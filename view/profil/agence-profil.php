<!DOCTYPE html>
<html>
<head>
	<title>Espace Agence</title>
	<?php require_once '../templates/css.php';
		  require_once '../templates/link.php';
		  require_once '../../model/agence.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?= $cssLink ?>/profil/agence-profil.css">
	<script type="text/javascript" src="<?= $jsLink ?>/profil/agence-profil-header.js"></script>
</head>
<body>

	<?php require_once '../templates/nav.php'; ?>
	<div class="my-container m-4 min-vh-100">
		<?php
          if(isset($_SESSION["flash"]["danger"])){
        ?>
            <div class="row">
        		<div class="col-md-3 me-2"></div>
              <div class="col-md-8 pt-2">
                <div class="alert alert-danger">
                  <?= $_SESSION["flash"]["danger"]; ?>
                </div>
             </div>
            </div>
        <?php

          }else if(isset($_SESSION["flash"]["success"])){
        ?>
        	<div class="row">
        		<div class="col-md-3 me-2"></div>
              <div class="col-md-8 pt-2">
                <div class="alert alert-success">
                  <?= $_SESSION["flash"]["success"]; ?>
                </div>
             </div>
            </div>
        <?php
          }
          if(isset($_SESSION["flash"]))
          	unset($_SESSION["flash"]);
        ?>
		<div class="row" id="profilContainer">
			<div class="col-md-3 me-2 mt-2 profil-menu p-0" id="profilMenu">
				<!--<img height="200" class="w-100" />-->
					<ul class="list-group">
					  <a id="informations">
					  	<li class="list-group-item">
					  		<div class="w-25">
					  			<i class="fas fa-info fa-2x ms-2 menuIcon"></i>
					  		</div>
					  		<div class="ms-4 pt-1">
					  			Informations
					  		</div>
					  	</li>
					  </a>
					  <a  id="voitures">
					  	<li class="list-group-item">
					  		<div class="w-25">
					  			<i class="fas fa-car fa-2x menuIcon"></i>
					  		</div>
					  		<div class="ms-4 pt-1">
					  			Voitures
					  		</div>
					  		<p class="center-badge-d-flex mb-0">
					  			<span class="badge rounded-pill bg-primary ms-4" id="countVoitures"></span>
					  		</p>
					  	</li>
					  </a>
					  <a id="clients">
					  	<li class="list-group-item">
					  		<div class="w-25">
					  			<i class="fas fa-users fa-2x menuIcon"></i>
					  		</div>
					  		<div class="ms-4 pt-1">
					  			Clients
					  		</div>
					  		<p class="center-badge-d-flex mb-0">
					  			<span class="badge rounded-pill bg-primary ms-4" id="countClients"></span>
					  		</p>
					  	</li>
					  </a>
					  <a id="locations">
					  	<li class="list-group-item">
					  		<div class="w-25">
					  			<i class="fas fa-road fa-2x menuIcon"></i>
					  		</div>
					  		<div class="ms-4 pt-1">
					  			Locations
					  		</div>
					  		<p class="center-badge-d-flex mb-0">
					  			<span class="badge rounded-pill bg-primary ms-4" id="countLocations"></span>
					  		</p>
					  	</li>
					  </a>
					</ul>
			</div>
			<div class="col-md-8 pt-2 mt-2 bg-white pb-2" id="profilContent">
			
			</div>
		</div>
	</div>
		<!-- Modal -->
	<div class="modal fade" id="editProfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content w-120">
	      <div class="modal-header" style="border-bottom: 0;">
	        <h5 class="modal-title" id="exampleModalLabel">Editer Mes données</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form class="shadow p-4  bg-white" method="post" id="frmEditProfil" action="<?= $controllerLink ?>/profilController.php?action=editAgence">
          <div class="form-group p-2">
            <label for="nomAgence">Nom </label>
            <input name="nomAgence" value="<?= $_SESSION["currentAgence"]->getNom(); ?>" type="text" class="form-control" id="nomAgence" placeholder="Entrer le nom de votre agence">
          </div>
          <div class="form-group p-2">
            <label for="emailAgence">Adresse E-mail</label>
            <input name="emailAgence" value="<?= $_SESSION["currentAgence"]->getEmail(); ?>" type="email" class="form-control" id="emailAgence" aria-describedby="emailHelp" placeholder="Entrer l'E-mail de votre agence">
          </div>
          <div class="form-group p-2">
            <label for="dateOuverture">Date d'ouverture</label>
            <input name="dateOuverture" value="<?= $_SESSION["currentAgence"]->getDate(); ?>" type="date" class="form-control" id="dateOuverture">
          </div>
          <div class="row p-2">
            <div class="col-md-6">
              <div class="form-check m-0 p-0">
                 <label for="nomDirecteur">Nom Directeur</label>
            	 <input name="nomDirecteur" value="<?= $_SESSION["currentAgence"]->getNomDirecteur(); ?>" type="text" class="form-control" id="nomDirecteur" placeholder="Entrer le nom du directeur">
              </div>
            </div>
            <div class="col-md-6" >
              <label class="form-check-label" for="villeAgence">Ville</label>
              <input name="villeAgence" value="<?= $_SESSION["currentAgence"]->getVille(); ?>" type="text" class="form-control" id="villeAgence" placeholder="Entrer la ville de votre agence">
            </div>
          </div>
          <div class="form-group p-2">
            <label for="telAgence">Téléphone </label>
            <input name="telAgence" value="<?= $_SESSION["currentAgence"]->getTel(); ?>" pattern="[0-9\-\(\)\/\+\s]{8,18}" type="text" class="form-control" id="telAgence" placeholder="Entrer le téléphone de l'agence">
          </div>
          <div class="form-group p-2">
            <label class="form-check-label" for="adresseAgence">Adresse</label>
            <textarea name="adresseAgence" class="form-control" id="adresseAgence" rows="2" placeholder=" Entrer l'adresse de votre agence"><?= $_SESSION["currentAgence"]->getAdresse(); ?></textarea>
          </div>
      </form>
	      </div>
	      <div  class="modal-footer" style="border-top: 0;">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
	        <button type="submit" form="frmEditProfil" class="btn btn-primary">Sauvegarder</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="deleteCarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        Voulez-vous supprimé cette voiture de votre Agence ?
	      </div>
	      <div class="modal-footer">
	        <a href="#" class="btn btn-secondary" id="confirmModalNoCar" data-bs-dismiss="modal">Non</a>
  			<a href="#" class="btn btn-primary" id="confirmModalYesCar">Oui</a>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="deleteLocationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        Voulez-vous supprimé cette Location de votre Agence ?
	      </div>
	      <div class="modal-footer">
	        <a href="#" class="btn btn-secondary" id="confirmModalNoLocation" data-bs-dismiss="modal">Non</a>
  			<a href="#" class="btn btn-primary" id="confirmModalYesLocation">Oui</a>
	      </div>
	    </div>
	  </div>
	</div>

	

	<?php require_once '../templates/footer.php'; ?>
	<?php require_once '../templates/js.php'; ?>
	<script type="text/javascript" src="<?= $jsLink ?>/profil/agence-profil-footer.js"></script>	

</body>
</html>