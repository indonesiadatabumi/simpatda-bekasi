<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pribadi class controller
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121016
 */
class Dsp_form_cetak_surat_teguran_lapor extends Master_Controller {

	function __construct() {
		parent::__construct();
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_form_cetak_surat_teguran_lapor');
	}
}