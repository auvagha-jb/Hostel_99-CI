<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model{
 
    public function getUser(){
        if(isset($_SESSION['user_id'])){
            return $_SESSION['user_id'];
        }
        return "";
    }
    
    /*********Sign up form methods***********/
    
    public function emailExists($email){
        $query = $this->db->get_where('users',array('email'=>$email));
        $data = ($query->num_rows()>0) ? "email-exists" : null;
        
        echo json_encode($data);
    }


    public function signUp(){
        //Insert 
        if(isset($_POST['s-u-submit'])){
            //Form data
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $pwd = $this->input->post('pwd');
            $pwd_hash = password_hash($pwd, PASSWORD_BCRYPT); 
            $country_code = $this->input->post('country_code');
            $no = $this->input->post('no');
            $gender = $this->input->post('gender');
            $user_type = $this->input->post('user_type');

            $data = array(
                'first_name' =>$first_name,
                'last_name'=>$last_name, 
                'email'=>$email, 
                'pwd' =>$pwd_hash,
                'country_code' =>$country_code,
                'phone_no' =>$no, 
                'gender' =>$gender, 
                'user_type'=>$user_type,
                'blocked'=>0
            );

            
            if($this->db->insert('users',$data)){//Upon successful registration...
                //Session variables        
                $user_data = array(
                  'user_id' => $this->db->insert_id(),
                  'email' => $email,
                  'first_name' => $first_name,
                  'last_name' => $last_name,
                  'gender' => $gender,
                  'user_type' => $user_type  
              );
                
              //Get the page the user is to be directed to
              $page = $this->redirect_user($data, $user_data);
              echo $page;
            }
        }

    }

    
    /**
     * Ensures the owner's verification password is correct
     * @param string $password
     */
    function authOwner($email, $auth_pwd){
        //Get the email address
        $query = $this->db->get_where('owner_activation', array('email'=>$email));
        $row = $query->row_array();
        $data = array();
        
        $data['status'] = false;
        
        //If such an email is found
        if($query->num_rows() > 0){
            $hash = $row['activation_pwd'];
            
            if(password_verify($auth_pwd, $hash)){
                $data['msg'] = 'Verified';
                $data['status'] = true;
            }else {
                $data['msg'] = 'Wrong authentication password';
            }
            
        }else{
            $data['msg'] = 'Your hostel was not verified by us. <a href="#">Contact us for assistance or visit our offices</a>';
        }
        
        
        echo json_encode($data);
    }
    
    
    /***********End: Sign up form action*************/
    
    /****Sign in form action****/
    public function signIn(){
      
      //Get the post data
      $email = $this->input->post('email');
      $pwd = $this->input->post('pwd');

      //Check whether email exits
      $sql = "SELECT * FROM users WHERE email = ?";
      $query = $this->db->query($sql, $email);

      //If the email exists
      if($query->num_rows()==1){

          $row = $query->row();
          $hash = $row->pwd; 
          
          /*
           * Check whether password is correct
           */
          if(password_verify($pwd, $hash)){
              $user_data = array(
                  'user_id' => $row->user_id,
                  'email' => $row->email,
                  'first_name' => $row->first_name,
                  'last_name' => $row->last_name,
                  'gender' => $row->gender,
                  'user_type' => $row->user_type  
              );
              
              /*
               * Check if blocked
               */
              $data = array(
                'user_type'=>$row->user_type,
                 'blocked'=>$row->blocked 
              );
              
              /**
               * Determines which page to redirect the user, 
               * Checks whether the particular user had been blocked from the system,
               * Redirects user to the page they were on in the event they had to log in again when due to session expiry 
               */
              $page = $this->redirect_user($data, $user_data); 
              echo $page;
              
          }else{
              //return error message
              echo 'invalid-pwd';
              exit();
          }


      }else{
          //return error message
          echo 'invalid-email';
          exit();
      }
}

    //Called once a user successfully logs in or signs up
    function redirect_user(&$data, &$user_data){
        $user_type = $data['user_type'];
        $blocked = $data['blocked'];
        $data = "";        
        
        //If the user is not blocked...
        if($blocked == 0){            
            //If the user had logged in again after the session had expired 
            if(isset($_SESSION['current_url'])){
                $current_url = $_SESSION['current_url'];
                $module = $_SESSION['module'];
                
                //Set the session variables
                $this->session->set_userdata($user_data);
                
                //Ensures one is not redirected to a module above their access level
                $clear = $this->rightType($module, $user_type);
                
                //If the user is of the right type, the url they last accessed will be return, else their index page will be returned, according to the user_type 
                $data = $clear ? $current_url: $this->default_redirect($user_type);
                
            } 
            //If they are logging in for the first time...
            else {
                //Set the session variables
                $this->session->set_userdata($user_data);
                //Redirect to index pages of the different user types
                if(isset($_SESSION['user_id'])){
                     $data = $this->default_redirect($user_type);
                }  
            }
            
          }else{
              $data =  'Account blocked';
          }  
          
          return $data;
    }
        
    //Ensures that higher level modules are accessible to only those authorized
    function rightType($module, $user_type){
        $valid = true;
        
        if($module === "owner" && $user_type !=="Hostel Owner"){
            $valid = false;
        }else if($module === "admin" && $user_type !=="Admin"){
            $valid = false;
        }
        
        return $valid;
    }
    
    function default_redirect($user_type){
        $data = "";
        switch ($user_type){
             case "Student":
                 $data = 'Main/';
                 break;
             case "Hostel Owner":
                 $data = 'Owner/';
                 break;
             case "Admin":
                 $data = 'Admin/';
                 break;
            default:
                $data = 'Main/';
                break;
         }
         return $data;
    }
    
    /*****End: Sign in form action *****/
    
    function logout(){
      session_destroy();
    }
}