<?php

	/**
	 * 
	 */
	class LocationDao
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

		public function findAll(){
			$stmt = $this->dbh->prepare("select * from location  order by dateCreation desc");

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function findAllValideLocation(){
			$stmt = $this->dbh->prepare("select * from location where statut = 'valide' order by dateCreation desc");

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function findById($id){
			$stmt = $this->dbh->prepare("select * from location where id = ?");

			$stmt->bindValue(1,$id);

			$stmt->execute();

			$result = $stmt->fetch();

			return $result;
		}	

		public function getLocationByVoitureAndStatus($idVoiture,$statut)
		{
			$stmt = $this->dbh->prepare("select * from location where idVoiture = ? and statut = ?");

			$stmt->bindValue(1,$idVoiture);
			$stmt->bindValue(2,$statut);

			$stmt->execute();

			$result = $stmt->fetch();
			/*if ($result) {
				return true;
			}else{
				return false;
			}*/
			return $result;
		}

		public function findVoitureByLocation($idLocation)
		{
			$stmt = $this->dbh->prepare("select idVoiture from location where id = ?");

			$stmt->bindValue(1,$idLocation);

			$stmt->execute();

			$result = $stmt->fetch();

			return $result;
		}

		public function findAllByUser(Utilisateur $user){
			$stmt = $this->dbh->prepare("select * from location where idUser = ?");

			$stmt->bindValue(1,$user->getId());

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function findAllByVoiture(Voiture $Voiture){
			$stmt = $this->dbh->prepare("select * from location where idVoiture = ?");

			$stmt->bindValue(1,$voiture->getId());

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function save(Location $location){
			$stmt = $this->dbh->prepare("insert into location (idUser,idVoiture,dateDebut,duree,localisation) values (?,?,?,?,?)");

			$stmt->bindValue(1,$location->getUser()->getId());
			$stmt->bindValue(2,$location->getVoiture());
			$stmt->bindValue(3,$location->getDateDebut());
			$stmt->bindValue(4,$location->getDuree());
			$stmt->bindValue(5,$location->getLocalisation());

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function edit($id,Location $location){
			$stmt = $this->dbh->prepare("update location set idUser = ? , idVoiture = ? , dateDebut = ? , duree = ? , localisation = ? where id = ?");

			$stmt->bindValue(1,$location->getUser()->getId());
			$stmt->bindValue(2,$location->getVoiture()->getId());
			$stmt->bindValue(3,$location->getDateDebut());
			$stmt->bindValue(4,$location->getDuree());
			$stmt->bindValue(5,$location->getLocalisation());
			$stmt->bindValue(6,$id);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function editLocalisation($id,Location $location){
			$stmt = $this->dbh->prepare("update location set localisation = ? where id = ?");

			$stmt->bindValue(1,$location->getLocalisation());
			$stmt->bindValue(2,$id);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function setConfirmer($idLocation)
		{
			$stmt = $this->dbh->prepare("update location set statut = 'confirmé' where id = ?");

			$stmt->bindValue(1,$idLocation);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function delete($id){
			$stmt = $this->dbh->prepare("delete from location where id = ?");

			$stmt->bindValue(1,$id);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function getLocationsByAgence($idAgence)
		{
			$stmt = $this->dbh->prepare("select l.id,u.cin,v.matricule,l.dateDebut,l.duree,l.statut,l.localisation,v.id as 'idVoiture' from location l join voiture v on v.id=l.idVoiture join utilisateur u on u.id=l.idUser where u.role='Client' and v.idAgence= ? order by l.dateCreation desc");

			$stmt->bindValue(1,$idAgence);

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function getLocationsByClient($idClient)
		{
			$stmt = $this->dbh->prepare("select l.id,u.nom,v.matricule,l.dateDebut,l.duree,l.statut,v.id as 'idVoiture' from location l join voiture v on v.id=l.idVoiture join utilisateur u on u.id=v.idAgence where l.idUser = ? and l.statut in ('en cours','valide','terminer') order by l.dateCreation desc");

			$stmt->bindValue(1,$idClient);

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function getLocationPrice($idLocation)
		{
			$stmt = $this->dbh->prepare("select v.prixJournalier * l.duree as 'prixTotal' from location l join voiture v on v.id=l.idVoiture where l.id= ?");

			$stmt->bindValue(1,$idLocation);

			$stmt->execute();

			$result = $stmt->fetch();

			return $result;
		}

		public function setValider($idLocation)
		{
			$stmt = $this->dbh->prepare("update location set statut = 'valide' where id = ?");

			$stmt->bindValue(1,$idLocation);

			$stmt->execute();
		}

		public function setAnnuler($idLocation)
		{
			$stmt = $this->dbh->prepare("update location set statut = 'annuler' where id = ?");

			$stmt->bindValue(1,$idLocation);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function setTerminer($idLocation)
		{
			$stmt = $this->dbh->prepare("update location set statut = 'terminer' where id = ?");

			$stmt->bindValue(1,$idLocation);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function getLocationByUserAndVoiture($idVoiture,$idUser)
		{
			$stmt = $this->dbh->prepare("select * from location where idVoiture = ? and idUser = ? and statut = 'en cours'");

			$stmt->bindValue(1,$idVoiture);
			$stmt->bindValue(2,$idUser);

			$stmt->execute();

			$result = $stmt->fetch();

			return $result;
		}
	}