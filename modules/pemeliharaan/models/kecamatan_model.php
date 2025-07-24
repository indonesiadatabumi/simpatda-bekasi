<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Kecamatan_model
 * @author	Daniel
 */

class Kecamatan_model extends CI_Model {
	/**
	 * get list kecamatan
	 */
	function get_list() {
		$tables = " kecamatan ";
		$relations = "";

		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' camat_id ';
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
		$total = $this->adodb->GetOne("SELECT count(camat_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->camat_id),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="camat_id[]" value="'.$row->camat_id.'" 
									onclick="isChecked('.$counter.','.$row->camat_id.');" />',
								$row->camat_kode,
								"<a href='#' onclick=\"editKecamatan('".$row->camat_id."')\">".$row->camat_nama."</a>"
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
	 * insert data kecamatan
	 */
	function insert() {
		$sql = "SELECT * FROM kecamatan WHERE camat_kode = '".$_POST['camat_kode']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_insert = array(
						'camat_kode' => $_POST['camat_kode'],
						'camat_nama' => strtoupper($_POST['camat_nama'])
					);
		
			$this->db->insert('kecamatan', $arr_insert);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * update kecamatan
	 */
	function update() {
		$sql = "SELECT * FROM kecamatan WHERE camat_kode = '".$_POST['camat_kode']."' AND camat_id != '".$_POST['camat_id']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_update = array(
							'camat_kode' => $_POST['camat_kode'],
							'camat_nama' => strtoupper($_POST['camat_nama'])
						);
			$this->db->where('camat_id', $_POST['camat_id']);
			$this->db->update('kecamatan', $arr_update);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * delete keterangan_spt
	 * @param unknown_type $id
	 */
	function delete($id) {
		$this->db->where('camat_id', $id);
		$this->db->delete('kecamatan');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}