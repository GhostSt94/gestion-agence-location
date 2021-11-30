<?php
	
	require_once '../dao/voitureDao.php';
	require_once '../dao/locationDao.php';
	require_once '../dao/imageDao.php';
	require_once '../model/voiture.php';
	require_once '../model/location.php';

	session_start();
	$voitureDao = new VoitureDao();
	$locationDao = new LocationDao();
	$imageDao = new ImageDao();
	$action = $_GET["action"];

	$carPerPage = 8;
	


	if(isset($action)){

		switch ($action) {

			case 'findAllMarque':
				$html = "<option value='0' selected>Sélectionner une marque</option>";
				foreach ($voitureDao->findAllMarque() as $row) {
	               	$html .= "<option value='".$row["marque"]."'>".$row["marque"]."</option>";
	            }
	            echo json_encode($html);
				break;

			case 'findAll':

				$html = '<i class="fas fa-spinner fa-spin fa-3x absolute-spinner"></i><div class="row">';
				$i = 0;
				$available="";
				$src = "";
				$currentPage  =$_GET["current"];
				if(isset($_GET["prixMin"],$_GET["prixMax"])){
					$prixMin = 0;
					$prixMax = 0;
					if($_GET["prixMin"] != 0){
						$prixMin = $_GET["prixMin"];
					}

					if($_GET["prixMax"] != 0){
						$prixMax = $_GET["prixMax"];
					}

					$carsCount = $voitureDao->findAllVoituresByPrix($prixMin,$prixMax,0)[1];
					$pages = ceil($carsCount / $carPerPage);
					$premier = ($currentPage * $carPerPage) - $carPerPage;
						
					foreach ($voitureDao->findAllVoituresByPrix($prixMin,$prixMax,$premier)[0] as $row) {
						if($i % 2 == 0 && $i != 0){
							$html .= '</div>';
							$html .= '<div class="row">';
						}
						if($row['estLouer']==0){
							$available="<h6 class='col text-danger'>(<b>Réservé</b>)</h6>";
						}else{
							$available="<h6 class='col text-success'>(<b>Disponible</b>)</h6>";
						}
						$result = $imageDao->findAllByVoitureAndPrincipal($row["id"],1);
						if($result){
							$src = "../../static/images/appImages/voitures/".$result[0]['src'];
						}else{
							$src= "";
						}
						$html .= "<div class='p-0 card col-md-5 mt-3'><img src='".$src."' class='card-img-top' height='180px'><div class='card-body '><div class='d-flex justify-content-between p-3'><div><h3 class='card-title'><b>".$row["model"]."</b></h3></div><div><h3><b>".$row["prixJournalier"]." Dh</b></h3></div></div><div class='row'><h6 class='card-subtitle mb-2 text-muted col-md-4'>".$row["marque"]."</h6>".$available."</div><p class='card-text'>Couleur : <b>".$row["couleur"]."</b><br/>Carburant : <b>".$row["carburant"]."</b><br>Nombre chevaux : <b>".$row["nbrChevaux"]."</b></p><form action='voiture-details.php' method='GET'><input type='hidden' name='id' value='".$row['id']."'><input class='btn btn-primary' type='submit' value='Détails'/></form></div></div>";	               	
		               	$i++;
		            }

		            $html .= '</div><div class="row">
								  <ul class="pagination mt-4" style="justify-content:center;">';
					for ($i=0; $i < $pages; $i++) {
						if($i == 0){
							$html .= '<li class="page-item activable-item active"><a class="page-link" href="" onclick="paginationSearchByPrice(event,'.$i.')" >'.($i + 1).'</a></li>';
						}else{
							$html .= '<li class="page-item activable-item"><a class="page-link" href="" onclick="paginationSearchByPrice(event,'.$i.')" >'.($i + 1).'</a></li>';
						}
						
					}			    
					$html .= '</ul></div>';
		            echo json_encode($html);
		            exit();
				}
				$carsCount = $voitureDao->getVoituresCount()["nbrVoitures"];
				$pages = ceil($carsCount / $carPerPage);
				$premier = ($currentPage * $carPerPage) - $carPerPage;
					
				foreach ($voitureDao->findAll($premier) as $row) {
					if($i % 2 == 0 && $i != 0){
						$html .= '</div>';
						$html .= '<div class="row">';
					}
					if($row['estLouer']==0){
						$available="<h6 class='col text-danger'>(<b>Réservé</b>)</h6>";
					}else{
						$available="<h6 class='col text-success'>(<b>Disponible</b>)</h6>";
					}
					$result = $imageDao->findAllByVoitureAndPrincipal($row["id"],1);
					if($result){
						$src = "../../static/images/appImages/voitures/".$result[0]['src'];
					}else{
						$src= "";
					}
					$html .= "<div class='p-0 card col-md-5 mt-3'><img src='".$src."' class='card-img-top' height='180px'><div class='card-body '><div class='d-flex justify-content-between p-3'><div><h3 class='card-title'><b>".$row["model"]."</b></h3></div><div><h3><b>".$row["prixJournalier"]." Dh</b></h3></div></div><div class='row'><h6 class='card-subtitle mb-2 text-muted col-md-4'>".$row["marque"]."</h6>".$available."</div><p class='card-text'>Couleur : <b>".$row["couleur"]."</b><br/>Carburant : <b>".$row["carburant"]."</b><br>Nombre chevaux : <b>".$row["nbrChevaux"]."</b></p><form action='voiture-details.php' method='GET'><input type='hidden' name='id' value='".$row['id']."'><input class='btn btn-primary' type='submit' value='Détails'/></form></div></div>";	               	
	               	$i++;
	            }

	            $html .= '</div><div class="row">
							  <ul class="pagination mt-4" style="justify-content:center;">';
				for ($i=0; $i < $pages; $i++) {
					if($i == 0){
						$html .= '<li class="page-item activable-item active"><a class="page-link" href="" onclick="pagination(event,'.$i.')" >'.($i + 1).'</a></li>';
					}else{
						$html .= '<li class="page-item activable-item"><a class="page-link" href="" onclick="pagination(event,'.$i.')" >'.($i + 1).'</a></li>';
					}
					
				}			    
				$html .= '</ul></div>';
	            echo json_encode($html);

			 	break;

			case 'searchVoiture':
				$marque = "";
				$model = "";
				$estLouer = $_GET["estlouer"];
				if(isset($_GET["marque"])){
					$marque = $_GET["marque"];
				}

				if(isset($_GET["model"])){
					$model = $_GET["model"];
				}
				
				$html = "<i class='fas fa-spinner fa-spin fa-3x absolute-spinner'></i><div class='row'>";
				$i = 0;
				$available="";
				$currentPage  =$_GET["current"];
				$premier = ($currentPage * $carPerPage) - $carPerPage;
				$carsCount = intval($voitureDao->search($marque,$model,$estLouer,$premier)[1]);
				$pages = ceil($carsCount / $carPerPage);
				
				foreach ($voitureDao->search($marque,$model,$estLouer,$premier)[0] as $row) {
					if($i % 2 == 0 && $i != 0){
						$html .= '</div>';
						$html .= '<div class="row">';
					}
					if($row['estLouer']==0){
						$available="<h6 class='col text-danger'>(<b>Réservé</b>)</h6>";
					}else{
						$available="<h6 class='col text-success'>(<b>Disponible</b>)</h6>";
					}
					$result = $imageDao->findAllByVoitureAndPrincipal($row["id"],1);
					if($result){
						$src = "../../static/images/appImages/voitures/".$result[0]['src'];
					}else{
						$src= "";
					}
					$html .= "<div class='p-0 card col-md-5 mt-3'><img src='".$src."' class='card-img-top' height='180px'><div class='card-body '><div class='d-flex justify-content-between p-3'><div><h3 class='card-title'><b>".$row["model"]."</b></h3></div><div><h3><b>".$row["prixJournalier"]." Dh</b></h3></div></div><div class='row'><h6 class='card-subtitle mb-2 text-muted col-md-4'>".$row["marque"]."</h6>".$available."</div><p class='card-text'>Couleur : <b>".$row["couleur"]."</b><br/>Carburant : <b>".$row["carburant"]."</b><br>Nombre chevaux : <b>".$row["nbrChevaux"]."</b></p><form action='voiture-details.php' method='GET'><input type='hidden' name='id' value='".$row['id']."'><input class='btn btn-primary' type='submit' value='Détails'/></form></div></div>";	               	
	               	$i++;
	            }

	            $html .= '</div><div class="row">
							  <ul class="pagination mt-4" style="justify-content:center;">';
				for ($i=0; $i < $pages; $i++) {
					if($i == 0){
						$html .= '<li class="page-item activable-item active"><a class="page-link" href="" onclick="paginationSearch(event,'.$i.')" >'.($i + 1).'</a></li>';
					}else{
						$html .= '<li class="page-item activable-item"><a class="page-link" href="" onclick="paginationSearch(event,'.$i.')" >'.($i + 1).'</a></li>';
					}
					
				}							    
				$html .= '</ul></div>';

	            echo json_encode($html);


				break;

			case 'details':
				$i=0;
				$html="<div class='row justify-content-center'><div class='col-6'><div id='carouselExampleInterval' class='carousel slide' data-bs-ride='carousel'>
				<div class='carousel-inner'>";
				$available="";
				if(isset($_GET["id"])){
					$id=$_GET["id"];
					$imagesCount = $voitureDao->getImagesCount($id)["nbrImages"];
					foreach($imageDao->findImagesByVoitureId($id) as $row) {
						if($i==0){$html .= "<div class='carousel-item active' >";}
						else{$html .= "<div class='carousel-item' >";}
						if(isset($_GET["fromProfil"]) && $_GET["fromProfil"] == 1){
							if($imagesCount == 1){
								$html .= "<a class='deleteImageLink mb-2' title='Il reste cette image seulement (pour la supprimer ajouter autres images dans la section profil)' disabled><i class='fas fa-trash-alt'></i></a>";
							}else{
								$html .= "<a class='deleteImageLink mb-2 carActions' onclick='deleteImage(".$row["id"].",event,\"".$row["src"]."\")' title='Supprimer cette image'><i class='fas fa-trash-alt'></i></a>";
							}
							
						}
						$html .="<img src='../../static/images/appImages/voitures/".$row['src']."' class='d-block' height='265' width='100%' alt='...'>
						</div>";
						$i++;
					}
					$html .= '<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</button>
						</div></div></div></div>';

						$html .="<div class='row justify-content-center mt-4 p-3'>";
					foreach ($voitureDao->findById($id) as $row) {
						$html .= "<div class='col-4'>";
						$html .= "<h1 class='text-dark'>".$row["marque"]." <b><i> ".$row["model"]."</i></b> </h1></div>";
						$html .= "<div class='col-5'>";
						if($row['estLouer']==0){
							$html .="<h6 class='alert alert-danger w-50 ms-5'><b>Réservé</b></h6></div>";
						}else{
							$html .="<h6 class='alert alert-success w-50 ms-5'><b>Disponible</b></h6></div>";
						}
						$html .="<table class='table'>";
						$html .="<tr><td>Matricule :</td><td><b>".$row["matricule"]."</b></td></tr>";
						$html .="<tr><td>Carburant :</td><td><b>".$row["carburant"]."</b></td></tr>";
						$html .="<tr><td>Couleur :</td><td><b>".$row["couleur"]."</b></td></tr>";
						$html .="<tr><td>Nombre de chevaux :</td><td><b>".$row["nbrChevaux"]."</b></td></tr>";
						$html .="<tr><td>Agence :</td><td><b>";
						foreach ($voitureDao->findAgenceById($row["idAgence"]) as $row2) {
							$html .= $row2["nom"];
						}
						$html .="</b></td></tr>";
						$html .="<tr><td></td><td><h4 class='text-prixJ'><b id='prixJ'>".$row["prixJournalier"]." </b><b>Dh / Jour</b></h4> </td></tr>";
						if(isset($_SESSION["currentClient"])){
							if ($locationDao->getLocationByVoitureAndStatus($id,'valide')) {
								$html .= '<tr><td></td><td><button type="button" id="louer" class="btn btn-primary w-50 float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop" disabled>
									  Réserver
									</button></td></tr>';
									//var_dump($locationDao->getLocationByVoitureAndStatus($id,'valide'));
							}else{
								$html .= '<tr><td></td><td><button type="button" id="louer" class="btn btn-primary w-50 float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
									  Réserver
									</button></td></tr>';
							}
							
							$html .= '<tr><td></td><td><p id="errorReserved" class="float-end"></p></td></tr>';
						}else{
							$html .= '<tr><td></td><td><a href="../login.php" class="btn btn-primary w-50 float-end">
									  Réserver
									</a></td></tr>';
						}
						$html .= "</table>";
					}
					$html .= "</div>";

				}else{
					$html="<h1>error</h1>";
				}
				echo json_encode($html);
					break;

				case 'checkReservation':
					$idUser = $_SESSION["currentClient"]->getId();
					$idVoiture = $_GET["idVoiture"];

					$result = $locationDao->getLocationByVoitureAndStatus($idVoiture,'valide');

					if($result){
						echo json_encode("true");
					}else{
						echo json_encode("false");
					}

					break;


				case 'louer':

					$duree = $_POST["duree"];
					$dateDebut = $_POST["dateDebut"];
					$voitureId = $_GET["id"];

					if(isset($_SESSION["currentClient"])){
						if(isset($duree,$dateDebut,$voitureId)){

							$location = new Location($_SESSION["currentClient"],$voitureId,$dateDebut,$duree,"");

							if ($locationDao->save($location)) {
								//$voitureDao->setLouer($voitureId,0);
								$_SESSION["flash"]["success"] = "Votre demande a été envoyer avec success, l'agence va vous contactez aprés la confirmation de votre demande .";
								header("location: ../view/voiture/nos-voiture.php");
							}else{
								$_SESSION["flash"]["danger"] = "Votre demande n'a pas été aboutie .";
								header("location: ../view/voiture/nos-voiture.php");
							}

						}
					}

					break;


				case 'checkLouer':

					foreach ($locationDao->findAllValideLocation() as $row) {
						$location = new Location(new Client(),$row["idVoiture"],$row["dateDebut"],$row["duree"],$row["localisation"]);
						$location->setId($row["id"]);
						if($location->getDateFin() <= date('Y-m-d')){
							$voitureDao->setLouer($location->getVoiture(),1);
							$locationDao->setTerminer($location->getId());
						}
					}

					break;

				case 'deleteImage':

					require_once '../view/templates/link.php';

					$id = $_GET["id"];
					$idVoiture = $_GET["idVoiture"];
					$src = $_GET["src"];

					if($imageDao->delete($id,$idVoiture)){
						unlink($targetUploadImageLink."/".$src);
						echo json_encode("true");
					}else{
						echo json_encode("false");
					}

					break;

				case 'checkIfLocationExists':

					$idVoiture = $_GET["id"];
					if(isset($_SESSION["currentClient"])){
						$idUser = $_SESSION["currentClient"]->getId();

						$result = $locationDao->getLocationByUserAndVoiture($idVoiture,$idUser);

						if($result){
							echo json_encode("true");
						}else{
							echo json_encode("false");	
						}
					}
					

					break;
		}

	}
	