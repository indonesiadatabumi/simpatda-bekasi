<?php 
/**
 * class Pembukuan
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121115
 */
class Penagihan extends CI_Model {

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
	
	function keterangan_spt()
	{
		$arr_data = array();		
		$this->db->select('*');
		$this->db->from('keterangan_spt');
		$this->db->order_by('ketspt_id');
		$query = $this->db->get();
		
		if ($query->num_rows())
		{
			foreach ($query->result() as $row)
			{
				$arr_data[$row->ketspt_id] = "[".$row->ketspt_kode."] ".$row->ketspt_ket;
			}
		}

		return $arr_data;	
	}
	
	function kecamatan()
	{
		$arr_data = array();		
		$this->db->select('*');
		$this->db->from('kecamatan');
		$this->db->order_by('camat_id');
		$query = $this->db->get();
		
		if ($query->num_rows())
		{
			foreach ($query->result() as $row)
			{
				$arr_data[$row->camat_id] = "[".$row->camat_kode."] ".$row->camat_nama;
			}
		}

		return $arr_data;		
	
	}
}