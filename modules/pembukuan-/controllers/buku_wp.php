<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pribadi class controller
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121016
 */
class Buku_wp extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('buku_wp_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('form_buku_wp');
	}
	
	/**
	 * cetak buku wpwr
	 */
	function cetak() {
		$data['dt_rows'] = $this->buku_wp_model->get_data($this->input->get('wp_id'),
															$this->input->get('jenis_pemungutan'),
															$this->input->get('tahun'));
															
		$pemda = $this->common_model->get_query('*', 'data_pemerintah_daerah');
		$data['pemda'] = $pemda->row_array();
		$data['model'] = $this->buku_wp_model;
		
		//insert history log
		$this->common_model->history_log("pembukuan", "P", 
			"Cetak Buku WP : ".$_GET['tahun']." | ".$_GET['jenis_pemungutan']." | ".$_GET['wp_id']);
		
		$this->load->view('pdf_buku_wp', $data);
	}
}