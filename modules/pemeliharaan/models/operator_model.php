<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Operator_model
 * @author	Daniel
 */

class Operator_model extends CI_Model {
	/**
	 * get list kecamatan
	 */
	function get_list() {
		$tables = " v_operator ";
		$relations = "";

		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' opr_kode ';
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
		$total = $this->adodb->GetOne("SELECT count(opr_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								$row->opr_id,
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="opr_id[]" value="'.$row->opr_id.'" 
									onclick="isChecked('.$counter.','.$row->opr_id.');" />',
								$row->opr_kode,
								$row->opr_user,
								"<a href='#' onclick=\"editData('".$row->opr_id."')\">".$row->opr_nama."</a>",
								$row->opr_nip,
								$row->ref_jab_nama,
								$row->status_aktif,
								$row->status_admin,
								$row->aktif_login,
								$row->opr_last_login
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
	 * insert data operator
	 */
	function insert() {
		$sql = "SELECT * FROM operator WHERE opr_user = '".$_POST['opr_user']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_insert = array(
						'opr_user' => $_POST['opr_user'],
						'opr_nama' => $_POST['opr_nama'],
						'opr_passwd' => md5($_POST['opr_user']),
						'opr_status' => $_POST['opr_status'],
						'opr_admin' => $_POST['opr_admin'],
						'opr_kode' => $_POST['opr_kode'],
						'opr_status_login' => $_POST['opr_status_login'],
						'opr_nip' => $_POST['opr_nip'],
						'opr_jabatan' => $_POST['opr_jabatan'],
						'opr_admin' => $_POST['opr_admin']
					);
		
			$this->db->insert('operator', $arr_insert);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * update operator
	 */
	function update() {
		$sql = "SELECT * FROM operator WHERE opr_user = '".$_POST['opr_user']."' AND opr_id != '".$_POST['opr_id']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_update = array(
							'opr_user' => $_POST['opr_user'],
							'opr_nama' => $_POST['opr_nama'],
							'opr_passwd' => $_POST['opr_passwd'],
							'opr_status' => $_POST['opr_status'],
							'opr_admin' => $_POST['opr_admin'],
							'opr_kode' => $_POST['opr_kode'],
							'opr_status_login' => $_POST['opr_status_login'],
							'opr_nip' => $_POST['opr_nip'],
							'opr_jabatan' => $_POST['opr_jabatan'],
							'opr_admin' => $_POST['opr_admin']
						);
			$this->db->where('opr_id', $_POST['opr_id']);
			$this->db->update('operator', $arr_update);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * delete operator
	 * @param unknown_type $id
	 */
	function delete($id) {
		$this->db->where('opr_id', $id);
		$this->db->delete('operator');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}