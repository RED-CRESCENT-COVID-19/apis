<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Base_API extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->output->set_content_type('application/json');
        $auth_key = $this->input->post('auth_key');

        if ($auth_key != AUTH_KEY) {
            exit(json_encode([
                'status' => 0,
                'message' => 'Authorization failed'
            ]));
        }

        unset($_POST['auth_key']);
    }

    public function exit_with_message($message) {
        exit(json_encode([
            'status' => 0,
            'message' => $message
        ]));
    }
    
    public function form_validator($fields) {
        foreach ($fields as $field) {
            $field_value = $this->input->post($field);
            if(!isset($field_value)){
                $this->exit_with_message("Please provide {$field}");
            }
        }
    }
}
