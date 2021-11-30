<?php

	/**
	 * 
	 */
	class Adminnistrateur
	{
		
		private $id,$nom,$email,$mdp;
		function __construct($id,$nom,$email,$mdp)
		{
			$this->id = $id;
			$this->nom = $nom;
			$this->email = $email;
			$this->mdp = $mdp;
		}

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getNom(){
			return $this->nom;
		}

		public function setNom($nom){
			$this->nom = $nom;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getMdp(){
			return $this->mdp;
		}

		public function setMdp($mdp){
			$this->mdp = $mdp;
		}
	}