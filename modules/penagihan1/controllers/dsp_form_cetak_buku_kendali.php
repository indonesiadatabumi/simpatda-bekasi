<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pribadi class controller
 * @package Simpatda
 * @author Angga Pratama
 * @version 20121016
 */
class Dsp_form_cetak_buku_kendali extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('penagihan');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$arr_keterangan_spt = array("" => "(silahkan pilih...)");
		$data['keterangan_spt'] = array_merge($arr_keterangan_spt,$this->penagihan->keterangan_spt());
		$data['kecamatan'] = array_merge($arr_keterangan_spt,$this->penagihan->kecamatan());
		$data['pejabat'] = array_merge($arr_keterangan_spt,$this->penagihan->get_pejabat_daerah());
		$this->load->view('view_form_cetak_buku_kendali', $data);
	}
}