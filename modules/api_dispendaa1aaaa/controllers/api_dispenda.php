<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ini_set("memory_limit", "300M");

class Api_dispenda extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('api_dispenda_model');
	}

	function index() {
		$get_data = $this->api_dispenda_model->_Get_ListData();
        	extract($_POST);

        	//set POST variables
        	$url = 'http://apibekasi.sspcity.id/welcome/get_dispenda_retribusi';
       
        	$tabel_masuk[0]['jenis_pajak_id'] = 1;
       	 	$tabel_masuk[0]['jenis_pajak_name'] = 'Pajak Hiburan';
        	$tabel_masuk[0]['tahun'] = 2016;
        	$tabel_masuk[0]['bulan'] = 12;
        	$tabel_masuk[0]['total'] = 37628736;
    
        	$ch = curl_init();
        	curl_setopt($ch, CURLOPT_URL, $url);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($tabel_masuk));
        	$response = curl_exec($ch);
		if(curl_error($ch))
		{
   			 echo 'error:' . curl_error($ch);
		}
		else{
    			echo "Dora";
		}
	}
