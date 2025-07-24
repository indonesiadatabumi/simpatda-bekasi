<?php 
/**
 * class Nota_perhitungan_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Nota_perhitungan_model extends CI_Model {
	/**
	 * get spt nota
	 */
	function get_spt() {
		$tables = " v_nota_perhitungan_list ";
	
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
		
		$where = " WHERE netapajrek_id IS NOT NULL AND spt_jenis_pajakretribusi='".$this->input->get('spt_jenis_pajakretribusi')."'";		
		
		$jenis_ketetapan = $this->input->get('spt_jenis_ketetapan');
		$spt_periode = $this->input->get('spt_periode');
		
		$where .= " AND netapajrek_jenis_ketetapan='$jenis_ketetapan' ";
			
		if ($spt_periode != "") {
			$where .= " AND spt_periode='$spt_periode' ";
		}
		
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$where .= " AND spt_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT DISTINCT netapajrek_id, spt_id,netapajrek_tgl, netapajrek_kohir, npwprd,spt_periode, netapajrek_tgl_jatuh_tempo, korek
				FROM $tables $where $sort $limit";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('netapajrek_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->netapajrek_id,
									$counter,
									"<a href=\"#\" onclick=\"isChosenSPT('$row->netapajrek_kohir');\">".$row->netapajrek_kohir."</a>",
									$row->npwprd,
									$row->spt_periode,
									format_tgl($row->netapajrek_tgl),
									format_tgl($row->netapajrek_tgl_jatuh_tempo),
									$row->korek
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
	 * get nota perhitungan
	 */
	function call_npwpd_tetap() {
		$data = array();
		
		$jenis_ketetapan = $this->input->get('spt_jenis_ketetapan');
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$tahun = $this->input->get('spt_periode');
		$spt_nomor1 = $this->input->get('spt_nomor1');
		$spt_nomor2 = $this->input->get('spt_nomor2');
		
		$sql_cari = "SELECT DISTINCT netapajrek_id, spt_id,netapajrek_tgl, netapajrek_kohir
						FROM v_nota_perhitungan_list
						WHERE netapajrek_kohir BETWEEN '$spt_nomor1' AND '$spt_nomor2' ";
		
		$sql_cari .= " AND netapajrek_jenis_ketetapan='".$jenis_ketetapan."' ";
			
		if (!empty($spt_jenis_pajakretribusi)) 
			$sql_cari .= " AND spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."'";
			
		if (!empty($tahun)) 
			$sql_cari .= " AND spt_periode='$tahun'";
			
		if ($this->input->get('netapajrek_tgl') != "")
			$sql_cari .= " AND netapajrek_tgl='".format_tgl($this->input->get('netapajrek_tgl'))."'";
		
		$sql_cari .= " ORDER BY netapajrek_kohir ASC";
		//echo $sql_cari;
		$ar_cari = $this->adodb->GetAll($sql_cari);
		return $ar_cari;
	}
	
	/**
	 * call nota_perhitungan
	 */
	function call_v_nota_perhitungan($netapajrek_id_spt) {
		$jenis_ketetapan = $_GET['spt_jenis_ketetapan'];
		$sql_cari = "SELECT a.*, b.sptrek_lama_pasang  
					FROM v_nota_perhitungan_list_2 a
					LEFT JOIN spt_reklame b ON a.spt_dt_id=sptrek_id_spt_dt 
					WHERE spt_id='$netapajrek_id_spt' AND netapajrek_jenis_ketetapan='$jenis_ketetapan'";
		// echo $sql_cari;
		$pajak = $this->adodb->GetAll($sql_cari);			
		return $pajak;
	}
	
	/**
	 * function get_spt_reklame
	 */
	function get_spt_reklame($spt_dt_id) {
		if (!empty($spt_dt_id)) {
			$query = "SELECT a.*, b.jenis as korek_jenis
						FROM spt_reklame a JOIN v_kode_rekening b
						ON a.sptrek_id_korek = b.korek_id
						WHERE sptrek_id_spt_dt=$spt_dt_id";
			
			//echo $query;
			$result = $this->adodb->GetRow($query);
			//print_r($result);
			return $result;
		}
	}
	
	
	/**
	 * get nota perhitungan
	 */
	function get_nota_lhp() {
		$data = array();
		
		$jenis_ketetapan = $this->input->get('spt_jenis_ketetapan');
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$tahun = $this->input->get('spt_periode');
		$spt_nomor1 = $this->input->get('spt_nomor1');
		$spt_nomor2 = $this->input->get('spt_nomor2');
		
		$sql_cari = "SELECT *
						FROM v_nota_perhitungan_list
						WHERE netapajrek_kohir BETWEEN '$spt_nomor1' AND '$spt_nomor2' ";
		
		$sql_cari .= " AND netapajrek_jenis_ketetapan='".$jenis_ketetapan."' ";
			
		if (!empty($spt_jenis_pajakretribusi)) 
			$sql_cari .= " AND spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."'";
		if (!empty($tahun)) 
			$sql_cari .= " AND spt_periode='$tahun'";	
		
		$sql_cari .= " ORDER BY netapajrek_kohir, netapajrek_id ASC";
		//echo $sql_cari;
		$ar_cari = $this->adodb->GetAll($sql_cari);
		return $ar_cari;
	}
}