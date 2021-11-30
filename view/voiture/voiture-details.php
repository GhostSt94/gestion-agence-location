<!DOCTYPE html>
<html>

<head>
    <title>Détails de la voiture</title>
    <?php 
      require_once '../templates/css.php';
      require_once '../templates/link.php';
    ?>
    <link rel="stylesheet" type="text/css" href="<?= $cssLink ?>/voiture-details.css">
    <script type="text/javascript">
      
    </script>
</head>

<body>
    <?php require_once '../templates/nav.php'; ?>
    <div class="min-vh-70">
      <div class="container bg-light mt-5 shadow-lg p-3 mb-5 bg-body rounded" id="voiture-details">
              
                  
      </div>
    </div>

        <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Demande de Location</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="post" action="../../controller/voitureController.php?action=louer&id=<?= $_GET["id"] ?>">
              <div class="modal-body">
                    <div class="form-group">
                        <label for="duree">Durée ( jours ):</label>
                        <input type="number" name="duree" id="duree" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label for="dateDebut">Date début :</label>
                        <input type="date" name="dateDebut" id="dateDebut" class="form-control" required="true">
                        <p class="text-danger mt-2" id="dateErreur"></p>
                    </div>        
              </div>
              <div class="modal-footer" style="justify-content: space-between;">
                <p id="prixTotal"></p>
                <div>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                  <button type="submit" class="btn btn-primary" id="envoyer">Envoyer la Demande</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
    <?php require_once '../templates/footer.php'; ?>

    <?php require_once '../templates/js.php'; ?>
    <script type="text/javascript" src="<?= $jsLink ?>/voiture-details.js"></script>
    <script type="text/javascript">

      $(function(){
        
        $.ajax({
          url: '../../controller/voitureController.php?action=details&id=<?=$_GET['id'];?><?php if(isset($_GET["fromProfil"])){?>&fromProfil=<?=$_GET['fromProfil'];?><?php } ?>',
          dataType: 'json',
          success: function(data){
            console.log(data);
            $("#voiture-details").html(data);

            $.ajax({
              url: '../../controller/voitureController.php?action=checkReservation&idVoiture=<?=$_GET['id'];?>',
              dataType: 'json',
              success: function(data){
                if(data == "true"){
                  $("#louer").attr("disabled","true");
                  $("#errorReserved").html("<b>Déjà réservé</b>");
                }else{
                  $("#louer").removeAttr("disabled");
                  $("#errorReserved").html("");
                }
              }
            });
          }

        });
      });
      function deleteImage(idImage,e,src) {
        e.preventDefault();
        var response = confirm("Voulez-vous supprimé cette Image ?");
        if(response){
            $.ajax({
              url: '../../controller/voitureController.php?action=deleteImage&id='+idImage+'&idVoiture=<?=$_GET['id'];?>&src='+src,
              dataType: 'json',
              success: function(data){
                
                if(data == "true"){

                  $.ajax({
                    url: '../../controller/voitureController.php?action=details&id=<?=$_GET['id'];?><?php if(isset($_GET["fromProfil"])){?>&fromProfil=<?=$_GET['fromProfil'];?><?php } ?>',
                    dataType: 'json',
                    success: function(data){
                      console.log(data);
                      $("#voiture-details").html(data);
                      alert("Image Supprimé avec success .");
                    }

                  });
                }else{
                  alert("Une erreur est survenue pendant la suppression veuillez réssayer plus tard .");
                }
              }
            }); 
        }
        
      }

    </script>
</body>

  
</html>