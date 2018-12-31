<?php

//holds the methods common to all modules
class Student extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model('student_model');
    }


    /***Search results for hostel***/
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
    
    /*********Hostel room booking*********/
    
    function book(){
        $hostel_no = $this->input->get('id');
        $hostel_name = $this->input->get('hostel_name');
        $hostel_where = array('hostel_no'=>$hostel_no);
        $get_where = array('hostel_no'=>$hostel_no, 'gender'=>$this->session->gender);
        
        $data['header'] = $this->page_model->setTitle($hostel_name);
        $data['css'] = array('booking-page');
        /***Hostel data***/
        $data['hostel'] = $this->table_model->getArray('hostels',$hostel_where);
        $data['rules'] = $this->db->get('rules',$hostel_where);
        $data['amenities'] = $this->db->get('amenities',$hostel_where);
        $data['pricing'] = $this->student_model->getRooms($get_where);
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