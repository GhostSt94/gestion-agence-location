<!DOCTYPE html>
<html>
<head>
	<title>Nos Agences de Location</title>
	<?php require_once '../templates/css.php'; ?>
	<link rel="stylesheet" type="text/css" href="../../static/css/custom-bg.css">
</head>
<body>
	<?php require_once '../templates/nav.php'; ?>
	<div class="my-container min-vh-100">
		<h1 class="ms-4 p-3">Nos Agences</h1>
		<div class="row me-0">
			
			<div class="col-md-3 ms-4 p-2 bg-white-opacity h-25">

				<form >
			        <select class="form-select mb-2" aria-label="Default select example" id="ville" name="ville">
			        </select>
			        <input type="text" name="nomAgence" id="nomAgence" class="form-control mb-2" placeholder="Entrer un nom d'agence">
			        <button id="search" class="btn btn-primary">Chercher</button>
		      </form>
			</div>

			<div class="col-md-8 ms-2 p-2 bg-white-opacity" id="nos-agences">
				
			</div>
		</div>
	</div>

	<?php require_once '../templates/footer.php'; ?>

	<?php require_once '../templates/js.php'; ?>
	<script type="text/javascript" src="../../static/js/nos-agence.js"></script>
</body>
</html>