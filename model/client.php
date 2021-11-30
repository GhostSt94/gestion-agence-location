<?php
	
	require_once 'utilisateur.php';

	/**
	 * 
	 */
	class Client extends Utilisateur
	{
		
		private $cin;


		function __construct($role="",$nom="",$adresse="",$ville="",$date="",$email="",$mdp="",$tel="",$cin="")
		{
			parent::__construct($role,$nom,$adresse,$ville,$date,$email,$mdp,$tel);
			$this->cin = $cin;
		}

		public function getCin()
		{
			return $this->cin;
		}

		public function setCin($cin)
		{
			$this->cin = $cin;
		}

		public function getAge()
		{
			$age = date('Y') - date('Y', strtotime($this->date)); 
	        if (date('md') < date('md', strtotime($this->date))) { 
	            return $age - 1; 
	        } 
	        return $age; 
		}
	}