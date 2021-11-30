<?php

	/**
	 * s
	 */
	class Message
	{
		private $id,$email,$contenu,$dateEnvoi;

		function __construct($email,$contenu)
		{
			$this->email = $email;
			$this->contenu = $contenu;
		}

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getContenu(){
			return $this->contenu;
		}

		public function setContenu($contenu){
			$this->contenu = $contenu;
		}

		public function getDateEnvoi(){
			return $this->dateEnvoi;
		}

		public function setDateEnvoi($dateEnvoi){
			$this->dateEnvoi = $dateEnvoi;
		}
		
	}