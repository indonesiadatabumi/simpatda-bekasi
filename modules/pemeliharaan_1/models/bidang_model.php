<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Bidang_model
 * @author	Daniel
 */

class Bidang_model extends CI_Model {
	/**
	 * get list bidang
	 */
	function get_list() {
		$tables = " v_bidang ";
		$relations = "";
		
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' bdg_id ';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		
		/* paging jgn dirubah */
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";
		
		/* search jgn dirubah */
		$query = $_POST['query'];
		$qtype = $_POST['qtype'];
	
		
		$where = "";
		if ($query) 
			$where = " WHERE CAST($qtype AS TEXT) ~~* '%$query%' ";
	
		$sql = "SELECT * FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('bdg_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								strtoupper($row->bdg_nama),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="bdg_id[]" value="'.$row->bdg_nama.'" 
									onclick="isChecked('.$counter.','.$row->bdg_nama.');" />',
								strtoupper($row->ref_urus_nama),
								$row->bdg_kode,
								'<a href="#" onclick="editData(cb'.$counter.')">'.strtoupper($row->bdg_nama).'</a>',
								strtoupper($row->fung_nama)
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
	 * insert
	 */
	function insert() {
		$arr_insert = array(
					'bdg_urusan' => $_POST['bdg_urusan'],
					'bdg_kode' => $_POST['bdg_kode'],
					'bdg_nama' => $_POST['bdg_nama']
				);
	
		$this->db->insert('bidang', $arr_insert);
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * update
	 */
	function update() {
		$arr_update = array(
					'bdg_urusan' => $_POST['bdg_urusan'],
					'bdg_kode' => $_POST['bdg_kode'],
					'bdg_nama' => $_POST['bdg_nama']
				);
		$this->db->where('bdg_id', $_POST['bdg_id']);
		$this->db->update('bidang', $arr_update);
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * delete
	 */
	function delete() {
		$this->db->where('bdg_id', $id);
		$this->db->delete('bidang');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}