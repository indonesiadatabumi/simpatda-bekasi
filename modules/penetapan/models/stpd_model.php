<?php 
/**
 * class Stpd_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Stpd_model extends CI_Model {
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
	
		$where = " WHERE a.netapajrek_id IS NOT NULL AND (a.netapajrek_jenis_ketetapan IN (".$this->config->item('status_stpd').") 
						OR a.netapajrek_jenis_ketetapan  IS NULL)";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
			
		if ($this->session->userdata('USER_JABATAN') < 10) {
			$where .= " AND a.spt_jenis_pajakretribusi = '".$this->session->userdata('USER_JABATAN')."'";
		}
	
		$sql = "SELECT *
				FROM $tables $where $sort $limit";
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
	
	function get_spt() {
		$tables = " v_calon_stprd_list ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' spt_id ';
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
		$where = " WHERE spt_jenis_pajakretribusi=$spt_jenis_pajak AND spt_periode='$spt_periode'";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT DISTINCT spt_id, spt_nomor, spt_periode, spt_periode_jual1, spt_periode_jual2, koderek, npwprd, wp_wr_nama
				FROM $tables $where $sort $limit";
		//echo  $sql;
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
	
	function insert() {
		$result = array();
		$spt_nomor1 = $this->input->post('spt_nomor1');
		$spt_nomor2 = $this->input->post('spt_nomor2');
		$spt_periode = $this->input->post('spt_periode');
		$spt_jenis_pajakretribusi = $this->input->post('spt_jenis_pajakretribusi');
		$netapajrek_tgl = $this->input->post('netapajrek_tgl');		
		
		//Get the id_spt from regular sptpd
		$sql_get_ids = "SELECT DISTINCT spt_id
							FROM v_calon_stprd_list 
							WHERE spt_nomor BETWEEN '$spt_nomor1' AND '$spt_nomor2' AND spt_periode='$spt_periode' 
							AND spt_jenis_pajakretribusi='$spt_jenis_pajakretribusi'";
		
		$ar_get_ids = $this->adodb->GetAll($sql_get_ids);
		
		if (empty($ar_get_ids)) {
			$result = array('status' => false, 'msg' => "Nomor-nomor SPT tersebut tidak bisa ditetapkan!");
		} else {
			$counter = 0;
			foreach ($ar_get_ids as $k => $v) {	
				$spt_penetapan = $this->find_penetapan("netapajrek_id_spt", $v['spt_id']);
				if (empty($spt_penetapan)) {
					$record = $this->records($v['spt_id'], $spt_periode, $netapajrek_tgl);
					$insertSQL = $this->adodb->AutoExecute('penetapan_pajak_retribusi', $record, 'INSERT');
				} else {
					//update ketetapan to STPD
					$arr_update = array(
									'netapajrek_jenis_ketetapan' => $this->config->item('status_stpd'),
									'netapajrek_tgl' => format_tgl($netapajrek_tgl),
									'netapajrek_wkt_proses' => 'now()',
									'netapajrek_tgl_jatuh_tempo' => $this->adodb->GetOne("SELECT '".format_tgl($netapajrek_tgl)."'::date + (SELECT ref_jatem FROM ref_jatuh_tempo)"),
									'netapajrek_kohir' => $this->insert_kohir($spt_periode, $this->config->item('status_stpd'))
								);
					$this->db->where('netapajrek_id', $spt_penetapan['netapajrek_id']);
					$this->db->update('penetapan_pajak_retribusi', $arr_update);
				}
				
				
				//update spt_detail
				$this->update_spt_detail($v['spt_id']);
				
				//update spt		
				$spt_update = array(
							'spt_status' => $this->config->item('status_stpd')
							//'spt_bunga'	=> ceil($bunga)
						);
				$this->db->where('spt_id', $v['spt_id']);
				$this->db->update('spt', $spt_update);
				
				$counter ++;
			}
			
			$result = array('status' => true, 'msg' => "$counter SPT berhasil ditetapkan! ");
		}
		
		return $result;
	}
	
	function update_spt_detail($spt_id) {
		$sql = "SELECT *
				FROM v_calon_stprd_list 
				WHERE spt_id='$spt_id'";
		$arr_data = $this->adodb->GetAll($sql);
		
		if (!empty($arr_data)) {
			foreach ($arr_data as $key => $val) {
				$bunga = $this->get_bunga($val['jatuh_tempo'], $val['spt_dt_pajak']);
				//echo $val['jatuh_tempo']."  ".$val['spt_dt_pajak']."   ".$bunga;
				$spt_dt_update = array(
							'spt_dt_bunga'	=> ceil($bunga)
						);
				$this->db->where('spt_dt_id', $val['spt_dt_id']);
				$this->db->update('spt_detail', $spt_dt_update);
			}
		}
	}	
	
	function delete($id) {		
		$this->db->delete('penetapan_pajak_retribusi', array('netapajrek_id' => $id, 'netapajrek_jenis_ketetapan' => $this->config->item('status_stpd'))); 
		//echo $this->db->last_query();
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	
	function get_bunga($tanggal_jatuh_tempo, $pokok) {
		$month = $this->adodb->GetOne("select 12*date_part('year', age(DATE '$tanggal_jatuh_tempo'))") + 
					$this->adodb->GetOne("SELECT date_part('month', age(DATE '$tanggal_jatuh_tempo'))");
		$month = ($month == 0) ? 1 : $month;
		//echo $month."\n";
		$besaran = $month * 0.02 * $pokok;
		
		return $besaran;
	}
	
	function records($spt_id, $spt_periode, $netapajrek_tgl) {
		$record = array();
		
		$record["netapajrek_id"] = $this->common_model->next_val("penetapan_pajak_retribusi_netapajrek_id_seq");
		$record["netapajrek_id_spt"] =  $spt_id;
		$record["netapajrek_wkt_proses"] =  "now()";
		$record["netapajrek_tgl"] =  format_tgl($netapajrek_tgl);
		$record["netapajrek_tgl_jatuh_tempo"] = $this->adodb->GetOne("SELECT '".format_tgl($netapajrek_tgl)."'::date + (SELECT ref_jatem FROM ref_jatuh_tempo)");
		$record["netapajrek_jenis_ketetapan"] = $this->config->item('status_stpd');
		$record["netapajrek_kohir"] = $this->insert_kohir($spt_periode, $this->config->item('status_stpd')); 
			
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