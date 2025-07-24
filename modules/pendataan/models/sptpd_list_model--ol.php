<?php 
/**
 * class Sptpd_list_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Sptpd_list_model extends CI_Model {
	
	function get_daftar_sptpd() {
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$sistem_pemungutan = $this->input->get('sistem_pemungutan');
		$kecamatan = $this->input->get('kecamatan');
		$masa_pajak = $this->input->get('masa_pajak');
		$tahun = $this->input->get('tahun');
		
		if ($this->input->get('daftar_spt') == '2' || $this->input->get('daftar_spt') == '0') {
			if ($spt_jenis_pajakretribusi == "3" || $spt_jenis_pajakretribusi == "7") {
				$sql_cari = "SELECT DISTINCT a.wp_wr_nama, a.wp_wr_almt, a.npwprd, b.spt_id, b.spt_tgl_proses, b.spt_nomor, korek_persen_tarif
					FROM v_wp_wr a LEFT JOIN v_sptpd_list b ON a.wp_wr_id = b.wp_wr_id ";
			} else {
				$sql_cari = "SELECT DISTINCT a.wp_wr_nama, a.wp_wr_almt, a.npwprd, b.spt_id, b.spt_tgl_proses, b.spt_nomor, korek_persen_tarif, b.spt_dt_persen_tarif, b.spt_dt_jumlah, b.spt_dt_pajak
					FROM v_wp_wr a LEFT JOIN v_sptpd_list b ON a.wp_wr_id = b.wp_wr_id ";
			}
			
			if (!empty($spt_jenis_pajakretribusi))
				$sql_cari .= " AND spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."'";
			
			if (!empty($sistem_pemungutan)) 
				$sql_cari .= " AND spt_jenis_pemungutan='".$sistem_pemungutan."'";
				
			if (!empty($masa_pajak))
				$sql_cari .= " AND EXTRACT(MONTH FROM spt_periode_jual1)='$masa_pajak'";
				
			if (!empty($tahun))
				$sql_cari .= " AND EXTRACT(YEAR FROM spt_periode_jual1)='$tahun'";
				
			$sql_cari .= " WHERE a.wp_wr_id IS NOT NULL";
			
			if (!empty($kecamatan))
				$sql_cari .= " AND a.wp_wr_kd_camat='$kecamatan'";
				
			if ($this->input->get('daftar_spt') == '2')
				$sql_cari .= " AND spt_id IS NULL";
		
			//prepare tanggal
			$next_month = mktime(0, 0, 0, $masa_pajak + 1, 1, $tahun);
			$tahun_kartu_wp = date("Y", $next_month);
			$bulan_kartu_wp = date("m", $next_month); 
			
			$sql_cari .= " AND ref_kodus_kode='0".$spt_jenis_pajakretribusi."' and (
				(a.wp_wr_status_aktif='TRUE' AND wp_wr_tgl_kartu <= '$tahun_kartu_wp-".$bulan_kartu_wp."-01' AND a.wp_wr_tgl_buka ISNULL) OR 
				(a.wp_wr_status_aktif='TRUE' AND a.wp_wr_tgl_buka <= '$tahun_kartu_wp-".$bulan_kartu_wp."-01' AND a.wp_wr_tgl_buka NOTNULL) OR
				(a.wp_wr_status_aktif='FALSE' AND a.wp_wr_tgl_tutup > '$tahun_kartu_wp-".$bulan_kartu_wp."-01')
			)";
			
		} else {
			//jika parkir atau hiburan : rekening > 1
			if ($spt_jenis_pajakretribusi == "3" || $spt_jenis_pajakretribusi == "7") {
				$sql_cari = "SELECT DISTINCT wp_wr_nama, wp_wr_almt, npwprd, spt_id, spt_tgl_proses, spt_nomor
					FROM v_sptpd_list 
					WHERE spt_id IS NOT NULL";
			} else {
				$sql_cari = "SELECT *
					FROM v_sptpd_list 
					WHERE spt_id IS NOT NULL";
			}			
			
		
			if (!empty($spt_jenis_pajakretribusi))
				$sql_cari .= " AND spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."'";
			
			if (!empty($sistem_pemungutan)) 
				$sql_cari .= " AND spt_jenis_pemungutan='".$sistem_pemungutan."'";
				
			if (!empty($kecamatan))
				$sql_cari .= " AND wp_wr_kd_camat='$kecamatan'";
				
			if (!empty($masa_pajak))
				$sql_cari .= " AND EXTRACT(MONTH FROM spt_periode_jual1)='$masa_pajak'";
				
			if (!empty($tahun))
				$sql_cari .= " AND EXTRACT(YEAR FROM spt_periode_jual1)='$tahun'";
		}		
		
		$sql_cari .= " ORDER BY spt_nomor ASC";
		//echo $sql_cari;
		$ar_cari = $this->adodb->GetAll($sql_cari);
		return $ar_cari;
	}
	
	/**
	 * get daftar spt by tanggal entry
	 */
	function get_list_spt_by_tanggal_entry() {
		$spt_jenis_pajak = $this->input->get('spt_jenis_pajakretribusi');
		$kecamatan = $this->input->get('kecamatan');
		$tgl_entry1 = $this->input->get('tgl_entry1');
		$tgl_entry2 = $this->input->get('tgl_entry2');
		$spt_jenis_pajak_restoran = $this->input->get('jenis_pajak_restoran');
		
		//jika parkir atau hiburan : rekening > 1
		if ($spt_jenis_pajak == "3" || $spt_jenis_pajak == "7") {
			$sql_cari = "SELECT DISTINCT wp_wr_nama, wp_wr_almt, npwprd, spt_id, spt_tgl_proses, spt_periode_jual1, spt_nomor, korek_persen_tarif
				FROM v_sptpd_list 
				WHERE spt_id IS NOT NULL";
		} else {
			$sql_cari = "SELECT *
				FROM v_sptpd_list b ";
				if($spt_jenis_pajak == 2){
					$sql_cari .= "LEFT JOIN wp_wr_detail c ON b.wp_wr_id=c.wp_wr_id";
				}
				$sql_cari .= " WHERE spt_id IS NOT NULL";
		}		
	
		$sql_cari .= " AND spt_jenis_pajakretribusi='".$spt_jenis_pajak."' AND spt_tgl_entry BETWEEN '".format_tgl($tgl_entry1)."' AND '".format_tgl($tgl_entry2)."'";

		if($spt_jenis_pajak_restoran <> '0' AND $spt_jenis_pajak == 2){
			$sql_cari .= " AND c.wp_jenis_restoran='".$spt_jenis_pajak_restoran."'";
		}
				
		if (!empty($kecamatan))
			$sql_cari .= " AND wp_wr_kd_camat='$kecamatan'";
			
		$sql_cari .= " ORDER BY spt_nomor ASC";
		
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
	function get_daftar_sptpd_restoran() {
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$jenis_restoran = $this->input->get('jenis_pajak_restoran');
		$sistem_pemungutan = $this->input->get('sistem_pemungutan');
		$kecamatan = $this->input->get('kecamatan');
		$masa_pajak = $this->input->get('masa_pajak');
		$tahun = $this->input->get('tahun');
		
		if ($this->input->get('daftar_spt') == '2' || $this->input->get('daftar_spt') == '0') {
			$sql_cari = "SELECT DISTINCT a.wp_wr_id, a.wp_wr_nama, a.wp_wr_almt, a.npwprd, b.spt_tgl_proses, b.spt_id, b.spt_nomor, b.spt_dt_persen_tarif, 
							b.korek_persen_tarif, b.spt_dt_jumlah, b.spt_dt_pajak, COALESCE(sptresto_jenis, 1) as sptrestoran_jenis
					FROM v_wp_detail a LEFT JOIN v_sptpd_list b ON a.wp_wr_id = b.wp_wr_id ";			
			
			if (!empty($spt_jenis_pajakretribusi))
				$sql_cari .= " AND spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."'";			
			
			if (!empty($sistem_pemungutan)) 
				$sql_cari .= " AND spt_jenis_pemungutan='".$sistem_pemungutan."'";
				
			if (!empty($masa_pajak))
				$sql_cari .= " AND EXTRACT(MONTH FROM spt_periode_jual1)='$masa_pajak'";
				
			if (!empty($tahun))
				$sql_cari .= " AND EXTRACT(YEAR FROM spt_periode_jual1)='$tahun'";
				
			$sql_cari .= " LEFT JOIN spt_restoran c ON b.spt_id=c.sptresto_id_spt";
			$sql_cari .= " WHERE a.wp_wr_id IS NOT NULL ";
			
			if (!empty($kecamatan))
				$sql_cari .= " AND a.wp_wr_kd_camat='$kecamatan'";
				
			if ($this->input->get('daftar_spt') == '2')
				$sql_cari .= " AND spt_id IS NULL";
			
			//prepare tanggal
			$next_month = mktime(0, 0, 0, $masa_pajak + 1, 1, $tahun);
			$tahun_kartu_wp = date("Y", $next_month);
			$bulan_kartu_wp = date("m", $next_month);
						
			$sql_cari .= " AND ref_kodus_kode='0".$spt_jenis_pajakretribusi."' and (
				(a.wp_wr_status_aktif='TRUE' AND wp_wr_tgl_kartu <= '$tahun_kartu_wp-".$bulan_kartu_wp."-01' AND a.wp_wr_tgl_buka ISNULL) OR 
				(a.wp_wr_status_aktif='TRUE' AND a.wp_wr_tgl_buka <= '$tahun_kartu_wp-".$bulan_kartu_wp."-01' AND a.wp_wr_tgl_buka NOTNULL) OR
				(a.wp_wr_status_aktif='FALSE' AND a.wp_wr_tgl_tutup > '$tahun_kartu_wp-".$bulan_kartu_wp."-01')
			)";
			
			if ($jenis_restoran != "0") {
				$sql_cari .= " AND COALESCE(wp_jenis_restoran, 0) IN ($jenis_restoran, 0)";					
			}
		} else {
			$sql_cari = "SELECT *, COALESCE(v_wp_detail.wp_jenis_restoran, 1) as sptrestoran_jenis
					FROM v_sptpd_list LEFT JOIN spt_restoran ON v_sptpd_list.spt_id=spt_restoran.sptresto_id_spt
					LEFT JOIN v_wp_detail ON v_sptpd_list.wp_wr_id = v_wp_detail.wp_wr_id
					WHERE spt_id IS NOT NULL";
		
			if (!empty($spt_jenis_pajakretribusi))
				$sql_cari .= " AND spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."'";
				
			if ($jenis_restoran != "0")
				$sql_cari .= " AND COALESCE(v_wp_detail.wp_jenis_restoran, 1)='".$jenis_restoran."'";
			
			if (!empty($sistem_pemungutan)) 
				$sql_cari .= " AND spt_jenis_pemungutan='".$sistem_pemungutan."'";
				
			if (!empty($kecamatan))
				$sql_cari .= " AND v_sptpd_list.wp_wr_kd_camat='$kecamatan'";
				
			if (!empty($masa_pajak))
				$sql_cari .= " AND EXTRACT(MONTH FROM spt_periode_jual1)='$masa_pajak'";
				
			if (!empty($tahun))
				$sql_cari .= " AND EXTRACT(YEAR FROM spt_periode_jual1)='$tahun'";
		}	
		
		$sql_cari .= " ORDER BY spt_nomor ASC";
		// die($sql_cari);
		$ar_cari = $this->adodb->GetAll($sql_cari);
		return $ar_cari;
	}
	
	function get_daftar_kartu_data() {
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$tgl_pendataan = $this->input->get('tgl_pendataan');
		$spt_periode = $this->input->get('spt_periode');		
		
		$sql_cari = "SELECT *
					FROM v_sptpd_list 
					WHERE spt_id IS NOT NULL";
		
		if (!empty($spt_jenis_pajakretribusi))
			$sql_cari .= " AND spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."'";
			
		if (!empty($tgl_pendataan))
			$sql_cari .= " AND spt_tgl_entry='".format_tgl($tgl_pendataan)."'";
			
		if (!empty($spt_periode))
			$sql_cari .= " AND spt_periode='$spt_periode'";
			
		if (!is_null($_GET['daftar'])) {
			if ($_GET['daftar'] == "1")
				$sql_cari .= " AND spt_kode='10'";
		}
		
		$sql_cari .= " ORDER BY spt_nomor ASC";
		//echo $sql_cari;
		$ar_cari = $this->adodb->GetAll($sql_cari);
		return $ar_cari;
	}
}