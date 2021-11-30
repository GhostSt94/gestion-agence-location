var estLouer = 0;
$(function(){

	$.ajax({
		url: '../../controller/voitureController.php?action=findAllMarque',
		dataType: 'json',
		success: function(data){
			console.log(data);
			$("#marque").html(data);
		}

	});

	$('input[type="checkbox"]').click(function(){
	    if($(this).prop("checked") == true){
	    	estLouer = 1;
	    }
	    else if($(this).prop("checked") == false){
	    	estLouer = 0;
	    }
	  });

	$("#search").click(function(e){
		e.preventDefault();

		var marque = $("#marque").val();
		var model = $("#model").val();
		
		$(".alert").eq(0).css("display","none");

		$(".absolute-spinner").css("display","block");
		$(".card").css("visibility","hidden");
		$("#nos-agences").css("background-color","rgba(0,0,0,0.5)");

		if(model == "" && marque == 0 && estLouer == 0){
			$.ajax({
				url: '../../controller/voitureController.php?action=searchVoiture&current=1&estlouer=0',
				dataType: 'json',
				success: function(data){
					$("#nos-voitures").css("background-color","rgba(225,225,225,0.9)");
					$(".card").css("visibility","visible");
					$("#nos-voitures").html(data);
					$(".absolute-spinner").css("display","none");
					var index = data.indexOf("card");
					if(index === -1){
						$("#nos-voitures .row").eq(0).html("<h3 class='text-center mt-4'>Aucune Voiture trouvée .</h3>");
					}
									
				}
			});
		}else{
			var customUrl = "";

			if(marque == 0 && model != ""){
				customUrl = "../../controller/voitureController.php?action=searchVoiture&model="+model+"&estlouer="+estLouer+"&current=1";
			}	

			if(model == "" && marque != 0){
				customUrl = "../../controller/voitureController.php?action=searchVoiture&marque="+marque+"&estlouer="+estLouer+"&current=1";
			}

			if(model != "" && marque != 0){
				customUrl = '../../controller/voitureController.php?action=searchVoiture&marque='+marque+'&model='+model+"&estlouer="+estLouer+"&current=1";
			}

			if(model == "" && marque == 0){
				customUrl = '../../controller/voitureController.php?action=searchVoiture&estlouer='+estLouer+"&current=1";
			}

			$.ajax({
				url:  customUrl,
				dataType: 'json',
				success: function(data){
					$("#nos-voitures").css("background-color","rgba(225,225,225,0.9)");
					$(".card").css("visibility","visible");
					$("#nos-voitures").html(data);
					$(".absolute-spinner").css("display","none");
					var index = data.indexOf("card");
					if(index === -1){
						$("#nos-voitures .row").eq(0).html("<h3 class='text-center mt-4'>Aucune Voiture trouvée .</h3>");
					}
				}
			});
		}

		
	});

	
});

function paginationSearch(e,index) {
	e.preventDefault();

	var marque = $("#marque").val();
	var model = $("#model").val();

	var customUrl = "";
	if(marque == 0 && model != ""){
		customUrl = "../../controller/voitureController.php?action=searchVoiture&model="+model+"&estlouer="+estLouer+"&current="+(index + 1);
	}

	if(model == "" && marque != 0){
		customUrl = "../../controller/voitureController.php?action=searchVoiture&marque="+marque+"&estlouer="+estLouer+"&current="+(index + 1);
	}

	if(model != "" && marque != 0){
		customUrl = '../../controller/voitureController.php?action=searchVoiture&marque='+marque+'&model='+model+"&estlouer="+estLouer+"&current="+(index + 1);
	}

	if(model == "" && marque == 0){
		customUrl = '../../controller/voitureController.php?action=searchVoiture&estlouer='+estLouer+"&current="+(index + 1);
	}

	$.ajax({
		url:  customUrl,
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

function pagination(e,index) {
	e.preventDefault();
	
	$.ajax({
		url: '../../controller/voitureController.php?action=findAll&current='+(index+1),
		dataType: 'json',
		success: function(data) {
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

function setHeight() {
	var b = [];
	for (var i = 0; i < $(".card").length ; i++) {
		b[i] = parseInt($(".card").eq(i).css("height"));
	}
	var heightMax = Math.max.apply(null,b);
	$(".card").css("height",heightMax+"px");

	$(".absolute-spinner").css("display","none");
}