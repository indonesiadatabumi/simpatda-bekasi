<?php 
/**
 * class Setor_bank_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Setor_bank_model extends CI_Model {
	
	/**
	 * get setoran pajak
	 * @param unknown_type $setorpajret_id
	 */
	function get_setoran_pajak($setorpajret_id, $is_cart) {
		$sql = "SELECT a.*, b.*, CASE
				            WHEN t1.korek_sub1::text = '00'::text AND t1.korek_sub2::text = '00'::text THEN (((((((t1.korek_tipe::text || '.'::text) || t1.korek_kelompok::text) || '.'::text) || t1.korek_jenis::text) || '.'::text) || t1.korek_objek::text) || '.'::text) || t1.korek_rincian::text
				            WHEN t1.korek_sub2::text = '00'::text THEN (((((((((t1.korek_tipe::text || '.'::text) || t1.korek_kelompok::text) || '.'::text) || t1.korek_jenis::text) || '.'::text) || t1.korek_objek::text) || '.'::text) || t1.korek_rincian::text) || '.'::text) || t1.korek_sub1::text
				            ELSE (((((((((((t1.korek_tipe::text || '.'::text) || t1.korek_kelompok::text) || '.'::text) || t1.korek_jenis::text) || '.'::text) || t1.korek_objek::text) || '-'::text) || t1.korek_rincian::text) || '.'::text) || t1.korek_sub1::text) || '.'::text) || t1.korek_sub2::text
				        END AS koderek, t1.korek_jenis, t1.korek_nama
				FROM setoran_pajak_retribusi a LEFT JOIN setoran_pajak_retribusi_detail b
				ON a.setorpajret_id = b.setorpajret_dt_id_setoran
				JOIN kode_rekening t1 ON b.setorpajret_dt_rekening = t1.korek_id";
		if($is_cart)
			$sql .= " WHERE a.setorpajret_id IN ($setorpajret_id)";
		else 
			$sql .= " WHERE a.setorpajret_id = $setorpajret_id";

		$sql .= "ORDER BY koderek ASC";
		//echo $sql;				
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function get_list_no_bukti() {
		$result = array();
		$tgl_penyetoran = $_GET['tgl_penyetoran'];
		$spt_jenis_pajakretribusi = $_GET['spt_jenis_pajakretribusi'];
		
		$sql = "SELECT DISTINCT setorpajret_id, setorpajret_no_bukti, setorpajret_no_spt, setorpajret_jlh_bayar
				FROM setoran_pajak_retribusi
				WHERE setorpajret_jenis_pajakretribusi='$spt_jenis_pajakretribusi' AND setorpajret_tgl_bayar = '".format_tgl($tgl_penyetoran)."'
				AND setorpajret_id NOT IN (
					SELECT skbd_id_setoran_pajak
					FROM setoran_ke_bank_detail a JOIN setoran_ke_bank_header b
					ON a.skbd_id_header = b.skbh_id
					WHERE skbh_tgl = '".format_tgl($tgl_penyetoran)."'
				)
				ORDER BY setorpajret_no_spt ASC";
		//echo $sql;
		$query = $this->db->query($sql);
		
		$total = 0;
		$list = array();
		if ($query->num_rows() > 0) {
			$total = $query->num_rows();
			foreach ($query->result() as $row) {
				$list[] = array(
							'key' => $row->setorpajret_id."|".$row->setorpajret_no_bukti."|".$row->setorpajret_jlh_bayar,
							'value' => $row->setorpajret_no_spt
						);
			}
		}
		
		$result = array('total' => $total,
						'list' => $list);
		
		echo json_encode($result);
	}
	
	/**
	 * insert setor bank
	 */
	function insert() {
		$tgl_setoran = format_tgl($this->input->post('tgl_penyetoran'));
		
		if ($tgl_setoran == "")
			$tgl_setoran = date('Y-m-d');
			
		$arr_tgl_setoran = explode('-', $tgl_setoran);
		$tahun_setoran = $arr_tgl_setoran[0];
		$bulan_setoran = $arr_tgl_setoran[1];		
		
		$nomor_surat = $this->insert_no_sts($tahun_setoran, $bulan_setoran);
		$skbh_no = format_angka(4, $nomor_surat)."/".format_romawi($bulan_setoran)."/STS/".$tahun_setoran;
		
		//insert header
		$skbh_id = $this->common_model->next_val('setoran_ke_bank_header_skbh_id_seq');
		
		$arr_header = array(
						'skbh_id' => $skbh_id,
						'skbh_tgl' => $tgl_setoran,
						'skbh_no' => $skbh_no,
						'skbh_nama' => $this->input->post('txt_dari'),
						'skbh_alamat' => $this->input->post('txt_alamat'),
						'skbh_jumlah' => unformat_currency($this->input->post('txt_total_setor')),
						'skbh_keterangan' => ($_POST['txt_keterangan'] == "") ? NULL : $_POST['txt_keterangan'],
						'skbh_bukti_setoran' => $this->input->post('ddl_bukti_setoran'),
						'skbh_no_surat' => $nomor_surat,
						'skbh_dibuat_oleh' => $this->session->userdata('USER_NAME')
					);
		$this->db->insert('setoran_ke_bank_header', $arr_header);
		
		if ($this->db->affected_rows() > 0) {
			//insert detail
			if ($_POST['mode'] == "add") {
				if (!empty($_POST['setorpajret_id'])) {
					foreach ($_POST['setorpajret_id'] as $k => $v) {
						$arr_setor_id = explode("|", $_POST['setorpajret_id'][$k]);
						
						$skbd_id = $this->common_model->next_val('setoran_ke_bank_detail_skbd_id_seq');
						$arr_detail = array(
										'skbd_id' => $skbd_id,
										'skbd_id_header' => $skbh_id,
										'skbd_id_setoran_pajak' => $arr_setor_id[0]
									);
						$this->db->insert('setoran_ke_bank_detail', $arr_detail);					
					}
				}
			} else if ($_POST['mode'] == "cart") {
				$arr_id = explode(",", $this->input->post('setoran_id'));
				
				if (count($arr_id) > 0) {
					for ($i = 0; $i < count($arr_id); $i++) {
						$skbd_id = $this->common_model->next_val('setoran_ke_bank_detail_skbd_id_seq');
						$arr_detail = array(
										'skbd_id' => $skbd_id,
										'skbd_id_header' => $skbh_id,
										'skbd_id_setoran_pajak' => $arr_id[$i]
									);
						$this->db->insert('setoran_ke_bank_detail', $arr_detail);
					}	
				} else {
					$skbd_id = $this->common_model->next_val('setoran_ke_bank_detail_skbd_id_seq');
					$arr_detail = array(
									'skbd_id' => $skbd_id,
									'skbd_id_header' => $skbh_id,
									'skbd_id_setoran_pajak' => $this->input->post('setoran_id')
								);
					$this->db->insert('setoran_ke_bank_detail', $arr_detail);
				}
			}
			
			//insert history log
			$this->common_model->history_log("bkp", "I", 
				"Insert STS : ".$skbh_id." | ".$tgl_setoran." | ".$skbh_no." | ".$this->input->post('txt_total_setor'));

			return $skbh_id;
		} else {
			return false;
		}		
	}
	
	/**
	 * nomor bukti
	 * @param unknown_type $kohir_thn
	 */
	function insert_no_sts ($tahun_setoran, $bulan_setoran) {		
		$query = $this->db->query("SELECT nomor_id, nomor_tanda_setoran+1 as no_sts FROM nomor_surat WHERE nomor_tahun='$tahun_setoran' AND nomor_bulan='$bulan_setoran'");
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$nomor_id = $row->nomor_id;
			$next_val = $row->no_sts;
			
			$record = array('nomor_tanda_setoran' => $next_val);
			$this->db->update('nomor_surat', $record, array('nomor_id' => $nomor_id));
			
			return $next_val;
		} else {
			$arr_data = array(
							'nomor_id' => $this->common_model->next_val('nomor_surat_nomor_id_seq'),
							'nomor_tahun' => $tahun_setoran,
							'nomor_bulan' => $bulan_setoran,
							'nomor_tanda_setoran' => 1,
							'nomor_teguran' => 0
						);
			$this->db->insert('nomor_surat', $arr_data);
			return 1;
		}
	}
	
	/*
	function insert_sts($id_setoran, $nama, $alamat, $jumlah) {
		//insert header
		$skbh_id = $this->common_model->next_val('setoran_ke_bank_header_skbh_id_seq');
		$skbh_no = $this->insert_no_sts();
		$arr_header = array(
						'skbh_id' => $skbh_id,
						'skbh_tgl' => date('Y-m-d H:i:s'),
						'skbh_no' => $skbh_no."/STS/".date('Y'),
						'skbh_nama' => $nama,
						'skbh_alamat' => $alamat,
						'skbh_jumlah' => $jumlah
					);
		$this->db->insert('setoran_ke_bank_header', $arr_header);
		
		if ($this->db->affected_rows() > 0) {
			//insert detail
			$skbd_id = $this->common_model->next_val('setoran_ke_bank_detail_skbd_id_seq');
			$arr_detail = array(
							'skbd_id' => $skbd_id,
							'skbd_id_header' => $skbh_id,
							'skbd_id_setoran_pajak' => $id_setoran,
							'skbd_jumlah' => $jumlah
						);
			$this->db->insert('setoran_ke_bank_detail', $arr_detail);	

			return $skbh_id;
		} else {
			return false;
		}	
	}
	*/
}