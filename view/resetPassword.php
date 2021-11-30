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
      <div class="col-md-6" id="checking">
        
      </div>
      </div>
    </div>

  <?php require_once 'templates/js.php'; ?>
  <script type="text/javascript">
      $(function(){

          $.ajax({
            url: '../controller/utilisateurController.php?action=checkRole&e=<?= $_GET["e"] ?>',
            dataType: 'json',
            success: function(data){
                $("#checking").html(data);
            }
          });
      });
  </script>
</body>

</html>