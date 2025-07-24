<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Satuan_kerja class controller
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121016
 */
class Satuan_kerja extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('satuan_kerja_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_satuan_kerja');
	}
	
	/**
	 * get list
	 */
	function get_list() {
		$this->satuan_kerja_model->get_list();
	}
	
	/**
	 * add anggaran
	 */
	function add() {
		$data['bidang'] = $this->common_model->get_record_list('bdg_id AS value, bdg_nama AS item', 'bidang', NULL, "bdg_nama", true);
		$this->load->view('add_satuan_kerja', $data);
	}
	
	/**
	 * update anggaran
	 */
	function insert() {
		$return = $this->satuan_kerja_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			
			//insert history log
			$this->common_model->history_log("pemeliharaan", "I", "Insert satuan kerja");	
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit anggaran
	 */
	function edit() {
		$query = $this->common_model->get_query('*', 'skpd', "skpd_id='".$this->input->post('skpd_id')."'");
		$data['row'] = $query->row();
		$data['bidang'] = $this->common_model->get_record_list('bdg_id AS value, bdg_nama AS item', 'bidang', NULL, "bdg_nama", true);
		$this->load->view('edit_satuan_kerja', $data);
	}
	
	/**
	 * update satuan kerja
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['skpd_id'] != "") {
			$return = $this->satuan_kerja_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
				
				//insert history log
				$this->common_model->history_log("pemeliharaan", "U", "Update satuam kerja, id ".$_POST['skpd_id']);
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
			if($this->satuan_kerja_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pemeliharaan", "D", "Delete satuan kerja ".$arr_id[$i]);
			}
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
	
	function instansi() {
		$this->satuan_kerja_model->instansi($this->input->post('status'), $this->input->post('skpd_id'));
	}
}