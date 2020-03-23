<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Surveyor_model extends CI_Model {

    private $surveyor_table_name = 'surveyor';
    private $authorization_code_table_name = 'surveyor_authorization_codes';

    public function __construct() {
        parent::__construct();
        $this->output->set_content_type('application/json');
    }

    public function get($data = NULL) {
        if ($data) {
            $this->db->where($data);
        }

        return $this->db->get($this->surveyor_table_name)->result_array();
    }

    public function saveCode($phone_number, $code) {
        $this->db->insert($this->authorization_code_table_name, ['phone_number' => $phone_number, 'code' => $code]);
        return $this->db->insert_id();
    }

    public function validateCode($phone_number = "", $code = "") {
        $query = "select * from {$this->authorization_code_table_name} where phone_number = {$phone_number} and code = {$code} and expiry_date > now() and status=1";
        $result = $this->db->query($query)->result_array();

        if (count($result)) {
            $this->db->query("update {$this->authorization_code_table_name} set status=0 where id = {$result[0]['id']}");
            return 1;
        }


        return 0;
    }
    

}
