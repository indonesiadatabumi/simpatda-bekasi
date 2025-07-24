<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Hasil_pemeriksaan controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Hasil_pemeriksaan extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('hasil_pemeriksaan_model');
		$this->load->model('common_model');
		$this->load->model('objek_pajak_model');
	}
	
	/**
	 * view hasil pemeriksaan
	 */
	function index() {
		$data['ketetapan'] = array(
								'' => "-- Pilih Ketetapan --",
								$this->config->item('status_skpdkb') => 'SKPDKB',
								$this->config->item('status_skpdkbt') => 'SKPDKBT',
								$this->config->item('status_skpdlb') => 'SKPDLB',
								$this->config->item('status_skpdn') => 'SKPDN',
								$this->config->item('status_skpdt') => 'SKPDT'
							);
		$data['jenis_pajak'] = $this->objek_pajak_model->get_ref_jenis_pajak_retribusi(false);
		$this->load->view('add_hasil_pemeriksaan', $data);
	}
	
	/**
	 * get list LHP
	 */
	function get_list() {
		$this->hasil_pemeriksaan_model->get_list_lhp();
	}
	
	/**
	 * view laporan pemeriksaan
	 */
	function view() {
		$this->load->view('view_hasil_pemeriksaan');
	}
	
	/**
	 * insert new LHP
	 */
	function save() {
		/*
		//check if exist or not
		$check_lhp = $this->hasil_pemeriksaan_model->check_lhp_exist(
																"",
																$this->input->post('lhp_periode'),
																$this->input->post('lhp_jenis_ketetapan'),
																$_POST['lhp_dt_periode1'][0],
																$_POST['lhp_dt_periode2'][0],
																$_POST['wp_wr_id']
															);
		*/
		
		//if (!$check_lhp) {
			$this->hasil_pemeriksaan_model->insert();
		//} else {
		//	echo json_encode(array('status' => false, 'msg' => 'Data sudah ada untuk periode tersebut.'));
		//}		
	}
	
	function edit() {
		$data['ketetapan'] = array(
								'' => "-- Pilih Ketetapan --",
								$this->config->item('status_skpdkb') => 'SKPDKB',
								$this->config->item('status_skpdkbt') => 'SKPDKBT',
								$this->config->item('status_skpdlb') => 'SKPDLB',
								$this->config->item('status_skpdn') => 'SKPDN',
								$this->config->item('status_skpdt') => 'SKPDT'
							);
		$data['jenis_pajak'] = $this->objek_pajak_model->get_ref_jenis_pajak_retribusi(false);
		$data['row'] = $this->hasil_pemeriksaan_model->get_lhp_data();
		$data['row_detail'] = $this->hasil_pemeriksaan_model->get_lhp_detail();
		$this->load->view('edit_hasil_pemeriksaan', $data);
	}
	
	function update() {
		$this->hasil_pemeriksaan_model->edit();	
	}
	
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->hasil_pemeriksaan_model->delete($arr_id[$i]) == true)
				$counter++;
		}
		
		if ($counter != 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
	
	/**
	 * get setoran wp
	 */
	function get_setoran_wp() {
		$get = '?sqtype=&squery=';
		if (is_array($_GET)) {
			foreach ($_GET as $key => $value) {
				$get .= "&".$key."=".$value;
			}	
		}
		
		$data['flexigrid_url'] = base_url()."pendataan/hasil_pemeriksaan/get_list_setoran_wp/".$get;
		$this->load->view('popup_lhp_wp', $data);
	}
	
	/**
	 * get list setoran wp
	 */
	function get_list_setoran_wp() {
		$wp_id = $this->input->get('wp_id');
		$korek_id = $this->input->get('korek_id');
		$row_id = $this->input->get('row_id');
		
		$this->hasil_pemeriksaan_model->get_list_setoran_wp($wp_id, $korek_id, $row_id);
	}
	
	/**
	 * check bunga LHP
	 */
	function check_bunga() {
		$bunga = 0;
		$date1 = $this->input->post('date1');
		$date2 = $this->input->post('date2');
		$pokok = unformat_currency($this->input->post('pokok'));
		
		$months = $this->countMonth ($date1, $date2);
		$dayOut = $this->adodb->GetOne("SELECT ref_jatem_batas_bayar_self from ref_jatuh_tempo");
		$date1 = explode("-",$date1);
		if ($date1[1] < $dayOut) 
			$months = $months - 1;
		$bunga = ($months * 2 * $pokok) / 100;
		
		echo $bunga;
	}
	
	/**
	 * To find how many months between two date $date1 > $date2
	 * @param unknown_type $date1
	 * @param unknown_type $date2
	 */
	function countMonth ($date1,$date2) {
		$date1 = new DateTime(format_tgl($date1));
		$date2 = new DateTime(format_tgl($date2));
		$interval = date_diff($date1, $date2);
		return $interval->format('%m');
	} 
}