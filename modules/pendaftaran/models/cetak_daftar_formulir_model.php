<?php 
/**
 * class Wp_badan_usaha_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121015
 */
class Cetak_daftar_formulir_model extends CI_Model {
	/**
	 * get list formulir
	 */
	function get_list_formulir($from_no_formulir, $to_no_formulir, $from_tgl_kirim, $to_tgl_kirim, $status) {		
		if (!empty($from_no_formulir) && !empty($to_no_formulir)) {
			$from_no_formulir = format_angka(8, $from_no_formulir);
			$to_no_formulir = format_angka(8, $to_no_formulir);
			$this->db->where("form_nomor between '$from_no_formulir' and '$to_no_formulir'");
		} elseif (!empty($from_no_formulir)) {
			$from_no_formulir = format_angka(8, $from_no_formulir);
			$this->db->where("form_nomor >= '$from_no_formulir'");
		} elseif (!empty($to_no_formulir)) {
			$to_no_formulir = format_angka(8, $to_no_formulir);
			$this->db->where("form_nomor <= '$to_no_formulir'");
		}
		
		if (!empty($from_tgl_kirim) && !empty($to_tgl_kirim)) {
			$this->db->where("form_tgl_kirim between '".format_tgl($from_tgl_kirim)."' and '".format_tgl($to_tgl_kirim)."'");
		} elseif (!empty($from_tgl_kirim)) {
			$this->db->where("form_tgl_kirim >= '".format_tgl($from_tgl_kirim)."'");
		} elseif (!empty($to_tgl_kirim)) {
			$this->db->where("form_tgl_kirim <= '".format_tgl($to_tgl_kirim)."'");
		}
		
		if (!empty($status)) {
			$this->db->where("form_status = '$status'");
		}
		
		$this->db->order_by('form_nomor', 'ASC');
		$this->db->from('v_formulir');		
		$query = $this->db->get();
		
		return $query;
	}
}