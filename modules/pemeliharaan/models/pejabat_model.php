<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Pejabat_model
 * @author	Daniel
 * @version 20130128
 */

class Pejabat_model extends CI_Model {
	/**
	 * get list pejabat
	 */
	function get_list() {
		/* tables and relations sesuaikan*/
		$tables = " v_pejabat_daerah ";
		$relations = "";
	
		/* sorting sesuaikan*/
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' pejda_kode ';
		if (!$sortorder) $sortorder = 'desc';
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
	
		
		$where = "";
		if ($query) 
			$where = " WHERE CAST($qtype AS TEXT) ~~* '%$query%' ";
	
		$sql = "SELECT * FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('pejda_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (								
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="pejda_id[]" value="'.$row->pejda_id.'" 
									onclick="isChecked('.$counter.','.$row->pejda_id.');" />',
								addslashes($row->pejda_id),
								$row->pejda_kode,
								"<a href='#' onclick=\"editData('".$row->pejda_id."')\">".$row->pejda_nama."</a>",
								addslashes($row->ref_japeda_nama),
								$row->ref_goru_ket,
								$row->pejda_nip,
								addslashes($row->ref_stajab_ket)
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
	 * insert new data
	 */
	function insert() {
		$record = array();
		$record["pejda_kode"] = $this->input->post('pejda_kode');
		$record["pejda_nama"] = $this->input->post('pejda_nama');
		$record["pejda_nip"]  = $this->input->post('pejda_nip');
		$record["pejda_jabatan"]   = $this->input->post('pejda_jabatan');
		$record["pejda_aktif"]     = $this->input->post('pejda_aktif');
		$record["pejda_pangkat"]   = $this->input->post('pejda_pangkat');
		$record["pejda_gol_ruang"] = $this->input->post('pejda_gol_ruang');
		$record["pejda_ttd"]       = $this->input->post('pejda_ttd');
		
		$this->db->insert('pejabat_daerah', $record);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * update pejabat
	 */
	function update() {
		$record = array();
		$record["pejda_kode"] = $this->input->post('pejda_kode');
		$record["pejda_nama"] = $this->input->post('pejda_nama');
		$record["pejda_nip"]  = $this->input->post('pejda_nip');
		$record["pejda_jabatan"]   = $this->input->post('pejda_jabatan');
		$record["pejda_aktif"]     = $this->input->post('pejda_aktif');
		$record["pejda_pangkat"]   = $this->input->post('pejda_pangkat');
		$record["pejda_gol_ruang"] = $this->input->post('pejda_gol_ruang');
		$record["pejda_ttd"]       = $this->input->post('pejda_ttd');
		
		$this->db->where('pejda_id', $this->input->post('pejda_id'));
		$this->db->update('pejabat_daerah', $record);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * delete data pejabat
	 */
	function delete($id) {
		$this->db->where('pejda_id', $id);
		$this->db->delete('pejabat_daerah');
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}