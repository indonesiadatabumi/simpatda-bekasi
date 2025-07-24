<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The My Controller class
 */
class Master_Controller extends MX_Controller {
	var $data = array();
	
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		
		$segment=$this->uri->segment(0);
		if ($this->session->userdata('USER_ID') == null && $segment != "login")
				redirect('login');
	}
}