<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kode_usaha class controller
 * @package Simpatda
 * @author Daniel H
 */
class Kode_usaha extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('kode_usaha_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_kode_usaha');
	}
	
	/**
	 * get list
	 */
	function get_list() {
		$this->kode_usaha_model->get_list();
	}
	
	/**
	 * add anggaran
	 */
	function add() {
		$this->load->view('add_kode_usaha');
	}
	
	/**
	 * update anggaran
	 */
	function insert() {
		$return = $this->kode_usaha_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert data kode usaha");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit anggaran
	 */
	function edit() {
		$query = $this->common_model->get_query('*', 'ref_kode_usaha', "ref_kodus_id='".$this->input->post('ref_kodus_id')."'");
		$data['row'] = $query->row();
		$this->load->view('edit_kode_usaha', $data);
	}
	
	/**
	 * update anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['ref_kodus_id'] != "") {
			$return = $this->kode_usaha_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update data kode usaha id ".$_POST['ref_kodus_id']);
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
			if($this->kode_usaha_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "d", "Delete data kode usaha id ".$arr_id[$i]);
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}