<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pos_anggaran class controller
 * @package Simpatda
 * @author Daniel
 */
class Pos_anggaran extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('pos_anggaran_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_pos_anggaran');
	}
	
	/**
	 * get list
	 */
	function get_list() {
		$this->pos_anggaran_model->get_list();
	}
	
	/**
	 * add anggaran
	 */
	function add() {
		$this->load->view('add_pos_anggaran');
	}
	
	/**
	 * update anggaran
	 */
	function insert() {
		$return = $this->pos_anggaran_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert data pos anggaran");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit anggaran
	 */
	function edit() {
		$pos_anggaran = $this->common_model->get_query('*', 'pos_anggaran', "posang_id='".$this->input->post('posang_id')."'");
		$data['row'] = $pos_anggaran->row();
		$this->load->view('edit_pos_anggaran', $data);
	}
	
	/**
	 * update anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['posang_id'] != "") {
			$return = $this->pos_anggaran_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update data pos anggaran id ".$_POST['posang_id']);
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
			if($this->pos_anggaran_model->delete($arr_id[$i]) == true) {
				$counter++;
				$this->common_model->history_log("pemeliharaan", "d", "Delete pos anggaran id ".$arr_id[$i]);	
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}