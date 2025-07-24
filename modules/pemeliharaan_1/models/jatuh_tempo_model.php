<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Jatuh_tempo_model
 * @author	Daniel
 */

class Jatuh_tempo_model extends CI_Model {
	/**
	 * update kecamatan
	 */
	function update() {
		$arr_update = array(
						'ref_jatem' => $_POST['ref_jatem'],
						'ref_jatem_batas_bayar_self' => $_POST['ref_jatem_batas_bayar_self'],
						'ref_jatem_batas_lapor_self' => $_POST['ref_jatem_batas_lapor_self']
					);
		$this->db->update('ref_jatuh_tempo', $arr_update);
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
}