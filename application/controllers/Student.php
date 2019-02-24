<?php

//holds the methods common to all modules
class Student extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model('student_model');
    }

    //Search results for hostel
    function search_results(){
        $searchdata = array(
            'location_home' => $this->input->post('location_home'),
            'hostel_type' => $this->input->post('hostel_type'),
            'max_price'=> $this->input->post('max_price')  
        );
 
        $data['header'] = $this->page_model->setTitle('Search results');
        $data['query'] = $this->student_model->hostelSearch($searchdata);
        
        $this->load->view('templates/header',$data);
        $this->load->view('student/hostel-search-results');
    }
    
    function view_details($user_id){
        $data['header'] = $this->page_model->setTitle('My details');
        $data['css'] = array('forms');
        //SELECT 8 FROM users WHERE user_id = ?
        $data['row'] = $this->table_model->getArray('users',array('user_id'=>$user_id));
        
        $this->load->view('templates/header',$data);
        $this->load->view('student/view-details');
        $this->load->view('templates/footer');
    }
    
    function update_details(){
        $update_data = array(
            'first_name'=>$_POST['first_name'],  
            'last_name'=>$_POST['last_name'],  
            'email'=>$_POST['email'],  
            'country_code'=>$_POST['country_code'],  
            'phone_no'=>$_POST['phone_no'],  
      );
      $where = array('user_id'=>$_SESSION['user_id']);  
  
      $this->table_model->updateRows('users', $where,$update_data);
        alert("Update succesful");
        header("refresh:0; url=".base_url('student/view_details/'.$_SESSION['user_id']));
    }
    
    
    //Javascript helper: Ensures the user does not update email to one which is already taken 
    function email_available(){
        $where = array(
          'email' => $this->input->post('email'),
           'user_id !='=>$this->input->post('user_id')
        );
        $num = $this->table_model->getNumRows('users',$where);
        
        if($num > 0){
            echo 'email-exists';
        }
    }
    
    /*********Hostel room booking*********/
    
    function book(){
        $hostel_no = $this->input->get('id');
        $hostel_name = $this->input->get('hostel_name');
        $hostel_where = array('hostel_no'=>$hostel_no);
        $price_where = array('hostel_no'=>$hostel_no, 'gender'=>$this->session->gender);
        
        $data['header'] = $this->page_model->setTitle($hostel_name);
        $data['css'] = array('booking-page');
        /***Hostel data***/
        $data['hostel'] = $this->table_model->getArray('hostels',$hostel_where);
        $data['rules'] = $this->db->get('rules',$hostel_where);
        $data['amenities'] = $this->db->get('amenities',$hostel_where);
        $data['pricing'] = $this->student_model->getRooms($price_where);
        /*****************/
        $this->load->view('templates/header',$data);
        $this->load->view('student/book-hostel-room');
        $this->load->view('templates/footer');
    }
    
    function add_to_cart(){
        $data = array( 
            'hostel_no' => $this->input->get('id'),
            'no_sharing' => $this->input->get('no')
        );
        $this->student_model->addToCart($data);
    }
    
    function view_cart(){
        $data['header'] = $this->page_model->setTitle('View Cart');
        $data['css'] = array('view-cart');
        
        $this->load->view('templates/header',$data);
        $this->load->view('student/book/view-cart');
    }
    
    function remove_cart_item(){
        $id = $this->input->get('id');
        $this->student_model->removeCartItem($id);
    }
    
    function fetch_rooms(){
        $this->student_model->fetchRooms();
    }
            
    function checkout(){
        $data['header'] = $this->page_model->setTitle('Check out');
        $data['css'] = array('booking-page');
        
        $this->load->view('templates/header',$data);
        $this->load->view('student/book/checkout');
    }
    
    function place_order(){
        $this->student_model->placeOrder();
    }
    
    function order_success(){
        $booking_no = $_GET['id'];
        //"SELECT * FROM bookings WHERE booking_no=?
        $booking_where = array('booking_no'=>$booking_no);
        $data['bookdata'] = $this->table_model->getArray('bookings',$booking_where);
        
        $this->load->view('student/book/OAuth');
        $this->load->view('student/book/order-success',$data);
    }
    
}