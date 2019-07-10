<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AccountController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('User_model');
        $this->load->model('Product_model');
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

    //login page

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

    function offerdrivelist() {
        $user_details = $this->User_model->user_details($this->user_id);
        $data['user_data'] = $user_details;
        $data['msg'] = "";
        $current_date = date("m/d/Y");
        $query = $this->db->query("SELECT * from `offer_drive` WHERE user_id = $this->user_id and off_date >= '$current_date' order by id desc");
        $data_value = $query->result_array();
        $offer_container = array();

        foreach ($data_value as $key => $value) {
            $offerdata = $value;

            $query1 = $this->db->query("SELECT cp.id,cp.status,ur.user_name,ur.mobile_no FROM
                `confirn_pick_drive` as cp
                join user_registration as ur on cp.user_id = ur.id
                WHERE cp.offer_drive_id = " . $value['id'] . "   ");

            $temp1 = $query1->result_array();
            $offerdata['picker'] = $temp1;
            array_push($offer_container, $offerdata);
        }
        $data['user_ride_data'] = $offer_container;

        if (isset($_POST['confirm_pick_drive_id'])) {

            $confirm_data = explode("+", $this->input->post('confirm_pick_drive_id'));

            $c_p_d_id = $confirm_data[0];
            $this->db->set('status', 'Done');
            $this->db->where('id', $c_p_d_id);
            $this->db->update('confirn_pick_drive');

            $message = $this->mobile . " is also confirm your drive. ";

            if (REPORT_MODE) {
                $message_code = $this->_sendsms($message, $confirm_data[1]);
            }
            redirect('AccountController/offerdrivelist');
        }
        if (isset($_POST['cancel_drive'])) {
            $confirm_data = explode("+", $this->input->post('cancel_drive'));
            $ids = $confirm_data[0];


            $this->db->set('status', '');
            $this->db->where('id', $ids);
            $this->db->update('confirn_pick_drive');

            $message = $this->mobile . " have cancel your drive. ";
            #echo  $message;
            if (REPORT_MODE) {
                $message_code = $this->_sendsms($message, $confirm_data[1]);
            }
            redirect('AccountController/offerdrivelist');
        }

        if (isset($_POST['delete_drive'])) {
            $id = $this->input->post('delete_drive');
            $query = "delete  from confirn_pick_drive where offer_drive_id = $id ";
            $this->db->query($query);
            $query1 = "delete  from offer_drive where id = $id ";
            $this->db->query($query1);
            redirect('AccountController/offerdrivelist');
        }


        $this->load->view('offerdrivelist', $data);
    }

    function profile() {

        if ($this->user_id == 0) {
            redirect('/');
        }
        $user_details = $this->User_model->user_details($this->user_id);
        $data['user_data'] = $user_details;
//        $data['msg'] = "";
//        $current_date = date("m/d/Y");
//        $query = $this->db->query("SELECT * from `offer_drive` WHERE user_id = $this->user_id and off_date >= '$current_date' order by id desc");
//        $data_value = $query->result_array();
//        $offer_container = array();
//
//        foreach ($data_value as $key => $value) {
//            $offerdata = $value;
//
//            $query1 = $this->db->query("SELECT cp.id,cp.status,ur.user_name,ur.mobile_no FROM
//                `confirn_pick_drive` as cp
//                join user_registration as ur on cp.user_id = ur.id
//                WHERE cp.offer_drive_id = " . $value['id'] . "   ");
//
//            $temp1 = $query1->result_array();
//            $offerdata['picker'] = $temp1;
//            array_push($offer_container, $offerdata);
//        }
//        $data['user_ride_data'] = $offer_container;
        ##########

        if (isset($_POST["starttracking"])) {
            $this->session->set_userdata('trackingstatus', "Yes");
        }
        if (isset($_POST["stoptracking"])) {
            $this->session->set_userdata('trackingstatus', "No");
        }

        $trackingstatus = $this->session->userdata('trackingstatus');
        $data['trackingstatus'] = $trackingstatus;


        if (isset($_POST['update_profile'])) {
            $this->db->set('user_name', $this->input->post('user_name'));
            $this->db->where('id', $this->user_id);
            $this->db->update('user_registration');

            $this->session->set_userdata('user_name', $this->input->post('user_name'));

            redirect('AccountController/profile');
        }

        #print_r($data);
        $this->load->view('profile', $data);
    }

    function registration() {
        $data1['msg'] = "";

        if (isset($_POST['submit'])) {

            $mobile_no = $this->input->post('mobile_no');
            $password = $this->input->post('password');
            $user_name = $this->input->post('user_name');
            $cpassword = $this->input->post('con_password');


            if ($cpassword == $password) {
                $user_check = $this->User_model->check_user($mobile_no);
                if ($user_check) {
                    $data1['msg'] = 'Mobile No. Already Registered.';
                } else {
                    $userarray = array(
                        'user_name' => $user_name,
                        'mobile_no' => $mobile_no,
                        'password' => md5($password),
                        'password2' => $password,
                        'registration_datetime' => date("Y-m-d h:i:s A")
                    );
                    $this->db->insert('user_registration', $userarray);
                    $user_id = $this->db->insert_id();

                    $sess_data = array(
                        'mobile_no' => $mobile_no,
                        'user_name' => $user_name,
                        'login_id' => $user_id,
                    );

                    $this->session->set_userdata('logged_in', $sess_data);
                    //redirect('AccountController/profile');
                }
            } else {
                $data1['msg'] = 'Password did not match.';
            }
        }


        $this->load->view('registration', $data1);
    }

    function login() {

        if (isset($_POST['signIn'])) {
            $otp = rand(1000, 9999);
            $mobile_no = $this->input->post('mobile_no');
            $message = $otp . " is your verification code, verify and enjoy. ";

            $this->db->select('*');
            $this->db->from('user_registration');
            $this->db->where('mobile_no', $mobile_no);
            $this->db->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {

                $userdata = $query->result_array()[0];
                $this->db->set('password2', $otp);
                $this->db->where('mobile_no', $mobile_no);
                $this->db->update('user_registration');
                if (REPORT_MODE) {
                    $message_code = $this->_sendsms($message, $mobile_no);
                }
                redirect('AccountController/otpcheck/' . $mobile_no);
            } else {
                #new registration
                $userarray = array(
                    'user_name' => $mobile_no,
                    'mobile_no' => $mobile_no,
                    'password' => md5($otp),
                    'password2' => $otp,
                    'registration_datetime' => date("Y-m-d h:i:s A")
                );
                $this->db->insert('user_registration', $userarray);
                $user_id = $this->db->insert_id();
                #$message_code = $this->_sendsms($message, $mobile_no);
//
//                $sess_data = array(
//                    'mobile_no' => $user_name,
//                    'user_name' => $user_name,
//                    'login_id' => $user_id,
//                );
                //$this->session->set_userdata('logged_in', $sess_data);
                redirect('AccountController/otpcheck/' . $mobile_no);
            }
        }
        $this->load->view('login');
    }

    // OTP
    function otpcheck($mobile_no) {
        $data['msg'] = "";
        $query = $this->db->query(" SELECT id,password2 FROM `user_registration` where mobile_no = '$mobile_no' ");
        $result = $query->result_array();

        $otp_result = $result[0]['password2'];
        $user_ids = $result[0]['id'];

        if (isset($_POST['otpCheck'])) {
            $otp = $this->input->post('password2');

            if ($otp == $otp_result) {

                $data['msg'] = "Valid OTP";
                $sess_data = array(
                    'mobile_no' => $mobile_no,
                    'user_name' => $mobile_no,
                    'login_id' => $user_ids,
                );
                $user_id = $user_ids;
                $session_cart = $this->session->userdata('session_cart');
                $this->session->set_userdata('logged_in', $sess_data);
                redirect('AccountController/profile');
            } else {

                $data['msg'] = "Invalid OTP";
                redirect('AccountController/otpcheck/' . $mobile_no);
            }
        }

        $this->load->view('otpcheck', $data);
    }

    // Logout from admin page
    function logout() {
        $newdata = array(
            'username' => '',
            'password' => '',
            'logged_in' => FALSE,
        );

        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();

        redirect('AccountController/login');
    }

    function confirmdrive() {
        $query = $this->db->query("SELECT od.*,cp.op_date_time FROM `confirn_pick_drive` as cp
        join offer_drive as od on cp.offer_drive_id = od.id
        WHERE cp.user_id = $this->user_id and cp.STATUS = 'Done'  ");

        $result_array = $query->result_array();
        $data['result'] = $result_array;
        $this->load->view('confirmdrive', $data);
    }

    function tracklocation($ruser_id) {
        $data['user_id'] = $ruser_id;
        $this->load->view('tracking', $data);
    }

}

?>
