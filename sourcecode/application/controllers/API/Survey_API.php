<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_API.php';

class Survey_API extends Base_API {

    public function __construct() {
        parent::__construct();
        $this->load->model('Survey_model', 'survey');
    }

    public function create() {

        //Validating
        $this->form_validator(['household_id', 'surveyor_id']);

        //Getting the params
        $data = $this->input->post(NULL, TRUE);

        //Creating the survey
        $result = $this->survey->createSurvey($data);

        //output
        $this->output->set_output(json_encode([
            'status' => 1,
            'person_id' => $result['person_id'],
            'survey_id' => $result['survey_id']
        ]));
    }

    public function getSummary() {

        $this->form_validator(['surveyor_id']);
        
        $surveyor_id = $this->input->post('surveyor_id');
        
        $result = $this->survey->getSummaryFor($surveyor_id);
        
        $this->output->set_output(json_encode([
            'status' => 1, 
            'households' => $result['households'],
            'people' => $result['people']
        ]));
    }

}
