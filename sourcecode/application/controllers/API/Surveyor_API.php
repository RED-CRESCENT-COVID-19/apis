<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_API.php';

use Twilio\Rest\Client;

class Surveyor_API extends Base_API {

    public function __construct() {
        parent::__construct();
        $this->load->model('Surveyor_model', 'surveyor');
    }

    //Send the code to the users device. 

    public function getCode() {

        //Getting the post data
        $phone_number = $this->input->post('phone_number');

        if (!$phone_number) {
            $this->exit_with_message('Please provide a phone number');
        }

        //Getting the surveyor info
        $surveyor = $this->surveyor->get(['phone_number' => $phone_number]);

        //Checking if phone number exits in our db
        if (!count($surveyor)) {
            $this->output->set_output(json_encode([
                'status' => 0,
                'message' => 'You are not authorized to receive the code. Please contact admin'
            ]));
        }

        //Sending the code if number exists
        else {
            //Generate Code
            $code = $this->__generateRandomString();

            //Save Code in Db
            $this->surveyor->saveCode($phone_number, $code);

            //Send Twillio Message
            $this->__sendSMS($phone_number, $code);

            //Output
            $this->output->set_output(json_encode([
                'status' => 1,
//                'code' => $code,
                'surveyor_id' => $surveyor[0]['id']
            ]));
        }
    }

    public function validateCode() {

        //Getting input data
        $code = $this->input->post('code');
        $phone_number = $this->input->post('phone_number');


        //Validating Input
        if (!$code OR ! $phone_number) {
            $this->exit_with_message('Please provide phone number and code');
        }


        //Checking if the code is valid
        $status = $this->surveyor->validateCode($phone_number, $code);


        //Outputting the data
        if ($status) {
            $this->output->set_output(json_encode([
                'status' => 1,
                'message' => 'Authorized'
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => 0,
                'message' => 'Invalid code or code has expired'
            ]));
        }
    }
    

    //Generate Random Code
    private function __generateRandomString($length = 6) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    //Create Twilio Client
    private function __sendSMS($phone_number, $code) {


        //Sending message via Twilio
        try {
            $client = new Twilio\Rest\Client(TWILIO_SID, TWILIO_TOKEN);
            $message = $client->messages->create(
                    $phone_number, [
                'from' => TWILIO_PHONE_NUMBER,
                'body' => "Your OTP code is {$code}"
                    ]
            );
            return $message->sid;
        } catch (Exception $exc) {
            return 0;
        }
    }

}
