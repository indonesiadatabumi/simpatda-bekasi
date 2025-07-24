<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pribadi class controller
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121016
 */
class Dsp_mstr_kecamatan extends Master_Controller {

	function __construct() {
		parent::__construct();
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_dsp_mstr_kecamatan');
	}
}