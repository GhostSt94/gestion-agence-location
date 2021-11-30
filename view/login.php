<!DOCTYPE html>
<html lang="en">

<head>
 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authentification</title>
  <?php require_once 'templates/css.php';
        require_once 'templates/link.php';
        session_start();
  ?>
  <link rel="stylesheet" type="text/css" href="<?= $cssLink ?>/login.css">
</head>

<body>
  <a title="Accueil" href="/Gestion Agence Location"><i class="fas fa-home fa-2x"></i></a>
  <div class="container">
    <div class="text-center p-3">
      <img src="<?= $imageLink ?>/logo.png" id="logoLogin" class="rounded" width="130" height="105">
    </div>

    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <?php
          if(isset($_SESSION["flash"]["danger"])){
        ?>
            <div class="alert alert-danger">
              <?= $_SESSION["flash"]["danger"]; ?>
            </div>
        <?php
            unset($_SESSION["flash"]);
          }
        ?>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <form class="shadow bg-white p-2" method="post" action="<?= $controllerLink ?>/utilisateurController.php?action=logIn">
        <h1 class="p-2 text-center">Authentification</h1>
          <div class="form-group p-2">
            <label for="email">Adresse E-mail</label>
            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Entrer votre E-mail" required="true">
            <p class="text-danger mb-0 mt-1" id="errorResetPassword"></p>
          </div>
          <div class="form-group p-2">
            <label for="password">Mot de Passe</label>
            <div class="rounded">
              <div class="input-group">
                <input name="password" type="password"  aria-describedby="Afficher / Cacher"  class="form-control  border-0 shadow-0" id="password" placeholder="Entrer votre Mot de Passe" required="true">
                <div class="input-group-append">
                    <button id="show_hide" type="button" class="btn btn-link"><i class="fas fa-eye"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class=" row p-3 jc-sb">
            <div class="col-md-5">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="cbxRemenberMe" name="cbxRemenberMe">
                <label class="form-check-label" for="cbxRemenberMe">Rester connecté</label>
              </div>
            </div>
            <div class="col-md-5" >
              <a href="resetPassword.php" id="resetPassword">Mot de passe oublié ?</a>
            </div>
          </div>
          <div class="row p-4">
             <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
          </div>
      </form>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-6 pt-3 text-center">
        <small>Vous n'avez pas un compte ? <a href="signUp.php"> inscrivez-vous</a></small>
      </div>
    </div>
  </div>

  <?php require_once 'templates/js.php'; ?>
  <script type="text/javascript" src="<?= $jsLink ?>/login.js"></script>
</body>

</html>