<?php
	require_once 'link.php';
	session_start();
?>

	<nav class="navbar navbar-expand-lg navbar-light bg-light bg-white">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="/Gestion-Agence-Location">
	        <img src="<?= $imageLink ?>/logo.png" width="70" height="50">
	    </a>
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
	        <li class="nav-item">
	          <a class="nav-link <?php if($_SERVER['PHP_SELF'] == '/Gestion Agence Location/view/agence/nos-agence.php'){ echo 'active'; } ?>" aria-current="page" href="<?= $viewLink ?>/agence/nos-agence.php">Nos Agences</a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link <?php if($_SERVER['PHP_SELF'] == '/Gestion Agence Location/view/voiture/nos-voiture.php'){ echo 'active'; } ?>" href="<?= $viewLink ?>/voiture/nos-voiture.php">Nos Voitures</a>
	        </li>
	        <?php
	        	if(isset($_SESSION["currentAdmin"])){
	        ?>
	        <li class="nav-item">
	          <a class="nav-link <?php if($_SERVER['PHP_SELF'] == '/Gestion Agence Location/view/admin/index.php'){ echo 'active'; } ?>" href="<?= $viewLink ?>/admin/index.php">Espace Administrateur</a>
	        </li>
	        <?php
	        	}
	        ?>
	      </ul>
	      <div class="d-flex">
	      	<?php  
	        	if(isset($_SESSION["currentAgence"])){
	        ?>
	        <a  href="<?= $viewLink ?>/profil/agence-profil.php" data-bs-toggle="tooltip" data-bs-placement="bottom" type="button" title="Espace Agence" class="ms-3"><i class="far fa-user-circle fa-2x" style="color: #01366E;"></i></a>
	        <a data-bs-toggle="tooltip" data-bs-placement="bottom" type="button" title="Déconnection" href="<?= $controllerLink ?>/utilisateurController.php?action=logOut" class="ms-3"><i class="fas fa-sign-out-alt  fa-2x" style="color: #01366E;"></i></a>
	        <?php 
	        	}
	        ?>
	        <?php  
	        	if(isset($_SESSION["currentClient"])){
	        ?>
	        <a  href="<?= $viewLink ?>/profil/client-profil.php"  data-bs-toggle="tooltip" data-bs-placement="bottom" type="button" title="Espace Client" class="ms-3"><i class="far fa-user-circle fa-2x" style="color: #01366E;"></i></a>
	        <a data-bs-toggle="tooltip" data-bs-placement="bottom" type="button"  title="Déconnection" href="<?= $controllerLink ?>/utilisateurController.php?action=logOut" class="ms-3"><i class="fas fa-sign-out-alt  fa-2x" style="color: #01366E;"></i></a>
	        <?php 
	        	}
	        ?>
	        <?php  
	        	if(isset($_SESSION["currentAdmin"])){
	        ?>
	        <a  href="<?= $viewLink ?>/admin/index.php"  data-bs-toggle="tooltip" data-bs-placement="bottom" type="button" title="Espace Admin" class="ms-3"><i class="far fa-user-circle fa-2x" style="color: #01366E;"></i></a>
	        <a data-bs-toggle="tooltip" data-bs-placement="bottom" type="button"  title="Déconnection" href="<?= $controllerLink ?>/utilisateurController.php?action=logOut" class="ms-3"><i class="fas fa-sign-out-alt  fa-2x" style="color: #01366E;"></i></a>
	        <?php 
	        	}
	        ?>
	        <?php  
	        	if(!isset($_SESSION["currentClient"]) && !isset($_SESSION["currentAgence"]) && !isset($_SESSION["currentAdmin"])){
	        ?>
	        	<a href="<?= $viewLink ?>/login.php"  data-bs-toggle="tooltip" data-bs-placement="bottom" type="button" title="S'authentifier" class="ms-3"><i class="far fa-user-circle fa-2x" style="color: #01366E;"></i></a>
	        	<a type="button" title="Déconnection" class="ms-3 invisible"><i class="fas fa-sign-out-alt  fa-2x" style="color: #01366E;"></i></a>
	        <?php 
	        	}
	        ?>
	      </div>
	    </div>
	  </div>
	</nav>