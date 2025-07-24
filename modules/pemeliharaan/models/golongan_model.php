<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Golongan_model
 * @author	Daniel
 * @version 20130128
 */

class Golongan_model extends CI_Model {
	/**
	 * get list pejabat
	 */
	function get_list() {
		/* tables and relations sesuaikan*/
		$tables = " ref_gol_ruang ";
		$relations = "";
	
		/* sorting sesuaikan*/
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' ref_goru_id ';
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
		$total = $this->adodb->GetOne("SELECT count('ref_goru_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->ref_goru_id),
								$counter,
								'<input type="checkbox" id="cbg'.$counter.'" class="toggle_golongan" name="goru_id[]" value="'.$row->ref_goru_id.'" 
									onclick="isChecked('.$counter.','.$row->ref_goru_id.');" />',
								"<a id=\"gol_$counter\" href=\"#\" onclick=\"editGolongan('$row->ref_goru_id', '".addslashes($row->ref_goru_ket)."')\">".
									$row->ref_goru_ket."</a>"
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
						'ref_goru_ket' => $this->input->post('ref_goru_ket')
					);
		$this->db->insert('ref_gol_ruang', $arr_insert);
		
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
						'ref_goru_ket' => $this->input->post('ref_goru_ket')
					);
		$this->db->where('ref_goru_id', $this->input->post('ref_goru_id'));
		$this->db->update('ref_gol_ruang', $arr_update);
		
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
		$this->db->where('ref_goru_id', $id);
		$this->db->delete('ref_gol_ruang');
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}