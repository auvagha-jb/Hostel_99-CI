//Users table credentials
var users_url = 'admin/show_users';
var users_id = 'users-table';
var users_empty_msg = 'No users are registered in the system';

//Suspended users table credentials
var suspended_url = 'admin/show_suspended_users';
var suspended_id = 'suspended-users-table';
var suspended_empty_msg = 'No users have been suspended';

/*****Beginning of jQuery functions******/
$(() => {
    //On page load call the main function 
    $(document).ready(main());

    //Functions to be executed on load
    function main() {
        //Display the registered and suspended users tables
        get_table(users_url, users_id, users_empty_msg);
        get_table(suspended_url, suspended_id, suspended_empty_msg);
        dataTable("admin-hostels", "No hostels have been registered in the system");
    }

    $('#suspend').click(function () {
        $('#suspend').toggle('1000');
        $("i", this).toggleClass("fas fa-lock");
    });

    $(document).on('click', '.delete_user', function () {
        //The user or hostel to be deleted
        var name = $(this).closest('tr').children().eq(1).text();
        var id = $(this).closest('tr').children().eq(0).text();
        var user_status = $(this).closest('tr').children().eq(5).text();
        var table_id = $(this).closest('table').attr('id');
        var confirmed = confirm_del(name);
        let data = {
            id, name, user_status
        };


        if (confirmed) {
            //Carry out asynchronous request to delete data, then refresh table
            ajax("admin/user_delete", data).then(data => {
                //Convert JSON to JavaScript object
                data = JSON.parse(data);
                data.status ? refresh_table(users_url, table_id, users_empty_msg): null;
                displaySuccess(data.message,"user_success");
            });
        }
    });

    function confirm_del(name) {
        var del = confirm("Delete " + name + " ?");

        return del;
    }

    function displaySuccess(msg,id_selector) {
        $('#'+id_selector).html(msg);
        $('#'+id_selector).slideDown().delay(3000).slideUp();
        setTimeout(function () {
            $('#'+id_selector).empty();
        }, 3000);
    }


    /***************Start: Functions to append table ************/

    /*
     * @param {string} link
     * @param {string} table_id
     * @param {type} empty_msg
     * @returns {void}
     */
    function get_table(link, table_id, empty_msg) {
        $.ajax({
            url: base_url + link, // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            dataType: "JSON",
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                appendTable(data, table_id);
                dataTable(table_id, empty_msg);
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            }
        });
    }

    /*
     * @param {string} link
     * @param {string} table_id
     * @param {type} empty_msg
     * @returns {void}
     */
    function refresh_table(link, table_id, empty_msg) {
        $.ajax({
            url: base_url + link, // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            dataType: "JSON",
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                appendTable(data, table_id);
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    }



    /**********Action: Suspend user***********/
    $(document).on("click", "td > button.user-suspend", function () {
        var id = $(this).closest('tr').children().eq(0).text();
        var name = $(this).closest('tr').children().eq(1).text();

        //Carry out asynchronous request to suspend user then refresh table and give feedback
        ajax("admin/user_suspend/" + id, null).then(() => {
            suspend_restore_msg(name, "suspended");
        });
    });


    /**********Action: Restore user***********/
    $(document).on("click", "td > button.user-restore", function () {
        var id = $(this).closest('tr').children().eq(0).text();
        var name = $(this).closest('tr').children().eq(1).text();

        //Carry out asynchronous request to restore suspended user then refresh table and give feedback
        ajax("admin/user_restore/" + id, null).then(() => {
            suspend_restore_msg(name, "pardoned from suspension");
        });
    });


    /*******Action: Confirm hostel delete**********/
    $(document).on("click", ".hostel_delete", function () {
        let hostel = $(this).closest('tr').children().eq('0').text();
        return confirm_hostel_delete(hostel);
    });

    function confirm_hostel_delete(hostel) {
        let bool = confirm("Delete " + hostel + "?");

        return bool;
    }

    /**********Helper functions**********/

    //To perform ajax functions
    function ajax(controller, data) {
        let promise = $.ajax({
            url: base_url + controller, // Url to which the request is send
            method: 'POST',
            data: data,
            success:function(){
                
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

        return promise;
    }

    //Feedback once a user is suspended or unsuspended
    function suspend_restore_msg(name, action) {
        refresh_table(users_url, users_id, users_empty_msg);
        refresh_table(suspended_url, suspended_id, suspended_empty_msg);
        displaySuccess(name + " " + action,"users-success");
    }


    //Initializes the datatables plugin
    function dataTable(table_id, empty_msg) {
        $('#' + table_id).DataTable({
            "language": {
                "emptyTable": empty_msg
            }
        });
    }

    //Ajax helper function: Appends table to specified div
    function appendTable(data, table_id) {
        if (data !== null) {
            $("#" + table_id + " tbody").html(data);
        }
    }
    /***************End: Functions to append table ************/
});