<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Jabatan class controller
 * @author Daniel Hutauruk
 */
class Jabatan extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('jabatan_model');
		$this->load->model('common_model');
	}
	
	/**
	 * view function
	 */	
	function view() {
		$this->load->view('view_jabatan');
	}
	
	/**
	 * function to get list
	 */
	function get_list() {
		$this->jabatan_model->get_list();
	}
	
	/**
	 * insert data
	 */
	function insert() {
		$result = $this->jabatan_model->insert();
		if ($result) {
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert data jabatan");
			echo json_encode(array('status' => true, 'msg' => 'Data berhasil disimpan'));			
		} else
			echo json_encode(array('status' => false, 'msg' => 'Data gagal disimpan'));
	}
	
	/**
	 * update data
	 */
	function update() {
		$result = $this->jabatan_model->update();
		if ($result) {
			//insert history log
			$this->common_model->history_log("pemeliharaan", "U", "Update data jabatan");
			
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
			if($this->jabatan_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "d", "Delete data jabatan id ".$arr_id[$i]);	
			}
		}
		
		if ($counter != 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}