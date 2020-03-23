<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_API.php';

class Household_API extends Base_API {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->model('Household_model','household');
    }
    
    public function create() {
        
        $data = $this->input->post(NULL,TRUE);
        
        
        //Validating
        if(!isset($data['address']) OR !isset($data['survey_allowed'])){
            $this->exit_with_message('Pleaes provide an address and survey_allowed field');
        }
        
        //Gathering input
        $household_data = [
            'address' => $data['address'],
            'latitude' => isset($data['latitude']) ? $data['latitude'] : 0.00,
            'longitude' => isset($data['longitude']) ? $data['longitude'] : 0.00,
            'survey_allowed' => $data['survey_allowed']  
        ];
        
        //Inserting into database
        $household_id = $this->household->create($household_data);
        
        //Output
        $this->output->set_output(json_encode([
            'status' => 1,
            'household_id' => $household_id
        ]));
    }
   
    
}
