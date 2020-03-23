<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Household_model extends CI_Model {
    
    
    private $household_table = 'house_hold';
    
    public function __construct() {
        parent::__construct();
    }
    
    
    //Functions for House Hold
    
    public function create($data) {
        $this->db->insert($this->household_table,$data);
        return $this->db->insert_id();
    }
    
    public function get($data=NULL) {
        if($data) {
            $this->db->where($data);
        }
        return $this->db->get($this->household_table)->result_array();
    }
    
    public function update($id,$data){
        $this->db->where($id,$data);
        $this->db->update($this->household_table);
        return $this->db->affected_rows();
    }
    
    
}
