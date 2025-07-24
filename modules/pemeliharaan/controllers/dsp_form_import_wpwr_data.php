<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pribadi class controller
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121016
 */
class Dsp_form_import_wpwr_data extends Master_Controller {

	function __construct() {
		parent::__construct();
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_dsp_form_import_wpwr_data');
	}
}