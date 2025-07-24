<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SKPD Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Stpd extends Master_Controller {
	/**
	 * construct
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('stpd_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index controller
	 */
	function index() {
		$this->load->view('view_stpd');
	}
	
	/**
	 * get list skpd
	 */
	function get_list_penetapan() {
		$this->stpd_model->get_list_penetapan();
	}
	
	function get_spt() {
		$get = '';
		if (is_array($_GET)) {
			foreach ($_GET as $key => $value) {
				$get .= "&".$key."=".$value;
			}	
		}
		$data['flexigrid_url'] = base_url()."penetapan/stpd/get_data_spt?sqtype=&squery=".$get;
		$this->load->view('popup_spt', $data);
	}
	
	/**
	 * get list spt
	 */
	function get_data_spt() {
		$this->stpd_model->get_spt();
	}
	
	function add() {
		$this->load->model('objek_pajak_model');
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$this->load->view('form_stpd', $data);
	}
	
	function insert() {
		$result = $this->stpd_model->insert();
		echo json_encode($result);
	}
	
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->stpd_model->delete($arr_id[$i]) == true)
				$counter++;
		}
		
		if ($counter != 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}