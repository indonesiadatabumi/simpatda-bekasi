<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Realisasi_setoran Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121204
 */
class Realisasi_setoran extends Master_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
	}
	
	function index() {
		$this->load->model('objek_pajak_model');
		$data['objek_pajak'] = $this->objek_pajak_model->get_ref_jenis_pajak_retribusi(true);
		
		$kecamatan = $this->common_model->get_kecamatan();
		//get kecamatan
		$arr_kecamatan = array();
		$arr_kecamatan['0'] = "-- Pilih Kecamatan --";
		foreach ($kecamatan as $row) {
			$arr_kecamatan[$row->camat_id] = $row->camat_kode.' | '.$row->camat_nama;
		}
		$data['kecamatan'] = $arr_kecamatan;
		
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_realisasi_setoran', $data);
	}
	
	/**
	 * get pejabat daerah
	 */
	function get_pejabat_daerah() {
		$pejabat_daerah = $this->common_model->get_pejabat_daerah();
		$arr_pejabat = array();
		$arr_pejabat['0'] = '--';
		if (count($pejabat_daerah) > 0) {
			foreach ($pejabat_daerah as $row) {
				$arr_pejabat[$row->pejda_id] = 
						$row->pejda_nama.' / '.$row->ref_japeda_nama;
			}
		}
		
		return $arr_pejabat;
	}
}