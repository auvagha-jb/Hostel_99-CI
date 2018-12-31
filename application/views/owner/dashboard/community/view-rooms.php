<script>
$(function(){ 
   getAll();
function getAll(){
    $.post(base_url+'owner/fetch_rooms', function(data){
        $('#all_rooms').html(data);
    },"json")
    .fail(function(xhr,textStatus,errorThrown){
        console.log(xhr.responseText);
    });
}   
  
});
</script>

<input type="hidden" class="rooms_tab" id="hostel_no_rooms" value="<?= $_SESSION['hostel_no'];?>">
<div id="all_rooms" class="row">
    
</div>
