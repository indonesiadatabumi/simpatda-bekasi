<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Nilai_kelas_jalan class controller
 * @package Simpatda
 * @author Daniel H
 */
class Nilai_kelas_jalan extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('nilai_kelas_jalan_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_nilai_kelas_jalan');
	}
	
	/**
	 * get list kelas jalan
	 */
	function get_list() {
		$this->nilai_kelas_jalan_model->get_list();
	}
	
	/**
	 * add kelas jalan
	 */
	function add() {
		$data['rekening'] = $this->common_model->get_record_list('korek_id as value, korek_nama as item', 'kode_rekening', 'korek_id IN (26, 27,30)');
		$data['kelas_jalan'] = $this->common_model->get_record_list('ref_rkj_id as value, ref_rkj_nama as item', 'ref_rek_klas_jalan');
		$this->load->view('add_nilai_kelas_jalan', $data);
	}
	
	/**
	 * update anggaran
	 */
	function insert() {
		$return = $this->nilai_kelas_jalan_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert data nilai kelas jalan reklame");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit anggaran
	 */
	function edit() {
		$data['rekening'] = $this->common_model->get_record_list('korek_id as value, korek_nama as item', 'kode_rekening', 'korek_id IN (26, 27,30)');
		$data['kelas_jalan'] = $this->common_model->get_record_list('ref_rkj_id as value, ref_rkj_nama as item', 'ref_rek_klas_jalan');
		$query = $this->common_model->get_query('*', 'ref_rek_nilai_kelas_jalan', "id='".$this->input->post('id')."'");
		$data['row'] = $query->row();
		$this->load->view('edit_nilai_kelas_jalan', $data);
	}
	
	/**
	 * update anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['id'] != "") {
			$return = $this->nilai_kelas_jalan_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update data nilai kelas jalan reklame");
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
			if($this->nilai_kelas_jalan_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "D", "Delete data nilai kelas jalan reklame id ".$arr_id[$i]);
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}