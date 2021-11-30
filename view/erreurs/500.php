<!DOCTYPE html>
<html>

<head>
    <title>Erreur interne</title>
    <?php require_once '../templates/css.php'; ?>
    <link rel="stylesheet" type="text/css" href="<?= $cssLink ?>/erreurs/erreurs.css">
</head>

<body>
    <?php require_once '../templates/nav.php'; ?>

    <div class="center-item-d-flex mx-auto w-75 erreur-container" >
      <div class="container" >
        <div class="row">
          <div class="col-md-2  ps-0 pe-0 text-center">
            <i class="fas fa-exclamation-triangle erreur-img"></i>
          </div>
          <div class="col-md-10 ps-0 pe-0">
            <h4 class="mt-4 text-danger">Erreur 500 : Une erreur interne est survenue, veuillez réessayer plus tard. Si l'erreur parvient toujours veuillez nous contacter.</h4>
          </div>
        </div>
      </div>  
    </div>  

    <?php require_once '../templates/js.php'; ?>
</body>

  
</html>