<?php 
/**
 * class Skpd_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Skpd_model extends CI_Model {
	/**
	 * get list data spt
	 */
	function get_spt() {
		$tables = " v_spt a LEFT JOIN penetapan_pajak_retribusi b ON b.netapajrek_id_spt=a.spt_id ";
	
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
	
		$spt_periode = $this->input->get('spt_periode');
		$spt_jenis_pajak = $this->input->get('spt_jenis_pajakretribusi');
		$where = " WHERE a.spt_jenis_pajakretribusi=$spt_jenis_pajak AND a.spt_periode='$spt_periode' AND a.spt_jenis_pemungutan='2' AND netapajrek_id IS NULL";
		
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$where .= " AND spt_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT a.*
				FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('spt_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->spt_id,
									$counter,
									"<a href=\"#\" onclick=\"isChosenSPT('$row->spt_nomor');\">".$row->spt_nomor."</a>",
									$row->spt_periode,
									$row->spt_periode_jual1." s/d ".$row->spt_periode_jual2,
									$row->koderek,
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
	 * get_list_penetapan
	 */
	function get_list_penetapan() {
		$tables = " v_penetapan_pajak_retribusi a ";
	
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
	
		$where = " WHERE a.netapajrek_id IS NOT NULL AND (a.netapajrek_jenis_ketetapan IN (".$this->config->item('status_spt_official').") 
					OR a.netapajrek_jenis_ketetapan  IS NULL)";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
			
		if ($this->session->userdata('USER_JABATAN') < 10) {
			$where .= " AND a.spt_jenis_pajakretribusi = '".$this->session->userdata('USER_JABATAN')."'";
		}
	
		$sql = "SELECT *
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
									'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="spt_id[]" value="'.$row->netapajrek_id.'" 
										onclick="isChecked('.$counter.','.$row->netapajrek_id.');" />',
									$row->netapajrek_kohir,
									$row->korek_nama,
									$row->spt_periode,
									$row->spt_nomor,
									format_tgl($row->netapajrek_tgl),
									$row->ketspt_ket,
									format_tgl($row->netapajrek_tgl_jatuh_tempo),
									$row->koderek,
									$row->npwprd
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
	 * insert sptpd
	 */
	function insert() {
		$result = array();
		$spt_nomor1 = $this->input->post('spt_nomor1');
		$spt_nomor2 = $this->input->post('spt_nomor2');
		$spt_periode = $this->input->post('spt_periode');
		$spt_jenis_pajakretribusi = $this->input->post('spt_jenis_pajakretribusi');
		
		
		//Get the id_spt from regular sptpd
		$sql_get_ids = "SELECT DISTINCT spt_id,spt_nomor 
							FROM v_spt 
							WHERE spt_nomor BETWEEN '$spt_nomor1' AND '$spt_nomor2' AND spt_periode='$spt_periode' 
							AND spt_jenis_pajakretribusi='$spt_jenis_pajakretribusi' AND spt_jenis_pemungutan='2'";
		
		$ar_get_ids = $this->adodb->GetAll($sql_get_ids);
		
		if (empty($ar_get_ids)) {
			$result = array('status' => false, 'msg' => "Nomor-nomor SPT tersebut tidak bisa ditetapkan!");
		} else {
			$counter = 0;
			foreach ($ar_get_ids as $k => $v) {				
				$spt_penetapan = $this->find_penetapan("netapajrek_id_spt", $v['spt_id']);
				if (empty($spt_penetapan)) {
					$record = $this->records($v['spt_id'], $v['spt_nomor'], $this->input->post('netapajrek_tgl'));
					$insertSQL = $this->adodb->AutoExecute('penetapan_pajak_retribusi', $record, 'INSERT');
					$counter++;
				}
			}
			
			$result = array('status' => true, 'msg' => "$counter SPT berhasil ditetapkan!");
			
			//insert history log
			$this->common_model->history_log("penetapan", "i", "Insert data penetapan : ".
					$spt_periode." | ".$spt_jenis_pajakretribusi." | ".$spt_nomor1." - ".$spt_nomor2);
		}
		
		return $result;
	}
	
	/**
	 * delete data penetapan
	 */
	function delete($id) {
		$ar_penetapan = $this->find_penetapan("netapajrek_id", $id);
		
		if ($this->delete_penetapan($id)) {
			$record = array();
			$record["netapajrekbtl_id"] = $this->common_model->next_val("penetapan_pajak_retribusi_batal_netapajrekbtl_id_seq");
			$record["netapajrekbtl_id_spt"] =  $ar_penetapan['netapajrek_id_spt'];
			$record["netapajrekbtl_wkt_proses"] =  "now()";
			$record["netapajrekbtl_tgl"] = $ar_penetapan['netapajrek_tgl'];
			$record["netapajrek_tgl_jatuh_tempo"] = $ar_penetapan['netapajrek_tgl_jatuh_tempo'];
			$record["netapajrek_kohir"] = $ar_penetapan['netapajrek_kohir'];
			
			$insertSQL = $this->adodb->AutoExecute('penetapan_pajak_retribusi_batal', $record, 'INSERT');
			
			return true;
		} else {
			return false;
		}
	}
	
	function delete_penetapan($netapajrek_id) {
		$sql_delete = "DELETE FROM penetapan_pajak_retribusi WHERE netapajrek_id=$netapajrek_id";
		$delete = $this->adodb->Execute($sql_delete);
		return $delete;
	}
	
	function records($spt_id, $spt_nomor, $netapajrek_tgl) {
		$record = array();
		
		$record["netapajrek_id"] = $this->common_model->next_val("penetapan_pajak_retribusi_netapajrek_id_seq");
		$record["netapajrek_id_spt"] =  $spt_id;
		$record["netapajrek_wkt_proses"] =  "now()";
		$record["netapajrek_tgl"] =  format_tgl($netapajrek_tgl);
		$record["netapajrek_tgl_jatuh_tempo"] = $this->adodb->GetOne("SELECT '".format_tgl($netapajrek_tgl)."'::date + (SELECT ref_jatem FROM ref_jatuh_tempo)");
		$record["netapajrek_jenis_ketetapan"] = $this->config->item('status_skpd');
		$record["netapajrek_kohir"] = $spt_nomor; 
			
		return $record;
	}
	
	/**
	 * find penetapan
	 */
	function find_penetapan($field, $value) {
		$sql_find = "SELECT * FROM penetapan_pajak_retribusi WHERE $field='".$value."'";
		$qr_find = $this->adodb->GetRow($sql_find);
		return $qr_find;
	}
}