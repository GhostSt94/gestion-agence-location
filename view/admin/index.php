<!DOCTYPE html>
<html>
<head>
	<title>Espace Administrateur</title>
	<?php require_once '../templates/css.php';
		  require_once '../templates/link.php';
	?>
	<link rel="stylesheet" type="text/css" href="<?= $cssLink ?>/profil/admin-profil.css">
	<script type="text/javascript" src="<?= $jsLink ?>/profil/admin-profil-header.js"></script>
</head>
<body>

	<?php require_once '../templates/nav.php'; ?>

	<div class="my-container m-4 min-vh-100">
		
		<div class="row" id="profilContainer">
			<div class="col-md-3 me-2 mt-2 profil-menu" id="profilMenu" style="padding: 0;">
				<ul class="list-group" style="border-radius: 0;">
					  <a id="agences">
					  	<li class="list-group-item">
					  		<div class="w-25">
					  			<i class="fas fa-building fa-2x ms-2 menuIcon"></i>
					  		</div>
					  		<div class="ms-4 pt-1">
					  			Agences
					  		</div>
					  		<p class="center-badge-d-flex mb-0">
					  			<span class="badge rounded-pill bg-primary ms-4" id="countAgences"></span>
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
					  <a id="messages">
					  	<li class="list-group-item">
					  		<div class="w-25">
					  			<i class="fas fa-envelope fa-2x menuIcon"></i>
					  		</div>
					  		<div class="ms-4 pt-1">
					  			Messages
					  		</div>
					  		<p class="center-badge-d-flex mb-0">
					  			<span class="badge rounded-pill bg-primary ms-4" id="countMessages"></span>
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
	<div class="modal fade" id="deleteAgenceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        Voulez-vous supprimé cette Agence ?
	      </div>
	      <div class="modal-footer">
	        <a href="#" class="btn btn-secondary" id="confirmModalNoAgence" data-bs-dismiss="modal">Non</a>
  			<a href="#" class="btn btn-primary" id="confirmModalYesAgence">Oui</a>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="deleteClientModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        Voulez-vous supprimé ce Client ?
	      </div>
	      <div class="modal-footer">
	        <a href="#" class="btn btn-secondary" id="confirmModalNoClient" data-bs-dismiss="modal">Non</a>
  			<a href="#" class="btn btn-primary" id="confirmModalYesClient">Oui</a>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="deleteMessageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        Voulez-vous supprimé ce Message?
	      </div>
	      <div class="modal-footer">
	        <a href="#" class="btn btn-secondary" id="confirmModalNoMessage" data-bs-dismiss="modal">Non</a>
  			<a href="#" class="btn btn-primary" id="confirmModalYesMessage">Oui</a>
	      </div>
	    </div>
	  </div>
	</div>

	<?php require_once '../templates/footer.php'; ?>
	<?php require_once '../templates/js.php'; ?>
	<script type="text/javascript" src="<?= $jsLink ?>/profil/admin-profil-footer.js"></script>
</body>
</html>