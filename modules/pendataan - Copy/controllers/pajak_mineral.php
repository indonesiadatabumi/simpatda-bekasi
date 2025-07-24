<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pajak_bahan_galian controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Pajak_mineral extends Master_Controller {
	/**
	 * add page controller
	 */
	function add() {
		$data['sistem_pemungutan'] = array('1' => 'Self Assesment', '2' => 'Official Assesment');
		$this->load->view('add_pajak_mineral', $data);
	}
}