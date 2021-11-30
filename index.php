<!DOCTYPE html>
<html>
<head>
	<title>Accueil</title>
	<?php 
		require_once 'view/templates/css.php';
		require_once 'view/templates/link.php'; 
	?>
	<link rel="stylesheet" type="text/css" href="<?= $cssLink ?>/accueil.css">
</head>
<body>
<div id="A">
	<?php require_once 'view/templates/nav.php';  ?>

	<div class="min-vh-100">	
		<div class="row p-5 mt-5 me-0">
		    <div class="col-md-8 rounded bg-light p-3">
		        <h2>Trouvez votre voiture avec un prix idéale</h2>
		        <form action="view/voiture/nos-voiture.php" class="p-3" method="get">
		            <div class="row py-3">
		                <div class="col">
		                    <label for="prixMin" class="form-label">Prix Minimum ( DH / Jour )</label>
		                    <input type="number" min="0" value="0" class="form-control" id="prixMin" name="prixMin">
		                </div>
		                <div class="col">
		                    <label for="prixMax" class="form-label">Prix Maximum ( DH / Jour )</label>
		                    <input type="number" min="0" value="0" class="form-control" id="prixMax" name="prixMax">
		                    <p id="errorPrixMax" class="text-danger mt-2 mb-0"></p>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-md-2 offset-md-10">
		                    <input type="submit" class="btn btn-primary" value="Chercher" id="searchByPrice">
		                </div>
		            </div>
		        </form>
		    </div>
		</div>
	</div>
	<div class="row rounded bg-light p-4 mt-5">
		<div class="col-md-6 text-center ">
			<h3 class="p-3">Location Voiture</h3>
			<p class="p-3" style="text-align: justify;">
				Vous souhaitez louer une voiture ? Découvrez le grand assortiment de modèles et de marques de location automobile. Une petite voiture maniable pour la ville, un modèle écologique, un spacieux minibus ou la voiture de sport de vos rêves ? Chez nous, vous trouverez assurément la voiture que vous cherchez. Réservez en ligne rapidement et facilement et prenez la route sans soucis. Vous avez encore des questions ? N'hésitez pas à nous <a href="#frmContact">contacter</a> , nous nous ferons un plaisir de vous aider.
			</p>
		</div>
		<div class="col-md-6 text-center p-5" style="opacity: 0.8;">
			<img  src="static/images/appImages/logo.png" width="200px" height="150px" alt="...">
		</div>
	</div>
	<div class="row  justify-content-evenly p-1 mt-3">
		<div class="col rounded bg-light text-center p-3 m-2">
			<i class="far fa-calendar-check fa-3x my-3"></i>
			<h4>Gérer votre réservation en ligne</h4>
		</div>
		<div class="col rounded bg-light text-center p-3 m-2">
			<i class="fas fa-align-center fa-3x my-3"></i>
			<h4>Toutes les offres sur la même plateforme</h4>
		</div>
		<div class="col rounded bg-light text-center p-3 m-2">
			<i class="fas fa-search-plus fa-3x my-3"></i>
			<h4>Votre recherche sur mesure</h4>
		</div>
		
	</div>
	<div id="test"></div>

	
	<?php require_once 'view/templates/footer.php'; ?>
</div>
	<?php require_once 'view/templates/js.php'; ?>
	<script type="text/javascript" src="<?= $jsLink ?>/accueil.js"></script>
</body>
</html>