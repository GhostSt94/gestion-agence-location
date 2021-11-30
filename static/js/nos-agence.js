$(function(){
	$.ajax({
		url: '../../controller/utilisateurController.php?action=findAllVille',
		dataType: 'json',
		success: function(data){
			console.log(data);
			$("#ville").html(data);
		}
	});

	$.ajax({
		url: '../../controller/utilisateurController.php?action=findAllAgence&current=1',
		dataType: 'json',
		success: function(data){
			console.log(data);
			$("#nos-agences").html(data);
			setHeight();
		}
	});

	$("#search").click(function(e){
		e.preventDefault();
		var ville = $("#ville").val();
		var nom = $("#nomAgence").val();
				
		var customUrl = "";

		$(".absolute-spinner").css("display","block");
		$(".card").css("visibility","hidden");
		$("#nos-agences").css("background-color","rgba(0,0,0,0.5)");
				
		if(nom == "" && ville == "Sélectionner une ville"){
			$.ajax({
				url: '../../controller/utilisateurController.php?action=findAllAgence&current=1',
				dataType: 'json',
				success: function(data){
					$(".card").css("visibility","visible");
					$("#nos-agences").css("background-color","rgba(225,225,225,0.9)");
					$("#nos-agences").html(data);
					setHeight();
				}
			});
		}else{
			if(ville == "Sélectionner une ville" && nom != ""){
				customUrl = "../../controller/utilisateurController.php?action=searchAgence&nom="+nom+"&current=1";
			}

			if(nom == "" && ville != "Sélectionner une ville"){
				customUrl = "../../controller/utilisateurController.php?action=searchAgence&ville="+ville+"&current=1";
			}

			if(nom != "" && ville != "Sélectionner une ville"){
				customUrl = '../../controller/utilisateurController.php?action=searchAgence&ville='+ville+'&nom='+nom+"&current=1";
			}

			$.ajax({
				url:  customUrl,
				dataType: 'json',
				success: function(data){
					$(".card").css("visibility","visible");
					$("#nos-agences").css("background-color","rgba(225,225,225,0.9)");
					$("#nos-agences").html(data);
					setHeight();
					var index = data.indexOf("card");
					if(index === -1){
						$("#nos-agences .row").eq(0).html("<h3 class='text-center mt-4'>Aucune Agence trouvée .</h3>");
					}
				}
			});
		}

	});

			
});

function paginationSearch(e,index) {
	e.preventDefault();
	var ville = $("#ville").val();
	var nom = $("#nomAgence").val();
			
	var customUrl = "";
				
	if(nom == "" && ville == "Sélectionner une ville"){
		$.ajax({
			url: '../../controller/utilisateurController.php?action=findAllAgence&current=1',
			dataType: 'json',
			success: function(data){
				$("#nos-agences").html(data);
				setHeight();
			}
		});
	}else{
		if(ville == "Sélectionner une ville" && nom != ""){
			customUrl = "../../controller/utilisateurController.php?action=searchAgence&nom="+nom+"&current="+(index + 1);
		}

		if(nom == "" && ville != "Sélectionner une ville"){
			customUrl = "../../controller/utilisateurController.php?action=searchAgence&ville="+ville+"&current="+(index + 1);
		}

		if(nom != "" && ville != "Sélectionner une ville"){
			customUrl = '../../controller/utilisateurController.php?action=searchAgence&ville='+ville+'&nom='+nom+"&current="+(index + 1);
		}

					
		$.ajax({
			url:  customUrl,
			dataType: 'json',
			success: function(data){
				$("html, body").animate({scrollTop: 0},"fast");
				$("#nos-agences").html(data);
				setHeight();
				for (var i = 0; i < $(".activable-item").length; i++) {
					$(".activable-item").eq(i).removeClass("active");
				}
				$(".activable-item").eq(index).addClass("active");
							
			}
		});
	}
}

function pagination(e,index) {
	e.preventDefault();
	$.ajax({
		url: '../../controller/utilisateurController.php?action=findAllAgence&current='+(index+1),
		dataType: 'json',
		success: function(data) {
			$("html, body").animate({scrollTop: 0},"fast");
			$("#nos-agences").html(data);
			setHeight();
			for (var i = 0; i < $(".activable-item").length; i++) {
				$(".activable-item").eq(i).removeClass("active");
			}
			$(".activable-item").eq(index).addClass("active");
		}
	});
}

function setHeight() {
	var b = [];
	for (var i = 0; i < $(".card").length ; i++) {
		b[i] = parseInt($(".card").eq(i).css("height"));
	}
	var heightMax = Math.max.apply(null,b);
	$(".card").css("height",heightMax+"px");
	$(".absolute-spinner").css("display","none");
}