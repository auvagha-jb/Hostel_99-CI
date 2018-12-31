<?php

//holds the methods common to all modules
class Main extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        //My models
        $this->load->model('user_model');
        $this->load->model('page_model');
    }
    
    //The home page
    function index(){
        $user_id = $this->user_model->getUser();
        $data['data'] = array('user_id'=>$user_id);
        $data['header'] = $this->page_model->setTitle('Home');
        
        $this->load->view('templates/header',$data);
        $this->load->view('user/home_1');
        $this->load->view('templates/footer');
        
    }
    
    function sign_up(){
        $data['header'] = $this->page_model->setTitle('Sign up');
        $data['css'] = array('forms');
        
        $this->load->view('templates/header',$data);
        $this->load->view('user/sign_up');
        $this->load->view('templates/footer');
    }
    
    function sign_in(){
        $data['header'] = $this->page_model->setTitle('Sign in');
        $data['css'] = array('forms');
        
        $this->load->view('templates/header',$data);
        $this->load->view('user/sign_in');
    }
    
    function contact_us(){
        
    }
    
    function logout(){
        $this->user_model->logout();
        redirect('main/sign_in');
    }
}