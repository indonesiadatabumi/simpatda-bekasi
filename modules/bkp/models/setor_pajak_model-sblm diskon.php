<?php 
/**
 * class Sspd_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Setor_pajak_model extends CI_Model {
	/**
	 * get list setoran
	 */
	function get_list() {
		$tables = " v_setoran_pajak_retribusi ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' setorpajret_dibuat_tanggal ';
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
	
		$where = " WHERE setorpajret_id IS NOT NULL ";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT DISTINCT setorpajret_id, setorpajret_no_spt, setorpajret_spt_periode, ketspt_singkat, setorpajret_tgl_bayar, setorpajret_jlh_bayar, ref_jenparet_ket, 
					npwprd, wp_wr_nama, ref_viabaypajret_ket, setorpajret_dibuat_tanggal
				FROM $tables $where $sort $limit";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count(DISTINCT setorpajret_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->setorpajret_id,
									$counter,
									$row->setorpajret_spt_periode,
									$row->setorpajret_no_spt,
									$row->ketspt_singkat,
									format_tgl($row->setorpajret_tgl_bayar),
									$row->ref_jenparet_ket,
									format_currency($row->setorpajret_jlh_bayar),
									$row->npwprd,
									$row->wp_wr_nama,
									$row->ref_viabaypajret_ket
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
	 * insert setor pajak db
	 */
	function insert_setor_pajak() {
		$result = array();
		
		$setor_id = $this->common_model->next_val("setoran_pajak_retribusi_setorpajret_id_seq");
		$nomor_bukti = $this->insert_nobuk($_POST['periode_spt']);
		$record = array();
		$record['setorpajret_id'] = $setor_id;
		$record['setorpajret_id_spt'] = $_POST['spt_pen_id'];
		$record['setorpajret_no_bukti'] = $nomor_bukti;
		$record['setorpajret_tgl_bayar'] = format_tgl($_POST['tanggal_setor']);
		$record['setorpajret_jlh_bayar'] = unformat_currency($_POST['txt_setoran']);
		$record['setorpajret_via_bayar'] = $_POST['via_bayar'];
		$record['setorpajret_jenis_ketetapan'] = $_POST['setorpajret_jenis_ketetapan'];
		$record['setorpajret_id_wp'] = $_POST['wp_id'];
		$record['setorpajret_jenis_pajakretribusi'] = $_POST['spt_jenis_pajakretribusi'];
		$record['setorpajret_spt_periode'] = $_POST['periode_spt'];
		$record['setorpajret_no_spt'] = $_POST['nomor_spt'];
		$record['setorpajret_periode_jual1'] = ($_POST['spt_periode_jual1'] != "") ? format_tgl($_POST['spt_periode_jual1']) : NULL;
		$record['setorpajret_periode_jual2'] = ($_POST['spt_periode_jual2'] != "") ? format_tgl($_POST['spt_periode_jual2']) : NULL;
		$record['setorpajret_jatuh_tempo'] = ($_POST['txt_jatuh_tempo'] != "") ? format_tgl($_POST['txt_jatuh_tempo']) : NULL;
		$record['setorpajret_dibuat_oleh'] = $this->session->userdata('USER_NAME');

		//cek sudah pernah setor atau blm.
		if ($this->is_setor_exist($_POST['spt_pen_id'], $_POST['setorpajret_jenis_ketetapan'])) {
			$result = array('status' => false, 'msg' => 'Pajak sudah pernah disetor');
		} else {
			$this->db->insert('setoran_pajak_retribusi', $record);
			
			if ($this->db->affected_rows() > 0) {
				//insert detail_setoran
				if (!empty($_POST['spt_dt_korek'])) {
					foreach ($_POST['spt_dt_korek'] as $key => $value) {
						if (!empty($value)) {
							$arr_setor_detail = array(
									'setorpajret_dt_id_setoran' => $setor_id,
									'setorpajret_dt_rekening' => $_POST['spt_dt_korek'][$key],
									'setorpajret_dt_jumlah' => $_POST['spt_dt_pajak'][$key]
								);
								
							$this->db->insert('setoran_pajak_retribusi_detail', $arr_setor_detail);
						}
					}
					
					//add sanksi to database
					if ($_POST['jenis_setoran'] == 1 && unformat_currency($_POST['txt_denda']) > 0) {
						$query = $this->db->query("SELECT * FROM v_kode_rekening_pajak WHERE koderek='41407' AND jenis='0".$_POST['spt_jenis_pajakretribusi']."'");
						if ($query->num_rows() > 0) {
							$korek = $query->row();
							
							$arr_setor_detail = array(
									'setorpajret_dt_id_setoran' => $setor_id,
									'setorpajret_dt_rekening' => $korek->korek_id,
									'setorpajret_dt_jumlah' => unformat_currency($_POST['txt_denda'])
								);
								
							$this->db->insert('setoran_pajak_retribusi_detail', $arr_setor_detail);
						}
					}
				}
				
				$result = array('status' => true, 'msg' => 'Pajak berhasil disetor', 'setor_id' => $setor_id, 'no_bukti' => $nomor_bukti);
				
				//insert history log
				$this->common_model->history_log("bkp", "I", 
					"Insert Setoran Pajak : ".$_POST['spt_jenis_pajakretribusi']." | ".$_POST['periode_spt']." | ".$_POST['nomor_spt']." | ".$_POST['txt_setoran']);
		
			}
			else 
				$result = array('status' => false, 'msg' => 'Pajak gagal disetor');
		}
		
		echo json_encode($result);
	}
	
	/**
	 * check if exist setor data
	 */
	function is_setor_exist($setorpajret_id_penetapan, $setorpajret_jenis_ketetapan) {
		$query = $this->db->get_where('setoran_pajak_retribusi', array('setorpajret_id_spt' => $setorpajret_id_penetapan, 
																	'setorpajret_jenis_ketetapan' => $setorpajret_jenis_ketetapan));
		if ($query->num_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * nomor bukti
	 * @param unknown_type $kohir_thn
	 */
	function insert_nobuk ($kohir_thn) {
		$query = $this->db->query("SELECT kohir_no_bukti+1 as kohir_no FROM kohir WHERE kohir_thn='".$kohir_thn."'");
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$next_val = $row->kohir_no;
			
			$record = array();
			$record['kohir_no_bukti'] = $next_val;
			$this->adodb->AutoExecute('kohir', $record, 'UPDATE', "kohir_thn=$kohir_thn");
			
			return $next_val;
		} else {
			$arr_data = array(
							'kohir_id' => $this->common_model->next_val('kohir_kohir_id_seq'),
							'kohir_thn' => $kohir_thn,
							'kohir_no_bukti' => 1,
							'kohir_no_sts' => 1
						);
			$this->db->insert('kohir', $arr_data);
			return 1;
		}
	}
}