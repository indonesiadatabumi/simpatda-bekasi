<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * class Rekening 
 * @author Daniel
 * @package Simpatda
 * @version 20121028
 */
class Rekening extends CI_Controller
{
	/**
	 * constructor
	 */
	function __construct(){
		parent::__construct();
		$this->load->model('rekening_model');
	}
	
	/**
	 * get popup_rekening controller
	 */
	function popup_rekening() {
		$get = '';
		if (is_array($_GET)) {
			foreach ($_GET as $key => $value) {
				$get .= "&".$key."=".$value;
			}	
		}
		$data['flexigrid_url'] = base_url()."rekening/get_grid_list?sqtype=&squery=".$get;
		$this->load->view('popup_rekening', $data);
	}
	
	/**
	 * get popup_rekening 5 digit controller
	 */
	function popup_rekening5digit() {
		$data['flexigrid_url'] = base_url()."rekening/get_rekening_list?sqtype=&squery=";
		$this->load->view('popup_rekening', $data);
	}
	
	/**
	 * get list rekening
	 */
	function get_grid_list() {
		echo $this->rekening_model->get_grid_list();
	}
	
	/**
	 * get rekening list
	 */
	function get_rekening_list() {
		echo $this->rekening_model->get_rekening_list();
	}
	
	/**
	 * get array list
	 */
	function get_arr_list(){
		$koderek = $this->input->get('koderek');
		
		echo json_encode($this->rekening_model->get_arr_list($koderek));
	}
	
	/**
	 * get retribusi list
	 */
	function get_rekening_retribusi() {
		$rekening = $this->rekening_model->get_rekening_retribusi();
		echo json_encode($rekening);		
	}
	
	/**
	 * find rekening from input user
	 */
	function find_rekening() {
		$result = array();
		$return = $this->rekening_model->find_rekening();
		
		if ($return != false)
			$result = array('status' => true, 'data' => $return);
		else
			$result = array('status' => false, 'msg' => 'Rekening tidak ditemukan');
	
		echo json_encode($result);
	}
}