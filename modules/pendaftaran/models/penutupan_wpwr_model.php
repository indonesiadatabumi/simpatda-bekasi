<?php 
/**
 * class Penutupan_wpwr_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121015
 */
class Penutupan_wpwr_model extends CI_Model {
	/**
	 * penutupan wpwr
	 */
	function insert() {
		$arr_field = array(
					'wp_wr_tgl_tutup' => format_tgl($this->input->post('tgl_tutup'))
					);
		$this->db->where('wp_wr_id', $this->input->post('wp_wr_id'));
		$this->db->update('wp_wr', $arr_field);

		//insert into penutupan wp_wr
		$arr_insert = array(
						'wp_wr_id' => $this->input->post('wp_wr_id'),
						'tgl_tutup' => format_tgl($this->input->post('tgl_tutup')),
						'tgl_proses' => date('Y-m-d'),
						'no_berita_acara' => $this->input->post('no_berita'),
						'isi_berita_acara' => $this->input->post('isi_berita')
					);
		$this->db->insert('penutupan_wpwr', $arr_insert);

		//update status user sipdah
		$arr_field = array(
			'is_active' => 'N'
			);
		$this->db->where('id_wp_wr', $this->input->post('wp_wr_id'));
		$this->db->update('tbl_users', $arr_field);

		//delete penonaktifan wpwr
		$this->db->where('wp_wr_id', $this->input->post('wp_wr_id'));
		$this->db->delete('penonaktifan_wpwr');
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else 
			return false;
	}
}