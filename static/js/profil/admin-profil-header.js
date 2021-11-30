function showModalDeleteAgence(index,e,id) {
    e.preventDefault();
    $("#deleteAgenceModal").modal("show");
    
    $("#confirmModalYesAgence").click(function(e){
        e.preventDefault();
        $.ajax({
            url: '../../controller/utilisateurController.php?action=deleteAgence&id='+id,
            dataType: 'json',
            success: function(data){
                if(data == "success"){
                    $("#deleteAgenceModal").modal("hide");
                    $("#agencesTable tr").eq(index).remove();
                }
                

            }
        })
    });
}

function showModalDeleteClient(index,e,id) {
    e.preventDefault();
    $("#deleteClientModal").modal("show");
    
    $("#confirmModalYesClient").click(function(e){
        e.preventDefault();
        $.ajax({
            url: '../../controller/utilisateurController.php?action=deleteClient&id='+id,
            dataType: 'json',
            success: function(data){
                if(data == "success"){
                    $("#deleteClientModal").modal("hide");
                    $("#clientsTable tr").eq(index).remove();
                }
                

            }
        })
    });
}

function showModalDeleteMessage(index,e,id) {
    e.preventDefault();
    $("#deleteMessageModal").modal("show");
    
    $("#confirmModalYesMessage").click(function(e){
        e.preventDefault();
        $.ajax({
            url: '../../controller/utilisateurController.php?action=deleteMessage&id='+id,
            dataType: 'json',
            success: function(data){
                if(data == "success"){
                    $("#deleteMessageModal").modal("hide");
                    $("#messagesTable tr").eq(index).remove();
                }
                

            }
        })
    });
}