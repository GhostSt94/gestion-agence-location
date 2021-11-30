<?php
	
	require_once 'utilisateur.php';

	/**
	 * 
	 */
	class Agence extends Utilisateur
	{
		
		private $nomDirecteur;

		function __construct($role,$nom,$adresse,$ville,$date,$email,$mdp,$tel,$nomDirecteur)
		{
			parent::__construct($role,$nom,$adresse,$ville,$date,$email,$mdp,$tel);
			$this->nomDirecteur = $nomDirecteur;
		}

		public function getNomDirecteur()
		{
			return $this->nomDirecteur;
		}

		public function setNomDirecteur($nomDirecteur)
		{
			$this->nomDirecteur = $nomDirecteur;
		}
	}