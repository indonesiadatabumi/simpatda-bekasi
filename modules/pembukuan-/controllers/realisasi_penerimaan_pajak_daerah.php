<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Realisasi_penerimaan_pajak_daerah class controller
 * @package Simpatda
 * @author Angga Pratama
 */
class Realisasi_penerimaan_pajak_daerah extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('pembukuan_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$arr_pejabat_daerah = array("0" => "(silahkan pilih...)");
		$data['pejabat_daerah'] = array_merge($arr_pejabat_daerah, $this->pembukuan_model->get_pejabat_daerah());
		$this->load->view('form_realisasi_penerimaan_pajak_daerah', $data);
	}
	
	function save_excel() {		
		$this->load->view('xls_realisasi_penerimaan_pajak_daerah');
	}
	
	/**
	 * function to cetak pdf
	 */
	function cetak_pdf() {
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$bendahara = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('bendahara')."'");		
		$data['bendahara'] = $bendahara->row();
		
		$this->load->view('pdf_realisasi_penerimaan_pajak_daerah', $data);
	}
}