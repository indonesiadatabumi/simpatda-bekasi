<?php 
/**
 * class Pribadi_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121015
 */
class Wp_pribadi_model extends CI_Model {
	/**
	 * get list data pribadi model
	 */
	function get_list() {
		$tables = " v_wp_wr ";
		$relations = " wp_wr_gol=1 and wp_wr_status_aktif=TRUE ";
	
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

		if (!empty($relations)) {
		$where = " WHERE $relations ";
		if ($query) $where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
		}
		else {if ($query) $where = " WHERE CAST($qtype AS TEXT) ~~* '%$query%' ";}
	
		$sql = "SELECT * FROM $tables $where $sort $limit";
	
		$result = $this->adodb->Execute($sql);		
		$total = $this->adodb->GetOne("SELECT count('wp_wr_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->wp_wr_id,
									$counter,
									'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="wp_wr_id[]" value="'.$row->wp_wr_id.'" 
											onclick="selectRow('.$counter.','.$row->wp_wr_id.');" />',
									$row->no_reg,
									"<a href='#' onclick=\"editData('".$row->wp_wr_id."')\">".$row->npwprd."</a>",
									$row->wp_wr_no_kartu,
									addslashes($row->wp_wr_nama),
									addslashes(preg_replace("/[\r|\n]/","",$row->wp_wr_almt)),
									$row->wp_wr_lurah,
									$row->wp_wr_camat,
									$row->wp_wr_kabupaten,
									format_tgl($row->wp_wr_tgl_terima_form),
									format_tgl($row->wp_wr_tgl_bts_kirim),
									format_tgl($row->wp_wr_tgl_form_kembali)
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
	
	/*
	 * get wp_wr by wp_wr_id
	 */
	function get_wp_wr($id) {
		$where = array('wp_wr_id' => $id,
						'wp_wr_status_aktif' => 'TRUE');
		
		$this->db->select('*');
		$this->db->from('v_wp_wr');
		$this->db->where($where);
		
		return $this->db->get();
	}
	
	/**
	 * insert data wp_wr_pribadi
	 */
	function insert_data() {
		$result = array();
		
		list($wp_wr_kd_camat, $wp_wr_camat) =  explode("|", $this->input->post('wp_wr_kd_camat'));
		
		$wp_wr_kd_lurah = '';
		$wp_wr_lurah = '';
		if ($this->input->post('wp_wr_kd_lurah') != '') {
			list($wp_wr_kd_lurah,$wp_wr_lurah) =  explode("|", $this->input->post('wp_wr_kd_lurah'));
		}
		$wp_wr_no_urut = $this->input->post('wp_wr_no_urut');
		
		if ($this->common_model->is_exist_wp_wr($wp_wr_no_urut)) {
			$result = array('status' => false, 'msg' => 'Nomor registrasi sudah terdaftar. Silahkan pilih yang lain.');
		} else {
			$wp_wr_tgl_tb = (!empty($_POST['wp_wr_tgl_tb']) ? $this->input->post('wp_wr_tgl_tb') : NULL);
			$wp_wr_tgl_kk = (!empty($_POST['wp_wr_tgl_kk']) ? $this->input->post('wp_wr_tgl_kk') : NULL);
			$next_val = $this->common_model->next_val('wp_wr_wp_wr_id_seq');
			
			$data = array(
						'wp_wr_id' => $next_val,
						'wp_wr_no_form' => '1'.$wp_wr_no_urut,
						'wp_wr_no_urut' => $wp_wr_no_urut,
						'wp_wr_gol' => $this->input->post('wp_wr_gol'),
						'wp_wr_jenis' => $this->input->post('wp_wr_jenis'),
						'wp_wr_nama' => strtoupper($this->input->post('wp_wr_nama')),
						'wp_wr_almt' => strtoupper($this->input->post('wp_wr_almt')),
						'wp_wr_lurah' => $wp_wr_lurah,
						'wp_wr_camat' => $wp_wr_camat,
						'wp_wr_kd_lurah' => $wp_wr_kd_lurah,
						'wp_wr_kd_camat' => $wp_wr_kd_camat,
						'wp_wr_kabupaten' => strtoupper($this->input->post('wp_wr_kabupaten')),
						'wp_wr_telp' => $this->input->post('wp_wr_telp'),
						'wp_wr_kodepos' => $this->input->post('wp_wr_kodepos'),
						'wp_wr_wn' => $this->input->post('wp_wr_wn'),
						'wp_wr_jns_tb' => $this->input->post('wp_wr_jns_tb'),
						'wp_wr_no_tb' => strtoupper($this->input->post('wp_wr_no_tb')),
						'wp_wr_tgl_tb' => format_tgl($wp_wr_tgl_tb),
						'wp_wr_no_kk' => strtoupper($this->input->post('wp_wr_no_kk')),
						'wp_wr_tgl_kk' => format_tgl($wp_wr_tgl_kk),
						'wp_wr_pekerjaan' => $this->input->post('wp_wr_pekerjaan'),
						'wp_wr_nm_instansi' => strtoupper($this->input->post('wp_wr_nm_instansi')),
						'wp_wr_alm_instansi' => strtoupper($this->input->post('wp_wr_alm_instansi')),
						'wp_wr_tgl_kartu' => format_tgl($this->input->post('wp_wr_tgl_kartu')),
						'wp_wr_tgl_terima_form' => format_tgl($this->input->post('wp_wr_tgl_terima_form')),
						'wp_wr_tgl_bts_kirim' => format_tgl($this->input->post('wp_wr_tgl_bts_kirim')),
						'wp_wr_jns_pemungutan' => 1,
						'wp_wr_bidang_usaha' => $this->input->post('bidus'),
						'wp_wr_pejabat' => $this->session->userdata('USER_ID')
					);
					
			$this->db->insert('wp_wr', $data);
			if ($this->db->affected_rows() > 0) {
				$npwprd = $this->common_model->get_record_value('npwprd', 'v_wp_wr', "wp_wr_id='".$next_val."'");
				//insert history log
				$this->common_model->history_log("pendaftaran", "i", "Insert WP Pribadi wp_wr_id=".$next_val);
				
				$result = array('status' => true, 'npwpd' => $npwprd);
			}
			else 
				$result = array('status' => false, 'msg' => 'Data gagal tersimpan');
		}
		
		return $result;
	}
	
	/**
	 * update data wp_wr_pribadi
	 */
	function update_data() {
		$result = array();
		
		list($wp_wr_kd_camat, $wp_wr_camat) =  explode("|", $this->input->post('wp_wr_kd_camat'));
		
		$wp_wr_kd_lurah = '';
		$wp_wr_lurah = '';
		if ($this->input->post('wp_wr_kd_lurah') != '') {
			list($wp_wr_kd_lurah,$wp_wr_lurah) =  explode("|", $this->input->post('wp_wr_kd_lurah'));
		}
		
		$wp_wr_tgl_tb = (!empty($_POST['wp_wr_tgl_tb']) ? $this->input->post('wp_wr_tgl_tb') : NULL);
		$wp_wr_tgl_kk = (!empty($_POST['wp_wr_tgl_kk']) ? $this->input->post('wp_wr_tgl_kk') : NULL);
		
		$data = array(
					'wp_wr_gol' => $this->input->post('wp_wr_gol'),
					'wp_wr_jenis' => $this->input->post('wp_wr_jenis'),
					'wp_wr_nama' => strtoupper($this->input->post('wp_wr_nama')),
					'wp_wr_almt' => strtoupper($this->input->post('wp_wr_almt')),
					'wp_wr_lurah' => $wp_wr_lurah,
					'wp_wr_camat' => $wp_wr_camat,
					'wp_wr_kd_lurah' => $wp_wr_kd_lurah,
					'wp_wr_kd_camat' => $wp_wr_kd_camat,
					'wp_wr_kabupaten' => strtoupper($this->input->post('wp_wr_kabupaten')),
					'wp_wr_telp' => $this->input->post('wp_wr_telp'),
					'wp_wr_kodepos' => $this->input->post('wp_wr_kodepos'),
					'wp_wr_wn' => $this->input->post('wp_wr_wn'),
					'wp_wr_jns_tb' => $this->input->post('wp_wr_jns_tb'),
					'wp_wr_no_tb' => strtoupper($this->input->post('wp_wr_no_tb')),
					'wp_wr_tgl_tb' => format_tgl($wp_wr_tgl_tb),
					'wp_wr_no_kk' => strtoupper($this->input->post('wp_wr_no_kk')),
					'wp_wr_tgl_kk' => format_tgl($wp_wr_tgl_kk),
					'wp_wr_pekerjaan' => $this->input->post('wp_wr_pekerjaan'),
					'wp_wr_nm_instansi' => strtoupper($this->input->post('wp_wr_nm_instansi')),
					'wp_wr_alm_instansi' => strtoupper($this->input->post('wp_wr_alm_instansi')),
					'wp_wr_tgl_kartu' => format_tgl($this->input->post('wp_wr_tgl_kartu')),
					'wp_wr_tgl_terima_form' => format_tgl($this->input->post('wp_wr_tgl_terima_form')),
					'wp_wr_tgl_bts_kirim' => format_tgl($this->input->post('wp_wr_tgl_bts_kirim')),
					'wp_wr_jns_pemungutan' => 1,
					'wp_wr_bidang_usaha' => $this->input->post('bidus'),
					'wp_wr_pejabat' => $this->session->userdata('USER_ID')
				);
		
		$this->db->where('wp_wr_id', $this->input->post('wp_wr_id'));
		$this->db->update('wp_wr', $data);
		if ($this->db->affected_rows() > 0) {
			$result = array('status' => true, 'msg' => 'Data berhasil disimpan');
			//insert history log
			$this->common_model->history_log("pendaftaran", "U", "Update WP Pribadi wp_wr_id=".$this->input->post('wp_wr_id'));	
		}
		else 
			$result = array('status' => false, 'msg' => 'Data gagal tersimpan');
	
		return $result;
	}
	
	/**
	 * delete data wp_wr
	 * @param unknown_type $id
	 */
	function delete_data($wp_wr_id) {
		$this->db->where('wp_wr_id', $wp_wr_id);
		$this->db->delete('wp_wr');

		if ($this->db->affected_rows() > 0) {
			//insert history log
			$this->common_model->history_log("pendaftaran", "D", "Delete WP Pribadi wp_wr_id=$wp_wr_id");
			return true;
		} else {
			return false;
		}
	}
}