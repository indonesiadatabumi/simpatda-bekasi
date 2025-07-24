<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Target_anggaran class controller
 * @package Simpatda
 */
class Target_anggaran extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('target_anggaran_model');
	}
	
	/**
	 * view status anggaran
	 */
	function view() {
		if ($_GET['title'] == "")
			$data['title'] = "Target Anggaran";
		else 
			$data['title'] = $_GET['title'];
		$data['tahangdet_id_header'] = $_GET['id'];
			
		$arr_korek = array();
		$kode_rekening = $this->target_anggaran_model->get_rekening();
		foreach ($kode_rekening as $row) {
			$arr_korek[$row->korek_id] = "(".$row->rekening.") ".$row->korek_nama;
		}
		
		$data['kode_rekening'] = $arr_korek;
		$this->load->view('view_target_anggaran', $data);
	}
	
	/**
	 * get list status anggaran
	 */
	function get_list() {
		$this->target_anggaran_model->get_list($_GET['tahang_id']);
	}
	
	/**
	 * get detail anggaran
	 */
	function get_detail() {
		$return = $this->target_anggaran_model->get_detail($_POST['tahangdet_id']);
		
		if ($return->num_rows() > 0) {
			$result = array('status' => TRUE, 'data' => $return->row_array());
		} else {
			$result = array('status' => false, "msg" => "Data tidak ditemukan");
		}
		echo json_encode($result);
	}
	
	/**
	 * insert new status anggaran
	 */
	function insert() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		if ($this->input->post('mode') == "add") {
			$return = $this->target_anggaran_model->insert();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "I", "Insert target anggaran");
			}
		}
		
		echo json_encode($result);
	}
	
	/**
	 * update status anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		if ($this->input->post('mode') == "edit") {
			$return = $this->target_anggaran_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update target anggaran");
			}
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
			if($this->target_anggaran_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "D", "Delete target anggaran");
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}