$(function () {

    var path = location.href;
    var page = path.split('/').slice(-1);
    setActive(page);
    
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    }); 

    $('.sidebar-nav li a').click(function(){
       // toggleActive();
       var target = "#"+$(this).attr('id');
    });

   function toggleActive(target){
       $('.sidebar-nav li a').not(target).removeClass('active'); 
       $('.sidebar-nav li a'+target).addClass('active'); 
   }
   
   function setActive(target){
       $('.sidebar-nav li a').each(function(){
          var href = $(this).attr('href');
          if(href == target){
              $(this).addClass('active');
          }
       });
   }
    
});