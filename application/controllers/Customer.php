<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	private $path_upload = 'assets/upload/customer/';

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id')) redirect('login');
		$this->load->model('customer_model','model');
	}

	function get_data()
	{
		if(!$this->input->is_ajax_request()) redirect();

		$tipe_customer = $this->input->get('tipe_customer');

		$list = $this->model->get_data($tipe_customer);
				
		$data['data']    = [];
		$data['total']   = 0;
		$data['success'] = false;

		if ($list->num_rows() > 0) {
			foreach ($list->result_array() as $key => $value) {
				$data['data'][$key][] = ($key + 1) . '.';
				$data['data'][$key][] = $value['nama_customer'];
				$data['data'][$key][] = $value['nama_tipe_customer'];
				$data['data'][$key][] = $value['alamat_customer'].', '.$value['city_name'].', '.$value['province_name'];
				$data['data'][$key][] = $value['status_customer'];
				$data['data'][$key][] = $value['lampiran'];
				$data['data'][$key][] = $value['id_customer'];
				$data['total'] = $key + 1;
			}

			$data['success'] = true;
		}
		echo json_encode($data);
	}

	function get_data_lampiran()
	{
		if(!$this->input->is_ajax_request()) redirect();

		$id_customer = $this->input->get('customer');

		$list = $this->model->get_data_lampiran($id_customer);
		
		$data['data']    = [];
		$data['total']   = 0;
		$data['success'] = false;

		if ($list->num_rows() > 0) {
			foreach ($list->result_array() as $key => $value) {
				$data['data'][$key][] = ($key + 1) . '.';
				$data['data'][$key][] = $value['file_lampiran'];
				$data['data'][$key][] = $value['id_customer'];
				$data['data'][$key][] = $value['id_jenis_lampiran'];
				$data['total'] = $key + 1;
			}

			$data['success'] = true;
		}
		echo json_encode($data);
	}

	function get_data_by_id()
	{
		if(!$this->input->is_ajax_request()) redirect();
		
		$id = $this->input->post('id');
		$data = $this->model->get_by_id($id)->row();

		echo json_encode($data);
	}

	function get_tipe_customer()
	{
		if(!$this->input->is_ajax_request()) redirect();
		
		$list = $this->model->get_data_tipe_customer();

		$data = [];

		if ($list->num_rows() > 0) {
			foreach ($list->result_array() as $key => $value) {
				$data[$key]['id']   = $value['id_tipe_customer'];
				$data[$key]['name'] = $value['nama_tipe_customer'];
			}
		}

		echo json_encode($data);
	}

	function get_sales()
	{
		if(!$this->input->is_ajax_request()) redirect();
		
		$list = $this->model->get_data_sales();

		$data = [];

		if ($list->num_rows() > 0) {
			foreach ($list->result_array() as $key => $value) {
				$data[$key]['id']   = $value['id_sales'];
				$data[$key]['name'] = $value['nik_sales'].' - '.$value['nama_sales'];
			}
		}

		echo json_encode($data);
	}

	function get_jenis_lampiran()
	{
		if(!$this->input->is_ajax_request()) redirect();
		
		$list = $this->model->get_data_jenis_lampiran();

		$data = [];

		if ($list->num_rows() > 0) {
			foreach ($list->result_array() as $key => $value) {
				$data[$key]['id']   = $value['id_jenis_lampiran'];
				$data[$key]['name'] = $value['nama_jenis_lampiran'];
			}
		}

		echo json_encode($data);
	}

	function get_province()
	{
		if(!$this->input->is_ajax_request()) redirect();
		
		$list = $this->model->get_data_province();

		$data = [];

		if ($list->num_rows() > 0) {
			foreach ($list->result_array() as $key => $value) {
				$data[$key]['id']   = $value['province_id'];
				$data[$key]['name'] = $value['province_name'];
			}
		}

		echo json_encode($data);
	}

	function get_city()
	{
		if(!$this->input->is_ajax_request()) redirect();

		$province_id = $this->input->post('province_id');
		$list = $this->model->get_data_city($province_id);

		$data = [];

		if ($list->num_rows() > 0) {
			foreach ($list->result_array() as $key => $value) {
				$data[$key]['id']   = $value['city_id'];
				$data[$key]['name'] = $value['city_name'];
			}
		}

		echo json_encode($data);
	}

	function save()
	{
		if(!$this->input->is_ajax_request()) redirect();

		$exec = false;
		
		$data_array = array(
			'id_customer' => $this->input->post('id_customer') ? $this->input->post('id_customer') : null,
			'nama_customer' => $this->input->post('nama_customer'),
			'id_tipe_customer' => $this->input->post('tipe_customer'),
			'npwp_customer' => $this->input->post('npwp_customer'),
			'alamat_customer' => $this->input->post('alamat_customer'),
			'city_id' => $this->input->post('kota'),
			'kode_pos_customer' => $this->input->post('kode_pos_customer'),
			'telp_customer' => $this->input->post('telp_customer'),
			'email_customer' => $this->input->post('email_customer'),
			'website_customer' => $this->input->post('website_customer'),
			'bidang_usaha_customer' => $this->input->post('bidang_usaha_customer'),
			'pic_customer' => $this->input->post('pic_customer'),
			'telp_pic_customer' => $this->input->post('telp_pic_customer'),
			'id_sales' => $this->input->post('id_sales') ? $this->input->post('id_sales') : null,
			'status_customer' => $this->input->post('status_customer'),
		);

		if ($data_array['id_customer']) {
			$exec = $this->model->update(['id_customer' => $data_array['id_customer']],$data_array);
		} else{
			$exec = $this->model->save($data_array);
		}


		echo json_encode(
			['status' => $exec]
		);
	}

	function save_lampiran()
	{
		if(!$this->input->is_ajax_request()) redirect();

		$exec = false;
		
		$data_array = array(
			'id_customer' => $this->input->post('id_customer_lampiran'),
			'id_jenis_lampiran' => $this->input->post('jenis_lampiran'),
		);

		$nama_jenis_lampiran = $this->model->get_nama_jenis_lampiran($data_array['id_jenis_lampiran']);

		$nama_lampiran = $nama_jenis_lampiran.'-'.$data_array['id_customer'];

		$upload_action = $this->_do_upload($data_array['id_customer'],$nama_lampiran);

		if (!$upload_action['status']) {
			echo json_encode($upload_action);
			exit;
		}

		$data_array['file_lampiran'] = $upload_action['pesan'];

		$exec = $this->model->save_lampiran($data_array);

		echo json_encode(
			['status' => $exec]
		);
	}

	function delete()
	{
		if(!$this->input->is_ajax_request()) redirect();

		$exec = $this->model->delete(['id_customer' => $this->input->post('id')]);
		$exec2 = $this->model->delete_lampiran(['id_customer' => $this->input->post('id')]);

		if(file_exists($this->path_upload.$this->input->post('id')))
			rmdir($this->path_upload.$this->input->post('id'));
		
		echo json_encode(
			['status' => $exec]
		);
		
	}

	function delete_lampiran()
	{
		if(!$this->input->is_ajax_request()) redirect();

		$exec = $this->model->delete_lampiran(
			['id_customer' => $this->input->post('id_customer'),
			'id_jenis_lampiran' => $this->input->post('id_jenis_lampiran')
		]);

		$path = $this->path_upload.$this->input->post('id_customer');

		if(file_exists($path.'/'.$this->input->post('nama_lampiran')))
			unlink($path.'/'.$this->input->post('nama_lampiran'));

		echo json_encode(
			['status' => $exec]
		);

	}

	function download_lampiran()
	{
		$id_customer = $this->input->get('customer');
		$nama_file = $this->input->get('file');
		$path = $this->path_upload.$id_customer;
		force_download($path.'/'.$nama_file,NULL);
	}



	private function _do_upload($id_customer,$filename)
	{
		$path = $this->path_upload.$id_customer;
		$result_upload = [
			'status' => false,
			'pesan' => '',
		];

        if(!file_exists($path))
            mkdir($path, 0777, true);

		$config['upload_path']          = $path;
        $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|ppt|pptx';
        $config['max_size']             = 10240; //set max size allowed in Kilobyte
        $config['max_width']            = 10000; // set max width image allowed
        $config['max_height']           = 10000; // set max height allowed
        $config['overwrite']           	= true; // set max height allowed
        $config['file_name']            = str_replace(' ', '_', $filename); //just milisecond timestamp fot unique name

        $this->load->library('upload');
        $this->upload->initialize($config);

        if(!$this->upload->do_upload('file_lampiran'))
        {
			$result_upload['pesan'] = 'Upload error: '.$this->upload->display_errors('','');
			return $result_upload;
		}
		$result_upload['status']= true;
		$result_upload['pesan']= $this->upload->data('file_name');
		return $result_upload;
	}


}

/* End of file Customer.php */
/* Location: ./application/controllers/Customer.php */