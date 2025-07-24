<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pribadi class controller
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121016
 */
class Dsp_ref_korek_GB extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('penagihan');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_dsp_ref_korek_GB');
	}
	
	function get_list()
	{
		$data = $this->penagihan->list_dsp_ref_korek_gb();
		echo $data;
	}
}