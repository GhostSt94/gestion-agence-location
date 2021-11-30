$(function(){

  $("#show_hide").click(function(){
    if($("#password").attr("type") == "password"){
      $("#password").attr("type","text");
      $(this).html('<i class="fas fa-eye-slash"></i>'); 
    }else{
      $("#password").attr("type","password");
      $(this).html('<i class="fas fa-eye"></i>'); 
    }
  });

  $("#resetPassword").click(function(e){
    e.preventDefault();
    var email = $("#email").val();
    if(email == ""){
      $("#errorResetPassword").html("Entrer votre E-mail d'abord .");
    }else{
      $("#errorResetPassword").html("");
      $.ajax({
        url: '../controller/utilisateurController.php?action=verifEmailExist&email='+email,
        dataType: 'json',
        success: function(data){
          if(data == 0){
            $("#errorResetPassword").html("Aucun compte est associé a cet E-mail .");
          }else{
            location.href = "resetPassword.php?e="+email;
          }
        }
      });
    }

  });
});