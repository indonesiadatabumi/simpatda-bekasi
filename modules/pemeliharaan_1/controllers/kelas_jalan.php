<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kelas_jalan class controller
 * @package Simpatda
 * @author Daniel H
 */
class Kelas_jalan extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('kelas_jalan_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_kelas_jalan');
	}
	
	function get_list() {
		$this->kelas_jalan_model->get_list();
	}
	
	/**
	 * add kelas jalan
	 */
	function add() {
		$this->load->view('add_kelas_jalan');
	}
	
	/**
	 * update anggaran
	 */
	function insert() {
		$return = $this->kelas_jalan_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert data kelas jalan reklame");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit anggaran
	 */
	function edit() {
		$query = $this->common_model->get_query('*', 'ref_rek_klas_jalan', "ref_rkj_id='".$this->input->post('ref_rkj_id')."'");
		$data['row'] = $query->row();
		$this->load->view('edit_kelas_jalan', $data);
	}
	
	/**
	 * update anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['ref_rkj_id'] != "") {
			$return = $this->kelas_jalan_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update data kelas jalan reklame id ".$_POST['ref_rkj_id']);
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
			if($this->kelas_jalan_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "d", "Delete data kelas jalan reklame id ".$arr_id[$i]);
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}