<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH . 'libraries/REST_Controller.php');

class Api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->library('session');
        $this->checklogin = $this->session->userdata('logged_in');
        $this->user_id = $this->session->userdata('logged_in')['login_id'];
    }

    public function index() {
        $this->load->view('welcome_message');
    }

    function getAddress_post() {
        $address = $this->post('address');
        $lat = $this->post('lat');
        $lng = $this->post('lng');
        $dis = $this->post('dis');
        
        $sess_data = array(
            'dis' => $dis,
            'address' => $address,
            'lat' =>  $lat,
            'lng' => $lng,
        );
   
        $this->session->set_userdata('distnceinfo', $sess_data);
        
        $positions = array(
            'dis' => $dis,
            'address' => $address,
            'lat' =>  $lat,
            'lng' => $lng,
            
        );
        $this->response($positions);
    }

    function gpsPosition_get($user_id) {
        $this->db->where_in('user_id', $user_id);
        $query = $this->db->get('user_position');
        $current_postion = $query->row();
        if ($current_postion) {
            $this->response($current_postion);
        }$positions = array(
            'lat' => $this->input->post('lat'),
            'lng' => $this->input->post('lng'),
        );
        $this->response($positions);
    }

    function gpsPosition_post() {

        $user_id = $this->post('user_id');
        $lat = $this->post('lat');
        $lng = $this->post('lng');


        $this->db->where_in('user_id', $user_id);
        $query = $this->db->get('user_position');
        $current_postion = $query->row();

        if ($current_postion) {
            $this->db->set('lat', $lat);
            $this->db->set('lng', $lng);
            $this->db->where('user_id', $this->user_id);
            $this->db->update('user_position');
        } else {
            $positionArray = array(
                'user_id' => $this->input->post('user_id'),
                'lat' => $this->input->post('lat'),
                'lng' => $this->input->post('lng'),
            );
            $this->db->insert('user_position', $positionArray);
        }
        $positions = array(
            'lat' => $this->input->post('lat'),
            'lng' => $this->input->post('lng'),
        );
        $this->response($positions);
    }

}

?>