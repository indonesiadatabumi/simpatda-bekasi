<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Target_anggaran_model
 * @author	Daniel
 */
class Target_anggaran_model extends CI_Model {
	/**
	 * get list status anggaran
	 */
	function get_list($tahang_id) {
		$tables = " v_tahun_anggaran ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		$sort = "ORDER BY kode_rek ASC";
	
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";
		
		$query = $_POST['query'];
		$qtype = $_POST['qtype'];
			
		$where = " WHERE tahangdet_id_header = $tahang_id ";
		if ($query) 
			$where = " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
	
		$sql = "SELECT * FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		//echo $sql;
		$total = $this->adodb->GetOne("SELECT count('tahangdet_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								$row->tahangdet_id,
								$counter,
								'<input type="checkbox" id="cbta'.$counter.'" class="toggle_status_anggaran" name="target[]" value="'.$row->tahangdet_id.'" 
									onclick="isChecked('.$counter.','.$row->tahangdet_id.');" />',
								$row->kode_rek,
								$row->korek_nama,
								format_currency($row->tahangdet_jumlah)
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
	 * get rekening
	 */
	function get_rekening() {
		$sql = "SELECT korek_id, 
					korek_nama,
					case when korek_jenis IS NOT NULL THEN
						case when korek_objek IS NOT NULL THEN
								case when korek_rincian != '00' THEN
											case when korek_sub1 != '00' THEN
												case when korek_sub2 != '00' THEN
												korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text || '.'::text || 
												korek_rincian::text || '.'::text || korek_sub1::text || '.' || korek_sub2::text
												ELSE
												korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text || '.'::text || 
												korek_rincian::text || '.'::text || korek_sub1::text
												END
											ELSE
												korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text || '.'::text || 
												korek_rincian::text
											END
								ELSE
										korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text
								END
						ELSE
							korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text
						END
					ELSE
					korek_tipe::text || '.'::text || korek_kelompok::text
					END AS rekening, 
					korek_tipe, korek_kelompok, korek_jenis, korek_objek, korek_rincian, korek_sub1, korek_sub2, korek_sub3
				FROM kode_rekening
				WHERE korek_tipe='4' AND korek_status_aktif='TRUE'
				ORDER BY rekening";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	/**
	 * get detail
	 * @param unknown_type $id
	 */
	function get_detail($id) {
		$this->db->where('tahangdet_id', $id);
		$query = $this->db->get('tahun_anggaran_detail');
		
		return $query;
	}
	
	/**
	 * insert status keterangan
	 * @param unknown_type $ref_statang_ket
	 */
	function insert() {
		$sql = "SELECT * FROM tahun_anggaran_detail WHERE tahangdet_id_header='".$this->input->post('tahangdet_id_header')."' AND tahangdet_id_rek='".$this->input->post('tahangdet_id_rek')."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_insert = array(
					'tahangdet_id_header' => $this->input->post('tahangdet_id_header'),
					'tahangdet_id_rek' => $this->input->post('tahangdet_id_rek'),
					'tahangdet_jumlah' => unformat_currency($this->input->post('tahangdet_jumlah'))
				);
			$this->db->insert('tahun_anggaran_detail', $arr_insert);
			
			if ($this->db->affected_rows() > 0)
				return TRUE;
			else
				return FALSE;
		}
	}
	
	/**
	 * update status keterangan
	 * @param unknown_type $ref_statang_id
	 * @param unknown_type $ref_statang_ket
	 */
	function update() {
		$sql = "SELECT * FROM tahun_anggaran_detail WHERE tahangdet_id_header='".$this->input->post('tahangdet_id_header')."' 
				AND tahangdet_id_rek='".$this->input->post('tahangdet_id_rek')."' AND tahangdet_id !='".$this->input->post('tahangdet_id')."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {		
			$arr_update = array(
						'tahangdet_id_rek' => $this->input->post('tahangdet_id_rek'),
						'tahangdet_jumlah' => unformat_currency($this->input->post('tahangdet_jumlah'))
					);
			$this->db->where('tahangdet_id', $this->input->post('tahangdet_id'));
			$this->db->update('tahun_anggaran_detail', $arr_update);
			
			if ($this->db->affected_rows() > 0)
				return TRUE;
			else
				return FALSE;
		}
	}
	
	/**
	 * delete status keterangan
	 * @param unknown_type $ref_statang_id
	 */
	function delete($id) {
		$this->db->where('tahangdet_id', $id);
		$this->db->delete('tahun_anggaran_detail');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}