<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Table_Model extends CI_Model{
    
    public function getArray($table,$cond){
        $query = $this->db->get_where($table, $cond);
        return $query->row_array();
    }

    public function getCustomQuery($sql,$param){
        $query = $this->db->query($sql, $param);
        return $query;
    }
    
    public function getCustomArray($sql,$param){
        $query = $this->db->query($sql, $param);
        return $query->row_array();
    }
    
    public function getQuery($table,$param){
        $query = $this->db->get_where($table, $param);
        return $query;
    }
    
    function getJoinArray($sql, $param){       
        $query = $this->db->query($sql,$param);
        return $query->row_array();
    }
    
    function getRows($table, $cols, $cond=""){
        if(!empty($cond)){
            $this->db->where($cond);
        }
        
        $this->db->select(implode(",", $cols));
        $query = $this->db->get($table);
        
        return $query->row_array();   
    }
    
    function getRowQuery($table, $cols, $cond=""){
        if(!empty($cond)){
            $this->db->where($cond);
        }
        
        $this->db->select(implode(",", $cols));
        $query = $this->db->get($table);
        
        return $query;   
    }

    function updateRows($table, $where,$update){
        $this->db->where($where);
        $this->db->update($table,$update);
    }
     
    
    function deleteRow($table, $where){
        $this->db->where($where);
        $this->db->delete($table);
    }
    
    function countAll($table){
        $query = $this->db->get($table);
        return $query->num_rows();
    }
    
    function countRows($query){
        return $this->db->count_all_results();
    }
    
    
}