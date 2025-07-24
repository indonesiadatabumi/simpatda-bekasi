<?php 
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
	
	function get_koderek($pajak) {
		$koderek = $this->adodb->GetOne("select koderek from v_kode_rekening_pajak5digit where korek_nama='$pajak' ");
		return $koderek;
	}
	
	function get_kd_camat($camat_id) {
		$kd_camat = $this->adodb->GetOne("select camat_kode from kecamatan where camat_id='$camat_id' ");
		return $kd_camat;
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
					FROM v_daftar_rekapitulasi LEFT JOIN spt_restoran ON v_daftar_rekapitulasi.spt_id=spt_restoran.sptresto_id_spt
					$where
					ORDER BY camat_kode ASC";
				} else {
					$sql = "SELECT DISTINCT wp_wr_kd_camat camat_id, camat_kode, wp_wr_camat camat_nama
					FROM v_daftar_rekapitulasi
					$where
					ORDER BY camat_kode ASC";
				}
			} else {
				$sql = "SELECT DISTINCT wp_wr_kd_camat camat_id, camat_kode, wp_wr_camat camat_nama
					FROM v_daftar_rekapitulasi
					$where
					ORDER BY camat_kode ASC";	
			}
		} else {
			if (isset($kecamatan_id) && !empty($kecamatan_id)) {
				$where .= " AND camat_id='$kecamatan_id'";
			}
			
			$sql = "SELECT *
					FROM kecamatan
					$where
					ORDER BY camat_kode ASC";
		}
		
		$query = $this->db->query($sql);
		return $query->result_array();	
	}
	
	/**
	 * get data spt
	 */
	function get_data_rekapitulasi($jenis_laporan, $jenis_pajak, $camat_id, $first_param, $second_param, $status_spt, $jenis_restoran = 0) {	
		$where = "WHERE spt_jenis_pajakretribusi IS NOT NULL ";
		if ($jenis_pajak != null) 
			$where .= " AND spt_jenis_pajakretribusi='$jenis_pajak'";
		
		if ($camat_id != null)
			$where .= " AND wp_wr_kd_camat='$camat_id'";
			
		if ($jenis_laporan == 1) {
			if ($first_param != null && $second_param != null)
			$where .= " AND skbh_tgl BETWEEN '".format_tgl($first_param)."' AND '".format_tgl($second_param)."'";
		} else {
			if ($first_param != null && $second_param != null)
			$where .= " AND EXTRACT(MONTH FROM spt_periode_jual1) = $first_param
					AND EXTRACT(YEAR FROM spt_periode_jual1) = $second_param";	
		}
			
		if ($status_spt != null)
			$where .= " AND ketspt_id='$status_spt'";
			
		//jika jenis pajak restoran
		if ($jenis_pajak == "2") {
			if ($jenis_restoran == 1 || $jenis_restoran == 2) {
				$where .= " AND COALESCE(sptresto_jenis, 1)='".$jenis_restoran."'";
				
				$sql = "SELECT *
				FROM v_daftar_rekapitulasi LEFT JOIN spt_restoran ON v_daftar_rekapitulasi.spt_id=spt_restoran.sptresto_id_spt
				$where
				ORDER BY spt_nomor ASC";
			} else {
				$sql = "SELECT *
				FROM v_daftar_rekapitulasi
				$where
				ORDER BY spt_nomor ASC";
			}
		} else {
			$sql = "SELECT *
				FROM v_daftar_rekapitulasi
				$where
				ORDER BY spt_nomor ASC";	
		}
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	function kecamatan_skpdkb($jenis_laporan, $jenis_pajak, $kecamatan_id = NULL, $first_param, $second_param, $status_spt, $jenis_restoran = 0, $type_cetak = 0){
		if ($type_cetak == 0) {
			$where = "WHERE a.koderek IS NOT NULL ";
			if ($jenis_pajak != "") 
				$where .= " AND a.koderek='$jenis_pajak'";
			
			if (isset($kecamatan_id) && !empty($kecamatan_id)) {
				$where .= " AND a.camat_kode='$kecamatan_id'";
			} 
				
			if ($first_param != null && $second_param != null)
				$where .= " AND EXTRACT(MONTH FROM b.lhp_dt_periode1) = $first_param
						AND EXTRACT(YEAR FROM b.lhp_dt_periode1) = $second_param";	
				
			if ($status_spt != "")
				$where .= " AND a.lhp_jenis_ketetapan='$status_spt'";
				
			$sql = "SELECT DISTINCT a.camat_kode, a.wp_wr_camat camat_nama
					FROM v_laporan_hasil_pemeriksaan a, v_laporan_hasil_pemeriksaan_detail b 
					$where
					and a.lhp_id=b.lhp_dt_id_header 
					ORDER BY a.camat_kode ASC";	

		} else {
			if (isset($kecamatan_id) && !empty($kecamatan_id)) {
				$where .= " AND camat_id='$kecamatan_id'";
			}
			
			$sql = "SELECT *
					FROM kecamatan
					$where
					ORDER BY camat_kode ASC";
		}

		$query = $this->db->query($sql);
		return $query->result_array();	
	}
	
	function kecamatan_skpdkb_realisasi($jenis_laporan, $jenis_pajak, $kecamatan_id = NULL, $first_param, $second_param, $status_spt, $jenis_restoran = 0, $type_cetak = 0){
		if ($type_cetak == 0) {
			$where = "WHERE a.koderek IS NOT NULL ";
			if ($jenis_pajak != "") 
				$where .= " AND a.koderek='$jenis_pajak'";
			
			if (isset($kecamatan_id) && !empty($kecamatan_id)) {
				$where .= " AND a.camat_kode='$kecamatan_id'";
			} 
				
			if ($first_param != null && $second_param != null)
				$where .= " AND s.skbh_tgl BETWEEN '".format_tgl($first_param)."' AND '".format_tgl($second_param)."'";
				
			if ($status_spt != "")
				$where .= " AND a.lhp_jenis_ketetapan='$status_spt'";
				
			$sql = "SELECT DISTINCT a.camat_kode, a.wp_wr_camat camat_nama
					FROM v_laporan_hasil_pemeriksaan a, v_laporan_hasil_pemeriksaan_detail b, v_penetapan_lhp c, v_sts s 
					$where
					and a.lhp_id=b.lhp_dt_id_header 
					and a.npwprd=c.npwprd and b.lhp_dt_id=c.lhp_dt_id and a.lhp_id=c.lhp_id and 
					c.netapajrek_id=s.setorpajret_id_spt and a.npwprd=s.npwprd and c.npwprd=s.npwprd 
					ORDER BY a.camat_kode ASC";	

		} else {
			if (isset($kecamatan_id) && !empty($kecamatan_id)) {
				$where .= " AND camat_id='$kecamatan_id'";
			}
			
			$sql = "SELECT *
					FROM kecamatan
					$where
					ORDER BY camat_kode ASC";
		}
		$query = $this->db->query($sql);
		return $query->result_array();	
	}

	function data_skpdkb($jenis_laporan = 0, $jenis_pajak, $camat_kode, $first_param, $second_param, $status_spt, $jenis_restoran = 0){
		$where = "WHERE a.koderek IS NOT NULL ";
		if ($jenis_pajak != null) 
			$where .= " AND a.koderek='$jenis_pajak'";
		
		if ($camat_kode != null)
			$where .= " AND camat_kode='$camat_kode'";
			
		if ($jenis_laporan == 1) {
			if ($first_param != null && $second_param != null)
			$where .= " AND lhp_tgl BETWEEN '".format_tgl($first_param)."' AND '".format_tgl($second_param)."'";
		} else {
			if ($first_param != null && $second_param != null)
			$where .= " AND EXTRACT(MONTH FROM a.lhp_tgl) = $first_param
					AND EXTRACT(YEAR FROM a.lhp_tgl) = $second_param";	
		}
			
		if ($status_spt != null)
			$where .= " AND lhp_jenis_ketetapan='$status_spt'";

		$sql = "select a.lhp_id, a.wp_wr_nama, a.npwprd, a.wp_wr_almt, a.lhp_tgl, a.lhp_no_periksa, b.pajak_msh_hrs_dbyr 
				from v_laporan_hasil_pemeriksaan a, v_laporan_hasil_pemeriksaan_detail b 
				$where 
				and a.lhp_id=b.lhp_dt_id 
				order by lhp_id asc";
		
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	/**
	 * get_kecamtan
	 */
	function get_kecamatan_skpdkb($jenis_laporan, $jenis_pajak, $kecamatan_id = NULL, $first_param, $second_param, $status_spt, $jenis_restoran = 0, $type_cetak = 0) {			
		if($kecamatan_id != NULL){
			$q = "select camat_kode from kecamatan where camat_id='$kecamatan_id' ";
			$x = $this->db->query($q);
			$r = $x->result_array();
			foreach($r as $rx){
				$kecamatan_id = $rx['camat_kode'];
			}
		}
		
		if ($type_cetak == 0) {
			$where = "WHERE a.koderek IS NOT NULL ";
			if ($jenis_pajak != "") 
				$where .= " AND a.koderek='4110$jenis_pajak'";
			
			if (isset($kecamatan_id) && !empty($kecamatan_id)) {
				$where .= " AND a.camat_kode='$kecamatan_id'";
			} 
				
			if ($jenis_laporan == 1) {
				if ($first_param != null && $second_param != null)
				$where .= " AND a.lhp_tgl BETWEEN '".format_tgl($first_param)."' AND '".format_tgl($second_param)."'";
			} else {
				if ($first_param != null && $second_param != null)
				$where .= " AND EXTRACT(MONTH FROM b.lhp_dt_periode1) = $first_param
						AND EXTRACT(YEAR FROM b.lhp_dt_periode1) = $second_param";	
			}
				
			if ($status_spt != "")
				$where .= " AND a.lhp_jenis_ketetapan='$status_spt'";
				
			//jika jenis pajak restoran
			if ($jenis_pajak == "2") {
					$sql = "SELECT DISTINCT a.camat_kode camat_id, a.wp_wr_camat camat_nama
					FROM v_laporan_hasil_pemeriksaan a, v_laporan_hasil_pemeriksaan_detail b
					$where
					ORDER BY a.camat_kode ASC";
			} else {
				$sql = "SELECT DISTINCT a.camat_kode camat_id,a.wp_wr_camat camat_nama
					FROM v_laporan_hasil_pemeriksaan a, v_laporan_hasil_pemeriksaan_detail b
					$where
					ORDER BY a.camat_kode ASC";	
			}
		} else {
			if (isset($kecamatan_id) && !empty($kecamatan_id)) {
				$where .= " AND camat_id='$kecamatan_id'";
			}
			
			$sql = "SELECT *
					FROM kecamatan
					$where
					ORDER BY camat_kode ASC";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/**
	 * get data skpdkb
	 */
	function get_data_rekapitulasi_skpdkb($jenis_laporan, $jenis_pajak, $camat_id, $first_param, $second_param, $status_spt, $jenis_restoran = 0) {	
		$q = "select camat_kode from kecamatan where camat_id='$camat_id' ";
		$x = $this->db->query($q);
		$r = $x->row();
		$camat_id = $r['camat_kode'];

		if($jenis_pajak==1)
			$jenis_pajak = '41101';
		if($jenis_pajak==2)
			$jenis_pajak = '41102';

		$where = "WHERE a.koderek IS NOT NULL ";
		if ($jenis_pajak != null)
			$where .= " AND a.koderek='$jenis_pajak'";
		
		if ($camat_id != null)
			$where .= " AND a.camat_kode='$camat_id'";
			
		if ($jenis_laporan == 1) {
			if ($first_param != null && $second_param != null)
			$where .= " AND a.lhp_tgl BETWEEN '".format_tgl($first_param)."' AND '".format_tgl($second_param)."'";
		} else {
			if ($first_param != null && $second_param != null)
			$where .= " AND EXTRACT(MONTH FROM b.lhp_dt_periode1) = $first_param
					AND EXTRACT(YEAR FROM b.lhp_dt_periode1) = $second_param";	
		}
			
		if ($status_spt != null)
			$where .= " AND a.lhp_jenis_ketetapan='$status_spt'";
			
		//jika jenis pajak restoran
		if ($jenis_pajak == "41102") {
/*
			if ($jenis_restoran == 1 || $jenis_restoran == 2) {
				$where .= " AND COALESCE(sptresto_jenis, 1)='".$jenis_restoran."'";
				
				$sql = "SELECT *
				FROM v_daftar_rekapitulasi LEFT JOIN spt_restoran ON v_daftar_rekapitulasi.spt_id=spt_restoran.sptresto_id_spt
				$where
				ORDER BY spt_nomor ASC";
			} else {
*/
				$sql = "SELECT a.lhp_id, a.wp_wr_nama, a.npwprd, a.wp_wr_almt, a.lhp_tgl, a.lhp_no_periksa, b.pjk_terhutang, a.lhp_tgl_periksa, b.lhp_dt_setoran, b.pajak_msh_hrs_dbyr
				FROM  v_laporan_hasil_pemeriksaan a, v_laporan_hasil_pemeriksaan_detail b
				$where
				AND a.lhp_id=b.lhp_dt_id
				ORDER BY a.lhp_id ASC";
//			}
		} else {
			$sql = "SELECT a.lhp_id, a.wp_wr_nama, a.npwprd, a.wp_wr_almt, a.lhp_tgl, a.lhp_no_periksa, b.pjk_terhutang, a.lhp_tgl_periksa, b.lhp_dt_setoran, b.pajak_msh_hrs_dbyr 
				FROM v_laporan_hasil_pemeriksaan a, v_laporan_hasil_pemeriksaan_detail b
				$where 
				AND a.lhp_id=b.lhp_dt_id
				ORDER BY a.lhp_id ASC";	
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/**
	 * get wp kecamatan
	 * @param unknown_type $kecamatan_id
	 */
	function get_wp_kecamatan($kecamatan_id, $jenis_pajak, $bulan_pajak, $tahun_pajak) {
		if (!empty($kecamatan_id) && !empty($bulan_pajak) && !empty($tahun_pajak)) {
			$sql = "SELECT *
						FROM v_wp_wr
						WHERE wp_wr_kd_camat='$kecamatan_id' AND ref_kodus_kode='$jenis_pajak' AND 
							(wp_wr_status_aktif='TRUE' 
							OR 
							(wp_wr_status_aktif='FALSE' AND EXTRACT(MONTH FROM wp_wr_tgl_tutup) >= $bulan_pajak AND EXTRACT(YEAR FROM wp_wr_tgl_tutup) = $tahun_pajak))";
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
}