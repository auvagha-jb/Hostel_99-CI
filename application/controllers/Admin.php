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
    
    function user_delete($id, $name, $user_status = ""){
        //To remove %20 from name
        $name = str_replace('%20', ' ', $name);
        $where = array('user_id'=>$id);
        $booked = $this->admin_model->userBooked($id);
        $user_status ==="Tenant"?$tenant = true:$tenant = false;
        
        if(!$booked && !$tenant){
            $this->db->trans_start(TRUE);
            $this->table_model->deleteRow('users', $where);
            $this->db->trans_complete();
        }elseif ($booked) {
            alert($name." had booked, therefore needs to remain in the system");
        }elseif($tenant){
            alert($name." is a tenant, therefore needs to remain in the system");
        }
        //redirect('admin/users');
    }
    
    
}
