<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Penutupan_wpwr class
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Penonaktifan_wpwr extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('penonaktifan_wpwr_model');
		$this->load->model('common_model');
	}
	/**
	 * index page controller
	 */
	function index() {
		$this->load->view('form_penonaktifan_wpwr');
	}
	
	/**
	 * view penutupan wp
	 */
	function view() {
		$this->load->view('view_wp_nonaktif');
	}
	
	/**
	 * add penutupan
	 */
	function add() {
		$result = $this->penonaktifan_wpwr_model->insert();
		if ($result) {
			//insert history log ($module, $action, $description)
			// $this->common_model->history_log("pendaftaran", "U", "Penutupan data WP id=".$this->input->post('wp_wr_id'));
			
			echo json_encode(array('status' => true, 'msg' => 'WP berhasil dinonaktifkan'));
		} else 
			echo json_encode(array('status' => false, 'msg' => 'WP tidak berhasil dinonaktifkan'));
	}

	// ubah status wp
	function change_status(){
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->penonaktifan_wpwr_model->change_status($arr_id[$i]) == true)
				$counter++;
		}
		
		if ($counter != 0) {
			echo $counter." Status berhasil diganti";
		} else {
			echo "Tidak ada data yang berhasil diubah";
		}
	}
}