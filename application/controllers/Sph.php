<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sph extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('login') != TRUE) {
            redirect('login');
        }
    }

    public function index() {

        // Set the title
        $this->template->title = 'SPH Admin';
        $this->template->stylesheet->add('assets/css/bootstrap.min.css');
        $this->template->stylesheet->add('assets/css/jquery.dataTables.min.css');
        $this->template->stylesheet->add('assets/css/bootstrap-datepicker3.min.css');

        // Dynamically add a javascript
        $this->template->javascript->add('assets/js/bootstrap.min.js');
        $this->template->javascript->add('assets/js/jquery.dataTables.min.js');
        $this->template->javascript->add('assets/js/bootstrap-datepicker.min.js');
        //$this->template->javascript->add('assets/js/init.js');
        
        $data['getNo'] = $this->getNo();
        // Load a view in the content partial
        $this->template->content->view('sph/list', $data);
        
        // Publish the template
        $this->template->publish();
    }

	public function getNo() {
		// 010/020.15601
		$sk = '010';
		$pelanggan = '020';
		$this->load->model('sql_mod');
		$q = $this->sql_mod->msrwhere('m_sph', array('active' => 'Y'), 'sph_id', 'ASC')->result();
		$n = count($q);
		$count = str_pad($n + 1, 5, 0, STR_PAD_LEFT);
		return $sk . '/' . $pelanggan . '.' . $count;
	}
	
    public function ajax_list() {
        $this->load->model('sql_mod');

        $list = $this->sql_mod->msrwhere('m_sph', array('active' => 'Y'), 'sph_id', 'DESC')->result();
        $data = array();
        $no = 1;

        foreach ($list as $sph) {
            $no++;
            $row = array();
            $row[] = $sph->nomor_sph;
            $row[] = $sph->tanggal_sph;
            $row[] = $sph->tujuan_sph;
            $row[] = $sph->lokasi_sph; 
			$row[] = $sph->perihal_sph;
			
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$sph->sph_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$sph->sph_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $data[] = $row;
        }

        $output = array(
                    //"draw" => $_POST['draw'],
                    "recordsTotal" => $this->sql_mod->count_all('m_sph'),
                    "recordsFiltered" => $this->sql_mod->count_filtered('m_sph'),
                    "data" => $data,
                    );
        echo json_encode($output);
    }

    public function ajax_add() {
        $this->load->library('form_validation');
		
        $this->form_validation->set_rules('nomor_sph', 'Nomor', 'required');
        $this->form_validation->set_rules('tanggal_sph', 'Tanggal', 'required');
        $this->form_validation->set_rules('tujuan_sph', 'Tujuan', 'required');
        $this->form_validation->set_rules('lokasi_sph', 'Lokasi', 'required');
        $this->form_validation->set_rules('perihal_sph', 'Perihal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
        
		if ($this->form_validation->run() == FALSE) {
            $data['response'] = 'failed';
            $data['message']  = validation_errors();
            echo json_encode($data);
        } else {
            $this->load->model('sql_mod');
			$this->load->library('upload');

            $config['upload_path'] = './files/docs/';
            $config['allowed_types'] = 'pdf|doc|docx';
			$config['max_size'] = '15000';
            //$config['file_name'] = $file_name;
            $this->upload->initialize($config);
            $image = $this->upload->data();

            $set = array(
                    'nomor_sph' => $this->input->post('nomor_sph'),
                    'tanggal_sph' => $this->input->post('tanggal_sph'),
                    'tujuan_sph' => $this->input->post('tujuan_sph'),
                    'lokasi_sph' => $this->input->post('lokasi_sph'),
                    'perihal_sph' => $this->input->post('perihal_sph'),
                    'jumlah' => $this->input->post('jumlah'),
                    //'file_sph' => $this->input->post('file_sph'),
                    //'file_supplier' => $this->input->post('file_supplier'),
                    'active' => $this->input->post('active'),
					'ip_address' => $this->input->ip_address(),
                    'hostname' => gethostname(),
                    'creation_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->encrypt->decode($this->session->userdata('user_id'))
                );
            $this->sql_mod->save('m_sph', $set);
            $data['response'] = 'success';
            echo json_encode($data); 
        }

    }

    public function ajax_edit($id) {
        $this->load->model('sql_mod');
        $data = $this->sql_mod->msrwhere('m_sph', array('sph_id' => $id), 'sph_id', 'DESC')->row();
        echo json_encode($data);
    }

    public function ajax_update() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nomor_sph', 'Nomor', 'required');
        $this->form_validation->set_rules('tanggal_sph', 'Tanggal', 'required');
        $this->form_validation->set_rules('tujuan_sph', 'Tujuan', 'required');
        $this->form_validation->set_rules('lokasi_sph', 'Lokasi', 'required');
        $this->form_validation->set_rules('perihal_sph', 'Perihal', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['response'] = 'failed';
            $data['message']  = validation_errors();
            echo json_encode($data);
        } else {
            $this->load->model('sql_mod');
            $set = array(
                    'nomor_sph' => $this->input->post('nomor_sph'),
                    'tanggal_sph' => $this->input->post('tanggal_sph'),
                    'tujuan_sph' => $this->input->post('tujuan_sph'),
                    'lokasi_sph' => $this->input->post('lokasi_sph'),
                    'perihal_sph' => $this->input->post('perihal_sph'),
                    'jumlah' => $this->input->post('jumlah'),
                    'file_sph' => $this->input->post('file_sph'),
                    'file_supplier' => $this->input->post('file_supplier'),
                    'active' => $this->input->post('active'),
					'ip_address' => $this->input->ip_address(),
                    'last_update_date' => date('Y-m-d H:i:s'),
                    'last_updated_by' => $this->encrypt->decode($this->session->userdata('user_id'))
                );
            $this->sql_mod->edit('m_sph', $set, 'sph_id', $this->input->post('sph_id'));
            $data['response'] = "success";
            echo json_encode($data);
        }
    }
 
    public function ajax_delete($id) {
        $this->load->model('sql_mod');
        $this->sql_mod->delete('m_sph', 'sph_id', $id);
        $data['response'] = 'success';
        echo json_encode($data);
    }

	

}