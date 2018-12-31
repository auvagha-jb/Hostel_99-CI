$(document).ready(function(){

   /*Ensure the cards are the same height**/
   flex_cards();
        
    function flex_cards(){
        $(".special-offers").addClass("d-flex");
        $(".special-offers").addClass("p-2");

        $(".card").addClass("align-items-stretch");
    }
   
    /****************Handle window resizing**************/
    var default_width = $(window).width();
    resizeText(default_width);
    
    var min_width = 820;
   

    function resizeText(width){
        if(width<=min_width){

             $(".carousel-item h1").removeClass("display-3");
             $(".carousel-item h3").removeClass("display-4");

             $(".carousel-item h1").addClass("mobile-text");
             $(".carousel-item h3").addClass("mobile-text");
             
        }else{
             $(".carousel-item h1").addClass("display-3");
             $(".carousel-item h3").addClass("display-4");

             $(".carousel-item h1").removeClass("mobile-text");
             $(".carousel-item h3").removeClass("mobile-text");
        }
        
        
       }
   
    
    $(window).resize(function(){
        var width = $(window).width();
        resizeText(width);
        console.log(width);
        
        if(width>min_width){
            $(".navbar-nav").show();
        }
    });
    /*******End: Window resizing*******/
    
    
    $('#location_home').click(function(){
       var id =  $('#user_id').val();
       if(id ==""){
           alert('Please log in first');
           location.replace(base_url+'main/sign_in');
       }

    });
    
});