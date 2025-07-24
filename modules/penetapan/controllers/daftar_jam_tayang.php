<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Daftar_surat_ketetapan Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Daftar_jam_tayang extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('jam_tayang_model');
	}
	
	/**
	 * index page controller
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
		$data['kelurahan'] = array('' => '--');
		$data['kecamatan'] = $arr_kecamatan;
		
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_daftar_jam_tayang', $data);
	}
	
	/**
	 * pdf daftar surat ketetapan
	 */
	function pdf_daftar_jam_tayang() {
		$lurah = explode('|', $this->input->get('lurah_id'));
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		if ($this->input->get('wp_wr_kd_camat'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('wp_wr_kd_camat')."'");

		if ($this->input->get('lurah_id'))
			$data['kelurahan'] = $this->common_model->get_record_value('lurah_nama', 'kelurahan', "lurah_id='".$lurah[0]."'");
		
		$data['jenis_pajak'] = $this->common_model->get_record_value('ref_jenparet_ket', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		
		$data['data'] = $this->jam_tayang_model->daftar_jam_tayang();
		$this->load->view('pdf_daftar_jam_tayang', $data);
	}
	
	/**
	 * cetak daftar excel
	 */
	function xls_daftar_jam_tayang() {
		$lurah = explode('|', $this->input->get('lurah_id'));
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		if ($this->input->get('wp_wr_kd_camat'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('wp_wr_kd_camat')."'");

		if ($this->input->get('lurah_id'))
			$data['kelurahan'] = $this->common_model->get_record_value('lurah_nama', 'kelurahan', "lurah_id='".$lurah[0]."'");
			
		$data['jenis_pajak'] = $this->common_model->get_record_value('ref_jenparet_ket', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		
		$data['data'] = $this->jam_tayang_model->daftar_jam_tayang();
		
		$this->load->view('xls_daftar_jam_tayang', $data);
	}	

	/**
	 * cetak daftar tayang berdasarkan tanggal ketetapan
	 */
	function pdf_daftar_jam_tayang_via_tanggal() {
		$lurah = explode('|', $this->input->get('lurah_id'));
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		if ($this->input->get('wp_wr_kd_camat'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('wp_wr_kd_camat')."'");

		if ($this->input->get('lurah_id'))
			$data['kelurahan'] = $this->common_model->get_record_value('lurah_nama', 'kelurahan', "lurah_id='".$lurah[0]."'");
			
		$data['jenis_pajak'] = $this->common_model->get_record_value('ref_jenparet_ket', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		
		$data['data'] = $this->jam_tayang_model->daftar_jam_tayang_tanggal();
		
		$this->load->view('pdf_daftar_jam_tayang_tanggal', $data);
	}

	/**
	 * cetak daftar excel
	 */
	function xls_daftar_jam_tayang_via_tanggal() {
		$lurah = explode('|', $this->input->get('lurah_id'));
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		if ($this->input->get('wp_wr_kd_camat'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('wp_wr_kd_camat')."'");

		if ($this->input->get('lurah_id'))
			$data['kelurahan'] = $this->common_model->get_record_value('lurah_nama', 'kelurahan', "lurah_id='".$lurah[0]."'");
			
		$data['jenis_pajak'] = $this->common_model->get_record_value('ref_jenparet_ket', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		
		
		$data['data'] = $this->jam_tayang_model->daftar_jam_tayang_tanggal();
		$this->load->view('xls_daftar_jam_tayang_tanggal', $data);
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