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
                <?php
                //Display table
                echo "<h2>Registered Users</h2>";
                echo " <table class='w3-table-all w3-centered w3-hoverable admin-table'>";
                headerRows();
                echo "<th>Suspend</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($users->result_array() as $row) {
                    if ($row['blocked'] == 0) {
                        showTable($row);
                        echo '<td i><a href="admin/user_suspend?id=' . $row['user_id'] . '"><i class="fas fa-lock-open"></i></td>';
                        echo "</tr>";
                    }
                }
                echo "</tbody>";
                echo "</table>";
                ?>
            </div>
        </div>
    </div>

    <!--Suspended users-->
    <div class="tab-pane fade show" id="suspended-users" role="tabpanel" aria-labelledby="suspended-users-tab">
        <div class="w3-main" style="margin:20px 20px;">
            <div class="usersTable">
                <?php
                //Display table
                echo "<h2>Suspended Users</h2>";
                echo " <table class='w3-table-all w3-centered w3-hoverable admin-table'>";
                headerRows();
                echo "<th>Restore</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($users->result_array() as $row) {
                    if ($row['blocked'] == 1) {
                        showTable($row);
                        echo '<td i><a href="admin/user_restore?id=' . $row['user_id'] . '"><i class="fas fa-lock-open"></i></td>';
                        echo "</tr>";
                    }
                }
                echo "</tbody>";
                echo "</table>";

                function headerRows() {
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>User ID</th>";
                    echo "<th>Name</th>";
                    echo "<th>Email Address</th>";
                    echo "<th>User Type</th>";
                    echo "<th>Room Assigned</th>";
                    echo "<th>Delete</th>";
                }

                function showTable($row) {
                    $id = $row['user_id'];
                    $name = $row['first_name'] . " " . $row['last_name'];
                    $status = $row['user_status'];
                    
                    echo "<tr>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $name . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['user_type'] . "</td>";
                    echo "<td>" . $row['room_assigned'] . "</td>";
                    echo '<td class="delete"><a href="'.base_url('admin/user_delete/'.$id.'/'.$name.'/'.$status).'" class="btn btn-danger"><i class="fa fa-trash-alt"></i></td>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!--Tab wrapper-->
