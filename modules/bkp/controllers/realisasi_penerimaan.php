<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Realisasi_penerimaan Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121204
 */
class Realisasi_penerimaan extends Master_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_realisasi_penerimaan', $data);
	}
	
	/**
	 * get pejabat daerah
	 */
	function get_pejabat_daerah() {
		$this->load->model('common_model');
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