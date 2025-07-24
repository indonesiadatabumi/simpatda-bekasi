<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ini_set("memory_limit", "8000M");

/**
 * class Daftar_rekapitulasi_model
 * @package Simpatda
 */
class Daftar_rekapitulasi_model extends CI_Model {
	/**
	 * keterangan spt
	 * @param unknown_type $spt_id
	 */
	function get_keterangan_spt($ket_id) {
		$result = $this->adodb->GetOne("SELECT ketspt_singkat FROM keterangan_spt WHERE ketspt_id=$ket_id");
		return $result;
	}
	
	/**
	 * get ref pajak
	 * @param unknown_type $pajak_id
	 */
	function get_ref_pajak($pajak_id) {
		$nama = $this->adodb->GetOne("SELECT ref_jenparet_ket FROM ref_jenis_pajak_retribusi WHERE ref_jenparet_id=$pajak_id");
		return $nama;
	}
	function get_koderek($pajak){
		$koderek = $this->adodb->GetOne("select koderek from v_kode_rekening_pajak5digit where korek_nama='$pajak' ");
		return $koderek;
	}	
	/**
	 * get_kecamtan
	 */
	function get_kecamatan($jenis_laporan, $jenis_pajak, $kecamatan_id = NULL, $first_param, $second_param, $status_spt, $jenis_restoran = 0, $type_cetak = 0) {			
		if ($type_cetak == 0) {
			$where = "WHERE spt_jenis_pajakretribusi IS NOT NULL ";
			if ($jenis_pajak != "") 
				$where .= " AND spt_jenis_pajakretribusi='$jenis_pajak'";
			
			if (isset($kecamatan_id) && !empty($kecamatan_id)) {
				if($jenis_pajak != '4'){
					$where .= " AND wp_wr_kd_camat='$kecamatan_id'";
				}elseif($jenis_pajak == '4'){
					$where .= " AND wp_wr_camat='$kecamatan_id'";
				}
			} 
				
			if ($jenis_laporan == 1) {
				if ($first_param != null && $second_param != null)
				$where .= " AND skbh_tgl BETWEEN '".format_tgl($first_param)."' AND '".format_tgl($second_param)."'";
			} else {
				if ($first_param != null && $second_param != null)
				$where .= " AND EXTRACT(MONTH FROM spt_periode_jual1) = $first_param
						AND EXTRACT(YEAR FROM spt_periode_jual1) = $second_param";	
			}
				
			if ($status_spt != "")
				$where .= " AND ketspt_id='$status_spt'";
				
			//jika jenis pajak restoran
			if ($jenis_pajak == "2") {
				if ($jenis_restoran == 1 || $jenis_restoran == 2) {
					$where .= " AND COALESCE(sptresto_jenis, 1)='".$jenis_restoran."'";
					
					$sql = "SELECT DISTINCT wp_wr_kd_camat camat_id, camat_kode, wp_wr_camat camat_nama
					FROM v_daftar_rekapitulasi2 LEFT JOIN spt_restoran ON v_daftar_rekapitulasi.spt_id=spt_restoran.sptresto_id_spt
					$where
					ORDER BY camat_kode ASC";
				} else {
					$sql = "SELECT DISTINCT wp_wr_kd_camat camat_id, camat_kode, wp_wr_camat camat_nama
					FROM v_daftar_rekapitulasi2
					$where
					ORDER BY camat_kode ASC";
				}
			} else {
				$sql = "SELECT DISTINCT wp_wr_kd_camat camat_id, camat_kode, wp_wr_camat camat_nama
					FROM v_daftar_rekapitulasi3
					$where
					ORDER BY camat_kode ASC";	
			}
		} 
		else 
		{
			if (isset($kecamatan_id) && !empty($kecamatan_id)) {
				$where .= " AND camat_id='$kecamatan_id'";
			}
			
			$sql = "SELECT *
					FROM kecamatan
				
					ORDER BY camat_kode ASC";
		}
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	/**
	 * get data spt
	 */

	function get_data_rekapitulasi($jenis_laporan, $jenis_pajak, $camat_id, $first_param, $second_param, $status_spt, $jenis_restoran) {
		
		$where = "WHERE a.spt_jenis_pajakretribusi IS NOT NULL ";
		if ($jenis_pajak != null) 
			$where .= " AND a.spt_jenis_pajakretribusi='$jenis_pajak'";
		
		if ($camat_id != null)
			if($jenis_pajak != '4'){
				$where .= " AND a.wp_wr_kd_camat='$camat_id'";
			} elseif($jenis_pajak == '4'){
				$where .= " AND a.wp_wr_camat='$camat_id'";
			}
			
		if ($jenis_laporan == 1) {
		
			if ($first_param != null && $second_param != null)
			$where .= " AND a.skbh_tgl BETWEEN '".format_tgl($first_param)."' AND '".format_tgl($second_param)."'";
		} else {
			if ($first_param != null && $second_param != null)
			$where .= " AND EXTRACT(MONTH FROM a.spt_periode_jual1) = $first_param
					AND EXTRACT(YEAR FROM a.spt_periode_jual1) = $second_param";	
		}
			
		if ($status_spt != null)
			$where .= " AND a.spt_status='$status_spt'";
			
		//jika jenis pajak restoran
		if ($jenis_pajak == 2) {
		
			if ($jenis_restoran == 0) {
					
			// $sql = "SELECT a.*, c.setorpajret_jlh_bayar
			// 	FROM v_daftar_rekapitulasi2 a 
			// 	LEFT JOIN wp_wr_detail b on a.wp_wr_id=b.wp_wr_id
			// 	LEFT JOIN setoran_pajak_retribusi c on a.spt_id=c.setorpajret_id_spt and a.spt_periode=c.setorpajret_spt_periode
			// 	$where AND (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1' or b.wp_jenis_restoran='2') ORDER BY a.spt_nomor ASC ";
			$sql =  "SELECT
						a.spt_id,
						a.spt_kode_billing,
						a.spt_periode,
						a.wp_wr_nama, 
						a.npwprd, 
						a.wp_wr_almt, 
						a.spt_periode_jual1, 
						a.spt_tgl_proses, 
						a.spt_nomor,
						b.spt_dt_jumlah AS omzet,
						a.spt_pajak
					FROM v_spt AS a
					LEFT JOIN spt_detail AS b ON a.spt_id=b.spt_dt_id_spt
					LEFT JOIN wp_wr_detail AS c ON a.spt_idwpwr=c.wp_wr_id
					$where AND (c.wp_jenis_restoran='0' or c.wp_jenis_restoran='1' or c.wp_jenis_restoran='2')
					ORDER BY a.spt_nomor ASC";
			} else if  ($jenis_restoran == 1 ) {
			
			// $sql = "SELECT a.*, c.setorpajret_jlh_bayar
			// 	FROM v_daftar_rekapitulasi2 a 
			// 	LEFT JOIN wp_wr_detail b on a.wp_wr_id=b.wp_wr_id
			// 	LEFT JOIN setoran_pajak_retribusi c on a.spt_id=c.setorpajret_id_spt and a.spt_periode=c.setorpajret_spt_periode
			// 	$where AND (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1') ORDER BY a.spt_nomor ASC ";
			$sql =  "SELECT
						a.spt_id,
						a.spt_kode_billing,
						a.spt_periode,
						a.wp_wr_nama, 
						a.npwprd, 
						a.wp_wr_almt, 
						a.spt_periode_jual1, 
						a.spt_tgl_proses, 
						a.spt_nomor,
						b.spt_dt_jumlah AS omzet,
						a.spt_pajak
					FROM v_spt AS a
					LEFT JOIN spt_detail AS b ON a.spt_id=b.spt_dt_id_spt
					LEFT JOIN wp_wr_detail AS c ON a.spt_idwpwr=c.wp_wr_id
					$where AND (c.wp_jenis_restoran='0' or c.wp_jenis_restoran='1')
					ORDER BY a.spt_nomor ASC";
			}else if  ($jenis_restoran == 2 ) {
			
			// $sql = "SELECT a.*, c.setorpajret_jlh_bayar
			// 	FROM v_daftar_rekapitulasi2 a 
			// 	LEFT JOIN wp_wr_detail b on a.wp_wr_id=b.wp_wr_id
			// 	LEFT JOIN setoran_pajak_retribusi c on a.spt_id=c.setorpajret_id_spt and a.spt_periode=c.setorpajret_spt_periode
			//     $where AND b.wp_jenis_restoran='2' ORDER BY a.spt_nomor ASC ";
			$sql =  "SELECT
						a.spt_id,
						a.spt_kode_billing,
						a.spt_periode,
						a.wp_wr_nama, 
						a.npwprd, 
						a.wp_wr_almt, 
						a.spt_periode_jual1, 
						a.spt_tgl_proses, 
						a.spt_nomor,
						b.spt_dt_jumlah AS omzet,
						a.spt_pajak
					FROM v_spt AS a
					LEFT JOIN spt_detail AS b ON a.spt_id=b.spt_dt_id_spt
					LEFT JOIN wp_wr_detail AS c ON a.spt_idwpwr=c.wp_wr_id
					$where AND c.wp_jenis_restoran='2'
					ORDER BY a.spt_nomor ASC";
			}
				
		}
		
		else if  ($jenis_pajak == 4)
		{
			// $sql = "SELECT a.*, b.netapajrek_tgl_jatuh_tempo, d.sptrek_judul, d.sptrek_lokasi, d.sptrek_luas, d.sptrek_lama_pasang
			// FROM v_daftar_rekapitulasi3 a
			// LEFT JOIN v_daftar_ketetapan_list b on a.spt_id=b.netapajrek_id
			// LEFT JOIN v_spt_detail c ON b.netapajrek_id_spt=c.spt_dt_id_spt
			// LEFT JOIN spt_reklame d on c.spt_dt_id=d.sptrek_id_spt_dt
			// $where
			// ORDER BY a.spt_nomor ASC";
			$sql =  "SELECT
						a.spt_id,
						a.spt_kode_billing,
						a.spt_periode,
						a.wp_wr_nama, 
						a.npwprd, 
						a.wp_wr_almt, 
						a.spt_periode_jual1, 
						a.spt_tgl_proses, 
						a.spt_nomor,
						a.spt_pajak,
						b.netapajrek_tgl_jatuh_tempo, 
						d.sptrek_judul, 
						d.sptrek_lokasi, 
						d.sptrek_luas, 
						d.sptrek_lama_pasang
					FROM v_spt AS a
					LEFT JOIN v_daftar_ketetapan_list b on a.spt_id=b.netapajrek_id_spt
					LEFT JOIN v_spt_detail c ON b.netapajrek_id_spt=c.spt_dt_id_spt
					LEFT JOIN spt_reklame d on c.spt_dt_id=d.sptrek_id_spt_dt
					$where
					ORDER BY a.spt_nomor ASC";	
		}
		else {
			$sql = "SELECT
						a.spt_id,
						a.spt_kode_billing,
						a.spt_periode,
						a.wp_wr_nama, 
						a.npwprd, 
						a.wp_wr_almt, 
						a.spt_periode_jual1, 
						a.spt_tgl_proses, 
						a.spt_nomor,
						b.spt_dt_jumlah AS omzet,
						a.spt_pajak
					FROM v_spt AS a
					LEFT JOIN spt_detail AS b ON a.spt_id=b.spt_dt_id_spt
					$where
					ORDER BY a.spt_nomor ASC";	
		}
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}

	function get_data_rekapitulasi_realisasi($jenis_laporan, $jenis_pajak, $camat_id, $first_param, $second_param, $status_spt, $jenis_restoran) {
	
		$where = "WHERE a.spt_jenis_pajakretribusi IS NOT NULL ";
		$where2 = "WHERE d.setorpajret_id_spt IS NULL";
		if ($jenis_pajak != null) 
			$where .= " AND a.spt_jenis_pajakretribusi='$jenis_pajak'";
			$where2 .= " AND a.spt_jenis_pajakretribusi='$jenis_pajak'";
		
		if ($camat_id != null)
			if($jenis_pajak != '4'){
				$where .= " AND a.wp_wr_kd_camat='$camat_id'";
				$where2 .= " AND a.wp_wr_kd_camat='$camat_id'";
			} elseif($jenis_pajak == '4'){
				$where .= " AND a.wp_wr_camat='$camat_id'";
				$where2 .= " AND a.wp_wr_camat='$camat_id'";
			}
			
		if ($jenis_laporan == 1) {
		
			if ($first_param != null && $second_param != null)
			$where .= " AND skbh_tgl BETWEEN '".format_tgl($first_param)."' AND '".format_tgl($second_param)."'";
			$where2 .= " AND date(tgl_pembayaran) BETWEEN '".format_tgl($first_param)."' AND '".format_tgl($second_param)."'";
		} else {
			if ($first_param != null && $second_param != null)
			$where .= " AND EXTRACT(MONTH FROM a.spt_periode_jual1) = $first_param
					AND EXTRACT(YEAR FROM a.spt_periode_jual1) = $second_param";	
		}
			
		if ($status_spt != null)
			$where .= " AND a.spt_status='$status_spt'";
			
		//jika jenis pajak reklame
		if  ($jenis_pajak == 4)
		{
			// $sql = "SELECT a.*, b.netapajrek_tgl_jatuh_tempo, d.sptrek_judul, d.sptrek_lokasi, d.sptrek_luas, d.sptrek_lama_pasang
			// FROM v_daftar_rekapitulasi3 a
			// LEFT JOIN v_daftar_ketetapan_list b on a.spt_id=b.netapajrek_id
			// LEFT JOIN v_spt_detail c ON b.netapajrek_id_spt=c.spt_dt_id_spt
			// LEFT JOIN spt_reklame d on c.spt_dt_id=d.sptrek_id_spt_dt
			// $where
			// ORDER BY a.spt_nomor ASC";	
			$sql = "SELECT
						a.wp_wr_nama,
						a.npwprd,
						a.wp_wr_almt,
						a.spt_periode_jual1,
						a.spt_tgl_proses,
						a.spt_nomor,
						b.spt_dt_jumlah AS omzet,
						a.spt_pajak,
						f.netapajrek_tgl_jatuh_tempo, 
						h.sptrek_judul, 
						h.sptrek_lokasi, 
						h.sptrek_luas, 
						h.sptrek_lama_pasang,
						e.skbh_no,
						e.skbh_tgl,
						c.setorpajret_jlh_bayar
					FROM v_spt AS a
					LEFT JOIN spt_detail AS b ON a.spt_id=b.spt_dt_id_spt
					LEFT JOIN setoran_pajak_retribusi AS c ON a.spt_nomor=c.setorpajret_no_spt AND a.spt_periode=c.setorpajret_spt_periode
					LEFT JOIN setoran_ke_bank_detail AS d ON c.setorpajret_id=d.skbd_id_setoran_pajak
					LEFT JOIN setoran_ke_bank_header AS e ON d.skbd_id_header=e.skbh_id
					LEFT JOIN v_daftar_ketetapan_list f on a.spt_id=f.netapajrek_id_spt
					LEFT JOIN v_spt_detail g ON f.netapajrek_id_spt=g.spt_dt_id_spt
					LEFT JOIN spt_reklame h on g.spt_dt_id=h.sptrek_id_spt_dt
					$where
					UNION
					SELECT
						a.wp_wr_nama,
						a.npwprd,
						a.wp_wr_almt,
						a.spt_periode_jual1,
						a.spt_tgl_proses,
						a.spt_nomor,
						b.spt_dt_jumlah AS omzet,
						a.spt_pajak,
						e.netapajrek_tgl_jatuh_tempo, 
						g.sptrek_judul, 
						g.sptrek_lokasi, 
						g.sptrek_luas, 
						g.sptrek_lama_pasang,
						c.ntp AS skbh_no,
						date(tgl_pembayaran) AS skbh_tgl,
						c.sptpd_yg_dibayar AS setorpajret_jlh_bayar
					FROM v_spt AS a
					LEFT JOIN spt_detail AS b ON a.spt_id=b.spt_dt_id_spt
					LEFT JOIN payment.pembayaran_sptpd AS c ON a.spt_kode_billing=c.kode_billing AND a.spt_periode=CAST(c.tahun_pajak AS smallint)
					LEFT JOIN setoran_pajak_retribusi AS d ON a.spt_id=d.setorpajret_id_spt
					LEFT JOIN v_daftar_ketetapan_list e on a.spt_id=e.netapajrek_id_spt
					LEFT JOIN v_spt_detail f ON e.netapajrek_id_spt=f.spt_dt_id_spt
					LEFT JOIN spt_reklame g on f.spt_dt_id=g.sptrek_id_spt_dt
					$where2";
		}
		else {
			$sql = "SELECT
					a.wp_wr_nama,
					a.npwprd,
					a.wp_wr_almt,
					a.spt_periode_jual1,
					a.spt_tgl_proses,
					a.spt_nomor,
					b.spt_dt_jumlah AS omzet,
					a.spt_pajak,
					e.skbh_no,
					e.skbh_tgl,
					c.setorpajret_jlh_bayar
				FROM v_spt AS a
				LEFT JOIN spt_detail AS b ON a.spt_id=b.spt_dt_id_spt
				LEFT JOIN setoran_pajak_retribusi AS c ON a.spt_id=c.setorpajret_id_spt AND a.spt_id=c.setorpajret_id_spt AND a.spt_periode=c.setorpajret_spt_periode
				LEFT JOIN setoran_ke_bank_detail AS d ON c.setorpajret_id=d.skbd_id_setoran_pajak
				LEFT JOIN setoran_ke_bank_header AS e ON d.skbd_id_header=e.skbh_id
				$where
				UNION
				SELECT
					a.wp_wr_nama,
					a.npwprd,
					a.wp_wr_almt,
					a.spt_periode_jual1,
					a.spt_tgl_proses,
					a.spt_nomor,
					b.spt_dt_jumlah AS omzet,
					a.spt_pajak,
					c.ntp AS skbh_no,
					date(tgl_pembayaran) AS skbh_tgl,
					c.sptpd_yg_dibayar AS setorpajret_jlh_bayar
				FROM v_spt AS a
				LEFT JOIN spt_detail AS b ON a.spt_id=b.spt_dt_id_spt
				LEFT JOIN payment.pembayaran_sptpd AS c ON a.spt_kode_billing=c.kode_billing AND a.spt_periode=CAST(c.tahun_pajak AS smallint)
				LEFT JOIN setoran_pajak_retribusi AS d ON a.spt_id=d.setorpajret_id_spt
				$where2";
			
		}
		// var_dump($sql);die;		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	/**
	 * get wp kecamatan
	 * @param unknown_type $kecamatan_id
	 */
	function get_wp_kecamatan($kecamatan_id, $jenis_pajak,$jenis_restoran, $bulan_pajak, $tahun_pajak) {
		if (!empty($kecamatan_id) && !empty($bulan_pajak) && !empty($tahun_pajak)) {
			
			/*
			$sql = "SELECT *
						FROM v_wp_wr
						WHERE wp_wr_kd_camat='$kecamatan_id' AND ref_kodus_kode='$jenis_pajak' AND 
							(wp_wr_status_aktif='TRUE' 
							OR 
							(wp_wr_status_aktif='FALSE' AND EXTRACT(MONTH FROM wp_wr_tgl_tutup) >= $bulan_pajak 
							AND EXTRACT(YEAR FROM wp_wr_tgl_tutup) = $tahun_pajak))";
			*/
			if ($jenis_pajak==2 AND $jenis_restoran==0) {
				
			
		
			$sql = "SELECT a.*
						FROM v_wp_wr a left join wp_wr_detail b on a.wp_wr_id=b.wp_wr_id
						where (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1' or b.wp_jenis_restoran='2')
						AND a.wp_wr_kd_camat='$kecamatan_id' AND a.ref_kodus_kode='$jenis_pajak' AND 
							(a.wp_wr_status_aktif='TRUE' 
							OR 
							(a.wp_wr_status_aktif='FALSE' AND EXTRACT(MONTH FROM a.wp_wr_tgl_tutup) >= $bulan_pajak AND EXTRACT(YEAR FROM a.wp_wr_tgl_tutup) = $tahun_pajak))";
				
				
				
				
				
		}else if ($jenis_pajak==2 AND $jenis_restoran==1) {
				
			
		
			$sql = "SELECT a.*
						FROM v_wp_wr a left join wp_wr_detail b on a.wp_wr_id=b.wp_wr_id
						where (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1')
						AND a.wp_wr_kd_camat='$kecamatan_id' AND a.ref_kodus_kode='$jenis_pajak' AND 
							(a.wp_wr_status_aktif='TRUE' 
							OR 
							(a.wp_wr_status_aktif='FALSE' AND EXTRACT(MONTH FROM a.wp_wr_tgl_tutup) >= $bulan_pajak AND EXTRACT(YEAR FROM a.wp_wr_tgl_tutup) = $tahun_pajak))";
				
				
				
				
				
		}else if ($jenis_pajak==2 AND $jenis_restoran==2) {
				
			
		
			$sql = "SELECT a.*
						FROM v_wp_wr a left join wp_wr_detail b on a.wp_wr_id=b.wp_wr_id
						where b.wp_jenis_restoran='2'
						AND a.wp_wr_kd_camat='$kecamatan_id' AND a.ref_kodus_kode='$jenis_pajak' AND 
							(a.wp_wr_status_aktif='TRUE' 
							OR 
							(a.wp_wr_status_aktif='FALSE' AND EXTRACT(MONTH FROM a.wp_wr_tgl_tutup) >= $bulan_pajak AND EXTRACT(YEAR FROM a.wp_wr_tgl_tutup) = $tahun_pajak))";
				
				
				
				
				
		}
		
		
		else {
		
			$sql = "SELECT *
						FROM v_wp_wr
						WHERE wp_wr_kd_camat='$kecamatan_id' AND ref_kodus_kode='$jenis_pajak' AND 
							(wp_wr_status_aktif='TRUE' 
							OR 
							(wp_wr_status_aktif='FALSE' AND EXTRACT(MONTH FROM wp_wr_tgl_tutup) >= $bulan_pajak AND EXTRACT(YEAR FROM wp_wr_tgl_tutup) = $tahun_pajak))";
								
		}
			
			
			
			$query = $this->db->query($sql);
			
			return $query->result_array();
		} else {
			return array();
		}
	} 
	
	/**
	 * get data realisasi pajak
	 * @param unknown_type $jenis_pajak
	 * @param unknown_type $f_bulan_pajak
	 * @param unknown_type $f_tahun_pajak
	 * @param unknown_type $t_bulan_pajak
	 * @param unknown_type $t_tahun_pajak
	 */
	function get_data_realisasi($jenis_pajak, $f_bulan, $f_tahun, $t_bulan, $t_tahun) {
		$result = array();
		$sql = "SELECT * FROM v_rekapitulasi_penerimaan 
				WHERE setorpajret_jenis_pajakretribusi=$jenis_pajak 
				AND (
					(EXTRACT(MONTH FROM skbh_tgl) >= $f_bulan AND EXTRACT(YEAR FROM skbh_tgl) >= $f_tahun)
					OR
					(EXTRACT(MONTH FROM skbh_tgl) <= $t_bulan AND EXTRACT(YEAR FROM skbh_tgl) <= $t_tahun)
				) ORDER BY skbh_id DESC, skbd_id ASC";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $rows) {
				$arr_realisasi = explode('-', $rows['skbh_tgl']);
				if (count($arr_realisasi) <= 1)
					continue;
					
				//make array like $rows[year][month][wp_id][spt_dt_id]
				$result[$arr_realisasi[0]][$arr_realisasi[1]][$rows['setorpajret_id_wp']][$rows['setorpajret_dt_id']] = $rows;
			}
		}
		//print_r($result);
		return $result;
	}
	
	/**
	 * get data pajak
	 */
	function get_data_pajak($jenis_pajak, $f_bulan_pajak, $f_tahun_pajak, $t_bulan_pajak, $t_tahun_pajak) {
		$result = array();
		$sql = "SELECT * FROM v_rekapitulasi_penerimaan 
				WHERE setorpajret_jenis_pajakretribusi=$jenis_pajak 
				AND (
					(EXTRACT(MONTH FROM setorpajret_periode_jual1) >= $f_bulan_pajak AND EXTRACT(YEAR FROM setorpajret_periode_jual1) >= $f_tahun_pajak)
					OR
					(EXTRACT(MONTH FROM setorpajret_periode_jual1) <= $t_bulan_pajak AND EXTRACT(YEAR FROM setorpajret_periode_jual1) <= $t_tahun_pajak)
				) ORDER BY skbh_id DESC, skbd_id ASC";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $rows) {
				$arr_periode = explode('-', $rows['setorpajret_periode_jual1']);
				if (count($arr_periode) <= 1)
					continue;
					
				//make array like $rows[year][month][wp_id][spt_dt_id]
				$result[$arr_periode[0]][$arr_periode[1]][$rows['setorpajret_id_wp']][$rows['setorpajret_dt_id']] = $rows;
			}
		}
		//print_r($result);
		return $result;
	}

	function getCamat($kd_camat){
		$sql_camat = "SELECT camat_nama FROM kecamatan WHERE camat_id = '$kd_camat'";
		$query = $this->db->query($sql_camat);
		return $query->row();
	}

	function cek_bayar($spt_id)  {
		$sql_bayar = "SELECT 
						skbh_no,
						skbh_tgl,
						setorpajret_jlh_bayar
					FROM setoran_pajak_retribusi AS a
					LEFT JOIN setoran_ke_bank_detail AS b ON a.setorpajret_id=b.skbd_id_setoran_pajak
					LEFT JOIN setoran_ke_bank_header AS c ON b.skbd_id_header=c.skbh_id
					WHERE setorpajret_id_spt='$spt_id'";
					
		$query = $this->db->query($sql_bayar);
		return $query->row();
	}

	function cek_bayar_bank($spt_kode_billing, $spt_periode)  {
		$sql_bayar = "SELECT 
						ntp AS skbh_no,
						DATE(tgl_pembayaran) AS skbh_tgl,
						sptpd_yg_dibayar AS setorpajret_jlh_bayar
					FROM payment.pembayaran_sptpd 
					WHERE kode_billing='$spt_kode_billing' AND tahun_pajak = '$spt_periode'";
		$query = $this->db->query($sql_bayar);
		return $query->row();
	}
}