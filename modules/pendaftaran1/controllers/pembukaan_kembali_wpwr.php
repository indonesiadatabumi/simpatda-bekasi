<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pembukaan_kembali_wpwr class controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Pembukaan_kembali_wpwr extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('pembukaan_kembali_wpwr_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$this->load->view('form_pembukaan_kembali_wpwr');
	}
	
	/**
	 * save pembukaan_kembali
	 */
	function save() {		
		$result = $this->pembukaan_kembali_wpwr_model->save();
		if ($result == true) {
			//insert history log ($module, $action, $description)
			$this->common_model->history_log("pendaftaran", "U", "Pembukaan kembali data WP id=".$this->input->post('wp_wr_id'));
			
			echo json_encode(array('status' => true, 'msg' => 'WP berhasil diaktifkan kembali'));
		} else 
			echo json_encode(array('status' => false, 'msg' => 'WP tidak berhasil diaktifkan. Silahkan periksa kembali'));
	}
}