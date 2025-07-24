<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Penutupan_wpwr class
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Penutupan_wpwr extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('penutupan_wpwr_model');
		$this->load->model('common_model');
	}
	/**
	 * index page controller
	 */
	function index() {
		$this->load->view('form_penutupan_wpwr');
	}
	
	/**
	 * view penutupan wp
	 */
	function view() {
		$this->load->view('view_wp_tutup');
	}
	
	/**
	 * add penutupan
	 */
	function add() {
		$result = $this->penutupan_wpwr_model->insert();
		if ($result) {
			//insert history log ($module, $action, $description)
			$this->common_model->history_log("pendaftaran", "U", "Penutupan data WP id=".$this->input->post('wp_wr_id'));
			
			echo json_encode(array('status' => true, 'msg' => 'WP berhasil ditutup'));
		} else 
			echo json_encode(array('status' => false, 'msg' => 'WP tidak berhasil ditutup'));
	}
}