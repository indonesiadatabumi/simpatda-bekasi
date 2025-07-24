<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Golongan class controller
 * @author Daniel Hutauruk
 */
class Golongan extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('golongan_model');
		$this->load->model('common_model');
	}
	
	/**
	 * view function
	 */	
	function view() {
		$this->load->view('view_golongan');
	}
	
	/**
	 * function to get list
	 */
	function get_list() {
		$this->golongan_model->get_list();
	}
	
	/**
	 * insert data
	 */
	function insert() {
		$result = $this->golongan_model->insert();
		if ($result) {
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert data golongan");
			echo json_encode(array('status' => true, 'msg' => 'Data berhasil disimpan'));			
		} else
			echo json_encode(array('status' => false, 'msg' => 'Data gagal disimpan'));
	}
	
	/**
	 * update data
	 */
	function update() {
		$result = $this->golongan_model->update();
		if ($result) {
			//insert history log
			$this->common_model->history_log("pemeliharaan", "u", "Update data golongan");
			echo json_encode(array('status' => true, 'msg' => 'Data berhasil disimpan'));
		} else
			echo json_encode(array('status' => false, 'msg' => 'Data gagal disimpan'));
	}
	
	/**
	 * delete data
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->golongan_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "d", "Delete data golongan id ".$arr_id[$i]);
			}
		}
		
		if ($counter != 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}