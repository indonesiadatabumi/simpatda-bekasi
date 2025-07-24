<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Operator class controller
 * @package Simpatda
 * @author Daniel M
 */
class Operator extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('operator_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_operator');
	}
	
	/**
	 * get list
	 */
	function get_list() {
		$this->operator_model->get_list();
	}
	
	/**
	 * add operator
	 */
	function add() {
		$data['jabatan'] = $this->common_model->get_record_list('ref_jab_id AS value, ref_jab_nama AS item', 'ref_jabatan', NULL, "ref_jab_id", true);
		$data['status_aktif'] = array('' => "--", 't' => 'Aktif', 'f' => 'Tidak Aktif');
		$data['status_admin'] = array('' => "--", 't' => 'Ya', 'f' => 'Tidak');
		$this->load->view('add_operator', $data);
	}
	
	/**
	 * update operator
	 */
	function insert() {
		$return = $this->operator_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert data operator");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit operator
	 */
	function edit() {
		$data['jabatan'] = $this->common_model->get_record_list('ref_jab_id AS value, ref_jab_nama AS item', 'ref_jabatan', NULL, "ref_jab_id", true);
		$data['status_aktif'] = array('' => "--", 't' => 'Aktif', 'f' => 'Tidak Aktif');
		$data['status_admin'] = array('' => "--", 't' => 'Ya', 'f' => 'Tidak');
		
		$operator = $this->common_model->get_query('*', 'operator', "opr_id='".$this->input->post('opr_id')."'");
		$data['row'] = $operator->row();
		$this->load->view('edit_operator', $data);
	}
	
	/**
	 * update operator
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['opr_id'] != "") {
			$return = $this->operator_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update data operator id ".$_POST['opr_id']);
			}
		}
		
		echo json_encode($result);
	}
	
	/**
	 * delete operator
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->operator_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "d", "Delete data operator id ".$arr_id[$i]);
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}