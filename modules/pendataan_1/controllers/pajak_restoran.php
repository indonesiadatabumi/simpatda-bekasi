<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pajak_restoran controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Pajak_restoran extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('spt_model');
		$this->load->model('pajak_restoran_model');
	}
	
	/**
	 * add pajak restoran
	 */
	function add() {
		$data['sistem_pemungutan'] = array('1' => 'Self Assesment', '2' => 'Official Assesment');
		$data['jenis_pajak_restoran'] = array('1' => 'Rumah Makan', '2' => 'Catering');
		$this->load->view('add_pajak_restoran', $data);
	}
	
	function add_katering() {
		$data['sistem_pemungutan'] = array('1' => 'Self Assesment', '2' => 'Official Assesment');
		$data['jenis_pajak_restoran'] = array('2' => 'Catering');
		$this->load->view('add_pajak_restoran_katering', $data);
	}
	/**
	 * insert data sptpd restoran
	 */
	function save() {
		$result = array();
		$wp_id = $this->input->post('wp_wr_id');
		
		if (!empty($wp_id)) {
			if ($this->input->post('jenis_pajak_restoran') == "1") {
				$check_masa_pajak = $this->pajak_restoran_model->check_masa_pajak(
															$wp_id, 
															$this->input->post('spt_periode_jual1'),
															$this->input->post('spt_periode_jual2'),
															$this->input->post('spt_jenis_pemungutan'),
															"",
															1
															);
			} else {
				$check_masa_pajak = false;
			}
			
			if (!$check_masa_pajak) {
				//save spt and spt_detail
				$spt_id = $this->spt_model->insert_spt();
				
				if ($spt_id != 0) {
					//insert spt_detail
					$this->spt_model->insert_spt_detail($spt_id);
					
					//insert data into spt_restoran
					if ($this->session->userdata('USER_SPT_CODE') == "10")
						$this->pajak_restoran_model->insert_spt_restoran($spt_id);
					
					$result = array('status' => true, 'msg' => 'Data berhasil disimpan');
					//insert history log
					$this->common_model->history_log("pendataan", "i", "Insert SPT Pajak Restoran : ".
							$spt_id." | ".$_POST['spt_periode']." | ".$_POST['spt_kode'].$_POST['spt_no_register']." | ".$_POST['wp_wr_nama']." | ".$_POST['spt_pajak']);
				} else {
					$result = array('status' => false, 'msg' => 'Data tidak berhasil disimpan');
				}
			} else {
				$result = array('status' => false, 'msg' => 'WPWR untuk periode penjualan yang sama sudah pernah diinput');
			}
		} else {
			$result = array('status' => false, 'msg' => 'Silahkan masukkan data WP terlebih dahulu');
		}
		
		echo json_encode($result);
	}
	
	
	/**
	 * view data
	 */
	function view() {
		$this->load->view('view_pajak_restoran');	
	}
	
	/**
	 * get list sptpd hotel
	 */
	function get_list() {
		$this->pajak_restoran_model->get_list();
	}
	
	/**
	 * edit sptpd controller
	 */
	function edit() {
		$sptpd = $this->spt_model->get_sptpd();
		$data['sistem_pemungutan'] = array('1' => 'Self Assesment', '2' => 'Official Assesment');
		$data['jenis_pajak_restoran'] = array('1' => 'Rumah Makan', '2' => 'Catering');		
		$data['dt_pajak_restoran'] = $this->pajak_restoran_model->get_spt_restoran($this->input->post('spt_id'));

		if ($sptpd != false) {
			$data['row'] = $sptpd;
			$this->load->view('edit_pajak_restoran', $data);	
		}
	}
	
	/**
	 * update data sptpd
	 */
	function update() {
		$result = array();
		$wp_id = $this->input->post('wp_wr_id');
		
		if (!empty($wp_id)) {
			//update spt and spt_detail
			if ($this->input->post('jenis_pajak_restoran') == "1") {
				$check_masa_pajak = $this->spt_model->check_masa_pajak(
																$wp_id, 
																$this->input->post('spt_periode_jual1'),
																$this->input->post('spt_periode_jual2'),
																$this->input->post('korek'),
																$this->input->post('spt_jenis_pemungutan'),
																$this->input->post('spt_id')
																);
			} else {
				$check_masa_pajak = false;
			}
			
			if (!$check_masa_pajak) {
				$return = $this->spt_model->update_spt();
				if ($return) {
					$this->spt_model->update_spt_detail();
					
					//update spt_restoran
					if ($this->session->userdata('USER_SPT_CODE') == "10")
						$this->pajak_restoran_model->update_spt_restoran($this->input->post('spt_id'));
						
					$result = array('status' => true, 'msg' => 'Data berhasil disimpan');
					
					//insert history log
					$this->common_model->history_log("pendataan", "U", "Update SPT Pajak Restoran : ".
							$_POST['spt_id']." | ".$_POST['spt_periode']." | ".$_POST['spt_no_register']." | ".$_POST['wp_wr_nama']." | ".$_POST['spt_pajak']);
				}
				else 
					$result = array('status' => false, 'msg' => 'Data tidak berhasil disimpan');
			} else {
				$result = array('status' => false, 'msg' => 'WPWR untuk periode penjualan yang sama sudah pernah diinput');
			}				
		} else {
			$result = array('status' => false, 'msg' => 'Silahkan masukkan data WP terlebih dahulu');
		}
		
		echo json_encode($result);
	}
	
	/**
	 * deleta data pajak
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->spt_model->delete_spt_all($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pendataan", "D", "Delete SPT Pajak Restoran : ".$arr_id[$i]);
			}
		}
		
		if ($counter != 0) {				
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}