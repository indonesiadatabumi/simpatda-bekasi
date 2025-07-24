<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Kelas_jalan_model
 * @author	Daniel
 */

class Kelas_jalan_model extends CI_Model {
	/**
	 * get list Kelas_jalan
	 */
	function get_list() {
		$tables = " ref_rek_klas_jalan ";
		$relations = "";

		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' ref_rkj_kode ';
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
		$total = $this->adodb->GetOne("SELECT count(ref_rkj_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->ref_rkj_id),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="ref_rkj_id[]" value="'.$row->ref_rkj_id.'" 
									onclick="isChecked('.$counter.','.$row->ref_rkj_id.');" />',
								$row->ref_rkj_kode,
								"<a href='#' onclick=\"editData('".$row->ref_rkj_id."')\">".$row->ref_rkj_nama."</a>"
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
		$sql = "SELECT * FROM ref_rek_klas_jalan WHERE ref_rkj_kode = '".$_POST['ref_rkj_kode']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_insert = array(
						'ref_rkj_kode' => $_POST['ref_rkj_kode'],
						'ref_rkj_nama' => $_POST['ref_rkj_nama']
					);
		
			$this->db->insert('ref_rek_klas_jalan', $arr_insert);
			
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
		$sql = "SELECT * FROM ref_rek_klas_jalan WHERE ref_rkj_kode = '".$_POST['ref_rkj_kode']."' AND ref_rkj_id != '".$_POST['ref_rkj_id']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_update = array(
						'ref_rkj_kode' => $_POST['ref_rkj_kode'],
						'ref_rkj_nama' => $_POST['ref_rkj_nama']
					);
			$this->db->where('ref_rkj_id', $_POST['ref_rkj_id']);
			$this->db->update('ref_rek_klas_jalan', $arr_update);
			
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
		$this->db->where('ref_rkj_id', $id);
		$this->db->delete('ref_rek_klas_jalan');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}