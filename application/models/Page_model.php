<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_Model extends CI_Model{
    
    function setTitle($title){
        $data = array(
            'title'=> $title
        );
        return $data;
    }
}