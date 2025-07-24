<?php 
/**
 * class Stpd_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Stpd_model extends CI_Model {
	/**
	 * get list stpd
	 */
	function get_list() {
		$tables = " v_stpd ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' stpd_nomor ';
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
	
		$where = " WHERE stpd_id IS NOT NULL";
		
		if ($this->session->userdata('USER_JABATAN') < 10) {
			$where .= " AND stpd_jenis_pajak = '".$this->session->userdata('USER_JABATAN')."'";
		}
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
	
		$sql = "SELECT *
				FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('stpd_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->stpd_id,
									$counter,
									'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="stpd_id[]" value="'.$row->stpd_id.'" 
										onclick="isChecked('.$counter.','.$row->stpd_id.');" />',
									"<a href=\"#\" onclick=\"editData('$row->stpd_id');\">".$row->stpd_nomor."</a>",
									$row->stpd_periode,
									$row->ref_jenparet_ket,
									$row->koderek_titik,									
									$row->korek_nama,
									format_tgl($row->stpd_tgl_proses),
									format_tgl($row->stpd_jatuh_tempo),
									$row->npwprd,
									$row->wp_wr_nama,
									format_currency($row->stpd_pajak)
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
	
	function get_calon_stpd() {
		$tables = " v_calon_stprd ";
	
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
	
		$where = " WHERE setorpajret_jenis_pajakretribusi='".$_GET['jenis_pajak']."' AND EXTRACT(MONTH FROM setorpajret_tgl_bayar) = '".$_GET['bulan_realisasi']."'
						AND EXTRACT(YEAR FROM setorpajret_tgl_bayar) = '".$_GET['tahun_realisasi']."'";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT *
				FROM $tables $where $sort $limit";
		//echo  $sql;
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('setorpajret_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$bulan_pengenaan1 = get_diff_months($row->setorpajret_jatuh_tempo, $row->setorpajret_tgl_bayar, $row->setorpajret_jenis_ketetapan);
				if ($bulan_pengenaan1 > 15){
				$bulan_pengenaan = 15;}
					else {
						$bulan_pengenaan=$bulan_pengenaan1;
				}
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->setorpajret_id,
									$counter,
									"<a href=\"#\" onclick=\"chosenSPT('$row->setorpajret_no_spt', '$row->setorpajret_id');\">".$row->setorpajret_no_spt."</a>",
									format_tgl($row->setorpajret_periode_jual1)." s.d ".format_tgl($row->setorpajret_periode_jual2),
									format_tgl($row->setorpajret_tgl_bayar),
									$bulan_pengenaan,
									format_currency($row->setorpajret_jlh_bayar),
									$row->npwprd,
									$row->wp_wr_nama
								)
							); $counter++;
							
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
	 * get list stpd
	 */
	function get_list_data_stpd() {
		$tables = " v_stpd ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' stpd_nomor ';
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
	
		$where = " WHERE stpd_periode=".$_GET['periode']." AND stpd_jenis_pajak=".$_GET['jenis_pajak'];
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
	
		$sql = "SELECT *
				FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('stpd_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->stpd_id,
									$counter,
									"<a href=\"#\" onclick=\"chosenData('$row->stpd_nomor');\">".$row->stpd_nomor."</a>",
									$row->stpd_nomor,
									$row->stpd_periode,
									$row->ref_jenparet_ket,
									$row->koderek_titik,
									$row->npwprd,
									$row->wp_wr_nama,
									format_currency($row->stpd_pajak)
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
	 * get detail setoran
	 * @param unknown_type $setoran_id
	 */
	function get_detail_setoran($setoran_id) {
		if (empty($setoran_id) || $setoran_id == null)
			return null;
			
		$sql = "SELECT * FROM v_calon_stprd WHERE setorpajret_id=".$setoran_id;
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	/**
	 * insert new data stpd
	 */
	function insert() {
		$result = array();
		
		//check setoran id
		if ($_POST['setorpajret_id'] == "")
			return false;
			
		$sql = "SELECT * FROM stpd WHERE stpd_setoran_id=".$_POST['setorpajret_id'];
		$query = $this->db->query($sql);
		
		if ($query->num_rows > 0) 
			return array('status' => false, 'msg' => 'Data STPD sudah pernah disimpan.');
			
		$sql = "SELECT * FROM stpd WHERE stpd_nomor=".$_POST['stpd_nomor']." AND stpd_jenis_pajak=". $_POST['jenis_pajak'];
		$query = $this->db->query($sql);
		
		if ($query->num_rows > 0) 
			return array('status' => false, 'msg' => 'Nomor STPD sudah pernah disimpan.');		

		$stpd_id = $this->common_model->next_val('stpd_stpd_id_seq');
		$kd_billing = $this->session->userdata('USER_SPT_CODE')."".format_angka($this->config->item('length_no_spt'), $stpd_nomor)."".date("dmy")."".rand(11111,99999);
		$arr_insert = array(
						'stpd_id' => $stpd_id,
						'stpd_jenis_pajak' => $_POST['jenis_pajak'],
						'stpd_tgl_proses' => format_tgl($_POST['tgl_proses']),
						'stpd_jatuh_tempo' => $this->adodb->GetOne("SELECT '".format_tgl($_POST['tgl_proses'])."'::date + (SELECT ref_jatem FROM ref_jatuh_tempo)"),
						'stpd_periode' => $_POST['periode'],
						'stpd_nomor' => $_POST['stpd_nomor'],
						'stpd_setoran_id' => $_POST['setorpajret_id'],
						'stpd_nomor_spt' => $_POST['spt_nomor'],
						'stpd_wp_id' => $_POST['wp_wr_id'],
						'stpd_korek_id' => $_POST['spt_kode_rek'],
						'stpd_periode_jual1' => format_tgl($_POST['setorpajret_periode_jual1']),
						'stpd_periode_jual2' => format_tgl($_POST['setorpajret_periode_jual2']),
						'stpd_tgl_setoran' => format_tgl($_POST['setorpajret_tgl_bayar']),
						'stpd_jumlah_setoran' => unformat_currency($_POST['setorpajret_jlh_bayar']),
						'stpd_kurang_bayar' => 0,
						'stpd_bulan_pengenaan' => $_POST['bulan_pengenaan'],
						'stpd_bunga' => $_POST['bunga'],
						'stpd_sanksi' => unformat_currency($_POST['spt_pajak']),
						'stpd_pajak' => unformat_currency($_POST['spt_pajak']),
						'stpd_dibuat_oleh' => $this->session->userdata('USER_NAME'),
						'stpd_dibuat_tgl' => "NOW()",
						'stpd_kode_billing' => $kd_billing
					);
		$query = $this->db->insert('stpd', $arr_insert);
		
		if ($this->db->affected_rows() > 0) {
			$result = array('status' => true, 'msg' => $this->config->item('msg_success'));
			
			//insert history log
			$this->common_model->history_log("penagihan", "I", "Insert STPD id : ".$stpd_id." | jenis pajak : ".$_POST['jenis_pajak']);
		} else 
			$result = array('status' => false, 'msg' => $this->config->item('msg_fail'));
		
		return $result;
	}
	
	/**
	 * update new data stpd
	 */
	function update() {
		$result = array();
		
		//check setoran id
		if ($_POST['setorpajret_id'] == "")
			return false;
			
		$sql = "SELECT * FROM stpd WHERE stpd_setoran_id='".$_POST['setorpajret_id']."' AND stpd_id != '".$_POST['stpd_id']."'";
		$query = $this->db->query($sql);
		if ($query->num_rows > 0)
			return array('status' => false, 'msg' => 'Data STPD sudah pernah disimpan.');
			
		$sql = "SELECT * FROM stpd WHERE stpd_nomor=".$_POST['stpd_nomor']." AND stpd_jenis_pajak=". $_POST['jenis_pajak']." AND stpd_id != ".$_POST['stpd_id'];
		$query = $this->db->query($sql);		
		if ($query->num_rows > 0) 
			return array('status' => false, 'msg' => 'Nomor STPD sudah pernah disimpan.');
		
		$arr_update = array(
						'stpd_jenis_pajak' => $_POST['jenis_pajak'],
						'stpd_tgl_proses' => format_tgl($_POST['tgl_proses']),
						'stpd_jatuh_tempo' => $this->adodb->GetOne("SELECT '".format_tgl($_POST['tgl_proses'])."'::date + (SELECT ref_jatem FROM ref_jatuh_tempo)"),
						'stpd_periode' => $_POST['periode'],
						'stpd_nomor' => $_POST['stpd_nomor'],
						'stpd_setoran_id' => $_POST['setorpajret_id'],
						'stpd_nomor_spt' => $_POST['spt_nomor'],
						'stpd_wp_id' => $_POST['wp_wr_id'],
						'stpd_korek_id' => $_POST['spt_kode_rek'],
						'stpd_periode_jual1' => format_tgl($_POST['setorpajret_periode_jual1']),
						'stpd_periode_jual2' => format_tgl($_POST['setorpajret_periode_jual2']),
						'stpd_tgl_setoran' => format_tgl($_POST['setorpajret_tgl_bayar']),
						'stpd_jumlah_setoran' => unformat_currency($_POST['setorpajret_jlh_bayar']),
						'stpd_kurang_bayar' => 0,
						'stpd_bulan_pengenaan' => $_POST['bulan_pengenaan'],
						'stpd_bunga' => $_POST['bunga'],
						'stpd_sanksi' => unformat_currency($_POST['spt_pajak']),
						'stpd_pajak' => unformat_currency($_POST['spt_pajak']),
						'stpd_dibuat_oleh' => $this->session->userdata('USER_NAME'),
						'stpd_dibuat_tgl' => "NOW()"
					);
		$this->db->where('stpd_id', $_POST['stpd_id']);
		$query = $this->db->update('stpd', $arr_update);
		
		if ($this->db->affected_rows() > 0) {
			$result = array('status' => true, 'msg' => $this->config->item('msg_success'));
			//insert history log
			$this->common_model->history_log("penagihan", "U", "Update STPD id : ".$_POST['stpd_id']." | jenis pajak : ".$_POST['jenis_pajak']);
		} else 
			$result = array('status' => false, 'msg' => $this->config->item('msg_fail'));
		
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
		$this->db->delete('stpd', array('stpd_id' => $id)); 
		//echo $this->db->last_query();
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * get data stpd
	 */
	function get_list_cetak_stpd($periode, $jenis_pajak, $stpd_nomor1, $stpd_nomor2) {
		$sql = "SELECT * FROM v_stpd WHERE stpd_periode=$periode AND stpd_jenis_pajak=$jenis_pajak AND stpd_nomor BETWEEN $stpd_nomor1 AND $stpd_nomor2";
		//echo $sql;
		$query = $this->adodb->GetAll($sql);
		return $query;
	}
	
	/**
	 * get daftar stpd
	 */
	function get_daftar_stpd() {
		$where = "stpd_id IS NOT NULL";
		
		if ($_GET['bulan'] != "" && $_GET['tahun'] != "") {
			$where .= " AND EXTRACT(MONTH FROM stpd_tgl_setoran)=".$_GET['bulan']." AND EXTRACT(YEAR FROM stpd_tgl_setoran)=".$_GET['tahun'];
		}
		
		if ($_GET['jenis_pajak'] != "" && $_GET['jenis_pajak'] != "0") {
			$where .= " AND stpd_jenis_pajak=".$_GET['jenis_pajak'];
		}		
		
		if ($_GET['camat_id'] != "" && $_GET['camat_id'] != "0") {
			$where .= " AND wp_wr_kd_camat='".$_GET['camat_id']."'";
		}
		
		$sql = "SELECT * FROM v_stpd WHERE $where ORDER BY stpd_nomor ASC";
		$query = $this->adodb->GetAll($sql);
	
		return $query;
	}
}