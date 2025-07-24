<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * class Rekam_formulir 
 * @author Daniel
 * @package Simpatda
 */
class Rekam_formulir extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('rekam_formulir_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$kecamatan = $this->common_model->get_kecamatan();
		//get kecamatan
		$arr_kecamatan = array();
		$arr_kecamatan[''] = "--";
		foreach ($kecamatan as $row) {
			$arr_kecamatan[$row->camat_id] = $row->camat_kode.' | '.$row->camat_nama;
		}
		$data['kecamatan'] = $arr_kecamatan;
		$data['kelurahan'] = array('' => '--');
		$data['kabupaten'] = $this->common_model->get_record_value('dapemda_nm_dati2', 'data_pemerintah_daerah', 'dapemda_id=1');
		$data['status'] = array('0' => 'DIKIRIM', '1' => 'KEMBALI', '2' => 'TIDAK KEMBALI');
		$this->load->view('add_rekam_formulir', $data);
	}
	
	/**
	 * view page controller
	 */
	function view() {
		$this->load->view('view_rekam_formulir');
	}
	
	/**
	 * get list data formulir
	 */
	function get_list() {
		$this->rekam_formulir_model->get_list();
	}
	
	/**
	 * edit rekam formulir
	 */
	function edit() {
		$formulir = $this->rekam_formulir_model->get_detail();
		$kecamatan = $this->common_model->get_kecamatan();
		//get kecamatan
		$arr_kecamatan = array();
		$arr_kecamatan[''] = "--";
		foreach ($kecamatan as $row) {
			$arr_kecamatan[$row->camat_id] = $row->camat_kode.' | '.$row->camat_nama;
		}
		$data['kecamatan'] = $arr_kecamatan;
		
		$kelurahan = $this->common_model->get_kelurahan($formulir->form_camat);
		$arr_kelurahan = array();
		$arr_kelurahan[''] = "--";
		foreach ($kelurahan as $row) {
			$arr_kelurahan[$row->lurah_id] = $row->lurah_kode.' | '.$row->lurah_nama;
		}
		$data['kelurahan'] = $arr_kelurahan;
		$data['kabupaten'] = $this->common_model->get_record_value('dapemda_nm_dati2', 'data_pemerintah_daerah', 'dapemda_id=1');
		$data['status'] = array('0' => 'DIKIRIM', '1' => 'KEMBALI', '2' => 'TIDAK KEMBALI');
		$data['row'] = $formulir;
		
		$this->load->view('edit_rekam_formulir', $data);
	}
	
	/**
	 * next nomor formulir
	 */
	function next_no_formulir() {
		echo $this->common_model->get_next_nomor_formulir();
	}
	
	/**
	 * insert formulir
	 */
	function save() {
		$result = $this->rekam_formulir_model->insert();
		
		if ($result)
			echo json_encode(array('status' => true, 'msg' => "Data berhasil disimpan"));
		else
			echo json_encode(array('status' => false, 'msg' => "Data gagal disimpan"));
	}
	
	/**
	 * update formulir
	 */
	function update() {
		$result = $this->rekam_formulir_model->update();
		
		if ($result)
			echo json_encode(array('status' => true, 'msg' => "Data berhasil disimpan"));
		else
			echo json_encode(array('status' => false, 'msg' => "Data gagal disimpan"));
	}
	
	/**
	 * delete formulir controller
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->rekam_formulir_model->delete($arr_id[$i]) == true)
				$counter++;
		}
		
		if ($counter != 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}