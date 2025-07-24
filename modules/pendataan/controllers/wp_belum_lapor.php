<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * class Daftar_sptpd 
 * @author Daniel
 * @package Simpatda
 */
class Wp_belum_lapor extends Master_Controller
{
	/**
	 * constructor
	 */
	function __construct() {
		$this->load->model('common_model');
		$this->load->model('objek_pajak_model');
		$this->load->model('wp_belum_lapor_model');
	}
	
	/**
	 * index page controller
	 */	
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
		
		$this->load->view('form_wp_belum_lapor', $data);
	}
	
	/**
	 * cetak daftar sptpd
	 */
	function cetak_wp_belum_lapor() {		
		ini_set('memory_limit', '768M');
		if ($this->input->get('kecamatan'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='" . $this->input->get('kecamatan') . "'");

		$jenis_pajak = $this->common_model->get_query('*', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='" . $this->input->get('spt_jenis_pajakretribusi') . "'");
		$data['jenis_pajak'] = $jenis_pajak->row();

		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='" . $this->input->get('mengetahui') . "'");
		$data['mengetahui'] = $mengetahui->row();

		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='" . $this->input->get('diperiksa') . "'");
		$data['diperiksa'] = $diperiksa->row();

		if ($_GET['spt_jenis_pajakretribusi'] == '2')
			$data['rows'] = $this->wp_belum_lapor_model->get_wp_belum_lapor_restoran();
		else
			$data['rows'] = $this->wp_belum_lapor_model->get_wp_belum_lapor();
		// var_dump($data['rows']);die;
		$data['model'] = $this->wp_belum_lapor_model;
		$data['daftar_spt'] = $this->input->get('daftar_spt');
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');
		$data['pemda'] = $query->row();

		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Daftar SPTPD");

		$this->load->view('pdf_wp_belum_lapor', $data);
	}
	
	/**
	 * cetak daftar excel sptpd
	 */
	function cetak_xls_wp_belum_lapor() {		
		if ($this->input->get('kecamatan'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('kecamatan')."'");
			
		$jenis_pajak = $this->common_model->get_query('*', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		$data['jenis_pajak'] = $jenis_pajak->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		if ($_GET['spt_jenis_pajakretribusi'] == '2')
			$data['rows'] = $this->wp_belum_lapor_model->get_wp_belum_lapor_restoran();
		else 
			$data['rows'] = $this->wp_belum_lapor_model->get_wp_belum_lapor();
			
		$data['model'] = $this->wp_belum_lapor_model;
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Daftar SPTPD");
		
		$this->load->view('xls_wp_belum_lapor', $data);
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