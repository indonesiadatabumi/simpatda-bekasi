<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Restore_data class controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Restore_data_uptd extends Master_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('restore_data_model');
	}
	
	/**
	 * index page controller
	 */
	function index()
	{
		$this->load->view('form_restore_data_uptd');
	}
	
	/**
	 * export data to json
	 */
	function upload() {
		$status = false;
		$msg = "";
		$total_row = 0;
		$path = "";
		$file_element_name = 'userfile';
		
		$config['file_name'] = date("YmdHis");
		$config['upload_path'] = $this->config->item('import_files');
		$config['allowed_types'] = '*';
		$config['max_size'] = '10240';	//10 MB
		
		//load library upload
		$this->load->library('upload', $config);		

		if (!$this->upload->do_upload($file_element_name)) {
			$msg = $this->upload->display_errors('', '');
		} else {
			$status = true;
			$upload = $this->upload->data();
			
			if ($upload['file_ext'] == ".json") {
				try {
					//open the json file
					$path = $upload["full_path"];
					$contents = file_get_contents($path);
									
					$json = json_decode($contents);
					//print_r($json->{'list_spt'}); 
					$sum_spt = count($json->{'list_spt'});
					$sum_spt_air_tanah = count(@$json->{'list_spt_air_tanah'});
					
					$total_row = $sum_spt + $sum_spt_air_tanah;
				} catch (Exception $e) {
					$msg = "Error $e";
				}
			}
		}
		
		@unlink($_FILES["txt_attachment"]);
		
		echo json_encode(array('status' => $status, 'msg' => $msg, 'total_spt' => $total_row, 'file_path' => $path));
	}
	
	/**
	 * this function to restore data form file_path
	 */
	function restore() {
		$this->restore_data_model->insert_data();
	}
}