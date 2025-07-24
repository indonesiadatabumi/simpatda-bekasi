<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cart Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Cart extends Master_Controller {
	
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('cart_model');
	}
	
	/**
	 * index page controller
	 */
	function add_cart() {
		$result = $this->cart_model->validate_add_cart();
		
		echo json_encode($result);
	}
	
	/**
	 * check cart
	 */
	function check_cart() {
		if ($this->cart->total_items() > 0) {			
			$result = array('status' => true, "total" => $this->cart->total_items());
		} else {
			$result = array('status' => false, 'msg' => "Penampungan masih kosong");
		}		
		
		echo json_encode($result);
	}
	
	/**
	 * empty cart
	 */
	function empty_cart() {
		$result = array();
		if ($this->cart->total() > 0) {
			$this->cart->destroy();
			
			$result = array('status' => true, 'msg' => "Penampungan berhasil dikosongkan");
		} else {
			$result = array('status' => false, 'msg' => "Penampungan masih kosong");
		}		
		
		echo json_encode($result);
	}
}