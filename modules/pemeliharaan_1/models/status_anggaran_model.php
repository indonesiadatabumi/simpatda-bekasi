<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Status_anggaran_model
 * @author	Daniel
 */
class Status_anggaran_model extends CI_Model {
	/**
	 * get list status anggaran
	 */
	function get_list() {
		$tables = " ref_status_tahun_anggaran ";
		$relations = "";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' ref_statang_ket ';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
	
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";
		
		$query = $_POST['query'];
		$qtype = $_POST['qtype'];
			
		$where = "";
		if ($query) 
			$where = " WHERE CAST($qtype AS TEXT) ~~* '%$query%' ";
	
		$sql = "SELECT * FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('ref_statang_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								$counter,
								'<input type="checkbox" id="cbsa'.$counter.'" class="toggle_status_anggaran" name="statang_id[]" value="'.$row->ref_statang_id.'" 
									onclick="isChecked('.$counter.','.$row->ref_statang_id.');" />',
								"<a id=\"sa_$counter\" href=\"#\" onclick=\"editStatusAnggaran('$row->ref_statang_id', '".addslashes($row->ref_statang_ket)."')\">".
									$row->ref_statang_ket."</a>"
							)
						);
				$counter++;
			}	
		}
		
		$result = array (
						"page"	=> $page,
						"total"	=> $total,
						"rows"	=> $list
					);
			
		echo json_encode($result);
	}
	
	/**
	 * insert status keterangan
	 * @param unknown_type $ref_statang_ket
	 */
	function insert($ref_statang_ket) {
		$arr_insert = array(
					'ref_statang_ket' => $ref_statang_ket
				);
		$this->db->insert('ref_status_tahun_anggaran', $arr_insert);
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * update status keterangan
	 * @param unknown_type $ref_statang_id
	 * @param unknown_type $ref_statang_ket
	 */
	function update($ref_statang_id, $ref_statang_ket) {
		$arr_update = array(
					'ref_statang_ket' => $ref_statang_ket
				);
		$this->db->where('ref_statang_id', $ref_statang_id);
		$this->db->update('ref_status_tahun_anggaran', $arr_update);
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * delete status keterangan
	 * @param unknown_type $ref_statang_id
	 */
	function delete($ref_statang_id) {
		$this->db->where('ref_statang_id', $ref_statang_id);
		$this->db->delete('ref_status_tahun_anggaran');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}