<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Model extends CI_Model{
    
    function dashboardGraph(){
        $this->db->select('hostel_name, vacancies');
        $this->db->order_by('vacancies','DESC');
        $this->db->limit(15);
        
        $query = $this->db->get('hostels');
        
        return $query;
    }
    
    
    function getUsers(){
        //SELECT [cols] FROM `users` WHERE NOT user_type = 'Admin' ORDER BY user_type DESC
        $this->db->select('user_id, first_name, last_name, email, user_type, room_assigned, user_status,blocked');
        $this->db->where('user_type!=','Admin');
        $this->db->order_by('user_type','DESC');
      
        $query = $this->db->get('users');
        
        return $query;
    }
    
    
    function userBooked($id){
        $sql="SELECT * FROM users JOIN bookings ON users.user_id = bookings.user_id WHERE "
                . "users.user_id = ? AND users.user_status IS NULL";
        
        $query = $this->db->query($sql,$id);
        
        if($query->num_rows()>0){
            return true;
        }
        return false;
    }
    
}