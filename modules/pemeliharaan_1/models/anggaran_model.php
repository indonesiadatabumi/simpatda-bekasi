<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Anggaran_model
 * @author	Daniel
 */

class Anggaran_model extends CI_Model {
	/**
	 * get list pejabat
	 */
	function get_list_anggaran() {
		$tables = " v_thn_anggaran ";
		$relations = "";
	
		/* sorting sesuaikan*/
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' tahang_thn1 ';
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
		$total = $this->adodb->GetOne("SELECT count(tahang_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->tahang_thn1),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="tahang_id[]" value="'.$row->tahang_id.'" 
									onclick="isChecked('.$counter.','.$row->tahang_id.');" />',
								"<a href=\"#\" onclick=\"openTahunAnggaran('Tahun Anggaran ".$row->tahang_thn1."','".$row->tahang_id."')\">".addslashes(strtoupper($row->tahang_thn1))."</a>",
								$row->ref_statang_ket,
								"<a href='#' onclick=\"openTargetAnggaran('Target Anggaran Tahun ".$row->tahang_thn1."','".$row->tahang_id."')\">TARGET ANGGARAN</a>",
								"<a href='#' onclick=\"cetakTargetAnggaran('Target Anggaran Tahun ".$row->tahang_thn1."','".$row->tahang_id."')\">CETAK</a>"
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
	 * insert tahun anggaran
	 */
	function insert_tahun_anggaran() {
		$sql = "SELECT * FROM tahun_anggaran WHERE tahang_thn1 = '".$_POST['tahang_thn1']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_insert = array(
						'tahang_thn1' => $_POST['tahang_thn1'],
						'tahang_thn2' => $_POST['tahang_thn1'],
						'tahang_status' => $_POST['tahang_status']
					);
		
			$this->db->insert('tahun_anggaran', $arr_insert);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * update tahun anggaran
	 */
	function update_tahun_anggaran() {
		$arr_update = array(
						'tahang_thn1' => $_POST['tahang_thn1'],
						'tahang_thn2' => $_POST['tahang_thn1'],
						'tahang_status' => $_POST['tahang_status']
					);
					
		$this->db->where('tahang_id', $_POST['tahang_id']);
		$this->db->update('tahun_anggaran', $arr_update);
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * delete tahun anggaran
	 * @param unknown_type $id
	 */
	function delete_tahun_anggaran($id) {
		$this->db->where('tahang_id', $id);
		$this->db->delete('tahun_anggaran');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}