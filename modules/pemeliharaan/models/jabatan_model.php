<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Jabatan_model
 * @author	Daniel
 * @version 20130128
 */

class Jabatan_model extends CI_Model {
	/**
	 * get list pejabat
	 */
	function get_list() {
		/* tables and relations sesuaikan*/
		$tables = " ref_jabatan_pejabat_daerah ";
		$relations = "";
	
		/* sorting sesuaikan*/
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' ref_japeda_id ';
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
		$total = $this->adodb->GetOne("SELECT count('ref_japeda_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->ref_japeda_id),
								$counter,
								'<input type="checkbox" id="cbj'.$counter.'" class="toggle_jabatan" name="pejda_id[]" value="'.$row->ref_japeda_id.'" 
									onclick="isChecked('.$counter.','.$row->ref_japeda_id.');" />',
								"<a id=\"jbt_$counter\" href=\"#\" onclick=\"editJabatan('$row->ref_japeda_id', '".addslashes($row->ref_japeda_nama)."')\">".
									$row->ref_japeda_nama."</a>"
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
	 * insert data into db
	 */
	function insert() {
		$arr_insert = array(
						'ref_japeda_nama' => strtoupper($this->input->post('ref_japeda_nama'))
					);
		$this->db->insert('ref_jabatan_pejabat_daerah', $arr_insert);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * update data into db
	 */
	function update() {
		$arr_update = array(
						'ref_japeda_nama' => strtoupper($this->input->post('ref_japeda_nama'))
					);
		$this->db->where('ref_japeda_id', $this->input->post('ref_japeda_id'));
		$this->db->update('ref_jabatan_pejabat_daerah', $arr_update);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * delete function
	 */
	function delete($id) {
		$this->db->where('ref_japeda_id', $id);
		$this->db->delete('ref_jabatan_pejabat_daerah');
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}