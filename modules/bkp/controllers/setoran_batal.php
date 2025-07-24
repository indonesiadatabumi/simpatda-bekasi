<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Setoran_batal Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Setoran_batal extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		$this->load->model('common_model');
		$this->load->model('objek_pajak_model');
		$this->load->model('setoran_batal_model');
	}
	
	/**
	 * batal_setoran
	 */
	function index() {
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);		
		$keterangan_spt = $this->common_model->get_record_list("ketspt_id as value, ketspt_kode || ' | ' ||ketspt_ket as item",
																		"keterangan_spt", "ketspt_id IS NOT NULL", "ketspt_kode ASC");
		$arr_pilihan[''] = "--";
		$data['keterangan_spt'] = $arr_pilihan + $keterangan_spt;
		$this->load->view('form_batal_setoran', $data);
	}
	
	/**
	 * list setoran batal
	 */
	function get_list() {
		$this->setoran_batal_model->get_list();
	}
	
	/**
	 * insert pembatalan setoran
	 */
	function insert() {
		$result = array();
		$setoran = $this->setoran_batal_model->check_setoran(
												$this->input->post('spt_jenis_pajakretribusi'),
												$this->input->post('spt_periode'),
												$this->input->post('spt_nomor'),
												$this->input->post('setorpajret_jenis_ketetapan')
											);
		
		if ($setoran->num_rows() > 0) {
			$row_setoran = $setoran->row_array();
			
			$id_setoran = $row_setoran['setorpajret_id'];
			
			//check into setoran_ke_bank_detail is exist
			$setoran_bank = $this->setoran_batal_model->check_setoran_bank($id_setoran);
			
			if ($setoran_bank->num_rows() > 0) {
				$row_setoran_bank = $setoran_bank->row();
				
				//apakah sudah di validasi atau belum
				if ($row_setoran_bank->skbh_validasi == 't') {
					$result = array('status' => TRUE, 'msg' => 'Setoran sudah divalidasi. Silahkan hapus STS terlebih dahulu');
				} else {
					if ($setoran_bank->num_rows() == 1) {
						$return = $this->setoran_batal_model->delete_setoran_bank_detail($row_setoran_bank->skbd_id);
						if ($return) {
							$this->setoran_batal_model->delete_setoran_bank_header($row_setoran_bank->skbh_id);
							
							//delete setoran
							$return = $this->setoran_batal_model->delete_setoran($id_setoran);
							
						}
					} else {
						//just delete setoran_bank_detail
						$return = $this->setoran_batal_model->delete_setoran_bank_detail_by_setoran_id($id_setoran);
						if ($return) {
							//delete setoran
							$return = $this->setoran_batal_model->delete_setoran($id_setoran);
						}
					}
					
					if ($return) {
						$this->setoran_batal_model->insert_setoran_batal($row_setoran);
						$result = array('status' => TRUE, 'msg' => 'Setoran berhasil dibatalkan');
					} else 
						$result = array('status' => FALSE, 'msg' => 'Setoran gagal dibatalkan');
				}
			} else {
				//delete setoran
				$return = $this->setoran_batal_model->delete_setoran($id_setoran);

				if ($return) {
					//insert into setoran_pajak_retribusi_batal
					$this->setoran_batal_model->insert_setoran_batal($row_setoran);
					
					$result = array('status' => TRUE, 'msg' => 'Setoran berhasil dibatalkan');
				} else 
					$result = array('status' => FALSE, 'msg' => 'Setoran gagal dibatalkan');
			}
			
			echo json_encode($result);
		} else {
			echo json_encode(array('status' => FALSE, 'msg' => 'Setoran tidak ditemukan'));
		}
	}
}