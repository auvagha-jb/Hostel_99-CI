//$(document).ready(function(){
//   
//    $("#add-tenant-form #email").change(function(){
//        var email = $("#add-tenant-form #email").val();
//        if(email !== ""){
//            getGender(email);
//        }else{
//            showInvalid("Enter email address");
//        }
//    });
//    
//    function getGender(email){
//        var action = "get_gender";
//        $.post("php/get-gender.php", {email:email,action:action}, function(data){
//            if(data !== ""){
//                var gender = data;
//                showAvailableRooms(gender);
//                removeInvalid();
//            }else{
//                showInvalid("User email does not exist!");
//            }
//        });    
//    }//end
//    
//    function showAvailableRooms(gender){
//        var action = "show_rooms";
//        $.post("php-owner/owner-get-room-details.php", {gender:gender,action:action}, function(data){
//            $("#hostel_overview").html(data);
//            $("#hostel_overview").slideDown();
//        });
//    }
//   
//   function showInvalid(data){
//       $("#feedback").addClass("alert alert-danger");
//       $("#feedback").html(data);
//   }
//   
//   function removeInvalid(){
//       $("#feedback").removeClass("alert alert-invalid");
//       $("#feedback").html("");
//   }
//    
//});