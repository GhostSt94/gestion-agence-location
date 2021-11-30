<!DOCTYPE html>
<html>
<head>
	<title>Espace Client</title>
	<?php require_once '../templates/css.php';
		  require_once '../templates/link.php';
		  require_once '../../model/client.php'; ?>
	<link rel="stylesheet" type="text/css" href="<?= $cssLink ?>/profil/client-profil.css">
	<script type="text/javascript" src="<?= $jsLink ?>/profil/client-profil-header.js"></script>
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
			<div class="col-md-3 me-2 mt-2 profil-menu" id="profilMenu" style="padding: 0;">
				<ul class="list-group" style="border-radius: 0;">
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
			<div class="col-md-8 pt-2 mt-2 bg-white" id="profilContent">
			
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
	        <form class="shadow p-4  bg-white" method="post" id="frmEditProfil" action="<?= $controllerLink ?>/profilController.php?action=editClient">
          <div class="form-group p-2">
            <label for="nomClient">Nom Complet</label>
            <input name="nomClient" value="<?= $_SESSION["currentClient"]->getNom(); ?>" type="text" class="form-control" id="nomClient" placeholder="Entrer votre nom Complet">
          </div>
          <div class="form-group p-2">
            <label for="emailClient">E-mail</label>
            <input name="emailClient" value="<?= $_SESSION["currentClient"]->getEmail(); ?>" type="email" class="form-control" id="emailClient" aria-describedby="emailHelp" placeholder="Entrer votre l'E-mail">
          </div>
          <div class="form-group p-2">
            <label for="dateNaissance">Date Naissance</label>
            <input name="dateNaissance" value="<?= $_SESSION["currentClient"]->getDate(); ?>" type="date" class="form-control" id="dateNaissance">
          </div>
          <div class="row p-2">
            <div class="col-md-6">
              <div class="form-check m-0 p-0">
                 <label for="cin">CIN</label>
            	 <input name="cin" value="<?= $_SESSION["currentClient"]->getCin(); ?>" type="text" class="form-control" id="cin" placeholder="Entrer ">
              </div>
            </div>
            <div class="col-md-6" >
              <label class="form-check-label" for="villeClient">Ville</label>
              <input name="villeClient" value="<?= $_SESSION["currentClient"]->getVille(); ?>" type="text" class="form-control" id="villeClient" placeholder="Entrer votre ville de résidence">
            </div>
          </div>
          <div class="form-group p-2">
            <label for="telClient">Téléphone </label>
            <input name="telClient" value="<?= $_SESSION["currentClient"]->getTel(); ?>" pattern="[0-9\-\(\)\/\+\s]{8,18}" type="text" class="form-control" id="telClient" placeholder="Entrer votre téléphone">
          </div>
          <div class="form-group p-2">
            <label class="form-check-label" for="adresseClient">Adresse</label>
            <textarea name="adresseClient" class="form-control" id="adresseClient" rows="2" placeholder=" Entrer votre Adresse"><?= $_SESSION["currentClient"]->getAdresse(); ?></textarea>
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
	<div class="modal fade" id="annulerLocationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        Voulez-vous annulé cette Location ?
	      </div>
	      <div class="modal-footer">
	        <a href="#" class="btn btn-secondary" id="confirmModalNo" data-bs-dismiss="modal">Non</a>
  			<a href="#" class="btn btn-primary" id="confirmModalYes">Oui</a>
	      </div>
	    </div>
	  </div>
	</div>

	<?php require_once '../templates/footer.php'; ?>
	<?php require_once '../templates/js.php'; ?>
	<script type="text/javascript" src="<?= $jsLink ?>/profil/client-profil-footer.js"></script>
</body>
</html>