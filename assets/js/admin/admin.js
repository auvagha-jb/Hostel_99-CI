//Users table credentials
var users_url = 'admin/show_users';
var users_id = 'users-table';
var users_empty_msg = 'No users are registered in the system';

//Suspended users table credentials
var suspended_url = 'admin/show_suspended_users';
var suspended_id = 'suspended-users-table';
var suspended_empty_msg = 'No users have been suspended';

//Registered owner table credentials
var owners_url = 'admin/show_registered_owners';
var owners_id = 'registered-owners-table';
var owners_empty_msg = 'No new owners have been registered. Have they created an account?';


/*****Beginning of jQuery functions******/
$(() => {
    //On page load call the main function 
    $(document).ready(main());

    //Functions to be executed on load
    function main() {
        //Display the registered and suspended users tables and the registered owners table
        get_table(users_url, users_id, users_empty_msg);
        get_table(suspended_url, suspended_id, suspended_empty_msg);
        get_table(owners_url, owners_id, owners_empty_msg);
        dataTable("admin-hostels", "No hostels have been registered in the system");
    }

    /**Action: Delete user**/
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
                data.status ? refresh_table(users_url, table_id, users_empty_msg) : null;
                displayAlert(data.message, "user_success", 'success');
            });
        }
    });

    //Confirm dialog
    function confirm_del(name) {
        var del = confirm("Delete " + name + " ?");
        return del;
    }

    //Displays notification that slides down from the top of the page 
    /*
     * @param {string} msg
     * @param {string} id_selector
     * @returns {undefined}
     */
    function displayAlert(msg, id_selector, type) {
        let target = $('#' + id_selector);
        let class_ = getClass(target);

        target.removeClass(class_);
        target.addClass('alert-' + type);

        target.html(msg);
        target.slideDown().delay(5000).slideUp();
        setTimeout(function () {
            target.empty();
        }, 5000);
    }

        
    function getClass(target) {
        let classes = ['alert-success', 'alert-danger', 'alert-warning'];

        for (let class_ of classes) {
            if (target.hasClass(class_)) {
                return class_;
            }
        }
        return null;
    }

    /***************Function to fetch the table data the first time************/
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
                console.error(xhr.responseText);
            }
        });
    }

    /*******Function to refresh the table once an action has been performed********/
    /*
     * @param {string} link
     * @param {string} table_id
     * @param {type} empty_msg
     * @returns {void}
     */
    function refresh_table(link, table_id, empty_msg) {
        let promise = $.ajax({
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
                console.error(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
        return promise;
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

    /*******Register owner form validation*******/

    /********Used to track the state of the user input******/
    /* 
     * @type Object:  
     */
    let valid = {
        hostel_name: false,
        email: false,
        password: false
    };

    /***Action: Get random password***/
    $('#generate_pwd_btn').click(() => {
        generate_pwd();
        let pwd = document.getElementById('activation_pwd').value;

        /*
         * Checks if the password field is > 0. 
         * If it is: valid.password = true
         * else valid.password  = false 
         */
        valid.password = pwd.length > 0 ? true : false;
        console.log(valid.password);
    });

    function generate_pwd() {
        let pwd = Math.random() //Generate random number
                .toString(36)   //Convert to base 36
                .slice(-8);     //Cut off last 8 characters
        $('#activation_pwd').val(pwd);
    }

    /***Validation: To ensure that there is not double registration of an email address**/
    function email_exists() {
        let email = $('#email').val();

        ajax("user_ctrl/email_exists", {email}).then(data => {
            //Convert JSON back to JS object 
            data = JSON.parse(data);

            valid.email = false;
            if (data === "email-exists") {
                $('#email').addClass('is-invalid');
            } else {
                valid.email = true;
                $('#email').removeClass('is-invalid');
            }
            console.log(valid.email);
        });
    }

    /***Validation: To ensure that there are no duplicate hostel names**/
    function hostel_exists() {
        let hostel_name = $('#hostel_name').val();
        let hostel = $('#hostel_name');

        ajax("owner/hostel_exists", {hostel_name}).then(data => {
            if (data === "name-exists") {
                hostel.addClass('is-invalid');
                valid.hostel_name = false;
            } else {
                hostel.removeClass('is-invalid');
                valid.hostel_name = true;
            }
        });
    }
    
    function password_generated(){
        let pwd = $('#activation_pwd');
        !valid.password ? pwd.addClass('is-invalid') : pwd.removeClass('is-invalid');
    }

    $('#owner_reg_form').submit(e => {
        e.preventDefault();
        
        //Form validation
        email_exists();
        hostel_exists();
        password_generated();
        
        let valid_form = true;
        for (let key in valid) {
            if (!valid[key]) {
                valid_form = false;
            }
        }

        if (valid_form) {
            //Submit the form
            displayAlert('All systems go', 'owner-reg-feedback', 'success');
        } else {
            displayAlert('There is some invalid input in the form', 'owner-reg-feedback', 'danger');
        }
    });

    /**********Helper functions**********/

    /***To perform ajax functions***/
    /**
     * @param {string} controller
     * @param {string} data
     * @returns {jqXHR}
     */
    function ajax(controller, data = null) {
        let promise = $.ajax({
            url: base_url + controller, // Url to which the request is send
            method: 'POST',
            data: data,
            success: function () {

            },
            error: function (xhr, textStatus, errorThrown) {
                console.error(errorThrown);
            }
        });

        return promise;
    }

    //Feedback once a user is suspended or unsuspended
    function suspend_restore_msg(name, action) {
        refresh_table(users_url, users_id, users_empty_msg);
        refresh_table(suspended_url, suspended_id, suspended_empty_msg)
                .then(() => displayAlert(name + " " + action, "users-success", 'success'));
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
});