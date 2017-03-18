<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('login') != TRUE) {
            redirect('login');
        }
    }

    public function index() {

        // Set the title
        $this->template->title = 'Data Pengguna';
        $this->template->stylesheet->add('assets/css/bootstrap.min.css');
        $this->template->stylesheet->add('assets/css/jquery.dataTables.min.css');
        $this->template->stylesheet->add('assets/css/bootstrap-datepicker3.min.css');

        // Dynamically add a javascript
        $this->template->javascript->add('assets/js/bootstrap.min.js');
        $this->template->javascript->add('assets/js/jquery.dataTables.min.js');
        $this->template->javascript->add('assets/js/bootstrap-datepicker.min.js');
        
        // Load a view in the content partial
        $this->template->content->view('user/list');
        
        // Publish the template
        $this->template->publish();
    }

    public function ajax_list() {
        $this->load->model('sql_mod');

        $list = $this->sql_mod->msrwhere('m_user',array('active' => 'Y'), 'user_id', 'DESC')->result();
        $data = array();
        $no = 1;
		
        foreach ($list as $user) {
            $no++;
            $row = array();
            $row[] = $user->email;
            $row[] = $user->level_id;
            $row[] = $user->active;

            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$user->user_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$user->user_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array(
                        //"draw" => $_POST['draw'],
                        "recordsTotal" => $this->sql_mod->count_all('m_user'),
                        "recordsFiltered" => $this->sql_mod->count_filtered('m_user'),
                        "data" => $data,
                    );
        echo json_encode($output);
    }

    public function ajax_add() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('level_id', 'Level User', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[m_user.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|matches[confirm_pass]');
        $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'trim|required');
        $this->form_validation->set_rules('active', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['response'] = 'failed';
            $data['message']  = validation_errors();
            echo json_encode($data);
        } else {
            $this->load->model('sql_mod');
            $set = array(
                        'level_id' => $this->input->post('level_id'),
                        'email' => $this->input->post('email'),
                        'password' => md5($this->input->post('password')),
                        'active' => $this->input->post('active'),
                        'creation_date' => date('Y-m-d H:i:s'),
                        'created_by' => $this->encrypt->decode($this->session->userdata('user_id')),
						'ip_address' => $this->input->ip_address()
                    );
            $this->sql_mod->save('m_user', $set);
            $data['response'] = 'success';
            echo json_encode($data);
        }
    }

    public function ajax_edit($id) {
        $this->load->model('sql_mod');
        $data = $this->sql_mod->msrwhere('m_user', array('user_id' => $id), 'user_id', 'DESC')->row();
        echo json_encode($data);
    }

    public function ajax_update() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('level_id', 'Level', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['response'] = 'failed';
            $data['message']  = validation_errors();
            echo json_encode($data);
        } else {
            $this->load->model('sql_mod');
            $user_id = $this->encrypt->decode($this->session->userdata('user_id'));
            $set = array(
                        'level_id' => $this->input->post('level_id'),
                        'email' => $this->input->post('email'),
                        'password' => md5($this->input->post('password')),
                        'active' => $this->input->post('active'),
                        'last_update_date' => date('Y-m-d H:i:s'),
                        'last_updated_by' => $user_id
                    );
            $this->sql_mod->edit('m_user', $set, 'user_id', $user_id);
            $data['response'] = "success";
            echo json_encode($data);
        }
    }

    public function ajax_delete($id) {
        $this->load->model('sql_mod');
        $this->sql_mod->delete('m_user', 'user_id', $id);
        $data['response'] = 'success';
        echo json_encode($data);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
    
}
