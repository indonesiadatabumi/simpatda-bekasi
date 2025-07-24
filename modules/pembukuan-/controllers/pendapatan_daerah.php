<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pendapatan_daerah class controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Pendapatan_daerah extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('pembukuan_model');
		$this->load->model('realisasi_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$arr_pejabat_daerah = array("" => "(silahkan pilih...)");
		$data['pejabat_daerah'] = array_merge($arr_pejabat_daerah, $this->pembukuan_model->get_pejabat_daerah());
		$this->load->view('form_pendapatan_daerah', $data);
	}
	
	/**
	 * save excel
	 */
	function save_excel() {
		$data['realisasi_model'] = $this->realisasi_model;
		//insert history log
		$this->common_model->history_log("pembukuan", "P", "Cetak laporan pendapatan daerah : ".$_GET['tgl_proses']);
		
		$this->load->view('xls_pendapatan_daerah', $data);
	}
}