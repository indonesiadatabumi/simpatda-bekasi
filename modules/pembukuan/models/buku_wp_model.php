<?php 
/**
 * class Buku_wp_model
 * @package Simpatda
 */
class Buku_wp_model extends CI_Model {
	/**
	 * get data buku wp
	 */
	function get_data($wp_id, $jenis_pemungutan, $tahun_pajak) {
		if (empty($wp_id) || empty($jenis_pemungutan) || empty($tahun_pajak))
			return false;
			
		$tahun_pajak_sebelumnya = $tahun_pajak - 1;
			
		if ($jenis_pemungutan == 1) {
			// self assesment
			$sql = "SELECT DISTINCT vspt.*, vrp.setorpajret_no_bukti, vrp.setorpajret_tgl_bayar, vrp.setorpajret_jlh_bayar
					FROM v_spt vspt
					LEFT JOIN v_rekapitulasi_penerimaan vrp
					ON vspt.spt_jenis_pajakretribusi = vrp.setorpajret_jenis_pajakretribusi AND vspt.spt_nomor = vrp.setorpajret_no_spt
					AND vspt.spt_periode = vrp.setorpajret_spt_periode AND vspt.spt_idwpwr = vrp.setorpajret_id_wp
					WHERE spt_idwpwr = $wp_id and 
					spt_jenis_pemungutan = 1 AND
					(
					(EXTRACT(MONTH FROM spt_periode_jual1) = 12 AND EXTRACT(YEAR FROM spt_periode_jual1) = $tahun_pajak_sebelumnya)
					OR
					(EXTRACT(MONTH FROM spt_periode_jual1) BETWEEN 1 AND 11 AND EXTRACT(YEAR FROM spt_periode_jual1) = $tahun_pajak)
					)
					ORDER BY spt_periode_jual1 ASC";
		} else {
			// official assesment
			$sql = "SELECT DISTINCT vspt.*, ppr.netapajrek_kohir, ppr.netapajrek_tgl, ppr.netapajrek_besaran, vrp.setorpajret_no_bukti, setorpajret_tgl_bayar, setorpajret_jlh_bayar
					FROM v_spt vspt
					JOIN penetapan_pajak_retribusi ppr ON vspt.spt_id = ppr.netapajrek_id_spt
					LEFT JOIN v_rekapitulasi_penerimaan vrp
					ON vspt.spt_jenis_pajakretribusi = vrp.setorpajret_jenis_pajakretribusi AND vspt.spt_nomor = vrp.setorpajret_no_spt
					AND vspt.spt_periode = vrp.setorpajret_spt_periode AND vspt.spt_idwpwr = vrp.setorpajret_id_wp
					WHERE spt_idwpwr = $wp_id and 
					spt_jenis_pemungutan = 2 AND
					(
					(EXTRACT(MONTH FROM spt_periode_jual1) = 12 AND EXTRACT(YEAR FROM spt_periode_jual1) = $tahun_pajak_sebelumnya)
					OR
					(EXTRACT(MONTH FROM spt_periode_jual1) BETWEEN 1 AND 11 AND EXTRACT(YEAR FROM spt_periode_jual1) = $tahun_pajak)
					)
					ORDER BY spt_periode_jual1 ASC";
		}
		
		//echo $sql;
		return $this->adodb->GetAll($sql);
	}
	
	/**
	 * get spt_detail
	 * @param unknown_type $spt
	 */
	function get_sptpd_detail($spt_id) {
		if (empty($spt_id) || $spt_id == null)
			return 0;
			
		$this->db->from('spt_detail');
		$this->db->where('spt_dt_id_spt', $spt_id);
		$this->db->order_by('spt_dt_id', "asc");
		
		$query = $this->db->get();
		return $query->result_array();
	}
}