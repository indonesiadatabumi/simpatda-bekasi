<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Kecamatan_model
 * @author	Daniel
 */

class Kelurahan_model extends CI_Model {
	/**
	 * get list kecamatan
	 */
	function get_list() {
		$tables = " kelurahan,kecamatan ";
		$relations = " kelurahan.lurah_kecamatan=kecamatan.camat_id ";

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
	
		$sql = "SELECT kelurahan.*,kecamatan.camat_kode,kecamatan.camat_nama FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count(lurah_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->lurah_id),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="lurah_id[]" value="'.$row->lurah_id.'" 
									onclick="isChecked('.$counter.','.$row->lurah_id.');" />',
								$row->camat_kode,
								$row->lurah_kode,
								"<a href='#' onclick=\"editKelurahan('".$row->lurah_id."')\">".$row->lurah_nama."</a>",
								$row->camat_nama
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
		$sql = "SELECT * FROM kelurahan WHERE lurah_kode = '".$_POST['lurah_kode']."' AND lurah_kecamatan = '".$_POST['lurah_kecamatan']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_insert = array(
						'lurah_kecamatan' => $_POST['lurah_kecamatan'],
						'lurah_kode' => $_POST['lurah_kode'],
						'lurah_nama' => strtoupper($_POST['lurah_nama'])
					);
		
			$this->db->insert('kelurahan', $arr_insert);
			
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
		$sql = "SELECT * FROM kelurahan WHERE lurah_kode = '".$_POST['lurah_kode']."' AND lurah_kecamatan = '".$_POST['lurah_kecamatan']."' AND lurah_id != '".$_POST['lurah_id']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_update = array(
							'lurah_kecamatan' => $_POST['lurah_kecamatan'],
							'lurah_kode' => $_POST['lurah_kode'],
							'lurah_nama' => strtoupper($_POST['lurah_nama'])
						);
			$this->db->where('lurah_id', $_POST['lurah_id']);
			$this->db->update('kelurahan', $arr_update);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * delete tahun anggaran
	 * @param unknown_type $id
	 */
	function delete($id) {
		$this->db->where('lurah_id', $id);
		$this->db->delete('kelurahan');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}