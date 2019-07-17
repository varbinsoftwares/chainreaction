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

    public function playerMove_post() {

        $sess_data = array(
            'player' => $this->post('player'),
            'move' => $this->post('move'),
            'session' => $this->post('session'),
        );

        $this->db->where('session', $game_session);
//        $this->db->where('player', $player);
        $this->db->order_by('id desc');
        $query = $this->db->get('game_position');
        $checkrow = $query->row();
        if ($checkrow) {
            $this->db->set('move', $this->post('move'));
            $this->db->set('player', $this->post('player'));
            $this->db->where('session', $game_session);
            $this->db->update('game_position');
        } else {
            $this->db->insert('game_position', $sess_data);
            $insert_post_id = $this->db->insert_id();
        }



        $this->response(array("game_position_id" => $insert_post_id));
    }

    public function checkMove_get($player, $game_session) {
        $this->db->where('session', $game_session);
//        $this->db->where('player', $player);
        $this->db->order_by('id desc');
        $query = $this->db->get('game_position');
        $checkrow = $query->row();
        if ($checkrow) {
            $this->response($checkrow);
        } else {
            $this->response(array("move" => 0));
        }
    }

    public function playerMoveReset_get() {
        $this->db->delete('game_position', array('session' => '1'));
    }

}

?>