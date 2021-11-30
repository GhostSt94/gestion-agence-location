<?php

	require_once 'voiture.php';

	/**
	 * 
	 */
	class ImageVoiture
	{
		
		private $src,$voiture,$estPrincipal;

		function __construct($src,Voiture $voiture,$estPrincipal)
		{
			$this->src = $src;
			$this->voiture = $voiture;
			$this->estPrincipal = $estPrincipal;
		}

		public function getSrc()
		{
			return $this->src;
		}

		public function setSrc($src)
		{
			$this->src = $src;
		}

		public function getEstPrincipal()
		{
			return $this->estPrincipal;
		}

		public function setEstPrincipal($estPrincipal)
		{
			$this->estPrincipal = $estPrincipal;
		}

		public function getVoiture()
		{
			return $this->voiture;
		}

		public function setVoiture(Voiture $voiture)
		{
			$this->voiture = $voiture;
		}
	}