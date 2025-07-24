<?php 
/**
 * class cetak_kartu_npwpd_model.php
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121015
 */
class Cetak_kartu_npwpd_model extends CI_Model {
	/**
	 * get list data from db
	 */
	function get_list() {
		$tables = " v_wp_wr ";
	
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
	
		$where = "";
		if (!empty($relations)) {			
			if ($query) 
				$where .= " WHERE CAST($qtype AS TEXT) ~~* '%$query%' ";
		}
		else {
			if ($query) $where = " WHERE CAST($qtype AS TEXT) ~~* '%$query%' ";
		}
	
	
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
									'<input type="radio" id="cb'.$counter.'" class="toggle" name="wp_wr_id[]" value="'.$row->wp_wr_id.'" 
										onclick="isChecked(this.checked,'.$row->wp_wr_nama.');" />',
									$row->wp_wr_no_form,
									strtoupper($row->npwprd),
									$row->wp_wr_no_kartu,
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
	
	/**
	 * get wp data
	 */
	function get_wp() {
		$wp_id = $this->input->get('wp_id');
		
		$query = $this->db->get_where('v_wp_wr', array('wp_wr_id' => $wp_id));
		return $query->row();
	}
	
	/**
	 * get kadis
	 */
	function get_kadis() {
		$where = array(
					'pejda_jabatan' => '32',
					'pejda_aktif' => 'TRUE'
				);
		
		$query = $this->db->get_where('v_pejabat_daerah', $where);
		return $query->row();
	}
}