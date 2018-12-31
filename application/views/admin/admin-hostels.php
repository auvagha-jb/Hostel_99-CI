<div class="w3-main" style="margin:20px 20px;">
    <div class="usersTable">
        <?php
        //Display table
                echo "<h2>Registered Hostels</h2>";
                
                echo " <table class='w3-table-all w3-centered w3-hoverable admin-table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Hostel Name</th>";
                echo "<th>Hostel Location</th>";
                echo "<th>Hostel Type</th>";
//                echo "<th>Remove</th>";
                echo "<th>Remove</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($hostels->result_array() as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['hostel_name'] ."</td>";
                    echo "<td>" . $row['location'] . "</td>";
                    echo "<td>" . $row['type'] . "</td>";
                    echo '<td><a href="hostel-delete.php?id=' . $row['hostel_no'] . '"><i class="far fa-trash-alt"></i></td>';
//                    echo '<td><a href="hostel-suspend.php?id1=' . $row['hostel_no'] . '"><i class="fas fa-lock-open"></i></td>';
                    echo "</tr>";
                }
            
            echo "</tbody>";
            echo "</table>";
        ?>
    </div>
</div>