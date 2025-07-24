<?php 
/**
 * class Pembukaan_kembali_wpwr_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121015
 */
class Pembukaan_kembali_wpwr_model extends CI_Model {
	/**
	 * save pembukaan data wp
	 */
	function save() {
		$arr_field = array(
					'wp_wr_status_aktif' => 't',
					'wp_wr_tgl_buka' => format_tgl($this->input->post('tgl_buka')),
					'wp_wr_tgl_kartu' => format_tgl($this->input->post('tgl_buka'))
					);
		$this->db->where('wp_wr_id', $this->input->post('wp_wr_id'));
		$this->db->update('wp_wr', $arr_field);

		//insert into penutupan wp_wr
		$arr_insert = array(
						'wp_wr_id' => $this->input->post('wp_wr_id'),
						'tgl_buka' => format_tgl($this->input->post('tgl_buka')),
						'tgl_proses' => date('Y-m-d'),
						'no_berita_acara' => $this->input->post('no_berita'),
						'isi_berita_acara' => $this->input->post('isi_berita')
					);
		$this->db->insert('pembukaan_wpwr', $arr_insert);
		
		if ($this->db->affected_rows() > 0)
			return true;
		else 
			return false;
	}
}