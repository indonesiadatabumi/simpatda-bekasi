<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Keterangan_spt_model
 * @author	Daniel
 */

class Keterangan_spt_model extends CI_Model {
	/**
	 * get list keterangan_spt
	 */
	function get_list() {
		$tables = " keterangan_spt ";
		$relations = "";

		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' ketspt_id ';
		if (!$sortorder) $sortorder = 'asc';
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
		$total = $this->adodb->GetOne("SELECT count(ketspt_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->ketspt_id),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="ketspt_id[]" value="'.$row->ketspt_id.'" 
									onclick="isChecked('.$counter.','.$row->ketspt_id.');" />',
								$row->ketspt_kode,
								"<a href='#' onclick=\"editKeteranganSPT('".$row->ketspt_id."')\">".$row->ketspt_ket."</a>",
								$row->ketspt_singkat
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
	 * insert data keterangan_spt
	 */
	function insert() {
		$sql = "SELECT * FROM keterangan_spt WHERE ketspt_kode = '".$_POST['ketspt_kode']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_insert = array(
						'ketspt_kode' => strtoupper($_POST['ketspt_kode']),
						'ketspt_ket' => $_POST['ketspt_ket'],
						'ketspt_singkat' => $_POST['ketspt_singkat']
					);
		
			$this->db->insert('keterangan_spt', $arr_insert);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * update keterangan_spt
	 */
	function update() {
		$sql = "SELECT * FROM keterangan_spt WHERE ketspt_kode = '".$_POST['ketspt_kode']."' AND ketspt_id != '".$_POST['ketspt_id']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_update = array(
							'ketspt_kode' => strtoupper($_POST['ketspt_kode']),
							'ketspt_ket' => $_POST['ketspt_ket'],
							'ketspt_singkat' => $_POST['ketspt_singkat']
						);
			$this->db->where('ketspt_id', $_POST['ketspt_id']);
			$this->db->update('keterangan_spt', $arr_update);
			
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
		$this->db->where('ketspt_id', $id);
		$this->db->delete('keterangan_spt');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}