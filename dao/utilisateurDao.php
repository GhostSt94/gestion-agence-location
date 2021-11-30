<?php

	require_once '../model/utilisateur.php';
	require_once '../model/agence.php';
	require_once '../model/client.php';
	
	/**
	 * 
	 */
	class UtilisateurDao
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

		public function connectUser($email,$mdp)
		{
			$options = [
			  'cost' => 11
			];
			$password = password_hash($mdp, PASSWORD_BCRYPT, $options);
			
			if(isset($email,$password) && !empty($email) && !empty($password)){
				
				$stmt = $this->dbh->prepare("SELECT * FROM utilisateur WHERE email=? AND mdp=?");

				$stmt->bindValue(1,$email);
				$stmt->bindValue(2,$password, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result;
			}else{
				return false;
			}
		}

		public function getRole(Utilisateur $user)
		{
			return $user->getRole();
		}

		public function findById($id){
			$stmt = $this->dbh->prepare("select * from utilisateur where id = ?");

			$stmt->bindValue(1,$id);

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function saveUser($agence,$client)
		{
			$options = [
			  'cost' => 11
			];
			
			if($agence != null && $client == null){

				$stmt = $this->dbh->prepare("insert into utilisateur (role,nom,adresse,ville,date,nomDirecteur,mdp,mdpPlainText,email,tel,dateCreation) values (?,?,?,?,?,?,?,?,?,?,now())");

				$password = password_hash($agence->getMdp(), PASSWORD_BCRYPT, $options);

				$stmt->bindParam(1,$agence->getRole());
				$stmt->bindParam(2,$agence->getNom());
				$stmt->bindParam(3,$agence->getAdresse());
				$stmt->bindParam(4,$agence->getVille());
				$stmt->bindParam(5,$agence->getDate());
				$stmt->bindParam(6,$agence->getNomDirecteur());
				$stmt->bindParam(7,$password);
				$stmt->bindParam(8,$agence->getMdp());
				$stmt->bindParam(9,$agence->getEmail());
				$stmt->bindParam(10,$agence->getTel());

				if($stmt->execute()){
					return true;
				}else{
					return false;
				}
			}

			if($agence == null && $client != null){

				$stmt = $this->dbh->prepare("insert into utilisateur (role,nom,adresse,ville,date,cin,mdp,mdpPlainText,email,tel,dateCreation) values (?,?,?,?,?,?,?,?,?,?,now())");

				$password = password_hash($client->getMdp(), PASSWORD_BCRYPT, $options);

				$stmt->bindParam(1,$client->getRole());
				$stmt->bindParam(2,$client->getNom());
				$stmt->bindParam(3,$client->getAdresse());
				$stmt->bindParam(4,$client->getVille());
				$stmt->bindParam(5,$client->getDate());
				$stmt->bindParam(6,$client->getCin());
				$stmt->bindParam(7,$password);
				$stmt->bindParam(8,$client->getMdp());
				$stmt->bindParam(9,$client->getEmail());
				$stmt->bindParam(10,$client->getTel());

				if($stmt->execute()){
					return true;
				}else{
					return false;
				}
			}
		}

		public function editUser($id,$agence,$client)
		{
			if($agence != null && $client == null){

				$stmt = $this->dbh->prepare("update utilisateur set nom = ?, adresse = ?, ville = ?, date = ?, nomDirecteur = ?, email = ?,tel = ? where role = 'Agence' and id = ?");

				$stmt->bindParam(1,$agence->getNom());
				$stmt->bindParam(2,$agence->getAdresse());
				$stmt->bindParam(3,$agence->getVille());
				$stmt->bindParam(4,$agence->getDate());
				$stmt->bindParam(5,$agence->getNomDirecteur());
				$stmt->bindParam(6,$agence->getEmail());
				$stmt->bindParam(7,$agence->getTel());
				$stmt->bindParam(8,$id);

				if($stmt->execute()){
					return true;
				}else{
					return false;
				}
			}

			if($agence == null && $client != null){

				$stmt = $this->dbh->prepare("update utilisateur set nom = ?, adresse = ?, ville = ?, date = ?, cin = ?, email = ?,tel = ? where role = 'Client' and id = ?");

				$stmt->bindParam(1,$client->getNom());
				$stmt->bindParam(2,$client->getAdresse());
				$stmt->bindParam(3,$client->getVille());
				$stmt->bindParam(4,$client->getDate());
				$stmt->bindParam(5,$client->getCin());
				$stmt->bindParam(6,$client->getEmail());
				$stmt->bindParam(7,$client->getTel());
				$stmt->bindParam(8,$id);

				if($stmt->execute()){
					return true;
				}else{
					return false;
				}
			}
		}

		public function delete($id)
		{
			$stmt = $this->dbh->prepare("delete from utilisateur where id = ?");

			$stmt->bindParam(1,$id);
				
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function editUserPassword($id,$mdp)
		{
			$options = [
			  'cost' => 11
			];
			
			$password = password_hash($mdp, PASSWORD_BCRYPT, $options);

			$stmt = $this->dbh->prepare("update utilisateur set mdp = ?, mdpPlainText = ? where id = ?");

			$stmt->bindParam(1,$password);
			$stmt->bindParam(2,$mdp);
			$stmt->bindParam(3,$id);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function findByEmail($email)
		{
			$stmt = $this->dbh->prepare("select * from utilisateur where email = ?");

			$stmt->bindValue(1,$email);

			$stmt->execute();

			$result = $stmt->fetch();

			if($result){
				return true;
			}else{
				return false;
			}
		}

		public function findUserByEmail($email)
		{
			$stmt = $this->dbh->prepare("select * from utilisateur where email = ?");

			$stmt->bindValue(1,$email);

			$stmt->execute();

			$result = $stmt->fetch();

			if($result){
				if($result["role"] == "Admin"){
					return ["checkAdminLogin",$result];
				}
			}

			return $result;
		}

		public function findByCin($cin)
		{
			$stmt = $this->dbh->prepare("select * from utilisateur where cin = ?");

			$stmt->bindValue(1,$cin);

			$stmt->execute();

			$result = $stmt->fetchAll();

			if($result){
				return true;
			}else{
				return false;
			}
		}

		public function findAllVille()
		{
			$stmt = $this->dbh->prepare("select distinct ville from utilisateur where role = 'Agence'");

			$stmt->execute();

			$result = $stmt->fetchAll();



			return $result;
		}

		public function findAllByRole($role,$premier)
		{
			if($premier != -1){
				$stmt = $this->dbh->prepare("select * from utilisateur where role = ? limit ?,8");

				$stmt->bindValue(1,$role);
				$stmt->bindValue(2,$premier, PDO::PARAM_INT);
			}else{
				$stmt = $this->dbh->prepare("select * from utilisateur where role = ?");

				$stmt->bindValue(1,$role);
			}
			

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function getAgencesCount()
		{
			$stmt = $this->dbh->prepare("select count(*) as 'nbrAgences' from utilisateur where role = 'Agence'");

			$stmt->execute();

			$result = $stmt->fetch();

			return $result;
		}

		public function findAllAgenceByVilleAndNom($ville,$nom,$premier)
		{
			$count = 0;
			if($ville !== "" && $nom !== ""){
				$stmt = $this->dbh->prepare("select * from utilisateur where role = 'Agence' and ville = ? and instr(nom,?) != 0 limit ?,8");
				$stmt->bindValue(1,$ville);
				$stmt->bindValue(2,$nom);
				$stmt->bindValue(3,$premier, PDO::PARAM_INT);

				$stmtCount = $this->dbh->prepare("select count(*) from utilisateur where role = 'Agence' and ville = ? and instr(nom,?) != 0");
				$stmtCount->bindValue(1,$ville);
				$stmtCount->bindValue(2,$nom);

				$stmtCount->execute();

				$count = $stmtCount->fetch()[0];
			}

			if($ville === "" && $nom !== ""){
				$stmt = $this->dbh->prepare("select * from utilisateur where role = 'Agence' and  instr(nom,?) != 0 limit ?,8");
				$stmt->bindValue(1,$nom);
				$stmt->bindValue(2,$premier, PDO::PARAM_INT);

				$stmtCount = $this->dbh->prepare("select count(*) from utilisateur where role = 'Agence' and  instr(nom,?) != 0");
				$stmtCount->bindValue(1,$nom);

				$stmtCount->execute();

				$count = $stmtCount->fetch()[0];
			}

			if($ville !== "" && $nom === ""){
				$stmt = $this->dbh->prepare("select * from utilisateur where role = 'Agence' and ville = ? limit ?,8");
				$stmt->bindValue(1,$ville);
				$stmt->bindValue(2,$premier, PDO::PARAM_INT);

				$stmtCount = $this->dbh->prepare("select count(*) from utilisateur where role = 'Agence' and ville = ?");
				$stmtCount->bindValue(1,$ville);

				$stmtCount->execute();

				$count = $stmtCount->fetch()[0];
			}

			$stmt->execute();

			$result = $stmt->fetchAll();

			return [$result , $count];
		}

		public function getClientsByAgence($idAgence)
		{
			$stmt = $this->dbh->prepare("select distinct * from utilisateur where role = 'Client' and id in (select idUser from location where idVoiture in (select id from voiture where idAgence = ?))");

			$stmt->bindValue(1,$idAgence);

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;	
		}

		public function getLocationsCount($idAgence,$cin)
		{
			$stmt = $this->dbh->prepare("select count(*) as 'nbrLocations' from location l join utilisateur u on u.id=l.idUser join voiture v on v.id=l.idVoiture where v.idAgence= ? and u.cin= ?");

			$stmt->bindValue(1,$idAgence);
			$stmt->bindValue(2,$cin);

			$stmt->execute();

			$result = $stmt->fetch();

			return $result;	
		}

	}