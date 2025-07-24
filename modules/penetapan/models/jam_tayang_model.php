<?php 
/**
 * class Surat_ketetapan_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Jam_tayang_model extends CI_Model {
	
	
	/**
	 * daftar_surat_ketetapan_reklame
	 */
	function daftar_jam_tayang() {
		
		$where = "WHERE netapajrek_id_spt IS NOT NULL AND (a.netapajrek_tgl::date + (c.sptrek_lama_pasang || ' days')::interval) < NOW()";
		
		if (!empty($_GET['keterangan_spt']))
			$where .= " AND netapajrek_jenis_ketetapan=".$_GET['keterangan_spt'];
			
		if (!empty($_GET['spt_jenis_pajakretribusi']))
			$where .= " AND spt_jenis_pajakretribusi=".$_GET['spt_jenis_pajakretribusi'];
			
		if (!empty($_GET['tanggal']))
			$where .= " AND date_part('day',netapajrek_tgl)='".$_GET['tanggal']."'";
			
		if (!empty($_GET['bulan']))
			$where .= " AND date_part('month',netapajrek_tgl)='".$_GET['bulan']."'";
		
		if (!empty($_GET['tahun']))
			$where .= " AND date_part('year',netapajrek_tgl)='".$_GET['tahun']."'";
			
		// if ($this->session->userdata('USER_SPT_CODE') == "10") {
		// 	if ($_GET['wp_wr_kd_camat'] != "0") {
		// 		$camat_kode = $this->common_model->get_record_value('camat_kode', 'kecamatan', "camat_id=".$_GET['wp_wr_kd_camat']);
		// 		$where .= " AND spt_kode='$camat_kode'";
		// 	} else {
		// 		$where .= " AND spt_kode='".$this->session->userdata('USER_SPT_CODE')."'";
		// 	}			
		// } else {
		// 	$where .= " AND spt_kode='".$this->session->userdata('USER_SPT_CODE')."'";
		// }

		if (!empty($_GET['wp_wr_kd_camat'])){
			$kd_camat = $_GET['wp_wr_kd_camat'];
			$get_camat = $this->jam_tayang_model->getCamat($kd_camat);
			$camat = $get_camat->camat_nama;
			$where .= " AND wp_wr_camat='".$camat."'";
		}

		if (!empty($_GET['lurah_id'])){
			$lurah = explode('|', $_GET['lurah_id']);
			$where .= " AND wp_wr_lurah='".$lurah[1]."'";
		}
		
		$order_by = " ORDER BY netapajrek_kohir ASC";
		
		$sql = "SELECT a.*, b.korek_nama as korek_nama_detail,b.spt_dt_pajak, c.sptrek_judul, c.sptrek_lokasi, c.sptrek_luas, c.sptrek_lama_pasang
					FROM v_daftar_ketetapan_list a 
					INNER JOIN v_spt_detail b ON a.netapajrek_id_spt=b.spt_dt_id_spt
					LEFT JOIN spt_reklame c ON b.spt_dt_id=c.sptrek_id_spt_dt  $where $order_by";
		// echo $sql;die;
		$result = $this->adodb->GetAll($sql);
		return $result;
	}
	
	/**
	 * daftar_tanggal_surat_ketetapan_reklame
	 */
	function daftar_jam_tayang_tanggal() {
		$where = "WHERE netapajrek_id_spt IS NOT NULL AND (a.netapajrek_tgl::date + (c.sptrek_lama_pasang || ' days')::interval) < NOW()";
		
		$where .= " AND spt_jenis_pajakretribusi=".$_GET['spt_jenis_pajakretribusi'];
		$where .= " AND netapajrek_tgl BETWEEN '".format_tgl($_GET['tgl_penetapan1'])."' AND '".format_tgl($_GET['tgl_penetapan2'])."'";
		
		if (!empty($_GET['keterangan_spt']))
			$where .= " AND netapajrek_jenis_ketetapan=".$_GET['keterangan_spt'];
			
		if ($this->session->userdata('USER_SPT_CODE') != "")
			$where .= " AND spt_kode='".$this->session->userdata('USER_SPT_CODE')."'";

		if (!empty($_GET['wp_wr_kd_camat'])){
			$kd_camat = $_GET['wp_wr_kd_camat'];
			$get_camat = $this->jam_tayang_model->getCamat($kd_camat);
			$camat = $get_camat->camat_nama;
			$where .= " AND wp_wr_camat='".$camat."'";
		}

		if (!empty($_GET['lurah_id'])){
			$lurah = explode('|', $_GET['lurah_id']);
			$where .= " AND wp_wr_lurah='".$lurah[1]."'";
		}
		
		$order_by = " ORDER BY netapajrek_kohir ASC";
		
		$sql = "SELECT a.*, b.korek_nama as korek_nama_detail, b.spt_dt_pajak, c.sptrek_judul, c.sptrek_lokasi, c.sptrek_luas, c.sptrek_lama_pasang
					FROM v_daftar_ketetapan_list a 
					INNER JOIN v_spt_detail b ON a.netapajrek_id_spt=b.spt_dt_id_spt
					LEFT JOIN spt_reklame c ON b.spt_dt_id=c.sptrek_id_spt_dt $where $order_by";
		//echo $sql;
		$result = $this->adodb->GetAll($sql);
		return $result;
	}

	function getCamat($kd_camat){
		$sql_camat = "SELECT camat_nama FROM kecamatan WHERE camat_id = '$kd_camat'";
		$query = $this->db->query($sql_camat);
		return $query->row();
	}
}