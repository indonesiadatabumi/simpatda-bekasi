<?php 
/**
 * class Penonaktifan_wpwr_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121015
 */
class Penonaktifan_wpwr_model extends CI_Model {
	/**
	 * penonaktifan wpwr
	 */
	function insert() {
		$arr_field = array(
					'wp_wr_status_aktif' => 'f');
		$this->db->where('wp_wr_id', $this->input->post('wp_wr_id'));
		$this->db->update('wp_wr', $arr_field);

		//insert into penonaktifan wp_wr
		$arr_insert = array(
						'wp_wr_id' => $this->input->post('wp_wr_id'),
						'tgl_nonaktif' => format_tgl($this->input->post('tgl_nonaktif')),
						'tgl_proses' => date('Y-m-d'),
						'no_berita_acara' => $this->input->post('no_berita'),
						'isi_berita_acara' => $this->input->post('isi_berita')
					);
		$this->db->insert('penonaktifan_wpwr', $arr_insert);
		
		if ($this->db->affected_rows() > 0) {
			return true;
		} else 
			return false;
	}

	/**
	 * change status wp_wr
	 * @param unknown_type $id
	 */
	function change_status($wp_wr_id) {
		// ganti status wp di tbl wp wr
		$arr_field = array(
			'wp_wr_status_aktif' => 't');
		$this->db->where('wp_wr_id', $wp_wr_id);
		$this->db->update('wp_wr', $arr_field);

		//delete data penonaktifan wpwr
		$this->db->where('wp_wr_id', $wp_wr_id);
		$this->db->delete('penonaktifan_wpwr');

		if ($this->db->affected_rows() > 0) {
			//insert history log ($module, $action, $description)
			// $this->common_model->history_log("pendaftaran", "D", "Delete WP Badan Usaha id $wp_wr_id");
			
			return true;
		} else {
			return false;
		}
	}
}