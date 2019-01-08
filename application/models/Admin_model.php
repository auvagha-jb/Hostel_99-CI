<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('actions/booking_model');
    }

    function dashboardGraph() {
        $this->db->select('hostel_name, vacancies');
        $this->db->order_by('vacancies', 'DESC');
        $this->db->limit(15);

        $query = $this->db->get('hostels');

        return $query;
    }

    /***********Displaying the various tables***********/

    //For the registered users
    function showUsers(){
        $this->displayUsersTable('0');
    }
    
    //For the suspended users
    function showSuspendedUsers(){
        $this->displayUsersTable('1');
    }
    
    //Users table query
    function getUsers() {
        //SELECT [cols] FROM `users` WHERE NOT user_type = 'Admin' ORDER BY user_type DESC
        $this->db->select('user_id, first_name, last_name, email, user_type, room_assigned, user_status,blocked');
        $this->db->where('user_type!=', 'Admin');
        $this->db->order_by('user_type', 'DESC');

        $query = $this->db->get('users');

        return $query;
    }

    //Users table printing
    function displayUsersTable($blocked) {
        $query = $this->getUsers();
        $data = "";
        
        foreach ($query->result_array() as $row) {
            $id = $row['user_id'];
            $name = $row['first_name'] . " " . $row['last_name'];
            $status = $row['user_status'];
            $last_col_id = "user-restore";
            
           if($blocked == 1){
               $last_col_id = "user-suspend";
           }
            
            if ($row['blocked'] == $blocked) {
                $data.= "<tr>";
                $data.= "<td>" . $row['user_id'] . "</td>";
                $data.="<td>" . $name . "</td>";
                $data.="<td>" . $row['email'] . "</td>";
                $data.="<td>" . $row['user_type'] . "</td>";
                $data.="<td>" . $row['room_assigned'] . "</td>";
                $data.="<td>" . $row['user_status'] . "</td>";
                $data.='<td><button class="btn btn-danger delete"><i class="fa fa-trash-alt"></i></button></td>';
                $data.='<td>'
                        . '<button class="btn btn-warning '.$last_col_id.'">'
                        . '<i class="fas fa-lock-open"></i></td></button>';
                $data.="</tr>";
            }
        }
        echo json_encode($data);
    }

    function userBooked($id) {
        $query_array = $this->booking_model->userBooked($id);
        if (!empty($query_array)) {
            return true;
        }
        return false;
    }

}
