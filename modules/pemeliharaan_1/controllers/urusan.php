<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Urusan class controller
 * @package Simpatda
 */
class Urusan extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('urusan_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_urusan');
	}
}