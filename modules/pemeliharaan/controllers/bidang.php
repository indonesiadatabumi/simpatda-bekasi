<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Bidang class controller
 * @package Simpatda
 */
class Bidang extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('bidang_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_bidang');
	}
	
	/**
	 * get list bidang
	 */
	function get_list() {
		$this->bidang_model->get_list();
	}
	
	/**
	 * add new bidang
	 */
	function add() {
		$urusan = $this->common_model->get_query('*', 'ref_urusan', NULL, 'ref_urus_id');
		$dt_urusan[''] = "--";
		foreach ($urusan->result() as $row)
			$dt_urusan[$row->ref_urus_id] = "(".$row->ref_urus_id.") ".$row->ref_urus_nama;
			
		$data['dt_urusan'] = $dt_urusan;
		$this->load->view('add_bidang', $data);
	}
	
	/**
	 * insert bidang
	 */
	function insert() {
		$return = $this->bidang_model->insert();
		
		if ($return) {
			$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
		} else {
			$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit bidang
	 */
	function edit() {
		$kecamatan = $this->common_model->get_query('*', 'kecamatan', "camat_id='".$this->input->post('camat_id')."'");
		$data['kecamatan'] = $kecamatan->row();
		$this->load->view('edit_kecamatan', $data);
	}
	
	/**
	 * update bidang
	 */
	function update() {
		$result = array('status' => FALSE, 'msg' => $this->config->item('msg_fail'));
		
		if ($_POST['camat_id'] != "") {
			$return = $this->kecamatan_model->update();
			
			if ($return) {
				$result = array('status' => TRUE, 'msg' => $this->config->item('msg_success'));
			}
		}
		
		echo json_encode($result);
	}
	
	/**
	 * delete bidang
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->kecamatan_model->delete($arr_id[$i]) == true)
				$counter++;
		}
		
		if ($counter > 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}