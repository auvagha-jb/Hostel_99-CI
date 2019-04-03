<script src="<?= assets_url('js/forms.js');?>"></script>

<div class="container-fluid">
    <!--Form-->
    <div class="row">
        
        <div class="col-md-6 col-sm-12">
            <img src="<?= assets_url('img/background2.png');?>" class="img-responsive sign-up-img" >
            <div class="top-left display-4 text"><p>Join the H99 Community! <br>It's free for life.</p></div>
        </div>
        
        <div class="col-md-6 col-sm-12">
            <div class="form-data">              
                <form action="<?= base_url('user_ctrl/sign_up_action');?>" method="post" class="sign-up">
                     <h4 class="lead">Sign up</h4>
                    
                    <div class="row">
                        <div class="col-md-6"> 
                        <div class="form-group">
                            <label for='first_name'>First name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" required>
                        </div>
                        </div> 

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" required>
                            </div>
                         </div>
                     </div>
                     
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                        <div class="invalid-feedback">Email address already exists</div>
                    </div>
                                          
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pwd" id="pwd" class="form-control" required>
                        <div class="invalid-feedback" id="password-feedback"></div>
                    </div>
                     
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_pwd" id="confirm_pwd" class="form-control" required>
                        <div class="invalid-feedback" id="confirm-pwd-feedback"></div>
                    </div>
                     
                    <div class="form-group">
                        <label>Phone Number</label>          
                            <div class="input-group">
                                <?php 
                                    //select list of country codes
                                    country_codes();
                                 ?>
                                <div class="input-group-append">
                                    <input type="number" name="no" id="no" class="form-control" required>
                                </div>
                            </div>
                        <small class="form-small-text">e.g 0722 123 456 will be +254 722 123 456</small>    
                    </div>
                     
                     <div class="form-group">
                         <select name="gender" id="gender" class="form-control" required>
                             <option value="">Gender</option>
                             <option value="male">Male</option>
                             <option value="female">Female</option>
                         </select>
                     </div>
                     
                     <div class="form-group">
                         <select name="user_type" id="user_type" class="form-control" required>
                             <option value="">Occupation</option>
                             <option value="Student">Student</option>
                             <option value="Hostel Owner">Hostel Owner</option>
                         </select>
                     </div>
                     
                     <div class="form-group owner_auth d-none">
                         <input type="password" class="form-control"  id="auth_pwd" placeholder="Enter your authentication code">
                         <div class="invalid-feedback" id="owner_invalid"></div>
                         <div class="valid-feedback" id="owner_valid"></div>
                     </div>
                     
                     <button type="submit" name="s-u-submit" id="s-u-submit" class="btn btn-primary">Join H99</button>
                </form>
            </div>
        </div>
    </div>
    </div>





