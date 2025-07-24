<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Daftar_surat_ketetapan Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Daftar_surat_ketetapan extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('objek_pajak_model');
		$this->load->model('surat_ketetapan_model');
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
		$data['kecamatan'] = $arr_kecamatan;
		$data['jenis_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator();
		$data['keterangan_spt'] = $this->common_model->get_record_list("ketspt_id as value, '[' || ketspt_kode || '] ' ||ketspt_ket as item",
																		"keterangan_spt", "ketspt_id IS NOT NULL", "ketspt_kode ASC");
		
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_daftar_surat_ketetapan', $data);
	}
	
	/**
	 * pdf daftar surat ketetapan
	 */
	function pdf_daftar_surat_ketetapan() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		$ketetapan = $this->common_model->get_query('*', 'keterangan_spt', "ketspt_id='".$this->input->get('keterangan_spt')."'");
		$data['ketetapan'] = $ketetapan->row();
		
		if ($this->input->get('wp_wr_kd_camat'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('wp_wr_kd_camat')."'");
			
		$data['jenis_pajak'] = $this->common_model->get_record_value('ref_jenparet_ket', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		
		//insert history log
		$this->common_model->history_log("penetapan", "P", 
			"Print Daftar Ketetapan : ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['tahun']."-".$_GET['bulan']."-".$_GET['tanggal']." | ".$_GET['keterangan_spt']." | ".$_GET['wp_wr_kd_camat']);
		
		if ($this->input->get('spt_jenis_pajakretribusi') != "4") {
			$data['data'] = $this->surat_ketetapan_model->daftar_surat_ketetapan();
			$this->load->view('pdf_daftar_surat_ketetapan', $data);
		} else {
			$data['data'] = $this->surat_ketetapan_model->daftar_surat_ketetapan_reklame();
			
			$this->load->view('pdf_daftar_surat_ketetapan_reklame', $data);
		}
	}
	
	/**
	 * cetak daftar excel
	 */
	function xls_daftar_surat_ketetapan() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		$ketetapan = $this->common_model->get_query('*', 'keterangan_spt', "ketspt_id='".$this->input->get('keterangan_spt')."'");
		$data['ketetapan'] = $ketetapan->row();
		
		if ($this->input->get('wp_wr_kd_camat'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('wp_wr_kd_camat')."'");
			
		$data['jenis_pajak'] = $this->common_model->get_record_value('ref_jenparet_ket', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		
		//insert history log
		$this->common_model->history_log("penetapan", "P", 
			"Print Daftar Ketetapan : ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['tahun']."-".$_GET['bulan']."-".$_GET['tanggal']." | ".$_GET['keterangan_spt']." | ".$_GET['wp_wr_kd_camat']);
		
		if ($this->input->get('spt_jenis_pajakretribusi') != "4") {
			$data['data'] = $this->surat_ketetapan_model->daftar_surat_ketetapan();
			$this->load->view('xls_daftar_surat_ketetapan', $data);
		} else {
			$data['data'] = $this->surat_ketetapan_model->daftar_surat_ketetapan_reklame();
			
			$this->load->view('xls_daftar_surat_ketetapan_reklame', $data);
		}
	}	
	
	/**
	 * cetak daftar ketetapan berdasarkan tanggal ketetapan
	 */
	function pdf_cetak_daftar_via_tanggal_ketetapan() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		$ketetapan = $this->common_model->get_query('*', 'keterangan_spt', "ketspt_id='".$this->input->get('keterangan_spt')."'");
		$data['ketetapan'] = $ketetapan->row();
		
		if ($this->input->get('wp_wr_kd_camat'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('wp_wr_kd_camat')."'");
			
		$data['jenis_pajak'] = $this->common_model->get_record_value('ref_jenparet_ket', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		
		//insert history log
		$this->common_model->history_log("penetapan", "P", 
			"Print Daftar Ketetapan : ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['tgl_penetapan1']."-".$_GET['tgl_penetapan2']." | ".$_GET['keterangan_spt']." | ".$_GET['wp_wr_kd_camat']);
		
		if ($this->input->get('spt_jenis_pajakretribusi') != "4") {
			$data['data'] = $this->surat_ketetapan_model->daftar_tanggal_surat_ketetapan();
			$this->load->view('pdf_daftar_tanggal_ketetapan', $data);
		} else {
			$data['data'] = $this->surat_ketetapan_model->daftar_tanggal_surat_ketetapan_reklame();
			$this->load->view('pdf_daftar_tanggal_ketetapan_reklame', $data);
		}
	}

	/**
	 * cetak daftar excel
	 */
	function xls_daftar_surat_ketetapan_via_tanggal() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		$ketetapan = $this->common_model->get_query('*', 'keterangan_spt', "ketspt_id='".$this->input->get('keterangan_spt')."'");
		$data['ketetapan'] = $ketetapan->row();
		
		if ($this->input->get('wp_wr_kd_camat'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('wp_wr_kd_camat')."'");
			
		$data['jenis_pajak'] = $this->common_model->get_record_value('ref_jenparet_ket', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
		
		//insert history log
		$this->common_model->history_log("penetapan", "P", 
			"Print Daftar Ketetapan : ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['tahun']."-".$_GET['bulan']."-".$_GET['tanggal']." | ".$_GET['keterangan_spt']." | ".$_GET['wp_wr_kd_camat']);
		
		if ($this->input->get('spt_jenis_pajakretribusi') != "4") {
			$data['data'] = $this->surat_ketetapan_model->daftar_tanggal_surat_ketetapan();
			$this->load->view('xls_daftar_surat_ketetapan_tanggal', $data);
		} else {
			$data['data'] = $this->surat_ketetapan_model->daftar_tanggal_surat_ketetapan_reklame();
			$this->load->view('xls_daftar_surat_ketetapan_tanggal_reklame', $data);
		}
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