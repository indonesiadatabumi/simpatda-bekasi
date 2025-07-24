<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Kode_rekening_model
 * @author	Daniel
 */

class Kode_rekening_model extends CI_Model {
	/**
	 * get list kode rekening
	 */
	function get_list() {
		$tables = " v_kode_rekening ";
		$relations = "";

		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' korek_id ';
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
		$total = $this->adodb->GetOne("SELECT count(korek_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
							"id"	=> $counter,
							"cell"	=> array (
								addslashes($row->korek_id),
								$counter,
								'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="korek_id[]" value="'.$row->korek_id.'" 
									onclick="isChecked('.$counter.','.$row->korek_id.');" />',
								($row->korek_status_aktif == 't') ? "<a href='#' onclick=\"disableKorek('".$row->korek_id."')\"><img src=assets/images/tick.png></a>"
									: "<a href='#' onclick=\"enableKorek('".$row->korek_id."')\"><img src=assets/images/untick.png></a>",
								$row->korek_tipe,
								$row->korek_kelompok,
								$row->korek_jenis,
								$row->korek_objek,
								$row->jenis,
								$row->klas,
								$row->korek_sub2,
								$row->korek_sub3,
								"<a href='#' onclick=\"editData('".$row->korek_id."')\">".$row->korek_nama."</a>",
								$row->ref_kakorek_ket,
								$row->korek_persen_tarif,
								(real)$row->korek_tarif_dsr,
								$row->korek_vol_dsr,
								$row->korek_tarif_tambah,
								$row->dahukorek_no_perda,
								$row->dahukorek_tgl_perda
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
	 * insert data kode rekening
	 */
	function insert() {
		$korek_rincian = $_POST['korek_rincian'];
		if (empty($korek_rincian) || trim($korek_rincian) == "") { $korek_rincian = "00"; }
		$korek_sub1 = $_POST['korek_sub1'];
		if (empty($korek_sub1) || trim($korek_sub1) == "") { $korek_sub1 = "00"; }
		
		$arr_insert = array(
					'korek_tipe' => $_POST['korek_tipe'],
					'korek_kelompok' => $_POST['korek_kelompok'],
					'korek_jenis' => $_POST['korek_jenis'],
					'korek_objek' => $_POST['korek_objek'],
					'korek_rincian' => $korek_rincian,
					'korek_sub1' => $korek_sub1,
					'korek_sub2' => $_POST['korek_sub2'],
					'korek_sub3' => $_POST['korek_sub3'],
					'korek_nama' => $_POST['korek_nama'],
					'korek_kategori' => $_POST['korek_kategori'],
					'korek_persen_tarif' => ($_POST['korek_persen_tarif'] != '') ? $_POST['korek_persen_tarif'] : 0,
					'korek_tarif_dsr' => ($_POST['korek_tarif_dsr'] != '') ? $_POST['korek_tarif_dsr'] : NULL,
					'korek_vol_dsr' => ($_POST['korek_vol_dsr'] != '') ? $_POST['korek_vol_dsr'] : NULL,
					'korek_tarif_tambah' => ($_POST['korek_tarif_tambah'] != '') ? $_POST['korek_tarif_tambah'] : NULL,
					'korek_id_hukum' => ($_POST['korek_id_hukum'] != '' ? $_POST['korek_id_hukum'] : NULL),
					'korek_kategori' => $_POST['korek_kategori']
				);
	
		$this->db->insert('kode_rekening', $arr_insert);
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * update kecamatan
	 */
	function update() {
		$korek_rincian = $_POST['korek_rincian'];
		if (empty($korek_rincian) || trim($korek_rincian) == "") { $korek_rincian = "00"; }
		$korek_sub1 = $_POST['korek_sub1'];
		if (empty($korek_sub1) || trim($korek_sub1) == "") { $korek_sub1 = "00"; }
		
		$arr_update = array(
						'korek_tipe' => $_POST['korek_tipe'],
						'korek_kelompok' => $_POST['korek_kelompok'],
						'korek_jenis' => $_POST['korek_jenis'],
						'korek_objek' => $_POST['korek_objek'],
						'korek_rincian' => $korek_rincian,
						'korek_sub1' => $korek_sub1,
						'korek_sub2' => $_POST['korek_sub2'],
						'korek_sub3' => $_POST['korek_sub3'],
						'korek_nama' => $_POST['korek_nama'],
						'korek_kategori' => $_POST['korek_kategori'],
						'korek_persen_tarif' => ($_POST['korek_persen_tarif'] != '') ? $_POST['korek_persen_tarif'] : 0,
						'korek_tarif_dsr' => ($_POST['korek_tarif_dsr'] != '') ? $_POST['korek_tarif_dsr'] : NULL,
						'korek_vol_dsr' => ($_POST['korek_vol_dsr'] != '') ? $_POST['korek_vol_dsr'] : NULL,
						'korek_tarif_tambah' => ($_POST['korek_tarif_tambah'] != '') ? $_POST['korek_tarif_tambah'] : NULL,
						'korek_id_hukum' => ($_POST['korek_id_hukum'] != '' ? $_POST['korek_id_hukum'] : NULL),
						'korek_kategori' => $_POST['korek_kategori']
					);
		$this->db->where('korek_id', $_POST['korek_id']);
		$this->db->update('kode_rekening', $arr_update);
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
	
	/**
	 * delete keterangan_spt
	 * @param unknown_type $id
	 */
	function delete($id) {
		$this->db->where('korek_id', $id);
		$this->db->delete('kode_rekening');
		
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}
	
	/**
	 * update status aktif kode rekening
	 * @param unknown_type $status
	 * @param unknown_type $korek_id
	 */
	function update_status_aktif($status, $korek_id) {
		$arr_update = array(
						'korek_status_aktif' => $status
					);
		$this->db->where('korek_id', $korek_id);
		$this->db->update('kode_rekening', $arr_update);
	}
}