<?php

defined('BASEPATH') or exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Transfer_cash extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->methods['index_get']['limit'] = 500;
        $this->methods['index_post']['limit'] = 100;
    }
    function index_post()
    {
        $users = [
            'Username' => $this->post('Username'),
            'recipient' => '',
            'amount' => ''
        ];
        if ($users) {
            $this->response([
                'success' => true
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'success' => false,
                'error' => [
                    'Status' => 'Failed Precondition',
                    'message' => 'Account balance is not sufficient'
                ]
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    function index_get()
    {
        $users = [
            'Username' => 'Bank', 'Accountnumber' => random_string('numeric', 12), 'Balance' => 100000000,
            'Transfer' => [
                'sender' => 'anggi',
                'recipient' => 'bla',
                'amount' => 20000
            ]
        ];
        if ($users) {
            if ($users['Balance'] >= $users['Transfer']['amount']) {
                $users['Balance'] = ($users['Balance'] - 20000);
            }
            $this->response($users, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'success' => False,
                'status' => 'Bad Request',
                'message' => 'Username is mandatory and must be defined.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
