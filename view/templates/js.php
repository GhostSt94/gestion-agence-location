<?php
	require_once 'link.php';
?>

<script type="text/javascript" src="<?= $jsLink ?>/jquery.js"></script>
<script type="text/javascript" src="<?= $jsLink ?>/popper.min.js"></script>
<script type="text/javascript" src="<?= $jsLink ?>/boostrap.min.js"></script>
<script type="text/javascript" src="<?= $jsLink ?>/font-awsome.js"></script>
<script type="text/javascript">
	$(function(){

		$.ajax({
			url: '/Gestion Agence Location/controller/voitureController.php?action=checkLouer',
			dataType: 'json',
			success: function(data){
				console.log(data);
			}

		});

		$.ajax({
			url: '/Gestion Agence Location/controller/utilisateurController.php?action=checkSession',
			success: function(){
				console.log("success");
			}
		});

		$.ajax({
			url: '/Gestion Agence Location/controller/utilisateurController.php?action=checkRemenberMe',
			success: function(){
				console.log("success");
			}
		});


	});

	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	  return new bootstrap.Tooltip(tooltipTriggerEl)
	});

</script>