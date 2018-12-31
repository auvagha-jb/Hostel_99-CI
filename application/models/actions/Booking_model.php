<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_Model extends CI_Model {

    function userBooked($user_id) {
        //$query = 'SELECT * FROM `bookings` WHERE user_id = ?';
        $query = $this->db->get_where('bookings', $user_id);

        return $query->row_array();
    }

    function vacancyPresent($user,$room){
        //User data
        $gender = $user['gender'];

        //Rooms table
        $no_sharing = $room['no_sharing'];
        $gender_count = $room[$gender.'_count'];
        $total = $room['total_capacity'];
        $blocked_m = $room['blocked_male'];
        $blocked_f = $room['blocked_female'];

        $spaces = $total - ($blocked_m + $blocked_f);

        /*
         * if condition 1 - Check if there are any rooms left to spare
         * if condition 2 - Check that there is space in the last room for that particular gender
         */
        if($spaces==0 && ($gender_count % $no_sharing) == 0){
            return false;
        }
        return true;
    }
    
    function updateBooking($user_id){
        //$query = 'UPDATE `bookings` SET status = "tenant" WHERE user_id = ?';
        $updates = array(
            'status'=>'Tenant',
        );
        
        $this->db->where('user_id',$user_id);
        $this->db->update('bookings',$updates);
    }
    
    function updateVacancies($hostel, $room, $user,$action){
        //User data
        $gender = $user['gender'];

        //Hostels table
        $hostel_no = $hostel['hostel_no'];
        $total_occupied = $hostel['total_occupied'];
        $total_available = $hostel['total_available'];

        //Rooms table
        $no_sharing = $room['no_sharing'];
        $current_capacity = $room['current_capacity'];
        $gender_count = $room[$gender.'_count'];//Reinitialization done due to calculation


        /****Do the increment on total occupied and current capacity****/

        if($action == "add-tenant"){
            //Hostels table
            $total_occupied += 1;
            $vacancies = $total_available - $total_occupied; 

            //Rooms table
            $current_capacity += 1;
            $gender_count += 1;
            $block_gender = ceil($gender_count/$no_sharing)*$no_sharing;
            
        }else if($action == "remove-tenant"){ 
            //Hostels table
            $total_occupied -= 1;
            $vacancies = $total_available - $total_occupied; 

            //Rooms table
            $current_capacity -= 1;
            $gender_count -= 1;
            $block_gender = ceil($gender_count/$no_sharing)*$no_sharing;
        }

        /***UPDATE tables***/
       
        //Hostels table
        /*UPDATE hostels SET total_occupied = ?, vacancies = ? WHERE hostel_no = ?";*/
        $hostel_update = array(
            'total_occupied' => $total_occupied,
            'vacancies' => $vacancies
        ); 
        $hostel_where = array(
            'hostel_no'=>$hostel_no
        );
        $this->table_model->updateRows('hostels', $hostel_where,$hostel_update);
        
        //Rooms table
        /*UPDATE rooms SET current_capacity = ?, '.$gender.'_count = ?, blocked_'.$gender.' = ? 
         * WHERE hostel_no = ? AND no_sharing = ? */
        $room_update = array(
            'current_capacity' => $current_capacity,
            $gender.'_count' => $gender_count,
            'blocked_'.$gender => $block_gender,
        ); 
        
        $room_where = array(
          'hostel_no',$hostel_no,
           'no_sharing'=>$no_sharing
        );
        $this->table_model->updateRows('rooms', $room_where,$room_update);
        
    }
    
    function thisRoomDetails($hostel_no, $room_assigned){
        
        $query = 'SELECT * FROM room_allocation WHERE hostel_no = ? AND room_no = ?';
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $hostel_no, $room_assigned);
        $bool = $stmt->execute();

        if($bool == false){
            array_push($error, $con->error);
        }

        $result = $stmt->get_result();
        $row = $result->fetch_array();

        return $row;
    }
    
    /*
     * @param
     * $this_room: room allocation table array
     * $hostel: hostels table array
     * $data: data collected 
     * $action: determines whether to increment or decrement  
     */
    function updateRooms($this_room, $hostel, $data,$action){
        //Get the current details for this room 
        $no_sharing = $data['no_sharing'];
        $hostel_no = $hostel['hostel_no'];

        $no_occupied = $this_room['no_occupied'];//Is incremented
        $room_no = $this_room['room_no'];

        //The math
        if($action == "add-tenant"){
            $no_occupied += 1;
        }else if($action == "remove-tenant"){
            $no_occupied -= 1;
        }
        
        $spaces = $no_sharing - $no_occupied;

        //UPDATE `room_allocation` SET `no_occupied`= ? ,`spaces`= ? WHERE room_no = ? AND hostel_no = ? 
        $room_where = array('room_no' => $room_no, 'hostel_no'=>$hostel_no );
        $room_update = array('no_occupied'=> $no_occupied ,'spaces'=>$spaces);
        $this->db->where($room_where);
        $this->db->update('room_allocation',$room_update);
    }
    
} 
