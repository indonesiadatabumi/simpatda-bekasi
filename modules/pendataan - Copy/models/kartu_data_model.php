<?php 
/**
 * class Kartu_data_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Kartu_data_model extends CI_Model {
	/**
	 * get data wp
	 */
	function get_data_wp() {
		$wp_id = $this->input->get_post('wp_id');
		$query = $this->db->get_where('v_wp_wr', array('wp_wr_id' => $wp_id));
		
		return $query->row_array();
	}
	
	/**
	 * get spt_list
	 */
	function get_spt_list() {
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
               	FROM v_spt vspt
					LEFT JOIN penetapan_pajak_retribusi ppr ON ppr.netapajrek_id_spt=vspt.spt_id
			        LEFT JOIN v_rekapitulasi_penerimaan vrp ON vspt.spt_id = vrp.setorpajret_id_spt AND vspt.spt_status=vrp.setorpajret_jenis_ketetapan
						AND vspt.spt_jenis_pajakretribusi=vrp.setorpajret_jenis_pajakretribusi
			    	LEFT JOIN keterangan_spt ket ON ket.ketspt_id = spt_status AND spt_status = ket.ketspt_id
			    WHERE spt_periode='".$this->input->get_post('spt_periode')."' AND spt_idwpwr='".$this->input->get_post('wp_id')."'
			    	AND spt_status IN (1, 8) AND spt_jenis_pajakretribusi != 4
			    ORDER BY spt_tgl_proses ASC";
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
}