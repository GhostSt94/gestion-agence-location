<?php

	/**
	 * 
	 */
	class Utilisateur
	{
		protected $id,$role,$nom,$adresse,$ville,$date,$email,$mdp,$tel;

		function __construct($role,$nom,$adresse,$ville,$date,$email,$mdp,$tel)
		{
			$this->role = $role;
			$this->nom = $nom;
			$this->adresse = $adresse;
			$this->ville = $ville;
			$this->date = $date;
			$this->email = $email;
			$this->mdp = $mdp;
			$this->tel = $tel;
		}

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getRole(){
			return $this->role;
		}

		public function setRole($role){
			$this->role = $role;
		}

		public function getNom(){
			return $this->nom;
		}

		public function setNom($nom){
			$this->nom = $nom;
		}

		public function getAdresse(){
			return $this->adresse;
		}

		public function setAdresse($adresse){
			$this->adresse = $adresse;
		}

		public function getVille(){
			return $this->ville;
		}

		public function setVille($ville){
			$this->ville = $ville;
		}

		public function getDate(){
			return $this->date;
		}

		public function setDate($ville){
			$this->date = $date;
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

		public function getTel(){
			return $this->tel;
		}

		public function setTel($tel){
			$this->tel = $tel;
		}
	}