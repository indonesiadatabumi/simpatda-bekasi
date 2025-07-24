<?php 
/**
 * class Common_model
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121015
 */
class Common_model extends CI_Model {
	/**
	 * get record list from db and return array
	 * @param unknown_type $field_name
	 * @param unknown_type $table_name
	 * @param unknown_type $criteria
	 * @param unknown_type $order_by
	 */
	public function get_record_list($field_name, $table_name, $criteria, $order_by, $option = FALSE)
	{	
		$arr_data = array();
	
		$sql = "SELECT ".$field_name." FROM ".$table_name;
		
		if($criteria)
		{
			$sql .= " WHERE ".$criteria;
		}
		
		if($order_by)
		{
			$sql .= " ORDER BY ".$order_by;
		}			
		
		$query = $this->db->query($sql);
		
		if ($option)
			$arr_data[''] = "--";
		
		if ($query->num_rows())
		{
			foreach ($query->result() as $row)
			{
				$arr_data[$row->value] = $row->item;
			}
		}
		return $arr_data;
	}
	
	/**
	 * get record value
	 * @param unknown_type $field_name
	 * @param unknown_type $table_name
	 * @param unknown_type $criteria
	 */
	public function get_record_value($field_name, $table_name, $criteria = NULL)
	{	
		$sql = "SELECT $field_name FROM $table_name ";
		if ($criteria != NULL)
			$sql .= "WHERE $criteria";
			
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
		{
	    	return array_pop($query->row_array());
	  	}
	  
	  	return null;
	}
	
	/**
	 * get_query
	 * @param unknown_type $field_name
	 * @param unknown_type $table_name
	 * @param unknown_type $criteria
	 * @param unknown_type $order_by
	 */
	public function get_query($field_name, $table_name, $criteria = NULL, $order_by = NULL) {
		$sql = "SELECT ".$field_name." FROM ".$table_name;
		
		if(!empty($criteria) && $criteria != null)
			$sql .= " WHERE ".$criteria;
		
		if(!empty($order_by) && $order_by != null)
			$sql .= " ORDER BY ".$order_by;
		
		$query = $this->db->query($sql);
		
		return $query;
	}
	
	/**
	 * get next number wp
	 */
	function get_next_number_wp($jenis = 'p') {
		$next_nomor_urut = $this->adodb->GetOne("SELECT COALESCE(MAX(wp_wr_no_urut)::INT,0) + 1 FROM wp_wr WHERE wp_wr_jenis = '$jenis'");

		if (strlen($next_nomor_urut) < 7)  {
			$selisih = 7 - strlen($next_nomor_urut);
			for ($i=1;$i<=$selisih;$i++) {
				$next_nomor_urut = "0".$next_nomor_urut;
			}
		}
		
		return $next_nomor_urut;
	}

	/**
	 * get next number calon wp
	 */
	function get_next_number_calon_wp($jenis = 'p') {
		$next_nomor_urut = $this->adodb->GetOne("SELECT COALESCE(MAX(wp_wr_no_urut)::INT,0) + 1 FROM calon_wp_wr WHERE wp_wr_jenis = '$jenis'");

		if (strlen($next_nomor_urut) < 7)  {
			$selisih = 7 - strlen($next_nomor_urut);
			for ($i=1;$i<=$selisih;$i++) {
				$next_nomor_urut = "0".$next_nomor_urut;
			}
		}
		
		return $next_nomor_urut;
	}
	
	/**
	 * get next nomor sptpd
	 */
	function get_next_nomor_sptpd($spt_periode, $spt_jenis_pajakretribusi) {
		if (!empty($spt_periode) && !empty($spt_jenis_pajakretribusi)) {
			$sql_sptpd = "select 
							CASE WHEN MAX(spt_no_register::INT) + 1 IS NULL then 1
							ELSE MAX(spt_no_register::INT) + 1 END as max_spt_no_register 
						from spt 
						WHERE spt_periode='".$spt_periode."' AND spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."' 
							AND spt_kode='".$this->session->userdata('USER_SPT_CODE')."'";
			$next_spt_no_register = $this->adodb->GetOne($sql_sptpd);
			return $next_spt_no_register;
		}
		return false;
	}
	
	/**
	 * get next nomor formulir
	 */
	function get_next_nomor_formulir() {		
		$next_nomor_urut = $this->adodb->GetOne("SELECT COALESCE(MAX(form_nomor)::INT,0) + 1 FROM formulir");

		if (strlen($next_nomor_urut) < 8)  {
			$selisih = 8 - strlen($next_nomor_urut);
			for ($i=1;$i<=$selisih;$i++) {
				$next_nomor_urut = "0".$next_nomor_urut;
			}
		}
		
		return $next_nomor_urut;
	}
	
	/**
	 * get kecamatan
	 */
	function get_kecamatan() {
		$this->db->select('*');
		$this->db->from('kecamatan');
		$this->db->order_by('camat_kode', 'ASC');
		
		if ($this->session->userdata('USER_SPT_CODE') != "10")
			$this->db->where('camat_kode', $this->session->userdata('USER_SPT_CODE'));	
		
		$query = $this->db->get();
		
		return $query->result();
	}

	/**
	 * get kelurahanall
	 */
	function get_kelurahanall() {
		$this->db->select('*');
		$this->db->from('kelurahan');
		$this->db->order_by('lurah_kode', 'ASC');
		
		if ($this->session->userdata('USER_SPT_CODE') != "10")
			$this->db->where('lurah_kode', $this->session->userdata('USER_SPT_CODE'));	
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/**
	 * get kelurahan
	 */
	function get_kelurahan($id_kecamatan) {
		$this->db->select('lurah_id, lurah_kode, lurah_nama');
		$this->db->from('kelurahan');
		$this->db->where(array('lurah_kecamatan' => $id_kecamatan));
		$this->db->order_by('lurah_kode', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}
	
	/**
	 * get bidang usaha
	 */
	function get_bidang_usaha() {
		$result = array();
		
		$this->db->from('ref_kode_usaha');
		$this->db->order_by('ref_kodus_kode', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}
	
	/**
	 * get_pejabat_daerah
	 */
	function get_pejabat_daerah() {
		$query = $this->db->get('v_pejabat_daerah');
		return $query->result();
	}
	
	/**
	 * check is exist wp_wr
	 * @param unknown_type $nomor_urut
	 */
	function is_exist_wp_wr($nomor_urut) {
		$query = $this->db->get_where('wp_wr', array('wp_wr_no_urut' => $nomor_urut));
		return  ($query->num_rows() > 0) ? true : false;
	}

	/**
	 * check is exist calon_wp_wr
	 * @param unknown_type $nomor_urut
	 */
	function is_exist_calon_wp_wr($nomor_urut) {
		$query = $this->db->get_where('calon_wp_wr', array('wp_wr_no_urut' => $nomor_urut));
		return  ($query->num_rows() > 0) ? true : false;
	}
	
	
	/**
	 * get next nomor stpd
	 */
	function get_next_nomor_stpd($periode, $jenis_pajak) {
		if (!empty($periode) && !empty($jenis_pajak)) {
			$sql = "SELECT 
							CASE WHEN MAX(stpd_nomor::INT) + 1 IS NULL then 1
							ELSE MAX(stpd_nomor::INT) + 1 END as nomor_stpd 
						FROM stpd 
						WHERE stpd_periode='".$periode."' AND stpd_jenis_pajak='".$jenis_pajak."'";
			$next_nomor_stpd = $this->adodb->GetOne($sql);
			return $next_nomor_stpd;
		}
		return false;
	}
	
	/**
	 * history log / audit trail
	 * @param unknown_type $module
	 * @param unknown_type $action
	 * @param unknown_type $description
	 */
	function history_log($module, $action, $description) {
		$case_action = "";
		if (strlen($action) == 1) {
			switch (strtoupper($action)) {
				case "I":
					$case_action = "INSERT";
					break;
				case "U":
					$case_action = "UPDATE";
					break;
				case "D":
					$case_action = "DELETE";
					break;
				case "P":
					$case_action = "PRINT";
					break;
				default:
					$case_action = "";
					break;
			}	
		} else {
			$case_action = $action;
		}
		
		$hislog = array();
		$hislog["hislog_id"] = uuid();
		$hislog["hislog_ip_address"] = $this->input->ip_address();
		$hislog["hislog_module"] = strtoupper($module);
		$hislog["hislog_action"] = strtoupper($case_action);
		$hislog["hislog_description"] = $description;
		$hislog["hislog_opr_user"] = $this->session->userdata('USER_NAME');		
	//	$hislog["hislog_time"] = "NOW()"; 
		$hislog["hislog_time"] = date('Y-m-d H:i:s');
		$this->db->insert('history_log', $hislog);
	}
	
	/**
	 * next value
	 * @param unknown_type $seq
	 */
	function next_val($seq) {
	   	$nextval = $this->adodb->GetOne("SELECT nextval('".$seq."')");
		return $nextval;
	}
/*
	function next_val(){
			$sql = "select spt_id+1 from spt order by spt_id desc limit 1";
			$next_spt_id = $this->adodb->GetOne($sql);
			return $next_spt_id;
	}
	
	function next_val_det(){
			$sql = "select spt_dt_id+1 from spt_detail order by spt_dt_id desc limit 1";
			$next_spt_id_det = $this->adodb->GetOne($sql);
			return $next_spt_id_det;
	}
*/
	/**
	 * get value output
	 * @param unknown_type $seq
	 */
	function curr_val ($seq) {
	   	$curval = $this->adodb->GetOne("SELECT currval('".$seq."')");
		return $curval;
	}
}