<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Backup_data_model
 * @author	Daniel
 * @version 20121209
 */

class Backup_data_model extends CI_Model
{
	/**
	 * get list data backup spt
	 */
	function get_list_data() {
		$fDate = $this->input->get('fDate');
		$tDate = $this->input->get('tDate');
		$kecamatan = $this->input->get('kecamatan');
		$jenis_pajak = $this->input->get('jenis_pajak');
		
		$tables = " spt, wp_wr, kecamatan, ref_jenis_pajak_retribusi ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' spt_nomor ';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";
	
		$where = " WHERE spt.spt_idwpwr = wp_wr.wp_wr_id AND kecamatan.camat_id::TEXT = wp_wr.wp_wr_kd_camat::TEXT 
					AND spt.spt_jenis_pajakretribusi = ref_jenis_pajak_retribusi.ref_jenparet_id
					AND spt.spt_tgl_entry BETWEEN '".format_tgl($fDate)."' AND '".format_tgl($tDate)."'
					AND camat_id IN ($kecamatan) AND spt_jenis_pajakretribusi IN ($jenis_pajak)";
	
		$sql = "SELECT * FROM $tables $where $sort $limit";
		
		$result = $this->adodb->Execute($sql);
		//echo $sql;
		$total = $this->adodb->GetOne("SELECT count('spt_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								$counter,
								$row->spt_nomor,
								$row->ref_jenparet_ket,
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
	
	/**
	 * get list data backup spt uptd
	 */
	function get_list_data_uptd() {
		$fDate = $this->input->get('fDate');
		$tDate = $this->input->get('tDate');
		$kecamatan = $this->input->get('kecamatan');
		$jenis_pajak = $this->input->get('jenis_pajak');
		
		$tables = " spt, ref_jenis_pajak_retribusi ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' spt_nomor ';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";
	
		$where = " WHERE spt.spt_jenis_pajakretribusi = ref_jenis_pajak_retribusi.ref_jenparet_id
					AND spt.spt_tgl_entry BETWEEN '".format_tgl($fDate)."' AND '".format_tgl($tDate)."'
					AND spt_jenis_pajakretribusi IN ($jenis_pajak)";
	
		$sql = "SELECT * FROM $tables $where $sort $limit";
		
		$result = $this->adodb->Execute($sql);
		//echo $sql;
		$total = $this->adodb->GetOne("SELECT count('spt_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								$counter,
								$row->spt_nomor,
								$row->ref_jenparet_ket,
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
	
	/**
	 * get data spt
	 */
	function get_spt($is_uptd = FALSE) {
		$fDate = $this->input->get('fDate');
		$tDate = $this->input->get('tDate');
		$kecamatan = $this->input->get('kecamatan');
		$jenis_pajak = $this->input->get('jenis_pajak');
		
		$sql = "SELECT spt.*, wp_wr.*
				FROM spt, wp_wr, kecamatan
				WHERE spt.spt_idwpwr = wp_wr.wp_wr_id AND kecamatan.camat_id::TEXT = wp_wr.wp_wr_kd_camat::TEXT 
					AND spt.spt_tgl_entry BETWEEN '".format_tgl($fDate)."' AND '".format_tgl($tDate)."'
					AND camat_id IN ($kecamatan) AND spt_jenis_pajakretribusi IN ($jenis_pajak) AND spt_jenis_pajakretribusi NOT IN (4, 8)";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		
		return $result;
	}
	
	/**
	 * function to get spt detail
	 */
	function get_spt_detail($is_uptd = FALSE) {
		$fDate = $this->input->get('fDate');
		$tDate = $this->input->get('tDate');
		$kecamatan = $this->input->get('kecamatan');
		$jenis_pajak = $this->input->get('jenis_pajak');
		
		$sql = "SELECT spt_detail.*
				FROM spt, spt_detail, wp_wr, kecamatan
				WHERE spt.spt_id = spt_detail.spt_dt_id_spt AND spt.spt_idwpwr = wp_wr.wp_wr_id AND kecamatan.camat_id::TEXT = wp_wr.wp_wr_kd_camat::TEXT 
					AND spt.spt_tgl_entry BETWEEN '".format_tgl($fDate)."' AND '".format_tgl($tDate)."'
					AND camat_id IN ($kecamatan) AND spt_jenis_pajakretribusi IN ($jenis_pajak) AND spt_jenis_pajakretribusi NOT IN (4, 8)";
		
		$result = $this->adodb->Execute($sql);
		
		return $result;
	}
	
	/**
	 * function get setoran
	 */
	function get_setoran() {
		$fDate = $this->input->get('from_penyetoran');
		$tDate = $this->input->get('to_penyetoran');
		$kecamatan = $this->input->get('kecamatan');
		
		$sql = "SELECT setoran_pajak_retribusi.*
				FROM spt, wp_wr, kecamatan, setoran_pajak_retribusi
				WHERE spt.spt_idwpwr = wp_wr.wp_wr_id AND kecamatan.camat_id::TEXT = wp_wr.wp_wr_kd_camat::TEXT 
					AND spt.spt_id=setoran_pajak_retribusi.setorpajret_id_penetapan
					AND setoran_pajak_retribusi.setorpajret_tgl_bayar BETWEEN '".format_tgl($fDate)."' AND '".format_tgl($tDate)."'
					AND camat_id IN ($kecamatan) AND spt_jenis_pajakretribusi NOT IN (4)";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		
		return $result;
		
	}
	
	/**
	 * function get setoran reklame
	 */
	function get_setoran_reklame() {
		$fDate = $this->input->get('from_penyetoran');
		$tDate = $this->input->get('to_penyetoran');
		
		$sql = "SELECT setoran_pajak_retribusi.*
				FROM spt, setoran_pajak_retribusi
				WHERE spt.spt_id=setoran_pajak_retribusi.setorpajret_id_penetapan
					AND setoran_pajak_retribusi.setorpajret_tgl_bayar BETWEEN '".format_tgl($fDate)."' AND '".format_tgl($tDate)."'
					AND spt_jenis_pajakretribusi=4";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		
		return $result;
		
	}
	
	/**
	 * get skpd 
	 */
	function get_spt_air_tanah() {
		$fDate = $this->input->get('fDate');
		$tDate = $this->input->get('tDate');
		$kecamatan = $this->input->get('kecamatan');
		
		$sql = "SELECT spt.*, wp_wr.*, penetapan_pajak_retribusi.*
				FROM spt, wp_wr, kecamatan, penetapan_pajak_retribusi
				WHERE spt.spt_idwpwr = wp_wr.wp_wr_id AND penetapan_pajak_retribusi.netapajrek_id_spt = spt.spt_id
					AND kecamatan.camat_id::TEXT = wp_wr.wp_wr_kd_camat::TEXT 
					AND spt.spt_tgl_entry BETWEEN '".format_tgl($fDate)."' AND '".format_tgl($tDate)."'
					AND camat_id IN ($kecamatan) AND spt_jenis_pajakretribusi='8'";
		//echo $sql;
		
		$result = $this->adodb->Execute($sql);
		
		return $result;
	}
	
	/**
	 * get spt_detail_reklame
	 */
	function get_spt_detail_air_tanah() {
		$fDate = $this->input->get('fDate');
		$tDate = $this->input->get('tDate');
		$kecamatan = $this->input->get('kecamatan');
		
		$sql = "SELECT spt_detail.*
				FROM spt, spt_detail, wp_wr, kecamatan
				WHERE spt.spt_idwpwr = wp_wr.wp_wr_id AND spt.spt_id = spt_detail.spt_dt_id_spt
					AND kecamatan.camat_id::TEXT = wp_wr.wp_wr_kd_camat::TEXT 
					AND spt.spt_tgl_entry BETWEEN '".format_tgl($fDate)."' AND '".format_tgl($tDate)."'
					AND camat_id IN ($kecamatan) AND spt_jenis_pajakretribusi='8'";	
		
		$result = $this->adodb->Execute($sql);
		
		return $result;
	}
	
	/**
	 * get spt_reklame
	 */
	function get_spt_reklame() {
		$fDate = $this->input->get('fDate');
		$tDate = $this->input->get('tDate');
		
		$sql = "SELECT spt.*, wp_wr_reklame.*, penetapan_pajak_retribusi.*
				FROM spt, wp_wr_reklame, penetapan_pajak_retribusi
				WHERE spt.spt_idwp_reklame = wp_wr_reklame.wp_rek_id
					AND penetapan_pajak_retribusi.netapajrek_id_spt = spt.spt_id
					AND spt.spt_tgl_entry BETWEEN '".format_tgl($fDate)."' AND '".format_tgl($tDate)."'
					AND spt_jenis_pajakretribusi='4'";
		//echo $sql;
		
		$result = $this->adodb->Execute($sql);
		
		return $result;
	}
	
	
	/**
	 * get spt_detail_reklame
	 */
	function get_spt_detail_reklame() {
		$fDate = $this->input->get('fDate');
		$tDate = $this->input->get('tDate');
		
		$sql = "SELECT spt_detail.*, spt_reklame.*
				FROM spt LEFT JOIN spt_detail ON spt.spt_id = spt_detail.spt_dt_id_spt
				LEFT JOIN spt_reklame ON spt_reklame.sptrek_id_spt_dt = spt_detail.spt_dt_id 
				WHERE spt.spt_tgl_entry BETWEEN '".format_tgl($fDate)."' AND '".format_tgl($tDate)."'
					AND spt_jenis_pajakretribusi='4'";	
		
		$result = $this->adodb->Execute($sql);
		
		return $result;
	}
	
	/**
	 * get data wp
	 */
	function get_wp() {
		$fDate = $this->input->get('fDate');
		$tDate = $this->input->get('tDate');
		$kecamatan = $this->input->get('kecamatan');
		
		$sql = "SELECT wp_wr.*
				FROM wp_wr, kecamatan
				WHERE wp_wr.wp_wr_kd_camat::TEXT=kecamatan.camat_id::TEXT
					AND wp_wr.wp_wr_tgl_kartu BETWEEN '".format_tgl($fDate)."' AND '".format_tgl($tDate)."'
					AND camat_id IN ($kecamatan)";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		
		return $result;
	}
}