<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pribadi class controller
 * @package Simpatda
 * @author Angga Pratama
 */
class Dsp_list_kelas_jalan extends Master_Controller {

	function __construct() {
		parent::__construct();
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_dsp_list_kelas_jalan');
	}
	
	function get_list() {
		
	}
	
	function add()
	{
		
	}
	
	function edit() {
		
	}
	
	function delete() {
		
	}
}