<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SKPD Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Skpd extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('skpd_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index controller
	 */
	function index() {
		$this->load->model('objek_pajak_model');
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$this->load->view('form_skpd', $data);
	}
	
	/**
	 * get spt yang akan ditetapkan
	 */
	function get_spt() {
		$get = '';
		if (is_array($_GET)) {
			foreach ($_GET as $key => $value) {
				$get .= "&".$key."=".$value;
			}	
		}
		$data['flexigrid_url'] = base_url()."penetapan/skpd/get_data_spt?sqtype=&squery=".$get;
		$this->load->view('popup_spt', $data);
	}
	
	/**
	 * get list spt
	 */
	function get_data_spt() {
		$this->skpd_model->get_spt();
	}
	
	/**
	 * insert skpd
	 */
	function insert() {
		$return = $this->skpd_model->insert();
		echo json_encode($return);
	}
	
	/**
	 * view skpd controller
	 */
	function view() {
		$this->load->view('view_skpd');
	}
	
	/**
	 * get list skpd
	 */
	function get_list_penetapan() {
		$this->skpd_model->get_list_penetapan();
	}
	
	/**
	 * delete penetapan
	 */
	function delete() {		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->skpd_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("penetapan", "d", "Delete data penetapan : ".$arr_id[$i]);	
			}
		}
		
		echo "Data berhasil dihapus";
	}
}