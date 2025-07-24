<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Realisasi_penerimaan_daerah class controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Realisasi_penerimaan_daerah extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('pembukuan_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$arr_pejabat_daerah = array("" => "(silahkan pilih...)");
		$data['pejabat_daerah'] = array_merge($arr_pejabat_daerah, $this->pembukuan_model->get_pejabat_daerah());
		$this->load->view('form_realisasi_penerimaan_daerah', $data);
	}
}