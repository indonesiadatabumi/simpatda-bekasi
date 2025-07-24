<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Backup_data_wp class controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121209
 */
class Backup_data_wp extends Master_Controller {

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
		$data['kecamatan'] = $this->common_model->get_kecamatan();
		$this->load->view('form_backup_data_wp', $data);
	}
	
	/**
	 * export data to json
	 */
	function export() {
		//insert history log
		$this->common_model->history_log("BACKUP WP", "I", "Backup data WP");
		
		$dt_wp = $this->backup_data_model->get_wp();
		
		$list_wp = array();
		
		if ($dt_wp) {
			while ($row_wp = $dt_wp->FetchNextObject(false)) {
				$list_wp[] = array(				
								//data wp
								'wp_wr_id' => $row_wp->wp_wr_id,
								'wp_wr_no_form' => $row_wp->wp_wr_no_form,
								'wp_wr_jenis' => $row_wp->wp_wr_jenis,
								'wp_wr_gol' => $row_wp->wp_wr_gol,
								'wp_wr_no_urut' => $row_wp->wp_wr_no_urut,
								'wp_wr_kd_camat' => $row_wp->wp_wr_kd_camat,
								'wp_wr_kd_lurah' => $row_wp->wp_wr_kd_lurah,
								'wp_wr_nama' => $row_wp->wp_wr_nama,
								'wp_wr_almt' => $row_wp->wp_wr_almt,
								'wp_wr_lurah' => $row_wp->wp_wr_lurah,
								'wp_wr_camat' => $row_wp->wp_wr_camat,
								'wp_wr_kabupaten' => $row_wp->wp_wr_kabupaten,
								'wp_wr_telp' => $row_wp->wp_wr_telp,
								'wp_wr_nama_milik' => $row_wp->wp_wr_nama_milik,
								'wp_wr_almt_milik' => $row_wp->wp_wr_almt_milik,
								'wp_wr_lurah_milik' => $row_wp->wp_wr_lurah_milik,
								'wp_wr_camat_milik' => $row_wp->wp_wr_camat_milik,
								'wp_wr_kabupaten_milik' => $row_wp->wp_wr_kabupaten_milik,
								'wp_wr_telp_milik' => $row_wp->wp_wr_telp_milik,
								'wp_wr_kd_usaha' => $row_wp->wp_wr_kd_usaha,
								'wp_wr_tgl_kartu' => $row_wp->wp_wr_tgl_kartu,
								'wp_wr_tgl_terima_form' => $row_wp->wp_wr_tgl_terima_form,
								'wp_wr_tgl_bts_kirim' => $row_wp->wp_wr_tgl_bts_kirim,
								'wp_wr_tgl_form_kembali' => $row_wp->wp_wr_tgl_form_kembali,
								'wp_wr_jns_pemungutan' => $row_wp->wp_wr_jns_pemungutan,
								'wp_wr_pejabat' => $row_wp->wp_wr_pejabat,
								'wp_wr_status_aktif' => $row_wp->wp_wr_status_aktif,
								'wp_wr_tgl_tutup' => $row_wp->wp_wr_tgl_tutup,
								'wp_wr_kodepos' => $row_wp->wp_wr_kodepos,
								'wp_wr_wn' => $row_wp->wp_wr_wn,
								'wp_wr_jns_tb' => $row_wp->wp_wr_jns_tb,
								'wp_wr_no_tb' => $row_wp->wp_wr_no_tb,
								'wp_wr_tgl_tb' => $row_wp->wp_wr_tgl_tb,
								'wp_wr_no_kk' => $row_wp->wp_wr_no_kk,
								'wp_wr_tgl_kk' => $row_wp->wp_wr_tgl_kk,
								'wp_wr_pekerjaan' => $row_wp->wp_wr_pekerjaan,
								'wp_wr_nm_instansi' => $row_wp->wp_wr_nm_instansi,
								'wp_wr_alm_instansi' => $row_wp->wp_wr_alm_instansi,
								'wp_wr_kodepos_milik' => $row_wp->wp_wr_kodepos_milik,
								'wp_wr_bidang_usaha' => $row_wp->wp_wr_bidang_usaha,
								'wp_wr_tgl_buka' => $row_wp->wp_wr_tgl_buka,
								'wp_wr_no_formulir' => $row_wp->wp_wr_no_formulir
							);
			}
		}
		
		header("Content-type: application/json");
		header("Content-Disposition: attachment; filename=wp_".date("Ymd").".json");
		header("Expires: 0"); 
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public" );	
		
		$result = array(
					'list_wp' => $list_wp
				);
				
		echo json_encode($result);
	}
}