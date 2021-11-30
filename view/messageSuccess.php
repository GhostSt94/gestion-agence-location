<!DOCTYPE html>
<html lang="en">

<head>
 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Changer votre mot de passe</title>
  <?php 
    require_once 'templates/css.php'; 
    require_once 'templates/link.php';
  ?>
  <link rel="stylesheet" type="text/css" href="<?= $cssLink ?>/login.css">
</head>

<body>
  <a title="Accueil" href="/<?= $appName ?>"><i class="fas fa-home fa-2x"></i></a>
  <div class="container">
    <div class="text-center p-3">
      <img src="<?= $imageLink ?>/logo.png" width="130" height="105">
    </div>

    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <div class="shadow bg-white p-2">
          <div class="form-group row p-3">
            <div class="col-md-1 center-item-d-flex"><i class="fas fa-check-circle font-xx-large" ></i></div>
            <p class="col-md-11 mb-0">Vous devez recevoir un mail contenant le lien de modification de votre mot de passe .</p>
          </div>
      </div>
      </div>
    </div>
  </div>

  <?php require_once 'templates/js.php'; ?>

</body>

</html>