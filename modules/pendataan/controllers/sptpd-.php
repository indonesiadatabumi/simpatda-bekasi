<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * class Daftar_sptpd 
 * @author Daniel
 * @package Simpatda
 */
class Sptpd extends Master_Controller
{
	/**
	 * constructor
	 */
	function __construct() {
		$this->load->model('common_model');
		$this->load->model('objek_pajak_model');
		$this->load->model('sptpd_list_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$kecamatan = $this->common_model->get_kecamatan();
		//get kecamatan
		$arr_kecamatan = array();
		$arr_kecamatan[''] = "-- Pilih Kecamatan --";
		foreach ($kecamatan as $row) {
			$arr_kecamatan[$row->camat_id.'|'.$row->camat_nama] = $row->camat_kode.' | '.$row->camat_nama;
		}
		$data['kecamatan'] = $arr_kecamatan;
		$data['objek_pajak'] = array(
									$this->config->item('jenis_pajak_hotel') => 'Pajak Hotel',
									$this->config->item('jenis_pajak_restoran') => 'Pajak Restoran',
									$this->config->item('jenis_pajak_hiburan') => 'Pajak Hiburan',
									$this->config->item('jenis_pajak_genset') => 'Pajak Penerangan Jalan / Genset',
									$this->config->item('jenis_pajak_parkir') => 'Pajak Parkir',
								);
		
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_sptpd', $data);		
	}
	
	/**
	 * cetak sptpd
	 */
	function cetak_sptpd() {
		$pemda = $this->common_model->get_query('*', 'data_pemerintah_daerah');
		$data['pemda'] = $pemda->row(); 
		$spt_jenis_pajak = $this->input->get('spt_jenis_pajakretribusi');
		
		//jika jenis pajak hotel
		if ($spt_jenis_pajak == $this->config->item('jenis_pajak_hotel')) {
			$this->load->view('pdf_sptpd_hotel', $data);
		}
	}
	
	function daftar() {
		$kecamatan = $this->common_model->get_kecamatan();
		//get kecamatan
		$arr_kecamatan = array();
		if ($this->session->userdata('USER_SPT_CODE') == "10")
			$arr_kecamatan['0'] = "-- Pilih Kecamatan --";
			
		foreach ($kecamatan as $row) {
			$arr_kecamatan[$row->camat_id] = $row->camat_kode.' | '.$row->camat_nama;
		}
		$data['kecamatan'] = $arr_kecamatan;
		$data['objek_pajak'] = $this->objek_pajak_model->get_pajak_self_assesment();
		$data['jenis_pajak_restoran'] = array('0' => 'Rumah Makan & Catering', '1' => 'Rumah Makan', '2' => 'Catering');
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		
		$this->load->view('form_daftar_sptpd', $data);
	}
	
	/**
	 * cetak daftar sptpd
	 */
	function cetak_daftar_sptpd() {		
		if ($this->input->get('kecamatan'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('kecamatan')."'");
			
		$jenis_pajak = $this->common_model->get_query('*', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		$data['jenis_pajak'] = $jenis_pajak->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		if ($_GET['spt_jenis_pajakretribusi'] == '2')
			$data['rows'] = $this->sptpd_list_model->get_daftar_sptpd_restoran();
		else 
			$data['rows'] = $this->sptpd_list_model->get_daftar_sptpd();
			
		$data['model'] = $this->sptpd_list_model;
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Daftar SPTPD");
		
		$this->load->view('pdf_daftar_sptpd', $data);
	}
	
	/**
	 * cetak daftar excel sptpd
	 */
	function cetak_xls_daftar_sptpd() {		
		if ($this->input->get('kecamatan'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('kecamatan')."'");
			
		$jenis_pajak = $this->common_model->get_query('*', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		$data['jenis_pajak'] = $jenis_pajak->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		if ($_GET['spt_jenis_pajakretribusi'] == '2')
			$data['rows'] = $this->sptpd_list_model->get_daftar_sptpd_restoran();
		else 
			$data['rows'] = $this->sptpd_list_model->get_daftar_sptpd();
			
		$data['model'] = $this->sptpd_list_model;
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Daftar SPTPD");
		
		$this->load->view('xls_daftar_sptpd', $data);
	}
	
	/**
	 * cetak daftar spt berdasarkan tanggal entry
	 */
	function cetak_daftar_tanggal_sptpd() {
		if ($this->input->get('kecamatan'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('kecamatan')."'");
			
		$jenis_pajak = $this->common_model->get_query('*', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		$data['jenis_pajak'] = $jenis_pajak->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		$data['rows'] = $this->sptpd_list_model->get_list_spt_by_tanggal_entry();
			
		$data['model'] = $this->sptpd_list_model;
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Daftar SPTPD");
		
		$this->load->view('pdf_daftar_tanggal_sptpd', $data);
	}
	
	/**
	 * get pejabat daerah
	 */
	function get_pejabat_daerah() {
		$pejabat_daerah = $this->common_model->get_pejabat_daerah();
		$arr_pejabat = array();
		if (count($pejabat_daerah) > 0) {
			foreach ($pejabat_daerah as $row) {
				$arr_pejabat[$row->pejda_id] = 
						$row->pejda_nama.' | '.$row->ref_japeda_nama;
			}
		}
		
		return $arr_pejabat;
	}
}