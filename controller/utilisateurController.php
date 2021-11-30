<?php
	
	require_once '../dao/utilisateurDao.php';
	require_once '../dao/messageDao.php';
	require_once '../model/client.php';
	require_once '../model/agence.php';
	require_once '../model/message.php';
	require_once '../model/administrateur.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../lib/PHPMailer/Exception.php';
	require '../lib/PHPMailer/PHPMailer.php';
	require '../lib/PHPMailer/SMTP.php';

	session_start();

	$action = $_GET["action"];
	$agencePerPage = 8;

	$utilisateurDao = new UtilisateurDao();
	$messageDao = new MessageDao();

	if(isset($action)){

		switch ($action) {
			case 'logIn':
				
				$email = $_POST["email"];
				$password = $_POST["password"];
				$result = $utilisateurDao->findUserByEmail($email);
				var_dump($result);
				if(!isset($email,$password) || empty($email) || empty($password)){
					$_SESSION["flash"]["danger"] = "Veuillez entrer votre E-mail et votre Mot de Passe .";
					header("location: ../view/login.php");
				}else{
					if($result && $result[0] == "checkAdminLogin"){
						if($result[1]){
							if($result[1]["mdpPlainText"] == $password){
								$admin = new Adminnistrateur($result["id"],$result["nom"],$result["email"],$result["mdpPlainText"]);
								if(isset($_POST["cbxRemenberMe"])){
									setcookie("user_email",$email,time() + (86400 * 8000), "/");
									setcookie("user_password",$password,time() + (86400 * 8000), "/");
									setcookie("user_role","Admin",time() + (86400 * 8000), "/");
								}
								$_SESSION["currentAdmin"] = $admin;
								unset($_SESSION["currentClient"]);
								unset($_SESSION["currentAgence"]);
								header("location: ../index.php");
								exit();
							}
						}
					}
					if($result && password_verify($password, $result["mdp"])){

						if($result["role"] == "Client"){
							$client = new Client("Client",$result["nom"],$result["adresse"],$result["ville"],$result["date"],$result["email"],$result["mdpPlainText"],$result["tel"],$result["cin"]);
							$client->setId($result["id"]);
							if(isset($_POST["cbxRemenberMe"])){
								setcookie("user_email",$email,time() + (86400 * 8000), "/");
								setcookie("user_password",$password,time() + (86400 * 8000), "/");
								setcookie("user_role","Client",time() + (86400 * 8000), "/");
							}
							$_SESSION["currentClient"] = $client;
							unset($_SESSION["currentAgence"]);
							unset($_SESSION["currentAdmin"]);
							header("location: ../index.php");
						}else if ($result["role"] == "Agence") {
							$agence = new Agence("Agence",$result["nom"],$result["adresse"],$result["ville"],$result["date"],$result["email"],$result["mdpPlainText"],$result["tel"],$result["nomDirecteur"]);
							$agence->setId($result["id"]);
							if(isset($_POST["cbxRemenberMe"])){
								setcookie("user_email",$email,time() + (86400 * 8000), "/");
								setcookie("user_password",$password,time() + (86400 * 8000), "/");
								setcookie("user_role","Agence",time() + (86400 * 8000), "/");
							}
							$_SESSION["currentAgence"] = $agence;
							unset($_SESSION["currentClient"]);
							unset($_SESSION["currentAdmin"]);
							header("location: ../index.php");
						}
						
					}else{
						$_SESSION["flash"]["danger"] = "E-mail ou Mot de Passe incorrecte .";
						header("location: ../view/login.php");
					}
				}
				

				break;
			
			case 'signUp':
				$checkError = 1;

				if(isset($_POST["ajouterClient"])){
					$nom = $_POST["nomClient"];
					$adresse = $_POST["adresseClient"];
					$ville = $_POST["villeClient"];
					$date = $_POST["dateNaissance"];
					$email = $_POST["emailClient"];
					$mdp = $_POST["mdpClient"];
					$mdpConfirm = $_POST["confirmMdpClient"];
					$tel = $_POST["telClient"];
					$cin = $_POST["cin"];

					if(isset($nom,$adresse,$ville,$date,$email,$mdp,$tel,$cin) && !empty($nom) && !empty($tel) && !empty($adresse) && !empty($ville) && !empty($date) && !empty($email) && !empty($mdp) && !empty($cin)){
						if($mdp !== $mdpConfirm){
							$_SESSION["flash"]["danger"] = "Le Mot de Passe et sa confirmation doivent être identique .";
							header("location: ../view/signUp.php");
							exit();
						}

						if($utilisateurDao->findByEmail($email)){
							$_SESSION["flash"]["danger"] = "Cet E-mail existe déjà .";
							header("location: ../view/signUp.php");
							exit();
						}

						if($utilisateurDao->findByCin($cin)){
							$_SESSION["flash"]["danger"] = "Ce CIN existe déjà .";
							header("location: ../view/signUp.php");
							exit();
						}
						$client = new Client("Client",$nom,$adresse,$ville,$date,$email,$mdp,$tel,$cin);
						if($client->getAge() < 18){
							$_SESSION["flash"]["danger"] = "Vous devez avoir au moins 18 ans pour avoir un compte .";
							header("location: ../view/signUp.php");
							exit();
						}
						$utilisateurDao->saveUser(null,$client);
						header("location: ../view/login.php");
					}else{
						$checkError = -1;
					}
				}

				if(isset($_POST["ajouterAgence"])){
					$nom = $_POST["nomAgence"];
					$adresse = $_POST["adresseAgence"];
					$ville = $_POST["villeAgence"];
					$date = $_POST["dateOuverture"];
					$email = $_POST["emailAgence"];
					$mdp = $_POST["mdpAgence"];
					$mdpConfirm = $_POST["confirmMdpAgence"];
					$tel = $_POST["telAgence"];
					$nomDirecteur = $_POST["nomDirecteur"];

					if(isset($nom,$adresse,$ville,$date,$email,$mdp,$tel,$nomDirecteur) && !empty($nom) && !empty($tel) && !empty($adresse) && !empty($ville) && !empty($date) && !empty($email) && !empty($mdp) && !empty($nomDirecteur)){
						if($mdp !== $mdpConfirm){
							$_SESSION["flash"]["danger"] = "Le Mot de Passe et sa confirmation doivent être identique .";
							header("location: ../view/signUp.php");
							exit();
						}

						if($utilisateurDao->findByEmail($email)){
							$_SESSION["flash"]["danger"] = "Cet E-mail existe déjà .";
							header("location: ../view/signUp.php");
							exit();
						}
						$agence = new Agence("Agence",$nom,$adresse,$ville,$date,$email,$mdp,$tel,$nomDirecteur);
						$utilisateurDao->saveUser($agence,null);
						header("location: ../view/login.php");
					}else{
						$checkError = -1;
					}
				}

				if($checkError === -1){
					$_SESSION["flash"]["danger"] = "Veuillez entre tous les champs .";
					header("location: ../view/signUp.php");
				}

				break;

			case 'findAllVille':
				$html = "<option selected>Sélectionner une ville</option>";
				foreach ($utilisateurDao->findAllVille() as $row) {
	               	$html .= "<option value='".$row["ville"]."'>".$row["ville"]."</option>";
	            }
	            echo json_encode($html);
				break;

			case 'findAllAgence':
				$currentPage  =$_GET["current"];
				$agencesCount = $utilisateurDao->getAgencesCount()["nbrAgences"];
				$pages = ceil($agencesCount / $agencePerPage);
				$premier = ($currentPage * $agencePerPage) - $agencePerPage;
				$html = '<i class="fas fa-spinner fa-spin fa-3x absolute-spinner"></i><div class="row">';
				$i = 0;

				foreach ($utilisateurDao->findAllByRole('Agence',$premier) as $row) {
					if($i % 2 == 0 && $i != 0){
						$html .= '</div>';
						$html .= '<div class="row">';
					}
	               	$html .= '<div class="card col-md-5 mt-3"><div class="card-body"><h3 class="card-title"><b>'.$row["nom"].'</b></h3><h6 class="card-subtitle mb-2 text-muted">'.$row["ville"].'</h6><p class="card-text">Adresse : '.$row["adresse"].'<br/>Téléphone : '.$row["tel"].'</p></div></div>';
	               	
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

			case 'searchAgence':
				$nom = "";
				$ville = "";
				if(isset($_GET["nom"])){
					$nom = $_GET["nom"];
				}

				if(isset($_GET["ville"])){
					$ville = $_GET["ville"];
				}		

				$currentPage  =$_GET["current"];
				$premier = ($currentPage * $agencePerPage) - $agencePerPage;
				$agencesCount = $utilisateurDao->findAllAgenceByVilleAndNom($ville,$nom,$premier)[1];
				$pages = ceil($agencesCount / $agencePerPage);

				$html = '<i class="fas fa-spinner fa-spin fa-3x absolute-spinner"></i><div class="row">';
				$i = 0;
				foreach ($utilisateurDao->findAllAgenceByVilleAndNom($ville,$nom,$premier)[0] as $row) {
					if($i % 2 == 0 && $i != 0){
						$html .= '</div>';
						$html .= '<div class="row">';
					}
	               	$html .= '<div class="card col-md-5 mt-3"><div class="card-body"><h3 class="card-title"><b>'.$row["nom"].'</b></h3><h6 class="card-subtitle mb-2 text-muted">'.$row["ville"].'</h6><p class="card-text">Adresse : '.$row["adresse"].'<br/>Téléphone : '.$row["tel"].'</p></div></div>';
	               	
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

			case 'logOut':
				session_destroy();
				setcookie("user_email","",time() - 10, "/");
				setcookie("user_password","",time() - 10, "/");
				setcookie("user_role","",time() - 10, "/");
				header("location: ../index.php");
				break;

			case 'checkSession':

				if(!isset($_SESSION["currentAgence"]) && !isset($_SESSION["currentClient"]) && !isset($_SESSION["currentAdmin"])){
					session_destroy();
					header('location: ../index.php');
				}

				break;

			case 'checkRemenberMe':

				if(isset($_COOKIE["user_email"],$_COOKIE["user_password"],$_COOKIE["user_role"])){
					if($result = $utilisateurDao->connectUser($_COOKIE["user_email"],$_COOKIE["user_password"])){
						if($result["role"] == "Client"){
							$client = new Client("Client",$result["nom"],$result["adresse"],$result["ville"],$result["date"],$result["email"],$result["mdp"],$result["tel"],$result["cin"]);
							$client->setId($result["id"]);
							$_SESSION["currentClient"] = $client;
							unset($_SESSION["currentAgence"]);
							unset($_SESSION["currentAdmin"]);
						}else if ($result["role"] == "Agence") {
							$agence = new Agence("Agence",$result["nom"],$result["adresse"],$result["ville"],$result["date"],$result["email"],$result["mdp"],$result["tel"],$result["nomDirecteur"]);
							$agence->setId($result["id"]);
							$_SESSION["currentAgence"] = $agence;
							unset($_SESSION["currentClient"]);
							unset($_SESSION["currentAdmin"]);
						}else if ($result["role"] == "Admin") {
							$admin = new Administrateur($result["id"],$result["nom"],$result["email"],$result["mdp"]);
							$_SESSION["currentAdmin"] = $admin;
							unset($_SESSION["currentClient"]);
							unset($_SESSION["currentAgence"]);
						}
					}
				}

				break;

			case 'resetPassword':
				$email = $_GET["email"];
				$role = $_GET["role"];

				if($role == "Agence"){
					$dateOuverture = $_POST["dateOuverture"];

					if(!isset($dateOuverture) || empty($dateOuverture)){
						$_SESSION["flash"]["danger"] = "Entrer une date d'ouverture d'abord .";
						header('location: ../view/resetPassword.php?e='.$email);
						exit();
					}else{
						$dateOuvertureAgence = $utilisateurDao->findUserByEmail($email)["date"];
						if($dateOuverture != $dateOuvertureAgence){
							$_SESSION["flash"]["danger"] = "La date d'ouverture est incorrecte .";
							header('location: ../view/resetPassword.php?e='.$email);
							exit();
						}	
					}
				}else if($role == "Client"){
					$dateNaissance = $_POST["dateNaissance"];

					if(!isset($dateNaissance) || empty($dateNaissance)){
						$_SESSION["flash"]["danger"] = "Entrer une date de naissance d'abord .";
						header('location: ../view/resetPassword.php?e='.$email);
						exit();
					}else{
						$dateNaissanceClient = $utilisateurDao->findUserByEmail($email)["date"];
						if($dateNaissance != $dateNaissanceClient){
							$_SESSION["flash"]["danger"] = "La date de naissance est incorrecte .";
							header('location: ../view/resetPassword.php?e='.$email);
							exit();
						}	
					}
				}

				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
				$mail->Host = 'smtp.gmail.com';            //Adresse IP ou DNS du serveur SMTP
				$mail->Port = '587';                          //Port TCP du serveur SMTP
				$mail->SMTPDebug = 2;  // debugging: 1 = errors and messages, 2 = messages only
			    $mail->SMTPAuth = true;  // authentication enabled
			    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
			    $mail->SMTPAutoTLS = false; 
				$mail->Username   =  'gestion.agence.location.voiture@gmail.com';   //Adresse email à utiliser
				$mail->Password   =  'gestionagence';         //Mot de passe de l'adresse email à utiliser

				$mail->Subject    =  'Changement de  votre mot de passe';
				$mail->From       =  'contact@LocationVoiture.ma';
				$mail->FromName   = 'Contact de LocationVoiture.ma';
				$mail->IsHTML(true);
				$mail->Body = "<div id='mail-container'>
									<p>Voici votre lien de modification de votre mot de passe : </p>
									<a href='http://localhost:81/Gestion Agence Location/view/resetPasswordForm.php?e=".$email."&fm=1'>Le lien</a>
							   </div>";

				$mail->AddAddress($email);

				if ($mail->send()) {
				    $mail->smtpClose();
					header('location: ../view/messageSuccess.php');

				}else{
					$_SESSION["flash"]["danger"] = "Une erreur interne est survenue veuillez réessayer plus tard .";
					header('location: ../view/resetPassword.php?e='.$email);
					
				}
				
				break;

			case 'resetPasswordConfirm':

				$email = $_GET["e"];
				$password = $_POST["password"];
				$passwordConfirm = $_POST["confirmPassword"];

				if(isset($email,$password,$passwordConfirm) && !empty($email) && !empty($passwordConfirm) && !empty($password)){
					if($password == $passwordConfirm){
						
						$id = $utilisateurDao->findUserByEmail($email)["id"];
						
						if($utilisateurDao->editUserPassword($id,$password)){
							$_SESSION["flash"]["success"] = "Mot de passe éditer avec success veuillez vous <a href='../view/login.php'>Connectez</a> pour vérifié .";
							header('location: ../view/resetPasswordForm.php?e='.$email.'&fm=1');
						}else{
							$_SESSION["flash"]["danger"] = "Une erreur interne est survenue veuillez réessayer plus tard .";
							header('location: ../view/resetPasswordForm.php?e='.$email.'&fm=1');
						}
					}else{
						$_SESSION["flash"]["danger"] = "Le mot de passe et sa confirmation doivent être identique .";
						header('location: ../view/resetPasswordForm.php?e='.$email.'&fm=1');
					}
				}else{
					$_SESSION["flash"]["danger"] = "Veuillez entrez le mot de passe et sa confirmation .";
					header('location: ../view/resetPasswordForm.php?e='.$email.'&fm=1');
				}

				break;

			case 'verifEmailExist':

				$email = $_GET["email"];
				$html = 1;

				if($email != ""){
					if(!$utilisateurDao->findByEmail($email)){
						$html = 0;
						
					}
				}

				echo json_encode($html);

				break;

			case 'checkRole':

				$email = $_GET["e"];
				$html = "";

				$role = $utilisateurDao->findUserByEmail($email)["role"];

				if($role == "Agence"){
					$html = '<form class="shadow bg-white p-2" method="post" action="../controller/utilisateurController.php?action=resetPassword&email='.$email.'&role=Agence">
          						<div class="form-group p-3" >
								  <label for="dateOuverture" class="pb-1">Date Ouverture</label>
	           			 		  <input name="dateOuverture" type="date" class="form-control" id="dateOuverture">
	           			 		  <p class="text-danger" id="errorDateOuverture"></p>
	           			 		</div>
	           			 		<div class="row p-4 pt-1">
					               <button type="submit" class="btn btn-primary btn-block" id="envoyerMail">Valider</button>
					            </div>
					          </form>';
				}else if($role == "Client"){
					$html = '<form class="shadow bg-white p-2" method="post" action="../controller/utilisateurController.php?action=resetPassword&email='.$email.'&role=Client">
          						<div class="form-group p-3" >
								  <label for="dateNaissance" class="pb-1">Date Naissance</label>
	           			 		  <input name="dateNaissance" type="date" class="form-control" id="dateNaissance">
	           			 		  <p class="text-danger" id="errorDateNaissance"></p>
	           			 		</div>
	           			 		<div class="row p-4 pt-1">
					               <button type="submit" class="btn btn-primary btn-block" id="envoyerMail">Valider</button>
					            </div>
					          </form>';
				}

				echo json_encode($html);

				break;

			case 'agenceAdmin':

				$html = "<table id='agencesTable' class='table table-stripped text-center'><tr><th>Nom</th><th>Nom Directeur</th><th>Date Ouverture</th><th>Adresse</th><th>Date Création du Compte</th><th></th></tr>";
				$a = 0;
				foreach ($utilisateurDao->findAllByRole('Agence',-1) as $row) {
					$a++;
					$html .= "<tr><input type='hidden' value='".$row["id"]."'/><td>".$row["nom"]."</td><td>".$row["nomDirecteur"]."</td><td>".$row["date"]."</td><td>".$row["adresse"]."</td><td>".$row["dateCreation"]."</td>";
					$html .= "<td><a title='Supprimer' class='carActions confirmModalLink' onclick='showModalDeleteAgence(".$a.",event,".$row["id"].")'><i class='fas fa-trash-alt'></i></a></td>";
					$html .= "</tr>";
				}

				$html .= "</table>";

				echo json_encode($html);

				break;

			case 'clientsAdmin':

				$html = "<table id='clientsTable' class='table table-stripped text-center'><tr><th>Nom Complet</th><th>CIN</th><th>Date Naissance</th><th>Adresse</th><th>Date Création du Compte</th><th></th></tr>";
				$a = 0;
				foreach ($utilisateurDao->findAllByRole('Client',-1) as $row) {
					$a++;
					$html .= "<tr><input type='hidden' value='".$row["id"]."'/><td>".$row["nom"]."</td><td>".$row["cin"]."</td><td>".$row["date"]."</td><td>".$row["adresse"]."</td><td>".$row["dateCreation"]."</td>";
					$html .= "<td><a title='Supprimer' class='carActions confirmModalLink' onclick='showModalDeleteClient(".$a.",event,".$row["id"].")'><i class='fas fa-trash-alt'></i></a></td>";
					$html .= "</tr>";
				}

				$html .= "</table>";

				echo json_encode($html);

				break;

			case 'messagesAgence':

				$html = "<table id='messagesTable' class='table table-stripped text-center'><tr><th>Date Envoi</th><th>E-mail</th><th>Message</th><th></th></tr>";
				$a = 0;
				foreach ($messageDao->findAll() as $row) {
					$a++;
					$html .= "<tr><input type='hidden' value='".$row["id"]."'/><td>".$row["dateEnvoi"]."</td><td>".$row["email"]."</td><td>".$row["contenu"]."</td>";
					$html .= "<td><a title='Supprimer' class='carActions confirmModalLink' onclick='showModalDeleteMessage(".$a.",event,".$row["id"].")'><i class='fas fa-trash-alt'></i></a></td>";
					$html .= "</tr>";
				}

				$html .= "</table>";

				echo json_encode($html);

				break;

			case 'getCounts':

				$countAgences = count($utilisateurDao->findAllByRole('Agence',-1));
				$countClients = count($utilisateurDao->findAllByRole('Client',-1));
				$countMessages = count($messageDao->findAll());

				echo json_encode([$countAgences,$countClients,$countMessages]);

				break;

			case 'deleteAgence':

				$idAgence = $_GET["id"];

				if($utilisateurDao->delete($idAgence)){
					echo json_encode("success");
				}else{
					echo json_encode("errorDateOuverture");
				}

				break;

			case 'deleteClient':

				$idClient = $_GET["id"];

				if($utilisateurDao->delete($idClient)){
					echo json_encode("success");
				}else{
					echo json_encode("erreur");
				}

				break;

			case 'deleteMessage':

				$idMessage = $_GET["id"];

				if($messageDao->delete($idMessage)){
					echo json_encode("success");
				}else{
					echo json_encode("erreur");
				}

				break;

			case 'sendMessage':

				$email = $_POST["emailMsg"];
				$message = $_POST["message"];
				$from = $_GET["from"];

				if(isset($email,$message,$from) && !empty($email) && !empty($message) && !empty($from)){
					$message = new Message($email,$message);
					if($messageDao->save($message)){
						$_SESSION["flash"]["success"] = "Message Envoyé avec success .";
						header('location: '.$from.'#frmContact');
					}else{
						$_SESSION["flash"]["danger"] = "Une erreur est survenue, réessayer plus tard .";
						header('location: '.$from.'#frmContact');
					}

					
				}else{
					$_SESSION["flash"]["danger"] = "Entrer votre E-mail et Message d'abord .";
					header('location: '.$from.'#frmContact');
				}

				break;

		}
	}