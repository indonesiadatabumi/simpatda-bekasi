<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kartu_data Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Kartu_data extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('kartu_data_model');
	}
	
	/**
	 * jenis pajak controller
	 */
	function jenis_pajak() {
		$this->load->model('objek_pajak_model');
		$data['jenis_pajak'] = $this->objek_pajak_model->get_ref_jenis_pajak_retribusi();
		$this->load->view('view_popup_kartu_data', $data);
	}
	
	/**
	 * pajak hotel controller
	 */
	function pajak_hotel() {
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('kartu_data_hotel', $data);
	}
	
	/**
	 * kartu data hotel controller
	 */
	function pdf_pajak_hotel() {					
		$data['mengetahui'] = $this->get_detail_pejabat($this->input->get('mengetahui'));
		$data['dibuat'] = $this->get_detail_pejabat($this->input->get('dibuat'));
		$data['pemda'] = $this->get_data_pemerintah();
		$wp = $this->kartu_data_model->get_data_wp();
		$data['wp'] = $wp;
		$data['arr_spt'] = $this->kartu_data_model->get_spt_list();
		
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Kartu Data WP : ".$wp['wp_wr_id']." | ".$wp['npwprd']." | ".$wp['wp_wr_nama']);
		
		$this->load->view('pdf_kartu_data_hotel', $data);
	}
	
	/**
	 * pajak restoran controller
	 */
	function pajak_restoran() {
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('kartu_data_restoran', $data);
	}
	
	/**
	 * kartu data restoran controller
	 */
	function pdf_pajak_restoran() {				
		$data['mengetahui'] = $this->get_detail_pejabat($this->input->get('mengetahui'));
		$data['dibuat'] = $this->get_detail_pejabat($this->input->get('dibuat'));
		$data['pemda'] = $this->get_data_pemerintah();
		$wp = $this->kartu_data_model->get_data_wp();
		$data['wp'] = $wp;
		$data['arr_spt'] = $this->kartu_data_model->get_spt_list();
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Kartu Data WP : ".$wp['wp_wr_id']." | ".$wp['npwprd']." | ".$wp['wp_wr_nama']);
	
		$this->load->view('pdf_kartu_data_restoran', $data);
	}
	
	/**
	 * pajak hiburan controller
	 */
	function pajak_hiburan() {
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('kartu_data_hiburan', $data);
	}

	/**
	 * kartu data restoran controller
	 */
	function pdf_pajak_hiburan() {				
		$data['mengetahui'] = $this->get_detail_pejabat($this->input->get('mengetahui'));
		$data['dibuat'] = $this->get_detail_pejabat($this->input->get('dibuat'));
		$data['pemda'] = $this->get_data_pemerintah();
		$wp = $this->kartu_data_model->get_data_wp();
		$data['wp'] = $wp;
		$data['arr_spt'] = $this->kartu_data_model->get_spt_list();
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Kartu Data WP : ".$wp['wp_wr_id']." | ".$wp['npwprd']." | ".$wp['wp_wr_nama']);
	
		$this->load->view('pdf_kartu_data_hiburan', $data);
	}
	
	/**
	 * pajak reklame controller
	 */
	function pajak_reklame() {
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('kartu_data_reklame', $data);
	}
	
	/**
	 * pdf reklame controller
	 */
	function pdf_reklame() {
		$data['mengetahui'] = $this->get_detail_pejabat($this->input->get('mengetahui'));
		$data['dibuat'] = $this->get_detail_pejabat($this->input->get('dibuat'));
		$data['pemda'] = $this->get_data_pemerintah();
		$wp = $this->kartu_data_model->get_data_wp();
		$data['wp'] = $wp;
		$data['arr_spt'] = $this->kartu_data_model->get_spt_list();
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Kartu Data WP : ".$wp['wp_wr_id']." | ".$wp['npwprd']." | ".$wp['wp_wr_nama']);
	
		$this->load->view('pdf_kartu_data_reklame', $data);
	}
	
	
	/**
	 * pajak genset controller
	 */
	function pajak_genset() {
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('kartu_data_genset', $data);
	}
	
	/**
	 * kartu data restoran controller
	 */
	function pdf_pajak_genset() {				
		$data['mengetahui'] = $this->get_detail_pejabat($this->input->get('mengetahui'));
		$data['dibuat'] = $this->get_detail_pejabat($this->input->get('dibuat'));
		$data['pemda'] = $this->get_data_pemerintah();
		$wp = $this->kartu_data_model->get_data_wp();
		$data['wp'] = $wp;
		$data['arr_spt'] = $this->kartu_data_model->get_spt_list();		
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Kartu Data WP : ".$wp['wp_wr_id']." | ".$wp['npwprd']." | ".$wp['wp_wr_nama']);
	
		$this->load->view('pdf_kartu_data_genset', $data);
	}
	
	
	/**
	 * pajak pln controller
	 */
	function pajak_pln() {
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('kartu_data_pln', $data);
	}
	
	/**
	 * kartu data restoran controller
	 */
	function pdf_pajak_pln() {				
		$data['mengetahui'] = $this->get_detail_pejabat($this->input->get('mengetahui'));
		$data['dibuat'] = $this->get_detail_pejabat($this->input->get('dibuat'));
		$data['pemda'] = $this->get_data_pemerintah();
		$wp = $this->kartu_data_model->get_data_wp();
		$data['wp'] = $wp;
		$data['arr_spt'] = $this->kartu_data_model->get_spt_list();		
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Kartu Data WP : ".$wp['wp_wr_id']." | ".$wp['npwprd']." | ".$wp['wp_wr_nama']);
	
		$this->load->view('pdf_kartu_data_pln', $data);
	}
	
	/**
	 * pajak parkir controller
	 */
	function pajak_parkir() {
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('kartu_data_parkir', $data);
	}
	
	/**
	 * kartu data restoran controller
	 */
	function pdf_pajak_parkir() {				
		$data['mengetahui'] = $this->get_detail_pejabat($this->input->get('mengetahui'));
		$data['dibuat'] = $this->get_detail_pejabat($this->input->get('dibuat'));
		$data['pemda'] = $this->get_data_pemerintah();
		$wp = $this->kartu_data_model->get_data_wp();
		$data['wp'] = $wp;
		$data['arr_spt'] = $this->kartu_data_model->get_spt_list();
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Kartu Data WP : ".$wp['wp_wr_id']." | ".$wp['npwprd']." | ".$wp['wp_wr_nama']);
	
		$this->load->view('pdf_kartu_data_parkir', $data);
	}
	
	/**
	 * pajak air bawah tanah controller
	 */
	function pajak_air_bawah_tanah() {
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('kartu_data_air_bawah_tanah', $data);
	}
	
	/**
	 * pdf air tanah controller
	 */
	function pdf_pajak_air_tanah() {
		$data['mengetahui'] = $this->get_detail_pejabat($this->input->get('mengetahui'));
		$data['dibuat'] = $this->get_detail_pejabat($this->input->get('dibuat'));
		$data['pemda'] = $this->get_data_pemerintah();
		$wp = $this->kartu_data_model->get_data_wp();
		$data['wp'] = $wp;
		$data['arr_spt'] = $this->kartu_data_model->get_spt_list();
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Kartu Data WP : ".$wp['wp_wr_id']." | ".$wp['npwprd']." | ".$wp['wp_wr_nama']);
	
		$this->load->view('pdf_kartu_data_air_bawah_tanah', $data);
	}
	
	/**
	 * daftar kartu data
	 */
	function daftar() {
		$this->load->model('objek_pajak_model');
		$data['objek_pajak'] = $this->objek_pajak_model->get_ref_jenis_pajak_retribusi(true);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('daftar_kartu_data', $data);
	}
	
	function pdf_daftar_kartu_data() {
		$this->load->model('sptpd_list_model');
		
		if ($this->input->get('spt_jenis_pajakretribusi') != "") {
			$jenis_pajak = $this->common_model->get_query('*', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('spt_jenis_pajakretribusi')."'");
			$data['jenis_pajak'] = $jenis_pajak->row();
		}		
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		$data['rows'] = $this->sptpd_list_model->get_daftar_kartu_data();
		//insert history log
		$this->common_model->history_log("pendataan", "P", "Print Daftar Kartu Data ");
		
		$this->load->view('pdf_daftar_kartu_data', $data);
	}
	
	/**
	 * get detail pejabat
	 */
	function get_detail_pejabat($pejda_id) {
		$result = "";
		
		if (!empty($pejda_id)) {
			$query = $this->common_model->get_query("*", "v_pejabat_daerah", "pejda_id='".$pejda_id."'");
			$result = $query->row_array();
		}
			
		return $result;
	}
	
	/**
	 * get data pemerintah
	 */
	function get_data_pemerintah() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');
		return $query->row();
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
				$arr_pejabat[$row->pejda_id] = $row->ref_japeda_nama." - ".$row->pejda_nama;
			}
		}
		
		return $arr_pejabat;
	}
}