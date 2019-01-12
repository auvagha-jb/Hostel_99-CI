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
                appendTable('bookings-table',data);
                dataTable('bookings-table');
            },
            error: function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText); 
            }
        });
    }
    
    function dataTable(table_id) {  
        dataTable = function(){};//Kill as soon as it is called to avoid reinitialization of dataTable
          $('#'+table_id).DataTable({
            "language": {
                "emptyTable": "No bookings at the moment"
            }
        }); 
    }

    function appendTable(table_id, data){
        if (data !== "" || data !==null) {
               $(`#${table_id} tbody`).html(data);
           }
    }
    /**********End: Show Tenants************/
    
    
    /***********Action: Add tenant ***********/
    $(document).on("click","#add-tenant", function(){
        var email = $(this).closest("tr").children().eq(4).text();
        var name = $(this).closest("tr").children().eq(1).text();
        var room_assigned = $(this).closest("tr").children().eq(5).text();
        var no_sharing = $(this).closest("tr").children().eq(6).text();
        showModal(email, name, room_assigned,no_sharing);
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
            
      $.post(base_url+"owner/add_tenant", {email:email, room_assigned:room_assigned,no_sharing:no_sharing}, function(data, status){
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
   
   /***********End: Add tenant ***********/
   
   function showSuccess(data){
      //Display success message
      $("#bookings-feedback").removeClass("alert alert-danger");
      $("#bookings-feedback").addClass("alert alert-success");
      $("#bookings-feedback").html(data);
   }
    
   function refreshTable(){
      $("#hostel_overview").slideUp();
        showBookings();//Display the updated table
   }
   
   function clearTable(){
       $("#bookings-table").find("tr:not(:first)").remove();
   }//End of function
   
   function updateTenants(){
      $.ajax({
            url: base_url + "owner/show_tenants", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            dataType: "JSON",
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                appendTable('tenants-table',data);
                //Updates the number of vacancies and bookings once tenant is added
                vacancies_bookings();
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            }
        });
       
   }//End of function
  
   function vacancies_bookings() {
        $.post(base_url + "owner/vacancies_bookings", function (data) {
            $("#vacancies").html(data.vacancies);
            $("#pending_bookings").html(data.bookings);
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        });
    }
   
    
});