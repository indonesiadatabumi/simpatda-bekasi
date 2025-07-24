<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pajak_reklame controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Pajak_reklame2 extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('spt_model');
		$this->load->model('pajak_reklame_model');
	}
	
	/**
	 * add page controller
	 */
	function add() {
		$data['sistem_pemungutan'] = array('2' => 'Official Assesment');		
		$this->load->view('add_pajak_reklame', $data);
	}

	/**
	 * get kelas jalan
	 */
	function get_kelas_jalan() {
		$kelas_jalan = $this->pajak_reklame_model->get_kelas_jalan();
		echo json_encode($kelas_jalan);
	}
	
	/**
	 * get_nilai_kelas_jalan
	 */
	function get_nilai_kelas_jalan() {
		$rekening = $this->input->get('rekening');
		$kelas_jalan_id = $this->input->get('kelas_jalan_id');
		$arr_rekening = explode(",", $rekening);
		$query = $this->pajak_reklame_model->get_nilai_kelas_jalan($arr_rekening[0], $kelas_jalan_id);
		if ($query->num_rows() > 0) {
			$result = $query->row_array();
		} else {
			$result = array();
		}
		
		echo json_encode($result);
	}
	
	function save() {
		$result = array();		
		//insert into spt_reklame

		$wp_reklame_id = $this->pajak_reklame_model->insert_wp_reklame(
										0,
										0,
										$this->input->post('spt_no_register'),
										strtoupper($this->input->post('wp_wr_nama')),
										strtoupper($this->input->post('wp_wr_almt')),
										""
									);
		

		if ($wp_reklame_id != false) {
			$check_masa_pajak = $this->spt_model->check_masa_pajak(
															$wp_reklame_id, 
															$this->input->post('spt_periode_jual1'),
															$this->input->post('spt_periode_jual2'),
															$this->input->post('korek'),
															$this->input->post('spt_jenis_pemungutan'),
															true
															);

			if (!$check_masa_pajak) {

				//save spt
				$spt_id = $this->spt_model->insert_spt(true, $wp_reklame_id);

				if ($spt_id != 0) {

					$n_detail_rows = $this->input->post('n_detail_rows');

					for($i=1;$i<=$n_detail_rows;$i++){
						
						if(isset($_POST['spt_dt_korek'.$i])){
							
					// 		//insert into spt_detail
					// 		$spt_dt_id = $this->pajak_reklame_model->insert_spt_detail($spt_id,$i);

					// 		if ($spt_dt_id != false){
					// 			//insert into spt_reklame
					// 			$this->pajak_reklame_model->insert_spt_reklame($spt_dt_id,$i);
					// 		}

						}
					}

					$result = array('status' => true, 'msg' => 'Data berhasil disimpan');

					//insert history log
					$this->common_model->history_log("pendataan", "i", "Insert Data Pajak Reklame : ".
							$spt_id." | ".$_POST['spt_periode']." | ".$_POST['spt_kode'].$_POST['spt_no_register']." | ".strtoupper($_POST['wp_wr_nama'])." | ".$_POST['spt_pajak']);
				} else {
					$result = array('status' => false, 'msg' => 'Data tidak berhasil disimpan');
				}
			}
		}
		echo json_encode($result);
	}
	
		
}