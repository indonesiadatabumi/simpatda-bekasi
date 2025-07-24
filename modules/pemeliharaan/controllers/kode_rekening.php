<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kode_rekening class controller
 * @package Simpatda
 */
class Kode_rekening extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('kode_rekening_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_kode_rekening');
	}
	
	/**
	 * get list
	 */
	function get_list() {
		$this->kode_rekening_model->get_list();
	}
	
	/**
	 * add anggaran
	 */
	function add() {
		$data['kategori'] = $this->common_model->get_record_list('ref_kakorek_id AS value, ref_kakorek_ket AS item', 'ref_kategori_kode_rekening', NULL, "ref_kakorek_id", true);
		$data['perda'] = $this->common_model->get_record_list('dahukorek_id AS value, dahukorek_no_perda AS item', 'dasar_hukum_kode_rekening', NULL, "dahukorek_id", true);
		$this->load->view('add_kode_rekening', $data);
	}
	
	/**
	 * update anggaran
	 */
	function insert() {
		$return = $this->kode_rekening_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert kode rekening");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit anggaran
	 */
	function edit() {
		$rekening = $this->common_model->get_query('*', 'kode_rekening', "korek_id='".$this->input->post('korek_id')."'");
		$data['row'] = $rekening->row();
		$data['kategori'] = $this->common_model->get_record_list('ref_kakorek_id AS value, ref_kakorek_ket AS item', 'ref_kategori_kode_rekening', NULL, "ref_kakorek_id", true);
		$data['perda'] = $this->common_model->get_record_list('dahukorek_id AS value, dahukorek_no_perda AS item', 'dasar_hukum_kode_rekening', NULL, "dahukorek_id", true);
		$this->load->view('edit_kode_rekening', $data);
	}
	
	/**
	 * update anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['korek_id'] != "") {
			$return = $this->kode_rekening_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update kode rekening id".$_POST['korek_id']);
			}
		}
		
		echo json_encode($result);
	}
	
	/**
	 * delete anggaran
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->kode_rekening_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "d", "Delete kode rekening id ".$arr_id[$i]);	
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
	
	/**
	 * get korek kategory
	 */
	function get_korek_kategori() {
		$kategori = $this->common_model->get_query('*', 'ref_kategori_kode_rekening', "ref_kakorek_id='".$this->input->post('ref_kakorek_id')."'");
		echo  json_encode($kategori->row_array());
	}
	
	/**
	 * update status aktif
	 */
	function update_status_aktif() {
		$this->kode_rekening_model->update_status_aktif($this->input->post('status'), $this->input->post('korek_id'));
	}
	
	/**
	 * cetak daftar korek
	 */
	function cetak() {
		//insert history log
		$this->common_model->history_log("pemeliharaan", "P", "Print daftar kode rekening");
		$this->load->view('pdf_korek_rekening');		
	}
}