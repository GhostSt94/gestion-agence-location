<?php

	require_once '../model/voiture.php';
	require_once '../model/imageVoiture.php';

	/**
	 * 
	 */
	class ImageDao
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

		public function findAllByVoitureAndPrincipal($idVoiture,$estPrincipal)
		{
			$stmt = $this->dbh->prepare("select * from voiture_image where idVoiture = ? and estPrincipal = ?");

			$stmt->bindValue(1,$idVoiture);
			$stmt->bindValue(2,$estPrincipal);

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function findImagesByVoitureId($id){
			$stmt = $this->dbh->prepare("select * from voiture_image where idVoiture = ? order by estPrincipal desc");
			$stmt->bindValue(1,$id);
			$stmt->execute();
			$result = $stmt->fetchAll();
	
			return $result;	
		}

		public function findById($id)
		{
			$stmt = $this->dbh->prepare("select * from voiture_image where id = ?");

			$stmt->bindValue(1,$id);

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function save(ImageVoiture $image)
		{
			$stmt = $this->dbh->prepare("insert into voiture_image (src,idVoiture,estPrincipal) values (?,?,?)");

			$stmt->bindValue(1,$image->getSrc());
			$stmt->bindValue(2,$image->getVoiture()->getId());
			$stmt->bindValue(3,$image->getEstPrincipal());

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function edit($id,ImageVoiture $image)
		{
			$stmt = $this->dbh->prepare("update voiture_image set src = ? , idVoiture = ? where id = ?");

			$stmt->bindValue(1,$image->getSrc());
			$stmt->bindValue(2,$image->getVoiture()->getId());
			$stmt->bindValue(3,$id);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function delete($id,$idVoiture)
		{
			$stmt = $this->dbh->prepare("select * from voiture_image where id = ? and estPrincipal = 1");
			$stmt->bindValue(1,$id);
			$stmt->execute();
			$result = $stmt->fetch();

			if($result){
				$stmt = $this->dbh->prepare("update voiture_image set estPrincipal = 1 where idVoiture = ? limit 2");

				$stmt->bindValue(1,$idVoiture);

				if($stmt->execute()){
					$stmt = $this->dbh->prepare("delete from voiture_image where id = ?");

					$stmt->bindValue(1,$id);

					if($stmt->execute()){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}

				
			}else{
				$stmt = $this->dbh->prepare("delete from voiture_image where id = ?");

				$stmt->bindValue(1,$id);

				if($stmt->execute()){
					return true;
				}else{
					return false;
				}
			}

			
		}

	}