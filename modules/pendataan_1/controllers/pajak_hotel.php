<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pajak_hotel controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Pajak_hotel extends Master_Controller {
	/**
	 * contructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('pajak_hotel_model');
		$this->load->model('common_model');
		$this->load->model('spt_model');
	}
	
	/**
	 * add sptpd pajak hotel
	 */
	function add() {
		$data['sistem_pemungutan'] = array('1' => 'Self Assesment', '2' => 'Official Assesment');
		$this->load->view('add_pajak_hotel', $data);
	}
	
	/**
	 * edit pajak controller
	 */
	function edit() {
		$sptpd = $this->spt_model->get_sptpd();
		$data['sistem_pemungutan'] = array('1' => 'Self Assesment', '2' => 'Official Assesment');

		if ($sptpd != false) {
			$data['row'] = $sptpd;
			$this->load->view('edit_pajak_hotel', $data);	
		}
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
				$this->common_model->history_log("pendataan", "D", "Delete SPT Pajak Hotel : ".$arr_id[$i]);
			}				
		}
		
		if ($counter != 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
	
	/**
	 * view data
	 */
	function view() {
		$this->load->view('view_pajak_hotel');	
	}
	
	/**
	 * insert data pajak hotel
	 */
	function save() {
		$result = array();
		$wp_id = $this->input->post('wp_wr_id');
		
		if (!empty($wp_id)) {
			$check_masa_pajak = $this->spt_model->check_masa_pajak(
															$wp_id, 
															$this->input->post('spt_periode_jual1'),
															$this->input->post('spt_periode_jual2'),
															$this->input->post('korek'),
															$this->input->post('spt_jenis_pemungutan')
															);
			if (!$check_masa_pajak) {
				//save spt and spt_detail
				$spt_id = $this->spt_model->insert_spt();
				
				if ($spt_id != 0) {
					$this->spt_model->insert_spt_detail($spt_id);
					$result = array('status' => true, 'msg' => 'Data berhasil disimpan');
					
					//insert history log
					$this->common_model->history_log("pendataan", "I", "Insert SPT Pajak Hotel : ".
							$spt_id." | ".$_POST['spt_periode']." | ".$_POST['spt_kode'].$_POST['spt_no_register']." | ".$_POST['wp_wr_nama']." | ".$_POST['spt_pajak']);
				} else {
					$result = array('status' => false, 'msg' => 'Data tidak berhasil disimpan.');
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
	 * update data sptpd
	 */
	function update() {
		$result = array();
		$wp_id = $this->input->post('wp_wr_id');
		
		if (!empty($wp_id)) {
			//update spt and spt_detail
			$check_masa_pajak = $this->spt_model->check_masa_pajak(
															$wp_id, 
															$this->input->post('spt_periode_jual1'),
															$this->input->post('spt_periode_jual2'),
															$this->input->post('korek'),
															$this->input->post('spt_jenis_pemungutan'),
															$this->input->post('spt_id')
															);
			if (!$check_masa_pajak) {
				$return = $this->spt_model->update_spt();
				if ($return) {
					$this->spt_model->update_spt_detail();
					$result = array('status' => true, 'msg' => 'Data berhasil disimpan');
					
					//insert history log
					$this->common_model->history_log("pendataan", "U", "Update SPT Pajak Hotel : ".
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
	 * get list sptpd hotel
	 */
	function get_list() {
		$this->pajak_hotel_model->get_list();
	}
}