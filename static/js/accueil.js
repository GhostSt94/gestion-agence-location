$(function(){
	$("#prixMax").change(function(){
		var prixMin = $("#prixMin").val();
		var prixMax = $(this).val();
		if(eval(prixMin) > eval(prixMax)){
			$("#errorPrixMax").html("Prix Maximum invalide");
			$("#searchByPrice").attr("disabled","true");
		}else{
			$("#errorPrixMax").html("");
			$("#searchByPrice").removeAttr("disabled");
		}
	});	
});