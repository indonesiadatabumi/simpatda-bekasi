<?php 
/**
 * class Penetapan_lhp_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Penetapan_lhp_model extends CI_Model {
	
	function get_ketetapan_id() {
		$kohir1 = $this->input->get('no_kohir1');
		$kohir2 = $this->input->get('no_kohir2');
		$periode = $this->input->get('tahun');
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$jenis_ketetapan = $this->input->get('jenis_ketetapan');
		$netapajrek_tgl = $this->input->get('netapajrek_tgl');
		
		$where = "WHERE netapajrek_id IS NOT NULL AND netapajrek_jenis_ketetapan='".$jenis_ketetapan."' AND netapajrek_kohir BETWEEN '".$kohir1."' AND '".$kohir2."'";
		
		if (!empty($spt_jenis_pajakretribusi)) 
			$where .= " AND lhp_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."'";
		
		if (!empty($periode))
			$where .= " AND lhp_periode='".$periode."'";
		
		if (!empty($netapajrek_tgl))
			$where .= " AND netapajrek_tgl='".format_tgl($netapajrek_tgl)."'";
			
		$order_by = " ORDER BY netapajrek_kohir ASC";
		
		$sql = "SELECT DISTINCT netapajrek_id, netapajrek_kohir FROM v_penetapan_lhp $where $order_by";
		//echo $sql;
		$ar_cari = $this->adodb->GetAll($sql);
		return $ar_cari;
	}
	
	function get_ketetapan_by_id($netapajrek_id) {
		$where = " WHERE a.netapajrek_id = '$netapajrek_id'";
		
		$sql = "SELECT a.*, b.lhp_kode_billing, b.lhp_no_periksa FROM v_penetapan_lhp a left join laporan_hasil_pemeriksaan b ON a.lhp_id=b.lhp_id $where";
		// echo $sql;die;
		$ar_cari = $this->adodb->GetAll($sql);
		return $ar_cari;
	}
	
	function get_min_max_masa_pajak($netapajrek_id) {
		$where = " WHERE netapajrek_id = '$netapajrek_id'";
		
		$sql = "SELECT MIN(lhp_dt_periode1) lhp_dt_periode1, MAX(lhp_dt_periode1) lhp_dt_periode2 FROM v_penetapan_lhp $where";
		//echo $sql;
		$ar_cari = $this->adodb->GetAll($sql);
		return $ar_cari;
	}
	
	/**
	 * get ketetapan
	 */	
	function get_ketetapan() {
		$kohir1 = $this->input->get('no_kohir1');
		$kohir2 = $this->input->get('no_kohir2');
		$periode = $this->input->get('tahun');
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$jenis_ketetapan = $this->input->get('jenis_ketetapan');
		$netapajrek_tgl = $this->input->get('netapajrek_tgl');
		
		$where = "WHERE netapajrek_id IS NOT NULL AND lhp_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."' 
					AND netapajrek_jenis_ketetapan='".$jenis_ketetapan."' AND netapajrek_kohir BETWEEN '".$kohir1."' AND '".$kohir2."'";
		
		if (!empty($periode))
			$where .= " AND lhp_periode='".$periode."'";
		
		if (!empty($netapajrek_tgl))
			$where .= " AND netapajrek_tgl='".format_tgl($netapajrek_tgl)."'";
			
		$order_by = " ORDER BY netapajrek_kohir ASC";
		
		$sql = "SELECT * FROM v_penetapan_lhp $where $order_by";
		//echo $sql;
		$ar_cari = $this->adodb->GetAll($sql);
		return $ar_cari;
	}
}