<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * class Surat_teguran 
 * @author Daniel
 * @package Simpatda
 */
class Surat_teguran extends Master_Controller
{
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('objek_pajak_model');
		$this->load->model('common_model');
		$this->load->model('surat_teguran_model');
		$this->load->model('daftar_surat_teguran_model');
	}
	
	/**
	 * cetak surat teguran
	 */
	function index() {
		$data['jenis_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['kecamatan'] = $this->get_kecamatan();
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('surat_teguran', $data);
	}
	
	
	function pdf_surat_teguran() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$pejabat = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('pejabat')."'");
		$data['pejabat'] = $pejabat->row();
	
		$data['model'] = $this->surat_teguran_model;
		
		//insert history log
		$this->common_model->history_log("pembukuan", "P", "Cetak surat teguran : ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['tgl_awal']."|".$_GET['tgl_akhir']." | ".$_GET['wp_wr_kd_camat']);
		
		$this->load->view('pdf_surat_teguran', $data);
	}
	
	/**
	 * daftar surat teguran
	 */
	function daftar() {
		$data['jenis_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['kecamatan'] = $this->get_kecamatan();
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('daftar_surat_teguran', $data);
	}
	
	function pdf_daftar_surat_teguran() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('wp_wr_kd_camat')."'");
		
		$jenis_pajak = $this->common_model->get_query('*', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		$data['jenis_pajak'] = $jenis_pajak->row();
	
		$data['model'] = $this->daftar_surat_teguran_model;
		
		//insert history log
		$this->common_model->history_log("pembukuan", "P", "Cetak daftar surat teguran : ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['tgl_awal']."|".$_GET['tgl_akhir']." | ".$_GET['wp_wr_kd_camat']);
		
		$this->load->view('pdf_daftar_surat_teguran', $data);
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

	function pdf_surat_teguran_reklame()
	{
		$pejabat = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='" . $this->input->get('pejabat') . "'");
		$data['pejabat'] = $pejabat->row();
		$data['npwprd'] = $this->input->get('npwrd');
		$data['tgl_awal'] = $this->input->get('tgl_awal');
		$data['tgl_akhir'] = $this->input->get('tgl_akhir');
		$tgl_cetak = $this->input->get('tgl_cetak');
		$data['tgl_cetak'] = format_tgl($tgl_cetak);
		$data['no_surat_teguran'] = $this->surat_teguran_model->no_teguran();
		// $wpwr = $this->common_model->get_query('wp_wr_nama, wp_wr_almt, wp_wr_lurah, wp_wr_camat, wp_wr_kabupaten', 'v_wp_wr', "npwprd='" . $this->input->get('npwrd') . "'");
		// $data['wpwr'] = $wpwr->row();
		$data['model'] = $this->surat_teguran_model;

		$this->load->view('pdf_teguran_reklame', $data);
	}
}