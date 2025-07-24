<?php 
/**
 * class Tunggakan_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Tunggakan_model extends CI_Model {
/**
	 * get list stpd
	 */
	function get_list() {
		$tables = " v_daftar_tunggakan ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' spt_pen_id ';
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
	
		$where = " WHERE spt_pen_id IS NOT NULL";
		
		if ($_GET['periode'] != "") 
			$where .= " AND spt_periode=".$_GET['periode'];
			
		if ($_GET['jenis_pajak'] != "0" && $_GET['jenis_pajak'] != "") 
			$where .= " AND spt_jenis_pajakretribusi='".$_GET['jenis_pajak']."'";
		
		if ($_GET['camat_id'] != "0" && $_GET['camat_id'] != "") 
			$where .= " AND wp_wr_kd_camat='".$_GET['camat_id']."'";
			
		if ($_GET['fDate'] != "" && $_GET['tDate'] != "")
			$where .= " AND tgl_jatuh_tempo BETWEEN '".format_tgl($_GET['fDate'])."' AND '".format_tgl($_GET['tDate'])."'";
		elseif ($_GET['fDate'] != "")
			$where .= " AND tgl_jatuh_tempo >= '".format_tgl($_GET['fDate'])."'";
		elseif ($_GET['tDate'] != "") 
			$where .= " AND tgl_jatuh_tempo <= '".format_tgl($_GET['tDate'])."'";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
	
		$sql = "SELECT DISTINCT spt_pen_id, ref_jenparet_ket, spt_nomor, spt_periode, spt_periode_jual1, tgl_jatuh_tempo, koderek, npwprd, wp_wr_nama, ketspt_id, ketspt_singkat, spt_pajak
				FROM $tables $where $sort $limit";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count(DISTINCT spt_pen_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$arr_masa_pajak = explode('-', $row->spt_periode_jual1);
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->spt_pen_id,
									$counter,
									$row->wp_wr_nama,
									$row->npwprd,									
									$row->ref_jenparet_ket,
									$row->spt_periode,
									$row->spt_nomor,
									getNamaBulan($arr_masa_pajak[1])." ".$arr_masa_pajak[0],					
									format_tgl($row->tgl_jatuh_tempo),
									$row->koderek,									
									$row->ketspt_id,
									$row->ketspt_singkat,
									format_currency($row->spt_pajak)
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
	
	
	function get_daftar_tunggakan() {
		$where = " WHERE spt_pen_id IS NOT NULL";
		
		if ($_GET['periode'] != "") 
			$where .= " AND spt_periode=".$_GET['periode'];
			
		if ($_GET['jenis_pajak'] != "0" && $_GET['jenis_pajak'] != "") 
			$where .= " AND spt_jenis_pajakretribusi='".$_GET['jenis_pajak']."'";
		
		if ($_GET['camat_id'] != "0" && $_GET['camat_id'] != "") 
			$where .= " AND wp_wr_kd_camat='".$_GET['camat_id']."'";
			
		if ($_GET['fDate'] != "" && $_GET['tDate'] != "")
			$where .= " AND tgl_jatuh_tempo BETWEEN '".format_tgl($_GET['fDate'])."' AND '".format_tgl($_GET['tDate'])."'";
		elseif ($_GET['fDate'] != "")
			$where .= " AND tgl_jatuh_tempo >= '".format_tgl($_GET['fDate'])."'";
		elseif ($_GET['tDate'] != "") 
			$where .= " AND tgl_jatuh_tempo <= '".format_tgl($_GET['tDate'])."'";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
	
		$sql = "SELECT DISTINCT spt_pen_id, ref_jenparet_ket, spt_nomor, spt_periode, spt_periode_jual1, tgl_jatuh_tempo, koderek, npwprd, wp_wr_nama, ketspt_id, ketspt_singkat, spt_pajak
				FROM v_daftar_tunggakan $where";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		return $result;
	}
}