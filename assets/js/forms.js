$(document).ready(function(){

    getDefaults();
   
   /******Action Listeners********/
   //On keyup; ensures that the email address does not exist  
   $(".sign-up #email").change(function(){
        validEmail();
   });
   
   $(".sign-up #pwd").keyup(function(){
        validPwd(); 
   });
   
   $(".sign-up #confirm_pwd").keyup(function(){
       var pwd = $("#pwd").val();
       var confirm_pwd = $("#confirm_pwd").val(); 
       pwdMatch(pwd,confirm_pwd);
   });
   
   $(".update #email").change(function(){
        availableEmail();
   });
   
   $(".sign-up").submit(function(event){
       //On submit...ensures that the passwords match and are long enough and the email address does not exist in DB  
       if(!validPwd() || !validEmail()){
            event.preventDefault();
        }
   });
   
   $(".update").submit(function(event){
       //On submit...ensures that the passwords match and are long enough and the email address does not exist in DB  
       if(!availableEmail()){
            event.preventDefault();
        }
   });
    
    $(".sign-in").submit(function(event){
        if(!validSignIn()){
           event.preventDefault();
       } 
    });
   /******End; Action Listeners********/
   
   var valid = false;
   function validEmail(){
       var email = $("#email").val();
       
       $.post(base_url+"user_ctrl/email_exists", {email: email}, function(data){
            console.log(data);
            if(data === "email-exists"){               
                $("#email").addClass("is-invalid");
                valid = false;
            }else{
                $("#email").removeClass("is-invalid");
                valid = true;
            }
        },"json");
        
        console.log("Email: "+valid);
        return valid;
   }
   
   /******Student update details form********/
   function availableEmail(){
       var email = $("#email").val();
       
       $.post("php/update_details.php", {email: email}, function(data){
            console.log(data);
            if(data === "email-exists"){               
                $("#email").addClass("is-invalid");
                valid = false;
            }else{
                $("#email").removeClass("is-invalid");
                valid = true;
            }
        });
        
        console.log("Email: "+valid);
        return valid;
   }
   /******End Student update details form********/
   
   
 /*******Ensure valid password is entered********/
   function validPwd(){
       var pwd = $("#pwd").val();
       var confirm_pwd = $("#confirm_pwd").val();
       var valid = true;
       
       //Ensure the password is long enough
       if(!validLength(pwd)){
            return false;
       }
       //Ensure the passwords match
       if(!pwdMatch(pwd,confirm_pwd)){
            return false;
       }
    
        return valid;
   }
   
   function validLength(pwd){
       var valid = true;
       if(pwd.length < 8){
           $("#password-feedback").text("Ensure the password is at least 8 characters");
           $("#pwd").addClass("is-invalid");
           valid=false;
       }
        return valid;
   }
   
   function pwdMatch(pwd,confirm_pwd){
       var valid = true; 
       var msg = "Ensure the passwords match";
       if(pwd !== confirm_pwd){
            $("#password-feedback").text(msg);
            $("#pwd").addClass("is-invalid");
            $("#confirm_pwd").addClass("is-invalid");
            valid=false;
        }else{
            $("#pwd").removeClass("is-invalid");
            $("#confirm_pwd").removeClass("is-invalid");
        }
        return valid;
   }
 /*******Ensure valid password is entered********/
    
   var valid_sign_in = false;
   function validSignIn(){
       var email = $(".sign-in #email").val();
       var pwd = $(".sign-in #pwd").val();
       console.log("Email:"+email);
       
       $.post(base_url+"user_ctrl/sign_in_action", {email: email, pwd: pwd}, function(data){
           console.log(data);
           if(data ==="invalid-email"){
               //Show error
               $("#email").addClass("is-invalid");
               valid_sign_in = false;
               
           }else if(data === "invalid-pwd"){
               //Show error
               $("#email").removeClass("is-invalid");
               $("#pwd").addClass("is-invalid");
               valid_sign_in = false;
               
           }else if(data === "Account blocked"){
               $('#email-feedback').html(data);
                $("#email").addClass("is-invalid");
                valid_sign_in = false;
                
           }else{
               valid_sign_in = true;
           }
       }).fail(function(xhr, textStatus, errorThrown){
           console.log(xhr.responseText);
       });   
       
       console.log("Validity: "+valid_sign_in);
        return  valid_sign_in;
   }
   
   
   /*****Called on load******/
   function getDefaults(){
        //Prevent resubmission on refresh or back
       if(window.history.replaceState){
          window.history.replaceState(null, null, window.location.href); 
       }
       //turn off auto-complete
       $("#add-hostel-form").attr("autocomplete", "off");

      //Default value for the country code list 
      $("#country_code").val(254);
   }
   
    
});