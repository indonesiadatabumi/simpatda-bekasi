<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Uptd model
 * @author	Daniel
 */

class Uptd_model extends CI_Model {
	/**
	 * get list kecamatan
	 */
	function get_list() {
		$tables = " ref_uptd ";
		$relations = "";

		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' uptd_id ';
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
	
		if (!empty($relations)) {
		$where = " WHERE $relations ";
		if ($query) $where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
		}
		else {if ($query) $where = " WHERE CAST($qtype AS TEXT) ~~* '%$query%' ";}
	
		$sql = "SELECT * FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count(uptd_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->uptd_id),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="uptd_id[]" value="'.$row->uptd_id.'" 
									onclick="isChecked('.$counter.','.$row->uptd_id.');" />',
								"<a href='#' onclick=\"editData('".$row->uptd_id."')\">".$row->uptd_nama."</a>",
								$row->uptd_alamat
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
	 * insert data uptd
	 */
	function insert() {
		$arr_insert = array(
					'uptd_nama' => $_POST['uptd_nama'],
					'uptd_alamat' => $_POST['uptd_alamat']
				);
	
		$this->db->insert('ref_uptd', $arr_insert);
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * update uptd
	 */
	function update() {
		$arr_update = array(
						'uptd_nama' => $_POST['uptd_nama'],
						'uptd_alamat' => $_POST['uptd_alamat']
					);
		$this->db->where('uptd_id', $_POST['uptd_id']);
		$this->db->update('ref_uptd', $arr_update);
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * delete ref_uptd
	 * @param unknown_type $id
	 */
	function delete($id) {
		$this->db->where('uptd_id', $id);
		$this->db->delete('ref_uptd');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}