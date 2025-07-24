<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pribadi class controller
 * @package Simpatda
 * @author Daniel H
 * @version 20121016
 */
class Pejabat extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('pejabat_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('view_pejabat');
	}
	
	/**
	 * get list pejabat
	 */
	function get_list() {
		$this->pejabat_model->get_list();
	}
	
	/**
	 * add pejabat
	 */
	function add() {
		$data['arr_jabatan'] = $this->common_model->get_record_list('ref_japeda_id as value, ref_japeda_nama as item', 
																		'ref_jabatan_pejabat_daerah', null, 'ref_japeda_id ASC', true);
		$data['arr_golongan'] = $this->common_model->get_record_list('ref_goru_id as value, ref_goru_ket as item', 
																		'ref_gol_ruang', null, 'ref_goru_id ASC', true);
		$data['arr_pangkat'] = $this->common_model->get_record_list('ref_pangpej_id as value, ref_pangpej_ket as item', 
																		'ref_pangkat_pejabat', null, 'ref_pangpej_id ASC', true);
		$this->load->view('add_pejabat', $data);
	}
	
	/**
	 * save new data pejabat
	 */
	function save() {
		$result = $this->pejabat_model->insert();
		if ($result) {
			$this->common_model->history_log("pemeliharaan", "I", "Insert data pejabat");	
			echo json_encode(array('status' => true, 'msg' => 'Data berhasil disimpan'));			
		} else
			echo json_encode(array('status' => false, 'msg' => 'Data gagal disimpan'));
	}
	
	/**
	 * edit data
	 */
	function edit() {
		$data['arr_jabatan'] = $this->common_model->get_record_list('ref_japeda_id as value, ref_japeda_nama as item', 
																		'ref_jabatan_pejabat_daerah', null, 'ref_japeda_id ASC', true);
		$data['arr_golongan'] = $this->common_model->get_record_list('ref_goru_id as value, ref_goru_ket as item', 
																		'ref_gol_ruang', null, 'ref_goru_id ASC', true);
		$data['arr_pangkat'] = $this->common_model->get_record_list('ref_pangpej_id as value, ref_pangpej_ket as item', 
																		'ref_pangkat_pejabat', null, 'ref_pangpej_id ASC', true);
		$pejabat = $this->common_model->get_query('*', 'pejabat_daerah', 'pejda_id='.$_REQUEST['pejda_id']);
		$data['row'] = $pejabat->row();
		$data['status'] = array('' => '--', 't' => 'Aktif', 'f' => 'Non Aktif');
		$data['ttd'] = array('0' => '--', '1' => 'Mengetahui', '2' => 'Diperiksa oleh');
		
		$this->load->view('edit_pejabat', $data);
	}
	
	/**
	 * update pejabat
	 */
	function update() {
		$result = $this->pejabat_model->update();
		if ($result) {
			$this->common_model->history_log("pemeliharaan", "U", "Update data pejabat");
			echo json_encode(array('status' => true, 'msg' => 'Data berhasil disimpan'));			
		} else
			echo json_encode(array('status' => false, 'msg' => 'Data gagal disimpan'));
	}
	
	/**
	 * delete data pejabat
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->pejabat_model->delete($arr_id[$i]) == true) {
				$counter++;
				$this->common_model->history_log("pemeliharaan", "d", "Delete data pejabat id ".$arr_id[$i]);
			}				
		}
		
		if ($counter != 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
}