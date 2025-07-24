<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Rekap_setoran Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121112
 */
class Rekap_setoran extends Master_Controller {
	/**
	 * index page controller
	 */
	function index() {
		$this->load->model('objek_pajak_model');
		$data['objek_pajak'] = $this->objek_pajak_model->get_ref_jenis_pajak_retribusi(true);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_rekap_setoran', $data);
	}
	
	/**
	 * get pejabat daerah
	 */
	function get_pejabat_daerah() {
		$this->load->model('common_model');
		$pejabat_daerah = $this->common_model->get_pejabat_daerah();
		$arr_pejabat = array();
		$arr_pejabat[''] = '--';
		if (count($pejabat_daerah) > 0) {
			foreach ($pejabat_daerah as $row) {
				$arr_pejabat[$row->pejda_nama.'|'.$row->ref_japeda_nama.'|'.$row->pejda_nip.'|'.$row->ref_pangpej_ket] = 
						$row->pejda_nama.' / '.$row->ref_japeda_nama;
			}
		}
		
		return $arr_pejabat;
	}
}