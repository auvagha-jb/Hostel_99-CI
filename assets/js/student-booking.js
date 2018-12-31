$(document).ready(function(){
    
    $("#pick_room").click(function(){
        var gender = $("#gender").val();
        var no_sharing = $("#no_sharing").val();
        getAvailableRooms(gender, no_sharing);  
    });
    
    $(document).on("click",".modal-body .card", function(){
        var room = $(this).attr("id");
        $("#room_chosen").val(room);
        //Set the link dynamically
        var a = document.getElementById('checkout');
        a.href=base_url+"student/checkout?room="+room;
        $("#checkout").show();
    });
    
     function getAvailableRooms(gender, no_sharing){
        $.post(base_url+"student/fetch_rooms",{gender:gender, no_sharing:no_sharing},function(data){
            $("#pick-rm-dialog .row").html(data);
            $("#pickRoom").modal('show');
        },"json").fail(function(xhr, textStatus, errorThrown){
            console.log(xhr.responseText);
        });
    }
    
    function updateCartItem(obj,id){
        $.get("./cartAction.php", {action:"updateCartItem", id:id, qty:obj.value}, function(data){
            if(data === 'ok'){
                location.reload();
            }else{
                alert('Cart update failed, please try again.');
            }
        });
    }
    
});