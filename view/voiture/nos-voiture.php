<!DOCTYPE html>
<html>
<head>
	<title>Nos Voitures</title>
	<?php require_once '../templates/css.php'; ?>
	<link rel="stylesheet" type="text/css" href="../../static/css/custom-bg.css">

</head>
<body>
	<?php require_once '../templates/nav.php'; ?>
	<div class="my-container min-vh-100">
		<h1 class="ms-4 p-3">Voitures</h1>
		 <?php
          if(isset($_SESSION["flash"]["danger"])){
        ?>
            <div class="row">
        		<div class="col-md-3 ms-4"></div>
              <div class="col-md-8 ms-2">
                <div class="alert alert-danger">
                  <?= $_SESSION["flash"]["danger"]; ?>
                </div>
             </div>
            </div>
        <?php

          }else if(isset($_SESSION["flash"]["success"])){
        ?>
        	<div class="row">
        		<div class="col-md-3 ms-4"></div>
              <div class="col-md-8 ms-2">
                <div class="alert alert-success">
                  <?= $_SESSION["flash"]["success"]; ?>
                </div>
             </div>
            </div>
        <?php
          }
          unset($_SESSION["flash"]);
        ?>
       
		<div class="row me-0">
			
			<div class="col-md-3 ms-4 bg-white-opacity h-25 shadow-lg p-3 mb-5 rounded">

				<form >
			        <select class="form-select mb-2" aria-label="Default select example" id="marque" name="marque">
			        </select>
			        <input type="text" name="model" id="model" class="form-control mb-2" placeholder="Entrer un model">
					<div class="form-check-inline pt-2 pb-2">
						<label class="form-check-label">
							<input type="checkbox" name="available" id="available" class="form-check-input"> Disponible seulement
						</label>
					</div>
			        <button id="search" class="btn btn-primary pt-2">Chercher</button>
		      </form>
			</div>

			<div class="col-md-8 ms-2 bg-white-opacity shadow-lg p-3 mb-5 rounded" id="nos-voitures">
				
			</div>
		</div>
	</div>

	<?php require_once '../templates/footer.php'; ?>

	<?php require_once '../templates/js.php'; ?>

	<script type="text/javascript" src="../../static/js/nos-voiture.js"></script>
	<script type="text/javascript">
		$(function(){
			$.ajax({
				url: '../../controller/voitureController.php?action=findAll&current=1<?php if(isset($_GET["prixMin"])){?>&prixMin=<?=$_GET['prixMin'];?><?php } ?><?php if(isset($_GET["prixMax"])){?>&prixMax=<?=$_GET['prixMax'];?><?php } ?>',
				dataType: 'json',
				success: function(data){
					console.log(data);
					$("#nos-voitures").html(data);
					$(".absolute-spinner").css("display","none");
					var index = data.indexOf("card");
					if(index === -1){
						$("#nos-voitures .row").eq(0).html("<h3 class='text-center mt-4'>Aucune Voiture trouvée .</h3>");
					}
				}
			});
		});

		function paginationSearchByPrice(e,index) {	
			e.preventDefault();

			$.ajax({
				url: '../../controller/voitureController.php?action=findAll&current='+( index + 1 )+'<?php if(isset($_GET["prixMin"])){?>&prixMin=<?=$_GET['prixMin'];?><?php } ?><?php if(isset($_GET["prixMax"])){?>&prixMax=<?=$_GET['prixMax'];?><?php } ?>',
				dataType: 'json',
				success: function(data){
					$("html, body").animate({scrollTop: 0},"fast");
					$("#nos-voitures").html(data);
					for (var i = 0; i < $(".activable-item").length; i++) {
						$(".activable-item").eq(i).removeClass("active");
					}
					$(".activable-item").eq(index).addClass("active");
					$(".absolute-spinner").css("display","none");
				}
			});
		}
	</script>
</body>
</html>