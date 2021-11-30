<?php

	require_once '../dao/utilisateurDao.php';
	require_once '../dao/voitureDao.php';
	require_once '../dao/locationDao.php';
	require_once '../dao/imageDao.php';
	require_once '../model/agence.php';
	require_once '../model/location.php';
	require_once '../model/client.php';

	session_start();
	$action = $_GET["action"];

	$utilisateurDao = new UtilisateurDao();
	$voitureDao = new VoitureDao();
	$imageDao = new ImageDao();
	$locationDao = new LocationDao();

	if(isset($action)){
		switch ($action) {
			case 'informationsAgence':
				$html = "";
				if(isset($_SESSION["currentAgence"])){
					$result = $utilisateurDao->findById($_SESSION["currentAgence"]->getId());
					
					$html .= '<div class="container">
								<a data-bs-toggle="modal" data-bs-target="#editProfil" title="Modifier" type="button" id="editProdil" class="me-4 mt-2"><i class="fas fa-user-edit fa-lg"></i></a>
							  <div class="row p-2">
								<div class="col-md-4">Nom :</div>
								<div class="col-md-8">'.$result[0]["nom"].'</div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">Adresse :</div>
								<div class="col-md-8">'.$result[0]["adresse"].'</div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">Ville :</div>
								<div class="col-md-8">'.$result[0]["ville"].'</div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">Date Ouverture :</div>
								<div class="col-md-8">'.$result[0]["date"].'</div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">Nom du Directeur :</div>
								<div class="col-md-8">'.$result[0]["nomDirecteur"].'</div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">Téléphone :</div>
								<div class="col-md-8">'.$result[0]["tel"].'</div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">E-mail :</div>
								<div class="col-md-8">'.$result[0]["email"].'</div>
							  </div>
							  </div>';
				}

				echo json_encode($html);
				
				break;

			case 'editAgence':

				if(isset($_SESSION["currentAgence"])){
					$id = $_SESSION["currentAgence"]->getId();
					$nom = $_POST["nomAgence"];
					$adresse = $_POST["adresseAgence"];
					$ville = $_POST["villeAgence"];
					$date = $_POST["dateOuverture"];
					$email = $_POST["emailAgence"];
					$tel = $_POST["telAgence"];
					$nomDirecteur = $_POST["nomDirecteur"];

					if($utilisateurDao->findByEmail($email) && $_SESSION["currentAgence"]->getEmail() != $email){
						$_SESSION["flash"]["danger"] = "Cet E-mail existe déjà .";
						header("location: ../view/profil/agence-profil.php");
						exit();
					}

					if(isset($nom,$adresse,$ville,$date,$email,$tel,$nomDirecteur) && !empty($nom) && !empty($tel) && !empty($adresse) && !empty($ville) && !empty($date) && !empty($email)  && !empty($nomDirecteur)){
						$agence = new Agence("Agence",$nom,$adresse,$ville,$date,$email,"",$tel,$nomDirecteur);
						$agence->setId($id);
						$_SESSION["currentAgence"] = $agence;
						if($utilisateurDao->editUser($id,$agence,null)){
							$_SESSION["flash"]["success"] = "Données Modifié avec success .";
							header("location: ../view/profil/agence-profil.php");
							exit();
						}else{
							$_SESSION["flash"]["danger"] = "Une erreur est survenue pendant la modification .";
							header("location: ../view/profil/agence-profil.php");
							exit();
						}
						
					}else{
						$_SESSION["flash"]["danger"] = "Veuillez entrer tous les champs .";
						header("location: ../view/profil/agence-profil.php");
						exit();
						
					}
				

				}

				break;

			

			case 'voituresAgence':
				$html = "";

				if(isset($_SESSION["currentAgence"])){

					$html .= "<table id='voituresTable' class='table table-stripped text-center'><tr><th>Matricule</th><th>Marque</th><th>Carburant</th><th>Prix</th><th>Statut</th><th><a id='ajouterVoiture' class='carActions' title='Ajouter une nouvelle Voiture'><i class='fas fa-plus'></i></a></th><th></th></tr>";
					$a = 0;
					foreach ($voitureDao->findAllVoitureByAgence($_SESSION["currentAgence"]) as $row) {
						$a++;
						$html .= "<tr><input type='hidden' value='".$row["id"]."'/><td>".$row["matricule"]."</td><td>".$row["marque"]."</td><td>".$row["carburant"]."</td><td>".$row["prixJournalier"]." DH</td>";

						if($row["estLouer"] == 1){

							$html .= "<td>Disponible</td>";
						}else{
							$html .= '<td>Réservé</td>';
						}
						$html .= "<td >
									<a title='Modifier' class='editerVoiture carActions' onclick='editerVoiture(".$row["id"].")'><i class='fas fa-edit'></i></a>
									<a title='Supprimer' class='deleteVoiture carActions confirmModalLink' onclick='showModal(".$a.",event,".$row["id"].")'><i class='fas fa-trash-alt'></i></a>
									<a data-bs-toggle='tooltip' data-bs-placement='bottom' title='Détails' href='../voiture/voiture-details.php?id=".$row["id"]."&fromProfil=1'><i class='fas fa-info-circle'></i></a>";
						
						$html .= "</td>";

						if($row["estLouer"] == 0){
							$html .= '<td><div class="form-check form-switch p-0"><input onchange="setDisponible('.$row["id"].',this)" class="form-check-input ms-1" type="checkbox" id="flexSwitchCheckChecked" title="Rendre la Voiture Disponible ."></div></td>';
						}else{
							$html .= '<td><div class="form-check form-switch p-0"><input class="form-check-input ms-1" type="checkbox" id="flexSwitchCheckChecked" title="Cette Voiture est Disponible ." checked disabled></div></td>';
						}

						$html .= "</tr>";					
					}

					$html .= "</table>";
				}

				echo json_encode($html);
				
				break;

			case 'editVoiture':
				$html = "";


				if(isset($_SESSION["currentAgence"])){

					$result = $voitureDao->findById($_GET["id"]);

					$html .= "<div class='container'>
								<form method='post' enctype='multipart/form-data' action=''>
									<div class='alert alert-danger' style='display:none;' id='msgError'>
                  						Veuillez entrer tous les champs .
               						</div>
									<div class='form-group mt-2'>
										<label for='matricule'>Matricule</label>
										<input class='form-control' type='text' name='matricule' id='matricule' value='".$result[0]["matricule"]."'/>
									</div>
									<div class='form-group mt-3'>
										<label for='marque'>Marque</label>
										<input class='form-control' type='text' name='marque' id='marque' value='".$result[0]["marque"]."'/>
									</div>
									<div class='form-group mt-3'>
										<label for='model'>Modele</label>
										<input class='form-control' type='text' name='model' id='model' value='".$result[0]["model"]."'/>
									</div>
									<div class='row  jc-sb'>
									<div class='form-group mt-3 col-md-5'>
										<label for='couleur'>Couleur</label>
										<input class='form-control' type='text' name='couleur' id='couleur' value='".$result[0]["couleur"]."'/>
									</div>
									<div class='form-group mt-3 col-md-5'>
										<label for='carburant'>Carburant</label>
										<select class='form-control' name='carburant' id='carburant'>";

									if($result[0]["carburant"] == "Essence"){
										$html .= "<option value='Essence' selected>Essence</option>
												  <option value='Gasoil'>Gasoil</option>";
									}else{
										$html .= "<option value='Essence'>Essence</option>
												  <option value='Gasoil' selected>Gasoil</option>";
									}
									
					$html .= "	</select>
									</div>
									</div>
									<div class='form-group mt-3'>
										<label for='prixJournalier'>Prix Journalier</label>
										<input class='form-control' type='number' name='prixJournalier' id='prixJournalier' value='".$result[0]["prixJournalier"]."'/>
									</div>
									<div class='form-group mt-3'>
										<label for='nbrChevaux'>Nombre Chevaux</label>
										<input class='form-control' type='number' name='nbrChevaux' id='nbrChevaux' value='".$result[0]["nbrChevaux"]."'/>
									</div>";
									
 												if($voitureDao->getImagesCount($_GET["id"])["nbrImages"] < 4){
													$html .= "<div class='form-group mt-3'>
																<label for='images' class='form-label'>Images</label>
																<input accept='image/*' class='form-control' type='file' onchange='onChangeFileInput(this,".$result[0]["id"].")' name='images[]' id='images' multiple>
																<p class='text-danger' id='fileCountError'></p>
															  </div>";
												}
  										 
								$html .= "	<input type='button' value='Sauvegarder' class='btn btn-primary mb-3 mt-3' id='btnEditVoiture' onclick='submitEditVoiture(this,event,".$result[0]["id"].")'/>
								</form>
							  </div>";
				}

				echo json_encode($html);
				
				break;

			case 'getImagesCount':

				$result = $voitureDao->getImagesCount($_GET["id"]);

				echo json_encode($result["nbrImages"]);

				break;

			case 'submitEdit':
				
				require_once '../view/templates/link.php';

				$id = $_GET["id"];
				$matricule = $_GET["matricule"];
				$marque = $_GET["marque"];
				$model = $_GET["model"];
				$couleur = $_GET["couleur"];
				$carburant = $_GET["carburant"];
				$prixJ = $_GET["prixJournalier"];
				$nbrChevaux = $_GET["nbrChevaux"];
				
				//$images = $_GET["images"];

				
				if(isset($matricule,$marque,$model,$couleur,$carburant,$prixJ,$nbrChevaux,$_SESSION["currentAgence"]) && !empty($matricule) && !empty($marque) && !empty($model) && !empty($couleur) && !empty($prixJ) && !empty($nbrChevaux)){
					$voiture = new Voiture($matricule,$marque,$model,$couleur,$carburant,$prixJ,$nbrChevaux,"",$_SESSION["currentAgence"]);
					$voiture->setId($id);
					if($voitureDao->edit($id,$voiture)){
						for ($i=0; $i < count($_FILES['images']['name']); $i++) { 

							$imageName = $_FILES['images']['name'][$i];
							$imageTemp =$_FILES['images']['tmp_name'][$i];
							$filename = date("Y-m-d-H-i-s")." ".basename($imageName);
							$target= $targetUploadImageLink."/".$filename;
							
							if(is_uploaded_file($imageTemp)){

								if(move_uploaded_file($imageTemp,$target)){
									$image = new ImageVoiture($filename,$voiture,0);
								    $imageDao->save($image);
								}
							}
						}
						$_SESSION["flash"]["success"] = "Votre voiture a été modifié avec success .";
					}else{
						$_SESSION["flash"]["danger"] = "Une erreur est survenue .";
					}
				}

				break;

			case 'deleteVoiture':

				$idVoiture = $_GET["id"];

				if($voitureDao->delete($idVoiture)){
					echo json_encode("success");
				}else{
					echo json_encode("erreur");
				}

				break;

			case 'ajouterVoiture':
					$html = "";
	
	
					if(isset($_SESSION["currentAgence"])){
	
						$html .= "<div class='container'>
									<form method='post' enctype='multipart/form-data' action=''>
										<div class='alert alert-danger' style='display:none;' id='msgError'>
											  Veuillez entrer tous les champs .
										   </div>
										<div class='form-group mt-2'>
											<label for='matricule'>Matricule</label>
											<input class='form-control' type='text' name='matricule' id='matricule' />
										</div>
										<div class='form-group mt-3'>
											<label for='marque'>Marque</label>
											<input class='form-control' type='text' name='marque' id='marque' />
										</div>
										<div class='form-group mt-3'>
											<label for='model'>Modele</label>
											<input class='form-control' type='text' name='model' id='model' />
										</div>
										<div class='row jc-sb'>
										<div class='form-group mt-3 col-md-5'>
											<label for='couleur'>Couleur</label>
											<input class='form-control' type='text' name='couleur' id='couleur'/>
										</div>
										<div class='form-group mt-3 col-md-5'>
											<label for='carburant'>Carburant</label>
											<select class='form-control' name='carburant' id='carburant'>
												<option value='Essence' selected>Essence</option>
									 		 	<option value='Gasoil'>Gasoil</option>
									 		</select>
										</div>
										</div>
										<div class='form-group mt-3'>
											<label for='prixJournalier'>Prix Journalier</label>
											<input class='form-control' type='number' name='prixJournalier' id='prixJournalier' />
										</div>
										<div class='form-group mt-3'>
											<label for='nbrChevaux'>Nombre Chevaux</label>
											<input class='form-control' type='number' name='nbrChevaux' id='nbrChevaux' />
										</div>
										<div class='form-group mt-3'>
											 <label for='images' class='form-label'>Images</label>
											   <input accept='image/*' class='form-control' type='file' name='images[]' id='images' multiple>
											   <p class='text-danger' id='fileCountError'></p>
										</div>
										<input type='button' value='Sauvegarder' class='btn btn-primary mb-3 mt-3' id='btnAjouterVoiture' i-a='".$_SESSION["currentAgence"]->getId()."' />
									</form>
								  </div>";
	
							
					}
	
				echo json_encode($html);
					
				break;	

			case 'submitAjout':

				require_once '../view/templates/link.php';

				$matricule = $_GET["matricule"];
				$marque = $_GET["marque"];
				$model = $_GET["model"];
				$couleur = $_GET["couleur"];
				$carburant = $_GET["carburant"];
				$prixJ = $_GET["prixJournalier"];
				$nbrChevaux = $_GET["nbrChevaux"];
				
				if(isset($matricule,$marque,$model,$couleur,$carburant,$prixJ,$nbrChevaux,$_SESSION["currentAgence"]) && !empty($matricule) && !empty($marque) && !empty($model) && !empty($couleur) && !empty($prixJ) && !empty($nbrChevaux)){

					$voiture = new Voiture($matricule,$marque,$model,$couleur,$carburant,$prixJ,$nbrChevaux,"",$_SESSION["currentAgence"]);

					
					if($voitureDao->save($voiture)){
						//$i = 0;
						$image = null;
						$idVoiture = $voitureDao->getLastInsertID();
						$voiture->setId($idVoiture);
						for ($i=0; $i < count($_FILES['images']['name']); $i++) { 

							$imageName = $_FILES['images']['name'][$i];
							$imageTemp =$_FILES['images']['tmp_name'][$i];
							$filename = date("Y-m-d-H-i-s")." ".basename($imageName);
							$target= $targetUploadImageLink."/".$filename;
							
							if(is_uploaded_file($imageTemp)){
								if(move_uploaded_file($imageTemp,$target)){
									if($i == 0){
										$image = new ImageVoiture($filename,$voiture,1);
									}else{
										$image = new ImageVoiture($filename,$voiture,0);
									}
								    $imageDao->save($image);
								}
							}
						}					
						
						$_SESSION["flash"]["success"] = "Voiture Ajouté avec success .";
					}else{
						$_SESSION["flash"]["danger"] = "Une erreur est survenue .";
					}
				}

				break;

			case 'setDisponible':

				$idVoiture = $_GET["id"];

				$voitureDao->setLouer($idVoiture,1);

				break;

			case 'clientsAgence':

				$html = "";

				if(isset($_SESSION["currentAgence"])){

					$html .= "<table id='clientsTable' class='table table-stripped text-center'><tr><th>CIN</th><th>Nom Complet</th><th>Adresse</th><th>Ville</th><th>Téléphone</th><th>Nombres Locations</th></tr>";
					$a = 0;
					foreach ($utilisateurDao->getClientsByAgence($_SESSION["currentAgence"]->getId()) as $row) {
						$a++;
						$html .= "<tr><input type='hidden' value='".$row["id"]."'/><td>".$row["cin"]."</td><td>".$row["nom"]."</td><td>".$row["adresse"]."</td><td>".$row["ville"]." </td><td>".$row["tel"]."</td><td>".$utilisateurDao->getLocationsCount($_SESSION["currentAgence"]->getId(),$row["cin"])["nbrLocations"]."</td>";


						$html .= "</tr>";					
					}

					$html .= "</table>";
				}

				echo json_encode($html);					

				break;

			case 'locationsAgence':

				$html = "";

				if(isset($_SESSION["currentAgence"])){

					$html .= "<table id='locationsTable' class='table table-stripped text-center'><tr><th>CIN</th><th>Matricule</th><th>Date Début</th><th>Date Fin</th><th>Prix Total</th><th>Statut</th><th>Localisation</th><th></th></tr>";
					$a = 0;
					$agence = null;
					foreach ($locationDao->getLocationsByAgence($_SESSION["currentAgence"]->getId()) as $row){
						$a++;
						$location = new Location(new Client(),"",$row["dateDebut"],$row["duree"],"");
						$html .= "<tr><input type='hidden' value='".$row["id"]."'/><td>".$row["cin"]."</td><td>".$row["matricule"]."</td><td>".$row["dateDebut"]."</td><td>".$location->getDateFin()."</td><td>".$locationDao->getLocationPrice($row["id"])["prixTotal"]." DH</td>";
						if($row["statut"] == "en cours"){
							$html .= '<td>En cours</td>';
						}else if($row["statut"] == "valide"){
							$html .= '<td>Validé</td>';
						}else if($row["statut"] == "annuler"){
							$html .= '<td>Annulé</td>';
						}else if($row["statut"] == "terminer"){
							$html .= '<td>Terminé</td>';
						}

						$html .= "<td><a class='carActions' onclick='localisation(".$row["id"].",event)'><i class='fas fa-map-marker-alt'></i></a></td>";
						if($row["statut"] == "en cours"){
							$html .= '<td><div class="form-check form-switch p-0"><input class="form-check-input ms-1" type="checkbox" title="Valider la Location ." onchange="validerLocation('.$row["id"].',this)"></div></td>';
						}else if($row["statut"] == "valide"){
							$html .= '<td><div class="form-check form-switch p-0"><input class="form-check-input ms-1" type="checkbox"  title="Cette location est déjà validé ." checked disabled></div></td>';
						}else{
							$html .= "<td><a title='Supprimer' class='carActions confirmModalLink' onclick='showLocationModal(".$a.",event,".$row["id"].")'><i class='fas fa-trash-alt'></i></a></td>";
						}

						$html .= "</tr>";				
					}

					$html .= "</table>";
				}

				echo json_encode($html);


				break;

			case 'setValiderLocation':
				$idLocation = $_GET["id"];
				$idVoiture = $locationDao->findVoitureByLocation($idLocation)["idVoiture"];

				$voitureDao->setLouer($idVoiture,0);
				$locationDao->setValider($idLocation);

				break;

			case 'informationsClient':


				$html = "";
				if(isset($_SESSION["currentClient"])){

					$result = $utilisateurDao->findById($_SESSION["currentClient"]->getId());
					$client = new Client("","","","",$result[0]["date"],"","","","");
					$age = $client->getAge();
					$html .= '<div class="container">
								<a data-bs-toggle="modal" data-bs-target="#editProfil" type="button" id="editProdil" class="me-4 mt-2"><i class="fas fa-user-edit fa-lg"></i></a>
							   <div class="row p-2">
								<div class="col-md-4">CIN :</div>
								<div class="col-md-8">'.$result[0]["cin"].'</div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">Nom :</div>
								<div class="col-md-8">'.$result[0]["nom"].'</div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">Adresse :</div>
								<div class="col-md-8">'.$result[0]["adresse"].'</div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">Ville :</div>
								<div class="col-md-8">'.$result[0]["ville"].'</div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">Date Naissance :</div>
								<div class="col-md-8">'.$result[0]["date"].'&nbsp;&nbsp;&nbsp;&nbsp;<b>('.$age.' ans)</b></div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">Téléphone :</div>
								<div class="col-md-8">'.$result[0]["tel"].'</div>
							  </div>
							  <div class="row p-2">
								<div class="col-md-4">E-mail :</div>
								<div class="col-md-8">'.$result[0]["email"].'</div>
							  </div>
							  </div>';
				}

				echo json_encode($html);

				break;

			case 'editClient':

				if(isset($_SESSION["currentClient"])){
					$id = $_SESSION["currentClient"]->getId();
					$nom = $_POST["nomClient"];
					$adresse = $_POST["adresseClient"];
					$ville = $_POST["villeClient"];
					$date = $_POST["dateNaissance"];
					$email = $_POST["emailClient"];
					$tel = $_POST["telClient"];
					$cin = $_POST["cin"];

					if($utilisateurDao->findByEmail($email) && $_SESSION["currentClient"]->getEmail() != $email){
						$_SESSION["flash"]["danger"] = "Cet E-mail existe déjà .";
						header("location: ../view/profil/client-profil.php");
						exit();
					}

					if($utilisateurDao->findByCin($cin) && $_SESSION["currentClient"]->getCin() != $cin){
						$_SESSION["flash"]["danger"] = "Ce CIN existe déjà .";
						header("location: ../view/profil/client-profil.php");
						exit();
					}

					if(isset($nom,$adresse,$ville,$date,$email,$tel,$cin) && !empty($nom) && !empty($tel) && !empty($adresse) && !empty($ville) && !empty($date) && !empty($email)  && !empty($cin)){
						$client = new Client("Client",$nom,$adresse,$ville,$date,$email,"",$tel,$cin);
						$client->setId($id);
						$_SESSION["currentClient"] = $client;
						if($utilisateurDao->editUser($id,null,$client)){
							$_SESSION["flash"]["success"] = "Données Modifié avec success .";
							header("location: ../view/profil/client-profil.php");
						}else{
							$_SESSION["flash"]["danger"] = "Une erreur est survenue pendant la modification .";
							header("location: ../view/profil/client-profil.php");
						}
						
					}else{
						$_SESSION["flash"]["danger"] = "Veuillez entrer tous les champs .";
						header("location: ../view/profil/client-profil.php");
						
					}
				

				}

				break;

			case 'locationsClient':

				$html = "";

				if(isset($_SESSION["currentClient"])){

					$html .= "<table id='locationsTable' class='table table-stripped text-center'><tr><th>Matricule</th><th>Date Début</th><th>Date Fin</th><th>Prix Total</th><th>Statut</th><th>Nom Agence</th><th></th></tr>";
					$a = 0;
					$client = null;
					foreach ($locationDao->getLocationsByClient($_SESSION["currentClient"]->getId()) as $row) {
						$a++;
						$location = new Location(new Client(),"",$row["dateDebut"],$row["duree"],"");
						$html .= "<tr><input type='hidden' value='".$row["id"]."'/><td>".$row["matricule"]."</td><td>".$row["dateDebut"]."</td><td>".$location->getDateFin()."</td><td>".$locationDao->getLocationPrice($row["id"])["prixTotal"]." DH</td>";
						if($row["statut"] == "en cours"){
							$html .= '<td>En cours</td>';
						}else if($row["statut"] == "valide"){
							$html .= '<td>Validé</td>';
						}else if($row["statut"] == "terminer"){
							$html .= '<td>Terminé</td>';
						}

						$html .= "<td>".$row["nom"]."</td>";
						$html .= "<td><a title='Annuler' class='carActions confirmModalLink' onclick='showModal(".$a.",event,".$row["id"].")'><i class='fas fa-trash-alt'></i></a></td>";
						$html .= "</tr>";
					}

					$html .= "</table>";
				}

				echo json_encode($html);

				break;

			case 'setAnnulerLocation':

				$idLocation = $_GET["id"];

				if($locationDao->setAnnuler($idLocation)){
					echo json_encode("success");
				}else{
					echo json_encode("erreur");
				}

				break;

			case 'deleteLocation':

				$idLocation = $_GET["id"];

				if($locationDao->delete($idLocation)){
					echo json_encode("success");
				}else{
					echo json_encode("erreur");
				}

				break;

			case 'getCountsAgenceProfil':

				$countVoitures = count($voitureDao->findAllVoitureByAgence($_SESSION["currentAgence"]));
				$countClients = count($utilisateurDao->getClientsByAgence($_SESSION["currentAgence"]->getId()));
				$countLocations = count($locationDao->getLocationsByAgence($_SESSION["currentAgence"]->getId()));

				echo json_encode([$countVoitures,$countClients,$countLocations]);

				break;

			case 'getCountsClientProfil':

				$countLocations = count($locationDao->getLocationsByClient($_SESSION["currentClient"]->getId()));

				echo json_encode([$countLocations]);

				break;

			case 'getLocalisation':
				
				$html = "";
				$idLocation = $_GET["id"];

				$x = rand(31, 33);
				$y = rand(-7, -5);
				
				$location = new Location(new Client(),null,"","",$x.",".$y);
				$locationDao->editLocalisation($idLocation,$location);
				$location = $locationDao->findById($idLocation);

				if($location){
					$html = '<script>
								let map;
								function initMap() {
									const uluru = { lat: '.$x.', lng: '.$y.' };
									const map = new google.maps.Map(document.getElementById("map"), {
									  center: uluru,
									  zoom: 8
									});

									 const marker = new google.maps.Marker({
								      position: uluru,
								   	  map: map
								    });
								}
							</script>
							<div id="map" class="w-100 h-100 img-fluid"></div>
							';

					$html .= '<script
						      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVF_veOHZjUwV8-02lc4RpM0uwuxPpKks&region=MA&callback=initMap"
						      async
						    ></script>';
				}

				echo json_encode($html);
				break;
		}
	}