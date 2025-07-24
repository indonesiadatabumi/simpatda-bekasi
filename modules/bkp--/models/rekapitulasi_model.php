<?php 
/**
 * class Rekapitulasi_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Rekapitulasi_model extends CI_Model {
	/**
	 * get list rekapitulasi
	 */
	function get_list_header($tgl_penerimaan) {
		$sql = "SELECT DISTINCT skbh_id, skbh_tgl, skbh_no, skbh_nama, skbh_alamat, skbh_keterangan, skbh_jumlah, skbh_bukti_setoran, bukti_setoran
					FROM v_rekapitulasi_penerimaan
					WHERE skbh_tgl = '$tgl_penerimaan'
					ORDER BY skbh_id ASC";
		$query = $this->db->query($sql);
		 
		return $query;
	}
	
	/**
	 * get detail rincian
	 * @param unknown_type $skbh_id
	 */
	function get_detail($skbh_id) {
		$sql = "SELECT DISTINCT skbh_id, setorpajret_id, setorpajret_jlh_bayar
					FROM v_rekapitulasi_penerimaan
					WHERE skbh_id = '$skbh_id'
					ORDER BY setorpajret_id ASC";
		$query = $this->db->query($sql);
		 
		return $query;
	}
}