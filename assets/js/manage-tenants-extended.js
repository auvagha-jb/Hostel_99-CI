$(document).ready(function(){
   
    $("#add-tenant-form #email").change(function(){
        var email = $("#add-tenant-form #email").val();
        if(email !== ""){
            getGender(email);
        }else{
            showInvalid("Enter email address");
        }
    });
    
    function getGender(email){
        $.post(base_url+"owner/get_gender", {email:email}, function(data){
            if(data !== null){
                var gender = data.gender;
                showAvailableRooms(gender);
                removeInvalid();
            }else{
                showInvalid("User email does not exist!");
            }
        },"json")
        .fail(function(xhr,textStatus,errorMessage){
            console.log(xhr.responseText);
        });    
    }//end
//    
    function showAvailableRooms(gender){
        $.post(base_url+"owner/show_rooms", {gender:gender}, function(data){
            $("#hostel_overview").html(data);
            $("#hostel_overview").slideDown();
        }).fail(function(xhr,textStatus,errorMessage){
            console.log(xhr.responseText);
        });;
    }
//   
   function showInvalid(data){
       $("#feedback").addClass("alert alert-danger");
       $("#feedback").html(data);
   }
   
   function removeInvalid(){
       $("#feedback").removeClass("alert alert-invalid");
       $("#feedback").html("");
   }
    
});