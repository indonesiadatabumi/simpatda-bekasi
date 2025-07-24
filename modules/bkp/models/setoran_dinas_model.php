<?php 
/**
 * class Setoran_dinas_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Setoran_dinas_model extends CI_Model {
	
	/**
	 * get list setoran
	 */
	function get_list_setoran() {
		$tables = " v_setoran_lain ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' slh_id ';
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
	
		$where = " WHERE slh_id IS NOT NULL";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT DISTINCT slh_id, slh_tahun, slh_tgl, slh_satuan_kerja, skpd_nama, slh_dari, slh_keterangan, slh_jumlah
				FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count(DISTINCT slh_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->slh_id,
									$counter,
									'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="slh_id[]" value="'.$row->slh_id.'" 
										onclick="isChecked('.$counter.','.$row->slh_id.');" />',
									$row->slh_tahun,
									format_tgl($row->slh_tgl),
									$row->skpd_nama,
									$row->slh_dari,
									$row->slh_keterangan,
									format_currency($row->slh_jumlah)
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
	 * save setoran dinas
	 */
	function save() { 
		//insert setoran lain header
		$slh_id = $this->common_model->next_val('setoran_lain_header_slh_id_seq');
		$arr_header = array(
						'slh_id' => $slh_id,
						'slh_tahun' => $this->input->post('spt_periode'),
						'slh_tgl' => format_tgl($this->input->post('tanggal_setor')),
						'slh_satuan_kerja' => $this->input->post('ddl_dinas'),
						'slh_dari' => $this->input->post('txt_dari'),
						'slh_keterangan' => $this->input->post('txt_keterangan'),
						'slh_jumlah' => unformat_currency($this->input->post('txt_setoran')),
						'slh_created_by' => $this->session->userdata('USER_NAME')
					); 
		$this->db->insert('setoran_lain_header', $arr_header);
		
		if ($this->db->affected_rows() > 0) {
			//insert into setoran lain detail
			if (!empty($_POST['ddl_korek'])) {
				foreach ($_POST['ddl_korek'] as $key => $value) {
					if (!empty($value)) {
						$setoran = unformat_currency($_POST['txt_dt_setoran'][$key]);
						$korek = $_POST['ddl_korek'][$key];
						$arr_korek = explode(',', $korek);
						
						$sld_id = $this->common_model->next_val('setoran_lain_detail_sld_id_seq');
						$arr_detail = array(
								'sld_id' => $sld_id,
								'sld_id_header' => $slh_id,
								'sld_id_rekening' => $arr_korek[0],
								'sld_jlh_setor' => $setoran
							);
							
						$this->db->insert('setoran_lain_detail', $arr_detail);
					}
				}
			}
			
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * update header
	 * @param unknown_type $slh_id
	 */
	function update_header($slh_id) {
		$arr_header = array(
						'slh_tahun' => $this->input->post('spt_periode'),
						'slh_tgl' => format_tgl($this->input->post('tanggal_setor')),
						'slh_satuan_kerja' => $this->input->post('ddl_dinas'),
						'slh_dari' => $this->input->post('txt_dari'),
						'slh_keterangan' => $this->input->post('txt_keterangan'),
						'slh_jumlah' => unformat_currency($this->input->post('txt_setoran')),
						'slh_created_by' => $this->session->userdata('USER_NAME')
					); 
		$this->db->where('slh_id', $slh_id);
		$this->db->update('setoran_lain_header', $arr_header);
		
		if ($this->db->affected_rows() > 0) 
			return true;
		else
			return false;
	}
	
	/**
	 * update detail
	 * @param unknown_type $slh_id
	 */
	function update_detail($slh_id) {
	//insert into spt_detail
		if (!empty($_POST['ddl_korek'])) {
			$list_id = "";
			
			foreach ($_POST['ddl_korek'] as $key => $value) {
				if (!empty($value)) {
					$sld_id = @$_POST['sld_id'][$key];
					
					if (!empty($sld_id)) {
						$arr_korek = explode(",", $_POST['ddl_korek'][$key]);
						$setoran = unformat_currency($_POST['txt_dt_setoran'][$key]);
						
						$arr_detail = array(
								'sld_id_header' => $slh_id,
								'sld_id_rekening' => $arr_korek[0],
								'sld_jlh_setor' => $setoran
							);
						$this->db->where('sld_id', $sld_id);
						$this->db->update('setoran_lain_detail', $arr_detail);
					} else {
						$arr_korek = explode(",", $_POST['ddl_korek'][$key]);
						$setoran = unformat_currency($_POST['txt_dt_setoran'][$key]);
						
						$sld_id = $this->common_model->next_val('setoran_lain_detail_sld_id_seq');
						$arr_detail = array(
								'sld_id' => $sld_id,
								'sld_id_header' => $slh_id,
								'sld_id_rekening' => $arr_korek[0],
								'sld_jlh_setor' => $setoran
							);
						$this->db->insert('setoran_lain_detail', $arr_detail);
					}
					
					if($list_id != "") 
						$list_id .= ",".$sld_id;
					else 
						$list_id = $sld_id;
				}
			}
		
			//delete from database
			$delete = "DELETE FROM setoran_lain_detail WHERE sld_id NOT IN ($list_id) AND sld_id_header=$slh_id";
			$this->adodb->Execute($delete);
		} else {
			//delete from database
			$delete = "DELETE FROM setoran_lain_detail WHERE sld_id_header=$slh_id";
			$this->adodb->Execute($delete);
		}
		
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	
	/**
	 * get header setoran dinas
	 */
	function get_header($slh_id) {
		$query = $this->db->get_where('setoran_lain_header', array('slh_id' => $slh_id));

		return $query->row();
	}
	
	/**
	 * get detail setoran dinas
	 * @param unknown_type $slh_id
	 */
	function get_detail($slh_id) {
		$query = $this->db->query("SELECT * FROM setoran_lain_detail WHERE sld_id_header = $slh_id");

		return $query;
	}
	
	/**
	 * delete setoran dinas
	 */
	function delete($id) {
		$this->db->delete('setoran_lain_header', array('slh_id' => $id));
		if ($this->db->affected_rows() > 0) {
			$this->db->delete('setoran_lain_detail', array('sld_id_header' => $id));
			
			return true;
		} else {
			return false;
		}
	}
}