<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Master wp class controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Master_wp extends Master_Controller {
	/**
	 * index page controller
	 */
	function index() {
		switch ($this->session->userdata('USER_JABATAN')) {
			case "1":
				$kodus_id = $this->config->item('kodus_hotel');
				break;
			case "2":
				$kodus_id = $this->config->item('kodus_restoran');
				break;
			case "3":
				$kodus_id = $this->config->item('kodus_hiburan');
				break;
			case "4":
				$kodus_id = $this->config->item('kodus_reklame');
				break;
			case "5":
				$kodus_id = $this->config->item('kodus_genset');
				break;
			case "7":
				$kodus_id = $this->config->item('kodus_parkir');
				break;
			case "8":
				$kodus_id = $this->config->item('kodus_air_bawah_tanah');
				break;
			default:
				$kodus_id = 0;
				break;
		}
		$data['kodus_id'] = $kodus_id;
		$this->load->view('view_master_wp', $data);
	}
	
	/**
	 * get list all wp
	 */
	function get_list() {
		$this->load->model('master_wp_model');
		$this->master_wp_model->get_list();
	}
}