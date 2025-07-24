<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * History_log class controller
 * @package Simpatda
 */
class History_log extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_history_log');
	}
}