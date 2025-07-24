<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Setor_bank Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121112
 */
class Setor_bank extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('setor_bank_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$this->load->model('objek_pajak_model');
		
		$data['bukti_setoran'] = array(
									'1' => 'SSPD',
									'2' => 'K l i r i n g',
									'3' => 'STS'
								);
		$data['uptd'] = $this->get_uptd();
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(false);
		$this->load->view('form_setor_bank', $data);
	}
	
	/**
	 * form cetak sts
	 */
	function form_cetak_sts() {		
		$data['bukti_setoran'] = array(
									'1' => 'SSPD',
									'2' => 'K l i r i n g',
									'3' => 'STS'
								);
		$data['uptd'] = $this->get_uptd();
				
		if ($this->input->post('cart') == "0") {
			$data['jenis_pajak'] = $this->input->post('jenis_pajak');
			$data['arr_data'] = $this->setor_bank_model->get_setoran_pajak($this->input->post('setoran_id'), FALSE);
			$data['setoran_id'] = $this->input->post('setoran_id');
		} else if ($this->input->post('cart') == "1") {
			$this->load->library('cart');
			$this->load->model('cart_model');
			
			$data['jenis_pajak'] = $this->input->post('jenis_pajak');
			$id = $this->cart_model->get_cart_items();
			$data['arr_data'] = $this->setor_bank_model->get_setoran_pajak($id, TRUE);
			$data['setoran_id'] = $id;
		}
		$this->load->view('form_cetak_sts', $data);
	}
	
	function get_nomor_bukti() {
		$this->setor_bank_model->get_list_no_bukti();
	}
	
	
	/**
	 * insert setoran_ke_bank
	 */
	function insert() {
		$result = array();
		$this->load->model('sts_model');
		
		$id = $this->setor_bank_model->insert();
		if ($id) {
			$result = array('status' => true, 'id' => $id);
		} else {
			$result = array('status' => false, 'msg' => 'Data gagal disimpan');
		}
		
		echo json_encode($result);
	}
	
	/**
	 * get uptd
	 */
	function get_uptd() {
		$uptd = $this->common_model->get_query('*', 'ref_uptd');
		$arr_uptd = array();
		
		$arr_uptd[""] = "-- Silahkan Pilih --";
		if (count($uptd->num_rows()) > 0) {
			foreach ($uptd->result() as $row) {
				$arr_uptd[$row->uptd_id ."|". $row->uptd_nama."|".$row->uptd_alamat ] = $row->uptd_nama;
			}
		}
		$arr_uptd["-"] = "Lainnya";
		
		return $arr_uptd;
	}
}