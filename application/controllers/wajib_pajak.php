<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * class Wajib_pajak 
 * @author Daniel
 * @package Simpatda
 * @version 20121016
 */
class Wajib_pajak extends CI_Controller
{
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('wajib_pajak_model');
	}
	/**
	 * popup_npwpd controller
	 */
	function popup_npwpd() {
		$status = $this->input->get('status');
		// $jenis_pajak = $this->input->get('jenispajak');
		// $kd_kecamatan = $this->input->get('kecamatan');
		// $nm_kecamatan = $this->wajib_pajak_model->get_kecamatan($kd_kecamatan);
		$title = "";
		$url = "";
		if ($status == "true") {
			$title = 'Tabel Referensi Wajib Pajak';
			$url = base_url()."wajib_pajak/get_list_aktif?sqtype=&squery=";
		} else if ($status == "false") {
			$title = 'Tabel Referensi Wajib Pajak Non Aktif';
			$url = base_url()."wajib_pajak/get_list_nonaktif?sqtype=&squery=";
		} 
		$data['title'] = $title;
		$data['flexigrid_url'] = $url;
		$this->load->view('popup_npwpd', $data);
	}

	function popup_npwpd_nonaktif() {
		$title = 'Tabel Referensi Wajib Pajak';
		$url = base_url()."wajib_pajak/get_list_popup_wp_nonaktif?sqtype=&squery=";
		$data['title'] = $title;
		$data['flexigrid_url'] = $url;
		$this->load->view('popup_npwpd_nonaktif', $data);
	}

	function popup_npwpd_teguran() {
		$status = $this->input->get('status');
		$jenis_pajak = $this->input->get('jenispajak');
		// $kd_kecamatan = $this->input->get('kecamatan');
		// $nm_kecamatan = $this->wajib_pajak_model->get_kecamatan($kd_kecamatan);
		$title = "";
		$url = "";
		if ($status == "true") {
			$title = 'Tabel Referensi Wajib Pajak';
			$url = base_url()."wajib_pajak/get_list_aktif_teguran?sqtype=&squery=&jenispajak=$jenis_pajak";
		} else if ($status == "false") {
			$title = 'Tabel Referensi Wajib Pajak Non Aktif';
			$url = base_url()."wajib_pajak/get_list_nonaktif_teguran?sqtype=&squery=";
		} 
		$data['title'] = $title;
		$data['flexigrid_url'] = $url;
		$this->load->view('popup_npwpd_teguran', $data);
	}

	function popup_npwpd_teguran_laporan() {
		$jenis_pajak = $this->input->get('jenis_pajak');
		$bulan = $this->input->get('bulan');
		$tahun = $this->input->get('tahun');
		// $kd_kecamatan = $this->input->get('kecamatan');
		// $nm_kecamatan = $this->wajib_pajak_model->get_kecamatan($kd_kecamatan);
		$title = 'Tabel Referensi Wajib Pajak';
		$url = base_url()."wajib_pajak/get_list_teguran_laporan?sqtype=&squery=&jenispajak=$jenis_pajak&bulan=$bulan&tahun=$tahun";
		$data['title'] = $title;
		$data['flexigrid_url'] = $url;
		$this->load->view('popup_npwpd_teguran_laporan', $data);
	}
	
	/**
	 * get wp sptpd
	 */
	function get_wp_sptpd() {
		$kodus = $this->uri->segment(3);
		$data['title'] = 'Tabel Referensi Wajib Pajak';
		$data['flexigrid_url'] = base_url()."wajib_pajak/get_list_sptpd/$kodus";
		$this->load->view('popup_npwpd', $data);
	}

	/**
	 * get data reklame
	 */
	function get_data_reklame() {
		// $kodus = $this->uri->segment(3);
		$data['title'] = 'Tabel Data Reklame';
		$data['flexigrid_url'] = base_url()."wajib_pajak/get_list_reklame";
		$this->load->view('popup_list_reklame', $data);
	}
	
	/**
	 * get list of wajib pajak
	 */
	function get_list_aktif() {
		// $jenis_pajak = $this->input->get('jenispajak');
		$this->wajib_pajak_model->get_list_wp('true');
	}

	function get_list_aktif_teguran() {
		// $jenis_pajak = $this->input->get('jenispajak');
		$this->wajib_pajak_model->get_list_wp_teguran('true');
	}

	function get_list_teguran_laporan($jenis_pajak, $bulan, $tahun) {
		$this->wajib_pajak_model->get_list_wp_teguran_laporan();
	}
	
	/**
	 * get_list_nonaktif wp
	 */
	function get_list_nonaktif() {
		$this->wajib_pajak_model->get_list_wp('false');
	}

	function get_list_nonaktif_teguran() {
		$this->wajib_pajak_model->get_list_wp_teguran('false');
	}

	function get_list_wp_tutup() {
		$this->wajib_pajak_model->get_list_wp('false');
	}
	/**
	 * get_list_sptpd
	 */
	function get_list_sptpd() {
		$kodus = $this->uri->segment(3);
		$this->wajib_pajak_model->get_list_wp('true', $kodus);
	}

	function get_list_wp_nonaktif() {
		$this->wajib_pajak_model->get_list_wp_nonaktif('false');
	}

	function get_list_popup_wp_nonaktif() {
		$this->wajib_pajak_model->get_list_popup_wp_nonaktif('false');
	}

	/**
	 * get_list_reklame
	 */
	function get_list_reklame() {
		$this->wajib_pajak_model->get_list_reklame();
	}
	
	/**
	 * get wp by npwpd
	 * and return array wp field
	 */
	function get_wp_by_npwpd() {
		$return = array();
		$kode_pajak = $this->input->post('wp_wr_kode_pajak');
		$golongan = $this->input->post('wp_wr_golongan');
		$jenis_pajak = $this->input->post('wp_wr_jenis_pajak');
		$no_registrasi = $this->input->post('wp_wr_no_registrasi');
		$kode_camat = $this->input->post('wp_wr_kode_camat');
		$kode_lurah = $this->input->post('wp_wr_kode_lurah');
		$kodus = $this->input->post('kodus');
		
		if ($kode_pajak != "" && $golongan != "" && $jenis_pajak != "" && $no_registrasi != "" && $kode_camat != "" && $kode_lurah != "") {
			$result = $this->wajib_pajak_model->get_wp_by_npwpd($kode_pajak, $golongan, $jenis_pajak, $no_registrasi, 
											$kode_camat, $kode_lurah, $kodus);
											
			if (count($result) > 0) {
				$return = array('status' => true, 'data' => $result);
			} else {
				$return = array('status' => false, 'msg' => 'Data WP tidak ditemukan');
			}
		}
		
		echo json_encode($return);
	}
	
	
	/**
	 * get list wp_by_jenis_pajak
	 */
	function popup_wp_by_jenis_pajak() {
		$kodus = $this->input->get('kodus');
		$title = 'Tabel Referensi Wajib Pajak';
		$url = base_url()."wajib_pajak/get_wp_by_jenis_pajak?sqtype=&squery=&kodus=".$kodus;
		$data['title'] = $title;
		$data['flexigrid_url'] = $url;
		$this->load->view('popup_npwpd', $data);
	}
	
	/**
	 * get_list_nonaktif wp
	 */
	function get_wp_by_jenis_pajak() {
		$kodus = $this->input->get('kodus');
		$this->wajib_pajak_model->get_wp_by_jenis_pajak($kodus);
	}
}