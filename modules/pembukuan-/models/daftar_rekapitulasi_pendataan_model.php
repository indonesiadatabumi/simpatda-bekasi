<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ini_set("memory_limit", "1000M");

/**
 * class Daftar_rekapitulasi_model
 * @package Simpatda
 */
class Daftar_rekapitulasi_pendataan_model extends CI_Model {
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
				$where .= " AND wp_wr_kd_camat='$kecamatan_id'";
			} 
				
			if ($jenis_laporan == 1) {
				if ($first_param != null && $second_param != null)
				$where .= " AND spt_tgl_proses BETWEEN '".format_tgl($first_param)."' AND '".format_tgl($second_param)."'";
			} else {
				if ($first_param != null && $second_param != null)
				$where .= " AND EXTRACT(MONTH FROM spt_tgl_proses) = $first_param
						AND EXTRACT(YEAR FROM spt_tgl_proses) = $second_param";	
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
					FROM v_daftar_rekapitulasi
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
			$where .= " AND a.wp_wr_kd_camat='$camat_id'";
			
		if ($jenis_laporan == 1) {
		
			if ($first_param != null && $second_param != null)
			$where .= " AND a.spt_tgl_proses BETWEEN '".format_tgl($first_param)."' AND '".format_tgl($second_param)."'";
		} else {
			if ($first_param != null && $second_param != null)
			$where .= " AND EXTRACT(MONTH FROM a.spt_tgl_proses) = $first_param
					AND EXTRACT(YEAR FROM a.spt_tgl_proses) = $second_param";	
		}
			
		if ($status_spt != null)
			$where .= " AND a.ketspt_id='$status_spt'";
			
		//jika jenis pajak restoran
		if ($jenis_pajak == 2) {
		
			if ($jenis_restoran == 0) {
					
			$sql = "SELECT a.*
				FROM v_daftar_rekapitulasi2 a LEFT JOIN wp_wr_detail b on a.wp_wr_id=b.wp_wr_id
				$where AND (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1' or b.wp_jenis_restoran='2') ORDER BY a.spt_nomor ASC ";
			} else if  ($jenis_restoran == 1 ) {
			
			$sql = "SELECT a.*
				FROM v_daftar_rekapitulasi2 a LEFT JOIN wp_wr_detail b on a.wp_wr_id=b.wp_wr_id
				$where AND (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1') ORDER BY a.spt_nomor ASC ";
			}else if  ($jenis_restoran == 2 ) {
			
			$sql = "SELECT a.*
				FROM v_daftar_rekapitulasi2 a LEFT JOIN wp_wr_detail b on a.wp_wr_id=b.wp_wr_id
			    $where AND b.wp_jenis_restoran='2' ORDER BY a.spt_nomor ASC ";
			}
				
		}
		
		else if  ($jenis_pajak == 4)
		{
			$sql = "SELECT *
				FROM v_daftar_rekapitulasi2 a
				$where
				ORDER BY a.spt_nomor ASC";	
		}
		else {
			$sql = "SELECT *
				FROM v_daftar_rekapitulasi a
				$where
				ORDER BY a.spt_nomor ASC";	
		}
		
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
					(EXTRACT(MONTH FROM spt_tgl_proses_tgl) >= $f_bulan AND EXTRACT(YEAR FROM spt_tgl_proses) >= $f_tahun)
					OR
					(EXTRACT(MONTH FROM spt_tgl_proses) <= $t_bulan AND EXTRACT(YEAR FROM spt_tgl_proses) <= $t_tahun)
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
}