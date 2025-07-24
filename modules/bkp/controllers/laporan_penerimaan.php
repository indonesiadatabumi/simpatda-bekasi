<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Laporan_penerimaan Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Laporan_penerimaan extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('objek_pajak_model');
		$this->load->model('bpps_model');
	}
	
	/**
	 * index page
	 */
	function index() {
		$kecamatan = $this->common_model->get_kecamatan();
		//get kecamatan
		$arr_kecamatan = array();
		
		if ($this->session->userdata('USER_SPT_CODE') == "10")
			$arr_kecamatan['0'] = "-- Pilih Kecamatan --";
		
		foreach ($kecamatan as $row) {
			$arr_kecamatan[$row->camat_id] = $row->camat_kode.' | '.$row->camat_nama;
		}
		$data['kecamatan'] = $arr_kecamatan;
		$data['jenis_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_laporan_penerimaan', $data);
	}
	
	/**
	 * cetak laporan penerimaan
	 */
	function cetak_laporan() {		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$bendahara = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('bendahara')."'");
		$data['bendahara'] = $bendahara->row();
		
		if ($this->input->get('camat_id'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('camat_id')."'");
		
		$data['jenis_pajak'] = $this->common_model->get_record_value('ref_jenparet_ket', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('jenis_pajak')."'");
	    $data['arr_data'] = $this->bpps_model->get_laporan_penerimaan();
	    
	    //insert history log
		$this->common_model->history_log("bkp", "P", "Cetak Laporan Bendahara Penerimaan : ".$_GET['fDate']." | ".$_GET['tDate']." | ".$_GET['jenis_pajak']." | ".$_GET['camat_id']);
		
		$this->load->view('pdf_laporan_penerimaan', $data);
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
						$row->pejda_nama.' | '.$row->ref_japeda_nama;
			}
		}
		
		return $arr_pejabat;
	}
}