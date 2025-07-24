<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Pos_anggaran_model
 * @author	Daniel
 */

class Pos_anggaran_model extends CI_Model {
	/**
	 * get list pos anggaran
	 */
	function get_list() {
		$tables = " pos_anggaran ";
		$relations = "";

		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' posang_kode ';
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
		$total = $this->adodb->GetOne("SELECT count(posang_id) FROM $tables $where");
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->posang_id),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="posang_id[]" value="'.$row->posang_id.'" 
									onclick="isChecked('.$counter.','.$row->posang_id.');" />',
								$row->posang_kode,
								"<a href='#' onclick=\"editPosAnggaran('".$row->posang_id."')\">".$row->posang_ket."</a>"
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
	 * insert data pos anggaran
	 */
	function insert() {
		$sql = "SELECT * FROM pos_anggaran WHERE posang_kode = '".$_POST['posang_kode']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_insert = array(
						'posang_kode' => $_POST['posang_kode'],
						'posang_ket' => strtoupper($_POST['posang_ket'])
					);
		
			$this->db->insert('pos_anggaran', $arr_insert);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * update pos anggaran
	 */
	function update() {
		$sql = "SELECT * FROM pos_anggaran WHERE posang_kode = '".$_POST['posang_kode']."' AND posang_id != '".$_POST['posang_id']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_update = array(
							'posang_kode' => $_POST['posang_kode'],
							'posang_ket' => strtoupper($_POST['posang_ket'])
						);
			$this->db->where('posang_id', $_POST['posang_id']);
			$this->db->update('pos_anggaran', $arr_update);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * delete pos anggaran
	 * @param unknown_type $id
	 */
	function delete($id) {
		$this->db->where('posang_id', $id);
		$this->db->delete('pos_anggaran');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}