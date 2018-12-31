<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Owner extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('owner_model', 'table_model'));
        $this->load->model('actions/tenant_model');
    }

    /**** Views start****/

    function index() {
        $this->view_hostels();
    }

    function add_hostel() {
        $data['css'] = array('owner-forms');
        $data['header'] = $this->page_model->setTitle('Add Hostel');

        $this->load->view('templates/header', $data);
        $this->load->view('owner/add-hostel');
    }
    
    
    function add_hostel_action(){
        $this->owner_model->add_hostel_action();
    }    

    function view_hostels() {
        $user_id = $_SESSION['user_id'];
        $data['query'] = $this->owner_model->view_hostels($user_id);
        $data['header'] = $this->page_model->setTitle('My Hostels');

        $this->load->view('templates/header', $data);
        $this->load->view('owner/view-hostels');
    }

    function dashboard() {
        $hostel_no = $this->input->get('id');
        $hostel_name = $this->input->get('hostel_name');
        $hostel_where = array('hostel_no'=>$hostel_no);
        
        $data['header'] = $this->page_model->setTitle($hostel_name);
        $data['row'] = $this->table_model->getArray('hostels',$hostel_where);
        $data['css'] = array('owner-forms');

        $this->load->view('templates/header', $data);
        $this->load->view('owner/owner-dashboard');
    }

    /*     * * Views end ** */

    /*     * **Javascript helpers*** */

    function hostel_exists() {
        $hostel_name = $this->input->post('hostel_name');
        $this->owner_model->hostel_exists($hostel_name);
    }

    function edit_hostel() {
        $this->owner_model->edit_hostel();
    }

    function show_tenants() {
        $hostel_no = $_SESSION['hostel_no'];
        $this->owner_model->showTenants($hostel_no);
    }

    function show_bookings() {
        $hostel_no = $_SESSION['hostel_no'];
        $this->owner_model->showBookings($hostel_no);
    }

    function vacancies_bookings() {
        $hostel_no = $_SESSION['hostel_no'];
        $host_cols = array('vacancies');
        $sql = "SELECT COUNT(*) AS no_booked FROM users JOIN bookings ON users.user_id = bookings.user_id "
                . "WHERE hostel_no = ? AND users.user_status IS NULL";

        $row = $this->table_model->getCustomArray($sql, $hostel_no);

        $array = $this->table_model->getRows('Hostels', $host_cols, array('hostel_no' => $hostel_no)); //vacancies
        $book_array = array('bookings' => $row['no_booked']); //No of bookings
        $data = array_merge($array, $book_array);

        echo json_encode($data);
    }

    function fetch_rooms() {
        $this->owner_model->fetchRooms($_SESSION['hostel_no']);
    }

    function get_no_sharing() {
        $sql = "SELECT * FROM rooms WHERE hostel_no = ? ORDER BY no_sharing";
        $param = array($_SESSION['hostel_no']);
        $query = $this->table_model->getCustomQuery($sql, $param);
        $data = "";
        foreach ($query->result_array() as $row) {
            $no_sharing = $row['no_sharing'];
            $data .= '<option value="' . $no_sharing . '">' . $no_sharing . '</option>';
        }

        echo json_encode($data);
    }

    function get_gender() {
        $email = $this->input->post('email');
        $array = $this->table_model->getRows('users', array('gender'), array('email' => $email));

        echo json_encode($array);
    }

    function get_rent() {
        $hostel_no = $_SESSION['hostel_no'];
        $no_sharing = $this->input->post('no_sharing');
        $cond = array('hostel_no' => $hostel_no, 'no_sharing' => $no_sharing);

        $array = $this->table_model->getRows('rooms', array('monthly_rent'), $cond);

        echo json_encode($array);
    }

    function available_rooms() {
        $data = array(
            'gender' => $this->input->post('gender'),
            'no_sharing' => $this->input->post('no_sharing'),
            'hostel_no' => $this->input->post('hostel_no')
        );
        $this->owner_model->availableRooms($data);
    }

    /*     * ****Image handling**** */

    function upload_image() {
        $this->owner_model->uploadImage($_SESSION['hostel_name']);
    }

    function dropzone_upload() {
        $temp_file = $_FILES['file']['tmp_name'];
        $dir = 'uploads/' . $_SESSION['hostel_name'] . "/";
        $location = $dir . $_FILES['file']['name'];

        //Check whether the hostel folder exists
        if (!file_exists($dir)) {
            mkdir($dir);
        }

        move_uploaded_file($temp_file, $location);
    }

    function fetch_photos() {
        $data = array(
            'folder_name' => 'uploads',
            'hostel_name' => $_SESSION['hostel_name'],
        );
        $this->owner_model->fetchPhotos($data);
    }

    function remove_image() {
        $data = array(
            'file_name' => $this->input->post('name'),
            'folder_name' => 'uploads',
            'hostel_name' => $_SESSION['hostel_name']
        );

        $this->owner_model->removeImage($data);
    }

    /*     * ****End: Image handling**** */

    function verify_user() {
        $data = array(
            'hostel_no' => $this->session->userdata('hostel_no'),
            'email' => $this->input->post('email'),
            'room_assigned' => $this->input->post('room_assigned'),
            'no_sharing' => $this->input->post('no_sharing')
        );
        $this->owner_model->verifyUser($data);
    }
    
    function add_tenant(){
        $data = array(
            'hostel_no' => $this->session->userdata('hostel_no'),
            'email' => $this->input->post('email'),
            'room_assigned' => $this->input->post('room_assigned'),
            'no_sharing' => $this->input->post('no_sharing')
        );
    }

    /*     * ***End: Javascript helpers*** */



    /*     * ***For testing purposes**** */

    function test_upload() {
        $success = $this->owner_model->updateImage('Mock Hostel');
        echo $success;
    }

    function test_mkdir() {
        $folder = $this->input->post('folder');
        $this->owner_model->create($folder);
    }

    function test_rename() {
        $folder = $this->input->post('folder');
        $this->owner_model->rename($folder);
    }

    /*     * ***For testing purposes**** */

    function test_table() {
        $hostel_no = $_SESSION['hostel_no'];
        $this->owners_model->showTenants($hostel_no);
    }

}
