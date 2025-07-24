<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Tunggakan class controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Tunggakan extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model(array('common_model', 'objek_pajak_model', 'tunggakan_model'));
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$kecamatan = $this->common_model->get_kecamatan();
		//get kecamatan
		$arr_kecamatan = array();
		$arr_kecamatan['0'] = "-- Pilih Kecamatan --";
		
		foreach ($kecamatan as $row) {
			$arr_kecamatan[$row->camat_id] = $row->camat_kode.' | '.$row->camat_nama;
		}
		$data['kecamatan'] = $arr_kecamatan;
		$data['jenis_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$this->load->view('view_tunggakan', $data);
	}
	
	/**
	 * get list tunggakan
	 */
	function get_list() {
		$this->tunggakan_model->get_list();
	}
	
	/**
	 * cetak tunggakan
	 */
	function cetak() {
		if ($this->input->get('camat_id'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('camat_id')."'");
			
		$data['jenis_pajak'] = $this->common_model->get_record_value('ref_jenparet_ket', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('jenis_pajak')."'");
		$data['arr_data'] = $this->tunggakan_model->get_daftar_tunggakan();
		
		//insert history log
		$this->common_model->history_log("penagihan", "P", "Print Daftar Tungggakan");
		
		$this->load->view('pdf_tunggakan', $data);
	}
}