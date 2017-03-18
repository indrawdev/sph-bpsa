<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('login') == TRUE) {
            redirect('sph');
        }
    }

    public function index() {

        // Set the title
        $this->template->title = 'Login Admin';
        $this->template->stylesheet->add('assets/css/bootstrap.min.css');

        // Dynamically add a javascript
        $this->template->javascript->add('assets/js/bootstrap.min.js');
        
        // Load a view in the content partial
        $this->template->content->view('login_v');
        
        // Publish the template
        $this->template->publish();
    }

    public function isLogin() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            $data['response'] = 'failed';
            $data['message']  = validation_errors();
            echo json_encode($data);
        } else {
            $this->load->model('sql_mod');

            $set = array(
                        'email' => $this->input->post('email'),
                        'password' => md5($this->input->post('password')),
                        'active' => 'Y'
                    );
            $count = $this->sql_mod->msrwhere('m_user', $set, 'user_id', 'DESC')->num_rows();
            $check = $this->sql_mod->msrwhere('m_user', $set, 'user_id', 'DESC')->row();
            
            if ($count < 1) {
                $data['response'] = 'failed';
                $data['message']  = 'No have account, registration please!';
                echo json_encode($data);
            } else if ($count > 1) {
                $data['response'] = 'failed';
                $data['message']  = 'Multiple account';
                echo json_encode($data);
            } else {
                $this->load->library('encrypt');
                
                $this->session->set_userdata('login', TRUE);
                $this->session->set_userdata('user_id', $this->encrypt->encode($check->user_id));
                //$this->session->set_userdata('role_id', $this->encrypt->encode($check->role_id));

                $session_id = $this->session->userdata('session_id');
                $set_session = array(
                                    'user_id' => $check->user_id,
                                    //'role_id' => $check->role_id
                                );

                $this->sql_mod->edit('ci_sessions', $set_session, 'user_id', $session_id);
                $set_user = array(
                                'ip_address' => $this->input->ip_address(),
                                'last_updated_by' => $this->encrypt->decode($this->session->userdata('user_id')),
                                'last_login_date' => date('Y-m-d H:i:s')
                            );
                $this->sql_mod->edit('m_user', $set_user, 'user_id', $check->user_id);
                //$role = $this->sql_mod->msrwhere('role', array('role_id' => $check->role_id), 'role_id', 'ASC')->row();
                    $data['response'] = 'success';
                    $data['message'] = 'Loading, please wait...';
                    $data['redirect'] = 'sph'; //$role->default_url_after_login;
                    echo json_encode($data);
            }

        }
    }

    public function checkEmail() {
        $this->load->model('sql_mod');
        $email = $this->input->post('email');
        $check = $this->sql_mod->msrwhere('m_user', array('email' => $email), 'user_id', 'ASC')->num_rows();
        if ($check > 0) {
            $data['response'] = 'success';
            $data['message'] = 'Your email available';
            echo json_encode($data);
        } else {
            $data['response'] = 'failed';
            $data['message'] = 'Your email not available';
            echo json_encode($data);
        }
    }
    
}