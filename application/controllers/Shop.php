<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->library('session');
        $session_user = $this->session->userdata('logged_in');
        #print_r($session_user);
        if ($session_user) {
            $this->user_id = $session_user['login_id'];
            $this->mobile = $session_user['mobile_no'];
        } else {
            $this->user_id = 0;
            $this->mobile = 0;
        }
    }

    public function index() {
        $data = array("gameinit" => "false");
        $player_color_array = array(
            "player1" => "red",
            "player2" => "green",
            "player3" => "blue",
            "player4" => "yellow",
            "player5" => "purple",
        );
        $atom_array = array(
            "3" => "3x",
            "4" => "2x",
            "5" => "1x",
            "6" => "1x",
        );

        $game = array("row" => "",
            "col" => "",
            "atom_size" => "3x",
            "indexgame" => array(),
            "gamemove" => array(),
            "gamemovelist" => array(),
            "players" => array(),
            "moveselect" => [],
            "movelist" => [],
            "selectedPlayer" => "player1",
            "selectedColor" => "",
            "nextColor" => "red",
            "colwidth" => "",
            "winner" => "",
            "message" => ""
        );


        if (isset($_GET['start_game'])) {
            $matrix = $this->input->get('matrix');
            $game["row"] = $matrix;
            $game["col"] = $matrix;

            $game["atom_size"] = $atom_array[$matrix];

            $players = $this->input->get('players');

            $payers = array();
            for ($i = 1; $i <= $players; $i++) {
                $game["players"]["player" . $i] = $player_color_array["player" . $i];
                array_push($game["moveselect"], "player" . $i);
            }
            $data['gameinit'] = "true";
        }
        
        
        $data["gamearray"] = json_encode($game);
        $this->load->view('home', $data);
    }

    function _sendsms($message, $mobile_no) {
        //Send SMS using using curl input message and mobile no
        $options = array(
            'http' => array(
                'protocol_version' => '1.0',
                'method' => 'GET'
            )
        );
        $data = array('username' => 'anticrimetech',
            'message' => $message,
            'sendername' => 'MODELS',
            'smstype' => 'TRANS',
            'numbers' => $mobile_no,
            'apikey' => '13a03483-aca3-4d2a-963c-5999a1b393c4');
        $query = http_build_query($data);
        $ch = curl_init("http://sms.hspsms.com/sendSMS?" . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        $messge_code = '';
        $messagereturn = json_decode($response, $assoc = true);
//    print_r($messagereturn);
        foreach ($messagereturn as $key => $value) {
            if (isset($value['msgid'])) {
                $messge_code = $value['msgid'];
            }
        }
        return $messge_code;
    }

    public function pickride() {
        $data['msg'] = '';

        $session_data1 = $this->session->userdata('distnceinfo');
        if ($session_data1) {
            //print_r($session_data1);
            $latitude = $session_data1["lat"];
            $longitude = $session_data1["lng"];
            $distance = $session_data1["dis"];
        } else {
            $latitude = 22.6794104;
            $longitude = 75.8212206;
            $distance = 10;
        }

        //echo $this->user_id;

        $current_date = date("m/d/Y");

        if (isset($_POST['search'])) {

            $distance = $this->input->post('distance');

            $latitude = $this->input->post('lat');
            $longitude = $this->input->post('lng');

            $session_data1['dis'] = $distance;

            $this->session->set_userdata('distnceinfo', $session_data1);
        }
        if (isset($_POST['allsearch'])) {

            $distance = 1000;
            $latitude = $this->input->post('lat');
            $longitude = $this->input->post('lng');

            //$session_data1['dis'] = $distance;

            $this->session->set_userdata('distnceinfo', $session_data1);
        }
        $latitude = $latitude ? $latitude : 22.6794104;
        $longitude = $longitude ? $longitude : 75.8212206;
        $distance = $distance ? $distance : 10;

        $squery = "select * from (SELECT of.*,  111.111 * DEGREES(ACOS(COS(RADIANS(s_lat)) * COS(RADIANS($latitude))* COS(RADIANS(s_lng - $longitude))+ SIN(RADIANS(s_lat))* SIN(RADIANS($latitude)))) AS distance_in_km,"
                . " IF((select st.offer_drive_id from confirn_pick_drive as st where st.user_id = " . $this->user_id . " and st.offer_drive_id = of.id ), 1, 0) as stat "
                . "FROM `offer_drive` as of ) as a "
                . "where off_date >= '$current_date'  and distance_in_km < $distance order by id desc ";

        $query = $this->db->query($squery);

        $attr_value = $query->result_array();

        $data["attr_value"] = $attr_value;

        if (isset($_POST['confirm_pick_drive'])) {
            $mobile_no = $this->input->post('offer_no');



            $data1 = array(
                'offer_drive_id' => $this->input->post('offer_drive_id'),
                'op_date_time' => date("Y-m-d h:i:s A"),
                'user_id' => $this->user_id
            );
            $this->db->insert('confirn_pick_drive', $data1);
            $data['msg'] = "yes";
            $message = $this->input->post('picker_no') . " is pick your drive ";
            if (REPORT_MODE) {
                $message_code = $this->_sendsms($message, $mobile_no);
            }
            redirect('Shop/pickride');
        }
        if (isset($_POST['cancel_pick_ride'])) {

            $confirm_data = explode("+", $this->input->post('cancel_pick_ride'));
            $ids = $confirm_data[0];
            $query = "delete  from confirn_pick_drive where offer_drive_id = $ids   ";
            $this->db->query($query);
            $message = $this->mobile . " has canceled pick drive. ";
            if (REPORT_MODE) {
                $message_code = $this->_sendsms($message, $confirm_data[1]);
            }
            redirect('Shop/pickride');
        }

        $this->load->view('pickdrive', $data);
    }

    public function drivemap($id) {

        $query = $this->db->query("SELECT start_point,end_point from offer_drive where id = $id");

        $data['data'] = $query->result_array();

        $this->load->view('drivemap', $data);
    }

    public function offerdrive() {

        if (isset($_POST['submit'])) {
            $off_drive = array(
                'user_id' => $this->user_id,
                'person_name' => $this->input->post('person_name'),
                'contact_no' => $this->input->post('contact_no'),
                'vehicle_name' => $this->input->post('vehicle_name'),
                'vehicle_no' => $this->input->post('vehicle_no'),
                'off_date' => $this->input->post('off_date'),
                'start_point' => $this->input->post('start_point'),
                'end_point' => $this->input->post('end_point'),
                'available_sit' => $this->input->post('available_sit'),
                'pickup_time' => $this->input->post('pickup_time'),
                'offer_amount' => $this->input->post('offer_amount'),
                's_lat' => $this->input->post('lat'),
                's_lng' => $this->input->post('lng'),
            );

            $this->db->insert('offer_drive', $off_drive);
            redirect('Shop/pickride');
        }
        $this->load->view('offerdrive');
    }

}
