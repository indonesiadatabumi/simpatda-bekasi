<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SKPD Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Stpd extends Master_Controller {
	/**
	 * construct
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('stpd_model');
		$this->load->model('common_model');
		$this->load->model('objek_pajak_model');
	}
	
	/**
	 * index controller
	 */
	function index() {
		$this->load->view('view_stpd');
	}
	
	/**
	 * get list skpd
	 */
	function get_list() {
		$this->stpd_model->get_list();
	}
	
	function get_spt() {
		$get = '';
		if (is_array($_GET)) {
			foreach ($_GET as $key => $value) {
				$get .= "&".$key."=".$value;
			}	
		}
		$data['flexigrid_url'] = base_url()."penagihan/stpd/get_calon_stpd?sqtype=&squery=".$get;
		$this->load->view('popup_spt', $data);
	}
	
	/**
	 * get list spt
	 */
	function get_calon_stpd() {
		$this->stpd_model->get_calon_stpd();
	}
	
	/**
	 * get detail setoran
	 */
	function get_detail_setoran() {
		$query = $this->stpd_model->get_detail_setoran($_POST['setorpajret_id']);
		
		$result = array();
		if ($query != null || $query->num_rows() > 0) {
			$row = $query->row();
			$bulan_pengenaan = get_diff_months($row->setorpajret_jatuh_tempo, $row->setorpajret_tgl_bayar, $row->setorpajret_jenis_ketetapan);
			$pajak = round(($row->setorpajret_jlh_bayar * $this->config->item('bunga') * $bulan_pengenaan) / 100);
			
			$result = array(
					'setorpajret_id' => $row->setorpajret_id,
					'setorpajret_id_wp' => $row->setorpajret_id_wp,
					'wp_wr_jenis' => strtoupper($row->wp_wr_jenis),
					'wp_wr_gol' => $row->wp_wr_gol,
					'ref_kodus_kode' => $row->ref_kodus_kode,
					'wp_wr_no_urut' => $row->wp_wr_no_urut,
					'camat_kode' => $row->camat_kode,
					'lurah_kode' => $row->lurah_kode,
					'wp_wr_nama' => $row->wp_wr_nama,
					'wp_wr_almt' => $row->wp_wr_almt,
					'wp_wr_lurah' => $row->wp_wr_lurah,
					'wp_wr_camat' => $row->wp_wr_camat,
					'wp_wr_kabupaten' => $row->wp_wr_kabupaten,
					'setorpajret_periode_jual1' => format_tgl($row->setorpajret_periode_jual1),
					'setorpajret_periode_jual2' => format_tgl($row->setorpajret_periode_jual2),
					'setorpajret_jatuh_tempo' => format_tgl($row->setorpajret_jatuh_tempo),
					'setorpajret_tgl_bayar' => format_tgl($row->setorpajret_tgl_bayar),
					'setorpajret_jlh_bayar' => format_currency($row->setorpajret_jlh_bayar),
					'setorpajret_jlh_bayar_unformat' => $row->setorpajret_jlh_bayar,
					'bulan_pengenaan' => $bulan_pengenaan,
					'pajak' => format_currency($pajak)
				);
		}
		
		echo json_encode($result);
	}
	
	/**
	 * get next nomor stpd
	 */
	function get_next_nomor() {
		$stpd_nomor = $this->common_model->get_next_nomor_stpd($_POST['periode'], $_POST['jenis_pajak']);
		
		if (strlen($stpd_nomor) < 4)  {
			$selisih = 4 - strlen($stpd_nomor);
			for ($i=1;$i<=$selisih;$i++) {
				$stpd_nomor = "0".$stpd_nomor;
			}
		}
		echo $stpd_nomor;
		
	}
	
	function add() {
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(false);
		$year = date('Y');
		$years[$year] = $year;
		for ($i = 1; $i < 5; $i++) {
			$years[$year - $i] = $year - $i;
		}
		$data['tahun_pajak'] = $years;
		
		$this->load->view('add_stpd', $data);
	}
	
	function insert() {
		$result = $this->stpd_model->insert();
		echo json_encode($result);
	}
	
	/**
	 * edit data stpd
	 */
	function edit() {		
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(false);
		$year = date('Y');
		$years[$year] = $year;
		for ($i = 1; $i < 5; $i++) {
			$years[$year - $i] = $year - $i;
		}
		$data['tahun_pajak'] = $years;
		
		$query = $this->common_model->get_query('*', 'v_stpd', "stpd_id='".$this->input->post('stpd_id')."'");
		$data['row'] = $query->row();
		
		$this->load->view('edit_stpd', $data);
	}
	
	/**
	 * update stpd
	 */
	function update() {
		$result = $this->stpd_model->update();
		echo json_encode($result);
	}
	
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->stpd_model->delete($arr_id[$i]) == true) {				
				$counter++;
				//insert history log
				$this->common_model->history_log("penagihan", "D", "Delete STPD id : ".$arr_id[$i]);
			}
		}
		
		if ($counter != 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
	
	/**
	 * cetak stpd
	 */
	function cetak_stpd() {
		$data['objek_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(false);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_cetak_stpd', $data);
	}
	
	
	/**
	 * cetak stpd
	 */
	function get_list_cetak_stpd() {
		$this->load->view('popup_list_stpd');
	}
	
	/**
	 * get list data stpd
	 */
	function get_list_data_stpd() {
		$this->stpd_model->get_list_data_stpd();
	}
	
	/**
	 * pdf stpd
	 */
	function pdf_stpd() {
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		
		$pejabat = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $pejabat->row();
		$data['model'] = $this->stpd_model;
		
		//insert history log
		$this->common_model->history_log("penagihan", "P", "Print STPD : ".$_GET['periode']." | ".$_GET['jenis_pajak']." | ".$_GET['stpd_nomor1']." - ".$_GET['stpd_nomor2']);
		
		$this->load->view('pdf_stpd', $data);
	}
	
	/**
	 * cetak daftar stpd
	 */
	function cetak_daftar_stpd() {
		$kecamatan = $this->common_model->get_kecamatan();
		//get kecamatan
		$arr_kecamatan = array();
		
		if ($this->session->userdata('USER_SPT_CODE') == "10")
			$arr_kecamatan['0'] = "-- Pilih Kecamatan --";
		
		foreach ($kecamatan as $row) {
			$arr_kecamatan[$row->camat_id] = $row->camat_kode.' | '.$row->camat_nama;
		}
		$data['kecamatan'] = $arr_kecamatan;
		$data['jenis_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(false);
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$year = date('Y');
		$years[$year] = $year;
		for ($i = 1; $i < 5; $i++) {
			$years[$year - $i] = $year - $i;
		}
		$data['tahun'] = $years;
		
		$this->load->view('form_cetak_daftar_stpd', $data);
	}
	
	/**
	 * cetak daftar stpd
	 */
	function pdf_cetak_daftar() {
		$mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('mengetahui')."'");
		$data['mengetahui'] = $mengetahui->row();
		
		$diperiksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='".$this->input->get('diperiksa')."'");
		$data['diperiksa'] = $diperiksa->row();
		
		if ($this->input->get('camat_id'))
			$data['kecamatan'] = $this->common_model->get_record_value('camat_nama', 'kecamatan', "camat_id='".$this->input->get('camat_id')."'");
			
		$data['jenis_pajak'] = $this->common_model->get_record_value('ref_jenparet_ket', 'ref_jenis_pajak_retribusi', "ref_jenparet_id='".$this->input->get('jenis_pajak')."'");
		$data['query'] = $this->stpd_model->get_daftar_stpd();
		
		//insert history log
		$this->common_model->history_log("penagihan", "P", "Print Daftar STPD : ".$_GET['jenis_pajak']." | ".$_GET['bulan']." | ".$_GET['tahun']." | ".$_GET['camat_id']);
		
		$this->load->view('pdf_daftar_stpd', $data);
	}
	
	
	/**
	 * get pejabat daerah
	 */
	function get_pejabat_daerah() {
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