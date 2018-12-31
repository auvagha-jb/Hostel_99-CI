$(function () {
    //Use the datatables plugin
    $('.admin-table').DataTable();

    $('#suspend').click(function () {
        $('#suspend').toggle('1000');
        $("i", this).toggleClass("fas fa-lock");
    });
    
    $(".delete").click(function(){
       //The user or hostel to be deleted
       var row = $(this).closest('tr').children().eq(1).text();
        
        return confirm_del(row);
    });
    
    function confirm_del(row){
        var del = confirm("Delete "+row+" ?");
        
        return del;
    }
    
});