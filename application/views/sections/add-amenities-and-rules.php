    <div>
        <!--Gives user feedback on form submit-->
        <div id="feedback">
            
        </div>
<!--        action="php/owner-add-hostel-action.php" id="add-hostel-form" -->
            <div class="table-responsive">
                <div id="amenities-feedback"></div>
                <table class="table table-bordered" id="add-amenities-tbl">
                    <thead>
                        <tr>
                        <th>Amenities</th>
                        <th>Add</th>
                        <th>Delete</th>
                        </tr>
                    </thead>    
                    <tr>                        
                        <td><input type="text" name="amenities[]" id="amenities" class="form-control" required></td>
                        <td><button type="button" class="btn btn-success btn-sm add-amenity"><i class="fa fa-plus"></i></button></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-amenity" id="first_amenity"><i class="fa fa-minus"></i></button></td>
                    </tr>
                </table>
                <div id="rules-feedback"></div>
                <table class="table table-bordered" id="add-rules-tbl">
                    <thead>
                        <tr>
                        <th>Rules</th>
                        <th>Add</th>
                        <th>Delete</th>
                        </tr>
                    </thead>    
                    <tr>                        
                        <td><input type="text" name="rules[]" id="rules" class="form-control" required></td>
                        <td><button type="button" class="btn btn-success btn-sm add-rule"><i class="fa fa-plus"></i></button></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-rule" id="first_rule"><i class="fa fa-minus"></i></button></td>
                    </tr>
                </table>
            </div>
    </div>