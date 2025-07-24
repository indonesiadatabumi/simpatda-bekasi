<?php 
/**
 * class Rekening_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121028
 */
class Rekening_model extends CI_model {
	/**
	 * get list data
	 */
	function get_grid_list() {
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' koderek,jenis,klas ';
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
	
		$where = "WHERE korek_id IS NOT NULL";
		if ($query) $where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
			$koderek = $this->input->get('koderek');
		if ($koderek != "")
			$where .= " AND koderek = '$koderek'";
		
		$total = $this->adodb->GetOne("SELECT count('korek_id') FROM v_kode_rekening_pajak_detail $where");
		$sql = "SELECT korek_id,koderek,korek_nama,jenis,klas,korek_persen_tarif,korek_tarif_dsr 
						FROM v_kode_rekening_pajak_detail 
						$where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$fmt_koderek = $row->koderek;
                if (!empty($row->jenis)) { $fmt_koderek .= ".".$row->jenis; }
                if (!empty($row->klas)) { $fmt_koderek .= ".".$row->klas; }
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$counter,
									"<a href=\"#\" onclick=\"isChosen('$row->korek_id','$fmt_koderek','$row->korek_nama',
														'$row->korek_tarif_dsr','$row->korek_persen_tarif');\">".$fmt_koderek."</a>",
									addslashes($row->korek_nama),
									number_format ($row->korek_tarif_dsr, 2,',','.'),
									$row->korek_persen_tarif
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
	 * get_rekening_list : 5 digit rekening
	 */
	function get_rekening_list() {
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' koderek,jenis,klas ';
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
	
		$where = "WHERE korek_id IS NOT NULL";
		if ($query) $where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
			$koderek = $this->input->get('koderek');
		if ($koderek != "")
			$where .= " AND koderek = '$koderek'";
		
		$total = $this->adodb->GetOne("SELECT count('korek_id') FROM v_kode_rekening_pajak5digit $where");
		$sql = "SELECT korek_id,koderek,korek_nama,jenis,klas,korek_persen_tarif,korek_tarif_dsr 
						FROM v_kode_rekening_pajak5digit 
						$where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$fmt_koderek = $row->koderek;
                if (!empty($row->jenis)) { $fmt_koderek .= ".".$row->jenis; }
                if (!empty($row->klas)) { $fmt_koderek .= ".".$row->klas; }
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$counter,
									"<a href=\"#\" onclick=\"isChosen('$row->korek_id','$fmt_koderek','$row->korek_nama',
														'$row->korek_tarif_dsr','$row->korek_persen_tarif');\">".$row->koderek."</a>",
									addslashes($row->korek_nama),
									number_format ($row->korek_tarif_dsr, 2,',','.'),
									$row->korek_persen_tarif
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
	 * get array list rekening data
	 */
	function get_arr_list($koderek, $result_array = FALSE) {
		if ($koderek != "") {
			$this->db->where('koderek', $koderek);
		}
		$query = $this->db->get('v_kode_rekening_pajak_detail');
		$total = $query->num_rows();
		
		$result = array();
		if ($total > 0) {
			if ($result_array) {
				foreach ($query->result() as $row) {
					$result[$row->korek_id.",".$row->korek_persen_tarif.",".$row->korek_tarif_dsr] = "(".$row->koderek_titik.") ".$row->korek_nama;
				}
			} else {
				$list = array();
				foreach ($query->result() as $row) {
					$list[] = array(
								"key" => $row->korek_id.",".$row->korek_persen_tarif.",".(1 * $row->korek_tarif_dsr),
								"value" => "(".$row->koderek_titik.") ".$row->korek_nama
							);
				}
				
				$result = array('total' => $total,
						'list' => $list);
			}
			
		}
		
		return $result;
	}
	
	/**
	 * get rekening retribusi
	 */
	function get_rekening_retribusi() {
		$sql = "SELECT *
				FROM v_kode_rekening_pajak_detail
				WHERE korek_jenis != '1'";
		$query = $this->db->query($sql);
		$total = $query->num_rows();
		
		$result = array();
		if ($total > 0) {
			$list = array();
			foreach ($query->result() as $row) {
				$list[] = array(
							"key" => $row->korek_id.",".$row->korek_persen_tarif.",".(1 * $row->korek_tarif_dsr),
							"value" => "(".$row->koderek_titik.") ".$row->korek_nama
						);
			}
			
			$result = array('total' => $total,
					'list' => $list);			
		}
		
		return $result;
	}
	
	/**
	 * find rekening
	 */
	function find_rekening() {
		$koderek = $this->input->post("korek");
		$where = "WHERE koderek='$koderek'";
		
		if ($this->input->post('korek_rincian') != "")
			$where .= " AND jenis='".$this->input->post('korek_rincian')."'";
		
		if ($this->input->post('korek_sub1') != "")
			$where .= " AND klas='".$this->input->post('korek_sub1')."'";
			
		$sql = "SELECT korek_id,koderek,korek_nama,jenis,klas,korek_persen_tarif,korek_tarif_dsr, koderek_titik  
					FROM v_kode_rekening_pajak_detail 
					$where";
		
		$query = $this->db->query($sql);			
		
		if ($query->num_rows() > 0) {
			return $query->row_array(0);
		} else {
			return false;
		}
	}
}