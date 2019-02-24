<?php
    $user_id = $row['user_id'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $country_code = $row['country_code'];
    $phone_no = $row['phone_no'];
?>
<script src="<?= assets_url('js/forms.js');?>"></script>
<!--        My Details-->
<!--    forms.css-->

    <div class="container-fluid">
    <!--Form-->
    <div class="row">
        
        <div class="col-md-6 col-sm-12">
            <img src="<?= assets_url('img/background2.png');?>" class="img-responsive sign-up-img" >
            <div class="top-left display-4"><p style="color: white;">Keep us up to date</p></div>
        </div>
        
        <div class="col-md-6 col-sm-12">
            <div class="form-data">                       
                <form action="<?= base_url('student/update_details');?>" method="post" class="update">
                    <!--Hidden-->
                    <input type="hidden" id="user_id" value="<?= $user_id;?>">
                    
                    <div class="row">
                        <div class="col-md-6"> 
                        <div class="form-group">
                            <label for='first_name'>First name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $first_name;?>" required>
                        </div>
                        </div> 

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="<?= $last_name;?>" required>
                            </div>
                         </div>
                     </div>
                     
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" required value="<?= $email;?>">
                        <div class="invalid-feedback">Email address already exists</div>
                    </div>
                        
                     
                    <div class="form-group">
                        <label>Phone Number</label>          
                            <div class="input-group">
                                <!--List of country codes-->
                                <?php country_codes();?>
                                <div class="input-group-append">
                                    <input type="number" name="phone_no" id="phone_no" class="form-control" required>
                                </div>
                            </div>
                        <small class="form-small-text">e.g 0722 123 456 will be +254 722 123 456</small>    
                    </div>
                     <button type="submit" name="update_submit" id="s-u-submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
            
        </div>
        
    </div>
    
    </div>
    <script>
    $(document).ready(function(){
       var country_code = "<?= $country_code;?>";
       var no = "<?= $phone_no;?>";
        setPhoneNo(country_code,no);
       
       function setPhoneNo(country_code,no){
           $("#country_code").val(country_code);
           $("#phone_no").val(no);
       }
       
    });
    </script>
    

