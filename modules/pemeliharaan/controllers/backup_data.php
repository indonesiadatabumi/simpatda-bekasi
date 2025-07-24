<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Backup_data class controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121209
 */
class Backup_data extends Master_Controller {

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
		$this->load->view('form_backup_data', $data);
	}
	
	/**
	 * view backup data
	 */
	function view() {
		$this->backup_data_model->get_list_data();
	}
	
	/**
	 * export data to json
	 */
	function export() {
		//insert history log
		$this->common_model->history_log("BACKUP SPT", "I", "Backup data spt");
			
		$dt_spt = $this->backup_data_model->get_spt();
		$dt_spt_detail = $this->backup_data_model->get_spt_detail();
		
		$list_spt = array();
		$list_spt_detail = array();
		
		if (count($dt_spt) > 0) {
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
				
								//data wp
								'wp_wr_id' => $row_spt->wp_wr_id,
								'wp_wr_no_form' => $row_spt->wp_wr_no_form,
								'wp_wr_jenis' => $row_spt->wp_wr_jenis,
								'wp_wr_gol' => $row_spt->wp_wr_gol,
								'wp_wr_no_urut' => $row_spt->wp_wr_no_urut,
								'wp_wr_kd_camat' => $row_spt->wp_wr_kd_camat,
								'wp_wr_kd_lurah' => $row_spt->wp_wr_kd_lurah,
								'wp_wr_nama' => $row_spt->wp_wr_nama,
								'wp_wr_almt' => $row_spt->wp_wr_almt,
								'wp_wr_lurah' => $row_spt->wp_wr_lurah,
								'wp_wr_camat' => $row_spt->wp_wr_camat,
								'wp_wr_kabupaten' => $row_spt->wp_wr_kabupaten,
								'wp_wr_telp' => $row_spt->wp_wr_telp,
								'wp_wr_nama_milik' => $row_spt->wp_wr_nama_milik,
								'wp_wr_almt_milik' => $row_spt->wp_wr_almt_milik,
								'wp_wr_lurah_milik' => $row_spt->wp_wr_lurah_milik,
								'wp_wr_camat_milik' => $row_spt->wp_wr_camat_milik,
								'wp_wr_kabupaten_milik' => $row_spt->wp_wr_kabupaten_milik,
								'wp_wr_telp_milik' => $row_spt->wp_wr_telp_milik,
								'wp_wr_kd_usaha' => $row_spt->wp_wr_kd_usaha,
								'wp_wr_tgl_kartu' => $row_spt->wp_wr_tgl_kartu,
								'wp_wr_tgl_terima_form' => $row_spt->wp_wr_tgl_terima_form,
								'wp_wr_tgl_bts_kirim' => $row_spt->wp_wr_tgl_bts_kirim,
								'wp_wr_tgl_form_kembali' => $row_spt->wp_wr_tgl_form_kembali,
								'wp_wr_jns_pemungutan' => $row_spt->wp_wr_jns_pemungutan,
								'wp_wr_pejabat' => $row_spt->wp_wr_pejabat,
								'wp_wr_status_aktif' => $row_spt->wp_wr_status_aktif,
								'wp_wr_tgl_tutup' => $row_spt->wp_wr_tgl_tutup,
								'wp_wr_kodepos' => $row_spt->wp_wr_kodepos,
								'wp_wr_wn' => $row_spt->wp_wr_wn,
								'wp_wr_jns_tb' => $row_spt->wp_wr_jns_tb,
								'wp_wr_no_tb' => $row_spt->wp_wr_no_tb,
								'wp_wr_tgl_tb' => $row_spt->wp_wr_tgl_tb,
								'wp_wr_no_kk' => $row_spt->wp_wr_no_kk,
								'wp_wr_tgl_kk' => $row_spt->wp_wr_tgl_kk,
								'wp_wr_pekerjaan' => $row_spt->wp_wr_pekerjaan,
								'wp_wr_nm_instansi' => $row_spt->wp_wr_nm_instansi,
								'wp_wr_alm_instansi' => $row_spt->wp_wr_alm_instansi,
								'wp_wr_kodepos_milik' => $row_spt->wp_wr_kodepos_milik,
								'wp_wr_bidang_usaha' => $row_spt->wp_wr_bidang_usaha,
								'wp_wr_tgl_buka' => $row_spt->wp_wr_tgl_buka,
								'wp_wr_no_formulir' => $row_spt->wp_wr_no_formulir
							);
			}
		}
		
		//spt detail
		if (count($dt_spt_detail) > 0) {
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
		
		$list_spt_air_tanah = array();
		$list_spt_air_tanah_detail = array();
		
		//check pajak air tanah is check
		$pos = stripos($this->input->get_post('jenis_pajak'), '8');
		if ($pos !== false) {
			$dt_spt_air_tanah = $this->backup_data_model->get_spt_air_tanah();
			$dt_spt_detail_air_tanah = $this->backup_data_model->get_spt_detail_air_tanah();
			
			if (count($dt_spt_air_tanah) > 0) {
				while ($row_air_tanah = $dt_spt_air_tanah->FetchNextObject(false)) {
					$list_spt_air_tanah[] = array(
									'spt_id' => $row_air_tanah->spt_id,
									'spt_periode' => $row_air_tanah->spt_periode,
									'spt_nomor' => $row_air_tanah->spt_nomor,
									'spt_kode_rek' => $row_air_tanah->spt_kode_rek,
									'spt_tgl_terima' => $row_air_tanah->spt_tgl_terima,
									'spt_tgl_bts_kembali' => $row_air_tanah->spt_tgl_bts_kembali,
									'spt_nama_penerima' => $row_air_tanah->spt_nama_penerima,
									'spt_alamat_penerima' => $row_air_tanah->spt_alamat_penerima,
									'spt_periode_jual1' => $row_air_tanah->spt_periode_jual1,
									'spt_periode_jual2' => $row_air_tanah->spt_periode_jual2,
									'spt_status' => $row_air_tanah->spt_status,
									'spt_nilai' => $row_air_tanah->spt_nilai,
									'spt_pajak' => $row_air_tanah->spt_pajak,
									'spt_operator' => $row_air_tanah->spt_operator,
									'spt_jenis_pajakretribusi' => $row_air_tanah->spt_jenis_pajakretribusi,
									'spt_idwpwr' => $row_air_tanah->spt_idwpwr,
									'spt_jenis_pemungutan' => $row_air_tanah->spt_jenis_pemungutan,
									'spt_tgl_proses' => $row_air_tanah->spt_tgl_proses,
									'spt_tgl_entry' => $row_air_tanah->spt_tgl_entry,
									'spt_tarif_persen' => $row_air_tanah->spt_tarif_persen,
									'spt_tarif_dasar' => $row_air_tanah->spt_tarif_dasar,
									'spt_no_register' => $row_air_tanah->spt_no_register,
									'spt_idwpwr_detail' => $row_air_tanah->spt_idwpwr_detail,
									'spt_kode' => $row_air_tanah->spt_kode,
									'spt_idwp_reklame' => $row_air_tanah->spt_idwp_reklame,
					
									//penetapan air tanah
									'netapajrek_id' => $row_air_tanah->netapajrek_id,
									'netapajrek_id_spt' => $row_air_tanah->netapajrek_id_spt,
									'netapajrek_tgl' => $row_air_tanah->netapajrek_tgl,
									'netapajrek_wkt_proses' => $row_air_tanah->netapajrek_wkt_proses,
									'netapajrek_tgl_jatuh_tempo' => $row_air_tanah->netapajrek_tgl_jatuh_tempo,
									'netapajrek_kohir' => $row_air_tanah->netapajrek_kohir,
									'netapajrek_jenis_ketetapan' => $row_air_tanah->netapajrek_jenis_ketetapan,
									'netapajrek_setoran_sebelumnya' => $row_air_tanah->netapajrek_setoran_sebelumnya,
									'netapajrek_besaran' => $row_air_tanah->netapajrek_besaran,
									'netapajrek_kode_rek' => $row_air_tanah->netapajrek_kode_rek,
									'netapajrek_id_lhp' => $row_air_tanah->netapajrek_id_lhp,
									'netapajrek_keterangan' => $row_air_tanah->netapajrek_keterangan,
					
									//data wp
									'wp_wr_id' => $row_air_tanah->wp_wr_id,
									'wp_wr_no_form' => $row_air_tanah->wp_wr_no_form,
									'wp_wr_jenis' => $row_air_tanah->wp_wr_jenis,
									'wp_wr_gol' => $row_air_tanah->wp_wr_gol,
									'wp_wr_no_urut' => $row_air_tanah->wp_wr_no_urut,
									'wp_wr_kd_camat' => $row_air_tanah->wp_wr_kd_camat,
									'wp_wr_kd_lurah' => $row_air_tanah->wp_wr_kd_lurah,
									'wp_wr_nama' => $row_air_tanah->wp_wr_nama,
									'wp_wr_almt' => $row_air_tanah->wp_wr_almt,
									'wp_wr_lurah' => $row_air_tanah->wp_wr_lurah,
									'wp_wr_camat' => $row_air_tanah->wp_wr_camat,
									'wp_wr_kabupaten' => $row_air_tanah->wp_wr_kabupaten,
									'wp_wr_telp' => $row_air_tanah->wp_wr_telp,
									'wp_wr_nama_milik' => $row_air_tanah->wp_wr_nama_milik,
									'wp_wr_almt_milik' => $row_air_tanah->wp_wr_almt_milik,
									'wp_wr_lurah_milik' => $row_air_tanah->wp_wr_lurah_milik,
									'wp_wr_camat_milik' => $row_air_tanah->wp_wr_camat_milik,
									'wp_wr_kabupaten_milik' => $row_air_tanah->wp_wr_kabupaten_milik,
									'wp_wr_telp_milik' => $row_air_tanah->wp_wr_telp_milik,
									'wp_wr_kd_usaha' => $row_air_tanah->wp_wr_kd_usaha,
									'wp_wr_tgl_kartu' => $row_air_tanah->wp_wr_tgl_kartu,
									'wp_wr_tgl_terima_form' => $row_air_tanah->wp_wr_tgl_terima_form,
									'wp_wr_tgl_bts_kirim' => $row_air_tanah->wp_wr_tgl_bts_kirim,
									'wp_wr_tgl_form_kembali' => $row_air_tanah->wp_wr_tgl_form_kembali,
									'wp_wr_jns_pemungutan' => $row_air_tanah->wp_wr_jns_pemungutan,
									'wp_wr_pejabat' => $row_air_tanah->wp_wr_pejabat,
									'wp_wr_status_aktif' => $row_air_tanah->wp_wr_status_aktif,
									'wp_wr_tgl_tutup' => $row_air_tanah->wp_wr_tgl_tutup,
									'wp_wr_kodepos' => $row_air_tanah->wp_wr_kodepos,
									'wp_wr_wn' => $row_air_tanah->wp_wr_wn,
									'wp_wr_jns_tb' => $row_air_tanah->wp_wr_jns_tb,
									'wp_wr_no_tb' => $row_air_tanah->wp_wr_no_tb,
									'wp_wr_tgl_tb' => $row_air_tanah->wp_wr_tgl_tb,
									'wp_wr_no_kk' => $row_air_tanah->wp_wr_no_kk,
									'wp_wr_tgl_kk' => $row_air_tanah->wp_wr_tgl_kk,
									'wp_wr_pekerjaan' => $row_air_tanah->wp_wr_pekerjaan,
									'wp_wr_nm_instansi' => $row_air_tanah->wp_wr_nm_instansi,
									'wp_wr_alm_instansi' => $row_air_tanah->wp_wr_alm_instansi,
									'wp_wr_kodepos_milik' => $row_air_tanah->wp_wr_kodepos_milik,
									'wp_wr_bidang_usaha' => $row_air_tanah->wp_wr_bidang_usaha,
									'wp_wr_tgl_buka' => $row_air_tanah->wp_wr_tgl_buka,
									'wp_wr_no_formulir' => $row_air_tanah->wp_wr_no_formulir
								);
				}
				
				
				if (count($dt_spt_detail_air_tanah) > 0) {
					while ($row_dt_air_tanah = $dt_spt_detail_air_tanah->FetchNextObject(false)) {
						$list_spt_air_tanah_detail[] = array(
										'spt_dt_id' => $row_dt_air_tanah->spt_dt_id,
										'spt_dt_id_spt' => $row_dt_air_tanah->spt_dt_id_spt,
										'spt_dt_korek' => $row_dt_air_tanah->spt_dt_korek,
										'spt_dt_jumlah' => $row_dt_air_tanah->spt_dt_jumlah,
										'spt_dt_tarif_dasar' => $row_dt_air_tanah->spt_dt_tarif_dasar,
										'spt_dt_persen_tarif' => $row_dt_air_tanah->spt_dt_persen_tarif,
										'spt_dt_pajak' => $row_dt_air_tanah->spt_dt_pajak,
										'spt_dt_lokasi' => $row_dt_air_tanah->spt_dt_lokasi,
										'spt_dt_diskon' => $row_dt_air_tanah->spt_dt_diskon,
										'spt_dt_jam' => $row_dt_air_tanah->spt_dt_jam	
									);
					}
				}
			}
		}
		
		header("Content-type: application/json");
		header("Content-Disposition: attachment; filename=spt_".date("Ymd").".json");
		header("Expires: 0"); 
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public" );	
		
		$result = array(
					'list_spt' => $list_spt,
					'list_spt_detail' => $list_spt_detail,
					'list_spt_air_tanah' => $list_spt_air_tanah,
					'list_spt_air_tanah_detail' => $list_spt_air_tanah_detail
				);
				
		echo json_encode($result);
	}
}