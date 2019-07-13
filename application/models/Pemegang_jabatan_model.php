<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemegang_jabatan_model extends CI_Model {

	private $table= 'pemegang_jabatan';
	private $primary_key= 'id_pj';

	function get_data()
	{
		$this->db->where('id_bagian', $this->session->userdata('id_bagian'), FALSE);
		$this->db->order_by('nama', 'asc');
		return $this->db->get($this->table);
	}

	function get_by_id($id)
	{
		$this->db->where($this->primary_key, $id);
		return $this->db->get($this->table);
	}

	function save($data){
		$insert = $this->db->insert($this->table, $data);
		return $insert;
	}

	function update($where,$data){
		$this->db->where($where);
		$update = $this->db->update($this->table, $data);
		return $update;
	}

	function delete($where)
	{
		$this->db->where($where);
		$delete = $this->db->delete($this->table);
		return $delete;
	}


}

/* End of file Jenis_lampiran_model.php */
/* Location: ./application/models/Jenis_lampiran_model.php */