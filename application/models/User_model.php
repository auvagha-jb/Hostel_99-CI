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
        $data = "";
        if($query->num_rows()>0){
            $data = "email-exists";
        }
        echo json_encode($data);
    }


    public function signUp(){
        //Insert 
        if(isset($_POST['s-u-submit'])){
            //Form data
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            /********************************/
            $pwd = $this->input->post('pwd');
            $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT); 
            /********************************/
            $country_code = $this->input->post('country_code');
            $no = $this->input->post('no');
            /********************************/
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
                'user_type'=>$user_type
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
                
              /*
               * Ensures the user had not been blocked and they are redirected to the right page
               */
              $this->redirect_new($data, $user_data);
            }
        }

    }

    //To check whether the email address entered exists - To avoid duplicate email addresses
    function availableEmail(){
        //Check whether the email exists
        if(isset($_POST['email'])){

             $email = $_POST['email'];

             $check_email = $con->prepare("SELECT * FROM users WHERE email = ?");
             $check_email->bind_param("s", $email);
             $check_email->execute();
             $result1 = $check_email->get_result();

             if(mysqli_num_rows($result1)>=1){
                 echo'email-exists';
             }else{
                 echo 'all-good';
             }
        } 
    }
    
    //Function to redirect new user on sign in
    function redirect_new(&$data, &$user_data){
        $user_type = $data['user_type'];
        $blocked = $data['blocked'];
                
        if($blocked == 0){
            
            //Redirect back to the page they were on
            if(isset($_SESSION['current_url'])){
                $current_url = $_SESSION['current_url'];
                $module = $_SESSION['module'];
                
                //Set the session variables
                $this->session->set_userdata($user_data);
                
                //Ensures one is not redirected to a module above their access level
                $clear = $this->rightType($module, $user_type);
                if($clear){
                    echo $current_url;
                    exit();
                }else{
                    $this->redirect_user($user_type);
                }
                $this->session->unset_userdata('current_url','module');
            }

            //Set the session variables
            $this->session->set_userdata($user_data);
            
            //Redirect to index pages of the different user types
            if(isset($_SESSION['user_id'])){
                   $this->redirect_user($user_type);
            }   
            
          }else{
              echo 'Account blocked';
              exit();
          }  
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

      //If we get a reult
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
              
              //Check whether the parricular user had been blocked from the system
              $this->checkBlocked($data,$user_data); 
              
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

    function checkBlocked(&$data, &$user_data){
        $user_type = $data['user_type'];
        $blocked = $data['blocked'];
                
        if($blocked == 0){
            
            //Redirect back to the page they were on
            if(isset($_SESSION['current_url'])){
                $current_url = $_SESSION['current_url'];
                $module = $_SESSION['module'];
                
                //Set the session variables
                $this->session->set_userdata($user_data);
                
                //Ensures one is not redirected to a module above their access level
                $clear = $this->rightType($module, $user_type);
                if($clear){
                    echo $current_url;
                    exit();
                }else{
                    $this->redirect_user($user_type);
                }
                $this->session->unset_userdata('current_url','module');
            }

            //Set the session variables
            $this->session->set_userdata($user_data);
            
            //Redirect to index pages of the different user types
            if(isset($_SESSION['user_id'])){
                   $this->redirect_user($user_type);
            }   
            
          }else{
              echo 'Account blocked';
              exit();
          }  
    }
        
    function rightType($module, $user_type){
        $valid = true;
        
        if($module === "owner" && $user_type !=="Hostel Owner"){
            $valid = false;
        }elseif($module === "admin" && $user_type !=="Admin"){
            $valid = false;
        }
        
        return $valid;
    }
    
    function redirect_user($user_type){
        switch ($user_type){
             case "Student":
                 echo 'Main/';
                 break;
             case "Hostel Owner":
                 echo 'Owner/';
                 break;
             case "Admin":
                 echo 'Admin/';
                 break;
         }
    }
    
    /*****End: Sign in form action *****/
    
    function logout(){
      session_destroy();

      //Redirect to sign_in page
      //redirect('Main/sign_in');
     }
}