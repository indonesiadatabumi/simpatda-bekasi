<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pribadi class controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Kartu_data_wp extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('kartu_data_wp_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_daftar_wp');
	}
	
	function get_list_wp() {
		$this->kartu_data_wp_model->get_list_wp();
	}
	
	function get_detail() {
		$data['row'] = $this->kartu_data_wp_model->get_detail_wp($this->input->get('wp_id'));
		$this->load->view('kartu_data_detail', $data);
	}
	
	function deskripsi() {
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		
		$this->load->library('jpgraph');
		
		//get_data_spt
		$query = $this->kartu_data_wp_model->get_data_spt($this->input->get('wp_id'), $this->input->get('spt_periode'), $this->input->get('spt_periode2'));
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$datay[] = $row->spt_pajak;
				$arr_tgl = explode('-', $row->spt_periode_jual1);
				$datax[] = getNamaBulan($arr_tgl[1], true). "\n " . $arr_tgl[0];
			}
			
			$graph = $this->jpgraph->linechart( $datax, $datay, 'Data SPT', "Periode", "Rp.", 850, 400);
			// Display the graph
			$graph->Stroke();
		} else {
		}
	}
}