<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Setoran_reklame class controller
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121016
 */
class Daftar_setoran extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('objek_pajak_model');
		$this->load->model('daftar_setoran_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$data['jenis_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(false);
		$year = date('Y');
		$years[$year] = $year;
		for ($i = 1; $i < 5; $i++) {
			$years[$year - $i] = $year - $i;
		}
		$data['tahun_ketetapan'] = $years;
		$this->load->view('form_daftar_setoran', $data);
	}
	
	/**
	 * cetak buku wpwr
	 */
	function cetak() {
		$data['dt_rows'] = $this->daftar_setoran_model->get_data();
		$data['jenis_pajak'] = $this->common_model->get_record_value("ref_jenparet_ket", "ref_jenis_pajak_retribusi", "ref_jenparet_id=".$_GET['jenis_pajak']);
															
		//insert history log
		$this->common_model->history_log("pembukuan", "P", "Cetak daftar rekapitulasi reklame ");
		
		$this->load->view('pdf_daftar_setoran', $data);
	}
}