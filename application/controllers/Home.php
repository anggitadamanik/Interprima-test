<?php

defined('BASEPATH') or exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Home extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->methods['index_get']['limit'] = 500;
        $this->methods['index_post']['limit'] = 100;
        $this->methods['index_delete']['limit'] = 50;
    }
    function index_get()
    {
        $kontak = [ //data
            ['id' => 1, 'name' => 'Orion', 'hp' => '08576666762'],
            ['id' => 2, 'name' => 'Mars', 'hp' => '08576666770'],
            ['id' => 3, 'name' => 'Alpha', 'hp' => '08576666765']
        ];
        $id = $this->get('id');
        if ($id === NULL) {
            if ($kontak) {
                $this->response($kontak, REST_Controller::HTTP_OK);
            } else {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $id = (int) $id;

            if ($id <= 0) {
                $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
            }


            $user = NULL;

            if (!empty($kontak)) {
                foreach ($kontak as $key => $value) {
                    if (isset($value['id']) && $value['id'] === $id) {
                        $user = $value;
                    }
                }
            }

            if (!empty($user)) {
                $this->set_response($kontak, REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User could not be found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }
    function index_post()
    {
        $message = [
            'id' => 100,
            'name' => $this->post('name'),
            'hp' => $this->post('hp'),
            'message' => 'Added a resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED);
    }
    function index_delete()
    {
        $id = (int) $this->get('id');

        if ($id <= 0) {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }

        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT);
    }
}
