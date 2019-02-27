<?php

function query() {
    $CI = &get_instance();
    echo $CI->db->last_query() . "\n";
}

function alert($msg){
    echo '
        <script>
            alert("'.$msg.'");
        </script>
        ';
}

/* * *****Uri handling******* */

//Check that the session has not expired
function check_session($current_url, $module) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['current_url'] = $current_url;
        $_SESSION['module'] = $module;
        redirect('main/sign_in');
    }
}

function user_verify() {
    $CI = &get_instance();
    $CI->load->model('user_model');

    $get = $_SERVER['QUERY_STRING'];
    $page = $CI->uri->segment(2);
    $param = $CI->uri->segment(3);
    
    $module = strtolower($CI->uri->segment(1));
    $current_url = $module . '/' . $page;
    
    !empty($param)?
        $current_url.='/'.$param
        :$current_url;//If there is a variable in the third seg..
    
    !empty($get) ? 
        $current_url.='?' . $get 
        : $current_url; //If there is a get variable, append it to the url 

    
    $page_array = array('sign_in', 'sign_up', '');
    $module_array = array('owner', 'admin', 'welcome');

    /***Session variables***/
    $user_type = $CI->session->user_type ? $CI->session->user_type : null;
    $user_id = $CI->session->user_id ? $CI->session->user_id : null;

    /* If the page is not one of the exempted ones (in page_array) or is the top level modules (in module array)
     * ensure the user is logged in
     */

    if (!in_array($page, $page_array) || in_array($module, $module_array)) {
        check_session($current_url, $module);
    }

    if (!empty($user_id)) {
        if (!$CI->user_model->rightType($module, $user_type)) {
            redirect('Main/');
        }
    }
}

function applyCSS($css) {
    foreach($css as $css_link) {
        echo '<link rel="stylesheet" href="' . assets_url('css/' . $css_link) . '.css">';
    }
}

//Shortcuts for writing url links pointing to assets folder
function assets_url($path) {
    return base_url('assets/' . $path);
}

//Shortcuts for writing urls to retrieve images
function uploads_url($path) {
    return base_url('uploads/' . $path);
}

/*******End: Uri handling********/

/*
 * Page Sections
 */

function search_form() {
    $CI = &get_instance();
    $CI->load->view('sections/search-form');
}

function country_codes() {
    $CI = &get_instance();
    $CI->load->view('sections/country_codes');
}

/* * Student sections* */

function student_carousel() {
    $CI = &get_instance();
    $CI->load->view('student/carousel');
}

function add_room() {
    $CI = &get_instance();
    $CI->load->view('sections/add-room');
}

function add_amenities_and_rules() {
    $CI = &get_instance();
    $CI->load->view('sections/add-amenities-and-rules');
}

function hostel_rating(){
    $CI = &get_instance();
    $CI->load->view('student/sections/rating-feature');
}

/* * *Owner Dashboard** */
/* Community */

function community() {
    $CI = &get_instance();
    $CI->load->view('owner/dashboard/community/community-home');
}

function view_tenants() {
    $CI = &get_instance();
    $CI->load->view('owner/dashboard/community/view-tenants');
}

function view_bookings() {
    $CI = &get_instance();
    $CI->load->view('owner/dashboard/community/view-bookings');
}

function view_rooms() {
    $CI = &get_instance();
    $CI->load->view('owner/dashboard/community/view-rooms');
}

/* Community */

function edit_hostel() {
    $CI = &get_instance();
    $CI->load->view('owner/dashboard/edit-hostel');
}

function edit_photos() {
    $CI = &get_instance();
    $CI->load->view('owner/dashboard/edit-photos');
}
