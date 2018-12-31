<div class="add-room-section">
        <!--Gives user feedback on form submit-->
        <div id="rooms-feedback">
            
        </div>        
<!--        action="php/owner-add-hostel-action.php" id="add-hostel-form" --> 
            <div class="table-responsive">
                <table class="table table-bordered" id="add-room-tbl">
                    <thead>
                        <tr class="first">
                        <th>Number Sharing</th>
                        <th>Monthly Rent</th>
<!--                        <th>Number of Occupants</th>-->
<!--                        <th>Rooms occupied</th>-->
                        <th>Limit</th>
                        <th>Add</th>
                        <th>Delete</th>
                        </tr>
                    </thead>    
                    <tr class="first">                        
                        <td><input type="number" name="no_sharing[]" id="no_sharing" class="form-control" required></td>
                        <td><input type="number" name="monthly_rent[]" id="monthly_rent" class="form-control" required></td>
                        <td><input type="number" name="room_limit[]" id="room_limit" class="form-control" required></td>
                        <td><button type="button" class="btn btn-success btn-sm add-room"><i class="fa fa-plus"></i></button></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-room" id="first_row"><i class="fa fa-minus"></i></button></td>
                    </tr>
                </table>
            </div>

<!--                <td><input type="number" name="total_occupants[]" id="total_occupants" class="form-control" required></td>
                        <td><input type="number" name="no_rooms_occupied[]" id="no_rooms_occupied" class="form-control" required></td>-->
    </div>