<?php 
/**
 * class Bpps_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Bpps_model extends CI_Model {
	/**
	 * get list bpps
	 */
	function get_list() {
		if ($this->input->get('via_bayar') != "") {
			$this->db->where('setorpajret_via_bayar', $this->input->get('via_bayar'));
		}
		
		if ($this->input->get('koderek') != "") {
			$this->db->where('koderek', $this->input->get('koderek'));
		}
		
		if ($this->input->get('fDate') != "" && $this->input->get('tDate') != "") {
			$this->db->where("setorpajret_tgl_bayar BETWEEN '".format_tgl($this->input->get('fDate'))."' AND '".format_tgl($this->input->get('tDate'))."'");
		}
		
		$this->db->from('v_rekapitulasi_penerimaan_detail');
		$this->db->order_by('setorpajret_dibuat_tanggal', 'ASC');
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/**
	 * get data laporan penerimaan
	 */
	function get_laporan_penerimaan() {
		if ($this->input->get('fDate') != "" && $this->input->get('tDate') != "") {
			$this->db->where("setorpajret_tgl_bayar BETWEEN '".format_tgl($this->input->get('fDate'))."' AND '".format_tgl($this->input->get('tDate'))."'");
		}
		
		if ($_GET['jenis_pajak'] != "" && $_GET['jenis_pajak'] != "0") {
			$this->db->where("setorpajret_jenis_pajakretribusi = '".$_GET['jenis_pajak']."'");
		}
		
		if ($_GET['camat_id'] != "" && $_GET['camat_id'] != "0") {
			$this->db->where("wp_wr_kd_camat = '".$_GET['camat_id']."'");
		}
		
		$this->db->from('v_rekapitulasi_penerimaan_detail');
		$this->db->order_by('skbh_tgl ASC, skbh_no ASC');
		$query = $this->db->get();
		
		return $query->result();
	}
}