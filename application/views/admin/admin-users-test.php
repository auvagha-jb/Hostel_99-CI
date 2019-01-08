<center class="alert alert-success fixed-top hide" id="users-success"></center>

<!--Inner navigation bar to switch between tables-->
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="true">Users</a>
        <a class="nav-item nav-link" id="suspended-users-tab" data-toggle="tab" href="#suspended-users" role="tab" aria-controls="suspended-users" aria-selected="true">Suspended</a>
    </div>
</nav>

<!--Tab wrapper-->
<div class="tab-content" id="nav-tabContent">
    <!--Users table-->
    <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
        <div class="w3-main" style="margin:20px 20px;">
            <div class="usersTable">
                <h2>Registered Users</h2>
                <table class='w3-table-all w3-centered w3-hoverable admin-table' id="users-table">
                    <thead>
                        <?php headerRows('Suspend'); ?>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Suspended users-->
    <div class="tab-pane fade show" id="suspended-users" role="tabpanel" aria-labelledby="suspended-users-tab">
        <div class="w3-main" style="margin:20px 20px;">
            <div class="usersTable">
                <h2>Suspended Users</h2>
                <table class='w3-table-all w3-centered w3-hoverable admin-table' id="suspended-users-table">
                    <thead>
                        <?php headerRows('Restore'); ?>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                
                
                
                <?php
                function headerRows($last_col) {
                    echo "<tr>";
                    echo "<th>User ID</th>";
                    echo "<th>Name</th>";
                    echo "<th>Email Address</th>";
                    echo "<th>User Type</th>";
                    echo "<th>Room Assigned</th>";
                    echo "<th>Status</th>";
                    echo "<th>Delete</th>";
                    echo "<th>".$last_col."</th>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!--Tab wrapper-->
