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

    /*     * *********Displaying the various tables********** */

    //For the registered users
    function showUsers() {
        $this->displayUsersTable('0');
    }

    //For the suspended users
    function showSuspendedUsers() {
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
        //Query to select users
        $query = $this->getUsers();
        $data = "";

        foreach ($query->result_array() as $row) {
            $id = $row['user_id'];
            $name = $row['first_name'] . " " . $row['last_name'];
            $status = $row['user_status'];

            /*
             * Assign last column a class based on the status of the block
             * 1 = restore suspended user
             * 0 = susupend registered user
             */
            $last_col_class = ($blocked == 1) ? "user-restore" : "user-suspend";
            $lock_icon = ($blocked == 1) ? "fa-lock-open":"fa-lock";

            //Display rows in which the value in the clocked column matches the blocked value passed as an argument 
            if ($row['blocked'] == $blocked) {
                $data .= "<tr>";
                $data .= "<td>" . $row['user_id'] . "</td>";
                $data .= "<td>" . $name . "</td>";
                $data .= "<td>" . $row['email'] . "</td>";
                $data .= "<td>" . $row['user_type'] . "</td>";
                $data .= "<td>" . $row['room_assigned'] . "</td>";
                $data .= "<td>" . $row['user_status'] . "</td>";
                $data .= '<td><button class="btn btn-danger delete_user"><i class="far fa-trash-alt"></i></button></td>';
                $data .= '<td>'
                        . '<button class="btn btn-warning ' . $last_col_class . '">'
                        . '<i class="fas '.$lock_icon.'"></i></td></button>';
                $data .= "</tr>";
            }
        }
        echo json_encode($data);
    }

    /*     * *****Action: Delete user***** */

    function userDelete() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $user_status = $this->input->post('user_status');

        $booked = $this->admin_model->userBooked($id);
        $user_status === "Tenant" ? $tenant = true : $tenant = false;
        $data = array(
            "message" => null,
            "status"=>false
        ); //What is to be echoed

        if (!$booked && !$tenant) {
            $data['message'] = $name . " has been permanently removed from the system";
            $data['status'] = true;
            $this->db->trans_start();
            $where = array('user_id' => $id);
            $this->table_model->deleteRow('users', $where);
            $this->db->trans_complete();
        } elseif ($booked) {
            $data['message'] = $name . " had booked, therefore needs to remain in the system";
        } elseif ($tenant) {
            $data['message'] = $name . " is a tenant, therefore needs to remain in the system";
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

    function userSuspend($id) {
        $update_data = array(
            "blocked" => 1
        );

        $this->db->where('user_id', $id);
        $this->db->update('users', $update_data);
    }

    function userRestore($id) {
        $update_data = array(
            "blocked" => 0
        );

        $this->db->where('user_id', $id);
        $this->db->update('users', $update_data);
    }

    function hostelDelete($id) {
        $this->db->where('hostel_no', $id);
        $this->db->delete('hostels');

        redirect('admin/hostels');
    }

}
