function showModal(index,e,id) {
    e.preventDefault();
    $("#annulerLocationModal").modal("show");
    $("#confirmModalYes").click(function(e){
    	e.preventDefault();
    	$.ajax({
    		url: '../../controller/profilController.php?action=setAnnulerLocation&id='+id,
    		dataType: 'json',
    		success: function(data){
    			if(data == "success"){
    				$("#annulerLocationModal").modal("hide");
    				$("#locationsTable tr").eq(index).remove();
    			}
    			

    		}
    	})
    });
}