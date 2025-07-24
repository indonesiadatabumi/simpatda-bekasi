<?php 
/**
 * class Daftar_setoran_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Daftar_setoran_model extends CI_Model {
	/**
	 * get data setoran model 
	 */
	function get_data() {
		$type = $this->input->get('type');
		
		if ($type == "1") {
			$where = "WHERE netapajrek_id_spt IS NOT NULL";
			
			if (!empty($_GET['fDate']) && !empty($_GET['tDate'])) {
				$where .= " AND skbh_tgl BETWEEN '".format_tgl($_GET['fDate'])."' AND '".format_tgl($_GET['tDate'])."'";
			} elseif (!empty($_GET['fDate'])) {
				$where .= " AND skbh_tgl = '".format_tgl($_GET['fDate'])."'";
			} elseif (!empty($_GET['tDate'])) {
				$where .= " AND skbh_tgl = '".format_tgl($_GET['tDate'])."'";
			}
			
			if (!empty($_GET['jenis_pajak'])) {
				$where .= " AND spt_jenis_pajakretribusi=".$_GET['jenis_pajak'];
			}
				
			if ($this->session->userdata('USER_SPT_CODE') == "10")
				$where .= " AND spt_kode='".$this->session->userdata('USER_SPT_CODE')."'";	
		} else {
			$where = "WHERE netapajrek_id_spt IS NOT NULL";
			
			$where .= " AND date_part('month',netapajrek_tgl)=".$_GET['bulan_ketetapan']." AND date_part('year', netapajrek_tgl)=".$_GET['tahun_ketetapan'];
			
			if (!empty($_GET['jenis_pajak'])) {
				$where .= " AND spt_jenis_pajakretribusi=".$_GET['jenis_pajak'];
			}
				
			if ($this->session->userdata('USER_SPT_CODE') == "10")
				$where .= " AND spt_kode='".$this->session->userdata('USER_SPT_CODE')."'";	
				
			if ($_GET['jenis_daftar'] == "1")
				$where .= " AND skbh_tgl IS NOT NULL";
			elseif ($_GET['jenis_daftar'] == "2") {
				$where .= " AND skbh_tgl IS NULL";
			}
		}
		
		$order_by = " ORDER BY netapajrek_kohir ASC";
		
		$sql = "SELECT a.*, b.korek_nama as korek_nama_detail, c.sptrek_judul, d.skbh_tgl, d.setorpajret_dt_jumlah
					FROM v_daftar_ketetapan_list a 
					INNER JOIN v_spt_detail b ON a.netapajrek_id_spt=b.spt_dt_id_spt
					LEFT JOIN spt_reklame c ON b.spt_dt_id=c.sptrek_id_spt_dt 
					LEFT JOIN v_rekapitulasi_penerimaan_detail d ON a.spt_idwpwr = d.setorpajret_id_wp AND a.spt_periode = d.setorpajret_spt_periode 
							AND a.spt_nomor = d.setorpajret_no_spt AND a.spt_jenis_pajakretribusi = d.setorpajret_jenis_pajakretribusi 
							AND a.spt_status = d.setorpajret_jenis_ketetapan
					$where $order_by";
		//echo $sql;
		$result = $this->adodb->GetAll($sql);
		return $result;
	}
}