<?php 
/**
 * class Pembukuan
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121115
 */
class Pembukuan extends CI_Model {

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
	
	function list_dsp_ref_korek_gb()
	{
	
	}
}