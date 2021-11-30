<!DOCTYPE html>
<html lang="en">

<head>
 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <?php 
    require_once 'templates/css.php'; 
    require_once 'templates/link.php';
  ?>
  <link rel="stylesheet" type="text/css" href="<?= $cssLink ?>/signUp.css">
</head>

<body>
  <a title="Accueil" href="/<?= $appName ?>"><i class="fas fa-home fa-2x"></i></a>
  <div class="container">
    <div class="text-center p-3">
      <img src="<?= $imageLink ?>/logo.png" class="rounded" width="130" height="105">
    </div>
      <?php
           session_start();
          if(isset($_SESSION["flash"]["danger"])){
        ?>
            <div class="row justify-content-md-center">
              <div class="col-md-7">
                <div class="alert alert-danger">
                  <?= $_SESSION["flash"]["danger"]; ?>
                </div>
             </div>
            </div>
        <?php
            unset($_SESSION["flash"]);
          }
        ?>
    <div class="row justify-content-md-center">
      <div class="col-md-7">
      <ul class="list-group list-group-horizontal" style="justify-content: center;">
        <li id="client_id" class="list-group-item active"><i class="fas fa-user font-xx-large mx-auto"></i></li>
        <li id="agence_id" class="list-group-item"><i class="fas fa-building fa-x font-xx-large mx-auto"></i></li>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <!-- Client form -->
      <div id="client_form"class="col-md-7">
         <form class="shadow p-4  bg-white" method="post" action="<?= $controllerLink ?>/utilisateurController.php?action=signUp">
          <h2 class="mx-auto p-2 text-center">Inscription <i>( Client )</i></h2>
          <div class="form-group p-2">
            <label for="nomClient">Nom Complet </label>
            <input name="nomClient" type="text" class="form-control" id="nomClient" placeholder="Entrer votre nom" required="true">
          </div>
          <div class="form-group p-2">
            <label for="emailClient">Adresse E-mail</label>
            <input name="emailClient" type="email" class="form-control" id="emailClient" aria-describedby="emailHelp" placeholder="Entrer votre email" required="true">
          </div>
          <div class="form-group p-2">
            <label for="mdpClient">Mot de Passe</label>
            <div class="rounded" style="border: 1px solid #ced4da;">
              <div class="input-group">
                <input name="mdpClient" type="password" pattern="\w{6,}"  aria-describedby="Afficher / Cacher"  class="form-control  border-0 shadow-0" id="mdpClient" placeholder="Entrer votre Mot de Passe" required="true">
                <div class="input-group-append">
                    <button id="show_hide_client" type="button" class="btn btn-link"><i class="fas fa-eye"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group p-2">
            <label for="confirmMdpClient">Confirmation du Mot de Passe :</label>
            <input name="confirmMdpClient" type="password" pattern="\w{6,}" class="form-control" id="confirmMdpClient" aria-describedby="emailHelp" placeholder="Entrer la confirmation du Mot de passe" required="true">
          </div>
          <div class="form-group p-2">
            <label for="dateNaissance">Date de naissance</label>
            <input name="dateNaissance" type="date" class="form-control" id="dateNaissance" required="true">
          </div>
          <div class="form-group p-2">
            <label for="telClient">Téléphone </label>
            <input name="telClient" type="text" class="form-control" pattern="[0-9\-\(\)\/\+\s]{8,18}" id="telClient" placeholder="Entrer votre téléphone" required="true">
          </div>
          <div class="form-group p-2">
            <label for="cin">CIN</label>
            <input name="cin" type="text" class="form-control" id="cin" placeholder="Entrer votre CIN" required="true">
          </div>
          <div class="row p-2">
            <div class="col-md-7">
              <div class="form-check m-0 p-0">
                <label class="form-check-label" for="adresseClient">Adresse</label>
                <textarea name="adresseClient" class="form-control" id="adresseClient" rows="2" placeholder=" Entrer votre adresse" required="true"></textarea>
              </div>
            </div>
            <div class="col-md-5" >
              <label class="form-check-label" for="villeClient">Ville</label>
              <input name="villeClient" type="text" class="form-control" id="villeClient" placeholder="Entrer votre ville" required="true">
            </div>
          </div>
          <div class="row p-2">
             <button type="submit" class="btn btn-primary btn-block" id="ajouterClient" name="ajouterClient">S'inscrire</button>
          </div>
      </form>
      </div>
      <!-- Agence form -->
      <div id="agence_form" class="col-md-7 visually-hidden">
        <form class="shadow p-4  bg-white" method="post" action="../controller/utilisateurController.php?action=signUp">
          <h2 class="mx-auto p-2 text-center">Inscription <i>( Agence de Location )</i></h2>
          <div class="form-group p-2">
            <label for="nomAgence">Nom </label>
            <input name="nomAgence" type="text" class="form-control" id="nomAgence" placeholder="Entrer le nom de votre agence" required="true">
          </div>
          <div class="form-group p-2">
            <label for="emailAgence">Adresse E-mail</label>
            <input name="emailAgence" type="email" class="form-control" id="emailAgence" aria-describedby="emailHelp" placeholder="Entrer l'E-mail de votre agence" required="true">
          </div>
          <div class="form-group p-2">
            <label for="mdpAgence">Mot de Passe</label>
            <div class="rounded" style="border: 1px solid #ced4da;">
              <div class="input-group">
                <input name="mdpAgence" type="password" pattern="\w{6,}"  aria-describedby="Afficher / Cacher"  class="form-control  border-0 shadow-0" id="mdpAgence" placeholder="Entrer votre Mot de Passe" required="true">
                <div class="input-group-append">
                    <button id="show_hide_agence" type="button" class="btn btn-link"><i class="fas fa-eye"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group p-2">
            <label for="confirmMdpAgence">Confirmation du Mot de Passe :</label>
            <input name="confirmMdpAgence" type="password" pattern="\w{6,}" class="form-control" id="confirmMdpAgence" aria-describedby="emailHelp" placeholder="Entrer la confirmation du Mot de passe" required="true">
          </div>
          <div class="form-group p-2">
            <label for="dateOuverture">Date d'ouverture</label>
            <input name="dateOuverture" type="date" class="form-control" id="dateOuverture" required="true">
          </div>
          <div class="form-group p-2">
            <label for="nomDirecteur">Nom Directeur</label>
            <input name="nomDirecteur" type="text" class="form-control" id="nomDirecteur" placeholder="Entrer le nom du directeur" required="true">
          </div>
          <div class="form-group p-2">
            <label for="telAgence">Téléphone </label>
            <input name="telAgence" type="text" class="form-control" pattern="[0-9\-\(\)\/\+\s]{8,18}" id="telAgence" placeholder="Entrer le téléphone de l'agence" required="true">
          </div>
          <div class="row p-2">
            <div class="col-md-7">
              <div class="form-check m-0 p-0">
                <label class="form-check-label" for="adresseAgence">Adresse</label>
                <textarea name="adresseAgence" class="form-control" id="adresseAgence" rows="2" placeholder=" Entrer l'adresse de votre agence" required="true"></textarea>
              </div>
            </div>
            <div class="col-md-5" >
              <label class="form-check-label" for="villeAgence">Ville</label>
              <input name="villeAgence" type="text" class="form-control" id="villeAgence" placeholder="Entrer la ville de votre agence" required="true">
            </div>
          </div>
          <div class="row p-2">
             <button type="submit" class="btn btn-primary btn-block" name="ajouterAgence">S'inscrire</button>
          </div>
      </form>
      </div>
      <!-- end -->
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-7 text-center pt-3">
          <small>Vous avez déja un compte ? <a href="login.php"> connectez-vous</a></small>
      </div>
    </div>
  </div>
  <?php require_once 'templates/js.php'; ?>
  <script type="text/javascript" src="<?= $jsLink ?>/signUp.js"></script>
</body>

</html>