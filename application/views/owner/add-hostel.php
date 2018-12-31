    <script src="<?= assets_url('js/owner-forms.js');?>"></script>
    <script src="<?= assets_url('js/owner/owner-add.js');?>"></script>
    
    <div id="add-feedback" class="alert alert-warning fixed-top top"></div>
    <div class="container-fluid">
        <div>
            <form method="post" class="add-hostel-form" id="add_hostel-form" action="<?= base_url('owner/add_hostel_action');?>" 
                  enctype="multipart/form-data">
                <center>
                    <i class="fa fa-hotel"></i>
                    <div class="lead">My Hostel</div>
                </center>
                <div class="form-group">
                    <label>Hostel Name</label>
                    <input type="text" name="hostel_name" id="hostel_name" class="form-control" required="">
                    <div class="invalid-feedback">Hostel name already exists</div>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="description" class="form-control" required=""></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label>Location</label>
                        <input type="text" name="location" id="location" class="form-control" required="">
                    </div>
                    <div class="col-md-6">
                        <label>County</label>
                        <input type="text" name="county" id="county" class="form-control" required="">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label>Road</label>
                        <input type="text" name="road" id="road" class="form-control" required="">
                    </div>
                    <div class="col-md-6">
                        <label>Type</label>
                        <select class="form-control" name="hostel_type" id="hostel_type" required="">
                            <option value="">Choose One</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Mixed">Mixed</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type='file' name="image" id="image" onchange="ValidateSingleInput(this);" class="form-control" required/>
                    <img src="#" alt="Choose an image to see the preview" id="image_display">
                </div>
                
                <!--Add room section-->
                <?php add_room();?>
                <!--Add rules and amenities section-->
                <?php add_amenities_and_rules();?>
                
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <center class="alert alert-danger hide" id="add-hostel-footer">Form has some invalid inputs</center>
            </form>
        </div>
    </div> 
    </body>
    </html>