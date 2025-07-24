<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Surat_ketetapan Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Surat_ketetapan extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('objek_pajak_model');
		$this->load->model('surat_ketetapan_model');
		$this->load->model('common_model');
		$this->load->model('penetapan_lhp_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$this->load->view('view_surat_ketetapan');
	}
	
	/**
	 * form_ketetapan_skpd controller
	 */
	function form_ketetapan_skpd() {		
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_ketetapan_skpd', $data);
	}
	
	/**
	 * get list penetapan
	 */
	function get_penetapan() {
		$get = '';
		if (is_array($_GET)) {
			foreach ($_GET as $key => $value) {
				$get .= "&".$key."=".$value;
			}	
		}
		$data['flexigrid_url'] = base_url()."penetapan/surat_ketetapan/get_list_penetapan?".$get;
		$this->load->view('popup_ketetapan', $data);
	}
	
	/**
	 * get list penetapan
	 */
	function get_list_penetapan() {
		$this->surat_ketetapan_model->get_kohir();
	}
	
	/**
	 * pdf skpd
	 */
	function pdf_skpd() {
		$this->load->model('nota_perhitungan_model');
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$pejabat = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $pejabat->row();
	
		$data['spt_jenis_pajakretribusi'] = $this->input->get('spt_jenis_pajakretribusi');
		//$data['model'] = $this->surat_ketetapan_model;
		$data['model'] = $this->nota_perhitungan_model;
		
		//insert history log
		$this->common_model->history_log("penetapan", "P", 
			"Print SKPD : ".$_GET['spt_periode']." | ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['spt_nomor1']." - ".$_GET['spt_nomor2']);
		
		$this->load->view('pdf_skpd', $data);
	}
	
	/**
	 * form_ketetapan_skpd kurang bayar controller
	 */
	function form_ketetapan_skpdkb() {
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_ketetapan_skpdkb', $data);
	}
	
	/**
	 * export to pdf skpdkb
	 */
	function pdf_skpdkb() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$pejabat = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $pejabat->row();
	
		$data['spt_jenis_pajakretribusi'] = $this->input->get('spt_jenis_pajakretribusi');
		$data['model'] = $this->penetapan_lhp_model;
		
		//insert history log
		$this->common_model->history_log("penetapan", "P", 
			"Print SKPDKB : ".$_GET['tahun']." | ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['no_kohir1']." - ".$_GET['no_kohir2']);
		
		$this->load->view('pdf_skpdkb', $data);
	}
	
	/**
	 * form_ketetapan_stpd/surat tagihan pajak
	 */
	function form_ketetapan_stpd() {
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_ketetapan_stpd', $data);
	}
	
	/**
	 * export to pdf skpdkb
	 */
	function pdf_stpd() {
		$this->load->model('nota_perhitungan_model');
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$pejabat = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $pejabat->row();
	
		$data['spt_jenis_pajakretribusi'] = $this->input->get('spt_jenis_pajakretribusi');
		$data['model'] = $this->nota_perhitungan_model;
		
		$this->load->view('pdf_stpd', $data);
	}
	
	/**
	 * form_ketetapan_skpdt/tambahan
	 */
	function form_ketetapan_skpdt() {
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_ketetapan_skpdt', $data);
	}
	
	/**
	 * pdf skpdt
	 */
	function pdf_skpdt() {
		$this->load->model('nota_perhitungan_model');
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$pejabat = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $pejabat->row();
	
		$data['spt_jenis_pajakretribusi'] = $this->input->get('spt_jenis_pajakretribusi');
		$data['model'] = $this->nota_perhitungan_model;
		
		//insert history log
		$this->common_model->history_log("penetapan", "P", 
			"Print SKPDT : ".$_GET['spt_periode']." | ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['spt_nomor1']." - ".$_GET['spt_nomor2']);
		
		$this->load->view('pdf_skpdt', $data);
	}
	
	/**
	 * skpd nihil controller
	 */
	function form_ketetapan_skpdn() {
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_ketetapan_skpdn', $data);
	}
	
	/**
	 * cetak skpdn
	 */
	function pdf_skpdn() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$pejabat = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $pejabat->row();
	
		$data['spt_jenis_pajakretribusi'] = $this->input->get('spt_jenis_pajakretribusi');
		$data['model'] = $this->penetapan_lhp_model;
		
		//insert history log
		$this->common_model->history_log("penetapan", "P", 
			"Print SKPDN : ".$_GET['tahun']." | ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['no_kohir1']." - ".$_GET['no_kohir2']);
		
		$this->load->view('pdf_skpdn', $data);
	}
	
	/**
	 * skpd lebih bayar controller
	 */
	function form_ketetapan_skpdlb() {
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_ketetapan_skpdlb', $data);
	}
	
	function pdf_skpdlb() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$pejabat = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $pejabat->row();
	
		$data['spt_jenis_pajakretribusi'] = $this->input->get('spt_jenis_pajakretribusi');
		$data['model'] = $this->penetapan_lhp_model;
		
		//insert history log
		$this->common_model->history_log("penetapan", "P", 
			"Print SKPDLB : ".$_GET['tahun']." | ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['no_kohir1']." - ".$_GET['no_kohir2']);
		
		$this->load->view('pdf_skpdlb', $data);
	}
	
	/**
	 * skpd kurang bayar tambahan
	 */
	function form_ketetapan_skpkbt() {
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_ketetapan_skpdkbt', $data);
	}
	
	function pdf_skpdkbt() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$pejabat = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $pejabat->row();
	
		$data['spt_jenis_pajakretribusi'] = $this->input->get('spt_jenis_pajakretribusi');
		$data['model'] = $this->penetapan_lhp_model;
		
		//insert history log
		$this->common_model->history_log("penetapan", "P", 
			"Print SKPDKBT : ".$_GET['tahun']." | ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['no_kohir1']." - ".$_GET['no_kohir2']);
		
		$this->load->view('pdf_skpdkbt', $data);
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
						$row->pejda_nama.' / '.$row->ref_japeda_nama;
			}
		}
		
		return $arr_pejabat;
	}
}