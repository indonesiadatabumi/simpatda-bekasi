<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Nilai_kelas_jalan_model
 * @author	Daniel
 */

class Nilai_kelas_jalan_model extends CI_Model {
	/**
	 * get list Kelas_jalan
	 */
	function get_list() {
		$tables = " ref_rek_nilai_kelas_jalan,kode_rekening,ref_rek_klas_jalan ";
		$relations = " ref_rek_nilai_kelas_jalan.rek_id=kode_rekening.korek_id AND ref_rek_nilai_kelas_jalan.klas_jalan_id=ref_rek_klas_jalan.ref_rkj_id";

		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' id ';
		if (!$sortorder) $sortorder = 'asc';
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
		$total = $this->adodb->GetOne("SELECT count(id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->id),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="id[]" value="'.$row->id.'" 
									onclick="isChecked('.$counter.','.$row->id.');" />',
								$row->korek_nama,
								"<a href='#' onclick=\"editData('".$row->id."')\">".$row->ref_rkj_nama."</a>",
								$row->luas,
								$row->jumlah,
								$row->jangka_waktu,
								format_currency($row->nilai)
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
	 * insert data kecamatan
	 */
	function insert() {
		$sql = "SELECT * FROM ref_rek_nilai_kelas_jalan WHERE rek_id = '".$_POST['rek_id']."' AND klas_jalan_id='".$_POST['klas_jalan_id']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_insert = array(
						'klas_jalan_id' => $_POST['klas_jalan_id'],
						'rek_id' => $_POST['rek_id'],
						'nilai' => unformat_currency($_POST['nilai']),
						'luas' => $_POST['luas'],
						'jumlah' => $_POST['jumlah'],
						'jangka_waktu' => $_POST['jangka_waktu']
					);
		
			$this->db->insert('ref_rek_nilai_kelas_jalan', $arr_insert);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * update kecamatan
	 */
	function update() {
		$sql = "SELECT * FROM ref_rek_nilai_kelas_jalan WHERE rek_id = '".$_POST['rek_id']."' AND klas_jalan_id='".$_POST['klas_jalan_id']."' AND id != '".$_POST['id']."'";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0) {
			return false;
		} else {
			$arr_update = array(
							'klas_jalan_id' => $_POST['klas_jalan_id'],
							'rek_id' => $_POST['rek_id'],
							'nilai' => unformat_currency($_POST['nilai']),
							'luas' => $_POST['luas'],
							'jumlah' => $_POST['jumlah'],
							'jangka_waktu' => $_POST['jangka_waktu']
						);
			$this->db->where('id', $_POST['id']);
			$this->db->update('ref_rek_nilai_kelas_jalan', $arr_update);
			
			if ($this->db->affected_rows() > 0)
				return true;
			else 
				return false;
		}
	}
	
	/**
	 * delete keterangan_spt
	 * @param unknown_type $id
	 */
	function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete('ref_rek_nilai_kelas_jalan');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
}