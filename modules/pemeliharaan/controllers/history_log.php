<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * History_log class controller
 * @package Simpatda
 */
class History_log extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('history_log_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_history_log');
	}
	
	/**
	 * get list
	 */
	function get_list() {
		$this->history_log_model->get_list();
	}
	
	/**
	 * delete history log
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->history_log_model->delete($arr_id[$i]) == true)
				$counter++;
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}