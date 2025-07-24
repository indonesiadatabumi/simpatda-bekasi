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
	function get_data_realisasi($jenis_pajak, $f_bulan, $f_tahun, $t_bulan, $t_tahun, $denda = "1") {
		$result = array();
		
		//jika denda tidak ditampilkan
		$sql_denda = "";
		if ($denda == "0") {
			$sql_denda = " AND korek_tipe='".$this->config->item('rek_tipe').
						"' AND korek_kelompok='".$this->config->item('rek_kelompok').
						"' AND korek_jenis='".$this->config->item('rek_jenis')."'";
		}
		
		$sql = "SELECT * FROM v_rekapitulasi_penerimaan 
				WHERE setorpajret_jenis_pajakretribusi=$jenis_pajak 
				AND (
					(EXTRACT(MONTH FROM skbh_tgl) >= $f_bulan AND EXTRACT(YEAR FROM skbh_tgl) >= $f_tahun)
					OR
					(EXTRACT(MONTH FROM skbh_tgl) <= $t_bulan AND EXTRACT(YEAR FROM skbh_tgl) <= $t_tahun)
				) $sql_denda ORDER BY skbh_id DESC, skbd_id ASC";
		
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
	function get_data_pajak($jenis_pajak, $f_bulan_pajak, $f_tahun_pajak, $t_bulan_pajak, $t_tahun_pajak, $denda = "1") {
		$result = array();
		
		//jika denda tidak ditampilkan
		$sql_denda = "";
		if ($denda == "0") {
			$sql_denda = " AND korek_tipe='".$this->config->item('rek_tipe').
						"' AND korek_kelompok='".$this->config->item('rek_kelompok').
						"' AND korek_jenis='".$this->config->item('rek_jenis')."'";
		}
		
		$sql = "SELECT * FROM v_rekapitulasi_penerimaan 
				WHERE setorpajret_jenis_pajakretribusi=$jenis_pajak 
				AND (
					(EXTRACT(MONTH FROM setorpajret_periode_jual1) >= $f_bulan_pajak AND EXTRACT(YEAR FROM setorpajret_periode_jual1) >= $f_tahun_pajak)
					OR
					(EXTRACT(MONTH FROM setorpajret_periode_jual1) <= $t_bulan_pajak AND EXTRACT(YEAR FROM setorpajret_periode_jual1) <= $t_tahun_pajak)
				) $sql_denda ORDER BY skbh_id DESC, skbd_id ASC";
		
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