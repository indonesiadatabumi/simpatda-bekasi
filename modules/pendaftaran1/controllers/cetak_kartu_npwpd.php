<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Badan_usaha controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Cetak_kartu_npwpd extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('cetak_kartu_npwpd_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$this->load->view('view_cetak_kartu_npwpd');
	}
	
	/**
	 * get list page controller
	 */
	function get_list() {
		$this->cetak_kartu_npwpd_model->get_list();
	}
	
	/**
	 * cetak npwpd
	 */
	function cetak_npwpd() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		$data['pejabat'] = $this->cetak_kartu_npwpd_model->get_kadis();
		$wp = $this->cetak_kartu_npwpd_model->get_wp();
		$data['wp'] = $wp;
				
		//insert history log ($module, $action, $description)
		$this->common_model->history_log("pendaftaran", "P", "Print Kartu WP ".$wp->wp_wr_id." | ".$wp->npwprd." | ".$wp->wp_wr_nama);		
		
		$this->load->view('pdf_cetak_kartu_npwpd', $data);
	}
}