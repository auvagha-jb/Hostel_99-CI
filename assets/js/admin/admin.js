 //Users table credentials
    var users_url = 'admin/show_users';
    var users_id = 'users-table';
    var users_empty_msg ='No users are registered in the system'; 
    
    //Suspended users table credentials
    var suspended_url = 'admin/show_suspended_users';
    var suspended_id = 'suspended-users-table';
    var suspended_empty_msg ='No users have been suspended';

/*****Beginning of jQuery functions******/
 $(function () {
     //On page load call the main function 
    $(document).ready(main());

    //Functions to be executed on load
    function main(){
        //Display the registered and suspended users tables
        get_table(users_url,users_id,users_empty_msg);
        get_table(suspended_url,suspended_id,suspended_empty_msg);
    }

    $('#suspend').click(function () {
        $('#suspend').toggle('1000');
        $("i", this).toggleClass("fas fa-lock");
    });
    
    $(document).on('click','.delete_user',function(){
       //The user or hostel to be deleted
        var name = $(this).closest('tr').children().eq(1).text();
        var id = $(this).closest('tr').children().eq(0).text();
        var user_status = $(this).closest('tr').children().eq(5).text();
        var table_id = $(this).closest('table').attr('id');
        var confirmed = confirm_del(name);
        
        if(confirmed){
            removeUser(id,name,user_status,table_id);
        }
    });
    
    function confirm_del(name){
        var del = confirm("Delete "+name+" ?");
        
        return del;
    }

    function dipslaySuccess(msg){
        $('#users-success').html(msg);
        $('#users-success').slideDown().delay(3000).slideUp();
        setTimeout(function(){
           $('#users-success').empty(); 
        },3000);
    }
    
    
    /********Action: Remove user*********/
    /*
     * 
     * @param {string} id
     * @param {string} name
     * @param {string} user_status
     * @param {string} table_id
     * @returns {void}
     */
     function removeUser(id,name,user_status,table_id){
        var delete_link = 'admin/user_delete';
        $.ajax({
            url: base_url + delete_link, // Url to which the request is send
            method:'POST',
            dataType: 'JSON',
            data:{id:id,name:name,user_status:user_status},
            success: function (data)   // A function to be called if request succeeds
            {
                refresh_table(users_url,table_id,users_empty_msg);
                dipslaySuccess(data);
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            }
        });
    }
    
    
    /***************Start: Functions to append table ************/
    
    /*
     * @param {string} link
     * @param {string} table_id
     * @param {type} empty_msg
     * @returns {void}
     */
     function get_table(link,table_id,empty_msg){
        $.ajax({
            url: base_url + link, // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            dataType: "JSON",
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                appendTable(data,table_id);
                dataTable(table_id,empty_msg);
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
     function refresh_table(link,table_id,empty_msg){
        $.ajax({
            url: base_url + link, // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            dataType: "JSON",
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                appendTable(data,table_id);
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            }
        });
    }
    
    
    
    //Initializes the datatables plugin
    function dataTable(table_id,empty_msg){
        $('#'+table_id).DataTable({
            "language": {
                "emptyTable": empty_msg
            }
        });
    }
    
    //Ajax helper function: Appends table to specified div
    function appendTable(data,table_id) {
        if (data !== null) {
            $("#"+table_id+" tbody").html(data);
        } 
    }
    /***************End: Functions to append table ************/
});