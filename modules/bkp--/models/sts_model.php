<?php 
/**
 * class Sts_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Sts_model extends CI_Model {
	
	function get_list($f_date = NULL, $t_date = NULL) {
		$tables = " setoran_ke_bank_header ";
	
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
	
		$spt_periode = $this->input->get('spt_periode');
		$spt_jenis_pajak = $this->input->get('spt_jenis_pajakretribusi');
		$where = " WHERE skbh_id IS NOT NULL";
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
			
		if (!empty($f_date) && !empty($t_date)) {
			$where .= " AND skbh_tgl BETWEEN '".format_tgl($f_date)."' AND '".format_tgl($t_date)."'";
		}
	
		$sql = "SELECT *
				FROM $tables $where $sort $limit";
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('skbh_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				if ($row->skbh_validasi == 'f')
					$validasi = '<input type="image" src="assets/images/tick.png" id="btn_validasi'.$row->skbh_id.'" alt="Validasi" title="Validasi" style="cursor: pointer;" onclick="validasiSTS('.$row->skbh_id.')">';
				else 
					$validasi = "";
					
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->skbh_id,
									$counter,
									'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="skbh_id[]" value="'.$row->skbh_id.'" 
										onclick="isChecked('.$counter.','.$row->skbh_id.');" />',
									$row->skbh_no,
									format_tgl($row->skbh_tgl),
									$row->skbh_nama,
									$row->skbh_alamat,
									format_currency($row->skbh_jumlah),
									$validasi,
									'<input type="image" size="2" src="assets/images/printer.png" alt="Cetak" title="Cetak" style="cursor: pointer;" onclick="cetakSTS('.$row->skbh_id.')">'
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
	 * get sspd data
	 */
	function get_setoran_detail($setor_id) {
		$sql = "SELECT *
				FROM v_setoran_pajak_retribusi 
				WHERE setorpajret_id='$setor_id'
				ORDER BY setorpajret_id ASC";
		//echo $sql;
		$arr_data = $this->adodb->GetAll($sql);
		return $arr_data;
	}
	
	function get_setoran_ke_bank($id) {
		$sql = "SELECT *
				FROM v_sts
				WHERE skbh_id=$id
				ORDER BY koderek ASC";
		
		$arr_data = $this->adodb->GetAll($sql);
		return $arr_data;
	}
	
	/**
	 * validasi sts
	 * @param unknown_type $skbh_id
	 */
	function validasi($skbh_id) {
		if (empty($skbh_id))
			return false;
			
		$arr_update = array(
					'skbh_validasi' => 't',
					'skbh_validasi_tanggal' => 'NOW()',
					'skbh_validasi_oleh' => $this->session->userdata('USER_NAME')
				);
		$this->db->where('skbh_id', $skbh_id);
		$this->db->update('setoran_ke_bank_header', $arr_update);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * get daftar sts
	 * @param unknown_type $f_date
	 * @param unknown_type $t_date
	 */
	function list_daftar_sts($f_date, $t_date) {
		$where = "";
		if ($f_date != "" || $t_date != "")
			$where = " WHERE skbh_tgl BETWEEN '".format_tgl($f_date)."' AND '".format_tgl($t_date)."'";
			
		$sql = "SELECT * FROM setoran_ke_bank_header $where ORDER BY skbh_tgl DESC, skbh_id DESC";
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	function get_data_pembayaran_sptpd($npwprd, $kode_billing){
		$query = $this->db->get_where('payment.pembayaran_sptpd', array('npwprd' => $npwprd, 'kode_billing' => $kode_billing));
		return  $query->num_rows();
	}
	
	/**
	 * delete sts
	 * @param unknown_type $id
	 */
	function delete($id) {
		$query = $this->db->get_where('setoran_ke_bank_header', array('skbh_id' => $id));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			
			if ($this->session->userdata('USER_JABATAN') == "98" || $this->session->userdata('USER_JABATAN') == "99") {
					$this->db->where('skbh_id', $id);
					$this->db->delete('setoran_ke_bank_header');
					
					//delete detail
					if ($this->db->affected_rows() > 0) {
						$this->db->where('skbd_id_header', $id);
						$this->db->delete('setoran_ke_bank_detail');
						
						return true;
					}					
					else
						return false;			
			} else {
				if ($row->skbh_validasi == "f") {
					$this->db->where('skbh_id', $id);
					$this->db->delete('setoran_ke_bank_header');
					
					//delete detail
					if ($this->db->affected_rows() > 0) {
						$this->db->where('skbd_id_header', $id);
						$this->db->delete('setoran_ke_bank_detail');
						
						return true;
					}					
					else
						return false;
				} else {
					return false;
				}
			}		
		} else {
			return false;
		}
		
		
	}
}