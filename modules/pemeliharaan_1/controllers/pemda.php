<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pemda class controller
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121016
 */
class Pemda extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('pemda_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$data['data_master'] = $this->pemda_model->get_content();
		$this->load->view('view_pemda', $data);
	}
	
	/**
	 * update data pemda
	 */
	function update() {
		$return = $this->pemda_model->update();
		if ($return) {
			//insert history log
			$this->common_model->history_log("pemeliharaan", "U", "Update data pemda");	
			
			echo json_encode(array('status' => TRUE, 'msg' => 'Data berhasil disimpan'));
		} else {
			echo json_encode(array('status' => TRUE, 'msg' => 'Data berhasil disimpan'));
		}
	}
}