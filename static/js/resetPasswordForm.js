$(function () {
    $("#show_hide").click(function(){
      if($("#password").attr("type") == "password"){
          $("#password").attr("type","text");
          $("#confirmPassword").attr("type","text");
          $(this).html('<i class="fas fa-eye-slash"></i>'); 
      }else{
          $("#password").attr("type","password");
          $("#confirmPassword").attr("type","password");
          $(this).html('<i class="fas fa-eye"></i>'); 
      }
    });
});