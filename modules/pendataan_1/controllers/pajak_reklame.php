<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pajak_reklame controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Pajak_reklame extends Master_Controller {
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
							
							//insert into spt_detail
							$spt_dt_id = $this->pajak_reklame_model->insert_spt_detail($spt_id,$i);

							if ($spt_dt_id != false){
								//insert into spt_reklame
								$this->pajak_reklame_model->insert_spt_reklame($spt_dt_id,$i);
							}

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
	
	/**
	 * view list
	 */
	function view() {
		$this->load->view('view_pajak_reklame');
	}
	
	/**
	 * get list sptpd hiburan
	 */
	function get_list() {
		$this->pajak_reklame_model->get_list();
	}
	
	/**
	 * function edit
	 */
	function edit() {
		$this->load->model('rekening_model');
		$sptpd = $this->pajak_reklame_model->get_sptpd();
		$data['sistem_pemungutan'] = array('2' => 'Official Assesment');
	
		if ($sptpd != false) {
			//get spt_detail
			$spt_detail_rows = $this->pajak_reklame_model->get_spt_detail();
			$data['row'] = $sptpd;
			$data['rows_detail'] = $spt_detail_rows->result();
			
			$data['rekening'] = $this->rekening_model->get_arr_list($this->config->item('korek_reklame'), true);

			$this->load->view('edit_pajak_reklame', $data);	
		}
	}
	
	/**
	 * get spt reklame
	 */
	function get_spt_reklame() {
		$result = array();
		
		$spt_reklame = $this->pajak_reklame_model->get_spt_reklame($_GET['spt_dt_id']);

		if ($spt_reklame->num_rows() > 0) {
			$result = array(
				'total' => $spt_reklame->num_rows(),
				'list' => $spt_reklame->row()
			);
		} else {
			$result = array(
				'total' => '0'
			);
		}
		
		echo json_encode($result);
	}
	
	/**
	 * update data sptpd
	 */	
	function update() {
		
		$result = array();
		$wp_id = $this->input->post('wp_rek_id');
		$spt_id = $this->input->post('spt_id');
		$n_detail_rows = $this->input->post('n_detail_rows');

		if (!empty($wp_id) && !empty($spt_id)) {
			$this->pajak_reklame_model->update_wp_reklame();
			
			//update spt and spt_detail
			$return = $this->spt_model->update_spt();

			if ($return) {
				$sql = "SELECT spt_dt_id FROM spt_detail WHERE spt_dt_id_spt='".$spt_id."'";								
				$rows = $this->db->query($sql)->result();

				foreach($rows as $row){					
					$result = $this->db->delete('spt_reklame',array('sptrek_id_spt_dt'=>$row->spt_dt_id));
				}
				
				$result = $this->db->delete('spt_detail', array('spt_dt_id_spt' => $spt_id));
				
				for($i=1;$i<=$n_detail_rows;$i++){					
					
					if(isset($_POST['spt_dt_korek'.$i])){

						$spt_dt_id = $this->input->post('spt_dt_id'.$i);
						
						//insert into spt_detail
						$spt_dt_id = $this->pajak_reklame_model->insert_spt_detail($spt_id,$i);

						if ($spt_dt_id != false)
						{
							//insert into spt_reklame
							$this->pajak_reklame_model->insert_spt_reklame($spt_dt_id,$i);
						}
					}
				}

				$result = array('status' => true, 'msg' => 'Data berhasil disimpan');
				
				//insert history log
				$this->common_model->history_log("pendataan", "U", "Update Data Pajak Reklame : ".
						$_POST['spt_id']." | ".$_POST['spt_periode']." | ".$_POST['spt_no_register']." | ".strtoupper($_POST['wp_wr_nama'])." | ".$_POST['spt_pajak']);
			}
			else 
				$result = array('status' => false, 'msg' => 'Data tidak berhasil disimpan');
		} else {
			$result = array('status' => false, 'msg' => 'Silahkan masukkan data WP terlebih dahulu');
		}	
		echo json_encode($result);
	}
	
	/**
	 * deleta data pajak
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));

		for ($i = 0; $i < count($arr_id) - 1; $i++) {

			if($this->spt_model->delete_spt($arr_id[$i]) == true) {
				
				$counter++;
				
				//insert history log
				$this->common_model->history_log("pendataan", "D", "Delete Data Pajak Reklame : ".$arr_id[$i]);
			}				
		}
		
		if ($counter != 0) {			
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}