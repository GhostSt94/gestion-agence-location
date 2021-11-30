function editerVoiture(id){
		$.ajax({
			url: '../../controller/profilController.php?action=editVoiture&id='+id,
			dataType: 'json',
			success: function(data){
				$("#profilContent").html(data);
			}
		});
}

function onChangeFileInput(input,id){
	var filesCount = input.files.length;
	$.ajax({
		url: '../../controller/profilController.php?action=getImagesCount&id='+id,
		dataType: 'json',
		success: function(data){
			if(parseInt(data)  + parseInt(filesCount) > 4){
				$("#fileCountError").html("Vous avez dépassé le nombres maximum de photos ( Maximum 4 photos ).");
				$("#btnEditVoiture").attr("disabled","true");
			}else{
				$("#fileCountError").html("");
				$("#btnEditVoiture").removeAttr("disabled");
			}
		}
	});
}

function submitEditVoiture(btn,e,id){
	e.preventDefault();
	if($("#matricule").val() == "" || $("#marque").val() == "" || $("#model").val() == "" || $("#couleur").val() == "" || $("#carburant").val() == "" || $("#prixJ").val() == "" || $("#nbrChevaux").val() == ""){
		$("#msgError").css("display","block");
		$("html, body").animate({scrollTop: 0},"slow");
	}else{
		$("#msgError").css("display","none");
		var fd = new FormData();
		var files = $('#images')[0].files;
		for (var i = 0; i < files.length; i++) {
			fd.append('images[]',files[i])
		}
		$.ajax({
			url: '../../controller/profilController.php?action=submitEdit&id='+id+'&matricule='+$("#matricule").val()+'&marque='+$("#marque").val()+'&model='+$("#model").val()+'&couleur='+$("#couleur").val()+'&carburant='+$("#carburant").val()+'&prixJournalier='+$("#prixJournalier").val()+'&nbrChevaux='+$("#nbrChevaux").val(),
			type: 'post',
			data: fd,
			contentType: false,
			processData: false,
			success: function(){
				location.reload();
				btn.setAttribute("disabled","true");
			}
		});
	}
	
}

function showModal(index,e,id) {
        e.preventDefault();
        $("#deleteCarModal").modal("show");
        $("#confirmModalYesCar").click(function(e){
        	e.preventDefault();
        	$.ajax({
        		url: '../../controller/profilController.php?action=deleteVoiture&id='+id,
        		dataType: 'json',
        		success: function(data){
        			if(data == "success"){
        				$("#deleteCarModal").modal("hide");
        				$("#voituresTable tr").eq(index).remove();
        			}
        			

        		}
        	})
        });
}

function setDisponible(id,input) {
	if(input.checked){
		$.ajax({
			url: '../../controller/profilController.php?action=setDisponible&id='+id,
			success: function(){
				$.ajax({
					url: '../../controller/profilController.php?action=voituresAgence',
					dataType: 'json',
					success: function(data){
						$("#profilContent").html(data);
					}
				});	
			}
		});
	}

}

function validerLocation(id,input) {
	if(input.checked){
		$.ajax({
			url: '../../controller/profilController.php?action=setValiderLocation&id='+id,
			success: function(){
				$.ajax({
					url: '../../controller/profilController.php?action=locationsAgence',
					dataType: 'json',
					success: function(data){
						$("#profilContent").html(data);
					}
				});	
			}
		});
	}
}

function showLocationModal(index,e,id) {
        e.preventDefault();
        $("#deleteLocationModal").modal("show");
        
        $("#confirmModalYesLocation").click(function(e){
        	e.preventDefault();
        	$.ajax({
        		url: '../../controller/profilController.php?action=deleteLocation&id='+id,
        		dataType: 'json',
        		success: function(data){
        			if(data == "success"){
        				$("#deleteLocationModal").modal("hide");
        				$("#locationsTable tr").eq(index).remove();
        			}
        			

        		}
        	})
        });
}

function localisation(id,e) {
	e.preventDefault();

	$.ajax({
		url: '../../controller/profilController.php?action=getLocalisation&id='+id,
		dataType: 'json',
		success: function(data){
			$("#profilContent").html(data);
		}
	});
}

function goBack() {
	$("#locations").click();
}