<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Ctrl extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->model('user_model');//Load user_model as user
    }
            
    function sign_in_action(){
        $this->user_model->signIn();
        
    }
    
    /******Sign up form functions*****/
    
    function email_exists(){
        $email = $this->input->post('email');
        $this->user_model->emailExists($email);
    }
    
    function sign_up_action(){
        $this->user_model->signUp();
    }
    
    /******************************/
    
}