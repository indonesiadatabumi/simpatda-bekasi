<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Jatuh_tempo class controller
 * @package Simpatda
 */
class Jatuh_tempo extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('jatuh_tempo_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$query = $this->common_model->get_query('*', 'ref_jatuh_tempo');
		$data['row'] = $query->row();
		$this->load->view('view_jatuh_tempo', $data);
	}
	
	/**
	 * update jatuh tempo
	 */
	function update() {
		$return = $this->jatuh_tempo_model->update();
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("pemeliharaan", "U", "Update data jatuh tempo");
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
}