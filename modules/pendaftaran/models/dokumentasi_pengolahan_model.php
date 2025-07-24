<?php 
/**
 * class Dokumentasi_pengolahan_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121015
 */
class Dokumentasi_pengolahan_model extends CI_Model {
	/**
	 * get list daftar induk
	 */
	function get_list_daftar_induk () {
		$where = " WHERE wp_wr_id IS NOT NULL";
		
		if ($this->input->get("wp_wr_status_aktif") == "1") {
			$where .= " AND wp_wr_status_aktif = 'TRUE'";
		}
		
		if ($this->input->get('wp_wr_golongan') != "0") {
			$where .= " AND wp_wr_gol='".$this->input->get('wp_wr_golongan')."'";
		}

		if ($this->input->get('bidus') != "") {
			$where .= " AND wp_wr_bidang_usaha='".$this->input->get('bidus')."'";
		}
		
		if ($this->input->get('camat') != "") {
			$camat = $this->input->get('camat');
			$arr_camat = explode("|", $camat);
			$where .= " AND wp_wr_kd_camat='".$arr_camat[0]."'";
		}
		
		if ($this->input->get('lurah') != "" && $this->input->get('lurah') <> "null") {
			$lurah = $this->input->get('lurah');
			$arr_lurah = explode("|", $lurah);
			$where .= " AND wp_wr_kd_lurah='".$arr_lurah[0]."'";
		}
		
		$fromDate = $this->input->get('fDate');
		if ( ! empty($fromDate))
		{
			$where .= " AND wp_wr_tgl_kartu >= '".format_tgl($fromDate)."'";
		}
		
		$toDate = $this->input->get('tDate');
		if ( ! empty($toDate))
		{
			$where .= " AND wp_wr_tgl_kartu <= '".format_tgl($toDate)."'";
		}
		
		$from = " FROM v_wp_wr LEFT JOIN ref_kode_usaha ON v_wp_wr.wp_wr_bidang_usaha::TEXT = ref_kode_usaha.ref_kodus_id::TEXT";
		$order_by = " ORDER BY wp_wr_no_urut DESC";
		
		$query = "SELECT wp_wr_id, 
							npwprd, 
							wp_wr_nama, 
							wp_wr_almt,
							wp_wr_nama_milik,
							wp_wr_lurah, 
							wp_wr_camat, 
							wp_wr_bidang_usaha, 
							ref_kodus_nama
					$from $where $order_by";
		$result = $this->adodb->GetAll($query);
		return $result;
	}
	
	/**
	 * get list wp tutup
	 */
	function get_list_wp_tutup() {
		$where = " WHERE wp_wr_status_aktif = 'FALSE' ";
		
		$fromDate = $this->input->get('fDate');
		if ( ! empty($fromDate))
		{
			$where .= " AND wp_wr_tgl_tutup >= '".format_tgl($fromDate)."'";
		}
		
		$toDate = $this->input->get('tDate');
		if ( ! empty($toDate))
		{
			$where .= " AND wp_wr_tgl_tutup <= '".format_tgl($toDate)."'";
		}
		
		if ($this->input->get('bidus') != "") {
			$where .= " AND wp_wr_bidang_usaha='".$this->input->get('bidus')."'";
		}
		
		if ($this->input->get('camat') != "") {
			$camat = $this->input->get('camat');
			$arr_camat = explode("|", $camat);
			$where .= " AND wp_wr_kd_camat='".$arr_camat[0]."'";
		}
		
		$from = " FROM v_wp_wr LEFT JOIN ref_kode_usaha ON v_wp_wr.wp_wr_bidang_usaha::TEXT = ref_kode_usaha.ref_kodus_id::TEXT";
		$order_by = " ORDER BY wp_wr_no_urut DESC";
		
		$query = "SELECT wp_wr_id, 
							npwprd, 
							wp_wr_nama, 
							wp_wr_almt,
							wp_wr_nama_milik,
							wp_wr_lurah, 
							wp_wr_camat, 
							wp_wr_bidang_usaha, 
							ref_kodus_nama,
							wp_wr_tgl_tutup
					$from $where $order_by";
		$result = $this->adodb->GetAll($query);
		return $result;
	}

		/**
	 * get list wp nonaktif
	 */
	function get_list_wp_nonaktif() {
		$where = " WHERE a.wp_wr_id IS NOT NULL ";
		
		$fromDate = $this->input->get('fDate');
		if ( ! empty($fromDate))
		{
			$where .= " AND a.tgl_nonaktif >= '".format_tgl($fromDate)."'";
		}
		
		$toDate = $this->input->get('tDate');
		if ( ! empty($toDate))
		{
			$where .= " AND a.tgl_nonaktif <= '".format_tgl($toDate)."'";
		}
		
		if ($this->input->get('bidus') != "") {
			$where .= " AND b.wp_wr_bidang_usaha='".$this->input->get('bidus')."'";
		}
		
		if ($this->input->get('camat') != "") {
			$camat = $this->input->get('camat');
			$arr_camat = explode("|", $camat);
			$where .= " AND b.wp_wr_kd_camat='".$arr_camat[0]."'";
		}
		
		$from = " FROM penonaktifan_wpwr a
					LEFT JOIN v_wp_wr b ON a.wp_wr_id=b.wp_wr_id 
					LEFT JOIN ref_kode_usaha c ON b.wp_wr_bidang_usaha::TEXT = c.ref_kodus_id::TEXT";
		$order_by = " ORDER BY b.wp_wr_no_urut DESC";
		
		$query = "SELECT a.wp_wr_id, 
						 a.tgl_nonaktif, 
						 b.npwprd, 
						 b.wp_wr_nama, 
						 b.wp_wr_almt, 
						 b.wp_wr_nama_milik, 
						 b.wp_wr_lurah, 
						 b.wp_wr_camat, 
						 b.wp_wr_bidang_usaha, 
						 c.ref_kodus_nama
					$from $where $order_by";
		$result = $this->adodb->GetAll($query);
		return $result;
	}
}