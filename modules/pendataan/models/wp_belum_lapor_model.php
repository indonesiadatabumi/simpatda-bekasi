<?php 
/**
 * class Wp_belum_lapor_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Wp_belum_lapor_model extends CI_Model {
	
	function get_wp_belum_lapor() {
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$sistem_pemungutan = $this->input->get('sistem_pemungutan');
		$kecamatan = $this->input->get('kecamatan');
		$masa_pajak = $this->input->get('masa_pajak');
		$masa_pajak2 = $this->input->get('masa_pajak2');
		$tahun = $this->input->get('tahun');
		$tahun2 = $this->input->get('tahun2');
		$range1 = $tahun."-".$masa_pajak."-01";
		$range2 = $tahun2."-".$masa_pajak2."-01";

		//jika parkir atau hiburan : rekening > 1
		if ($spt_jenis_pajakretribusi == "3" || $spt_jenis_pajakretribusi == "7") {
			$sql_cari = "SELECT DISTINCT a.wp_wr_nama, a.wp_wr_almt, a.npwprd, a.spt_id, a.spt_tgl_proses, a.spt_nomor, a.spt_periode_jual1
				FROM v_spt a 
				LEFT JOIN spt b ON a.spt_id=b.spt_id AND a.spt_kode_billing=b.spt_kode_billing
				WHERE b.tgl_lapor IS NULL";
		} else {
			$sql_cari = "SELECT a.*, c.*
				FROM v_spt a 
				LEFT JOIN spt b ON a.spt_id=b.spt_id AND a.spt_kode_billing=b.spt_kode_billing
				LEFT JOIN spt_detail c ON a.spt_id=c.spt_dt_id_spt
				WHERE b.tgl_lapor IS NULL";
		}			


		if (!empty($spt_jenis_pajakretribusi))
			$sql_cari .= " AND a.spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."'";

		if (!empty($sistem_pemungutan)) 
			$sql_cari .= " AND a.spt_jenis_pemungutan='".$sistem_pemungutan."'";
			
		if (!empty($kecamatan))
			$sql_cari .= " AND a.wp_wr_kd_camat='$kecamatan'";

		if (!empty($masa_pajak))
			$sql_cari .= " AND a.spt_periode_jual1 BETWEEN '$range1' AND '$range2'";	
		
		$sql_cari .= " ORDER BY a.spt_periode_jual1 ASC";
		// echo $sql_cari;die;
		$ar_cari = $this->adodb->GetAll($sql_cari);
		return $ar_cari;
	}
	
	/**
	 * get spt_detail
	 * @param unknown_type $spt
	 */
	function get_sptpd_detail($spt_id) {
		$this->db->from('spt_detail');
		$this->db->where('spt_dt_id_spt', $spt_id);
		$this->db->order_by('spt_dt_id', "asc");
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/**
	 * get daftar sptpd restoran
	 */
	function get_wp_belum_lapor_restoran() {
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$jenis_restoran = $this->input->get('jenis_pajak_restoran');
		$sistem_pemungutan = $this->input->get('sistem_pemungutan');
		$kecamatan = $this->input->get('kecamatan');
		$masa_pajak = $this->input->get('masa_pajak');
		$masa_pajak2 = $this->input->get('masa_pajak2');
		$tahun = $this->input->get('tahun');
		$tahun2 = $this->input->get('tahun2');
		$range1 = $tahun."-".$masa_pajak."-01";
		$range2 = $tahun2."-".$masa_pajak2."-01";
		
		$sql_cari = "SELECT a.*, b.*, d.*
				FROM v_spt a 
				LEFT JOIN spt_restoran b ON a.spt_id=b.sptresto_id_spt
				LEFT JOIN spt c ON a.spt_id=c.spt_id AND a.spt_kode_billing=c.spt_kode_billing
				LEFT JOIN spt_detail d ON a.spt_id=d.spt_dt_id_spt
				LEFT JOIN kode_rekening_new e ON d.spt_dt_korek = e.korek_id
				WHERE c.tgl_lapor IS NULL";
	
		if ($jenis_restoran == 1){
			$sql_cari .= "  AND a.spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."' AND e.korek_rincian !='05' ";
		}
		elseif ($jenis_restoran == 2){
			$sql_cari .= "  AND a.spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."' AND e.korek_rincian ='05' ";}
			
		elseif ($jenis_restoran == 0){
			$sql_cari .= "  AND a.spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."' ";}
	
		if (!empty($sistem_pemungutan)) 
			$sql_cari .= " AND a.spt_jenis_pemungutan='".$sistem_pemungutan."'";
			
		if (!empty($kecamatan))
			$sql_cari .= " AND a.wp_wr_kd_camat='$kecamatan'";

		if (!empty($masa_pajak))
			$sql_cari .= " AND a.spt_periode_jual1 BETWEEN '$range1' AND '$range2'";
		
		$sql_cari .= " ORDER BY a.spt_periode_jual1 ASC";
		// die($sql_cari);
		$ar_cari = $this->adodb->GetAll($sql_cari);
		return $ar_cari;
	}
}