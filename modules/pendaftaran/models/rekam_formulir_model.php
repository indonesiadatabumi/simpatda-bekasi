<?php 
/**
 * class Rekam_formulir_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Rekam_formulir_model extends CI_Model {
	/**
	 * get list data rekam_formulir
	 */
	function get_list() {
		$tables = " v_formulir ";
		$relations = " form_id IS NOT NULL ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' form_id ';
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
		$total = $this->adodb->GetOne("SELECT count('form_id') FROM $tables $where");
			
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			$index = 0;
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->form_id,
									$counter,
									'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="form_id[]" value="'.$row->form_id.'" 
											onclick="selectRow('.$index.');isChecked(this.checked,'.$row->form_nomor.');" />',
									"<a href='#' onclick=\"editData('".$row->form_id."')\">".$row->form_nomor."</a>",
									$row->form_nama,
									$row->form_alamat,
									$row->camat_nama,
									$row->lurah_nama,
									$row->status,
								 	format_tgl($row->form_tgl_kirim),
									format_tgl($row->form_tgl_kembali)
								)
							);
				$counter++;
				$index++;
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
	 * get detail formulir
	 */
	function get_detail() {
		$query = $this->db->get_where('v_formulir', array('form_id' => $this->input->post('id')));
		return $query->row();
	}
	
	/**
	 * insert
	 */
	function insert() {
		$form_id = $this->common_model->next_val('formulir_id_seq');
		$arr_insert = array(
						'form_id' => $form_id,
						'form_nomor' => $this->input->post('txt_no_formulir'),
						'form_nama' => strtoupper($this->input->post('txt_nama')),
						'form_alamat' => strtoupper($this->input->post('txt_alamat')),
						'form_camat' => $this->input->post('txt_kode_camat'),
						'form_lurah' => $this->input->post('txt_kode_lurah'),
						'form_tgl_kirim' => format_tgl($this->input->post('txt_tgl_kirim')),
						'operator_id' => $this->session->userdata('USER_ID'),
						'tgl_proses' => date('Y-m-d H:i:s'),
						'form_status' => $this->input->post('ddl_status')
					);		
		$this->db->insert('formulir', $arr_insert);
		
		if ($this->db->affected_rows()) {
			//insert history log ($module, $action, $description)
			$this->common_model->history_log("pendaftaran", "I", "Insert Data Formulir ".$form_id." | ".$this->input->post('txt_no_formulir')." | ".$this->input->post('txt_nama'));
			
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * update model
	 */
	function update() {
		//if status kembali
		if ($this->input->post('ddl_status') == "1") {
			$tgl_kembali = date('Y-m-d');
		} else {
			$tgl_kembali = NULL;
		}
		
		$arr_data = array(
						'form_nomor' => $this->input->post('txt_no_formulir'),
						'form_nama' => strtoupper($this->input->post('txt_nama')),
						'form_alamat' => strtoupper($this->input->post('txt_alamat')),
						'form_camat' => $this->input->post('txt_kode_camat'),
						'form_lurah' => $this->input->post('txt_kode_lurah'),
						'form_tgl_kirim' => format_tgl($this->input->post('txt_tgl_kirim')),
						'operator_id' => $this->session->userdata('USER_ID'),
						'tgl_proses' => date('Y-m-d H:i:s'),
						'form_tgl_kembali' => $tgl_kembali,
						'form_status' => $this->input->post('ddl_status')
					);	
			
		$this->db->where('form_id', $this->input->post('form_id'));
		$this->db->update('formulir', $arr_data);
		
		if ($this->db->affected_rows()) {
			//insert history log ($module, $action, $description)
			$this->common_model->history_log("pendaftaran", "U", "Update Data Formulir ".$this->input->post('form_id')." | ".$this->input->post('txt_no_formulir')." | ".$this->input->post('txt_nama'));
			
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * delete data formulir
	 * @param unknown_type $id
	 */
	function delete($id) {
		$this->db->where('form_id', $id);
		$this->db->delete('formulir');

		if ($this->db->affected_rows() > 0) {
			$this->common_model->history_log("pendaftaran", "D", "Delete Data Formulir id $id");
			
			return true;
		} else {
			return false;
		}
	}
}