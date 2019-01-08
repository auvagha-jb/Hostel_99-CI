$(document).ready(function () {
    //Styling
    $(".inline-text").addClass("mr-3");
    $(".inline-text").addClass("my-3");
    $(".modal-body .card").addClass("mx-4 my-3");

    /*
     * On load...
     */
    showTenants();
    getNoSharing();
    vacancies_bookings();



    /**********Action: Show Tenants************/
    function showTenants() {
        $.ajax({
            url: base_url + "owner/show_tenants", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            dataType: "JSON",
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                appendTable(data);
                dataTable('tenants-table');
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            }
        });
    }
    

    function dataTable(table_id) {  
        dataTable = function(){};//Kill as soon as it is called to avoid reinitialization of dataTable
          $('#'+table_id).DataTable({
            "language": {
                "emptyTable": "No tenants are listed in your hostel"
            }
        }); 
    }

    function appendTable(data) {
        if (data !== null) {
            $("no-tenants-msg").hide();
            $("#tenants-table tbody").html(data);
        } else {
            $("#no-tenants-msg").show();
        }
    }
    
    /*********Work in progress*******/
//        var table = $('#tenants-table').DataTable({
//            "processing":true,
//            "serverSide":true,
//            "ajax":{
//                url:base_url + "owner/show_tenants",
//                type:"POST"
//            },
//            "language": {
//                "emptyTable": "No tenants are listed in your hostel"
//            }
//        });     
        //refresh(table);
    
    function refresh(table){
        setInterval(function(){
            table.ajax.reload();
        },3000);
    }
    /*********Work in progress*******/
    
    /**********End: Show Tenants************/



    /**********Action: Add tenants************/
    $("#add-tenant-form #room_assigned").click(function () {
        var form = "#add-tenant-form";
        var email = $(form + " #email").val();
        var no_sharing = $(form + " #no_sharing").val();

        if (email !== "" && no_sharing !== "") {
            getGender(email);
            removeInvalid();
        } else {
            showInvalid("Enter the email address and no_sharing");
        }
    });

    $("#add-tenant-form").submit(function (e) {
        e.preventDefault();

        var email = $("#email").val();
        var room_assigned = $("#room_assigned").val();
        var no_sharing = $("#no_sharing").val();

        if (room_assigned !== "" && email !== "" && no_sharing !== "") {
            verifyUser(email, room_assigned, no_sharing);
        } else {
            showInvalid("Fill all fields!")
        }
    });

    function verifyUser(email, room_assigned, no_sharing) {
        $.post(base_url + "owner/verify_user", {email: email, room_assigned: room_assigned, no_sharing: no_sharing},
        function (data, status) {
            if (data !== "") {
                //Display error message
                $("#feedback").addClass("alert alert-danger");
                $("#feedback").html(data);
                $("#add-tenant-form #room_assigned").val("");//Clear the room assigned
            } else {
                addTenant();
            }
        }).fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        });
    }//End of function


    function addTenant() {
        var email = $("#email").val();
        var room_assigned = $("#room_assigned").val();
        var no_sharing = $("#no_sharing").val();

        $.post(base_url + "owner/add_tenant", {email: email, room_assigned: room_assigned, no_sharing: no_sharing}, function (data, status) {

            if (data != "") {
                //Display succes message
                $("#feedback").removeClass("alert alert-danger");
                $("#feedback").addClass("alert alert-success");
                $("#feedback").html(data);

                $("#no-tenants-msg").hide();//Remove no-tenants message
                refreshTable();
            } else {
                alert("Not executed");
            }
        });
        $("#add-tenant-form #room_assigned").val("");//Clear the room assigned
    }//End of function

    /******End: Add tenants********/


    /******Utility functions********/
    function removeInvalid() {
        $("#feedback").removeClass("alert alert-invalid");
        $("#feedback").html("");
    }

    function getGender(email) {

        $.post(base_url + "owner/get_gender", {email: email}, function (data, status) {
            if (data !== "") {
                $("#add-tenant-form #gender").val(data.gender);

                var form = "#add-tenant-form";
                var gender = $(form + " #gender").val();
                var no_sharing = $(form + " #no_sharing").val();
                var hostel_no = $('#hostel_no').val();

                getAvailableRooms(gender, no_sharing, hostel_no);
            } else {
                showInvalid("User email does not exist!");
            }
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        });
    }//end

    function getAvailableRooms(gender, no_sharing, hostel_no) {
        $.post(base_url + "owner/available_rooms", {gender: gender, no_sharing: no_sharing, hostel_no: hostel_no}, function (data) {
            $("#assign-rm-dialog .row").html(data);
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        });
    }

    function getNoSharing() {
        $.post(base_url + "owner/get_no_sharing", function (data) {
            $("#no_sharing").append(data);
        }, "json")
                .fail(function (xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText);
                });
    }//End of function 


    function getRent(no_sharing) {
        $.post(base_url + "owner/get_rent", {no_sharing: no_sharing}, function (data) {
            $("#monthly_rent").val(data.monthly_rent);
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        });
    }

    //Get the Vacancies and bookings
    function vacancies_bookings() {
        $.post(base_url + "owner/vacancies_bookings", function (data) {
            $("#vacancies").html(data.vacancies);
            $("#pending_bookings").html(data.bookings);
        }, "json").fail(function (xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
        });
    }
    /******End: Utility functions********/




    $(document).on("click", "#room_assigned", function () {
        if (form_filled()) {
            $("#assignRoom").modal('show');
        }
    });

    $(document).on("click", ".modal-body .card", function () {
        var room = $(this).attr("id");
        $("#room_assigned").val(room);
    });




    /********Action: Remove tenant********/
    $(document).on("click", "#confirm_del", function () {
        var user_id = $(this).closest("tr").children().eq(0).text();
        var name = $(this).closest("tr").children().eq(1).text();
        var room_assigned = $(this).closest("tr").children().eq(5).text();
        var no_sharing = $(this).closest("tr").children().eq(6).text();
        showModal(user_id, name, room_assigned, no_sharing);
    });

    $(document).on("click", "#remove_tenant", function () {
        var user_id = $("#modal_form #user_id").val();
        var name = $("#modal_form #name").val();
        var no_sharing = $("#modal_form #no_sharing").val();
        var room_assigned = $("#modal_form #room_assigned").val();
        removeTenant(user_id, name, room_assigned, no_sharing);
    });

    function showModal(user_id, name, room_assigned, no_sharing) {
        $("#delete_dialog").html("");//Clears modal in case there are other rooms being displayed 
        var msg = '';
        msg += '<form id="modal_form">';
        msg += '<input type="hidden" id="user_id" value="' + user_id + '">';
        msg += '<input type="hidden" id="name" value="' + name + '">';
        msg += '<input type="hidden" id="no_sharing" value="' + no_sharing + '">';
        msg += '<input type="hidden" id="room_assigned" value="' + room_assigned + '">';
        msg += '</form>';

        msg += '<span>Remove ' + name + ' as a tenant?</span>';
        $("#delete_dialog").html(msg);
    }


    function removeTenant(user_id, name, room_assigned, no_sharing) {
        $.post(base_url + "owner/remove_tenant", {user_id: user_id, name: name, room_assigned: room_assigned, no_sharing: no_sharing},
        function (data) {
            $("#feedback").addClass("alert alert-success");
            $("#feedback").html(data);
            refreshTable();
        })
                .fail(function (xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText);
                });

    }//End of function

    /********End: Remove tenant********/

    /*******Start: Action Listeners*******/
    $("#no_sharing").change(function () {
        var no_sharing = $("#no_sharing").val();
        getRent(no_sharing);
        $("#add-tenant-form #room_assigned").val("");//Clear the room assigned
    });
    /*******End: Action Listeners*******/



    function clearTable() {
        $("#tenants-table").find("tr:not(:first)").remove();
    }//End of function


    function refreshTable() {
        $("#hostel_overview").slideUp();
        //clearTable();
        showTenants();//Display the updated table
        vacancies_bookings();
    }

    function showInvalid(data) {
        $("#feedback").addClass("alert alert-danger");
        $("#feedback").html(data);
    }

    function form_filled() {
        var form = "#add-tenant-form";
        var email = $(form + " #email").val();
        var no_sharing = $(form + " #no_sharing").val();

        if (email !== "" && no_sharing !== "") {
            return true;
        }
        return false;
    }


});