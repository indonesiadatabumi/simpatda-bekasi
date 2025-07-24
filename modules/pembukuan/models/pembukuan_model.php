<?php 
/**
 * class Pembukuan
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121115
 */
class Pembukuan_model extends CI_Model {
	/**
	 * jenis pajak
	 */
	function jenis_pajak() {
		$arr_data = array();		
		$this->db->select('*');
		$this->db->from('ref_jenis_pajak_retribusi');
		$this->db->order_by('ref_jenparet_id');
		$query = $this->db->get();
		
		if ($query->num_rows())
		{
			foreach ($query->result() as $row)
			{
				$arr_data[$row->ref_jenparet_id] = $row->ref_jenparet_ket;
			}
		}

		return $arr_data;	
	}
	
	/**
	 * get pejabat daerah
	 */
	function get_pejabat_daerah()
	{
		$arr_data = array();		
		$this->db->select('*');
		$this->db->from('v_pejabat_daerah');
		$this->db->order_by('ref_japeda_nama');
		$query = $this->db->get();
		
		if ($query->num_rows())
		{
			foreach ($query->result() as $row)
			{
				$arr_data[$row->pejda_id] = $row->ref_japeda_nama." | ".$row->pejda_nama;
			}
		}

		return $arr_data;	
	}
	
	/**
	 * get keterangan spt
	 */
	function keterangan_spt($is_selected = TRUE)
	{
		$arr_data = array();		
		$this->db->select('*');
		$this->db->from('keterangan_spt');
		$this->db->order_by('ketspt_id');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			if ($is_selected)
				$arr_data[''] = "(silahkan pilih...)";
				
			foreach ($query->result() as $row)
			{
				$arr_data[$row->ketspt_id] = "[".$row->ketspt_kode."] ".$row->ketspt_ket;
			}
		}

		return $arr_data;	
	}
	
	/**
	 * get kecamatan
	 */
	function kecamatan()
	{
		$arr_data = array();		
		$this->db->select('*');
		$this->db->from('kecamatan');
		$this->db->order_by('camat_kode');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$arr_data[''] = "(silahkan pilih...)";
			foreach ($query->result() as $row)
			{
				$arr_data[$row->camat_id] = "[".$row->camat_kode."] ".$row->camat_nama;
			}
		}

		return $arr_data;		
	
	}
	
	/**
	 * get week range
	 * @param unknown_type $date
	 */
	function start_week_date($date) {
		//list($start_date, $end_date) = x_week_range('2013-04-04');
	    $ts = strtotime($date);
	    $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
	    return date('Y-m-d', $start);
	}
}