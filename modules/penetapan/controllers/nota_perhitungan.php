<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Nota_perhitungan Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Nota_perhitungan extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('nota_perhitungan_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$this->load->model('objek_pajak_model');
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$data['jenis_ketetapan'] = array(
										$this->config->item('status_skpd') => 'SKPD',
										$this->config->item('status_skpdkb') => 'SKPDKB',
										$this->config->item('status_skpdkbt') => 'SKPDKBT',
										$this->config->item('status_skpdlb') => 'SKPDLB',
										$this->config->item('status_skpdn') => 'SKPDN',
										$this->config->item('status_skpdt') => 'SKPDT'
									);
		$this->load->view('form_nota_perhitungan', $data);
	}
	
	/**
	 * get pejabat daerah
	 */
	function get_pejabat_daerah() {
		$pejabat_daerah = $this->common_model->get_pejabat_daerah();
		$arr_pejabat = array();
		if (count($pejabat_daerah) > 0) {
			foreach ($pejabat_daerah as $row) {
				$arr_pejabat[$row->pejda_id] = $row->pejda_nama.' / '.$row->ref_japeda_nama;
			}
		}
		
		return $arr_pejabat;
	}
	
	/**
	 * get spt nota
	 */
	function get_spt() {
		$get = '';
		if (is_array($_GET)) {
			foreach ($_GET as $key => $value) {
				$get .= "&".$key."=".$value;
			}	
		}
		$data['flexigrid_url'] = base_url()."penetapan/nota_perhitungan/get_list_spt?sqtype=&squery=".$get;
		$this->load->view('popup_nota_spt', $data);
	}
	
	/**
	 * get list spt
	 */
	function get_list_spt() {
		$this->nota_perhitungan_model->get_spt();
	}
	
	/**
	 * cetak nota perhitungan
	 */
	function cetak_nota() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$pemeriksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('pemeriksa')."'");
		$data['pemeriksa'] = $pemeriksa->row();
		$data['spt_jenis_pajakretribusi'] = $this->input->get('spt_jenis_pajakretribusi');
		$data['nota_model'] = $this->nota_perhitungan_model;
		
		//insert history log
		$this->common_model->history_log("penetapan", "P", 
			"Print nota perhitungan : ".$_GET['spt_periode']." | ".$this->input->get('spt_jenis_pajakretribusi')." | ".$_GET['spt_nomor1']." - ".$_GET['spt_nomor2']);
		
		//jika SKPD atau STPD
		if ($_GET['spt_jenis_ketetapan'] == "1" || $_GET['spt_jenis_ketetapan'] == "3") {
			if ($_GET['spt_jenis_pajakretribusi'] != "4") 
				$this->load->view('pdf_nota_perhitungan', $data);
			else 
				$this->load->view('pdf_nota_perhitungan_reklame', $data);
		} else {
			$this->load->view('pdf_nota_perhitungan_lhp', $data);
		}
	}
}