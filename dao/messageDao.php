<?php
	
	require_once '../model/message.php';

	/**
	 * 
	 */
	class MessageDao
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
			$stmt = $this->dbh->prepare("select * from message  order by dateEnvoi desc");

			$stmt->execute();

			$result = $stmt->fetchAll();

			return $result;
		}

		public function save(Message $message){
			$stmt = $this->dbh->prepare("insert into message (email,contenu) values (?,?)");

			$stmt->bindValue(1,$message->getEmail());
			$stmt->bindValue(2,$message->getContenu());

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function delete($id){
			$stmt = $this->dbh->prepare("delete from message where id = ?");

			$stmt->bindValue(1,$id);

			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}
	}