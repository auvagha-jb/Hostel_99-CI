<!--Custom Js-->     
<script src="<?= assets_url('js/forms.js');?>"></script>
<!--Custom Js-->


<!--Form-->
    <div class="container-fluid padding">
        <form method="post" action="<?= base_url('user_ctrl/sign_in_action');?>" class="sign-in">
            <div class="lead form-text">Sign in</div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" name="email" id="email" class="form-control" required="">
                <div class="invalid-feedback" id="email-feedback">Invalid email address</div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="pwd" id="pwd" class="form-control" required="">
                <div class="invalid-feedback">Incorrect password</div>
            </div>
            <button  class="btn btn-secondary" id="sign-in-btn">Sign in</button>
            
            <br>
            <small class="form-text">
                Don't have an account? <a href='<?= base_url('main/sign_up');?>'>Sign up</a>
            </small>
        </form>
        
    </div>
<script>
   $('body').addClass('sign-in'); 
</script>
</body>
</html>