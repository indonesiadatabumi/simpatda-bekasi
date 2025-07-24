<?

class report {
	
	var $id;
	
	function report($id){
			$this->id= $id;
		}
	
	function qryPEMDA(){
		global $db;
		
		$qry = "select * from data_pemerintah_daerah";
		$result= $db->GetRow($qry);
		return $result;
		
		}
		
		function qryPEJABAT(){
		global $db;
		
		$qry = "select * from v_pejabat_daerah where pejda_kode='01'";
		$result= $db->GetRow($qry);
		return $result;
		
		}
		
		
	function qryDataNPWPD(){
			global $db;

			$qry= "select * from v_wp_wr where wp_wr_id='".$this->id."'";
			$result= $db->GetRow($qry);
			return $result;	
	}
	
}

?>