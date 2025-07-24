<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Rekam_pajak Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121112
 */
class Rekam_pajak extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		$this->load->model('common_model');
		$this->load->model('objek_pajak_model');
		$this->load->model('sspd_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$this->load->view('form_menu_penyetoran');
	}
	
	/**
	 * cetak sspd
	 */
	function cetak_sspd() {
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(true);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$data['keterangan_spt'] = $this->common_model->get_record_list("ketspt_id as value, '[' || ketspt_kode || '] ' ||ketspt_ket as item",
																		"keterangan_spt", "ketspt_id IS NOT NULL", "ketspt_kode ASC");
		$this->load->view('form_cetak_sspd', $data);
	}
	
	/**
	 * entry pajak
	 */
	function setor_pajak() {
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(false);		
		$keterangan_spt = $this->common_model->get_record_list("ketspt_id as value, ketspt_singkat || ' - ' ||ketspt_ket as item",
																		"keterangan_spt", "ketspt_id IS NOT NULL", "ketspt_kode ASC");
		//$arr_pilihan[''] = "--";
		//$data['keterangan_spt'] = $arr_pilihan + $keterangan_spt;
		$data['keterangan_spt'] = $keterangan_spt;
		$this->load->view('form_rekam_setoran_pajak', $data);
	}
	
	/**
	 * get spt setor
	 */
	function get_sspd() {
		$get = '';
		if (is_array($_GET)) {
			foreach ($_GET as $key => $value) {
				$get .= "&".$key."=".$value;
			}	
		}
		$data['flexigrid_url'] = base_url()."bkp/rekam_pajak/get_sspd_list?sqtype=&squery=".$get;
		$this->load->view('popup_sspd', $data);
	}
	
	/**
	 * cetak_sspd_pdf
	 */
	function cetak_sspd_pdf() {
		$denda = 0;
		
		if ($this->input->get('spt_jenis_pajakretribusi') != "4")
			$arr_sspd = $this->sspd_model->get_sspd_detail(
												$this->input->get_post('spt_periode'),
												$this->input->get_post('spt_nomor'),
												$this->input->get_post('setorpajret_jenis_ketetapan'),
												$this->input->get_post('spt_jenis_pajakretribusi')
											);
		else 
			$arr_sspd = $this->sspd_model->get_sspd_detail_reklame(
												$this->input->get_post('spt_periode'),
												$this->input->get_post('spt_nomor'),
												$this->input->get_post('setorpajret_jenis_ketetapan'),
												$this->input->get_post('spt_jenis_pajakretribusi')
											);
			
		if (@$_GET['jenis_setoran'] == "1" || @$_GET['jenis_setoran'] == null || @empty($_GET['jenis_setoran'])) {
			if (count($arr_sspd) > 0) {
				$tanggal_setoran = date("Y-m-d");
				
				//cek jika cetak SSPD dari dinas atau UPTD
				if ($this->session->userdata('USER_SPT_CODE') == "10") {
					if ($this->input->get('tanggal_setor') != "") {
						$tanggal_setoran = format_tgl($this->input->get('tanggal_setor'));
					}
				}
				
				if ($arr_sspd[0]['tgl_jatuh_tempo'] != null  && $_REQUEST['spt_jenis_pajakretribusi'] != "4") {
					$diff_month = get_diff_months($arr_sspd[0]['tgl_jatuh_tempo'], $tanggal_setoran, $arr_sspd[0]['ketspt_id']);
					if ($diff_month > 0)
						$denda = ceil(0.02 * $arr_sspd[0]['spt_pajak'] * $diff_month);
				}
			}	
		}
		
		$data['denda'] = $denda;
		if ($denda > 0) {
			$query = $this->db->query("SELECT * FROM v_kode_rekening_pajak WHERE koderek='41407' AND jenis='0".$_REQUEST['spt_jenis_pajakretribusi']."'");
			$row = $query->row();
			
			$data['denda_kode_rekening'] = $row->korek_tipe.".".$row->korek_kelompok.".".$row->korek_jenis.".".$row->korek_objek.".".$row->jenis;
			$data['denda_nama_rekening'] = $row->korek_nama;
		}
		
		//data pemda
	    $pemda = $this->common_model->get_query('*', 'data_pemerintah_daerah');
	    $data['pemda'] = $pemda->row();
	    $data['setorpajret_jenis_ketetapan'] = $this->input->get('setorpajret_jenis_ketetapan');
	    $data['ar_rekam_setor'] = $arr_sspd;
		$data['penyetor'] = $this->input->get('penyetor');
		$data['cetak_tgl_setoran'] = $this->input->get('tanggal_setor');
		
		//insert history log
		$this->common_model->history_log("bkp", "P", 
			"Print SSPD : ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['spt_periode']." | ".$_GET['spt_nomor']." | ".$_GET['setorpajret_jenis_ketetapan']);
	    
		$this->load->view('pdf_cetak_sspd', $data);
	}
	
	/**
	 * cetak multi sspd
	 */
	function cetak_multi_sspd() {
		//data pemda
	    $pemda = $this->common_model->get_query('*', 'data_pemerintah_daerah');
	    $data['pemda'] = $pemda->row();
	    $data['model'] = $this->sspd_model;
	    $data['setorpajret_jenis_ketetapan'] = $this->input->get('setorpajret_jenis_ketetapan');
		$data['penyetor'] = $this->input->get('penyetor');
		$data['cetak_tgl_setoran'] = $this->input->get('tanggal_setor');
		
		//insert history log
		$spt_nomor2 = "";
		if ($_GET['spt_nomor2'] != "") {
			$spt_nomor2 = " - ".$_GET['spt_nomor2'];
		}
		$this->common_model->history_log("bkp", "P", 
			"Print SSPD : ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['spt_periode']." | ".$_GET['spt_nomor1'].$spt_nomor2." | ".$_GET['setorpajret_jenis_ketetapan']);
	    
		$this->load->view('pdf_cetak_multi_sspd', $data);
	}


	function cetak_multi_billing() {
		//data pemda
	    $pemda = $this->common_model->get_query('*', 'data_pemerintah_daerah');
	    $data['pemda'] = $pemda->row();
	    $data['model'] = $this->sspd_model;
	    $data['setorpajret_jenis_ketetapan'] = $this->input->get('setorpajret_jenis_ketetapan');
		$data['penyetor'] = $this->input->get('penyetor');
		$data['cetak_tgl_setoran'] = $this->input->get('tanggal_setor');
		
		//insert history log
		$spt_nomor2 = "";
		if ($_GET['spt_nomor2'] != "") {
			$spt_nomor2 = " - ".$_GET['spt_nomor2'];
		}
		$this->common_model->history_log("bkp", "P", 
			"Print SSPD : ".$_GET['spt_jenis_pajakretribusi']." | ".$_GET['spt_periode']." | ".$_GET['spt_nomor1'].$spt_nomor2." | ".$_GET['setorpajret_jenis_ketetapan']);
	    
		$this->load->view('pdf_cetak_billing', $data);
	}
	
	/**
	 * get sspd list
	 */
	function get_sspd_list() {
		$form_id = "spt_nomor";
		if ($this->input->get('form_id') != "" && $this->input->get('form_id') != null)
			$form_id = $this->input->get('form_id');
		
		$this->sspd_model->get_list_sspd($form_id);
	}
	
	/**
	 * function to proses setoran
	 */
	function proses_setoran() {
		$arr_sspd = $this->sspd_model->get_sspd_detail(
												$this->input->get_post('spt_periode'),
												$this->input->get_post('spt_nomor'),
												$this->input->get_post('setorpajret_jenis_ketetapan'),
												$this->input->get_post('spt_jenis_pajakretribusi')
										);
		
		$denda = 0;
		if (count($arr_sspd) > 0) {
			if ($arr_sspd[0]['tgl_jatuh_tempo'] != null && $_POST['tanggal_setor'] != "") {
				$diff_month = get_diff_months($arr_sspd[0]['tgl_jatuh_tempo'], format_tgl($this->input->post('tanggal_setor')), $arr_sspd[0]['ketspt_id']);
				if ($diff_month > 0)
					$denda = ceil(0.02 * $arr_sspd[0]['spt_pajak'] * $diff_month);
			}
		}
		
		if ($denda > 0) {
			$data['jenis_setoran'] = array('1' => 'Pokok Pajak + Denda', '2' => 'Pokok Pajak');
		} else {
			$data['jenis_setoran'] = array('2' => 'Pokok Pajak');
		}
		
		$data['denda'] = $denda;	
		$data['ar_rekam_setor'] = $arr_sspd;
		$this->load->view('form_list_setoran_pajak', $data);
	}
	
	/**
	 * view setoran grid
	 */
	function view_setoran() {
		$this->load->view('view_setoran_pajak');
	}
	
	/**
	 * get list setoran pajak
	 */
	function get_list_setoran() {
		$this->load->model('setor_pajak_model');
		$this->setor_pajak_model->get_list();
	}
	
	/**
	 * controller to export sspd to pdf
	 */
	function insert_setor_pajak() {
		$this->load->model('setor_pajak_model');
		$this->setor_pajak_model->insert_setor_pajak();
	}
	
	/**
	 * get pejabat daerah
	 */
	function get_pejabat_daerah() {
		$pejabat_daerah = $this->common_model->get_pejabat_daerah();
		$arr_pejabat = array();
		$arr_pejabat[''] = '--';
		if (count($pejabat_daerah) > 0) {
			foreach ($pejabat_daerah as $row) {
				$arr_pejabat[$row->pejda_nama.'|'.$row->ref_japeda_nama.'|'.$row->pejda_nip.'|'.$row->ref_pangpej_ket] = 
						$row->pejda_nama.' / '.$row->ref_japeda_nama;
			}
		}
		
		return $arr_pejabat;
	}
}