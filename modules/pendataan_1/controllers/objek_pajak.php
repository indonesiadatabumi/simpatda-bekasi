<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Objek_pajak controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Objek_pajak extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		$this->load->model('objek_pajak_model');
	}
	
	/**
	 * popup_jenis_pajak controller
	 */
	function popup_jenis_pajak() {
		$data['jenis_pajak'] = $this->objek_pajak_model->get_ref_jenis_pajak_retribusi();
		$this->load->view('view_popup_jenis_pajak', $data);
	}
}