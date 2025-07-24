<?php 
/**
 * class Pajak_air_bawah_tanah_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121022
 */
class Pajak_air_bawah_tanah_model extends CI_Model {
/**
	 * get list data
	 */
	function get_list() {
		$tables = "v_spt vspt
					LEFT JOIN penetapan_pajak_retribusi ppr ON ppr.netapajrek_id_spt=vspt.spt_id
			        LEFT JOIN v_rekapitulasi_penerimaan vrp ON ppr.netapajrek_id = vrp.setorpajret_id_spt AND ppr.netapajrek_jenis_ketetapan=vrp.setorpajret_jenis_ketetapan
						AND vspt.spt_jenis_pajakretribusi=vrp.setorpajret_jenis_pajakretribusi
			    	LEFT JOIN keterangan_spt ket ON ket.ketspt_id = spt_status AND spt_status = ket.ketspt_id";
	
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
	
		$where = " WHERE spt_jenis_pajakretribusi='".$this->config->item('jenis_pajak_air_bawah_tanah')."' ";
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$where .= " AND camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}	
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT DISTINCT spt_id, spt_jenis_pajakretribusi, 
                    ket.ketspt_id, ref_jenparet_ket, ket.ketspt_singkat, 
                    ket.ketspt_ket, spt_nomor, spt_periode, 
                    spt_idwpwr, npwprd, wp_wr_nama, wp_wr_almt, 
                    wp_wr_lurah, wp_wr_camat, wp_wr_kabupaten, 
                    spt_jenis_pemungutan, ref_jenput_ket, 
                    spt_tgl_proses, spt_tgl_entry, 
                    spt_periode_jual1, spt_periode_jual2, 
                    spt_kode_rek, koderek, korek_nama, 
                    spt_pajak, spt_tgl_terima, spt_tgl_bts_kembali,
                    netapajrek_tgl, netapajrek_kohir, netapajrek_tgl_jatuh_tempo,
               			setorpajret_tgl_bayar, setorpajret_jlh_bayar 
				FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count(DISTINCT spt_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			$spt_id = "";
			while ($row = $result->FetchNextObject(false)) {
				if ($spt_id != $row->spt_id) {
					$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->spt_id,
									$counter,
									'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="spt_id[]" value="'.$row->spt_id.'" 
										onclick="isChecked('.$counter.','.$row->spt_id.');" />',
									addslashes($row->ref_jenput_ket),
									"<a href='#' onclick=\"editData('".$row->spt_id."', '".$row->spt_jenis_pajakretribusi."')\">".$row->spt_nomor."</a>",
									$row->spt_periode,
									$row->npwprd,
									$row->wp_wr_nama,
									format_currency($row->spt_pajak),
									//penetapan dan penyetoran
									$row->ketspt_singkat,
									format_tgl($row->netapajrek_tgl),
									$row->netapajrek_kohir,
									format_tgl($row->netapajrek_tgl_jatuh_tempo),
									format_tgl($row->setorpajret_tgl_bayar),
									format_currency($row->setorpajret_jlh_bayar)
								)
							);
					$counter++;	
					$spt_id =$row->spt_id;
				}
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
	 * get spt detail
	 */
	function get_spt_detail() {
		$spt_id = $this->input->post('spt_id');
		$query = $this->db->query("SELECT * FROM spt_detail WHERE spt_dt_id_spt=$spt_id ORDER BY spt_dt_id ASC");
		return $query;
	}
	
	/**
	 * insert into spt_detail
	 */
	function insert_spt_detail($spt_id) {
		//insert into spt_detail
		if (!empty($_POST['spt_dt_korek'])) {
			foreach ($_POST['spt_dt_korek'] as $key => $value) {
				if (!empty($value)) {
					$arr_korek = explode(",", $_POST['spt_dt_korek'][$key]);
					$spt_tarif_dasar = unformat_currency($_POST['spt_dt_dasar_pengenaan'][$key]);
					$spt_jumlah = unformat_currency($_POST['spt_dt_jumlah'][$key]);
					$spt_pajak = unformat_currency($_POST['spt_dt_pajak'][$key]);
					$spt_persen = $_POST['spt_dt_persen_tarif'][$key];
					
					$spt_detail_id = $this->common_model->next_val('spt_detail_spt_dt_id_seq');
					$arr_spt_detail = array(
							'spt_dt_id' => $spt_detail_id,
							'spt_dt_id_spt' => $spt_id,
							'spt_dt_korek' => $arr_korek[0],
							'spt_dt_jumlah' => $spt_jumlah,
							'spt_dt_tarif_dasar' => $spt_tarif_dasar,
							'spt_dt_pajak' => $spt_pajak,
							'spt_dt_persen_tarif' => $spt_persen
						);
						
					$this->db->insert('spt_detail', $arr_spt_detail);
				}
			}
		}
		
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * update_array_spt_detail
	 */
	function update_spt_detail($spt_id) {
		//insert into spt_detail
		if (!empty($_POST['spt_dt_korek'])) {
			$list_id = "";
			
			foreach ($_POST['spt_dt_korek'] as $key => $value) {
				if (!empty($value)) {
					$spt_dt_id = @$_POST['spt_dt_id'][$key];
					
					if (!empty($spt_dt_id)) {
						$arr_korek = explode(",", $_POST['spt_dt_korek'][$key]);
						$spt_tarif_dasar = unformat_currency($_POST['spt_dt_dasar_pengenaan'][$key]);
						$spt_jumlah = unformat_currency($_POST['spt_dt_jumlah'][$key]);
						$spt_pajak = unformat_currency($_POST['spt_dt_pajak'][$key]);
						$spt_persen = $_POST['spt_dt_persen_tarif'][$key];
						
						$arr_spt_detail = array(
								'spt_dt_id_spt' => $spt_id,
								'spt_dt_korek' => $arr_korek[0],
								'spt_dt_jumlah' => $spt_jumlah,
								'spt_dt_tarif_dasar' => $spt_tarif_dasar,
								'spt_dt_pajak' => $spt_pajak,
								'spt_dt_persen_tarif' => $spt_persen
							);
						$this->db->where('spt_dt_id', $spt_dt_id);
						$this->db->update('spt_detail', $arr_spt_detail);
					} else {
						$arr_korek = explode(",", $_POST['spt_dt_korek'][$key]);
						$spt_tarif_dasar = unformat_currency($_POST['spt_dt_dasar_pengenaan'][$key]);
						$spt_jumlah = unformat_currency($_POST['spt_dt_jumlah'][$key]);
						$spt_pajak = unformat_currency($_POST['spt_dt_pajak'][$key]);
						$spt_persen = $_POST['spt_dt_persen_tarif'][$key];
						
						$spt_dt_id = $this->common_model->next_val('spt_detail_spt_dt_id_seq');
						$arr_spt_detail = array(
								'spt_dt_id' => $spt_dt_id,
								'spt_dt_id_spt' => $spt_id,
								'spt_dt_korek' => $arr_korek[0],
								'spt_dt_jumlah' => $spt_jumlah,
								'spt_dt_tarif_dasar' => $spt_tarif_dasar,
								'spt_dt_pajak' => $spt_pajak,
								'spt_dt_persen_tarif' => $spt_persen
							);
						$this->db->insert('spt_detail', $arr_spt_detail);
					}
					
					if($list_id != "") 
						$list_id .= ",".$spt_dt_id;
					else 
						$list_id = $spt_dt_id;
				}
			} 
		
			//delete from database
			$delete = "DELETE FROM spt_detail WHERE spt_dt_id NOT IN ($list_id) AND spt_dt_id_spt=$spt_id";
			$this->adodb->Execute($delete);
		} else {
			//delete from database
			$delete = "DELETE FROM spt_detail WHERE spt_dt_id_spt=$spt_id";
			$this->adodb->Execute($delete);
		}
		
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * function get wp id
	 * @param unknown_type $npwpd
	 */
	function get_wp_id($npwpd, $id_bidus) {
		$sql = "SELECT wp_wr_id
					FROM v_wp_wr
					WHERE npwprd='$npwpd' AND wp_wr_bidang_usaha='$id_bidus'";
		$result = $this->adodb->GetOne($sql);
		return $result;
	}
	
	/**
	 * insert spt air tanah
	 */
	function insert_spt_air_tanah($spt_periode, $spt_kode_rek, $spt_periode_jual1, $spt_periode_jual2, $spt_status, $spt_pajak,
		$spt_jenis_pajakretribusi, $wp_wr_id, $tgl_proses, $tgl_entry
	) {
		$spt_nomor = $this->common_model->get_next_nomor_sptpd($spt_periode, $spt_jenis_pajakretribusi);
		
		$spt_id = $this->common_model->next_val('spt_spt_id_seq');
		$kd_billing = $this->session->userdata('USER_SPT_CODE')."".format_angka($this->config->item('length_no_spt'), $spt_nomor)."".date("dmy")."".rand(1111,9999);
		$arr_spt = array(
					'spt_id' => $spt_id,
					'spt_periode' => $spt_periode,
					'spt_kode' => $this->session->userdata('USER_SPT_CODE'),
					'spt_no_register' => format_angka($this->config->item('length_no_spt'), $spt_nomor),
					'spt_nomor' => $this->session->userdata('USER_SPT_CODE')."".format_angka($this->config->item('length_no_spt'), $spt_nomor),
					'spt_kode_rek' => $spt_kode_rek,
					'spt_periode_jual1' => $spt_periode_jual1,
					'spt_periode_jual2' => $spt_periode_jual2,
					'spt_status' => $spt_status,
					'spt_pajak' => $spt_pajak,
					'spt_operator' => $this->session->userdata('USER_ID'),
					'spt_jenis_pajakretribusi' => $spt_jenis_pajakretribusi,
					'spt_idwpwr' => $wp_wr_id,
					'spt_jenis_pemungutan' => '2',
					'spt_tgl_proses' => $tgl_proses,
					'spt_tgl_entry' => $tgl_entry,
					'spt_idwp_reklame' => NULL,
					'spt_kode_billing' => $kd_billing
				);
		$this->db->insert('spt', $arr_spt);
		
		if ($this->db->affected_rows() > 0) {
			return $spt_id;
		} else {
			return 0;
		}
	}
	
	/**
	 * insert spt detail air tanah
	 */
	function insert_spt_detail_air_tanah($spt_id, $spt_kode_rek, $spt_nilai, $tarif_dsr, $korek_persen_tarif, $spt_pajak) {
		//insert into spt_detail
		$spt_detail_id = $this->common_model->next_val('spt_detail_spt_dt_id_seq'); 
		$arr_spt_detail = array(
				'spt_dt_id' => $spt_detail_id,
				'spt_dt_id_spt' => $spt_id,
				'spt_dt_korek' => $spt_kode_rek,
				'spt_dt_jumlah' => ($spt_nilai != "") ? unformat_currency($spt_nilai) : 0,
				'spt_dt_tarif_dasar' => $tarif_dsr,
				'spt_dt_persen_tarif' => $korek_persen_tarif,
				'spt_dt_pajak' => ($spt_pajak != "" ) ? unformat_currency($spt_pajak) : 0
			);
		$this->db->insert('spt_detail', $arr_spt_detail);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}