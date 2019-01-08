<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class remove_Tenant extends CI_Model {

    function updateUsers($user_id) {
        //$query = "UPDATE users SET user_status = NULL, room_assigned = NULL, no_sharing = NULL WHERE user_id = ?";
        $update_data = array(
          'user_status' => NULL, 
          'room_assigned'=> NULL, 
          'no_sharing'=> NULL   
        );
        $this->db->where('user_id',$user_id);
        $this->db->update('users',$update_data);
    }

    function updateHistory($record_id, $date_checked_out) {
        //$query = "UPDATE tenant_history SET date_checked_out = ? WHERE record_id = ?";
        $update_data = array(
           'date_checked_out' => $date_checked_out  
        );
        $this->db->where('record_id',$record_id);
        $this->db->update('tenant_history',$update_data);
    }

    function deleteFromBridge($user_id) {
        //$query = "DELETE FROM `user_hostel_bridge` WHERE user_id = ?";
        $this->db->where('user_id',$user_id);
        $this->db->delete('user_hostel_bridge');
    }

    function updateVacancies(&$hostel, &$room, &$user) {
        //User data
        $gender = $user['gender'];

        //Hostels table
        $hostel_no = $hostel['hostel_no'];
        $total_occupied = $hostel['total_occupied'];
        $total_available = $hostel['total_available'];

        //Rooms table
        $no_sharing = $room['no_sharing'];
        $current_capacity = $room['current_capacity'];
        $gender_count = $room[$gender . '_count']; //Reinitialization done due to calculation


        /*
         * Do the increment on total occupied and current capacity
         */

        //Hostels table
        $total_occupied -= 1;
        $vacancies = $total_available - $total_occupied;

        //Rooms table
        $current_capacity -= 1;
        $gender_count -= 1;
        $block_gender = ceil($gender_count / $no_sharing) * $no_sharing;

        /*
         * UPDATE tables
         */

        //Hostels
        //$query_1 = "UPDATE hostels SET total_occupied = ?, vacancies = ? WHERE hostel_no = ?";
        $hostel_update = array(
          'total_occupied' => $total_occupied, 'vacancies' => $vacancies   
        );
        $hostel_where = array('hostel_no'=>$hostel_no);
        $this->table_model->updateRows('hostels', $hostel_where, $hostel_update);
        

        //Rooms
        /*$query = 'UPDATE rooms SET current_capacity = ?, ' . $gender . '_count = ?, blocked_' . $gender . ' = ? '
        *        . 'WHERE hostel_no = ? AND no_sharing = ?';
        */
        $room_update = array(
            'current_capacity'=>$current_capacity, 
            $gender.'_count'=>$gender_count, 
            'blocked_'.$gender=>$block_gender
        );
        $room_where = array('hostel_no' => $hostel_no, 'no_sharing' => $no_sharing);
        
        $this->table_model->updateRows('rooms',$room_where,$room_update);
    }

    function updateRooms($this_room, $hostel, $data) {
        //Get the current details for this room 
        $no_sharing = $data['no_sharing'];
        $hostel_no = $hostel['hostel_no'];

        $no_occupied = $this_room['no_occupied']; //Is incremented
        $room_no = $this_room['room_no'];

        /*
         * The math
         */
        $no_occupied -= 1;
        $spaces = $no_sharing - $no_occupied;

        /*
         * $query = 'UPDATE `room_allocation` SET `no_occupied`= ? ,`spaces`= ? '
         *       . 'WHERE room_no = ? AND hostel_no = ? ';
         */
        $update_data = array(
            'no_occupied'=>$no_occupied, 
            'spaces'=>$spaces  
        ); 
        $where = array('room_no'=>$room_no,'hostel_no'=>$hostel_no);
        
        $this->table_model->updateRows('room_allocation',$where,$update_data);
    }

}
