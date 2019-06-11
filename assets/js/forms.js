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


    //On keyup: validates the password field
    $(".sign-up #pwd").keyup(function () {
        user_auth.pwd = validPwd();
    });

    //On keyup: validates the password field
    $(".sign-up #confirm_pwd").keyup(function () {
        user_auth.pwd = validPwd();
    });

    //For hostel owner: Ensures that they had verified their hostel with the admin beforehand
    $(".sign-up #email").change(function () {
        validEmail();
        if (owner_auth.is_owner) {
            owner_is_verified();
        }
    });

    //On keyup: validates the confirm pasword field 
    $(".sign-up #confirm_pwd").keyup(function () {
        var pwd = $("#pwd").val();
        var confirm_pwd = $("#confirm_pwd").val();
        pwdMatch(pwd,confirm_pwd);
    });

    //On change of owner_authentication password
    $('#auth_pwd').change(function () {
        owner_is_verified();
    });

    //On change of user_type
    $("#user_type").change(function () {
        let user_type = $(this).val(),
            div = $(".owner_auth");

        //Check whether the user is signing up for an owner or student account
        owner_auth.is_owner = (user_type === "Hostel Owner") ? true : false;

        //Toggle hide and show the owner authentication field
        (user_type === "Hostel Owner") ? div.removeClass('d-none') : div.addClass('d-none');

    });



    //On submit of sign_up form...
    $(".sign-up").submit(function (event) {
        event.preventDefault();

        //Re-validate email address
        validEmail();

        let form = $(this),
            url = form.attr('action'),
            type = form.attr('method'),
            data = get_form_data(form);

        //Ensures that the passwords match and are long enough and the email address does not exist in DB
        if (!user_auth.pwd || !user_auth.email) {
            console.log("Password or email address is invalid");

            //Ensures that if the user type is hostel owner, the auth_password is correct
        } else if (owner_auth.is_owner && !owner_auth.pwd) {
            console.log("Hostel verification failed");
        } else {
            console.log("Submitted");
            ajax_form_submit(url,type,data).then(data => {
                let verified = is_verified(data);

                if (verified) {
                    redirect(data);
                }
            });
        }
    });

    //on submit of sign up form
    $(".sign-in").submit(function (event) {
        event.preventDefault();
        validSignIn();
    });

    /*
     * Keeps track of the state of validaton for Hostel Owner
     * @type object
     */
    let owner_auth = {
        is_owner: false,
        pwd: false
    };

    /*
     * Keeps track of the state of validation
     * @type object
     */
    let user_auth = {
        email: false,
        pwd: false
    };


    function validEmail() {
        var email = $("#email").val();

        $.post(base_url + "user_ctrl/email_exists",{ email: email },function (data) {
            console.log(data);
            if (data === "email-exists") {
                $("#email").addClass("is-invalid");
                user_auth.email = false;
            } else {
                $("#email").removeClass("is-invalid");
                user_auth.email = true;
            }
            console.log(user_auth);
        },"json").fail((xhr,textStatus,errorThrown) => {
            console.log(xhr,textStatus,errorThrown);
        });
    }

    /*
     * Executes an asynchronous request to ensure the hostel_owner had registered and entered the correct authentication password 
     * @returns {undefined}
     */
    function owner_is_verified() {
        //Check if the user_type is hostel_owner
        if ($('#user_type').val() === "Hostel Owner") {
            auth_owner().then(data => {
                auth_owner_feedback(data);
                //Toggle the state of the password property depending on whether the password is true or false
                owner_auth.pwd = data.status;
                console.log(data);
                console.log(owner_auth);
            });
        }
    }

    /**
     * Ensures the hostel owner was verified and entered the correct password
     * @returns {jqXHR}
     */
    function auth_owner() {
        let email = document.getElementById('email').value;
        let auth_pwd = document.getElementById('auth_pwd').value;

        let ajax = $.ajax({
            url: base_url + "user_ctrl/auth_owner",
            method: 'POST',
            dataType: 'JSON',
            data: { email,auth_pwd },
            success: function (data) {

            },
            error: function (xhr,textStatus,errorThrown) {
                console.log(xhr.responseText,textStatus,errorThrown);
            }
        });

        return ajax;
    }

    function auth_owner_feedback(data) {
        console.log(data);
        let class_name = (data.status) ? "is-valid" : "is-invalid";
        let class_to_rmv = (data.status) ? "is-invalid" : "is-valid";

        let div = (data.status) ? $('#owner_valid') : $('#owner_invalid');
        let div_to_hide = (data.status) ? $('#owner_invalid') : $('#owner_valid');
        let input = $('#auth_pwd');

        div.html(data.msg);

        div_to_hide.hide();
        div.show();

        input.removeClass(class_to_rmv);
        input.addClass(class_name);

    }

    /******Student update details form********/
    let update_form_auth = {
        email: false
    };

    $(".update #email").change(function () {
        availableEmail();
    });

    $(".update").submit(function (event) {
        let form = $(this),
            url = form.attr('action'),
            type = form.attr('method'),
            data = get_form_data(form);

        //Ensures the user's email is ok before submission
        if (update_form_auth.email) {
            ajax_form_submit(url,type,data).then(data => {
                alert(data);
            });
        }

        return false;
    });

    /**
     * Gets the data for each from element with attribute 'name'
     * @param {*} form 
     */
    function get_form_data(form) {
        let data = {};

        //Get elements with a _name_ attribute
        form.find('[name]').each(function () {
            let input = $(this),name = input.attr('name'),value = input.val();
            //Insert the form data into the object
            data[name] = value;
        });

        return data;
    }

    /** 
     * Submits the form using ajax
     * @param {string} url
     * @param {string} type
     * @param {string} data
     * @returns {undefined}
     */
    function ajax_form_submit(url,type,data) {
        return $.ajax({
            url: url,
            type: type,
            data: data,
            success: function (data) {

            },
            error: function (xhr,textStatus,errorThrown) {
                console.log(xhr.responseText);
            }
        });
    }


    function availableEmail() {
        var form_data = {
            email: document.getElementById('email').value,
            user_id: document.getElementById('user_id').value
        };

        $.post(base_url + "student/email_available",form_data,function (data) {
            console.log(data);
            if (data === "email-exists") {
                $("#email").addClass("is-invalid");
                update_form_auth.email = false;
            } else {
                $("#email").removeClass("is-invalid");
                update_form_auth.email = true;
            }
        }).fail(function (xhr,textStatus,errorThrown) {
            console.log(xhr.responseText);
        });
        console.log("Email: " + user_auth.email);
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
                let verified = is_verified(data);
                verifiedAction(verified,data);
            },
            error: function (xhr,textStatus,errorThrown) {
                console.log(xhr.responseText);
            }
        });

    }

    /*
     * Checks whether the user's input was verified 
     * @param {string} data
     */
    function is_verified(data) {
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
        return verified;
    }

    //Action to take once the credentials have been authenticated
    function verifiedAction(verified,data) {
        let btn = $('#sign-in-btn');
        console.log(verified);

        //Clear the current button class
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

    /*
     * Generic redirection method
     * @param {string} data
     */
    function redirect(data) {
        location.href(base_url + data);
    }

});