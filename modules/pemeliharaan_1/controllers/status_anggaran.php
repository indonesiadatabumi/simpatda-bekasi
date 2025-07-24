<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Status_anggaran class controller
 * @package Simpatda
 */
class Status_anggaran extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('status_anggaran_model');
	}
	
	/**
	 * view status anggaran
	 */
	function view() {
		$this->load->view('view_status_anggaran');
	}
	
	/**
	 * get list status anggaran
	 */
	function get_list() {
		$this->status_anggaran_model->get_list();
	}
	
	/**
	 * insert new status anggaran
	 */
	function insert() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		if ($this->input->post('mode') == "add") {
			$return = $this->status_anggaran_model->insert($this->input->post('ref_statang_ket'));
			
			if ($return)
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * update status anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		if ($this->input->post('mode') == "edit") {
			$return = $this->status_anggaran_model->update($this->input->post('ref_statang_id'), $this->input->post('ref_statang_ket'));
			
			if ($return)
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * delete status anggaran
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->status_anggaran_model->delete($arr_id[$i]) == true)
				$counter++;
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}