
<center class="lead my-3" id="no-bookings-msg">
    No bookings at the moment.
</center>

<center id="bookings-feedback"></center>

<!--User show bookings table-->
<!-- DataTables Example -->
<div class="card mb-3">
    <div class="card-header bg-dark text-white">
        <i class="fas fa-table"></i>
        <span id="table-content">Bookings</span>
    </div>
    <div class="card-body">

        <div class="table-responsive mx-3 my-3">
            <table class="table table-sm table-hover" id="bookings-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Phone number</th>
                        <th>Email</th>
                        <th>Room Chosen</th>
                        <th>No sharing</th>
                        <th>Add</th>
    <!--                    <th>Cancel</th>-->
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div> 
        <!-- Confirm delete Modal -->
        <div class="modal fade" id="confirmAddModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add new tenant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="add_dialog">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="confirm_add" data-dismiss="modal">Add</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#wrapper -->
    </div>
</div>        