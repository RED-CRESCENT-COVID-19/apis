<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Survey_model extends CI_Model {

    private $person_table = 'person';
    private $survey_table = 'survey';

    public function __construct() {
        parent::__construct();
    }

    public function createSurvey($data) {

        //Create the person
        $person_data = [
            'cnic' => isset($data['cnic']) ? $data['cnic'] : '',
            'phone_number' => isset($data['phone_number ']) ? $data['phone_number '] : '',
            'age' => isset($data['age']) ? $data['age'] : '',
            'gender' => isset($data['gender']) ? $data['gender'] : '',
            'household_id' => $data['household_id']
        ];

        $this->db->insert($this->person_table, $person_data);
        $person_id = $this->db->insert_id();


        //Create the survey
        $survey_data = [
            'person_id' => $person_id, 
            'household_id' => $data['household_id'],
            'surveyor_id' => $data['surveyor_id']
            ];
        
        if(isset($data['temperature']))  $survey_data['temperature'] = $data['temperature'];
        if(isset($data['fever']))  $survey_data['fever'] = $data['fever'];
        if(isset($data['cough'])) $survey_data['cough'] = $data['cough'];
        if(isset($data['sputum'])) $survey_data['sputum'] = $data['sputum'];
        if(isset($data['fatigue'])) $survey_data['fatigue'] = $data['fatigue'];
        if(isset($data['sob'])) $survey_data['sob'] = $data['sob'];
        if(isset($data['headache'])) $survey_data['headache'] = $data['headache'];
        if(isset($data['congestion'])) $survey_data['congestion'] = $data['congestion'];
        if(isset($data['meralgia']))$survey_data['meralgia'] = $data['meralgia'];
        if(isset($data['hemoptysis'])) $survey_data['hemoptysis'] = $data['hemoptysis'];
        if(isset($data['conjuctivitis'])) $survey_data['conjuctivitis'] = $data['conjuctivitis'];
        if(isset($data['notes'])) $survey_data['notes'] = $data['notes'];
        
        $this->db->insert($this->survey_table,$survey_data);
        $survey_id = $this->db->insert_id();
        
        
        $this->db->query("update house_hold set survey_allowed = 1 , strength = strength + 1 where id = {$data['household_id']}");
        
        return [
            'person_id' => $person_id,
            'survey_id' => $survey_id
        ];
    }
    
    
    public function getSummaryFor($surveyor_id) {
        
        return $this->db->query("select count(*) as people, count(distinct household_id) as households from survey where surveyor_id = {$surveyor_id}")->result_array()[0];
    }

}
