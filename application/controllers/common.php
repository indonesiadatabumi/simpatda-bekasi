<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * class Common 
 * @author Daniel
 * @package Simpatda
 * @version 20121016
 */
class Common extends CI_Controller
{
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
	}
	
	/**
	 * get_next_number_wp
	 */
	function get_next_number_wp() {
		$result = $this->common_model->get_next_number_wp();
		echo $result;
	}

	/**
	 * get_next_number_calon_wp
	 */
	function get_next_number_calon_wp() {
		$result = $this->common_model->get_next_number_calon_wp();
		echo $result;
	}
	
	/**
	 * get next nomor sptpd controller
	 */
	function get_next_nomor_sptpd() {
		$spt_periode = $this->input->post('spt_periode');
		$spt_jenis_pajakretribusi = $this->input->post('spt_jenis_pajakretribusi');
		$spt_periode = (empty($spt_periode) ? date("Y") : $spt_periode);
		
		$no_spt = $this->common_model->get_next_nomor_sptpd($spt_periode, $spt_jenis_pajakretribusi);	
		echo format_angka($this->config->item('length_no_spt'), $no_spt);
	}
	
	/**
	 * get kecamatan
	 */
	function get_kecamatan() {
		$result = $this->common_model->get_kecamatan();
		echo json_encode($result);
	}
	
	/**
	 * get kelurahan controller
	 */
	function get_kelurahan() {
		$kecamatan = $this->input->get('_value');
		$arr_kecamatan =  explode("|", $kecamatan);
		if (count($arr_kecamatan) > 0)
			$id_kecamatan = $arr_kecamatan[0];
		else 
			$id_kecamatan = $kecamatan;
		
		if (empty($id_kecamatan)) return false;
		
		$rs_kelurahan = $this->common_model->get_kelurahan($id_kecamatan);
		
		$arr_data = array();
		$arr_data[] = array("" => "--");
		if (count($rs_kelurahan) > 0)
		{
			foreach ($rs_kelurahan as $row)
			{
				$arr_data[] = array($row->lurah_id.'|'.$row->lurah_nama => $row->lurah_kode.' | '.$row->lurah_nama);
			}
		}
		
		if(!empty($arr_data)){
			echo json_encode($arr_data);
		}
	}
	
	/**
	 * get kelurahan controller
	 */
	function get_kelurahan_id() {
		$kecamatan = $this->input->get('_value');
		$arr_kecamatan =  explode("|", $kecamatan);
		if (count($arr_kecamatan) > 0)
			$id_kecamatan = $arr_kecamatan[0];
		else 
			$id_kecamatan = $kecamatan;
		
		if (empty($id_kecamatan)) return false;
		
		$rs_kelurahan = $this->common_model->get_kelurahan($id_kecamatan);
		
		$arr_data = array();
		$arr_data[] = array("" => "--");
		if (count($rs_kelurahan) > 0)
		{
			foreach ($rs_kelurahan as $row)
			{
				$arr_data[] = array($row->lurah_id => $row->lurah_kode.' | '.$row->lurah_nama);
			}
		}
		
		if(!empty($arr_data)){
			echo json_encode($arr_data);
		}
	}
}