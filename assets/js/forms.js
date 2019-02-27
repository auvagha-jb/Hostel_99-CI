$(document).ready(function () {
    getDefaults();

    /*****Actions executed  on page load******/
    function getDefaults() {
        //Prevent resubmission on refresh or back
        if (window.history.replaceState) {
            window.history.replaceState(null,null,window.location.href);
        }
        //turn off auto-complete
        $("#add-hostel-form input").attr("autocomplete","off");

        //Default value for the country code list 
        $("#country_code").val(254);
    }

    /******Action Listeners: Sign up form********/

    //On keyup: ensures that the email address does not exist  
    $(".sign-up #email").change(function () {
        validEmail();
    });
    //On keyup: validates the password field
    $(".sign-up #pwd").keyup(function () {
        validPwd();
    });
    //On keyup: validates the confirm pasword field 
    $(".sign-up #confirm_pwd").keyup(function () {
        var pwd = $("#pwd").val();
        var confirm_pwd = $("#confirm_pwd").val();
        pwdMatch(pwd,confirm_pwd);
    });
    //On submit of sign_up form...
    $(".sign-up").submit(function (event) {
        //Ensures there is no ajax request being sent to avoid missing errors in validation        
        if (!$.active) {
            //On submit...ensures that the passwords match and are long enough and the email address does not exist in DB
            if (!validPwd() || !validEmail()) {
                event.preventDefault();
            }
        } else {
            alert("Please wait a few seconds, request is being sent to the server")
        }

    });

    $(".sign-in").submit(function (event) {
        event.preventDefault();
        validSignIn();
    });
    var valid = false;
    function validEmail() {
        var email = $("#email").val();

        $.post(base_url + "user_ctrl/email_exists",{ email: email },function (data) {
            console.log(data);
            if (data === "email-exists") {
                $("#email").addClass("is-invalid");
                valid = false;
            } else {
                $("#email").removeClass("is-invalid");
                valid = true;
            }
        }).fail((xhr,textStatus,errorThrown) => {
            console.log(xhr,textStatus,errorThrown)
        });

        console.log("Email: " + valid);
        return valid;
    }

    /******Student update details form********/
    $(".update #email").change(function () {
        availableEmail();
    });

    $(".update").submit(function (event) {
        //On submit...ensures that the passwords match and are long enough and the email address does not exist in DB  
        if (!availableEmail()) {
            event.preventDefault();
        }
    });

    function availableEmail() {
        var data = {
            email: document.getElementById('email').value,
            user_id: document.getElementById('user_id').value
        };

        $.post(base_url + "student/email_available",data,function (data) {
            console.log(data);
            if (data === "email-exists") {
                $("#email").addClass("is-invalid");
                valid = false;
            } else {
                $("#email").removeClass("is-invalid");
                valid = true;
            }
        }).fail(function (xhr,textStatus,errorThrown) {
            console.log(xhr.responseText);
        });

        console.log("Email: " + valid);
        return valid;
    }
    /******End Student update details form********/


    /*******Ensure valid password is entered********/
    function validPwd() {
        var pwd = $("#pwd").val();
        var confirm_pwd = $("#confirm_pwd").val();

        //Ensure the password is long enough
        if (!validLength(pwd)) {
            return false;
        }
        //Ensure the passwords match
        if (!pwdMatch(pwd,confirm_pwd)) {
            return false;
        }

        return true;
    }

    //Ensures password is at least 8 characters long 
    function validLength(pwd) {
        var valid = true;
        if (pwd.length < 8) {
            $("#password-feedback").text("Ensure the password is at least 8 characters");
            $("#pwd").addClass("is-invalid");
            valid = false;
        }
        return valid;
    }

    //Ensures the password matches the confirm_password field
    function pwdMatch(pwd,confirm_pwd) {
        var valid = true;
        var msg = "Ensure the passwords match";
        if (pwd !== confirm_pwd) {
            $("#password-feedback").text(msg);
            $("#pwd").addClass("is-invalid");
            $("#confirm_pwd").addClass("is-invalid");
            valid = false;
        } else {
            $("#pwd").removeClass("is-invalid");
            $("#confirm_pwd").removeClass("is-invalid");
        }
        return valid;
    }

    /*********Action: Sign in**********/
    function validSignIn() {
        var email = $(".sign-in #email").val();
        var pwd = $(".sign-in #pwd").val();
        console.log("Email:" + email);

        $.ajax({
            url: base_url + "user_ctrl/sign_in_action",
            method: 'POST',
            data: { email: email,pwd: pwd },
            cache: true,
            beforeSend: function () {
                $('#sign-in-btn').html('Verifying...');
            },
            success: function (data) {
                let verified = false;
                if (data === "invalid-email") {
                    //Show error
                    $("#email").addClass("is-invalid");
                } else if (data === "invalid-pwd") {
                    //Show error
                    $("#email").removeClass("is-invalid");
                    $("#pwd").addClass("is-invalid");
                } else if (data === "Account blocked") {
                    $('#email-feedback').html(data);
                    $("#email").addClass("is-invalid");
                } else {
                    verified = true;
                }
                verifiedAction(verified,data);
            },
            error: function (xhr,textStatus,errorThrown) {
                console.log(xhr.responseText);
            }
        });

    }

    //Action to take once the credentials have been authenticated
    function verifiedAction(verified,data) {
        let btn = $('#sign-in-btn');
        console.log(verified)
        btn.hasClass('btn-secondary') ? btn.removeClass('btn-secondary') : null;
        btn.hasClass('btn-success') ? btn.removeClass('btn-success') : null;

        if (verified) {
            btn.addClass('btn-success');
            btn.html("Success");
            redirect(data);
        } else {
            btn.addClass('btn-secondary');
            btn.html("Sign in");
        }
    }

    function redirect(data) {
        location.href(base_url + data);
    }

});