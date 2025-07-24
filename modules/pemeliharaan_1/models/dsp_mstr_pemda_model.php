<?php 
/**
 * @author Angga Pratama
 */
class Dsp_mstr_pemda_model extends CI_Model 
{
	function get_content()
	{
		$this->db->select('*');
		$query = $this->db->get('data_pemerintah_daerah');
		return $query;
	}

}