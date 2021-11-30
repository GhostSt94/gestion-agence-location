<?php
	
	require_once '../model/agence.php';
	require_once '../model/voiture.php';

	/**
	 * 
	 */
	class VoitureDao
	{
		
		private $dbh;
		
		public function __construct()
		{
			try {
			 $this->dbh = new PDO('mysql:host=localhost;dbname=db_gestion_agence_location_1', 'root', '');
			} catch (PDOException $e) {
			 print "Erreur !: " . $e->getMessage() . "<br/>";
			 die();
			}
		}


		public function getLastInsertID(){
			return $this->dbh->lastInsertId();
		}


		public function findAll($premier){
			$stmt = $this->dbh->prepare("select * from voiture order by dateCreation desc limit ?,8");
			$stmt->bindValue(1, $premier, PDO::PARAM_INT);
			$stmt->execute();

			$result = $stmt->fetchAll();
			return $result;
		}

		public function findById($id){
			$stmt = $this->dbh->prepare("select * from voiture where id = ?");

			$stmt->bindValue(1,$id);

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function findAllVoitureByAgence(Agence $agence){
			$stmt = $this->dbh->prepare("select * from voiture where idAgence = ?  order by dateCreation desc");

			$stmt->bindValue(1,$agence->getId());

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function findAllVoituresByPrix($prixMin,$prixMax,$premier)
		{
			$count = 0;
			$stmt = $this->dbh->prepare("select * from voiture where prixJournalier BETWEEN ? and ? order by dateCreation desc limit ?,8");

			$stmt->bindValue(1,$prixMin);
			$stmt->bindValue(2,$prixMax);
			$stmt->bindValue(3, $premier, PDO::PARAM_INT);

			$stmt->execute();

			$result = $stmt->fetchAll();

			$stmtCount = $this->dbh->prepare("select count(*) from voiture where prixJournalier BETWEEN ? and ?");

			$stmtCount->bindValue(1,$prixMin);
			$stmtCount->bindValue(2,$prixMax);

			$stmtCount->execute();

			$count = $stmtCount->fetch()[0];

			return [$result , $count];
		}

		public function save(Voiture $voiture){
			$stmt = $this->dbh->prepare("insert into voiture (matricule,marque,model,couleur,carburant,prixJournalier,nbrChevaux,idAgence) values (?,?,?,?,?,?,?,?)");

			$stmt->bindValue(1,$voiture->getMatricule());
			$stmt->bindValue(2,$voiture->getMarque());
			$stmt->bindValue(3,$voiture->getModel());
			$stmt->bindValue(4,$voiture->getCouleur());
			$stmt->bindValue(5,$voiture->getCarburant());
			$stmt->bindValue(6,$voiture->getPrixJ());
			$stmt->bindValue(7,$voiture->getNbrChevaux());
			$stmt->bindValue(8,$voiture->getAgence()->getId());

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function edit($id,Voiture $voiture){
			$stmt = $this->dbh->prepare("update voiture set matricule = ? , marque = ? , model = ? , couleur = ? , carburant = ? , prixJournalier = ? , nbrChevaux = ? where id = ?");

			$stmt->bindValue(1,$voiture->getMatricule());
			$stmt->bindValue(2,$voiture->getMarque());
			$stmt->bindValue(3,$voiture->getModel());
			$stmt->bindValue(4,$voiture->getCouleur());
			$stmt->bindValue(5,$voiture->getCarburant());
			$stmt->bindValue(6,$voiture->getPrixJ());
			$stmt->bindValue(7,$voiture->getNbrChevaux());
			$stmt->bindValue(8,$id);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function delete($id){
			$stmt = $this->dbh->prepare("delete from voiture where id = ?");

			$stmt->bindValue(1,$id);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function findAllMarque()
		{
			$stmt = $this->dbh->prepare("select distinct marque from voiture order by marque asc");

			$stmt->execute();

			$result = $stmt->fetchAll();



			return $result;
		}

		public function search($marque,$model,$estLouer,$premier)
		{
			$count = 0;
			if($marque !== "" && $model !== ""){
				if($estLouer == 0){
					$stmt = $this->dbh->prepare("select * from voiture where marque = ? and instr(model,?) != 0  order by dateCreation desc limit ?,8");
					$stmt->bindValue(1,$marque);
					$stmt->bindValue(2,$model);
					$stmt->bindValue(3,$premier, PDO::PARAM_INT);

					$stmtCount = $this->dbh->prepare("select count(*) as 'selectCount' from voiture where marque = ? and instr(model,?) != 0 ");
					$stmtCount->bindValue(1,$marque);
					$stmtCount->bindValue(2,$model);
					$stmtCount->execute();
					$count = $stmtCount->fetch()["selectCount"];
				}else{
					$stmt = $this->dbh->prepare("select * from voiture where marque = ? and instr(model,?) != 0 and estLouer = ? order by dateCreation desc limit ?,8 ");
					$stmt->bindValue(1,$marque);
					$stmt->bindValue(2,$model);
					$stmt->bindValue(3,$estLouer);
					$stmt->bindValue(4,$premier, PDO::PARAM_INT);

					$stmtCount = $this->dbh->prepare("select count(*) as 'selectCount' from voiture where marque = ? and instr(model,?) != 0 and estLouer = ?  ");
					$stmtCount->bindValue(1,$marque);
					$stmtCount->bindValue(2,$model);
					$stmtCount->bindValue(3,$estLouer);
					$stmtCount->execute();
					$count = $stmtCount->fetch()["selectCount"];
				}
			}

			if($marque === "" && $model !== ""){
				if($estLouer == 0){
					$stmt = $this->dbh->prepare("select * from voiture where instr(model,?) != 0  order by dateCreation desc limit ?,8");
					$stmt->bindValue(1,$model);
					$stmt->bindValue(2,$premier, PDO::PARAM_INT);

					$stmtCount = $this->dbh->prepare("select count(*) as 'selectCount' from voiture where instr(model,?) != 0 ");
					$stmtCount->bindValue(1,$model);
					$stmtCount->execute();
					$count = $stmtCount->fetch()["selectCount"];
				}else{
					$stmt = $this->dbh->prepare("select * from voiture where instr(model,?) != 0 and estLouer = ? order by dateCreation desc limit ?,8 ");
					$stmt->bindValue(1,$model);
					$stmt->bindValue(2,$estLouer);
					$stmt->bindValue(3,$premier, PDO::PARAM_INT);

					$stmtCount = $this->dbh->prepare("select count(*) as 'selectCount' from voiture where instr(model,?) != 0 and estLouer = ? ");
					$stmtCount->bindValue(1,$model);
					$stmtCount->bindValue(2,$estLouer);
					$stmtCount->execute();
					$count = $stmtCount->fetch()["selectCount"];
				}
			}

			if($marque !== "" && $model === ""){
				if($estLouer == 0){
					$stmt = $this->dbh->prepare("select * from voiture where marque = ?  order by dateCreation desc limit ?,8");
					$stmt->bindValue(1,$marque);
					$stmt->bindValue(2,$premier, PDO::PARAM_INT);

					$stmtCount = $this->dbh->prepare("select count(*) as 'selectCount' from voiture where marque = ?  ");
					$stmtCount->bindValue(1,$marque);
					$stmtCount->execute();
					$count = $stmtCount->fetch()["selectCount"];
				}else{
					$stmt = $this->dbh->prepare("select * from voiture where marque = ? and estLouer = ? order by dateCreation desc limit ?,8");
					$stmt->bindValue(1,$marque);
					$stmt->bindValue(2,$estLouer);
					$stmt->bindValue(3,$premier, PDO::PARAM_INT);

					$stmtCount = $this->dbh->prepare("select count(*) as 'selectCount' from voiture where marque = ? and estLouer = ? ");
					$stmtCount->bindValue(1,$marque);
					$stmtCount->bindValue(2,$estLouer);
					$stmtCount->execute();
					$count = $stmtCount->fetch()["selectCount"];
				}		
			}

			if($marque === "" && $model === ""){
				if($estLouer == 0){
					$stmt = $this->dbh->prepare("select * from voiture  order by dateCreation desc limit ?,8");
					$stmt->bindValue(1,$premier, PDO::PARAM_INT);

					$stmtCount = $this->dbh->prepare("select count(*) as 'selectCount' from voiture");
					$stmtCount->execute();
					$count = $stmtCount->fetch()["selectCount"];
				}else{
					$stmt = $this->dbh->prepare("select * from voiture where estLouer = ? order by dateCreation desc limit ?,8");
					$stmt->bindValue(1,$estLouer);
					$stmt->bindValue(2,$premier, PDO::PARAM_INT);

					$stmtCount = $this->dbh->prepare("select count(*) as 'selectCount' from voiture where estLouer = ? ");
					$stmtCount->bindValue(1,$estLouer);
					$stmtCount->execute();
					$count = $stmtCount->fetch()["selectCount"];

				}		
			}

			$stmt->execute();

			$result = $stmt->fetchAll();
			return [$result,$count];
		}

		

		public function findAgenceById($id){
			$stmt = $this->dbh->prepare("select * from utilisateur where id = ?");
				$stmt->bindValue(1,$id);
				$stmt->execute();

				$result = $stmt->fetchAll();
	
				return $result;	
		}

		public function setLouer($idVoiture,$estLouer)
		{
			$stmt = $this->dbh->prepare("update voiture set estLouer = ? where id = ?");

			$stmt->bindValue(1,$estLouer);
			$stmt->bindValue(2,$idVoiture);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function getImagesCount($idVoiture)
		{
			$stmt = $this->dbh->prepare("select count(id) as 'nbrImages' from voiture_image where idVoiture = ?");
			$stmt->bindValue(1,$idVoiture);
			$stmt->execute();
			$result = $stmt->fetch();
	
			return $result;	
		}

		public function getVoituresCount()
		{
			$stmt = $this->dbh->prepare("select count(id) as 'nbrVoitures' from voiture");
			$stmt->execute();
			$result = $stmt->fetch();
	
			return $result;	
		}
	}