<?php 
/**
 * class Master_wp_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Master_wp_model extends CI_Model {
	/**
	 * get list data pribadi model
	 */
	function get_list() {
		$tables = " v_wp_wr ";
		$relations = " wp_wr_status_aktif='t' ";
		
		if ($_GET['kodus_id'] != "0") {
			$relations .= " AND wp_wr_bidang_usaha = '".$_GET['kodus_id']."'";
		};
		
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$relations .= " AND camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}
	
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
									//$row->wp_wr_no_kartu,
									addslashes($row->wp_wr_nama),
									addslashes(preg_replace("/[\r|\n]/","",$row->wp_wr_almt)),
									$row->wp_wr_lurah,
									$row->wp_wr_camat,
									$row->wp_wr_kabupaten,
									addslashes($row->wp_wr_nama_milik),
									addslashes(preg_replace("/[\r|\n]/","",$row->wp_wr_almt_milik)),
									$row->wp_wr_lurah_milik,
									$row->wp_wr_camat_milik,
									$row->wp_wr_kabupaten_milik,
									format_tgl($row->wp_wr_tgl_terima_form),
									format_tgl($row->wp_wr_tgl_bts_kirim),
									format_tgl($row->wp_wr_tgl_form_kembali)
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
}