$(function() {

	function setActiveCss(eq){
		$(".list-group-item").removeClass("active");
		$(".list-group-item").eq(eq).addClass("active");
	}

	$.ajax({
		url: '../../controller/utilisateurController.php?action=getCounts',
		dataType: 'json',
		success: function(data){
			console.log(data[0]);
			$("#countAgences").html(data[0]);
			$("#countClients").html(data[1]);
			$("#countMessages").html(data[2]);
		}
	});

	$("#agences").click(function(e){
		e.preventDefault();
		setActiveCss(0);

		$.ajax({
			url: '../../controller/utilisateurController.php?action=agenceAdmin',
			dataType: 'json',
			success: function(data){
				$("#profilContent").html(data);
			}
		});
	});

	$("#clients").click(function(e){
		e.preventDefault();
		setActiveCss(1);

		$.ajax({
			url: '../../controller/utilisateurController.php?action=clientsAdmin',
			dataType: 'json',
			success: function(data){
				$("#profilContent").html(data);
			}
		});
	});

	$("#messages").click(function(e){
		e.preventDefault();
		setActiveCss(2);

		$.ajax({
			url: '../../controller/utilisateurController.php?action=messagesAgence',
			dataType: 'json',
			success: function(data){
				$("#profilContent").html(data);
			}
		});
	});

	$(".list-group-item").click(function(){
		$(".alert").css("display","none");
	});

	$("#agences").click();

});