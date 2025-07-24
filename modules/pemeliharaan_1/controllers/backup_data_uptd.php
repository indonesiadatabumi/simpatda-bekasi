<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Backup_data_uptd class controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121209
 */
class Backup_data_uptd extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('backup_data_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$data['jenis_pajak'] = $this->common_model->get_record_list('ref_jenparet_id as value, ref_jenparet_ket as item', 'ref_jenis_pajak_retribusi', null, 'ref_jenparet_id ASC');
		$data['kecamatan'] = $this->common_model->get_kecamatan();
		$this->load->view('form_backup_data_uptd', $data);
	}
	
	/**
	 * view backup data
	 */
	function view() {
		$this->backup_data_model->get_list_data_uptd();
	}
	
	/**
	 * export data to json
	 */
	function export() {
		$dt_spt = $this->backup_data_model->get_spt(true);
		$dt_spt_detail = $this->backup_data_model->get_spt_detail(true);
		
		$list_spt = array();
		$list_wp = array();
		$list_spt_detail = array();
		
		if ($dt_spt) {
			while ($row_spt = $dt_spt->FetchNextObject(false)) {
				$list_spt[] = array(
									'spt_id' => $row_spt->spt_id,
									'spt_periode' => $row_spt->spt_periode,
									'spt_nomor' => $row_spt->spt_nomor,
									'spt_kode_rek' => $row_spt->spt_kode_rek,
									'spt_tgl_terima' => $row_spt->spt_tgl_terima,
									'spt_tgl_bts_kembali' => $row_spt->spt_tgl_bts_kembali,
									'spt_nama_penerima' => $row_spt->spt_nama_penerima,
									'spt_alamat_penerima' => $row_spt->spt_alamat_penerima,
									'spt_periode_jual1' => $row_spt->spt_periode_jual1,
									'spt_periode_jual2' => $row_spt->spt_periode_jual2,
									'spt_status' => $row_spt->spt_status,
									'spt_nilai' => $row_spt->spt_nilai,
									'spt_pajak' => $row_spt->spt_pajak,
									'spt_operator' => $row_spt->spt_operator,
									'spt_jenis_pajakretribusi' => $row_spt->spt_jenis_pajakretribusi,
									'spt_idwpwr' => $row_spt->spt_idwpwr,
									'spt_jenis_pemungutan' => $row_spt->spt_jenis_pemungutan,
									'spt_tgl_proses' => $row_spt->spt_tgl_proses,
									'spt_tgl_entry' => $row_spt->spt_tgl_entry,
									'spt_tarif_persen' => $row_spt->spt_tarif_persen,
									'spt_tarif_dasar' => $row_spt->spt_tarif_dasar,
									'spt_no_register' => $row_spt->spt_no_register,
									'spt_idwpwr_detail' => $row_spt->spt_idwpwr_detail,
									'spt_kode' => $row_spt->spt_kode,
									'spt_idwp_reklame' => $row_spt->spt_idwp_reklame,
							);
			}
		}
		
		//spt detail
		if ($dt_spt_detail) {
			while ($row_spt_detail = $dt_spt_detail->FetchNextObject(false)) {
				$list_spt_detail[] = array(
									'spt_dt_id' => $row_spt_detail->spt_dt_id,
									'spt_dt_id_spt' => $row_spt_detail->spt_dt_id_spt,
									'spt_dt_korek' => $row_spt_detail->spt_dt_korek,
									'spt_dt_jumlah' => $row_spt_detail->spt_dt_jumlah,
									'spt_dt_tarif_dasar' => $row_spt_detail->spt_dt_tarif_dasar,
									'spt_dt_persen_tarif' => $row_spt_detail->spt_dt_persen_tarif,
									'spt_dt_pajak' => $row_spt_detail->spt_dt_pajak,
									'spt_dt_lokasi' => $row_spt_detail->spt_dt_lokasi,
									'spt_dt_diskon' => $row_spt_detail->spt_dt_diskon,
									'spt_dt_jam' => $row_spt_detail->spt_dt_jam	
							);
			}
		}
		
		//list spt reklame
		$dt_spt_reklame = $this->backup_data_model->get_spt_reklame();
		$list_spt_reklame = array();
		
		if ($dt_spt_reklame) {
			while ($row_spt_reklame = $dt_spt_reklame->FetchNextObject(false)) {
				$list_spt_reklame[] = array(
									'spt_id' => $row_spt_reklame->spt_id,
									'spt_periode' => $row_spt_reklame->spt_periode,
									'spt_nomor' => $row_spt_reklame->spt_nomor,
									'spt_kode_rek' => $row_spt_reklame->spt_kode_rek,
									'spt_tgl_terima' => $row_spt_reklame->spt_tgl_terima,
									'spt_tgl_bts_kembali' => $row_spt_reklame->spt_tgl_bts_kembali,
									'spt_nama_penerima' => $row_spt_reklame->spt_nama_penerima,
									'spt_alamat_penerima' => $row_spt_reklame->spt_alamat_penerima,
									'spt_periode_jual1' => $row_spt_reklame->spt_periode_jual1,
									'spt_periode_jual2' => $row_spt_reklame->spt_periode_jual2,
									'spt_status' => $row_spt_reklame->spt_status,
									'spt_nilai' => $row_spt_reklame->spt_nilai,
									'spt_pajak' => $row_spt_reklame->spt_pajak,
									'spt_operator' => $row_spt_reklame->spt_operator,
									'spt_jenis_pajakretribusi' => $row_spt_reklame->spt_jenis_pajakretribusi,
									'spt_idwpwr' => $row_spt_reklame->spt_idwpwr,
									'spt_jenis_pemungutan' => $row_spt_reklame->spt_jenis_pemungutan,
									'spt_tgl_proses' => $row_spt_reklame->spt_tgl_proses,
									'spt_tgl_entry' => $row_spt_reklame->spt_tgl_entry,
									'spt_tarif_persen' => $row_spt_reklame->spt_tarif_persen,
									'spt_tarif_dasar' => $row_spt_reklame->spt_tarif_dasar,
									'spt_no_register' => $row_spt_reklame->spt_no_register,
									'spt_idwpwr_detail' => $row_spt_reklame->spt_idwpwr_detail,
									'spt_kode' => $row_spt_reklame->spt_kode,
									'spt_idwp_reklame' => $row_spt_reklame->spt_idwp_reklame,

									//data wp_reklame
									'wp_rek_id' => $row_spt_reklame->wp_rek_id,
									'wp_rek_jenis' => $row_spt_reklame->wp_rek_jenis,
									'wp_rek_kode' => $row_spt_reklame->wp_rek_kode,
									'wp_rek_nomor' => $row_spt_reklame->wp_rek_nomor,
									'wp_rek_nama' => $row_spt_reklame->wp_rek_nama,
									'wp_rek_alamat' => $row_spt_reklame->wp_rek_alamat,
									'wp_rek_lurah' => $row_spt_reklame->wp_rek_lurah,
									'wp_rek_camat' => $row_spt_reklame->wp_rek_camat,
									'wp_rek_kabupaten' => $row_spt_reklame->wp_rek_kabupaten,
									'wp_rek_merk_usaha' => $row_spt_reklame->wp_rek_merk_usaha,	
				
									// data penetapan
									'netapajrek_id' => $row_spt_reklame->netapajrek_id,
									'netapajrek_id_spt' => $row_spt_reklame->netapajrek_id_spt,
									'netapajrek_tgl' => $row_spt_reklame->netapajrek_tgl,
									'netapajrek_wkt_proses' => $row_spt_reklame->netapajrek_wkt_proses,
									'netapajrek_tgl_jatuh_tempo' => $row_spt_reklame->netapajrek_tgl_jatuh_tempo,
									'netapajrek_kohir' => $row_spt_reklame->netapajrek_kohir,
									'netapajrek_jenis_ketetapan' => $row_spt_reklame->netapajrek_jenis_ketetapan,
									'netapajrek_setoran_sebelumnya' => $row_spt_reklame->netapajrek_setoran_sebelumnya,
									'netapajrek_besaran' => $row_spt_reklame->netapajrek_besaran,
									'netapajrek_kode_rek' => $row_spt_reklame->netapajrek_kode_rek,
									'netapajrek_id_lhp' => $row_spt_reklame->netapajrek_id_lhp,
									'netapajrek_keterangan' => $row_spt_reklame->netapajrek_keterangan
							);
			}
		}		
		
		//list spt_reklame_detail
		$dt_spt_reklame_detail = $this->backup_data_model->get_spt_detail_reklame();
		$list_spt_detail_reklame = array();
		
		if ($dt_spt_reklame_detail) {
			while ($row_spt_reklame_detail = $dt_spt_reklame_detail->FetchNextObject(false)) {
				$list_spt_detail_reklame[] = array(
									'spt_dt_id' => $row_spt_reklame_detail->spt_dt_id,
									'spt_dt_id_spt' => $row_spt_reklame_detail->spt_dt_id_spt,
									'spt_dt_korek' => $row_spt_reklame_detail->spt_dt_korek,
									'spt_dt_jumlah' => $row_spt_reklame_detail->spt_dt_jumlah,
									'spt_dt_tarif_dasar' => $row_spt_reklame_detail->spt_dt_tarif_dasar,
									'spt_dt_persen_tarif' => $row_spt_reklame_detail->spt_dt_persen_tarif,
									'spt_dt_pajak' => $row_spt_reklame_detail->spt_dt_pajak,
									'spt_dt_lokasi' => $row_spt_reklame_detail->spt_dt_lokasi,
									'spt_dt_diskon' => $row_spt_reklame_detail->spt_dt_diskon,
									'spt_dt_jam' => $row_spt_reklame_detail->spt_dt_jam,

									// data spt_reklame
									'sptrek_id' => $row_spt_reklame_detail->sptrek_id,
									'sptrek_id_spt_dt' => $row_spt_reklame_detail->sptrek_id_spt_dt,
									'sptrek_area' => $row_spt_reklame_detail->sptrek_area,
									'sptrek_judul' => $row_spt_reklame_detail->sptrek_judul,
									'sptrek_lokasi' => $row_spt_reklame_detail->sptrek_lokasi,
									'sptrek_id_klas_jalan' => $row_spt_reklame_detail->sptrek_id_klas_jalan,
									'sptrek_luas' => $row_spt_reklame_detail->sptrek_luas,
									'sptrek_jumlah' => $row_spt_reklame_detail->sptrek_jumlah,
									'sptrek_lama_pasang' => $row_spt_reklame_detail->sptrek_lama_pasang,
									'sptrek_durasi' => $row_spt_reklame_detail->sptrek_durasi,
									'sptrek_nilai_tarif' => $row_spt_reklame_detail->sptrek_nilai_tarif,
									'sptrek_nsr' => $row_spt_reklame_detail->sptrek_nsr,
									'sptrek_tarif_pajak' => $row_spt_reklame_detail->sptrek_tarif_pajak,
									'sptrek_id_korek' => $row_spt_reklame_detail->sptrek_id_korek
							);
			}
		}
		
		header("Content-type: application/json");
		header("Content-Disposition: attachment; filename=spt_uptd_".date("Ymd").".json");
		header("Expires: 0"); 
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public" );
		
		$result = array(
					'list_spt' => $list_spt,
					'list_spt_detail' => $list_spt_detail,
					'list_spt_reklame' => $list_spt_reklame,
					'list_spt_detail_reklame' => $list_spt_detail_reklame
				);	
				
		echo json_encode($result);
	}
}