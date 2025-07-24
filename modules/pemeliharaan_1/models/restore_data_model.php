<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Restore_data_model
 * @author	Daniel
 * @version 20121209
 */

class Restore_data_model extends CI_Model
{
	/**
	 * get data spt
	 */
	function insert_data() {
		$counter = 0;
		$file_path = $this->input->post('file_path');
		
		if (!empty($file_path)) {
			$contents = file_get_contents($file_path);			
			$json = json_decode($contents);
			
			$list_spt = $json->{'list_spt'};
			$list_spt_detail = $json->{'list_spt_detail'};
			
			if (count($list_spt) > 0) {
				foreach ($list_spt as $row_spt) {					
					if ($this->check_spt_nomor($row_spt->spt_nomor, $row_spt->spt_periode, $row_spt->spt_jenis_pajakretribusi))
						continue;
						
					//check firstly wp_wr
					$is_exist_wp = $this->check_wp_id($row_spt->spt_idwpwr);
					if (!$is_exist_wp) {
						//insert wp into db
						$arr_wp = array(
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
						$this->db->insert('wp_wr', $arr_wp);
					}
					
					$spt_id = $this->common_model->next_val('spt_spt_id_seq');
					$spt_id_old = $row_spt->spt_id;
					
					$arr_spt = array(
									'spt_id' => $spt_id,
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
									'spt_idwp_reklame' => $row_spt->spt_idwp_reklame
								);								
					$this->db->insert('spt', $arr_spt);
					
					//insert spt_detail
					foreach ($list_spt_detail as $row_spt_detail) {
						if ($row_spt_detail->spt_dt_id_spt == $spt_id_old) {
							$spt_detail_id = $this->common_model->next_val('spt_detail_spt_dt_id_seq'); 
							$arr_spt_detail = array(
												'spt_dt_id' => $spt_detail_id,
												'spt_dt_id_spt' => $spt_id,
												'spt_dt_korek' => $row_spt_detail->spt_dt_korek,
												'spt_dt_jumlah' => $row_spt_detail->spt_dt_jumlah,
												'spt_dt_tarif_dasar' => $row_spt_detail->spt_dt_tarif_dasar,
												'spt_dt_persen_tarif' => $row_spt_detail->spt_dt_persen_tarif,
												'spt_dt_pajak' => $row_spt_detail->spt_dt_pajak,
												'spt_dt_lokasi' => $row_spt_detail->spt_dt_lokasi,
												'spt_dt_diskon' => $row_spt_detail->spt_dt_diskon,
												'spt_dt_jam' => $row_spt_detail->spt_dt_jam	
											);
							$this->db->insert('spt_detail', $arr_spt_detail);
						}
					}
					
					if ($this->db->affected_rows() > 0) {
						$counter++;
					}
				}
			}
			
			
			$list_spt = $json->{'list_spt_air_tanah'};
			$list_spt_detail = $json->{'list_spt_air_tanah_detail'};
			
		if (count($list_spt) > 0) {
				foreach ($list_spt as $row_spt) {					
					if ($this->check_spt_nomor($row_spt->spt_nomor, $row_spt->spt_periode, $row_spt->spt_jenis_pajakretribusi))
						continue;
						
					//check firstly wp_wr
					$is_exist_wp = $this->check_wp_id($row_spt->spt_idwpwr);
					if (!$is_exist_wp) {
						//insert wp into db
						$arr_wp = array(
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
						$this->db->insert('wp_wr', $arr_wp);
					}
					
					$spt_id = $this->common_model->next_val('spt_spt_id_seq');
					$spt_id_old = $row_spt->spt_id;
					
					$arr_spt = array(
									'spt_id' => $spt_id,
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
									'spt_idwp_reklame' => $row_spt->spt_idwp_reklame
								);								
					$this->db->insert('spt', $arr_spt);
					
					//insert penetapan
					$record = array();		
					$record["netapajrek_id"] = $this->common_model->next_val("penetapan_pajak_retribusi_netapajrek_id_seq");
					$record["netapajrek_id_spt"] =  $spt_id;
					$record["netapajrek_wkt_proses"] =  $row_spt->netapajrek_wkt_proses;
					$record["netapajrek_tgl"] =  $row_spt->netapajrek_tgl;
					$record["netapajrek_tgl_jatuh_tempo"] = $row_spt->netapajrek_tgl_jatuh_tempo;
					$record["netapajrek_jenis_ketetapan"] = $row_spt->netapajrek_jenis_ketetapan;
					$record["netapajrek_kohir"] = $row_spt->netapajrek_kohir;
					$this->db->insert('penetapan_pajak_retribusi', $record);
					
					//insert spt_detail
					foreach ($list_spt_detail as $row_spt_detail) {
						if ($row_spt_detail->spt_dt_id_spt == $spt_id_old) {
							$spt_detail_id = $this->common_model->next_val('spt_detail_spt_dt_id_seq'); 
							$arr_spt_detail = array(
												'spt_dt_id' => $spt_detail_id,
												'spt_dt_id_spt' => $spt_id,
												'spt_dt_korek' => $row_spt_detail->spt_dt_korek,
												'spt_dt_jumlah' => $row_spt_detail->spt_dt_jumlah,
												'spt_dt_tarif_dasar' => $row_spt_detail->spt_dt_tarif_dasar,
												'spt_dt_persen_tarif' => $row_spt_detail->spt_dt_persen_tarif,
												'spt_dt_pajak' => $row_spt_detail->spt_dt_pajak,
												'spt_dt_lokasi' => $row_spt_detail->spt_dt_lokasi,
												'spt_dt_diskon' => $row_spt_detail->spt_dt_diskon,
												'spt_dt_jam' => $row_spt_detail->spt_dt_jam	
											);
							$this->db->insert('spt_detail', $arr_spt_detail);
						}
					}
					
					if ($this->db->affected_rows() > 0) {
						$counter++;
					}
				}
			}
		}
		
		if ($counter > 0) 
			echo json_encode(array('status' => true, 'msg' => "$counter data berhasil di-restore"));
		else 
			echo json_encode(array('status' => false, 'msg' => "Tidak ada data berhasil di-restore"));			
	}
	
	/**
	 * insert data to db uptd
	 */
	function insert_data_from_uptd() {
		$counter = 0;
		$counter_failed = 0;
		$file_path = $this->input->post('file_path');
		
		if (!empty($file_path)) {
			$contents = file_get_contents($file_path);			
			$json = json_decode($contents);
			
			$list_spt = $json->{'list_spt'};
			$list_spt_detail = $json->{'list_spt_detail'};
			
			if (count($list_spt) > 0) {
				foreach ($list_spt as $row_spt) {					
					if ($this->check_spt_nomor($row_spt->spt_nomor, $row_spt->spt_periode, $row_spt->spt_jenis_pajakretribusi))
						continue;
						
					//check firstly wp_wr
					$is_exist_wp = $this->check_wp_id($row_spt->spt_idwpwr);
					if ($is_exist_wp) {										
						$spt_id = $this->common_model->next_val('spt_spt_id_seq');
						$spt_id_old = $row_spt->spt_id;
						
						$arr_spt = array(
										'spt_id' => $spt_id,
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
										'spt_idwp_reklame' => $row_spt->spt_idwp_reklame
									);								
						$this->db->insert('spt', $arr_spt);
						
						//insert spt_detail
						if ($this->db->affected_rows() > 0) {
							foreach ($list_spt_detail as $row_spt_detail) {
								if ($row_spt_detail->spt_dt_id_spt == $spt_id_old) {
									$spt_detail_id = $this->common_model->next_val('spt_detail_spt_dt_id_seq'); 
									$arr_spt_detail = array(
														'spt_dt_id' => $spt_detail_id,
														'spt_dt_id_spt' => $spt_id,
														'spt_dt_korek' => $row_spt_detail->spt_dt_korek,
														'spt_dt_jumlah' => $row_spt_detail->spt_dt_jumlah,
														'spt_dt_tarif_dasar' => $row_spt_detail->spt_dt_tarif_dasar,
														'spt_dt_persen_tarif' => $row_spt_detail->spt_dt_persen_tarif,
														'spt_dt_pajak' => $row_spt_detail->spt_dt_pajak,
														'spt_dt_lokasi' => $row_spt_detail->spt_dt_lokasi,
														'spt_dt_diskon' => $row_spt_detail->spt_dt_diskon,
														'spt_dt_jam' => $row_spt_detail->spt_dt_jam	
													);
									$this->db->insert('spt_detail', $arr_spt_detail);
								}
							}
							
							$counter++;
						}
					} else {
						$counter_failed ++; 
					}
				}
			}
			
			//insert spt_reklame
			$list_spt_reklame = @$json->{'list_spt_reklame'};
			$list_spt_reklame_detail = @$json->{'list_spt_detail_reklame'};
			
			if (count($list_spt_reklame) > 0) {
				/*
				foreach ($list_spt_reklame as $dt_spt_reklame) {
					$id_wp_reklame = $dt_spt_reklame->spt_idwp_reklame;
					echo $id_wp_reklame."<br/>";
					print_r($list_wp_reklame->$id_wp_reklame);
					exit();
				}
				*/
				
				foreach ($list_spt_reklame as $dt_reklame) {
					if ($this->check_spt_nomor($dt_reklame->spt_nomor, $dt_reklame->spt_periode, $dt_reklame->spt_jenis_pajakretribusi))
						continue;
						
					//insert firstly wp_reklame
					$wp_id_reklame = $this->common_model->next_val('wp_wr_reklame_wp_rek_id_seq');
					$arr_wp_reklame = array(
								'wp_rek_id' => $wp_id_reklame,
								'wp_rek_jenis' => $dt_reklame->wp_rek_jenis,
								'wp_rek_kode' => $dt_reklame->wp_rek_kode,
								'wp_rek_nomor' => $dt_reklame->wp_rek_nomor,
								'wp_rek_nama' => $dt_reklame->wp_rek_nama,
								'wp_rek_alamat' => $dt_reklame->wp_rek_alamat,
								'wp_rek_lurah' => $dt_reklame->wp_rek_lurah,
								'wp_rek_camat' => $dt_reklame->wp_rek_camat,
								'wp_rek_kabupaten' => $dt_reklame->wp_rek_kabupaten,
								'wp_rek_merk_usaha' => $dt_reklame->wp_rek_merk_usaha								
							);
					$this->db->insert('wp_wr_reklame', $arr_wp_reklame);
					
					if ($this->db->affected_rows() > 0) {
						// insert spt
						$spt_id_reklame = $this->common_model->next_val('spt_spt_id_seq');
						$spt_id_old_reklame = $dt_reklame->spt_id;
						
						$arr_spt = array(
										'spt_id' => $spt_id_reklame,
										'spt_periode' => $dt_reklame->spt_periode,
										'spt_nomor' => $dt_reklame->spt_nomor,
										'spt_kode_rek' => $dt_reklame->spt_kode_rek,
										'spt_tgl_terima' => $dt_reklame->spt_tgl_terima,
										'spt_tgl_bts_kembali' => $dt_reklame->spt_tgl_bts_kembali,
										'spt_nama_penerima' => $dt_reklame->spt_nama_penerima,
										'spt_alamat_penerima' => $dt_reklame->spt_alamat_penerima,
										'spt_periode_jual1' => $dt_reklame->spt_periode_jual1,
										'spt_periode_jual2' => $dt_reklame->spt_periode_jual2,
										'spt_status' => $dt_reklame->spt_status,
										'spt_nilai' => $dt_reklame->spt_nilai,
										'spt_pajak' => $dt_reklame->spt_pajak,
										'spt_operator' => $dt_reklame->spt_operator,
										'spt_jenis_pajakretribusi' => $dt_reklame->spt_jenis_pajakretribusi,
										'spt_idwpwr' => $dt_reklame->spt_idwpwr,
										'spt_jenis_pemungutan' => $dt_reklame->spt_jenis_pemungutan,
										'spt_tgl_proses' => $dt_reklame->spt_tgl_proses,
										'spt_tgl_entry' => $dt_reklame->spt_tgl_entry,
										'spt_tarif_persen' => $dt_reklame->spt_tarif_persen,
										'spt_tarif_dasar' => $dt_reklame->spt_tarif_dasar,
										'spt_no_register' => $dt_reklame->spt_no_register,
										'spt_idwpwr_detail' => $dt_reklame->spt_idwpwr_detail,
										'spt_kode' => $dt_reklame->spt_kode,
										'spt_idwp_reklame' => $wp_id_reklame
									);								
						$this->db->insert('spt', $arr_spt);
						
						//insert penetapan
						$record = array();		
						$record["netapajrek_id"] = $this->common_model->next_val("penetapan_pajak_retribusi_netapajrek_id_seq");
						$record["netapajrek_id_spt"] =  $spt_id_reklame;
						$record["netapajrek_wkt_proses"] =  $dt_reklame->netapajrek_wkt_proses;
						$record["netapajrek_tgl"] =  $dt_reklame->netapajrek_tgl;
						$record["netapajrek_tgl_jatuh_tempo"] = $dt_reklame->netapajrek_tgl_jatuh_tempo;
						$record["netapajrek_jenis_ketetapan"] = $dt_reklame->netapajrek_jenis_ketetapan;
						$record["netapajrek_kohir"] = $dt_reklame->netapajrek_kohir;
						$this->db->insert('penetapan_pajak_retribusi', $record);					
						
						//insert spt_detail
						foreach ($list_spt_reklame_detail as $dt_detail) {
							if ($dt_detail->spt_dt_id_spt == $spt_id_old_reklame) {
								$spt_detail_id = $this->common_model->next_val('spt_detail_spt_dt_id_seq'); 
								$arr_spt_detail = array(
													'spt_dt_id' => $spt_detail_id,
													'spt_dt_id_spt' => $spt_id_reklame,
													'spt_dt_korek' => $dt_detail->spt_dt_korek,
													'spt_dt_jumlah' => $dt_detail->spt_dt_jumlah,
													'spt_dt_tarif_dasar' => $dt_detail->spt_dt_tarif_dasar,
													'spt_dt_persen_tarif' => $dt_detail->spt_dt_persen_tarif,
													'spt_dt_pajak' => $dt_detail->spt_dt_pajak,
													'spt_dt_lokasi' => $dt_detail->spt_dt_lokasi,
													'spt_dt_diskon' => $dt_detail->spt_dt_diskon,
													'spt_dt_jam' => $dt_detail->spt_dt_jam	
												);
								$this->db->insert('spt_detail', $arr_spt_detail);
								
								if (@$dt_detail->sptrek_nilai_tarif != NULL) {
									$tarif = $dt_detail->sptrek_nilai_tarif;
								} else {
									$tarif = $dt_detail->sptrek_nilai_klas_jalan;
								}
								$arr_spt_reklame = array(
													'sptrek_id_spt_dt' => $spt_detail_id,
													'sptrek_area' => $dt_detail->sptrek_area,
													'sptrek_judul' => $dt_detail->sptrek_judul,
													'sptrek_lokasi' => $dt_detail->sptrek_lokasi,
													'sptrek_id_klas_jalan' => $dt_detail->sptrek_id_klas_jalan,
													'sptrek_luas' => $dt_detail->sptrek_luas,
													'sptrek_jumlah' => $dt_detail->sptrek_jumlah,
													'sptrek_lama_pasang' => $dt_detail->sptrek_lama_pasang,
													'sptrek_durasi' => $dt_detail->sptrek_durasi,
													'sptrek_nilai_tarif' => $tarif,
													'sptrek_nsr' => $dt_detail->sptrek_nsr,
													'sptrek_tarif_pajak' => $dt_detail->sptrek_tarif_pajak,
													'sptrek_id_korek' => $dt_detail->sptrek_id_korek
												);
								$this->db->insert('spt_reklame', $arr_spt_reklame);
							}
						}
						
						$counter++;
					} else {
						$counter_failed++;
					}
				}
			}
		}
		
		if ($counter > 0) 
			echo json_encode(array('status' => true, 'msg' => "$counter data berhasil di-restore \n$counter_failed data gagal di-restore"));
		else 
			echo json_encode(array('status' => false, 'msg' => "Tidak ada data berhasil di-restore"));
	}
	
	/**
	 * insert data wp
	 */
	function insert_data_wp() {
		$counter = 0;
		$file_path = $this->input->post('file_path');
		
		if (!empty($file_path)) {
			$contents = file_get_contents($file_path);			
			$json = json_decode($contents);
			
			$list_wp = $json->{'list_wp'};
			
			if (count($list_wp) > 0) {
				foreach ($list_wp as $row_wp) {
					//check firstly wp_wr
					$is_exist_wp = $this->check_wp_id($row_wp->wp_wr_id);
					if (!$is_exist_wp) {
						//insert wp into db
						$arr_wp = array(
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
						$this->db->insert('wp_wr', $arr_wp);
					} else {
						//update into database
						$arr_wp = array(
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
								
						$this->db->where('wp_wr_id', $row_wp->wp_wr_id);
						$this->db->update('wp_wr', $arr_wp);
					}
					
					if ($this->db->affected_rows() > 0) {
						$counter++;
					}
				}
			}
		}
		
		if ($counter > 0) 
			echo json_encode(array('status' => true, 'msg' => "Data berhasil di-restore"));
		else 
			echo json_encode(array('status' => false, 'msg' => "Tidak ada data berhasil di-restore"));	
	}
	
	/**
	 * check nomor is exist
	 * @param unknown_type $spt_nomor
	 * @param unknown_type $periode
	 * @param unknown_type $spt_jenis_pajak
	 */
	function check_spt_nomor($spt_nomor, $periode, $spt_jenis_pajak) {
		$sql = "select * from spt where spt_nomor='$spt_nomor' and spt_periode='$periode' and spt_jenis_pajakretribusi='$spt_jenis_pajak'";
		$rs = $this->db->query($sql);
		
		if ($rs->num_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * check wp_wr_id
	 * @param unknown_type $wp_id
	 */
	function check_wp_id($wp_id) {
		$sql = "select * from wp_wr where wp_wr_id='$wp_id'";
		$rs = $this->db->query($sql);
		
		if ($rs->num_rows() > 0)
			return true;
		else 
			return false;
	}
}