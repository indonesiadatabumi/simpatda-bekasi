<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kecamatan class controller
 * @package Simpatda
 */
class Kecamatan extends Master_Controller {
	/**
	 * kecamatan
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('kecamatan_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_kecamatan');
	}
	
	/**
	 * get list
	 */
	function get_list() {
		$this->kecamatan_model->get_list();
	}
	
	/**
	 * add anggaran
	 */
	function add() {
		$this->load->view('add_kecamatan');
	}
	
	/**
	 * update anggaran
	 */
	function insert() {
		$return = $this->kecamatan_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert data kecamatan");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit anggaran
	 */
	function edit() {
		$kecamatan = $this->common_model->get_query('*', 'kecamatan', "camat_id='".$this->input->post('camat_id')."'");
		$data['kecamatan'] = $kecamatan->row();
		$this->load->view('edit_kecamatan', $data);
	}
	
	/**
	 * update anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['camat_id'] != "") {
			$return = $this->kecamatan_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update data kecamatan id ".$_POST['camat_id']);
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
			if($this->kecamatan_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "D", "Delete data kecamatan ".$arr_id[$i]);
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}