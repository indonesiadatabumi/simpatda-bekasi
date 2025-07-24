<?php 
/**
 * class Pajak_hotel_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121022
 */
class Pajak_hotel_model extends CI_Model {
	/**
	 * get list data
	 */
	function get_list() {
		//$tables = " v_spt a LEFT JOIN penetapan_pajak_retribusi b ON b.netapajrek_id_spt=a.spt_id
		//				LEFT JOIN setoran_pajak_retribusi c ON a.spt_id = c.setorpajret_id_penetapan AND c.setorpajret_jenis_ketetapan=a.spt_status ";
		$tables = "v_spt vspt
					LEFT JOIN penetapan_pajak_retribusi ppr ON ppr.netapajrek_id_spt=vspt.spt_id
			        LEFT JOIN v_rekapitulasi_penerimaan vrp ON vspt.spt_id = vrp.setorpajret_id_spt AND vspt.spt_status=vrp.setorpajret_jenis_ketetapan
						AND vspt.spt_jenis_pajakretribusi=vrp.setorpajret_jenis_pajakretribusi
			    	LEFT JOIN keterangan_spt ket ON ket.ketspt_id = spt_status AND spt_status = ket.ketspt_id";
	
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
	
		$where = " WHERE spt_jenis_pajakretribusi='".$this->config->item('jenis_pajak_hotel')."'";
		
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$where .= " AND camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT DISTINCT spt_id, spt_jenis_pajakretribusi, 
                    ket.ketspt_id, ref_jenparet_ket, ket.ketspt_singkat, 
                    ket.ketspt_ket, spt_nomor, spt_periode, 
                    spt_idwpwr, npwprd, wp_wr_nama, wp_wr_almt, 
                    wp_wr_lurah, wp_wr_camat, wp_wr_kabupaten, 
                    spt_jenis_pemungutan, ref_jenput_ket, 
                    spt_tgl_proses, spt_tgl_entry, 
                    spt_periode_jual1, spt_periode_jual2, 
                    spt_kode_rek, koderek, korek_nama, 
                    spt_pajak, spt_tgl_terima, spt_tgl_bts_kembali
                    netapajrek_tgl, netapajrek_kohir, netapajrek_tgl_jatuh_tempo,
               			setorpajret_tgl_bayar, setorpajret_jlh_bayar
				FROM $tables $where $sort $limit";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count(DISTINCT spt_id) FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->spt_id,
									$counter,
									'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="spt_id[]" value="'.$row->spt_id.'" 
										onclick="isChecked('.$counter.','.$row->spt_id.');" />',
									addslashes($row->ref_jenput_ket),
									"<a href='#' onclick=\"editData('".$row->spt_id."', '".$row->spt_jenis_pajakretribusi."')\">".$row->spt_nomor."</a>",
									$row->spt_periode,
									$row->npwprd,
									$row->wp_wr_nama,
									format_currency($row->spt_pajak),
									//penetapan dan penyetoran
									$row->ketspt_singkat,
									format_tgl($row->netapajrek_tgl),
									$row->netapajrek_kohir,
									format_tgl($row->netapajrek_tgl_jatuh_tempo),
									format_tgl($row->setorpajret_tgl_bayar),
									format_currency($row->setorpajret_jlh_bayar)
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
}