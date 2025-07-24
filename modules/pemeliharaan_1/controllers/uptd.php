<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Uptd class controller
 * @package Simpatda
 */
class Uptd extends Master_Controller {
	/**
	 * kecamatan
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('uptd_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_uptd');
	}
	
	/**
	 * get list
	 */
	function get_list() {
		$this->uptd_model->get_list();
	}
	
	/**
	 * add anggaran
	 */
	function add() {
		$this->load->view('add_uptd');
	}
	
	/**
	 * update anggaran
	 */
	function insert() {
		$return = $this->uptd_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert data UPTD ");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit anggaran
	 */
	function edit() {
		$uptd = $this->common_model->get_query('*', 'ref_uptd', "uptd_id='".$this->input->post('uptd_id')."'");
		$data['row'] = $uptd->row();
		$this->load->view('edit_uptd', $data);
	}
	
	/**
	 * update anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['uptd_id'] != "") {
			$return = $this->uptd_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update data UPTD id ".$_POST['uptd_id']);
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
			if($this->uptd_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "D", "Delete data UPTD ".$arr_id[$i]);
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}