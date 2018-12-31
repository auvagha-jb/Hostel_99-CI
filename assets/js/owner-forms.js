$(document).ready(function (){
    
    //Onload...
    $(document).ready(main); 

    /***To be executed on onload***/
    function main(){        
        $("#hostel_name_feedback").hide();

         //Prevent resubmission on refresh or back
        if(window.history.replaceState){
           window.history.replaceState(null, null, window.location.href); 
        }

        //turn off auto-complete
        $(".add-hostel-form input").attr("autocomplete", "off");
    }
    /***End: To be executed on onload***/
    
    
    $("#hostel_name").click(function(){
       $("#hostel_name_feedback").show(); //To inform them that the hostel owner to contact admin to change name 
    });
    
    $('#add_hostel-form').submit(function(event){
        if(!validName()){
            event.preventDefault();
            $('#add-hostel-footer').slideDown('fast');
        }else{
            $('#add-hostel-footer').slideUp('fast');
        }
    });
    
    /****Dynamic input fields****/
    //Add room table
    $(document).on("click", ".add-room", function(){
        addRoom();
    });
    
    //Add amenities 
    $(document).on("click", ".add-amenity", function(){
         addAmenity();
    });
    
    //Add rules
    $(document).on("click", ".add-rule", function(){
         addRule();
    });
    
    //Remove room
    $(document).on('click', '.remove-room',function(){
        var rows = $("#add-room-tbl >tbody >tr").length;
          
        var feedback = "At least one row is needed";
        
        if(rows>1){
            hideWarning("#rooms-feedback");
            $(this).closest("tr").remove(); 
        }else{
            showWarning("#rooms-feedback",feedback);
        }
    });
    
    
    //Remove amenities
    $(document).on('click', '.remove-amenity',function(){
        var rows = $("#add-amenities-tbl >tbody >tr").length;
          
        var feedback = "At least one row is needed";
        
        if(rows>1){
            $("#amenities-feedback").hide();
            $(this).closest("tr").remove(); 
            
        }else{
            showWarning("#amenities-feedback",feedback);
        }
        console.log(rows);
    });
    
    
    //Remove rule
    $(document).on('click', '.remove-rule',function(){
        var rows = $("#add-rules-tbl >tbody >tr").length;
          
        var feedback = "At least one row is needed";
        
        if(rows>1){
            $("#rules-feedback").hide();
            $(this).closest("tr").remove(); 
        }else{
            showWarning("#rules-feedback",feedback);
        }
        console.log(rows);
    });
    
    /****End: Dynamic input fields****/
    
    $('#menu-toggle').click(function(){
       $('#wrapper').toggleClass('toggled'); 
    });
    
    
    /*
     * Add hostel details form
     */
    
    /*Checks whether the hostel name exists*/
    var valid;
    function validName(){
       var hostel_name = $("#hostel_name").val();
       
       $.post(base_url+"owner/hostel_exists", {hostel_name: hostel_name}, function(data){
            console.log(data);
            if(data === "name-exists"){               
                $("#hostel_name").addClass("is-invalid");
                valid = false;
            }else{
                $("#hostel_name").removeClass("is-invalid");
                valid = true;
            }
        });
        
        console.log("Name: "+valid);
        return valid;
   }
    
    
    
   /*********Utility functions*********/
   function showWarning(selector,msg){
        $(selector).addClass("alert alert-warning");
        $(selector).html(msg);
        $(selector).show();
   }
   
   function hideWarning(selector){
       $(selector).hide();
   }
   
   
    function clearRows(){
        $("#add-room-tbl tr.body").remove();
    }
   /*********End: Utility functions*********/
    
    
    function addAmenity(){
       //Hide warning message if it had been displayed
        $("#amenities-feedback").hide();
        
        var html="";
        html+="<tr>";
        html+='<td><input type="text" name="amenities[]" id="amenities" class="form-control" required></td>';
        html+='<td><button type="button" class="btn btn-success btn-sm add-amenity"><i class="fa fa-plus"></i></button></td>';
        html+='<td><button type="button" class="btn btn-danger btn-sm remove-amenity" id="first_rule"><i class="fa fa-minus"></i></button></td>';
        html+="</tr>";
       
        $("#add-amenities-tbl").append(html);
        
        var rows = $("#add-amenities-tbl >tbody >tr").length;
        console.log(rows);  
   }
    
    function addRule(){
       //Hide warning message if it had been displayed
        $("#rules-feedback").hide();
        
        var html="";
        
        html+="<tr>";
        html+='<td><input type="text" name="rules[]" id="rules" class="form-control" required></td>';
        html+='<td><button type="button" class="btn btn-success btn-sm add-rule"><i class="fa fa-plus"></i></button></td>';
        html+='<td><button type="button" class="btn btn-danger btn-sm remove-rule"><i class="fa fa-minus"></i></button></td>';
        html+="</tr>";
       
        $("#add-rules-tbl").append(html);
        var rows = $("#add-rules-tbl >tbody >tr").length;
        console.log(rows);  
   }
   
   function addRoom(){
        var html = "";
       //Hide the warning message if it had been displayed
       $("#rooms-feedback").hide();
       
       html+='<tr class="body">';
       html+='<td><input type="number" name="no_sharing[]" id="no_sharing" class="form-control" required></td>';
       html+='<td><input type="number" name="monthly_rent[]" id="monthly_rent" class="form-control" required></td>';
       html+='<td><input type="number" name="room_limit[]" id="room_limit" class="form-control" required></td>';
       html+='<td><button type="button" class="btn btn-success btn-sm add-room"><i class="fa fa-plus"></i></button></td>';
       html+='<td><button type="button" class="btn btn-danger btn-sm remove-room"><i class="fa fa-minus"></i></button></td>';
       html+='</tr>';
       
       $("#add-room-tbl").append(html);
   }
    
    $("#hostel_name").keyup(function(){
        validName();
    });
    
});



                        
                        
                        
                        
                        
                        
                    