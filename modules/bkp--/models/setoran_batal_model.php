<?php 
/**
 * class Setoran_batal_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Setoran_batal_model extends CI_Model {
	/**
	 * get list setoran batal
	 */
	function get_list() {
		$tables = " v_setoran_batal ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' setorpajret_deleted_time ';
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
	
		$where = " WHERE setorpajret_id IS NOT NULL ";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT *
				FROM $tables $where $sort $limit";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('setorpajret_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$counter,
									date("d-m-Y H:i:s", strtotime($row->setorpajret_deleted_time)),
									$row->setorpajret_deleted_by,
									$row->ref_jenparet_ket,
									$row->setorpajret_spt_periode,
									$row->setorpajret_no_spt,
									$row->ketspt_singkat,
									format_tgl($row->setorpajret_tgl_bayar),									
									format_currency($row->setorpajret_jlh_bayar),									
									$row->npwprd,
									$row->wp_wr_nama
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
	 * insert setoran batal
	 * @param unknown_type $row
	 */
	function insert_setoran_batal($arr_setoran) {
		if (!is_array($arr_setoran))
			return ;
			
		$arr_deleted = array('setorpajret_deleted_time' => 'NOW()', 'setorpajret_deleted_by' => $this->session->userdata('USER_NAME'));
		$arr_batal = array_merge($arr_setoran, $arr_deleted);
		
		$this->db->insert('setoran_pajak_retribusi_batal', $arr_batal);
	}
	
	/**
	 * insert pembatalan setoran
	 */
	function check_setoran($jenis_pajak, $periode, $nomor, $jenis_ketetapan) {
		$arr_where = array(
					'setorpajret_jenis_pajakretribusi' => $jenis_pajak,
					'setorpajret_spt_periode' => $periode,
					'setorpajret_no_spt' => $nomor,
					'setorpajret_jenis_ketetapan' => $jenis_ketetapan
				);
		
		$this->db->where($arr_where);
		$this->db->from('setoran_pajak_retribusi');		
		$query = $this->db->get();

		return $query;
	}
	
	/**
	 * check into STS is validate or not
	 */
	function check_setoran_bank($setoran_id) {
		$sql = "SELECT skbh_id, skbh_validasi, skbd_id
					FROM setoran_ke_bank_header skbh JOIN setoran_ke_bank_detail skbd
					ON skbh.skbh_id = skbd.skbd_id_header
					WHERE skbd.skbd_id_setoran_pajak = '$setoran_id'";
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	/**
	 * delete setoran_pajak
	 * @param unknown_type $setoran_id
	 */
	function delete_setoran($setoran_id) {
		$this->db->where('setorpajret_dt_id_setoran', $setoran_id);
		$this->db->delete('setoran_pajak_retribusi_detail');
		
		$this->db->where('setorpajret_id', $setoran_id);
		$query = $this->db->delete('setoran_pajak_retribusi');
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * delete setoran ke bank header
	 * @param unknown_type $skbh_id
	 */
	function delete_setoran_bank_header($skbh_id) {
		$this->db->where('skbh_id', $skbh_id);
		$query = $this->db->delete('setoran_ke_bank_header');
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * delete setoran ke bank detail
	 * @param unknown_type $skbd_id
	 */
	function delete_setoran_bank_detail($skbd_id) {
		$this->db->where('skbd_id', $skbd_id);
		$query = $this->db->delete('setoran_ke_bank_detail');
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * delete detail
	 * @param unknown_type $skbd_id
	 */
	function delete_setoran_bank_detail_by_setoran_id($setoran_id) {
		$this->db->where('skbd_id_setoran_pajak', $setoran_id);
		$query = $this->db->delete('setoran_ke_bank_detail');
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
}