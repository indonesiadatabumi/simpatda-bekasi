<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pribadi class controller
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121016
 */
class Dsp_mstr_pemda extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('dsp_mstr_pemda_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$data['data_master'] = $this->dsp_mstr_pemda_model->get_content();
		$this->load->view('view_dsp_mstr_pemda', $data);
	}
}