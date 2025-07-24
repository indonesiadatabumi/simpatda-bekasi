<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * class Surat_teguran 
 * @author Daniel
 * @package Simpatda
 */
class Surat_tegurann extends Master_Controller
{
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('objek_pajak_model');
		$this->load->model('common_model');
		$this->load->model('surat_tegurann_model');
		$this->load->model('daftar_surat_teguran_model');
	}
	
	/**
	 * cetak surat teguran
	 */
	function index() {
		$data['jenis_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['kecamatan'] = $this->get_kecamatan();
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('surat_tegurann', $data);
	}
	
	
	function pdf_surat_tegurann() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$pejabat = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('pejabat')."'");
		$data['pejabat'] = $pejabat->row();
	
		$data['model'] = $this->surat_tegurann_model;
		
		//insert history log
		$this->common_model->history_log("pembukuan", "P", "Cetak surat tegurann : ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['bulan']."|".$_GET['tahun']." | ".$_GET['wp_wr_kd_camat']);
		
		$this->load->view('pdf_surat_tegurann', $data);
	}
	
	/**
	 * daftar surat teguran
	 */
	function daftar() {
		$data['jenis_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['kecamatan'] = $this->get_kecamatan();
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('daftar_surat_tegurann', $data);
	}
	
	function pdf_daftar_surat_tegurann() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('wp_wr_kd_camat')."'");
		
		$jenis_pajak = $this->common_model->get_query('*', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		$data['jenis_pajak'] = $jenis_pajak->row();
	
		$data['model'] = $this->daftar_surat_tegurann_model;
		
		//insert history log
		$this->common_model->history_log("pembukuan", "P", "Cetak daftar surat tegurann : ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['bulan']."|".$_GET['tahun']." | ".$_GET['wp_wr_kd_camat']);
		
		$this->load->view('pdf_daftar_surat_tegurann', $data);
	}
	
	/**
	 * get kecamatan
	 */
	function get_kecamatan() {
		$kecamatan = $this->common_model->get_kecamatan();
		//get kecamatan
		$arr_kecamatan = array();
		$arr_kecamatan['0'] = "--";
		foreach ($kecamatan as $row) {
			$arr_kecamatan[$row->camat_id] = $row->camat_kode.' | '.$row->camat_nama;
		}
		return  $arr_kecamatan;
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
						$row->pejda_nama.' | '.$row->ref_japeda_nama;
			}
		}
		
		return $arr_pejabat;
	}
}