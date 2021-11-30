<?php

	require_once 'client.php';
	require_once 'voiture.php';

	/**
	 * 
	 */
	class Location
	{
		
		private $id,$user,$voiture,$dateDebut,$duree,$localisation,$dateFin;

		function __construct(Client $user,$voiture,$dateDebut,$duree,$localisation)
		{
			$this->user = $user;
			$this->voiture = $voiture;
			$this->dateDebut = $dateDebut;
			$this->duree = $duree;
			$this->localisation = $localisation;
		}

		public function getId()
		{
			return $this->id;
		}

		public function setId($id)
		{
			$this->id = $id;
		}

		public function getVoiture()
		{
			return $this->voiture;
		}

		public function setVoiture($voiture)
		{
			$this->voiture = $voiture;
		}

		public function getUser()
		{
			return $this->user;
		}

		public function setUser($user)
		{
			$this->user = $user;
		}

		public function getDateDebut()
		{
			return $this->dateDebut;
		}

		public function setDateDebut($dateDebut)
		{
			$this->dateDebut = $dateDebut;
		}

		public function getDuree()
		{
			return $this->duree;
		}

		public function setDuree($duree)
		{
			$this->duree = $duree;
		}

		public function getLocalisation()
		{
			return $this->localisation;
		}

		public function setLocalisation($localisation)
		{
			$this->localisation = $localisation;
		}

		public function getDateFin()
		{
			return date('Y-m-d', strtotime($this->dateDebut. ' + '.$this->duree.' days'));
		}
	}