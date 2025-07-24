<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Setoran_dinas Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Setoran_dinas extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('setoran_dinas_model');
	}
	
	/**
	 * index page
	 */
	function index() {
		$skpd = $this->common_model->get_record_list('skpd_id as value, skpd_nama as item', 'skpd', null, 'skpd_kode ASC', true);
		$data['skpd'] = $skpd;
		$this->load->view('add_setoran_dinas', $data);
	}
	
	/**
	 * get list setoran
	 */
	function get_list_setoran() {
		$this->setoran_dinas_model->get_list_setoran();
	}
	
	/**
	 * save data
	 */
	function save() {
		$result = $this->setoran_dinas_model->save();
		if ($result) {
			echo json_encode(array('status' => true, 'msg' => 'Data berhasil disimpan'));
		} else {
			echo json_encode(array('status' => false, 'msg' => 'Data gagal disimpan'));
		}
	}
	
	/**
	 * view data
	 */
	function view() {
		$this->load->view('view_setoran_dinas');
	}
	
	/**
	 * edit setoran dinas
	 */
	function edit() {
		$data['skpd'] = $this->common_model->get_record_list('skpd_id as value, skpd_nama as item', 'skpd', null, 'skpd_kode ASC', true);
		$data['header'] = $this->setoran_dinas_model->get_header($this->input->post('id'));
		$data['detail'] = $this->setoran_dinas_model->get_detail($this->input->post('id'));
		//load rekening
		$this->load->model('rekening_model');
		$data['rekening'] = $this->rekening_model->get_rekening_retribusi();		
		$this->load->view('edit_setoran_dinas', $data);
	}
	
	/**
	 * update setoran dinas
	 */
	function update() {
		//update spt and spt_detail
		$slh_id = $this->input->post('slh_id');
		$return = $this->setoran_dinas_model->update_header($slh_id);
		if ($return) {
			$this->setoran_dinas_model->update_detail($slh_id);
			$result = array('status' => true, 'msg' => 'Data berhasil disimpan');
		}
		else 
			$result = array('status' => false, 'msg' => 'Data tidak berhasil disimpan');	
			
		echo json_encode($result);
	}
	
	/**
	 * delete setoran dinas
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->setoran_dinas_model->delete($arr_id[$i]) == true)
				$counter++;
		}
		
		if ($counter > 0) {
			echo json_encode(array('status' => true, 'msg' => $counter." data berhasil dihapus"));
		} else {
			echo json_encode(array('status' => false, 'msg' => "Tidak ada data yang berhasil dihapus"));
		}
	}
}