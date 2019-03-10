<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin_model');
    }
    
    function index(){
        $this->dashboard();
    }
    
    function dashboard(){
        $data['header'] = $this->page_model->setTitle('Dashboard');
        $data['number'] = array(//The number stats
          'hostels'=>  $this->table_model->countAll('hostels'),
          'users'=>  $this->table_model->countAll('users')  
        );
        $data['graph'] = $this->admin_model->dashboardGraph();
        
        $this->load->view('templates/admin/admin-header',$data);
        $this->load->view('admin/admin-home');
        $this->load->view('templates/admin/admin-footer');
    }
    
    function users(){
        $data['header'] = $this->page_model->setTitle('Users');
        $data['users'] = $this->admin_model->getUsers();
        
        $this->load->view('templates/admin/admin-header',$data);
        $this->load->view('admin/admin-users');
        $this->load->view('templates/admin/admin-footer');
    }
    
    function hostels(){
        $cols = array('hostel_name', 'description', 'location', 'hostel_no', 'type');
        
        $data['header'] = $this->page_model->setTitle('Hostels');
        $data['hostels'] = $this->table_model->getRowQuery('hostels', $cols);
        
        $this->load->view('templates/admin/admin-header',$data);
        $this->load->view('admin/admin-hostels');
        $this->load->view('templates/admin/admin-footer');
    }
    
    function owner_registration(){
        //Title and css loaded
        $data['header'] = $this->page_model->setTitle('Account registration');
        $data['css'] = array('forms');
        
        $this->load->view('templates/admin/admin-header',$data);
        $this->load->view('admin/owner-account-registration');
        $this->load->view('templates/admin/admin-footer');
    }
   
    
    
   /**********Start: Javascript helpers and form action**********/
   //Used in the various js files in the assets folder 
    
    /**page: admin-users**/ 
    function show_users(){
        $this->admin_model->showUsers();
    }
    
    function show_suspended_users(){
        $this->admin_model->showSuspendedUsers();
    }
    
    function user_delete(){
        $this->admin_model->userDelete();
    }
    
    function user_suspend($id){
        $this->admin_model->userSuspend($id);
    }
    
    function user_restore($id){
        $this->admin_model->userRestore($id);
    }
    
    /*****page: admin-hostels*****/
    function hostel_delete($id){
        $this->admin_model->hostelDelete($id);
    }

    /*****page: owner-account-registration*****/
    function register_owner(){
        $this->admin_model->registerOwner();
    }
    
    function show_registered_owners(){
        $this->admin_model->showRegisteredOwners();
    }
    
    function hostel_registered(){
        $this->admin_model->hostelRegistered($this->input->post('hostel_name'));
    }
    
    /**********End: Javascript helpers and form helpers**********/
}
