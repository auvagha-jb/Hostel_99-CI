<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Owner_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('actions/booking_model', 'booking_model');
        $this->load->model('actions/remove_tenant', 'remove');
    }

    /*     * **Action: Add hostel*** */

    function hostel_exists($hostel_name) {
        $this->db->where('hostel_name', $hostel_name);
        $query = $this->db->get('hostels');

        if ($query->num_rows() > 0) {
            echo 'name-exists';
        } else {
            echo 'all-good';
        }
    }

    function add_hostel_action() {
        //Get form data 
        $details = array(
            'hostel_no' => $this->gen_hostel_no(), //Generate a hostel_no randomly 
            'hostel_name' => $this->input->post('hostel_name'),
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location'),
            'road' => $this->input->post('road'),
            'county' => $this->input->post('county'),
            'type' => $this->input->post('hostel_type'),
            'image' => $_FILES['image']['name']
        );

        /*         * Dynamic input arrays* */
        $sharing_array = $this->input->post('no_sharing');
        $rent_array = $this->input->post('monthly_rent');
        $limit_array = $this->input->post('room_limit');

        $amenities = $this->input->post('amenities');
        $rules = $this->input->post('rules');

        /*         * ************** */

        /* Begin transcation: Ensures changes are rolled back if any query fails */
        $this->db->trans_start();

        /* The core hostel details */
        $this->add_hostel_details($details);

        $this->add_room_details($sharing_array, $rent_array, $limit_array);
        $this->add_amenities($amenities);
        $this->add_rules($rules);
        $this->update_user_hostel_bridge();

        /* End the transcation */
        $this->db->trans_complete();

        //Given the transcation is successful...
        if ($this->db->trans_status()) {
            redirect('owner/dashboard?id=' . $details['hostel_no'] . '&type=' . $details['type'] .
                    '&hostel_name=' . $details['hostel_name']);
        }
    }

    function add_hostel_details(&$details) {

        //Set session variables
        $_SESSION['hostel_no'] = $details['hostel_no'];
        $_SESSION['hostel_name'] = $details['hostel_name'];
        $_SESSION['type'] = $details['type'];

        $this->uploadImage($details['hostel_name']);

        //Insert data into database
        $this->db->insert('hostels', $details);
    }

    function add_room_details(&$sharing_array, &$rent_array, &$limit_array) {
        //Find the number of items to insert
        $array_size = count($sharing_array);
        $hostel_capacity = 0; //To record the total number of people the hostel can hold
        $hostel_no = $_SESSION['hostel_no'];

        for ($count = 0; $count < $array_size; $count++) {
            //Get the form data
            $no_sharing = $sharing_array[$count];
            $monthly_rent = $rent_array[$count];
            $room_limit = $limit_array[$count];

            //Tally the hostel capacity
            $current_capacity = 0;
            $room_capacity = $no_sharing * $room_limit;
            $hostel_capacity = $hostel_capacity + $room_capacity; //This will get the grand total of available slots
            //Data to be inserted
            $data = array(
                'hostel_no' => $hostel_no,
                'no_sharing' => $no_sharing,
                'monthly_rent' => $monthly_rent,
                'room_limit' => $room_limit,
                'current_capacity' => $current_capacity,
                'total_capacity' => $room_capacity
            );

            $this->db->insert('rooms', $data);
        }

        $this->setCapacity($hostel_no, $hostel_capacity);
    }

    function add_amenities($amenities) {
        //Find the number of items to insert
        $array_size = count($amenities);
        $hostel_no = $_SESSION['hostel_no'];

        for ($count = 0; $count < $array_size; $count++) {
            //"INSERT INTO `amenities`(`hostel_no`, `amenity`) VALUES (?,?)";
            $insert_data = array(
                'hostel_no' => $hostel_no,
                'amenity' => $amenities[$count]
            );
            $this->db->insert('amenities', $insert_data);
        }
    }

    function add_rules($rules) {
        //Find the number of items to insert
        $array_size = count($rules);
        $hostel_no = $_SESSION['hostel_no'];

        for ($count = 0; $count < $array_size; $count++) {
            //"INSERT INTO `rules`(`hostel_no`, `rule`) VALUES (?,?)";
            $insert_data = array(
                'hostel_no' => $hostel_no,
                'rule' => $rules[$count]
            );
            $this->db->insert('rules', $insert_data);
        }
    }

    function update_user_hostel_bridge() {
        //Update the junction table: user_hostel_bridge
        $user_id = $_SESSION['user_id'];
        $hostel_no = $_SESSION['hostel_no'];
        $hostel_name = $_SESSION['hostel_name'];
        $type = $_SESSION['type'];

        //INSERT INTO `user_hostel_bridge`(`user_id`, `hostel_no`) VALUES(?,?)
        $insert_data = array(
            'user_id' => $user_id,
            'hostel_no' => $hostel_no
        );
        $this->db->insert('user_hostel_bridge', $insert_data);
    }

    /*     * *Add Hostel helpers * */

    function gen_hostel_no() {
        $hostel_no = mt_rand();

        do {
            $query = $this->db->get_where('hostels', array('hostel_no' => $hostel_no));
            $row_count = $query->num_rows();
        } while ($row_count > 0);

        return $hostel_no;
    }

    function setCapacity($hostel_no, $hostel_capacity) {
        //UPDATE hostels SET total_available = ?, total_occupied = ?, vacancies = ? WHERE hostel_no = ?

        $total_occupied = 0;
        $vacancies = $hostel_capacity - $total_occupied;

        $update_data = array(
            'total_available' => $hostel_capacity,
            'total_occupied' => $total_occupied,
            'vacancies' => $vacancies
        );

        $this->db->where('hostel_no', $hostel_no);
        $this->db->update('hostels', $update_data);
    }

    /*     * *End: Add Hostel helpers * */


    /*     * ******End: Add hostel******** */

    /** Action: View hostels * */
    function view_hostels($user_id) {
        $sql = "SELECT * FROM `users` JOIN user_hostel_bridge ON users.user_id = user_hostel_bridge.user_id "
                . "JOIN hostels ON hostels.hostel_no = user_hostel_bridge.hostel_no WHERE users.user_id = ?";

        $query = $this->db->query($sql, $user_id);
        return $query;
    }

    /** Action: Edit hostels * */
    function edit_hostel() {
        //Previous form data
        $hostel_no = $this->input->post('hostel_no');
        $hostel_name = $this->input->post('hostel_name');

        //Get form data  
        $details = array(
            'description' => $this->input->post('description'),
            'location' => $this->input->post('location'),
            'road' => $this->input->post('road'),
            'county' => $this->input->post('county'),
            'type' => $this->input->post('hostel_type')
        );

        //Update the details
        $this->db->where('hostel_no', $hostel_no);
        if ($this->db->update('hostels', $details)) {
            echo 'Done: ' . $this->db->last_query() . '\n';
        }


        //Handling image data        
        $image = $_FILES['image']['name'];
        $upload_data = array(
            'image' => $image
        );

        if (!empty($image)) {
            $this->uploadImage($hostel_name);

            $this->db->where('hostel_no', $hostel_no);
            if ($this->db->update('hostels', $upload_data)) {
                echo 'Done: ' . $this->db->last_query() . '\n';
            }
        }
    }

    /*     * ********Owner Dashboard********* */

    //Tenants table
    function showTenants($hostel_no) {
        $select = 'SELECT * FROM users JOIN user_hostel_bridge ON users.user_id = user_hostel_bridge.user_id '
                . 'WHERE user_hostel_bridge.hostel_no = ? AND users.user_status = "Tenant" AND users.user_type = "Student" '
                . 'ORDER BY room_assigned';

        $query = $this->db->query($select, $hostel_no);
        $data = "";
        if ($query->num_rows() < 1) {
            echo '';
        } else {
            foreach ($query->result_array() as $row) {
                $user_id = $row['user_id'];
                $name = $row['first_name'] . " " . $row['last_name'];
                $email = $row['email'];
                $phone_no = "+" . $row['country_code'] . $row['phone_no'];
                $gender = $row['gender'];
                $room_assigned = $row['room_assigned'];
                $no_sharing = $row['no_sharing'];
                $blocked = $row['blocked'];
                $bg = "";

                if ($blocked == 1) {
                    $bg = "bg-warning";
                }

                $data.='
            <tr class="' . $bg . '">
                <td>' . $user_id . '</td>
                <td>' . $name . '</td>
                <td>' . $email . '</td>
                <td>' . $phone_no . '</td>
                <td class="capitalize">' . $gender . '</td>
                <td>' . $room_assigned . '</td>
                <td>' . $no_sharing . '</td>
                <td>
                    <button href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDelModal" id="confirm_del">
                        <i class="fa fa-minus-circle"></i>
                    </button>
                </td>
            </tr>  
            ';
            }
        }

        echo json_encode($data);
    }

    //Bookings table
    function showBookings($hostel_no) {
        $select = 'SELECT * FROM users JOIN bookings ON users.user_id = bookings.user_id WHERE '
                . 'hostel_no = ? AND users.user_status IS NULL';

        $query = $this->db->query($select, $hostel_no);

        $data = "";
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $user_id = $row['user_id'];
                $name = $row['first_name'] . " " . $row['last_name'];
                $gender = $row['gender'];
                $phone_no = '+' . $row['country_code'] . ' ' . $row['phone_no'];
                $email = $row['email'];
                $room_chosen = $row['room_chosen'];
                $no_sharing = $row['no_sharing'];
                //$check_in_date = $row['check_in_date'];

                $data.='
                <tr>
                    <td>' . $user_id . '</td>
                    <td>' . $name . '</td>
                    <td class="capitalize">' . $gender . '</td>
                    <td>' . $phone_no . '</td>
                    <td>' . $email . '</td>
                    <td>' . $room_chosen . '</td>
                    <td>' . $no_sharing . '</td>
                    <td><a href="#" class="btn btn-success btn-sm add-tenant" id="add-tenant">
                        <i class="fa fa-plus-circle"></i>
                        </a>
                     </td>
                </tr>  
                ';
            }
        }
        echo json_encode($data);
    }

    //Fetch the rooms
    function fetchRooms($hostel_no) {
        //SELECT * FROM `room_allocation` WHERE hostel_no = ? ORDER BY room_no, wing
        $this->db->where('hostel_no', $hostel_no);
        $this->db->order_by('room_no ASC', 'wing ASC');
        $query = $this->db->get('room_allocation');

        $data = "";

        foreach ($query->result_array() as $row) {
            $no_occupied = $row['no_occupied'];
            $spaces = $row['spaces'];
            $room_no = $row['room_no'];
            $wing = $row['wing'];
            $colour = $this->getColour($wing, $no_occupied);
            $status = $this->roomStatus($no_occupied, $spaces);

            $data.='
                <div data-dismiss="modal" class="col-3">
                    <div class="card text-white mx-3 my-3 bg-' . $colour['bg'] . ' border-' . $colour['border'] . '" id="' . $room_no . '">
                      <div class="card-header">Room ' . $room_no . '</div>
                      <div class="card-body">
                          <div class="card-title">' . $status . '</div>
                      </div>
                    </div>
                </div>
                ';
        }
        echo json_encode($data);
    }

    function roomStatus($no_occupied, $spaces) {
        //Choose status message
        if ($no_occupied == 0) {
            $status = "Empty";
        } else if ($spaces == 0) {
            $status = "Full";
        } else {
            $status = "Room for " . $spaces;
        }
        return $status;
    }

    function availableRooms($data) {
        $wing = $data['gender']; //Because there is either a male or female wing
        $no_sharing = $data['no_sharing'];
        $hostel_no = $data['hostel_no'];

        $output = "";
        $sql = 'SELECT * FROM `room_allocation` WHERE wing = ? AND no_sharing = ? AND hostel_no = ? AND spaces > 0';
        $param = array($wing, $no_sharing, $hostel_no);
        $query = $this->db->query($sql, $param);
        $results = $query->num_rows();

        if ($results > 0) {
            foreach ($query->result_array() as $row) {
                $no_occupied = $row['no_occupied'];
                $spaces = $row['spaces'];
                $room_no = $row['room_no'];
                $colour = $this->getColour($wing, $no_occupied);
                $status = $this->roomStatus($no_occupied, $spaces);

                $output.='
                <div data-dismiss="modal">
                    <div class="card text-white mx-3 my-3 bg-' . $colour['bg'] . '" id="' . $room_no . '">
                      <div class="card-header">Room ' . $room_no . '</div>
                      <div class="card-body">
                          <div class="card-title">' . $status . '</div>
                      </div>
                    </div>
                </div>
                ';
            }
        } else {
            $output.= '<center class="lead">No rooms available for ' . $no_sharing . ' sharing</center>';
        }

        echo json_encode($output);
    }

    function noRooms($no) {
        $data = '<center class="lead">No rooms available for ' . $no . ' sharing</center>';
        return $data;
    }

    function getColour($wing, $no_occupied) {
        //Choose background and border colour
        if ($no_occupied == 0) {
            $bg = "secondary";
            if ($wing === "male") {
                $border = "primary";
            } else {
                $border = "danger";
            }
        } else {
            if ($wing == "male") {
                $bg = "primary";
            } else {
                $bg = "danger";
            }
            $border = $bg;
        }

        $colours = array(
            'border' => $border,
            'bg' => $bg
        );
        return $colours;
    }

    //End: Fetch rooms


    /*     * ***Image handling****** */

    function uploadImage($hostel_name) {
        /*
         * Specify the file path and create a folder if it doesn't exist
         */
        $dir = './uploads/' . $hostel_name;

        if (!file_exists($dir)) {
            mkdir($dir);
        }

        /*
         * Load the library with the specified configurations
         * Alt:$this->load->library('upload',$config); 
         */
        $config = array(
            'upload_path' => $dir,
            'allowed_types' => 'gif|jpg|jpeg|png|bmp'
        );

        $this->upload->initialize($config);

        $success = $this->upload->do_upload('image');

        return $success;
    }

    function removeImage($data) {
        $path = $data['folder_name'] . '/' . $data['hostel_name'] . '/' . $data['file_name'];
        if (!unlink($path)) {
            echo json_encode("Error found");
        } else {
            echo json_encode("Deleted");
        }
    }

    function fetchPhotos($data) {
        $folder_name = $data['folder_name'];
        $hostel_name = $data['hostel_name'];
        //Scans the named folder and returns file names
        $files = scandir($folder_name . '/' . $hostel_name);

        $output = '<div class="row">';

        //This will check whether there is an error with the scandir() function
        if (false !== $files) {
            foreach ($files as $file) {
                //This condition will ignore a single dot and double dot file
                if ('.' != $file && '..' != $file) {
                    $output .= '
                <div class="col-md-2">
                 <img src="' . uploads_url($hostel_name . '/' . $file . '') . '" class="img-thumbnail" width="275" height="275" style="height:175px;" />
                 <button type="button" class="btn btn-outline-danger btn-sm remove_image" id="' . $file . '">Remove</button>
                    <p>' . $file . '</p>
                </div>
                ';
                }
            }
        } else {
            $output.= '<center class="lead">No photos posted yet! Click or Drag and drop above</center>';
        }
        $output .= '</div>';
        echo json_encode($output);
    }

    /*     * ******End: Image handling******** */


    /*     * ***Action: Add tenant****** */

    //Ensure the user meets the criteria to be added as a tenant
    function verifyUser($data) {
        /*         * *****Post data****** */
        $hostel_no = $data['hostel_no'];
        $no_sharing = $data['no_sharing'];
        $email = $data['email'];
        $room_assigned = $data['room_assigned'];
        /*         * ****End: Post data****** */

        /*         * ****Database arrays***** */
        $user_where = array('email' => $email);
        $user = $this->table_model->getArray('users', $user_where); //Data about the user

        $room_where = array('hostel_no' => $hostel_no, 'no_sharing' => $no_sharing);
        $room = $this->table_model->getArray('rooms', $room_where); //General data about the room

        $tr_where = array('hostel_no' => $hostel_no, 'room_no' => $room_assigned);
        $this_room = $this->table_model->getArray('room_allocation', $tr_where); //Specific data about the the room
        /*         * ****End: Database arrays***** */

        /*         * *If the user is found ...** */
        if (!empty($user)) {
            $user_id = $user['user_id'];

            //Data about the hostel they are staying in
            $hostel_where = array('hostel_no' => $hostel_no);
            $hostel = $this->table_model->getArray('hostels', $hostel_where);
            //$isTenant = $this->isTenant($user['user_status']);


            /*
             * Check status to ensure they are not already a tenant in the current  
             * nor in another hostel and that they are of "student" type
             * 
             * @param $user{array} -->user details
             * @param $hostel{array} -->hostel details
             */
            $this->userElidgible($user, $hostel);


            /*
             * Had the user made a booking?
             * Actions to take if they had made a booking 
             */
            $booked = false;
            $booking_row = $this->booking_model->userBooked($user_id);

            if (isset($booking_row)) {
                $booked = true;
            }

            /*             * Testing transactions* */
            $this->db->trans_start();

            if ($booked) {
                /* Change status from booked to tenant */
                $this->booking_model->updateBooking($user_id);
            } else {//If they hadn't booked...
                /* Check whether vacancy is present */
                $vacant = $this->booking_model->vacancyPresent($user, $room);
                $action = "add-tenant";

                if (!$vacant) {
                    echo 'No more vacancies available for ' . $no_sharing . ' sharing';
                } else {
                    //Reduce the number of available slots in the hostel
                    $this->booking_model->updateVacancies($hostel, $room, $user, $action);

                    //Allocate rooms
                    $this->booking_model->updateRooms($this_room, $hostel, $data, $action);

                    echo ''; //Cleared for insert into database
                }
            }
        } else {
            echo "User email does not exist";
            exit();
        }
        //Commit or rollback the changes based on the success of the queries
        $this->db->trans_complete();
    }

    function userElidgible(&$user, &$hostel) {
        $name = $user['first_name'] . " " . $user['last_name'];
        $user_status = $user['user_status'];
        $user_type = $user['user_type'];
        $gender = $user['gender'];

        $hostel_no = $this->session->hostel_no;
        $hostel_name = $hostel['hostel_name'];
        $hostel_reg = $hostel['hostel_no'];
        $type = $hostel['type'];

        /*
         * if 1-To ensure the user was not already a tenant either in another hostel or your hostel
         * if-2 to ensure the user is registered as a student
         * if 3 - to ensure the user is of the right gender
         */
        if ($user_status == "Tenant") {
            if ($hostel_no !== $hostel_reg && $hostel_reg !== "") {
                echo $name . " is still registered as a tenant in " . $hostel_name;
                exit();
            } else {
                echo $name . " is already registered as a tenant in your hostel";
                exit();
            }
            //To ensure that the user registered as a student 
        } else if ($user_type != "Student") {
            echo $name . " is is not a student. User type: " . $user_type;
            exit();
            //To ensure the person is of the right gender
        } else if ($type != $gender && $type != "Mixed") {
            echo $name . " is " . $gender . ". If you admit both genders change hostel type to mixed";
            exit();
        }
    }

    //Addition of the tenant into the hostel records
    function addTenant(&$data) {
        //Form data
        $email = $data['email'];
        $room_assigned = $data['room_assigned'];
        $no_sharing = $data['no_sharing'];

        //Get the user data from the db
        $get = $this->table_model->getArray('users', array('email' => $email));
        $user_id = $get['user_id'];
        $name = $get['first_name'] . " " . $get['last_name'];

        //Begin transaction 
        $this->db->trans_start();

        //Change user_status from NULL to Tenant
        $this->changeStatus($email, $room_assigned, $no_sharing);

        //Insert data into respective tables: tenants_history and 
        $this->insertQueries($user_id, $hostel_no);

        $this->db->trans_complete();

        //Commit the queries if there were no errors encountered
        $status = $this->db->trans_status();
        if ($status == 1) {
            echo $name . ' has been added';
        }
    }

    function insertQueries($user_id, $hostel_no) {
        /*
         * TENANT_HISTORY 
         */
        date_default_timezone_set('Africa/Nairobi');
        $date_checked_in = date('Y-m-d H:i:s');

        //$insert_1 = "INSERT INTO `tenant_history`(`hostel_no`, `date_checked_in`) VALUES (?,?,?)";
        $th_data = array(
            'hostel_no' => $hostel_no,
            'date_checked_in' => $date_checked_in
        );
        $this->db->insert('tenant_history', $th_data);


        /*
         * TENANT_HISTORY_BRIDGE table
         * INSERT user_id, hostel_no AND record_id  
         */
        //$insert_2 = "INSERT INTO tenant_history_bridge (user_id, record_id) VALUES(?,?)";
        $record_id = $this->db->insert_id();
        $thb_data = array(
            'record_id' => $record_id,
            'user_id' => $user_id
        );
        $this->db->insert('tenant_history_bridge', $thb_data);


        /*
         * USER_HOSTEL_BRIDGE table
         * INSERT user_id, hostel_no AND record_id  
         */
        $uhb_data = array(#
            'hostel_no' => $hostel_no,
            'user_id' => $user_id,
            'record_id' => $record_id
        );
        $this->db->insert('user_hostel_bridge', $uhb_data);
    }

    function changeStatus($email, $room_assigned, $no_sharing) {
        //$query = 'UPDATE users SET user_status = "Tenant", room_assigned = ?, no_sharing = ? WHERE email = ?';
        $update_data = array(
            'user_status' => "Tenant",
            'room_assigned' => $room_assigned,
            'no_sharing' => $no_sharing
        );
        $this->db->where('email', $email);
        $this->db->update('users', $update_data);
    }

    //Show the room details for a wing
    function showRooms($gender) {
        $hostel_no = $this->session->hostel_no;

        //$query_1 = "SELECT no_sharing FROM rooms WHERE hostel_no = ?";
        $cond = array('hostel_no' => $hostel_no);
        $no_sharing = $this->table_model->getRowQuery('rooms', array('no_sharing'), $cond);

        foreach ($no_sharing->result_array() as $room) {
            $no_sharing = $room['no_sharing'];

            if (isset($gender)) {//room information for a specific wing
                $wing = $gender;
                $sql = 'SELECT COUNT(*) AS count FROM room_allocation WHERE spaces > 0 '
                        . 'AND wing = ? AND no_sharing = ? AND hostel_no = ?';

                $param = array($wing, $no_sharing, $hostel_no);
                $count_query = $this->db->query($sql, $param);

                foreach ($count_query->result_array() as $row) {
                    $count = $row['count'];
                    echo'
                    <span class="lead inline-text mx-3">
                        ' . $no_sharing . ' Sharing:
                        <span class="border px-2">' . $count . '</span>
                    </span>
                        ';
                }
            }
        }
    }

    /*     * ******End: Add tenant********** */

    function removeTenant() {
        //Form data
        $user_id = $this->input->post('user_id');
        $name = $this->input->post('name');
        $room_assigned = $this->input->post('room_assigned');
        $no_sharing = $this->input->post('no_sharing');
        $hostel_no = $this->session->hostel_no;
        
        $data = array(
            'user_id' => $user_id,
            'room_assigned' => $room_assigned,
            'no_sharing' => $no_sharing
        );

        //Table conditions
        $hostel_where = array('hostel_no'=>$hostel_no);
        $room_where = array('hostel_no'=>$hostel_no,'no_sharing'=>$no_sharing);
        $tr_where = array('hostel_no'=>$hostel_no,'room_no'=>$room_assigned);
        $user_where = array('user_id'=>$user_id);
        
        //Get data from different tables-->Table name = First param
        $hostel = $this->table_model->getArray('hostels',$hostel_where);
        $room = $this->table_model->getArray('rooms',$room_where);
        $this_room = $this->table_model->getArray('room_allocation',$tr_where);
        $user = $this->table_model->getArray('users',$user_where);

        //Get the record id for specific user
        $record_arr = $this->table_model->getRows('user_hostel_bridge', array('record_id'), $user_where);
        $record_id = $record_arr['record_id'];

        date_default_timezone_set('Africa/Nairobi');
        $date_checked_out = date('Y-m-d H:i:s');

        /*
         * Start transaction
         * Note: remove =  model. Path: actions/remove_tenant 
         */
        $this->db->trans_start();
        
        //Update users table
        $this->remove->updateUsers($user_id);

        //Update tenant history table
        $this->remove->updateHistory($record_id, $date_checked_out);

        //Delete user_id from user_tenant_bridge
        $this->remove->deleteFromBridge($user_id);

        //Free up one slot on the database
        $this->remove->updateVacancies($hostel, $room, $user);

        //Update the room_allocation
        $this->remove->updateRooms($this_room, $hostel, $data);

        //Remove them from ooking table
        $this->table_model->deleteRow('bookings', array('user_id'=>$user_id));

        //End the transaction
        $this->db->trans_complete();
        
        //If all queries are successfully executed...
        if ($this->db->trans_status() == 1) {
            echo $name . ' has been removed as a tenant';
        } 
    }

}
