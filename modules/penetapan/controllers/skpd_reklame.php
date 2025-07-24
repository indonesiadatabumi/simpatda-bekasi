<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Skpd_reklame Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Skpd_reklame extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->load->view('form_skpd_reklame');
	}
}