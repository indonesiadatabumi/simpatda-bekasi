<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Main class controller
 * @author Daniel Hutauruk
 */
class Main extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
	}

	/**
	 * Index Page for this controller.
	 */
	function index()
	{
		$this->load->view('main', $this->data);
	}
	
	/**
	 * home controller
	 */
	function home() {
		$this->load->view('home');
	}
	
	/**
	 * change password controller
	 */
	function change_password() {
		$this->load->view("change_password");
	}
	
	/**
	 * function to save change password
	 */
	function save_password() {
		$this->load->model('operator_model');
		$return = $this->operator_model->update_password();
		
		if ($return) {
			echo json_encode(array('status' => true, 'msg' => 'Password berhasil disimpan'));
		} else {
			echo json_encode(array('status' => false, 'msg' => 'Password gagal disimpan'));
		}
	}
}

/* End of file main.php */
/* Location: ./application/controllers/mainphp */