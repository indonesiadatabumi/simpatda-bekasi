<?php 
/**
 * class Pajak_reklame_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Pajak_reklame_model extends CI_Model {
	/**
	 * get list data
	 */
	function get_list() {
		//$tables = " v_spt a LEFT JOIN penetapan_pajak_retribusi b ON b.netapajrek_id_spt=a.spt_id
		//				LEFT JOIN setoran_pajak_retribusi c ON a.spt_id = c.setorpajret_id_penetapan AND c.setorpajret_jenis_ketetapan=a.spt_status ";
		$tables = "v_spt vspt
					LEFT JOIN penetapan_pajak_retribusi ppr ON ppr.netapajrek_id_spt=vspt.spt_id
			        LEFT JOIN v_rekapitulasi_penerimaan vrp ON vspt.spt_id = vrp.setorpajret_id_spt AND vspt.spt_status=vrp.setorpajret_jenis_ketetapan
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
	
		$where = " WHERE spt_jenis_pajakretribusi='".$this->config->item('jenis_pajak_reklame')."' ";
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
									$row->wp_wr_almt,
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
	
	function get_kelas_jalan() {
		$this->db->order_by("ref_rkj_kode", "asc");
		$query = $this->db->get('ref_rek_klas_jalan');
		$total = $query->num_rows();
		
		$result = array();
		if ($total > 0) {
			$list = array();
			foreach ($query->result() as $row) {
				$list[] = array(
							"key" => $row->ref_rkj_id,
							"value" => $row->ref_rkj_nama
						);
			}
			
			$result = array('total' => $total,
					'list' => $list);
		}
		
		return $result;
	}
	
	function get_nilai_kelas_jalan($rek_id, $kelas_jalan_id) {
		$sql = "SELECT * from ref_rek_nilai_kelas_jalan WHERE rek_id=$rek_id AND klas_jalan_id=$kelas_jalan_id";
		return $this->db->query($sql);
	}
	
	/**
	 * get data sptpd from db
	 */
	function get_sptpd() {
	$where = " WHERE spt_jenis_pajakretribusi='".$this->input->post('spt_jenis_pajakretribusi')."' AND spt_id='".$this->input->post('spt_id')."'";
		
		$tables = " v_spt a LEFT JOIN penetapan_pajak_retribusi b ON b.netapajrek_id_spt=a.spt_id
						LEFT JOIN setoran_pajak_retribusi c ON a.spt_id = c.setorpajret_id_spt AND c.setorpajret_jenis_ketetapan=a.spt_status ";
		
		$sql = "SELECT a.*, b.netapajrek_id,b.netapajrek_tgl,b.netapajrek_kohir,b.netapajrek_tgl_jatuh_tempo, c.setorpajret_id, c.setorpajret_tgl_bayar
				FROM $tables $where";
		//echo $sql;
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	/**
	 * get spt detail
	 */
	function get_spt_detail() {
		$spt_id = $this->input->post('spt_id');
		$query = $this->db->query("SELECT * FROM spt_detail WHERE spt_dt_id_spt=$spt_id ORDER BY spt_dt_id ASC");
		return $query;
	}	
	
	function insert_wp_reklame($spt_id, $spt_rekening, $spt_nomor, $spt_nama, $spt_alamat, $merk_usaha) {
		//insert into wp_reklame
		$wp_reklame_id = $this->common_model->next_val('wp_wr_reklame_wp_rek_id_seq'); 
		$arr_spt_detail = array(
				'wp_rek_id' => $wp_reklame_id,
				'wp_rek_jenis' => "P",
				'wp_rek_kode' => $this->session->userdata('USER_SPT_CODE'),
				'wp_rek_nomor' => $spt_nomor,
				'wp_rek_nama' => $spt_nama,
				'wp_rek_alamat' => $spt_alamat,
				//'wp_rek_merk_usaha' => $merk_usaha,
				'wp_rek_lurah' => NULL,
				'wp_rek_camat' => NULL,
				'wp_rek_kabupaten' => NULL
			);
		$this->db->insert('wp_wr_reklame', $arr_spt_detail);
		
		if ($this->db->affected_rows() > 0) {
			return $wp_reklame_id;
		} else {
			return false;
		}
	}
	
	/**
	 * get spt reklame
	 */
	function get_spt_reklame($spt_dt_id) {
		$query = $this->db->get_where('spt_reklame', array('sptrek_id_spt_dt' => $spt_dt_id));
		return $query;		
	}
	
	/**
	 * insert into spt_detail
	 */
	function insert_spt_detail($spt_id) {
		//insert into spt_detail
		$spt_detail_id = $this->common_model->next_val('spt_detail_spt_dt_id_seq'); 
		
		$arr_korek = explode(",", $_POST['spt_dt_korek']);
		$spt_pajak = ($this->input->post('spt_pajak') != "" ) ? unformat_currency($this->input->post('spt_pajak')) : 0;
		$spt_dt_jumlah = ($this->input->post('txt_nsr') != "") ? unformat_currency($this->input->post('txt_nsr')) : $spt_pajak;
		
		$arr_spt_detail = array(
				'spt_dt_id' => $spt_detail_id,
				'spt_dt_id_spt' => $spt_id,
				'spt_dt_korek' => $arr_korek[0],
				'spt_dt_jumlah' => $spt_dt_jumlah,
				'spt_dt_persen_tarif' => $this->input->post('spt_dt_persen_tarif'),
				'spt_dt_pajak' => $spt_pajak
			);
		$this->db->insert('spt_detail', $arr_spt_detail);
		
		if ($this->db->affected_rows() > 0) {
			return $spt_detail_id;
		} else {
			return false;
		}
	}
	
	/**
	 * update spt_detail
	 * @param unknown_type $spt_dt_id
	 */
	function update_spt_detail($spt_dt_id) {
		if (!empty($spt_dt_id)) {
			$arr_korek = explode(",", $_POST['spt_dt_korek']);
			$spt_pajak = ($this->input->post('spt_pajak') != "" ) ? unformat_currency($this->input->post('spt_pajak')) : 0;
			$spt_dt_jumlah = ($this->input->post('txt_nsr') != "") ? unformat_currency($this->input->post('txt_nsr')) : $spt_pajak;
			
			$arr_spt_detail = array(
					'spt_dt_korek' => $arr_korek[0],
					'spt_dt_jumlah' => $spt_dt_jumlah,
					'spt_dt_persen_tarif' => $this->input->post('spt_dt_persen_tarif'),
					'spt_dt_pajak' => $spt_pajak
				);
			$this->db->where('spt_dt_id', $spt_dt_id);
			$this->db->update('spt_detail', $arr_spt_detail);
			
			if ($this->db->affected_rows() > 0) {
				return true;
			} else {
				return false;
			}
		}		
	}
	
	function insert_spt_reklame($spt_dt_id) {
		//insert into spt_reklame
		$spt_reklame_id = $this->common_model->next_val('spt_reklame_sptrek_id_seq');
		$arr_korek = explode(",", $_POST['spt_dt_korek']);
		$arr_spt_reklame = array(
							'sptrek_id' => $spt_reklame_id,
							'sptrek_id_spt_dt' => $spt_dt_id,
							'sptrek_id_korek' => $arr_korek[0],
							'sptrek_area' => $this->input->post('area'),
							'sptrek_judul' => $this->input->post('txt_judul'),
							'sptrek_lokasi' => $this->input->post('txt_lokasi_pasang')
						);

		$arr_detail_reklame = array();
		$kode_rekening = $this->input->post('txt_korek');
		if ($kode_rekening == "4.1.1.04.01" || $kode_rekening == "4.1.1.04.02") {
			$arr_detail_reklame = array(
				'sptrek_id_klas_jalan' => ($this->input->post('kelas_jalan') != "" ? $this->input->post('kelas_jalan') : "0"),
				'sptrek_luas' => ($this->input->post('txt_luas') != "" ? $this->input->post('txt_luas') : "0"),
				'sptrek_jumlah' => ($this->input->post('txt_jumlah') != "" ? $this->input->post('txt_jumlah') : "0"),
				'sptrek_lama_pasang' => ($this->input->post('txt_jangka_waktu') != "" ? $this->input->post('txt_jangka_waktu') : "0"),
				'sptrek_nilai_tarif' => unformat_currency(($this->input->post('txt_nilai_kelas_jalan') ? $this->input->post('txt_nilai_kelas_jalan') : "0")),
				'sptrek_nsr' => unformat_currency(($this->input->post('txt_nsr') ? $this->input->post('txt_nsr') : "0")),
				'sptrek_tarif_pajak' => $this->input->post('spt_dt_persen_tarif')
			);
		} elseif ($kode_rekening == "4.1.1.04.05") {
			$arr_detail_reklame = array(
				'sptrek_luas' => ($this->input->post('txt_luas') != "" ? $this->input->post('txt_luas') : "0"),
				'sptrek_lama_pasang' => ($this->input->post('txt_jangka_waktu') != "" ? $this->input->post('txt_jangka_waktu') : "0"),
				'sptrek_nilai_tarif' => unformat_currency(($this->input->post('txt_nilai_tarif') ? $this->input->post('txt_nilai_tarif') : "0")),
				'sptrek_nsr' => ($this->input->post('txt_nsr') != '') ? ceil($this->input->post('txt_nsr')) : "0",
				'sptrek_tarif_pajak' => $this->input->post('spt_dt_persen_tarif')
			);
		} elseif ($kode_rekening == "4.1.1.04.06") {
			$arr_detail_reklame = array(
				'sptrek_durasi' => ($this->input->post('txt_durasi') != "" ? $this->input->post('txt_durasi') : "30"),
				
				'sptrek_jumlah' => ($this->input->post('txt_jumlah') != "" ? $this->input->post('txt_jumlah') : "0"),
				
				'sptrek_nilai_tarif' => unformat_currency(($this->input->post('txt_nilai_tarif') ? $this->input->post('txt_nilai_tarif') : "0")),
				'sptrek_nsr' => ($this->input->post('txt_nsr') != '') ? ceil($this->input->post('txt_nsr')) : "0",
				'sptrek_tarif_pajak' => $this->input->post('spt_dt_persen_tarif')
			);
		} elseif ($kode_rekening == "4.1.1.04.07" || $kode_rekening == "4.1.1.04.08" || $kode_rekening == "4.1.1.04.11") {
			$arr_detail_reklame = array(
				'sptrek_jumlah' => $this->input->post('txt_jumlah'),
				'sptrek_tarif_pajak' => unformat_currency($this->input->post('txt_nilai_tarif'))
			);
		} else if ($kode_rekening == "4.1.1.04.03" || $kode_rekening == "4.1.1.04.04") {
			$arr_detail_reklame = array(
				'sptrek_luas' => ($this->input->post('txt_luas') != "" ? $this->input->post('txt_luas') : "0"),
				'sptrek_nilai_tarif' => unformat_currency(($this->input->post('txt_nilai_tarif') ? $this->input->post('txt_nilai_tarif') : "0")),
				'sptrek_nsr' => ($this->input->post('txt_nsr') != '') ? ceil($this->input->post('txt_nsr')) : "0",
				'sptrek_tarif_pajak' => $this->input->post('spt_dt_persen_tarif')
			);
		} else if ($kode_rekening == "4.1.1.04.10") {
			$arr_detail_reklame = array(
				'sptrek_luas' => $this->input->post('txt_luas'),
				'sptrek_tarif_pajak' => unformat_currency($this->input->post('txt_nilai_tarif'))
			);
		} else if ($kode_rekening == "4.1.1.04.09") {
			$arr_detail_reklame = array(
				'sptrek_durasi' => ($this->input->post('txt_durasi') != "" ? $this->input->post('txt_durasi') : "15"),
				'sptrek_teater' => ($this->input->post('txt_teater') != "" ? $this->input->post('txt_teater') : "0"),
				'sptrek_jumlah' => ($this->input->post('txt_jumlah') != "" ? $this->input->post('txt_jumlah') : "0"),
				'sptrek_lama_pasang' => ($this->input->post('txt_jangka_waktu') != "" ? $this->input->post('txt_jangka_waktu') : "0"),
				'sptrek_nilai_tarif' => unformat_currency(($this->input->post('txt_nilai_tarif') ? $this->input->post('txt_nilai_tarif') : "0")),
				'sptrek_nsr' => ($this->input->post('txt_nsr') != '') ? ceil($this->input->post('txt_nsr')) : "0",
				'sptrek_tarif_pajak' => $this->input->post('spt_dt_persen_tarif')
			);
		}

		$arr_reklame = array_merge($arr_spt_reklame, $arr_detail_reklame);
								
		$this->db->insert('spt_reklame', $arr_reklame);
	}
	
	/**
	 * update spt reklame
	 * @param unknown_type $spt_reklame_id
	 * @param unknown_type $spt_dt_id
	 */
	function update_spt_reklame($spt_reklame_id, $spt_dt_id) {
		//insert into spt_reklame
		$arr_korek = explode(",", $_POST['spt_dt_korek']);
		$arr_spt_reklame = array(
							'sptrek_id_korek' => $arr_korek[0],
							'sptrek_area' => $this->input->post('area'),
							'sptrek_judul' => $this->input->post('txt_judul'),
							'sptrek_lokasi' => $this->input->post('txt_lokasi_pasang')
						);

		$arr_detail_reklame = array();
		$kode_rekening = $this->input->post('txt_korek');
		if ($kode_rekening == "4.1.1.04.01" || $kode_rekening == "4.1.1.04.02") {
			$arr_detail_reklame = array(
				'sptrek_id_klas_jalan' => ($this->input->post('kelas_jalan') != "" ? $this->input->post('kelas_jalan') : "0"),
				'sptrek_luas' => ($this->input->post('txt_luas') != "" ? $this->input->post('txt_luas') : "0"),
				'sptrek_jumlah' => ($this->input->post('txt_jumlah') != "" ? $this->input->post('txt_jumlah') : "0"),
				'sptrek_lama_pasang' => ($this->input->post('txt_jangka_waktu') != "" ? $this->input->post('txt_jangka_waktu') : "0"),
				'sptrek_nilai_tarif' => unformat_currency(($this->input->post('txt_nilai_kelas_jalan') ? $this->input->post('txt_nilai_kelas_jalan') : "0")),
				'sptrek_nsr' => unformat_currency(($this->input->post('txt_nsr') ? $this->input->post('txt_nsr') : "0")),
				'sptrek_tarif_pajak' => $this->input->post('spt_dt_persen_tarif')
			);
		} elseif ($kode_rekening == "4.1.1.04.05") {
			$arr_detail_reklame = array(
				'sptrek_luas' => ($this->input->post('txt_luas') != "" ? $this->input->post('txt_luas') : "0"),
				'sptrek_lama_pasang' => ($this->input->post('txt_jangka_waktu') != "" ? $this->input->post('txt_jangka_waktu') : "0"),
				'sptrek_nilai_tarif' => unformat_currency(($this->input->post('txt_nilai_tarif') ? $this->input->post('txt_nilai_tarif') : "0")),
				'sptrek_nsr' => ($this->input->post('txt_nsr') != '') ? ceil($this->input->post('txt_nsr')) : "0",
				'sptrek_tarif_pajak' => $this->input->post('spt_dt_persen_tarif')
			);
		} elseif ($kode_rekening == "4.1.1.04.06") {
			$arr_detail_reklame = array(
				'sptrek_durasi' => ($this->input->post('txt_durasi') != "" ? $this->input->post('txt_durasi') : "30"),
				
				'sptrek_jumlah' => ($this->input->post('txt_jumlah') != "" ? $this->input->post('txt_jumlah') : "0"),
				
				'sptrek_nilai_tarif' => unformat_currency(($this->input->post('txt_nilai_tarif') ? $this->input->post('txt_nilai_tarif') : "0")),
				'sptrek_nsr' => ($this->input->post('txt_nsr') != '') ? ceil($this->input->post('txt_nsr')) : "0",
				'sptrek_tarif_pajak' => $this->input->post('spt_dt_persen_tarif')
			);
		} elseif ($kode_rekening == "4.1.1.04.07" || $kode_rekening == "4.1.1.04.08" || $kode_rekening == "4.1.1.04.11") {
			$arr_detail_reklame = array(
				'sptrek_jumlah' => $this->input->post('txt_jumlah'),
				'sptrek_tarif_pajak' => unformat_currency($this->input->post('txt_nilai_tarif'))
			);
		} else if ($kode_rekening == "4.1.1.04.03" || $kode_rekening == "4.1.1.04.04") {
			$arr_detail_reklame = array(
				'sptrek_luas' => $this->input->post('txt_luas'),
				'sptrek_tarif_pajak' => unformat_currency($this->input->post('txt_nilai_tarif'))
			);
		} else if ($kode_rekening == "4.1.1.04.10") {
			$arr_detail_reklame = array(
				'sptrek_luas' => $this->input->post('txt_luas'),
				'sptrek_tarif_pajak' => unformat_currency($this->input->post('txt_nilai_tarif'))
			);
		} else if ($kode_rekening == "4.1.1.04.09") {
			$arr_detail_reklame = array(
				'sptrek_durasi' => ($this->input->post('txt_durasi') != "" ? $this->input->post('txt_durasi') : "15"),
				'sptrek_teater' => ($this->input->post('txt_teater') != "" ? $this->input->post('txt_teater') : "0"),
				'sptrek_jumlah' => ($this->input->post('txt_jumlah') != "" ? $this->input->post('txt_jumlah') : "0"),
				'sptrek_lama_pasang' => ($this->input->post('txt_jangka_waktu') != "" ? $this->input->post('txt_jangka_waktu') : "0"),
				'sptrek_nilai_tarif' => unformat_currency(($this->input->post('txt_nilai_tarif') ? $this->input->post('txt_nilai_tarif') : "0")),
				'sptrek_nsr' => ($this->input->post('txt_nsr') != '') ? ceil($this->input->post('txt_nsr')) : "0",
				'sptrek_tarif_pajak' => $this->input->post('spt_dt_persen_tarif')
			);
		}

		$arr_reklame = array_merge($arr_spt_reklame, $arr_detail_reklame);
		
		if (!empty($spt_reklame_id))
			$this->db->where('sptrek_id', $spt_reklame_id);
		else 
			$this->db->where('sptrek_id_spt_dt', $spt_dt_id);
			
		$this->db->update('spt_reklame', $arr_reklame);
	}
	
	function update_wp_reklame() {
		$arr_update = array(
							'wp_rek_nama' => strtoupper($this->input->post('wp_wr_nama')),
							'wp_rek_alamat' => strtoupper($this->input->post('wp_wr_almt'))
						);
		$this->db->where('wp_rek_id', $this->input->post('wp_rek_id'));
		$this->db->update('wp_wr_reklame', $arr_update);
	}
	
	function delete_wp_reklame($wp_rek_id) {
		$this->db->where('wp_rek_id', $wp_rek_id);
		$this->db->delete('wp_wr_reklame');
	}
}