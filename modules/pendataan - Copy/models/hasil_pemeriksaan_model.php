<?php 
/**
 * class Hasil_pemeriksaan_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Hasil_pemeriksaan_model extends CI_Model {
	/**
	 * get list LHP
	 */
	function get_list_lhp() {
		/* tables and relations sesuaikan*/
		$tables = " v_laporan_hasil_pemeriksaan LEFT JOIN keterangan_spt ket ON v_laporan_hasil_pemeriksaan.lhp_jenis_ketetapan=ket.ketspt_id ";
		$relations = "";
		$where = "";
	
		/* sorting sesuaikan*/
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' lhp_id ';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		
		/* paging jgn dirubah */
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";
		
		/* search jgn dirubah */
		$query = $_POST['query'];
		$qtype = $_POST['qtype'];	
		
		/* where jgn dirubah */
		if (!empty($relations)) {
			$where = " WHERE $relations ";
			if ($query) $where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
		}
		else {if ($query) $where = " WHERE CAST($qtype AS TEXT) ~~* '%$query%' ";}
	
	
		/* QUERY DATA sesuaikan*/
		$sql = "SELECT * FROM $tables $where $sort $limit";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('lhp_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								$row->lhp_id,
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="lhp_id[]" value="'.$row->lhp_id.'" 
										onclick="isChecked('.$counter.','.$row->lhp_id.');" />',
								"<a href='#' onclick=\"editData('".$row->lhp_id."')\">".$row->lhp_no_periksa."</a>",
								format_tgl($row->lhp_tgl),
								format_tgl($row->lhp_tgl_periksa),
								$row->ketspt_singkat,
								$row->npwprd,
								$row->wp_wr_nama,
								$row->koderek.".".$row->korek_rincian.".".$row->korek_sub1,
								$row->korek_nama
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
	 * get setoran of wp
	 * @param unknown_type $wp_id
	 * @param unknown_type $korek_id
	 */
	function get_list_setoran_wp($wpwr_id, $korek_id, $row_id) {	
		/* tables and relations sesuaikan*/
		$tables = " v_setoran_khusus_self ";
		$relations = " sprsd_id_spt IS NOT NULL ";	
		$relations .= " AND sprsd_idwpwr='".$wpwr_id."'";
		//else 
		//	return false;
		//if (!empty($korek_id)) $relations .= " AND sprsd_kode_rek='".$korek_id."'";	
	
		/* sorting sesuaikan*/
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' sprsd_id ';
		if (!$sortorder) $sortorder = 'asc';
		$sort = "ORDER BY $sortname $sortorder";
		
		/* paging jgn dirubah */
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";
		
		/* search jgn dirubah */
		$query = $_POST['query'];
		$qtype = $_POST['qtype'];	
		
		/* where jgn dirubah */
		if (!empty($relations)) {
		$where = " WHERE $relations ";
		if ($query) $where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
		}
		else {if ($query) $where = " WHERE CAST($qtype AS TEXT) ~~* '%$query%' ";}
	
	
		/* QUERY DATA sesuaikan*/
		$sql = "SELECT * FROM $tables $where $sort $limit";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('sprsd_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								$counter,
								$row->setorpajret_no_bukti,
								$row->sprsd_thn,
								"<a href=\"#\" onclick=\"isChosen('$row_id','$row->setorpajret_id','$row->sprsd_thn','$row->ref_viabaypajret_ket','". 
									format_tgl($row->sprsd_periode_jual1) ."','".format_tgl($row->sprsd_periode_jual2)."','".
									format_currency($row->setorpajret_jlh_bayar)."');\">".$row->setorpajret_tgl_bayar."</a>",
								format_tgl($row->sprsd_periode_jual1)." s/d ".format_tgl($row->sprsd_periode_jual2),
								format_currency($row->setorpajret_jlh_bayar),
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
	 * get LHP data
	 */
	function get_lhp_data() {
		$lhp_id = $this->input->post('lhp_id');
		
		$sql = "SELECT *
					FROM laporan_hasil_pemeriksaan lhp
					JOIN laporan_hasil_pemeriksaan_detail lhpd ON lhp.lhp_id=lhpd.lhp_dt_id_header
					JOIN v_wp_wr vwp ON lhp.lhp_idwpwr=vwp.wp_wr_id
					JOIN v_kode_rekening vkr ON lhp_kode_rek=vkr.korek_id
					WHERE lhp.lhp_id='$lhp_id'";
		$query = $this->db->query($sql);
		
		return $query->row();
	}
	
	function get_lhp_detail() {
		$lhp_id = $this->input->post('lhp_id');
		
		$sql = "SELECT *
					FROM laporan_hasil_pemeriksaan lhp
					JOIN laporan_hasil_pemeriksaan_detail lhpd ON lhp.lhp_id=lhpd.lhp_dt_id_header
					JOIN v_wp_wr vwp ON lhp.lhp_idwpwr=vwp.wp_wr_id
					JOIN v_kode_rekening vkr ON lhp_kode_rek=vkr.korek_id
					WHERE lhp.lhp_id='$lhp_id'";
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	/**
	 * check if LHP is exist
	 */
	function check_lhp_exist($lhp_id, $lhp_periode, $lhp_jenis_ketetapan, $lhp_dt_periode1, $lhp_dt_periode2, $lhp_idwpwr) {
		$sql = "SELECT *
				FROM laporan_hasil_pemeriksaan lhp JOIN laporan_hasil_pemeriksaan_detail lhpd
					ON lhp.lhp_id = lhpd.lhp_dt_id_header
				WHERE lhp.lhp_periode='$lhp_periode' AND lhp.lhp_jenis_ketetapan='$lhp_jenis_ketetapan' AND lhp_idwpwr='$lhp_idwpwr'
					AND lhpd.lhp_dt_periode1 BETWEEN '".format_tgl($lhp_dt_periode1)."' AND '".format_tgl($lhp_dt_periode2)."'
					AND lhpd.lhp_dt_periode2 BETWEEN '".format_tgl($lhp_dt_periode1)."' AND '".format_tgl($lhp_dt_periode2)."'";
		
		if (!empty($lhp_id)) {
			$sql .= " AND lhp.lhp_id != '$lhp_id'";
		}
		
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * insert LHP
	 */
	function insert() {
		$result = array();
		$lhp_id = $this->common_model->next_val('laporan_hasil_pemeriksaan_lhp_id_seq');
		//save header
		$arr_lhp = array(
						'lhp_id' => $lhp_id,
						'lhp_tgl' => format_tgl($this->input->post('lhp_tgl')),
						'lhp_idwpwr' => $this->input->post('wp_wr_id'),
						'lhp_periode' => $this->input->post('lhp_periode'),
						'lhp_kode_rek' => $this->input->post('lhp_kode_rek'),
						'lhp_tgl_periksa' => format_tgl($this->input->post('lhp_tgl_periksa')),
						'lhp_no_periksa' => $this->input->post('lhp_no_periksa'),
						'lhp_jenis_ketetapan' => $this->input->post('lhp_jenis_ketetapan'),
						'lhp_catatan' => $this->input->post('lhp_catatan'),
						'lhp_pajak' => unformat_currency($this->input->post('total_pajak')),
						'lhp_jenis_pajakretribusi' => $this->input->post('lhp_jenis_pajakretribusi')
				);
		$this->db->insert('laporan_hasil_pemeriksaan', $arr_lhp);
		
		//if success insert
		if ($this->db->affected_rows() > 0) {
			//insert into detail
			if (!empty($_POST['lhp_dt_periode1'])) {
				foreach ($_POST['lhp_dt_periode1'] as $k => $v) {
					//insert lhp detail
					$detail = array();
					$detail["lhp_dt_id"] = $this->common_model->next_val("laporan_hasil_pemeriksaan_detail_lhp_dt_id_seq");
					$detail["lhp_dt_pajak"] = unformat_currency($_POST['pajak_terhutang'][$k]);
					$detail["lhp_dt_id_header"] = $lhp_id;
					$detail["lhp_dt_periode1"] = format_tgl($_POST['lhp_dt_periode1'][$k]);
					$detail["lhp_dt_periode2"] = format_tgl($_POST['lhp_dt_periode2'][$k]);
					$detail["lhp_dt_dsr_pengenaan"] = unformat_currency($_POST['lhp_dt_dsr_pengenaan'][$k]);
					if (!empty($_POST['lhp_dt_tarif_persen'][$k])) 
						$detail["lhp_dt_tarif_persen"] = $_POST['lhp_dt_tarif_persen'][$k];
					else 
						$detail["lhp_dt_tarif_persen"] = $_POST['korek_persen_tarif'];
					$detail["lhp_dt_kompensasi"] = unformat_currency($_POST['lhp_dt_kompensasi'][$k]);
					$detail["lhp_dt_setoran"] = unformat_currency($_POST['lhp_dt_setoran'][$k]);
					$detail["lhp_dt_kredit_pjk_lain"] = unformat_currency($_POST['lhp_dt_kredit_pjk_lain'][$k]);
					$detail["lhp_dt_bunga"] = unformat_currency($_POST['lhp_dt_bunga'][$k]);
					$detail["lhp_dt_kenaikan"] = unformat_currency($_POST['lhp_dt_kenaikan'][$k]);
					$detail["lhp_dt_id_spt"] = (empty($_POST['lhp_dt_id_spt'][$k])) ? 0 : $_POST['lhp_dt_id_spt'][$k];
					$detail["lhp_dt_denda"] = 0;
					
					$this->db->insert('laporan_hasil_pemeriksaan_detail', $detail);
				}
			}
			
			$result = array('status' => true, 'msg' => 'Data berhasil disimpan.');
			
			//insert history log
			$this->common_model->history_log("pendataan", "i", "Insert Data LHP : ".
					$lhp_id." | ".$_POST['lhp_periode']." | ".strtoupper($_POST['wp_wr_nama'])." | ".$_POST['total_pajak']);
		} else {
			$result = array('status' => false, 'msg' => 'Data gagal disimpan.');
		}
		
		echo json_encode($result);
	}
	
	/**
	 * edit data
	 */
	function edit() {
		$result = array();
		$lhp_id = $this->input->post('lhp_id');
		//save header
		$arr_lhp = array(
						'lhp_tgl' => format_tgl($this->input->post('lhp_tgl')),
						'lhp_idwpwr' => $this->input->post('wp_wr_id'),
						'lhp_periode' => $this->input->post('lhp_periode'),
						'lhp_kode_rek' => $this->input->post('lhp_kode_rek'),
						'lhp_tgl_periksa' => format_tgl($this->input->post('lhp_tgl_periksa')),
						'lhp_no_periksa' => $this->input->post('lhp_no_periksa'),
						'lhp_jenis_ketetapan' => $this->input->post('lhp_jenis_ketetapan'),
						'lhp_catatan' => $this->input->post('lhp_catatan'),
						'lhp_pajak' => unformat_currency($this->input->post('total_pajak')),
						'lhp_jenis_pajakretribusi' => $this->input->post('lhp_jenis_pajakretribusi')
				);
		$this->db->where('lhp_id', $lhp_id);
		$this->db->update('laporan_hasil_pemeriksaan', $arr_lhp);
		
		//if success insert
		if ($this->db->affected_rows() > 0) {
			$list_id = ""; $lhp_dt_id = "";
			
			//insert into detail
			if (!empty($_POST['lhp_dt_periode1'])) {
				foreach ($_POST['lhp_dt_periode1'] as $k => $v) {
					//check is exist lhp_dt_id
					if (!empty($_POST['lhp_dt_id'][$k])) {
						$lhp_dt_id = @$_POST['lhp_dt_id'][$k];
						
						//update lhp detail
						$detail = array();
						$detail["lhp_dt_pajak"] = unformat_currency($_POST['pajak_terhutang'][$k]);
						$detail["lhp_dt_periode1"] = format_tgl($_POST['lhp_dt_periode1'][$k]);
						$detail["lhp_dt_periode2"] = format_tgl($_POST['lhp_dt_periode2'][$k]);
						$detail["lhp_dt_dsr_pengenaan"] = unformat_currency($_POST['lhp_dt_dsr_pengenaan'][$k]);
						if (!empty($_POST['lhp_dt_tarif_persen'][$k])) 
							$detail["lhp_dt_tarif_persen"] = $_POST['lhp_dt_tarif_persen'][$k];
						else 
							$detail["lhp_dt_tarif_persen"] = $_POST['korek_persen_tarif'];
						$detail["lhp_dt_kompensasi"] = unformat_currency($_POST['lhp_dt_kompensasi'][$k]);
						$detail["lhp_dt_setoran"] = unformat_currency($_POST['lhp_dt_setoran'][$k]);
						$detail["lhp_dt_kredit_pjk_lain"] = unformat_currency($_POST['lhp_dt_kredit_pjk_lain'][$k]);
						$detail["lhp_dt_bunga"] = unformat_currency($_POST['lhp_dt_bunga'][$k]);
						$detail["lhp_dt_kenaikan"] = unformat_currency($_POST['lhp_dt_kenaikan'][$k]);
						$detail["lhp_dt_id_spt"] = (empty($_POST['lhp_dt_id_spt'][$k])) ? 0 : $_POST['lhp_dt_id_spt'][$k];
						$detail["lhp_dt_denda"] = 0;
						$this->db->where('lhp_dt_id', $lhp_dt_id);
						$this->db->update('laporan_hasil_pemeriksaan_detail', $detail);
						
					} else {						
						//insert lhp detail
						$lhp_dt_id = $this->common_model->next_val("laporan_hasil_pemeriksaan_detail_lhp_dt_id_seq");
						
						$arr_detail = array(
									"lhp_dt_id" => $lhp_dt_id,
									"lhp_dt_pajak" => unformat_currency($_POST['pajak_terhutang'][$k]),
									"lhp_dt_id_header" => $lhp_id,
									"lhp_dt_periode1" => format_tgl($_POST['lhp_dt_periode1'][$k]),
									"lhp_dt_periode2" => format_tgl($_POST['lhp_dt_periode2'][$k]),
									"lhp_dt_dsr_pengenaan" => unformat_currency($_POST['lhp_dt_dsr_pengenaan'][$k]),
									"lhp_dt_tarif_persen" => ((!empty($_POST['lhp_dt_tarif_persen'][$k])) ? $_POST['lhp_dt_tarif_persen'][$k] : $_POST['korek_persen_tarif']),
									"lhp_dt_kompensasi" => unformat_currency($_POST['lhp_dt_kompensasi'][$k]),
									"lhp_dt_setoran" => unformat_currency($_POST['lhp_dt_setoran'][$k]),
									"lhp_dt_kredit_pjk_lain" => unformat_currency($_POST['lhp_dt_kredit_pjk_lain'][$k]),
									"lhp_dt_bunga" => unformat_currency($_POST['lhp_dt_bunga'][$k]),
									"lhp_dt_kenaikan" => unformat_currency($_POST['lhp_dt_kenaikan'][$k]),
									"lhp_dt_id_spt" => (empty($_POST['lhp_dt_id_spt'][$k])) ? 0 : $_POST['lhp_dt_id_spt'][$k],
									"lhp_dt_denda" => 0
								);
												
						$this->db->insert('laporan_hasil_pemeriksaan_detail', $arr_detail);
					}
					
					if($list_id != "") 
						$list_id .= ",".$lhp_dt_id;
					else 
						$list_id = $lhp_dt_id;
				}
				
				//delete from database
				$delete = "DELETE FROM laporan_hasil_pemeriksaan_detail WHERE lhp_dt_id NOT IN ($list_id) AND lhp_dt_id_header='$lhp_id'";
				$this->adodb->Execute($delete);
			}
			
			$result = array('status' => true, 'msg' => 'Data berhasil disimpan.');
			
			//insert history log
			$this->common_model->history_log("pendataan", "u", "Update Data LHP : ".
					$lhp_id." | ".$_POST['lhp_periode']." | ".strtoupper($_POST['wp_wr_nama'])." | ".$_POST['total_pajak']);
		} else {
			$result = array('status' => false, 'msg' => 'Data gagal disimpan.');
		}
		
		echo json_encode($result);
	}
	
	function delete($lhp_id) {
		$this->db->delete('laporan_hasil_pemeriksaan', array('lhp_id' => $lhp_id)); 
		if ($this->db->affected_rows() > 0) {
			$this->db->delete('laporan_hasil_pemeriksaan_detail', array('lhp_dt_id_header' => $lhp_id));
			
			//insert history log
			$this->common_model->history_log("pendataan", "d", "Delete Data LHP : ".$lhp_id);
			
			return true;
		} else {
			return false;
		}
	}
}