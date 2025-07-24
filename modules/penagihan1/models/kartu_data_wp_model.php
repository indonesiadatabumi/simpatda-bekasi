<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * class Kartu_data_wp_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Kartu_data_wp_model extends CI_Model {
	/**
	 * get list wp
	 */
	function get_list_wp() {
		$tables = " v_wp_wr ";
		$relations = " wp_wr_status_aktif='t' ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' wp_wr_id ';
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
		$total = $this->adodb->GetOne("SELECT count('wp_wr_id') FROM $tables $where");
			
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			$index = 0;
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->wp_wr_id,
									$counter,
									$row->no_reg,
									$row->npwprd,
									addslashes($row->wp_wr_nama),
									addslashes(preg_replace("/[\r|\n]/","",$row->wp_wr_almt)),
									$row->wp_wr_lurah,
									$row->wp_wr_camat,
									$row->wp_wr_kabupaten,
									addslashes($row->wp_wr_nama_milik),
									addslashes(preg_replace("/[\r|\n]/","",$row->wp_wr_almt_milik)),
									$row->wp_wr_lurah_milik,
									$row->wp_wr_camat_milik,
									$row->wp_wr_kabupaten_milik
								)
							);
				$counter++;
				$index++;
			}
		}
	
		$result = array (
						"page"	=> $page,
						"total"	=> $total,
						"rows"	=> $list
					);
			
		echo json_encode($result);
	}
	
	
	function get_detail_wp($wp_id) {
		$sql = "SELECT * 
				FROM v_wp_wr
				WHERE wp_wr_id='$wp_id'";
		$data = $this->adodb->GetRow($sql);
		return $data;
	}
	
	/**
	 * get data spt
	 */
	function get_data_spt($wp_id, $periode) {
		$sql = "SELECT spt_periode_jual1, spt_pajak
				FROM v_spt
				WHERE spt_idwpwr=$wp_id AND spt_periode=$periode AND spt_jenis_pajakretribusi != 4
				ORDER BY spt_periode_jual1 ASC, spt_tgl_entry ASC";
		$query = $this->db->query($sql);
		
		return $query;
	}
}