<?php 
/**
 * class Pajak_restoran_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121022
 */
class Spt_model extends CI_Model {
	/**
	 * check_masa_pajak
	 */
	function check_masa_pajak($wpwr_id, $spt_periode_jual1, $spt_periode_jual2, $kode_rek, $jenis_pungutan = 1, $spt_id = "", $is_reklame = FALSE) {
		$where = "spt_periode_jual1 BETWEEN '".format_tgl($spt_periode_jual1)."' AND '".format_tgl($spt_periode_jual2)."' 
					AND spt_periode_jual2 BETWEEN '".format_tgl($spt_periode_jual1)."' AND '".format_tgl($spt_periode_jual2)."'
					AND spt_jenis_pemungutan='$jenis_pungutan'";
		
		if (!$is_reklame) {
			$where .= " AND spt_idwpwr='".$wpwr_id."'";
		} else {
			$where .= " AND spt_idwp_reklame='".$wpwr_id."'";
		}
		
		if (!empty($spt_id)) {
			$where .= " AND spt_id != '$spt_id'";
		}
		
		$this->db->select('spt_id');
		$this->db->from('spt');
		$this->db->where($where);
		$query = $this->db->get();
		//echo $this->db->last_query();
		
		if ($query->num_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * get_nomor_spt
	 */
	function get_nomor_spt($periode, $spt_jenis_pajak) {
		$sql = "SELECT COALESCE(max(spt_nomor)+1,1) as max_no_spt FROM spt 
						WHERE spt_periode='".$periode."' AND spt_jenis_pajakretribusi='".$spt_jenis_pajak."'";
		$spt_no = $this->adodb->GetOne($sql);
		if (!empty($spt_no))
			return $spt_no;
		else 
			return false;
	}
	
	/**
	 * check nomor spt
	 */
	function is_exist_nomor_spt($nomor_spt, $periode, $spt_jenis_pajak) {
		$arr_where = array(
						'spt_kode' => $this->session->userdata('USER_SPT_CODE'),
						'spt_nomor' => $nomor_spt,
						'spt_periode' => $periode,
						'spt_jenis_pajakretribusi' => $spt_jenis_pajak
					);
		$this->db->from('spt');
		$this->db->where($arr_where);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * get data sptpd from db
	 */
	function get_sptpd() {
		$where = " WHERE spt_jenis_pajakretribusi='".$this->input->post('spt_jenis_pajakretribusi')."' AND spt_id='".$this->input->post('spt_id')."'";
		
		$sql = " SELECT spt_id, spt_periode, spt_nomor, spt_tgl_proses, spt_tgl_entry, spt_periode, spt_idwpwr, wp_wr_gol, ref_kodus_kode, wp_wr_no_urut, camat_kode, 
					lurah_kode, wp_wr_nama, wp_wr_almt, wp_wr_lurah, wp_wr_camat, wp_wr_kabupaten, spt_jenis_pemungutan, spt_periode_jual1, spt_periode_jual2, spt_dt_id, 
					spt_dt_korek, koderek, jenis AS korek_rincian, klas AS korek_sub1, korek_nama, spt_dt_jumlah, spt_dt_persen_tarif, spt_pajak, netapajrek_id, setorpajret_id,spt_kode 
				FROM spt LEFT JOIN spt_detail sptd ON spt.spt_id = sptd.spt_dt_id_spt
				JOIN v_wp_wr vwp ON spt.spt_idwpwr=vwp.wp_wr_id
				LEFT JOIN penetapan_pajak_retribusi ppr ON ppr.netapajrek_id_spt=spt.spt_id
				LEFT JOIN setoran_pajak_retribusi spr ON spt.spt_id = spr.setorpajret_id_spt AND spt.spt_status=spr.setorpajret_jenis_ketetapan
						AND spt.spt_jenis_pajakretribusi=spr.setorpajret_jenis_pajakretribusi
				LEFT JOIN v_kode_rekening rek ON sptd.spt_dt_korek = rek.korek_id $where";
		//echo $sql;
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	/**
	 * insert spt
	 */
	function insert_spt($is_spt_reklame = FALSE, $wp_reklame_id = 0) {
		$id_reklame = NULL;
		//insert into spt
		$spt_nomor = $this->input->post('spt_no_register');
		$is_exist_no_spt = $this->is_exist_nomor_spt(
														$this->input->post('spt_kode')."".$spt_nomor, 
														$this->input->post('spt_periode'), 
														$this->input->post('spt_jenis_pajakretribusi')
													);
		if ($is_exist_no_spt) 
			return 0;

		$spt_id = $this->common_model->next_val('spt_spt_id_seq');
		$spt_status =  ($this->input->post('spt_jenis_pemungutan') == 1) ? $this->config->item('status_spt_self') : $this->config->item('status_spt_official');
		$spt_kode_rek = $this->common_model->get_record_value('korek_id', 'v_kode_rekening_pajak5digit', "koderek='".$this->input->post('korek')."'");
		$spt_pajak = ($this->input->post('spt_pajak') != "") ? unformat_currency(($this->input->post('spt_pajak'))) : NULL;			
		
		if ($is_spt_reklame) {
			$wp_wr_id = NULL;
			$id_reklame = $wp_reklame_id;
			$kd_billing = $this->input->post('spt_kode')."".$spt_nomor."".date("dmy")."".rand(1111,9999);
		}			
		else {
			$wp_wr_id = $this->input->post('wp_wr_id');
			$kd_billing = $this->input->post('spt_kode')."".$spt_nomor."".date("dmy")."".rand(1111,9999);
		}
		$arr_spt = array(
					'spt_id' => $spt_id,
					'spt_periode' => $this->input->post('spt_periode'),
					'spt_kode' => $this->input->post('spt_kode'),
					'spt_no_register' => $spt_nomor,
					'spt_nomor' => $this->input->post('spt_kode')."".$spt_nomor,
					'spt_kode_rek' => $spt_kode_rek,
					'spt_periode_jual1' => format_tgl($this->input->post('spt_periode_jual1')),
					'spt_periode_jual2' => format_tgl($this->input->post('spt_periode_jual2')),
					'spt_status' => $spt_status,
					'spt_pajak' => $spt_pajak,
					'spt_operator' => $this->session->userdata('USER_ID'),
					'spt_jenis_pajakretribusi' => $this->input->post('spt_jenis_pajakretribusi'),
					'spt_idwpwr' => $wp_wr_id,
					'spt_jenis_pemungutan' => $this->input->post('spt_jenis_pemungutan'),
					'spt_tgl_proses' => format_tgl($this->input->post('spt_tgl_proses')),
					'spt_tgl_entry' => format_tgl($this->input->post('spt_tgl_entry')),
					'spt_idwp_reklame' => $id_reklame,
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
	 * update spt
	 */
	function update_spt() {
		//update into spt
		$spt_status =  ($this->input->post('spt_jenis_pemungutan') == 1) ? $this->config->item('status_spt_self') : $this->config->item('status_spt_official');
		
		$arr_spt = array(
					'spt_periode' => $this->input->post('spt_periode'),
					'spt_periode_jual1' => format_tgl($this->input->post('spt_periode_jual1')),
					'spt_periode_jual2' => format_tgl($this->input->post('spt_periode_jual2')),
					'spt_status' => $spt_status,
					'spt_pajak' => unformat_currency($this->input->post('spt_pajak')),
					'spt_operator' => $this->session->userdata('USER_ID'),
					'spt_jenis_pajakretribusi' => $this->input->post('spt_jenis_pajakretribusi'),
					'spt_idwpwr' => $this->input->post('wp_wr_id'),
					'spt_jenis_pemungutan' => $this->input->post('spt_jenis_pemungutan'),
					'spt_tgl_proses' => format_tgl($this->input->post('spt_tgl_proses')),
					'spt_tgl_entry' => format_tgl($this->input->post('spt_tgl_entry'))
				);
		$this->db->where('spt_id', $this->input->post('spt_id'));
		$this->db->update('spt', $arr_spt);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * insert into spt_detail
	 */
	function insert_spt_detail($spt_id) {
		//insert into spt_detail
		$spt_detail_id = $this->common_model->next_val('spt_detail_spt_dt_id_seq'); 
		$arr_spt_detail = array(
				'spt_dt_id' => $spt_detail_id,
				'spt_dt_id_spt' => $spt_id,
				'spt_dt_korek' => $this->input->post('spt_kode_rek'),
				'spt_dt_jumlah' => ($this->input->post('spt_nilai') != "") ? unformat_currency($this->input->post('spt_nilai')) : 0,
				'spt_dt_tarif_dasar' => $this->input->post('korek_tarif_dsr'),
				'spt_dt_persen_tarif' => $this->input->post('korek_persen_tarif'),
				'spt_dt_pajak' => ($this->input->post('spt_pajak') != "" ) ? unformat_currency($this->input->post('spt_pajak')) : 0
			);
		$this->db->insert('spt_detail', $arr_spt_detail);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * insert into spt_detail
	 */
	function insert_array_spt_detail($spt_id) {
		//insert into spt_detail
		if (!empty($_POST['spt_dt_korek'])) {
			foreach ($_POST['spt_dt_korek'] as $key => $value) {
				if (!empty($value)) {
					$arr_korek = explode(",", $_POST['spt_dt_korek'][$key]);
					$spt_nilai = unformat_currency($_POST['spt_dt_dasar_pengenaan'][$key]);
					$spt_pajak = unformat_currency($_POST['spt_dt_pajak'][$key]);
					$spt_persen = $_POST['spt_dt_persen_tarif'][$key];
					
					$spt_detail_id = $this->common_model->next_val('spt_detail_spt_dt_id_seq');
					$arr_spt_detail = array(
							'spt_dt_id' => $spt_detail_id,
							'spt_dt_id_spt' => $spt_id,
							'spt_dt_korek' => $arr_korek[0],
							'spt_dt_jumlah' => $spt_nilai,
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
	 * update_spt_detail
	 */
	function update_spt_detail() {
		//update into spt_detail
		$arr_spt_detail = array(
				'spt_dt_korek' => $this->input->post('spt_kode_rek'),
				'spt_dt_jumlah' => ($this->input->post('spt_nilai') != "") ? unformat_currency($this->input->post('spt_nilai')) : 0,
				'spt_dt_persen_tarif' => $this->input->post('korek_persen_tarif'),
				'spt_dt_tarif_dasar' => $this->input->post('korek_tarif_dsr'),
				'spt_dt_pajak' => ($this->input->post('spt_pajak') != "" ) ? unformat_currency($this->input->post('spt_pajak')) : 0
			);
		$this->db->where('spt_dt_id', $this->input->post('spt_dt_id'));
		$this->db->update('spt_detail', $arr_spt_detail);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * update_array_spt_detail
	 */
	function update_array_spt_detail($spt_id) {
		//insert into spt_detail
		if (!empty($_POST['spt_dt_korek'])) {
			$list_id = "";
			
			foreach ($_POST['spt_dt_korek'] as $key => $value) {
				if (!empty($value)) {
					$spt_dt_id = @$_POST['spt_dt_id'][$key];
					
					if (!empty($spt_dt_id)) {
						$arr_korek = explode(",", $_POST['spt_dt_korek'][$key]);
						$spt_nilai = unformat_currency($_POST['spt_dt_dasar_pengenaan'][$key]);
						$spt_pajak = unformat_currency($_POST['spt_dt_pajak'][$key]);
						$spt_persen = $_POST['spt_dt_persen_tarif'][$key];
						
						$arr_spt_detail = array(
								'spt_dt_id_spt' => $spt_id,
								'spt_dt_korek' => $arr_korek[0],
								'spt_dt_jumlah' => $spt_nilai,
								'spt_dt_pajak' => $spt_pajak,
								'spt_dt_persen_tarif' => $spt_persen
							);
						$this->db->where('spt_dt_id', $spt_dt_id);
						$this->db->update('spt_detail', $arr_spt_detail);
					} else {
						$arr_korek = explode(",", $_POST['spt_dt_korek'][$key]);
						$spt_nilai = unformat_currency($_POST['spt_dt_dasar_pengenaan'][$key]);
						$spt_pajak = unformat_currency($_POST['spt_dt_pajak'][$key]);
						$spt_persen = $_POST['spt_dt_persen_tarif'][$key];
						
						$spt_dt_id = $this->common_model->next_val('spt_detail_spt_dt_id_seq');
						$arr_spt_detail = array(
								'spt_dt_id' => $spt_dt_id,
								'spt_dt_id_spt' => $spt_id,
								'spt_dt_korek' => $arr_korek[0],
								'spt_dt_jumlah' => $spt_nilai,
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
	 * delete data spt
	 */
	function delete_spt($spt_id) {
		$this->db->delete('spt', array('spt_id' => $spt_id)); 
		if ($this->db->affected_rows() > 0) {
			$this->db->delete('spt_detail', array('spt_dt_id_spt' => $spt_id));
			
			return true;
		} else {
			return false;
		}
	}
}