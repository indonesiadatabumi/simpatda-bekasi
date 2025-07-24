<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Satuan_kerja_model
 * @author	Daniel
 */

class Satuan_kerja_model extends CI_Model {
	/**
	 * get list kecamatan
	 */
	function get_list() {
		$tables = " v_skpd ";
		$relations = "";

		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' skpd_id ';
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
		$total = $this->adodb->GetOne("SELECT count(skpd_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->skpd_id),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="skpd_id[]" value="'.$row->skpd_id.'" 
									onclick="isChecked('.$counter.','.$row->skpd_id.');" />',
								($row->skpd_simpatda_id) ? "<a href='#' onclick=\"disableInstansi('".$row->skpd_id."')\"><img src=assets/images/tick.png></a>"
									: "<a href='#' onclick=\"enableInstansi('".$row->skpd_id."')\"><img src=assets/images/untick.png></a>",
								"(".$row->ref_urus_id.") ".$row->ref_urus_nama,
								"(".$row->bdg_kode.") ".$row->bdg_nama,
								$row->skpd_kode,
								"<a href='#' onclick=\"editSatuanKerja('".$row->skpd_id."')\">".$row->skpd_nama."</a>",									
								$row->skpd_npwp,
								$row->skpd_bidang_tambahan,
								$row->skpd_lokasi
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
	 * insert data satuan kerja
	 */
	function insert() {
		$arr_insert = array(
					'skpd_kode' => $_POST['skpd_kode'],
					'skpd_nama' => $_POST['skpd_nama'],
					'skpd_nama2' => $_POST['skpd_nama2'],
					'skpd_singkatan' => $_POST['skpd_singkatan'],
					'skpd_id_bidang' => $_POST['skpd_id_bidang']
				);
	
		$this->db->insert('skpd', $arr_insert);
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * update satuan kerja
	 */
	function update() {
		$arr_update = array(
						'skpd_kode' => $_POST['skpd_kode'],
						'skpd_nama' => $_POST['skpd_nama'],
						'skpd_nama2' => $_POST['skpd_nama2'],
						'skpd_singkatan' => $_POST['skpd_singkatan'],
						'skpd_id_bidang' => $_POST['skpd_id_bidang']
					);
		$this->db->where('skpd_id', $_POST['skpd_id']);
		$this->db->update('skpd', $arr_update);
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * delete satuan kerja
	 * @param unknown_type $id
	 */
	function delete($id) {
		$this->db->where('skpd_id', $id);
		$this->db->delete('skpd');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * set instansi simpatda
	 * @param unknown_type $status
	 * @param unknown_type $skpd_id
	 */
	function instansi($status, $skpd_id) {
		$record = array();
		$find_skpd = $this->adodb->GetAll("SELECT * from skpd_simpatda");
		
		if ($status == 'true') {
        	$record['skpd_simpatda_id'] = $skpd_id;
			if (!empty($find_skpd)) {
				$updateSQL = $this->adodb->Execute("UPDATE skpd_simpatda SET skpd_simpatda_id=$skpd_id");
			}
			else {
				$insertSQL = $this->adodb->AutoExecute('skpd_simpatda', $record, 'INSERT');
			}
		}
		else {
			if (!empty($find_skpd))
			$updateSQL = $this->adodb->Execute("UPDATE skpd_simpatda SET skpd_simpatda_id=0");
		}
		
		return TRUE;
	}
}