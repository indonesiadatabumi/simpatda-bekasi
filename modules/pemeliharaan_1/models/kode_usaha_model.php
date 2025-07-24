<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Kode_usaha_model
 * @author	Daniel
 */

class Kode_usaha_model extends CI_Model {
	/**
	 * get list kode usaha
	 */
	function get_list() {
		$tables = " ref_kode_usaha ";
		$relations = "";

		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' ref_kodus_id ';
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
		$total = $this->adodb->GetOne("SELECT count(ref_kodus_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->ref_kodus_id),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="ref_kodus_id[]" value="'.$row->ref_kodus_id.'" 
									onclick="isChecked('.$counter.','.$row->ref_kodus_id.');" />',
								$row->ref_kodus_kode,
								"<a href='#' onclick=\"editKodeUsaha('".$row->ref_kodus_id."')\">".$row->ref_kodus_nama."</a>"
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
	 * insert data kode usaha
	 */
	function insert() {
		$sql = "SELECT * FROM ref_kode_usaha WHERE ref_kodus_kode = '".$_POST['ref_kodus_kode']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_insert = array(
						'ref_kodus_kode' => $_POST['ref_kodus_kode'],
						'ref_kodus_nama' => $_POST['ref_kodus_nama']
					);
		
			$this->db->insert('ref_kode_usaha', $arr_insert);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * update kode usaha
	 */
	function update() {
		$sql = "SELECT * FROM ref_kode_usaha WHERE ref_kodus_kode = '".$_POST['ref_kodus_kode']."' AND ref_kodus_id != '".$_POST['ref_kodus_id']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_update = array(
							'ref_kodus_kode' => $_POST['ref_kodus_kode'],
							'ref_kodus_nama' => $_POST['ref_kodus_nama']
						);
			$this->db->where('ref_kodus_id', $_POST['ref_kodus_id']);
			$this->db->update('ref_kode_usaha', $arr_update);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * delete kode usaha
	 * @param unknown_type $id
	 */
	function delete($id) {
		$this->db->where('ref_kodus_id', $id);
		$this->db->delete('ref_kode_usaha');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}