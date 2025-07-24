<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * LHP controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Lhp extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('lhp_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$this->load->view('form_lhp');
	}
	
	/**
	 * get wp from LHP
	 */
	function get_wp() {
		$this->load->view('popup_lhp');
	}
	
	/**
	 * get list wp
	 */
	function get_list_wp() {
		$this->lhp_model->get_list_wp();
	}
	
	/**
	 * insert penetapan LHP
	 */
	function insert() {
		$result = $this->lhp_model->insert();
		echo json_encode($result);
	}
	
	/**
	 * view penetapan LHP
	 */
	function view() {
		$this->load->view('view_lhp');
	}
	
	function get_list_penetapan() {
		$this->lhp_model->get_list_penetapan();
	}
	
	function delete() {
		$result = "";
		$counter = 0;
		
		$this->load->model('skpd_model');
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->skpd_model->delete($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("penetapan", "d", "Delete data penetapan LHP : ".$arr_id[$i]);	
			}
		}
		
		if ($counter != 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}