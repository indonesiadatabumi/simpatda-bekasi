<?php 
class Api_dispenda_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function _Get_ListData(){
		$query = $this->db->query("SELECT 
						SUM(a.setorpajret_dt_jumlah) AS TOTAL, 
						b.ref_jenparet_id AS JENIS_PAJAK_ID, 
						b.ref_jenparet_ket AS JENIS_PAJAK_NAME, 
						to_char(a.setorpajret_tgl_bayar, 'YYYY') AS TAHUN, 
						to_char(a.setorpajret_tgl_bayar, 'MM') AS BULAN
						FROM v_rekapitulasi_penerimaan_detail a
						JOIN ref_jenis_pajak_retribusi b ON b.ref_jenparet_id = a.setorpajret_jenis_pajakretribusi 
						GROUP BY b.ref_jenparet_id, to_char(a.setorpajret_tgl_bayar, 'YYYY'), to_char(a.setorpajret_tgl_bayar, 'MM') ORDER BY TAHUN, BULAN, JENIS_PAJAK_ID");
		return $query->result();
		
	}
}