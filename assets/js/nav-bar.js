$(document).ready(function(){
   
    //Hide and show dropdown contents
    $(".dropdown").click(function(){
       $(".dropdown-content", this).slideToggle();
   });
   
   var state = false;
   
   function down(){
       var value;
       
       if(state === false){
           value = false;
           state = true;
       }else{
           value = true;
           state = false;
       }
       return value;
   }
   
   //Collapse and expand navigation bar on small screens 
    $("button#nav-btn").click(function(){
        if(!down()){
            $(".navbar-nav").slideDown();
        }else{
            $(".navbar-nav").slideUp();
        }
    });   
    
});