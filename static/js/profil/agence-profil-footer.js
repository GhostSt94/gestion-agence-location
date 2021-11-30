$(function(){
			
	$("html, body").animate({scrollTop: 0},"fast");
	
	function setActiveCss(eq){
		$(".list-group-item").removeClass("active");
		$(".list-group-item").eq(eq).addClass("active");
	}

	$.ajax({
		url: '../../controller/profilController.php?action=getCountsAgenceProfil',
		dataType: 'json',
		success: function(data){
			$("#countVoitures").html(data[0]);
			$("#countClients").html(data[1]);
			$("#countLocations").html(data[2]);
		}
	});

	$("#informations").click(function(e){
		e.preventDefault();
		setActiveCss(0);

		$.ajax({
			url: '../../controller/profilController.php?action=informationsAgence',
			dataType: 'json',
			success: function(data){
				$("#profilContent").html(data);

			}
		});
	});

	$("#informations").click();

	$("#voitures").click(function(e){
		e.preventDefault();
		setActiveCss(1);
		$.ajax({
			url: '../../controller/profilController.php?action=voituresAgence',
			dataType: 'json',
			success: function(data){
				$("#profilContent").html(data);
				$("#ajouterVoiture").click(function(){
					
					$.ajax({
						url: '../../controller/profilController.php?action=ajouterVoiture',
						dataType: 'json',
						success: function(data) {
							$("#profilContent").html(data);

							$("#images").change(function () {
								var filesCount = $(this)[0].files.length;
								if(parseInt(filesCount) > 4){
									$("#fileCountError").html("Vous avez dépassé le nombres maximum de photos ( Maximum 4 photos ).");
									$("#btnAjouterVoiture").attr("disabled","true");
								}else{
									$("#fileCountError").html("");
									$("#btnAjouterVoiture").removeAttr("disabled");
								}
							});

							$("#btnAjouterVoiture").click(function(e) {
								e.preventDefault();
								
								var id = $(this).attr("i-a");
								if($("#matricule").val() == "" || $("#marque").val() == "" || $("#model").val() == "" || $("#couleur").val() == "" || $("#carburant").val() == "" || $("#prixJ").val() == "" || $("#nbrChevaux").val() == ""){
										$("#msgError").css("display","block");
										$("html, body").animate({scrollTop: 0},"fast");
								}else{
									$("#msgError").css("display","none");
									var fd = new FormData();
						        	var files = $('#images')[0].files;
									if(files.length > 0){
										
					        			for (var i = 0; i < files.length; i++) {
							        		fd.append('images[]',files[i])
							        	}

							        	$.ajax({
							              url: '../../controller/profilController.php?action=submitAjout&matricule='+$("#matricule").val()+'&marque='+$("#marque").val()+'&model='+$("#model").val()+'&couleur='+$("#couleur").val()+'&carburant='+$("#carburant").val()+'&prixJournalier='+$("#prixJournalier").val()+'&nbrChevaux='+$("#nbrChevaux").val(),
							              type: 'post',
							              data: fd,
							              contentType: false,
							              processData: false,
							              success: function(){
							                 location.reload();
							                 $(this).attr("disabled","true");
							              }
							           });
									}else{
							           alert("Choisir au moins une image .");
							        }
								
								}
								
							});
						}
					});
				});
			}
		});
	});

	$("#clients").click(function(e){
		e.preventDefault();
		setActiveCss(2);

		$.ajax({
			url: '../../controller/profilController.php?action=clientsAgence',
			dataType: 'json',
			success: function(data){
				$("#profilContent").html(data);
			}
		});
	});

	$("#locations").click(function(e){
		e.preventDefault();
		setActiveCss(3);

		$.ajax({
			url: '../../controller/profilController.php?action=locationsAgence',
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

