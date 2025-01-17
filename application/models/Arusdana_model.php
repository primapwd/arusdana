<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arusdana_model extends CI_Model {

	protected $table = 'arus_dana';

	public function __construct()
	{
		parent::__construct();
	}

	public function getData($idBagian)
	{
		$this->db->select('pa.*,uk.nama_unit_kerja,an.nama_anggaran,kt.nama_kategori');
		$this->db->join('unit_kerja uk', 'pa.id_unit_kerja = uk.id_unit_kerja');
		$this->db->join('anggaran an', 'pa.id_anggaran = an.id_anggaran');
		$this->db->join('kategori kt', 'kt.id_kategori = pa.id_kategori');
		$this->db->where('pa.id_bagian', $idBagian);
		return $this->db->get('permintaan_anggaran pa');
	}

	public function getAnggaran($idPermintaan)
	{
		return $this->db->where('id_permintaan', $idPermintaan)->get('permintaan_anggaran');
	}

	function get_by_id($id)
	{
		$this->db->select('*');
		$this->db->where('id_permintaan', $id);
		return $this->db->get('permintaan_anggaran');
	}

	function get_detail_permintaan($id_permintaan)
	{
		$this->db->select('id_detail_permintaan,uraian,nominal,keterangan');
		$this->db->where('id_permintaan', $id_permintaan);
		return $this->db->get('detail_permintaan_anggaran');
	}

	public function storeArusDana($arusDana)
	{
		$this->db->insert($this->table, $arusDana);
		return $this->db->insert_id();
	}

	public function storeChildArusDana($items)
	{
		return $this->db->insert('detail_arus_dana', $items);
	}


}

/* End of file Arusdana_model.php */
/* Location: ./application/models/Arusdana_model.php */