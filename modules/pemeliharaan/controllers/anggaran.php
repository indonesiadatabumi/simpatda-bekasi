<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Anggaran class controller
 * @package Simpatda
 */
class Anggaran extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('anggaran_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_anggaran');
	}
	
	/**
	 * get list
	 */
	function get_list() {
		$this->anggaran_model->get_list_anggaran();
	}
	
	/**
	 * add anggaran
	 */
	function add() {
		$data['status_anggaran'] = $this->common_model->get_record_list('ref_statang_id AS value, ref_statang_ket AS item', 'ref_status_tahun_anggaran', NULL, 'ref_statang_ket');
		$this->load->view('add_anggaran', $data);
	}
	
	/**
	 * update anggaran
	 */
	function insert() {
		$return = $this->anggaran_model->insert_tahun_anggaran();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert data anggaran");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit anggaran
	 */
	function edit() {
		$data['status_anggaran'] = $this->common_model->get_record_list('ref_statang_id AS value, ref_statang_ket AS item', 'ref_status_tahun_anggaran', NULL, 'ref_statang_ket');
		$tahun_anggaran = $this->common_model->get_query('*', 'tahun_anggaran', "tahang_id='".$this->input->get('id')."'");
		$data['tahun_anggaran'] = $tahun_anggaran->row();
		$this->load->view('edit_anggaran', $data);
	}
	
	/**
	 * update anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['tahang_id'] != "") {
			$return = $this->anggaran_model->update_tahun_anggaran();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update data anggaran id".$_POST['tahang_id']);
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
			if($this->anggaran_model->delete_tahun_anggaran($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "D", "Delete data anggaran id ".$arr_id[$i]);
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}