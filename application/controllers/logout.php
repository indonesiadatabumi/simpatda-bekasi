<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * class Logout
 * @author		Daniel
 * @copyright 2012
*/

class Logout extends CI_Controller
{	
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('operator_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{		
		$return = $this->operator_model->attempt_logout($this->session->userdata('USER_ID'));
		
		if ($return)
			redirect(base_url().'login');
	}
}
	
	
/* End of file logout.php */
/* Location: ./system/application/controllers/logout.php */