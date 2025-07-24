<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author		Daniel
 * @copyright 2012
 */
class Login extends CI_Controller
{
	/**
	 * constructor
	 */
	function __construct()
	{
		parent::__construct();

		//load the model	
		$this->load->model('operator_model');
		$this->load->model('common_model');
	}

	/**
	 * index page controller
	 */
	function index()
	{
		if ($this->session->userdata('USER_ID') != null) {
			echo "success";
		} else {
			$this->form_validation->set_rules('txt_username', 'User ID', 'required');
			$this->form_validation->set_rules('txt_password', 'Password', 'required');

			if ($_POST) {
				echo $this->_is_postback();
			} else {
				$this->_not_is_postback();
			}
		}
	}

	/**
	 * not is postback
	 */
	function _not_is_postback()
	{
		$this->load->view('login');
	}

	/**
	 * is postback
	 */
	function _is_postback()
	{
		if ($this->form_validation->run() === TRUE) {
			if ($this->check_session() != true)
				$result = $this->operator_model->attempt_login($_POST['txt_username'], $_POST['txt_password']);
			else
				$result = 'success';

			return $result;
		} else {
			return validation_errors(' ', ' ');
		}
	}

	/**
	 * function to check user session
	 */
	function check_session()
	{
		if ($this->session->userdata('USER_ID') != null && $this->session->userdata('USER_ID') != "")
			return true;
		else
			return false;
	}

	/**
	 * check is admin or not
	 */
	function popup_authentication()
	{
		$action = $this->input->get('action');
		$data['action'] = (!empty($action) ? $action : 'update');
		$this->load->view('popup_authentication', $data);
	}

	/**
	 * check authentication for update/delete data
	 */
	function check_authentication()
	{
		$query = $this->operator_model->check_authorize(
			$this->input->post('username'),
			$this->input->post('password')
		);
		if ($query->num_rows() > 0)
			echo 'success';
		else
			echo 'failed';
	}
}

	
/* End of file login.php */
/* Location: ./system/application/controllers/login.php */