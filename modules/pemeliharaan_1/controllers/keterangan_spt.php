<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Keterangan_spt class controller
 * @package Simpatda
 * @author Daniel H
 */
class Keterangan_spt extends Master_Controller {
	/**
	 * contructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('keterangan_spt_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_keterangan_spt');
	}
	
/**
	 * get list
	 */
	function get_list() {
		$this->keterangan_spt_model->get_list();
	}
	
	/**
	 * add anggaran
	 */
	function add() {
		$this->load->view('add_keterangan_spt');
	}
	
	/**
	 * update anggaran
	 */
	function insert() {
		$return = $this->keterangan_spt_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert Data Keterangan SPT");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit anggaran
	 */
	function edit() {
		$keterangan = $this->common_model->get_query('*', 'keterangan_spt', "ketspt_id='".$this->input->post('ketspt_id')."'");
		$data['row'] = $keterangan->row();
		$this->load->view('edit_keterangan_spt', $data);
	}
	
	/**
	 * update anggaran
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['ketspt_id'] != "") {
			$return = $this->keterangan_spt_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update Data Keterangan SPT id ".$_POST['ketspt_id']);
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
			if($this->keterangan_spt_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "d", "Delete Data Keterangan SPT id ".$arr_id[$i]);
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}