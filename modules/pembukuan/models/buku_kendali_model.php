<?php 
/**
 * class Buku_kendali_model
 * @package Simpatda
 */
class Buku_kendali_model extends CI_Model {
	/**
	 * get ref pajak
	 * @param unknown_type $pajak_id
	 */
	function get_ref_pajak($pajak_id) {
		$nama = $this->adodb->GetOne("SELECT ref_jenparet_ket FROM ref_jenis_pajak_retribusi WHERE ref_jenparet_id=$pajak_id");
		return $nama;
	}
	
	/**
	 * get_kecamtan
	 */
	function get_kecamatan($kecamatan_id = NULL) {
		if (isset($kecamatan_id) && !empty($kecamatan_id)) {
			$this->db->where('camat_id', $kecamatan_id);
		} 
		
		$this->db->from('kecamatan');
		$this->db->order_by('camat_kode', 'ASC');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	/**
	 * get wp kecamatan
	 * @param unknown_type $kecamatan_id
	 */
	function get_wp_kecamatan($kecamatan_id, $jenis_pajak,$jenis_pajak_restoran, $bulan_pajak, $tahun_pajak) {
	 if (!empty($kecamatan_id) && !empty($bulan_pajak) && !empty($tahun_pajak)) {
			if ($jenis_pajak==2 AND $jenis_pajak_restoran==0) {
				
			
		
			$sql = "SELECT a.*
						FROM v_wp_wr a left join wp_wr_detail b on a.wp_wr_id=b.wp_wr_id
						where (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1' or b.wp_jenis_restoran='2')
						AND a.wp_wr_kd_camat='$kecamatan_id' AND a.ref_kodus_kode='$jenis_pajak' AND 
							(a.wp_wr_status_aktif='TRUE' 
							OR 
							(a.wp_wr_status_aktif='FALSE' AND EXTRACT(MONTH FROM a.wp_wr_tgl_tutup) >= $bulan_pajak AND EXTRACT(YEAR FROM a.wp_wr_tgl_tutup) = $tahun_pajak))";
				
				
				
				
				
		}else if ($jenis_pajak==2 AND $jenis_pajak_restoran==1) {
				
			
		
			$sql = "SELECT a.*
						FROM v_wp_wr a left join wp_wr_detail b on a.wp_wr_id=b.wp_wr_id
						where (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1')
						AND a.wp_wr_kd_camat='$kecamatan_id' AND a.ref_kodus_kode='$jenis_pajak' AND 
							(a.wp_wr_status_aktif='TRUE' 
							OR 
							(a.wp_wr_status_aktif='FALSE' AND EXTRACT(MONTH FROM a.wp_wr_tgl_tutup) >= $bulan_pajak AND EXTRACT(YEAR FROM a.wp_wr_tgl_tutup) = $tahun_pajak))";
				
				
				
				
				
		}else if ($jenis_pajak==2 AND $jenis_pajak_restoran==2) {
				
			
		
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
	}
		else {
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
	function get_data_realisasi($jenis_pajak, $jenis_pajak_restoran,$f_bulan, $f_tahun, $t_bulan, $t_tahun, $denda = "1") {
		
		
		
		$result = array();
		
		//jika denda tidak ditampilkan
		$sql_denda = "";
		if ($denda == "0") {
			// $sql_denda = " AND korek_tipe='".$this->config->item('rek_tipe').
			// 			"' AND korek_kelompok='".$this->config->item('rek_kelompok').
			// 			"' AND korek_jenis='".$this->config->item('rek_jenis')."'";
						
			// 			$sql_denda2 = " AND a.korek_tipe='".$this->config->item('rek_tipe').
			// 			"' AND a.korek_kelompok='".$this->config->item('rek_kelompok').
			// 			"' AND a.korek_jenis='".$this->config->item('rek_jenis')."'";	
			$sql_denda = " AND korek_tipe='4' AND korek_kelompok='1' AND korek_jenis='1'";
						
						$sql_denda2 = " AND a.korek_tipe='4' AND a.korek_kelompok='1' AND a.korek_jenis='1''";			
		}
		
		
		
		if ($jenis_pajak == 2 AND $jenis_pajak_restoran==0){
		$sql="SELECT a.skbh_id, a.skbh_tgl, a.skbh_no, a.skbh_nama, a.skbh_alamat, a.skbh_keterangan, 
       a.skbh_jumlah, a.skbh_bukti_setoran, a.bukti_setoran, a.skbh_created_time, 
       a.skbd_id, a.setorpajret_id, a.setorpajret_id_spt, a.setorpajret_no_bukti, 
       a.setorpajret_tgl_bayar, a.setorpajret_jlh_bayar, a.setorpajret_via_bayar, 
       a.setorpajret_jenis_ketetapan, a.setorpajret_id_wp, a.setorpajret_jenis_pajakretribusi, 
       a.setorpajret_spt_periode, a.setorpajret_no_spt, a.setorpajret_periode_jual1, 
       a.setorpajret_periode_jual2, a.setorpajret_jatuh_tempo, a.setorpajret_created_time, 
       a.setorpajret_created_by, a.setorpajret_dt_id, a.setorpajret_dt_id_setoran, 
       a.setorpajret_dt_rekening, a.korek_tipe, a.korek_kelompok, a.korek_jenis, 
       a.korek_objek, a.setorpajret_dt_jumlah,b.wp_jenis_restoran
  FROM v_rekapitulasi_penerimaan a left join wp_wr_detail b on a.setorpajret_id_wp=b.wp_wr_id
   where (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1' or b.wp_jenis_restoran='2')and a.setorpajret_jenis_pajakretribusi=$jenis_pajak   AND (
					(EXTRACT(MONTH FROM a.skbh_tgl) >= $f_bulan AND EXTRACT(YEAR FROM a.skbh_tgl) >= $f_tahun)
					OR
					(EXTRACT(MONTH FROM a.skbh_tgl) <= $t_bulan AND EXTRACT(YEAR FROM a.skbh_tgl) <= $t_tahun)
				) $sql_denda2 ORDER BY a.skbh_id DESC, a.skbd_id ASC";
			
			
		}else if ($jenis_pajak == 2 AND $jenis_pajak_restoran==1){
		$sql="SELECT a.skbh_id, a.skbh_tgl, a.skbh_no, a.skbh_nama, a.skbh_alamat, a.skbh_keterangan, 
       a.skbh_jumlah, a.skbh_bukti_setoran, a.bukti_setoran, a.skbh_created_time, 
       a.skbd_id, a.setorpajret_id, a.setorpajret_id_spt, a.setorpajret_no_bukti, 
       a.setorpajret_tgl_bayar, a.setorpajret_jlh_bayar, a.setorpajret_via_bayar, 
       a.setorpajret_jenis_ketetapan, a.setorpajret_id_wp, a.setorpajret_jenis_pajakretribusi, 
       a.setorpajret_spt_periode, a.setorpajret_no_spt, a.setorpajret_periode_jual1, 
       a.setorpajret_periode_jual2, a.setorpajret_jatuh_tempo, a.setorpajret_created_time, 
       a.setorpajret_created_by, a.setorpajret_dt_id, a.setorpajret_dt_id_setoran, 
       a.setorpajret_dt_rekening, a.korek_tipe, a.korek_kelompok, a.korek_jenis, 
       a.korek_objek, a.setorpajret_dt_jumlah,b.wp_jenis_restoran
  FROM v_rekapitulasi_penerimaan a left join wp_wr_detail b on a.setorpajret_id_wp=b.wp_wr_id
   where (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1')and a.setorpajret_jenis_pajakretribusi=$jenis_pajak   AND (
					(EXTRACT(MONTH FROM a.skbh_tgl) >= $f_bulan AND EXTRACT(YEAR FROM a.skbh_tgl) >= $f_tahun)
					OR
					(EXTRACT(MONTH FROM a.skbh_tgl) <= $t_bulan AND EXTRACT(YEAR FROM a.skbh_tgl) <= $t_tahun)
				) $sql_denda2 ORDER BY a.skbh_id DESC, a.skbd_id ASC";
			
			
		}if ($jenis_pajak == 2 AND $jenis_pajak_restoran==2){
		$sql="SELECT a.skbh_id, a.skbh_tgl, a.skbh_no, a.skbh_nama, a.skbh_alamat, a.skbh_keterangan, 
       a.skbh_jumlah, a.skbh_bukti_setoran, a.bukti_setoran, a.skbh_created_time, 
       a.skbd_id, a.setorpajret_id, a.setorpajret_id_spt, a.setorpajret_no_bukti, 
       a.setorpajret_tgl_bayar, a.setorpajret_jlh_bayar, a.setorpajret_via_bayar, 
       a.setorpajret_jenis_ketetapan, a.setorpajret_id_wp, a.setorpajret_jenis_pajakretribusi, 
       a.setorpajret_spt_periode, a.setorpajret_no_spt, a.setorpajret_periode_jual1, 
       a.setorpajret_periode_jual2, a.setorpajret_jatuh_tempo, a.setorpajret_created_time, 
       a.setorpajret_created_by, a.setorpajret_dt_id, a.setorpajret_dt_id_setoran, 
       a.setorpajret_dt_rekening, a.korek_tipe, a.korek_kelompok, a.korek_jenis, 
       a.korek_objek, a.setorpajret_dt_jumlah,b.wp_jenis_restoran
  FROM v_rekapitulasi_penerimaan a left join wp_wr_detail b on a.setorpajret_id_wp=b.wp_wr_id
   where b.wp_jenis_restoran='2' and a.setorpajret_jenis_pajakretribusi=$jenis_pajak   AND (
					(EXTRACT(MONTH FROM a.skbh_tgl) >= $f_bulan AND EXTRACT(YEAR FROM a.skbh_tgl) >= $f_tahun)
					OR
					(EXTRACT(MONTH FROM a.skbh_tgl) <= $t_bulan AND EXTRACT(YEAR FROM a.skbh_tgl) <= $t_tahun)
				) $sql_denda2 ORDER BY a.skbh_id DESC, a.skbd_id ASC";
			
			
		}
		else {
		
		$sql = "SELECT * FROM v_rekapitulasi_penerimaan 
				WHERE setorpajret_jenis_pajakretribusi=$jenis_pajak 
				AND (
					(EXTRACT(MONTH FROM skbh_tgl) >= $f_bulan AND EXTRACT(YEAR FROM skbh_tgl) >= $f_tahun)
					OR
					(EXTRACT(MONTH FROM skbh_tgl) <= $t_bulan AND EXTRACT(YEAR FROM skbh_tgl) <= $t_tahun)
				) $sql_denda ORDER BY skbh_id DESC, skbd_id ASC";
		}
		
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
	 
	 
	function get_data_pajak($jenis_pajak,$jenis_pajak_restoran, $f_bulan_pajak, $f_tahun_pajak, $t_bulan_pajak, $t_tahun_pajak, $denda = "1") {
		$result = array();
		
	
	//	$tglf='1';
	//	$tgle='30';
		//jika denda tidak ditampilkan
		$sql_denda = "";
		if ($denda == "0") {
		// 	$sql_denda = " AND korek_tipe='".$this->config->item('rek_tipe').
		// 				"' AND korek_kelompok='".$this->config->item('rek_kelompok').
		// 				"' AND korek_jenis='".$this->config->item('rek_jenis')."'";
						
		// $sql_denda2 = " AND a.korek_tipe='".$this->config->item('rek_tipe').
		// 				"' AND a.korek_kelompok='".$this->config->item('rek_kelompok').
		// 				"' AND a.korek_jenis='".$this->config->item('rek_jenis')."'";
		$sql_denda = " AND korek_tipe='4' AND korek_kelompok='1' AND korek_jenis='1'";
						
		$sql_denda2 = " AND a.korek_tipe='4' AND a.korek_kelompok='1' AND a.korek_jenis='1'";
		}
	/*	$sql = "SELECT * FROM v_rekapitulasi_penerimaan 
				WHERE setorpajret_jenis_pajakretribusi=$jenis_pajak 
				AND setorpajret_periode_jual1 between '".$f_tahun_pajak."-".$f_bulan_pajak."-".$tglf."' AND '".$t_tahun_pajak."-".$t_bulan_pajak."-".$tgle."' $sql_denda ORDER BY skbh_id DESC, skbd_id ASC";
	*/
				
			if ($jenis_pajak == 2 AND $jenis_pajak_restoran==0){
		$sql="SELECT a.skbh_id, a.skbh_tgl, a.skbh_no, a.skbh_nama, a.skbh_alamat, a.skbh_keterangan, 
       a.skbh_jumlah, a.skbh_bukti_setoran, a.bukti_setoran, a.skbh_created_time, 
       a.skbd_id, a.setorpajret_id, a.setorpajret_id_spt, a.setorpajret_no_bukti, 
       a.setorpajret_tgl_bayar, a.setorpajret_jlh_bayar, a.setorpajret_via_bayar, 
       a.setorpajret_jenis_ketetapan, a.setorpajret_id_wp, a.setorpajret_jenis_pajakretribusi, 
       a.setorpajret_spt_periode, a.setorpajret_no_spt, a.setorpajret_periode_jual1, 
       a.setorpajret_periode_jual2, a.setorpajret_jatuh_tempo, a.setorpajret_created_time, 
       a.setorpajret_created_by, a.setorpajret_dt_id, a.setorpajret_dt_id_setoran, 
       a.setorpajret_dt_rekening, a.korek_tipe, a.korek_kelompok, a.korek_jenis, 
       a.korek_objek, a.setorpajret_dt_jumlah,b.wp_jenis_restoran
  FROM v_rekapitulasi_penerimaan a left join wp_wr_detail b on a.setorpajret_id_wp=b.wp_wr_id
   where (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1' or b.wp_jenis_restoran='2')and a.setorpajret_jenis_pajakretribusi=$jenis_pajak   AND (
					(EXTRACT(MONTH FROM a.setorpajret_periode_jual1) >= $f_bulan_pajak AND EXTRACT(YEAR FROM a.setorpajret_periode_jual1) >= $f_tahun_pajak)
					OR
					(EXTRACT(MONTH FROM a.setorpajret_periode_jual1) <= $t_bulan_pajak AND EXTRACT(YEAR FROM a.setorpajret_periode_jual1) <= $t_tahun_pajak)
				) $sql_denda2 ORDER BY a.skbh_id DESC, a.skbd_id ASC";
			
			
		}else if ($jenis_pajak == 2 AND $jenis_pajak_restoran==1){
		$sql="SELECT a.skbh_id, a.skbh_tgl, a.skbh_no, a.skbh_nama, a.skbh_alamat, a.skbh_keterangan, 
       a.skbh_jumlah, a.skbh_bukti_setoran, a.bukti_setoran, a.skbh_created_time, 
       a.skbd_id, a.setorpajret_id, a.setorpajret_id_spt, a.setorpajret_no_bukti, 
       a.setorpajret_tgl_bayar, a.setorpajret_jlh_bayar, a.setorpajret_via_bayar, 
       a.setorpajret_jenis_ketetapan, a.setorpajret_id_wp, a.setorpajret_jenis_pajakretribusi, 
       a.setorpajret_spt_periode, a.setorpajret_no_spt, a.setorpajret_periode_jual1, 
       a.setorpajret_periode_jual2, a.setorpajret_jatuh_tempo, a.setorpajret_created_time, 
       a.setorpajret_created_by, a.setorpajret_dt_id, a.setorpajret_dt_id_setoran, 
       a.setorpajret_dt_rekening, a.korek_tipe, a.korek_kelompok, a.korek_jenis, 
       a.korek_objek, a.setorpajret_dt_jumlah,b.wp_jenis_restoran
  FROM v_rekapitulasi_penerimaan a left join wp_wr_detail b on a.setorpajret_id_wp=b.wp_wr_id
   where (b.wp_jenis_restoran='0' or b.wp_jenis_restoran='1')and a.setorpajret_jenis_pajakretribusi=$jenis_pajak   AND (
					(EXTRACT(MONTH FROM a.setorpajret_periode_jual1) >= $f_bulan_pajak AND EXTRACT(YEAR FROM a.setorpajret_periode_jual1) >= $f_tahun_pajak)
					OR
					(EXTRACT(MONTH FROM a.setorpajret_periode_jual1) <= $t_bulan_pajak AND EXTRACT(YEAR FROM a.setorpajret_periode_jual1) <= $t_tahun_pajak)
				) $sql_denda2 ORDER BY a.skbh_id DESC, a.skbd_id ASC";
			
			
		}if ($jenis_pajak == 2 AND $jenis_pajak_restoran==2){
		$sql="SELECT a.skbh_id, a.skbh_tgl, a.skbh_no, a.skbh_nama, a.skbh_alamat, a.skbh_keterangan, 
       a.skbh_jumlah, a.skbh_bukti_setoran, a.bukti_setoran, a.skbh_created_time, 
       a.skbd_id, a.setorpajret_id, a.setorpajret_id_spt, a.setorpajret_no_bukti, 
       a.setorpajret_tgl_bayar, a.setorpajret_jlh_bayar, a.setorpajret_via_bayar, 
       a.setorpajret_jenis_ketetapan, a.setorpajret_id_wp, a.setorpajret_jenis_pajakretribusi, 
       a.setorpajret_spt_periode, a.setorpajret_no_spt, a.setorpajret_periode_jual1, 
       a.setorpajret_periode_jual2, a.setorpajret_jatuh_tempo, a.setorpajret_created_time, 
       a.setorpajret_created_by, a.setorpajret_dt_id, a.setorpajret_dt_id_setoran, 
       a.setorpajret_dt_rekening, a.korek_tipe, a.korek_kelompok, a.korek_jenis, 
       a.korek_objek, a.setorpajret_dt_jumlah,b.wp_jenis_restoran
  FROM v_rekapitulasi_penerimaan a left join wp_wr_detail b on a.setorpajret_id_wp=b.wp_wr_id
   where b.wp_jenis_restoran='2' and a.setorpajret_jenis_pajakretribusi=$jenis_pajak   AND (
					(EXTRACT(MONTH FROM a.setorpajret_periode_jual1) >= $f_bulan_pajak AND EXTRACT(YEAR FROM a.setorpajret_periode_jual1) >= $f_tahun_pajak)
					OR
					(EXTRACT(MONTH FROM a.setorpajret_periode_jual1) <= $t_bulan_pajak AND EXTRACT(YEAR FROM a.setorpajret_periode_jual1) <= $t_tahun_pajak)
				) $sql_denda2 ORDER BY a.skbh_id DESC, a.skbd_id ASC";
			
			
		}
		else {	
				
				
				
		$sql = "SELECT * FROM v_rekapitulasi_penerimaan 
				WHERE setorpajret_jenis_pajakretribusi=$jenis_pajak 
				AND (
					(EXTRACT(MONTH FROM setorpajret_periode_jual1) >= $f_bulan_pajak AND EXTRACT(YEAR FROM setorpajret_periode_jual1) >= $f_tahun_pajak)
					OR
					(EXTRACT(MONTH FROM setorpajret_periode_jual1) <= $t_bulan_pajak AND EXTRACT(YEAR FROM setorpajret_periode_jual1) <= $t_tahun_pajak)
				) $sql_denda ORDER BY skbh_id DESC, skbd_id ASC";
				
		}		
		
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