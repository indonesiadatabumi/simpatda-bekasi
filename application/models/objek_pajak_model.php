<?php 
/**
 * class Objek_pajak_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121022
 */
class Objek_pajak_model extends CI_Model {
	/**
	 * get_ref_jenis_pajak_retribusi
	 */
	function get_ref_jenis_pajak_retribusi($selected = FALSE) {
		$result = array();
		$this->db->order_by('ref_jenparet_id', 'ASC');
		$query = $this->db->get('ref_jenis_pajak_retribusi');
		if ($selected) 
			$result['0'] = "-- Pilih Jenis Pajak --";
			
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$result[$row->ref_jenparet_id] = $row->ref_jenparet_ket;
			}
		}
		
		return $result;
	}
	
	/**
	 * function get jenis by operator
	 */
	function get_jenis_pajak_by_operator($selected = TRUE) {
		$result = array();
		$this->db->order_by('ref_jenparet_id', 'ASC');
		$query = $this->db->get('ref_jenis_pajak_retribusi');
		if ($selected && $this->session->userdata('USER_JABATAN') >= 10) 
			$result['0'] = "-- Pilih Jenis Pajak --";
			
		if ($query->num_rows() > 0) {
			//operator hotel
			foreach ($query->result() as $row) {
				if ($this->session->userdata('USER_JABATAN') < 10) {
					if ($row->ref_jenparet_id == $this->session->userdata('USER_JABATAN')) {
						$result[$row->ref_jenparet_id] = $row->ref_jenparet_ket;
					}
				} else {
					$result[$row->ref_jenparet_id] = $row->ref_jenparet_ket;
				}								
			}
		}
		
		return $result;
	}
	
	/**
	 * function get jenis by operator
	 */
	function get_pajak_self_assesment($selected = TRUE) {
		$result = array();
		$this->db->order_by('ref_jenparet_id', 'ASC');
		$query = $this->db->get_where('ref_jenis_pajak_retribusi', "ref_jenparet_id NOT IN(4, 8)");
		if ($selected && $this->session->userdata('USER_JABATAN') >= 10) 
			$result['0'] = "-- Pilih Jenis Pajak --";
			
		if ($query->num_rows() > 0) {
			//operator hotel
			foreach ($query->result() as $row) {
				if ($this->session->userdata('USER_JABATAN') < 10) {
					if ($row->ref_jenparet_id == $this->session->userdata('USER_JABATAN')) {
						$result[$row->ref_jenparet_id] = $row->ref_jenparet_ket;
					}
				} else {
					$result[$row->ref_jenparet_id] = $row->ref_jenparet_ket;
				}								
			}
		}
		
		return $result;
	}
}