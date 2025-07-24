<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class History_log_model
 * @author	Daniel
 */

class History_log_model extends CI_Model {
	/**
	 * get list kecamatan
	 */
	function get_list() {
		$tables = " history_log a LEFT JOIN operator b ON a.hislog_opr_user=b.opr_user ";
		$relations = "";

		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' hislog_time ';
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
	
		$sql = "SELECT a.*, b.opr_nama FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count(hislog_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->hislog_id),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="hislog_id[]" value="'.$row->hislog_id.'" 
									onclick="isChecked('.$counter.','.$row->hislog_id.');" />',
								date('d-m-Y H:i:s', strtotime($row->hislog_time)),
								$row->hislog_opr_user,
								$row->opr_nama,								
								$row->hislog_ip_address,
								$row->hislog_module,
								$row->hislog_action,
								$row->hislog_description																
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
	 * delete keterangan_spt
	 * @param unknown_type $id
	 */
	function delete($id) {
		$this->db->where('hislog_id', $id);
		$this->db->delete('history_log');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}