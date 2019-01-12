<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('owner_model');
        $this->load->model('actions/booking_model');
        $this->load->model('actions/cart');
    }

    function hostelSearch($data) {
        //Get form data
        $location_home = $data['location_home'];
        $hostel_type = $data['hostel_type'];
        $max_price = $data['max_price'];

        //reinitialize hostel_type  --->The query will get all hostels that are NOT opposite gender 
        if ($hostel_type == "male") {
            $opposite = "female";
        } else {
            $opposite = "male";
        }

        /* SELECT hostels.hostel_no, hostels.hostel_name, hostels.image, hostels.description, hostels.location, hostels.road, MIN(rooms.monthly_rent) AS monthly_rent, MAX(rooms.no_sharing) AS no_sharing, hostels.vacancies FROM hostels JOIN rooms ON hostels.hostel_no = rooms.hostel_no WHERE (location = "Nairobi" OR county = "Nairobi" OR road = "Nairobi") AND (monthly_rent <= 10000 AND NOT type = "male") AND (hostels.vacancies>0) GROUP BY hostels.hostel_no ORDER BY monthly_rent */

        $sql = 'SELECT hostels.hostel_no, hostels.hostel_name, hostels.image, hostels.description, hostels.location, '
                . 'hostels.road, hostels.type, MIN(rooms.monthly_rent) AS monthly_rent, MAX(rooms.no_sharing) AS no_sharing, '
                . 'hostels.vacancies FROM hostels JOIN rooms ON hostels.hostel_no = rooms.hostel_no '
                . 'WHERE (location = ? OR county = ? OR road = ?) AND '
                . '(monthly_rent <= ? AND NOT type = ?) GROUP BY hostels.hostel_no '
                . 'ORDER BY monthly_rent ';


        $param = array($location_home, $location_home, $location_home, $max_price, $opposite);
        $query = $this->db->query($sql, $param);

        return $query;
    }

    public function getRooms($data) {
        //Data array contents
        $hostel_no = $data['hostel_no'];
        $gender = $data['gender'];

        $sql = 'SELECT * FROM hostels JOIN rooms ON hostels.hostel_no = rooms.hostel_no WHERE hostels.hostel_no = ? '
                . 'AND rooms.blocked_' . $gender . ' > rooms.' . $gender . '_count OR blocked_' . $gender . '= 0';
        $param = array($hostel_no);
        $query = $this->db->query($sql, $param);

        return $query;
    }

    /********Handling bookings*********/

    function addToCart($data) {
        $hostel_no = $data['hostel_no'];
        $no_sharing = $data['no_sharing'];

        //Reset the cart to prevent multiple selection of items
        $this->cart->destroy();

        $sql = 'SELECT no_sharing, monthly_rent FROM hostels JOIN rooms ON hostels.hostel_no = rooms.hostel_no '
                . 'WHERE hostels.hostel_no = ? AND no_sharing = ?';
        $param = array($hostel_no, $no_sharing);
        $row = $this->table_model->getCustomArray($sql, $param);

        $itemData = array(
            'hostel_name' => $_SESSION['hostel_name'],
            'no_sharing' => $no_sharing,
            'id' => $hostel_no . "-" . $row['no_sharing'],
            'name' => $row['no_sharing'] . " Sharing",
            'price' => $row['monthly_rent'],
            'qty' => 1
        );
        $_SESSION['no_sharing'] = $no_sharing;
        $_SESSION['total_price'] = $row['monthly_rent'];

        $insertItem = $this->cart->insert($itemData);
        $redirectLoc = $insertItem ? '/view_cart' : '/book';
        redirect('student' . $redirectLoc);
    }

    function removeCartItem($id) {
        $deleteItem = $this->cart->remove($id);
        if ($deleteItem) {
            redirect('student/view_cart');
        }
    }

    function fetchRooms() {
        $wing = $this->input->post('gender'); //Because there is either a male or female wing
        $no_sharing = $this->input->post('no_sharing');
        $hostel_no = $this->session->hostel_no;

        $data = "";
        $sql = 'SELECT * FROM `room_allocation` WHERE wing = ? AND no_sharing = ? AND hostel_no = ? AND spaces > 0';
        $param = array($wing, $no_sharing, $hostel_no);
        $query = $this->db->query($sql, $param);

        foreach ($query->result_array() as $row) {
            $no_occupied = $row['no_occupied'];
            $spaces = $row['spaces'];
            $room_no = $row['room_no'];
            $wing = $row['wing'];
            $colour = $this->owner_model->getColour($wing, $no_occupied);
            $status = $this->owner_model->roomStatus($no_occupied, $spaces);

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

    function placeOrder() {
        $data = array(
            'user_id' => $_SESSION['user_id'],
            'hostel_no' => $_SESSION['hostel_no'],
            'room_chosen' => $_SESSION['room'],
            'no_sharing' => $_SESSION['no_sharing'],
            'total_price' => $_SESSION['total_price']
        );

        /*
         * Get the current hostel details -->methods from classes: Hostels and Rooms
         */
        $hostel_no = $data['hostel_no'];
        $no_sharing = $data['no_sharing'];
        $user_id = $data['user_id'];
        $room_chosen = $data['room_chosen'];

        $hostel_where = array('hostel_no' => $hostel_no);
        $room_where = array('hostel_no' => $hostel_no, 'no_sharing' => $no_sharing);
        $user_where = array('user_id' => $user_id);
        $tr_where = array('hostel_no' => $hostel_no, 'room_no' => $room_chosen);

        print_r($data);
        echo $room_chosen;

        $hostel = $this->table_model->getArray('hostels', $hostel_where);
        $room = $this->table_model->getArray('rooms', $room_where);
        $user = $this->table_model->getArray('users', $user_where);
        $this_room = $this->table_model->getArray('room_allocation', $tr_where);

        $cartItems = $this->cart->contents();
       //Start transaction
        $this->db->trans_start();
        foreach ($cartItems as $item) {
            $action = "add-tenant";
            
            //Insert the booking into bookings table
            $this->db->insert('bookings',$data);
            $orderID = $this->db->insert_id();
            
            //Hostels table: Reduce the number of available slots in the hostel 
            $this->booking_model->updateVacancies($hostel, $room, $user,$action);

            //Room allocation table: Allocate rooms
            $this->booking_model->updateRooms($this_room, $hostel, $data,$action);
        }
        //Complete transaction
        $complete = $this->db->trans_complete();

        if ($complete) {
            $this->cart->destroy();
            redirect("student/order_success?id=$orderID");
        }
    }

    /*     * *******End: Handling bookings******** */
}
