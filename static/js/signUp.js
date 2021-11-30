$(function(){
	var type = "";

	 $("#client_id").click(function(){
	 	type = "Client";
	    $(this).addClass("active");
	    $("#agence_id").removeClass("active");
	    $("#client_form").removeClass("visually-hidden");
	    $("#agence_form").addClass("visually-hidden");
	 });
	  $("#agence_id").click(function(){
	  	type = "Agence";
	    $(this).addClass("active");
	    $("#client_id").removeClass("active");
	    $("#client_form").addClass("visually-hidden");
	    $("#agence_form").removeClass("visually-hidden");
	 });

	$("#show_hide_client").click(function(){
	    if($("#mdpClient").attr("type") == "password"){
	         $("#mdpClient").attr("type","text");
	         $("#confirmMdpClient").attr("type","text");
	         $(this).html('<i class="fas fa-eye-slash"></i>'); 
	    }else{
	         $("#mdpClient").attr("type","password");
	         $("#confirmMdpClient").attr("type","password");
	         $(this).html('<i class="fas fa-eye"></i>'); 
	    }
	});

	$("#show_hide_agence").click(function(){
	    if($("#mdpAgence").attr("type") == "password"){
	         $("#mdpAgence").attr("type","text");
	         $("#confirmMdpAgence").attr("type","text");
	         $(this).html('<i class="fas fa-eye-slash"></i>'); 
	    }else{
	         $("#mdpAgence").attr("type","password");
	         $("#confirmMdpAgence").attr("type","password");
	         $(this).html('<i class="fas fa-eye"></i>'); 
	    }
	});

});