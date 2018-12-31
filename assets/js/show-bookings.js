$(document).ready(function(){
   
   /***On load: ***/
    showBookings();
    
    /**********Action: Show bookings************/
    function showBookings(){
        $.ajax({
            url: base_url + "owner/show_bookings", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            dataType: "JSON", 
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {   
                appendBookings(data);
                $('#bookings-table').DataTable({
                    "language":{
                        "emptyTable": "No bookings at the moment "
                    }
                });
            },
            error: function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText); 
            }
        });
    }

    function appendBookings(data){
         if (data !== "" || data !==null) {
                $("no-bookings-msg").hide();
                $("#bookings-table tbody").append(data);
            } else {
                $("#no-bookings-msg").show();
            }
    }
    /**********End: Show Tenants************/
    
    
    function showBookingsTable(){    
        $.post("php-owner/owner-get-bookings-table.php", function(data, status){
          if(data != ""){
              $("no-bookings-msg").hide();
              $("#bookings-table tbody").html(data);
          }else{
              $("#bookings-table tbody").html(data);
              $("#no-bookings-msg").show();
          }
       });
       
   }//End of function
    function showDefaultBookingsTable(){    
        $.post("php-owner/owner-get-bookings-table.php", function(data, status){
          
          if(data != ""){
              $("no-bookings-msg").hide();
              $("#bookings-table tbody").append(data);
          }else{
              $("#no-bookings-msg").show();
          }
          $('#bookings-table').DataTable();
       });
       
   }//End of function

    $(document).on("click","#add-tenant", function(){
        var email = $(this).closest("tr").children().eq(4).text();
        var name = $(this).closest("tr").children().eq(1).text();
        var room_assigned = $(this).closest("tr").children().eq(5).text();
        var no_sharing = $(this).closest("tr").children().eq(6).text();
        showModal(email, name, room_assigned,no_sharing);
        showTenantsTable();
    });
    
    $(document).on("click","#confirm_add", function(){
        addTenant();
    });
    
    function showModal(email, name, room_assigned,no_sharing){
       var msg = '';
        msg += '<form id="modal_form">';
        msg += '<input type="hidden" id="email" value="'+email+'">';
        msg += '<input type="hidden" id="name" value="'+name+'">';
        msg += '<input type="hidden" id="no_sharing" value="'+no_sharing+'">';
        msg += '<input type="hidden" id="room_assigned" value="'+room_assigned+'">';
        msg += '</form>';
        
        msg += '<span>Add '+name+' as a tenant?</span>';
        $("#add_dialog").html(msg);
        $("#confirmAddModal").modal('show');
   }
   
   function addTenant(){
      var form = "#modal_form";
      var email = $(form+" #email").val();
      var room_assigned = $(form+" #room_assigned").val();
      var no_sharing = $(form+" #no_sharing").val();
            
      $.post("owner-add-tenant.php", {email:email, room_assigned:room_assigned,no_sharing:no_sharing}, function(data, status){
          if(data != ""){
              $("#no-tenants-msg").hide();//Remove no-tenants message
                showSuccess(data);
                refreshTable();
                updateTenants();
          }else{
              alert("Not executed");
          }
       });
   }//End of function
   
   function showSuccess(data){
      //Display success message
      $("#bookings-feedback").removeClass("alert alert-danger");
      $("#bookings-feedback").addClass("alert alert-success");
      $("#bookings-feedback").html(data);
   }
    
   function refreshTable(){
      $("#hostel_overview").slideUp();
      showBookingsTable();//Display the updated table
   }
   
   function clearTable(){
       $("#bookings-table").find("tr:not(:first)").remove();
   }//End of function
   
   function updateTenants(){
      $.post("owner-get-tenants-table.php", function(data, status){
          if(data != ""){
              $("no-tenants-msg").hide();
              $("#tenants-table tbody").html(data);
          }else{
              $("#no-tenants-msg").show();
          }
          
       });
       $.post("php-owner/owner-update-vacancies.php",function(data){
            $("#vacancies").html(data);
       });
       $.post("php-owner/owner-get-no-booked.php",function(data){
            $("#pending_bookings").html(data);
       });
       
   }//End of function
   
});