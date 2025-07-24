<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cetak_daftar_formulir controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Cetak_daftar_formulir extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('cetak_daftar_formulir_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		
		$pejabat_daerah = $this->common_model->get_pejabat_daerah();
		
		$arr_pejabat = array();
		$arr_pejabat[''] = '--';
		if (count($pejabat_daerah) > 0) {
			foreach ($pejabat_daerah as $row) {
				$arr_pejabat[$row->pejda_nama.'|'.$row->ref_japeda_nama.'|'.$row->pejda_nip.'|'.$row->ref_pangpej_ket."|".$row->pejda_kode] = 
						$row->pejda_nama.' / '.$row->ref_japeda_nama;
			}
		}
		$data['pejabat_daerah'] = $arr_pejabat;
		
		$this->load->view('form_cetak_daftar_formulir', $data);
	}
	
	/**
	 * cetak formulir pendaftaran
	 */
	function export_to_pdf() {		
		$mengetahui_nama = ""; 
		$mengetahui_jabatan = "";
		$mengetahui_nip = "";
		$mengetahui_ket_jabatan = "";
		$mengetahui_kode = "";
		
		$pemeriksa_nama = "";
		$pemeriksa_jabatan = "";
		$pemeriksa_nip = "";
		$pemeriksa_ket_jabatan = "";
		$pemeriksa_kode = "";
		
		$mengetahui = $this->input->get('mengetahui');
		$pemeriksa = $this->input->get('pemeriksa');
		
		if (!empty($mengetahui)) {
			$_mengetahui = explode("|", $mengetahui);
			$mengetahui_nama = $_mengetahui[0];
			$mengetahui_jabatan = $_mengetahui[1];
			$mengetahui_nip = $_mengetahui[2];
			$mengetahui_ket_jabatan = $_mengetahui[3];
			$mengetahui_kode = $_mengetahui[4];
		}
		
		if (!empty($pemeriksa)) {
			$_pemeriksa = explode("|",$pemeriksa);
			$pemeriksa_nama = $_pemeriksa[0];
			$pemeriksa_jabatan = $_pemeriksa[1];
			$pemeriksa_nip = $_pemeriksa[2];
			$pemeriksa_ket_jabatan = $_pemeriksa[3];
			$pemeriksa_kode = $_pemeriksa[4];
		}
		
		//get from database
		$query = $this->cetak_daftar_formulir_model->get_list_formulir($this->input->get('fNumber'),
														$this->input->get('tNumber'),
														$this->input->get('fDate'),
														$this->input->get('tDate'),
														$this->input->get('status'));
		// Load library FPDF
	    $this->load->library('cellpdf');
	    define('FPDF_FONTPATH',$this->config->item('fonts_path'));
	    
	    $data['result'] = $query->result();
	    $data['mengetahui_nama'] = $mengetahui_nama;
	    $data['mengetahui_jabatan'] = $mengetahui_jabatan;
	    $data['mengetahui_nip'] = $mengetahui_nip;
	    $data['mengetahui_ket_jabatan'] = $mengetahui_ket_jabatan;
	    $data['mengetahui_kode'] = $mengetahui_kode;
	    $data['pemeriksa_nama'] = $pemeriksa_nama;
	    $data['pemeriksa_jabatan'] = $pemeriksa_jabatan;
	    $data['pemeriksa_nip'] = $pemeriksa_nip;
	    $data['pemeriksa_ket_jabatan'] = $pemeriksa_ket_jabatan;
	    $data['pemeriksa_kode'] = $pemeriksa_kode;
	    
	    //insert history log ($module, $action, $description)
		$this->common_model->history_log("pendaftaran", "P", "Print Daftar Formulir");
	    
	    //load view pdf
	   	$this->load->view('pdf_cetak_daftar_formulir', $data);
	}
}