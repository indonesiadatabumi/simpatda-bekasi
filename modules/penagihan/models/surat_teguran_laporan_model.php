<?php 
/**
 * class Surat_teguran_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Surat_teguran_laporan_model extends CI_Model {
	/**
	 * get wp 
	 */
	function get_header() {
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$bulan = $this->input->get('bulan');
		$tahun = $this->input->get('tahun');
		$wp_wr_kd_camat = $this->input->get('wp_wr_kd_camat');
		$wp_wr_id = $this->input->get('wp_wr_id');
				
	//	if (!empty($wp_wr_id))

	//prepare tanggal
			$next_month = mktime(0, 0, 0, $bulan + 1, 1, $tahun);
			$tahun_kartu_wp = date("Y", $next_month);
			$bulan_kartu_wp = date("m", $next_month);

	$sql_cari="SELECT * FROM v_wp_detail  WHERE  wp_wr_id='$wp_wr_id' 
	AND ref_kodus_kode='0".$spt_jenis_pajakretribusi."' and (
				(wp_wr_status_aktif='TRUE' AND wp_wr_tgl_kartu <= '$tahun_kartu_wp-".$bulan_kartu_wp."-01' AND wp_wr_tgl_buka ISNULL) OR 
				(wp_wr_status_aktif='TRUE' AND wp_wr_tgl_buka <= '$tahun_kartu_wp-".$bulan_kartu_wp."-01' AND wp_wr_tgl_buka NOTNULL) OR
				(wp_wr_status_aktif='FALSE' AND wp_wr_tgl_tutup > '$tahun_kartu_wp-".$bulan_kartu_wp."-01')
			)";
	
		// echo $sql_cari;die;
		$ar_cari = $this->adodb->GetAll($sql_cari);
		return $ar_cari;
	}
	
	/**
	 * get detail surat teguran
	 */
	function get_detail($wp_wr_id) {
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$bulan = $this->input->get('bulan');
		$tahun = $this->input->get('tahun');
		$wp_wr_kd_camat = $this->input->get('wp_wr_kd_camat');
		
		$where = "WHERE spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."' AND wp_wr_id='$wp_wr_id'";
		
	/*	if (!empty($bulan))
			$where .= " AND date_part('month',spt_periode_jual1) = '$bulan'";
		
		if (!empty($tahun))
			$where .= " AND date_part('year',spt_periode_jual1) = '$tahun'";
	*/
		if (!empty($bulan))
				$where .= " AND EXTRACT(MONTH FROM spt_periode_jual1)='$bulan'";
				
			if (!empty($tahun))
			$where .= " AND EXTRACT(YEAR FROM spt_periode_jual1)='$tahun'";
					
		
		if (!empty($wp_wr_kd_camat))
			$where .= " AND wp_wr_kd_camat='$wp_wr_kd_camat'";
			
		if (!empty($wp_wr_id))
			$where .= " AND wp_wr_id='$wp_wr_id'";
					
		
		$sql = "SELECT *
					FROM v_spt
					$where";
		// var_dump($sql);die;
		$rs = $this->adodb->GetAll($sql);
		return $rs;
	}
	
	/**
	 * get nomor surat teguran
	 */
	function get_no_surat_teguran() {
		if ($_GET['tgl_cetak'] != '') {
			$arr_tanggal = explode('-', $_GET['tgl_cetak']);
			$tahun = $arr_tanggal[2];
			$bulan= $arr_tanggal[1];
		} else {
			$tahun = date('Y');
			$bulan = date('m');
		}
		
		$st_nomor = $this->insert_no_surat_teguran($bulan, $tahun);
		return format_angka(4, $st_nomor)."/".format_romawi($bulan)."/ST/".$tahun;
	}
	
	
	/**
	 * insert data into db
	 */
	function insert($data) {
		if ($data != null) {
			//check firstly into db then insert if null
			if ($data['st_spt_id'] != "" && $data['st_jenis_ketetapan'] != "") {
				$arr_where = array(
								'st_spt_id' => $data['st_spt_id'],
								'st_jenis_ketetapan' => $data['st_jenis_ketetapan']
							);
				$query = $this->db->get_where('surat_teguran_laporan', $arr_where);

				if ($query->num_rows() == 0)				
					$this->db->insert('surat_teguran_laporan', $data);
			}
		}
	}
	
	/**
	 * nomor bukti
	 * @param unknown_type $kohir_thn
	 */
	function insert_no_surat_teguran ($bulan, $tahun) {
		$query = $this->db->query("SELECT nomor_id, nomor_teguran+1 as no_teguran FROM nomor_surat WHERE nomor_tahun='$tahun' AND nomor_bulan='$bulan'");
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$nomor_id = $row->nomor_id;
			$next_val = $row->no_teguran;
			
			$record = array('nomor_teguran' => $next_val);
			$this->db->update('nomor_surat', $record, array('nomor_id' => $nomor_id));
			
			return $next_val;
		} else {
			$arr_data = array(
							'nomor_id' => $this->common_model->next_val('nomor_surat_nomor_id_seq'),
							'nomor_tahun' => $tahun_setoran,
							'nomor_bulan' => $bulan_setoran,
							'nomor_tanda_setoran' => 0,
							'nomor_teguran' => 1
						);
			$this->db->insert('nomor_surat', $arr_data);
			return 1;
		}
	}
}