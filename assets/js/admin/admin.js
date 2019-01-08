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
        ajax(users_url,users_id,users_empty_msg);
        ajax(suspended_url,suspended_id,suspended_empty_msg);
    }

    $('#suspend').click(function () {
        $('#suspend').toggle('1000');
        $("i", this).toggleClass("fas fa-lock");
    });
    
    $(document).on('click','.delete',function(){
       //The user or hostel to be deleted
        var name = $(this).closest('tr').children().eq(1).text();
        var id = $(this).closest('tr').children().eq(0).text();
        var user_status = $(this).closest('tr').children().eq(5).text();
        var confirmed = confirm_del(name);
        
        if(confirmed){
            console.log(id,name,user_status);
        }
    });
    
    function confirm_del(name){
        var del = confirm("Delete "+name+" ?");
        
        return del;
    }

    function dipslaySuccess(msg){
        $('#users-success').slideDown().delay(3000).slideUp();
    }
    
    
    /********Action: Remove user*********/
    function refreshTable(){
        ajax(link,table_id,empty_msg,data);
    }
     
     function removeUsers(id,name,user_status){
        var delete_link = 'admin/user_delete/'+id+'/'+name+'/'+user_status;
        
        $.ajax({
            url: base_url + delete_link, // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            dataType: "JSON",
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data)   // A function to be called if request succeeds
            {
                appendTable(data,'user-table');
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
     function ajax(link,table_id,empty_msg,data){
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
    
    
    
    //Initializes the datatables plugin
    function dataTable(table_id,empty_msg){
        datatable = function(){};//Kill the function as soon as it is called to prevent reinitialization of dataTable
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