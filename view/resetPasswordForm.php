<?php
  if(isset($_GET["fm"],$_GET["e"]) && $_GET["fm"] == 1){
?>
<!DOCTYPE html>
<html lang="en">

<head>
 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Changer votre mot de passe</title>
  <?php 
    require_once 'templates/css.php'; 
    require_once 'templates/link.php';
    session_start(); 
  ?>
  <link rel="stylesheet" type="text/css" href="../static/css/login.css">
</head>

<body>
  <a title="Accueil" href="/<?= $appName ?>"><i class="fas fa-home fa-2x"></i></a>
  <div class="container">
    <div class="text-center p-3">
      <img src="<?= $imageLink ?>/logo.png" width="130" height="105">
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
          }
        ?>
        <?php
          if(isset($_SESSION["flash"]["success"])){
        ?>
            <div class="alert alert-success">
              <?= $_SESSION["flash"]["success"]; ?>
            </div>
        <?php
          }
          unset($_SESSION["flash"]);
        ?>
      </div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <form class="shadow bg-white p-2" method="post" action="<?= $controllerLink ?>/utilisateurController.php?action=resetPasswordConfirm&e=<?= $_GET["e"] ?>">
          <div class="form-group p-2">
            <label for="password">Mot de Passe</label>
            <div class="rounded" style="border: 1px solid #ced4da;">
              <div class="input-group">
                <input name="password" type="password" pattern="\w{6,}" aria-describedby="Afficher / Cacher"  class="form-control  border-0 shadow-0" id="password" placeholder="Entrer votre Mot de Passe" required="true">
                <div class="input-group-append">
                    <button id="show_hide" type="button" class="btn btn-link"><i class="fas fa-eye"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group p-2">
             <label for="confirmPassword">Confirmer votre Mot de Passe</label>
             <input name="confirmPassword" type="password" pattern="\w{6,}" class="form-control" id="confirmPassword" placeholder="Entrer votre Mot de Passe" required="true">
          </div>
          <div class="form-group p-2">
            <button type="submit" class="btn btn-primary w-100">Valider</button>
          </div>
      </form>
      </div>
    </div>
  </div>

  <?php require_once 'templates/js.php'; ?>
  <script type="text/javascript" src="../static/js/resetPasswordForm.js"> </script>

</body>

</html>

<?php
  }else{
    header('location: erreurs/404.php');
  }
?>