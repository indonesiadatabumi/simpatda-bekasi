<?php 
/**
 * class Sspd_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Sspd_model extends CI_Model {
	/**
	 * get list sspd
	 */
	function get_list_sspd($form_id = "spt_nomor") {
		$nama_kec = $this->adodb->GetOne("SELECT camat_nama FROM kecamatan WHERE camat_kode='".$this->session->userdata('USER_SPT_CODE')."'");
		$spt_periode = $this->input->get('spt_periode');
		$spt_jenis_pajak = $this->input->get('spt_jenis_pajakretribusi');
		$ketspt_id = $this->input->get('ketspt_id');
		
		$tables = "v_penyetoran_sspd";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' spt_nomor ';
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
		
		$where = " WHERE spt_jenis_pajakretribusi=$spt_jenis_pajak AND spt_periode='$spt_periode' ";
		if ($ketspt_id != "") 
			$where .= " AND ketspt_id=$ketspt_id";
		
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			if ($spt_jenis_pajak=='4') {
				$where .= " AND wp_wr_camat = '$nama_kec'";
			}else {
				$where .= " AND camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
			}
		}
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT DISTINCT spt_pen_id, spt_nomor, spt_periode, tgl_jatuh_tempo, koderek, npwprd, wp_wr_nama, ketspt_id, ketspt_singkat, spt_pajak
				FROM $tables $where $sort $limit";
		
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count(DISTINCT spt_pen_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->spt_pen_id,
									$counter,
									"<a href=\"#\" onclick=\"isChosenSPT('$row->spt_nomor', '$row->ketspt_id', '$form_id');\">".$row->spt_nomor."</a>",
									$row->spt_periode,
									format_tgl($row->tgl_jatuh_tempo),
									$row->koderek,
									$row->npwprd,
									$row->wp_wr_nama,
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
	
	/**
	 * get sspd detail
	 */
	function get_sspd_detail($spt_periode, $spt_nomor, $jenis_ketetapan, $jenis_pajak) {
		$ketspt_id = $this->input->get_post('setorpajret_jenis_ketetapan');
		$tables = "v_penyetoran_sspd";
		
		$and_where = "";
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$and_where = " AND camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}
			
		$sql_cari = "SELECT *
					FROM $tables 
					WHERE spt_periode='$spt_periode' AND spt_nomor='$spt_nomor' 
						AND ketspt_id='$jenis_ketetapan' 
						AND spt_jenis_pajakretribusi='$jenis_pajak' $and_where 
					ORDER BY spt_periode_jual1 ASC";
		//echo $sql_cari;
		$ar_cari = $this->adodb->GetAll($sql_cari);
		return $ar_cari;
	}
	
	/**
	 * get sspd detail reklame
	 */
	function get_sspd_detail_reklame($spt_periode, $spt_nomor, $jenis_ketetapan, $jenis_pajak) {
		$nama_kec = $this->adodb->GetOne("SELECT camat_nama FROM kecamatan WHERE camat_kode='".$this->session->userdata('USER_SPT_CODE')."'");
		$and_where = "";
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			// $and_where = " AND camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
			$and_where = " AND wp_wr_camat = '$nama_kec'";
		}
		
		$sql_cari = "SELECT *
					FROM v_penyetoran_sspd s LEFT JOIN spt_reklame sr
					ON s.spt_dt_id = sr.sptrek_id_spt_dt
					WHERE spt_periode='$spt_periode' AND spt_nomor='$spt_nomor' 
						AND ketspt_id='$jenis_ketetapan' 
						AND spt_jenis_pajakretribusi='$jenis_pajak' $and_where 
					ORDER BY spt_periode_jual1 ASC";
		// echo $sql_cari;die;
		$ar_cari = $this->adodb->GetAll($sql_cari);
		return $ar_cari;
	}
	
	/**
	 * get distinct sspd
	 */
	function get_distinct_sspd($first_spt_number, $second_spt_number) {
		$nama_kec = $this->adodb->GetOne("SELECT camat_nama FROM kecamatan WHERE camat_kode='".$this->session->userdata('USER_SPT_CODE')."'");
		$and_where = "";
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			// $and_where = " AND camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
			$and_where = " AND wp_wr_camat = '$nama_kec'";
		}
		
		$sql = "SELECT DISTINCT spt_jenis_pajakretribusi, ketspt_id, spt_nomor, spt_periode, tgl_jatuh_tempo, spt_pajak
				FROM v_penyetoran_sspd
				WHERE spt_periode='".$this->input->get_post('spt_periode')."' AND spt_nomor BETWEEN $first_spt_number AND $second_spt_number 
					AND ketspt_id='".$this->input->get_post('setorpajret_jenis_ketetapan')."' 
					AND spt_jenis_pajakretribusi='".$this->input->get_post('spt_jenis_pajakretribusi')."' $and_where 
				ORDER BY spt_nomor ASC";
		
		$arr_data = $this->adodb->GetAll($sql);
		return $arr_data;
	}
}