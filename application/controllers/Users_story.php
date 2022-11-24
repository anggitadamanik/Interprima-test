<?php

defined('BASEPATH') or exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Users_story extends REST_Controller
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
            'Username' => $this->post('Username'), //parameter
            'Balance' => 100000, //body
            'Transfer' => 'empty transfer records' //body
        ];
        if ($users) {
            $this->response([
                'success' => true,
                'data' => [
                    'Accountnumber' => random_string('numeric', 12) //random system type string
                ],
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'success' => false,
                'error' => [
                    'Status' => 'Bad Request',
                    'message' => 'Username is mandatory and must be defined.'
                ]
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    function index_get()
    {
        $users = [
            'Username' => 'Bank', 'Accountnumber' => random_string('numeric', 12), 'Balance' => 100000000
        ];
        $Username = $this->get('Username');
        if ($Username == $users['Username']) {
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
