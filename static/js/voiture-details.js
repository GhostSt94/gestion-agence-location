$(function(){
  
  $("#duree").change(function(){
    var duree = $(this).val();
    var prix = $("#prixJ").html();
    $("#prixTotal").html(duree * prix + " DH");
  });
  
  $("#dateDebut").change(function(){

    var year = new Date().getFullYear();
    var mounth = new Date().getMonth() + 1;
    var day = new Date().getDate();
    if(mounth < 10){
      mounth = "0"+mounth;
    }
    if(day < 10){
      day = "0"+day;
    }
    var dateNow = new Date(year + "-" + mounth + "-" + day);
    var dateDebut = new Date($(this).val());
    if(dateNow > dateDebut){
      $("#dateErreur").html("Entrer une date supérieur de "+year + "-" + mounth + "-" + day);
      $("#envoyer").attr("disabled","true");
    }else{
      $("#dateErreur").html("");
      $("#envoyer").removeAttr("disabled");
    }

  });

});