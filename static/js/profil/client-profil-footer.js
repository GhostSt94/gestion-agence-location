$(function(){

	$("html, body").animate({scrollTop: 0},"fast");
	
	function setActiveCss(eq){
		$(".list-group-item").removeClass("active");
		$(".list-group-item").eq(eq).addClass("active");
	}

	$.ajax({
		url: '../../controller/profilController.php?action=getCountsClientProfil',
		dataType: 'json',
		success: function(data){
			$("#countLocations").html(data[0]);
		}
	});

	$("#informations").click(function(e){
		e.preventDefault();
		setActiveCss(0);
		$.ajax({
			url: '../../controller/profilController.php?action=informationsClient',
			dataType: 'json',
			success: function(data){
				//alert("ttt");
				$("#profilContent").html(data);
			}
		});
	});

	$("#informations").click();

	
	$("#locations").click(function(e){
		e.preventDefault();
		setActiveCss(1);

		$.ajax({
			url: '../../controller/profilController.php?action=locationsClient',
			dataType: 'json',
			success: function(data){
				$("#profilContent").html(data);
			}
		});
	});

	$(".list-group-item").click(function(){
		$(".alert").css("display","none");
	});

});