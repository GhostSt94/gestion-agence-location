<?php

	require_once 'agence.php';

	/**
	 * 
	 */
	class Voiture
	{
		private $id,$matricule,$marque,$model,$couleur,$carburant,$prixJ,$nbrChevaux,$estLouer,$agence;
		
		function __construct($matricule ,$marque,$model,$couleur,$carburant,$prixJ,$nbrChevaux,$estLouer,Agence $agence)
		{
			$this->matricule = $matricule;
			$this->marque = $marque;
			$this->model = $model;
			$this->couleur = $couleur;
			$this->carburant = $carburant;
			$this->prixJ = $prixJ;
			$this->nbrChevaux = $nbrChevaux;
			$this->estLouer = $estLouer;
			$this->agence = $agence;
		}

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getMatricule(){
			return $this->matricule;
		}

		public function setMatricule($matricule){
			$this->matricule = $matricule;
		}

		public function getMarque(){
			return $this->marque;
		}

		public function setMarque($marque){
			$this->marque = $marque;
		}

		public function getModel(){
			return $this->model;
		}

		public function setModel($model){
			$this->model = $model;
		}

		public function getCouleur(){
			return $this->couleur;
		}

		public function setCouleur($couleur){
			$this->couleur = $couleur;
		}

		public function getCarburant(){
			return $this->carburant;
		}

		public function setCarburant($carburant){
			$this->carburant = $carburant;
		}

		public function getPrixJ(){
			return $this->prixJ;
		}

		public function setPrixJ($prixJ){
			$this->prixJ = $prixJ;
		}

		public function getNbrChevaux(){
			return $this->nbrChevaux;
		}

		public function setNbrChevaux($nbrChevaux){
			$this->nbrChevaux = $nbrChevaux;
		}

		public function getEstLouer(){
			return $this->estLouer;
		}

		public function setEstLouer($estLouer){
			$this->estLouer = $estLouer;
		}

		public function getAgence(){
			return $this->agence;
		}

		public function setAgence(Agence $agence){
			$this->agence = $agence;
		}
	}