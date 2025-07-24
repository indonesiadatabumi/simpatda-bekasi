<?php 
/**
 * class Lhp_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Lhp_model extends CI_Model {
	/**
	 * get list wp
	 */
	function get_list_wp() {	
		$tables = "laporan_hasil_pemeriksaan lhp
					INNER JOIN v_wp_wr vwp ON lhp.lhp_idwpwr = vwp.wp_wr_id
					INNER JOIN keterangan_spt ket ON lhp.lhp_jenis_ketetapan = ket.ketspt_id";
		
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
		
		$where = " WHERE lhp.lhp_id NOT IN (
						SELECT pen.netapajrek_id_lhp
						FROM penetapan_pajak_retribusi pen
						WHERE pen.netapajrek_id_lhp IS NOT NULL
					) AND lhp_periode='".$_GET['tahun']."'";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT DISTINCT vwp.wp_wr_id, vwp.npwprd, vwp.wp_wr_nama, lhp.lhp_periode, ket.ketspt_id, ket.ketspt_singkat, ket.ketspt_ket
				FROM $tables $where $sort $limit";
		
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('vwp.wp_wr_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$counter,
									"<a href=\"#\" onclick=\"isChosen('$row->wp_wr_id','$row->npwprd');\">".$row->npwprd."</a>",
									$row->wp_wr_nama,
									$row->lhp_periode,
									$row->ketspt_id,
									$row->ketspt_singkat
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
	
	
	function get_list_penetapan() {		
		$tables = "laporan_hasil_pemeriksaan lhp
					INNER JOIN penetapan_pajak_retribusi pen ON lhp.lhp_id = pen.netapajrek_id_lhp
					INNER JOIN v_wp_wr vwp ON lhp.lhp_idwpwr = vwp.wp_wr_id
					INNER JOIN keterangan_spt ket ON lhp.lhp_jenis_ketetapan = ket.ketspt_id";
		
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
		
		$where = " WHERE lhp.lhp_id IS NOT NULL ";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT pen.netapajrek_id, pen.netapajrek_kohir, pen.netapajrek_tgl, pen.netapajrek_tgl_jatuh_tempo, vwp.wp_wr_id, vwp.npwprd, vwp.wp_wr_nama, lhp.lhp_periode, ket.ketspt_id, ket.ketspt_singkat, ket.ketspt_ket
				FROM $tables $where $sort $limit";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('pen.netapajrek_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$counter,
									'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="netapajrek_id[]" value="'.$row->netapajrek_id.'" 
										onclick="isChecked('.$counter.','.$row->netapajrek_id.');" />',
									$row->netapajrek_kohir,
									$row->lhp_periode,									
									format_tgl($row->netapajrek_tgl),
									format_tgl($row->netapajrek_tgl_jatuh_tempo),
									$row->npwprd,
									$row->wp_wr_nama,
									$row->ketspt_singkat
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
	 * insert LHP
	 */
	function insert() {
		$result = array();
		$wp_id = $this->input->post('wp_wr_id');
		$tahun = $this->input->post('tahun');
		$netapajrek_tgl = $this->input->post('netapajrek_tgl');
		
		$sql = "SELECT *
				FROM laporan_hasil_pemeriksaan lhp
				INNER JOIN v_wp_wr vwp ON lhp.lhp_idwpwr = vwp.wp_wr_id
				WHERE lhp.lhp_id NOT IN (
					SELECT pen.netapajrek_id_lhp
					FROM penetapan_pajak_retribusi pen
					WHERE pen.netapajrek_id_lhp IS NOT NULL
				) AND vwp.wp_wr_id='$wp_id' AND lhp_periode='$tahun'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$record = array();
				$record["netapajrek_wkt_proses"] =  "now()";
				$record["netapajrek_tgl"] =  format_tgl($netapajrek_tgl);
				$record["netapajrek_tgl_jatuh_tempo"] = $this->adodb->GetOne("SELECT '".format_tgl($netapajrek_tgl)."'::date + (SELECT ref_jatem FROM ref_jatuh_tempo)");
				$record["netapajrek_jenis_ketetapan"] = $row->lhp_jenis_ketetapan; 
				// $record["netapajrek_kohir"] = $this->insert_kohir($tahun, $row->lhp_jenis_ketetapan);
				$record["netapajrek_kohir"] = $row->lhp_no_periksa;
				//$record["netapajrek_besaran"] = unformat_number($besaran);
				$record["netapajrek_kode_rek"] = $row->lhp_kode_rek;
				$record["netapajrek_id_lhp"] = $row->lhp_id;	
				
				$insertSQL = $this->adodb->AutoExecute('penetapan_pajak_retribusi', $record, 'INSERT');
			}

			$result = array('status' => true, 'msg' => 'Data berhasil disimpan');
			//insert history log
			$this->common_model->history_log("penetapan", "i", "Insert penetapan LHP : tahun=".$tahun." | wp_id=".$wp_id);
		} else {
			$result = array('status' => false, 'msg' => 'Data gagal disimpan');
		}
		
		return $result;
	}
	
	function call_kohir_dt_no ($kohir_dt_id_header, $status_spt) {
		$kohir_dt_no = $this->adodb->GetOne("SELECT kohir_dt_no+1 FROM kohir_detail WHERE kohir_dt_id_header='".$kohir_dt_id_header."' AND kohir_dt_ket_spt=$status_spt");
		return $kohir_dt_no;
	}
	
	function check_kohir ($kohir_thn, $kohir_dt_ket_spt) {
		$kohir_id = $this->adodb->GetOne("SELECT kohir_id FROM v_kohir WHERE kohir_thn='".$kohir_thn."' AND kohir_dt_ket_spt='".$kohir_dt_ket_spt."' ");
		return $kohir_id;
	}
	
	
	function insert_kohir ($kohir_thn, $status_spt) {
		//find the kohir at the year
		$kohir_id = $this->check_kohir ($kohir_thn, $status_spt);

		if (!empty($kohir_id)) {
			//find the kohir_dt_no and added by 1
			$kohir_dt_no = $this->call_kohir_dt_no ($kohir_id, $status_spt);
			//update the kohir_dt_no
			$UPDATE = "UPDATE kohir_detail SET kohir_dt_no='".$kohir_dt_no."' WHERE kohir_dt_id_header=$kohir_id AND kohir_dt_ket_spt=$status_spt";
			$rsUPDATEM = $this->adodb->Execute($UPDATE);
		}
		else {
			//find tahun
			$kohir_id = $this->adodb->GetOne("SELECT kohir_id FROM kohir WHERE kohir_thn='$kohir_thn'");
			
			if (empty($kohir_id)) {
				$kohir_id = $this->adodb->GetOne("SELECT nextval('kohir_kohir_id_seq')");
				//insert into kohir
				$INSERT = "INSERT INTO kohir (kohir_id,kohir_thn,kohir_no_bukti) VALUES ($kohir_id,'".$kohir_thn."','1')";
				$rsINSERTM = $this->adodb->Execute($INSERT);
			}

			//insert into kohir_detail
			$INSERT = "INSERT INTO kohir_detail (kohir_dt_id_header,kohir_dt_ket_spt,kohir_dt_no) VALUES ('".$kohir_id."','".$status_spt."',1)";
			$rsINSERTM = $this->adodb->Execute($INSERT);
			$kohir_dt_no=1;
		}
		return $kohir_dt_no;
	}
}