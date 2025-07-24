<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kelurahan class controller
 * @package Simpatda
 * @author Daniel
 */
class Kelurahan extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('kelurahan_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_kelurahan');
	}
	
	/**
	 * get list
	 */
	function get_list() {
		$this->kelurahan_model->get_list();
	}
	
	/**
	 * add anggaran
	 */
	function add() {
		$data['kecamatan'] = $this->common_model->get_record_list('camat_id AS value, camat_nama AS item', 'kecamatan', NULL, "camat_kode", true);
		$this->load->view('add_kelurahan', $data);
	}
	
	/**
	 * update anggaran
	 */
	function insert() {
		$return = $this->kelurahan_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert data kelurahan");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit anggaran
	 */
	function edit() {
		$dt_data = $this->common_model->get_query('*', 'kelurahan', "lurah_id='".$this->input->post('lurah_id')."'");
		$data['kelurahan'] = $dt_data->row();
		$data['kecamatan'] = $this->common_model->get_record_list('camat_id AS value, camat_nama AS item', 'kecamatan', NULL, "camat_kode", true);
		$this->load->view('edit_kelurahan', $data);
	}
	
	/**
	 * update anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['lurah_id'] != "") {
			$return = $this->kelurahan_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update data kelurahan id ".$_POST['lurah_id']);
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
			if($this->kelurahan_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "D", "Delete data kelurahan ".$arr_id[$i]);
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}