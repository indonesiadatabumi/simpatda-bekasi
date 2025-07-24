<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Dokumentasi_pengolahan controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Dokumentasi_pengolahan extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		$this->load->model('common_model');
		$this->load->model('dokumentasi_pengolahan_model');
	}
	
	/**
	 * cetak daftar induk controller
	 */
	function daftar_induk_wpwr() {
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$data['kecamatan'] = $this->get_kecamatan();
		$data['kelurahan'] = array('' => '--');
		
		$bidang_usaha = array();
		$arr_bidang_usaha = $this->common_model->get_bidang_usaha();
		if (count($arr_bidang_usaha))
		{
			if ($this->session->userdata('USER_REF_KODUS_ID') == "" || $this->session->userdata('USER_REF_KODUS_ID') == null) {
				$bidang_usaha[''] = '--';
				foreach ($arr_bidang_usaha as $row)
				{
					$bidang_usaha[$row->ref_kodus_id] = $row->ref_kodus_kode.'.'.$row->ref_kodus_nama;
				}
			} else {
				foreach ($arr_bidang_usaha as $row)
				{
					if ($this->session->userdata('USER_REF_KODUS_ID') == $row->ref_kodus_id)
						$bidang_usaha[$row->ref_kodus_id] = $row->ref_kodus_kode.'.'.$row->ref_kodus_nama;
				}
			}			
		}
		$data['bidang_usaha'] = $bidang_usaha;
		
		$this->load->view('form_daftar_induk_wpwr', $data);
	}
	
	/**
	 * export_daftar_induk
	 */
	function export_daftar_induk() {
		$mengetahui = $this->input->get('mengetahui');
		$pemeriksa = $this->input->get('pemeriksa');
	    
	    //data mengetahui
	    $dt_mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='$mengetahui'");
	   	$data['mengetahui'] = array();
	   	if ($dt_mengetahui->num_rows() > 0) {
	   		$data['mengetahui'] = $dt_mengetahui->row();
	   	}
	    
		//data pemeriksa
	    $dt_pemeriksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='$pemeriksa'");
	   	$data['pemeriksa'] = array();
	   	if ($dt_pemeriksa->num_rows() > 0) {
	   		$data['pemeriksa'] = $dt_pemeriksa->row();
	   	}
	    
	    //data pemda
	    $pemda = $this->common_model->get_query('*', 'data_pemerintah_daerah');
	    $data['pemda'] = $pemda->row();
	    $data['linespace'] = $this->input->get('linespace');
	    
	    //insert history log ($module, $action, $description)
		$this->common_model->history_log("pendaftaran", "P", "Print Daftar Induk Wajib Pajak");
	    
	    //load view pdf
	   	$this->load->view('pdf_daftar_induk_wpwr', $data);
	}
	
	/**
	 * export to xls
	 */
	function export_daftar_induk_xls() {
		error_reporting(E_ERROR | E_WARNING | E_PARSE);

		//add library
		require_once(APPPATH.'libraries/Worksheet.php');
		require_once(APPPATH.'libraries/Workbook.php');
		
		$mengetahui = $this->input->get('mengetahui');
		$pemeriksa = $this->input->get('pemeriksa');
		
	    //data pemda
	    $pemda = $this->common_model->get_query('*', 'data_pemerintah_daerah');
	    $data['pemda'] = $pemda->row();
	    $data['linespace'] = $this->input->get('linespace');

  		function HeaderingExcel($filename) {
		      header("Content-type: application/vnd.ms-excel");
		      header("Content-Disposition: attachment; filename=$filename" );
		      header("Expires: 0");
		      header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		      header("Pragma: public");
		 }
		
		  // HTTP headers
		  HeaderingExcel('daftar_wp.xls');
		  
		   // Creating a workbook
		  $workbook = new Workbook("-");
		  
		  $formatot =& $workbook->add_format();
		  $formatot->set_size(10);
		  $formatot->set_bold();
		  $formatot->set_align('center');
		  $formatot->set_color('white');
		  $formatot->set_pattern();
		  $formatot->set_fg_color('grey');
		  
		  
		  // Creating the first worksheet
		  $worksheet1 =& $workbook->add_worksheet('Daftar WP');
		  $worksheet1->set_column(0,0,5);
		  $worksheet1->set_column(0,1,30);
		  $worksheet1->set_column(0,2,70);
		  $worksheet1->set_column(0,3,20);
		  $worksheet1->set_column(0,4,15);
		  
		  $fDate = $this->input->get('fDate');
			$tDate = $this->input->get('tDate');
		
			if (empty($fDate)) {
				$fDate = "Keadaan";
			}
			else {
				$fDate = "Dari tanggal ".tanggal_lengkap($fDate);
			}
		
			if (empty($tDate))
				$tDate = "tanggal ".tanggal_lengkap(date("d-m-Y"));
			else 
				$tDate = "tanggal ".tanggal_lengkap($tDate);
		  
		  $worksheet1->write_string(0, 0, "Daftar Induk Wajib Pajak");
		  $worksheet1->write_string(1, 0, $fDate." - ".$tDate);
		  
		  $worksheet1->write_string(4, 0, "No");
		  $worksheet1->write_string(4, 1, "Nama");
		  $worksheet1->write_string(4, 2, "Alamat Lengkap");
		  $worksheet1->write_string(4, 3, "N P W P D");
		  $worksheet1->write_string(4, 4, "Tgl. Daftar");
		  
		//Prepare data
		$andwhere = "";
		if (!empty($_GET['wp_wr_golongan'])) { 
			if ($_GET['wp_wr_golongan'] == "1") { $andwhere .= " AND b.wp_wr_gol='1'"; }
			elseif ($_GET['wp_wr_golongan'] == "2") { $andwhere .= " AND b.wp_wr_gol='2'"; }
		}
		
		$fromDate = $this->input->get('fDate');
		if (!empty($fromDate))
		{
			$andwhere .= " AND wp_wr_tgl_kartu >= '".format_tgl($fromDate)."'";
		}
		
		$toDate = $this->input->get('tDate');
		if ( ! empty($toDate))
		{
			$andwhere .= " AND wp_wr_tgl_kartu <= '".format_tgl($toDate)."'";
		}
		
		$wpwr_kdusaha = $_GET['bidus'];
		$wpwr_kdcamat = $_GET['camat'];
		$wpwr_kdlurah = $_GET['lurah'];
		$wpwr_jenis = $_GET['wp_wr_jenis'];
		
		if(!empty($wpwr_kdusaha)) {
			$andwhere .= " AND b.wp_wr_bidang_usaha='$wpwr_kdusaha'";
			if(!empty($wpwr_kdcamat)) {
				$camat = explode("|", $wpwr_kdcamat);
				$andwhere .= " AND b.wp_wr_kd_camat='".$camat[0]."'";
				if(!empty($wpwr_kdlurah)) {
					$lurah = explode("|", $wpwr_kdlurah);
					$andwhere .= " AND b.wp_wr_kd_lurah='".$lurah[0]."'";
					$sql = "SELECT * FROM v_wp_wr b WHERE b.wp_wr_jenis='$wpwr_jenis' AND b.wp_wr_status_aktif='TRUE'".$andwhere." ORDER BY b.wp_wr_no_urut ASC";
					$case = 1;
				}
				elseif(empty($wpwr_kdlurah)) {
					
					//$sql = "SELECT DISTINCT lurah_kode,wp_wr_kd_lurah,wp_wr_lurah FROM v_wp_wr WHERE wp_wr_jenis='$wpwr_jenis' AND wp_wr_status_aktif='TRUE'" . $andwhere . " ORDER BY lurah_kode ASC";
					$sql = "SELECT DISTINCT a.* FROM kelurahan a 
				LEFT JOIN v_wp_wr b ON a.lurah_id::INT=b.wp_wr_kd_lurah::INT 
				WHERE b.wp_wr_jenis='$wpwr_jenis' AND b.wp_wr_status_aktif='TRUE'" . $andwhere . " ORDER BY a.lurah_kode ASC";
					$case = 2;
				}
			}
			else {
				
				//$sql = "SELECT DISTINCT camat_kode,wp_wr_kd_camat,wp_wr_camat FROM v_wp_wr WHERE wp_wr_jenis='$wpwr_jenis' AND wp_wr_status_aktif='TRUE'" . $andwhere." ORDER BY camat_kode ASC";
				$sql = "SELECT DISTINCT a.camat_kode,a.camat_id as wp_wr_kd_camat,a.camat_nama as wp_wr_camat FROM kecamatan a 
				LEFT JOIN v_wp_wr b ON a.camat_kode=b.camat_kode 
				WHERE b.wp_wr_jenis='$wpwr_jenis' AND b.wp_wr_status_aktif='TRUE'" . $andwhere." ORDER BY a.camat_kode ASC";
				$case = 3;
			}
		}
		elseif(empty($wpwr_kdusaha)) {	
			if(!empty($wpwr_kdcamat)) {
				$camat = explode("|", $wpwr_kdcamat);
				$andwhere .= " AND b.wp_wr_kd_camat='".$camat[0]."'";
				if(!empty($wpwr_kdlurah)) {
					$lurah = explode("|", $wpwr_kdlurah);
					$andwhere .= " AND b.wp_wr_kd_lurah='".$lurah[0]."'";
				}
				$sql = "SELECT * FROM v_wp_wr b WHERE b.wp_wr_jenis='$wpwr_jenis' AND b.wp_wr_status_aktif='TRUE'" . $andwhere . " ORDER BY b.wp_wr_no_urut ASC";
			}
			else {
				$sql = "SELECT * FROM v_wp_wr b WHERE b.wp_wr_jenis='$wpwr_jenis' AND b.wp_wr_status_aktif='TRUE'" . $andwhere . " ORDER BY b.wp_wr_no_urut ASC";
			}
			$case = 4;
		}
		
		$no_baris = 5;
		switch($case) {
			case 2:
				$ar_data = $this->adodb->GetAll($sql);
				if(!empty($ar_data)) {
					$spc = array();
					$data1 = array();
					foreach($ar_data as $k => $v) {
						$jdl = 'Kelurahan ' . $v['lurah_nama'];
						$wherex = " AND wp_wr_kd_camat='$v[lurah_kecamatan]' AND wp_wr_kd_lurah='$v[lurah_id]' AND wp_wr_status_aktif='TRUE'";
						
						$fromDate = $this->input->get('fDate');
						if (!empty($fromDate))
						{
							$wherex .= " AND wp_wr_tgl_kartu >= '".format_tgl($fromDate)."'";
						}
						
						$toDate = $this->input->get('tDate');
						if ( ! empty($toDate))
						{
							$wherex .= " AND wp_wr_tgl_kartu <= '".format_tgl($toDate)."'";
						}
		
						$data1[0]['TEXT'] = "<sb>" . $counter . "</sb>";
						$data1[1]['TEXT'] = "<sb>" . strtoupper($jdl) . "</sb>";
						$data1[1]['COLSPAN']  = 4;
						$data1[0]['T_ALIGN'] = 'C';
						$data1[0]['BRD_TYPE'] = 'LT';$data1[1]['BRD_TYPE'] = 'LRT';
						$data1[0]['T_SIZE'] = 8;$data1[1]['T_SIZE'] = 8;
						$data1[0]['LN_SIZE'] = $linespace;$data1[1]['LN_SIZE'] = $linespace;
						$pdf->tbDrawData($data1);
						
						$sqlx = "SELECT * FROM v_wp_wr WHERE wp_wr_jenis='$wpwr_jenis' AND wp_wr_bidang_usaha='$wpwr_kdusaha'" . $wherex . " ORDER BY wp_wr_no_urut ASC";
						$ardat = $this->adodb->GetAll($sqlx);
						if(!empty($ardat)) {
			  				$no_urut  = 1;
							foreach($ardat as $k1 => $v1) {
								if($case = 2) $alamat_lengkap = str_replace("\n","",$v1[wp_wr_almt]);
								if($case = 3) $alamat_lengkap .= ' Kel. ' . $v1[wp_wr_lurah];
							
								$worksheet1->write_string($no_baris,0,$no_urut);
							  	$worksheet1->write_string($no_baris,1,$v1['wp_wr_nama']);
							  	$worksheet1->write_string($no_baris,2,strtoupper($alamat_lengkap));
							  	$worksheet1->write_string($no_baris,3,$v1['npwprd']);
							  	$worksheet1->write_string($no_baris,4,format_tgl($v1['wp_wr_tgl_terima_form']));
							  	
							  	$no_urut++;
							  	$no_baris++;
							}
						}
					}
				}
				break;
			case 3:
				$ar_data = $this->adodb->GetAll($sql);
				if(!empty($ar_data)) {
					$no_judul = 1;
					$spc = array();
					$data1 = array();
					foreach($ar_data as $k => $v) {						
						if($v[camat_kode]) {
							$jdl = 'Kecamatan ' . $v[wp_wr_camat];
							$wherex = " AND wp_wr_kd_camat='$v[wp_wr_kd_camat]'  AND wp_wr_status_aktif='TRUE'";
						}
						elseif($v[lurah_kode]) {
							$jdl = 'Kelurahan ' . $v[wp_wr_lurah];
							$wherex = " AND wp_wr_kd_lurah='$v[wp_wr_kd_lurah]'  AND wp_wr_status_aktif='TRUE'";
						}
						
						$fromDate = $this->input->get('fDate');
						if (!empty($fromDate))
						{
							$wherex .= " AND wp_wr_tgl_kartu >= '".format_tgl($fromDate)."'";
						}
						
						$toDate = $this->input->get('tDate');
						if ( ! empty($toDate))
						{
							$wherex .= " AND wp_wr_tgl_kartu <= '".format_tgl($toDate)."'";
						}
						
						
						if($case = 2) $alamat_lengkap = str_replace("\n","",$v1[wp_wr_almt]);
						if($case = 3) $alamat_lengkap .= ' Kel. ' . $v1[wp_wr_lurah];
					
						$worksheet1->write_string($no_baris,0,strtoupper($jdl));
					  	
					  	$no_judul++;
					  	$no_baris++;
						
						$sqlx = "SELECT * FROM v_wp_wr WHERE wp_wr_jenis='$wpwr_jenis' AND wp_wr_bidang_usaha='$wpwr_kdusaha'" . $wherex . " ORDER BY wp_wr_no_urut ASC";
						$ardat = $this->adodb->GetAll($sqlx);
						if(!empty($ardat)) {
							$no_urut  = 1;
							foreach($ardat as $k1 => $v1) {
								if($case = 2) $alamat_lengkap = str_replace("\n","",$v1[wp_wr_almt]);
								if($case = 3) $alamat_lengkap .= ' Kel. ' . $v1[wp_wr_lurah];
							
								$worksheet1->write_string($no_baris,0,$no_urut);
							  	$worksheet1->write_string($no_baris,1,$v1['wp_wr_nama']);
							  	$worksheet1->write_string($no_baris,2,strtoupper($alamat_lengkap));
							  	$worksheet1->write_string($no_baris,3,$v1['npwprd']);
							  	$worksheet1->write_string($no_baris,4,format_tgl($v1['wp_wr_tgl_terima_form']));
							  	
							  	$no_urut++;
							  	$no_baris++;
							}
						}
						
						$counter++;
					}
				}
				break;
			case 1:
			case 4:
				$ar_data = $this->adodb->GetAll($sql);
				if(!empty($ar_data)) {
					$no_urut = 1;
					$data1 = array();
					foreach($ar_data as $k => $v) {
						if(!empty($wpwr_kdcamat) && empty($wpwr_kdlurah)) {
							$alamat_lengkap = str_replace("\n","",$v[wp_wr_almt]) . ' Kel. ' . $v[wp_wr_lurah];
						}
						elseif(!empty($wpwr_kdlurah)) {
							$alamat_lengkap = str_replace("\n","",$v[wp_wr_almt]);
						}
						else {
							$alamat_lengkap = str_replace("\n","",$v[wp_wr_almt]) . ' Kel. ' . $v[wp_wr_lurah] . ' Kec. ' . $v[wp_wr_camat];
						}
						$kodus = $this->adodb->GetOne("SELECT ref_kodus_nama FROM ref_kode_usaha WHERE ref_kodus_id='".$v[wp_wr_bidang_usaha]."'");
						
						if($case = 2) $alamat_lengkap = str_replace("\n","",$v1[wp_wr_almt]);
						if($case = 3) $alamat_lengkap .= ' Kel. ' . $v1[wp_wr_lurah];
					
						$worksheet1->write_string($no_baris,0,$no_urut);
					  	$worksheet1->write_string($no_baris,1,$v1['wp_wr_nama']);
					  	$worksheet1->write_string($no_baris,2,strtoupper($alamat_lengkap));
					  	$worksheet1->write_string($no_baris,3,$v1['npwprd']);
					  	$worksheet1->write_string($no_baris,4,format_tgl($v1['wp_wr_tgl_terima_form']));
					  	
					  	$no_urut++;
					  	$no_baris++;
					}
				}
				break;
		}
		
		//insert history log ($module, $action, $description)
		$this->common_model->history_log("pendaftaran", "P", "Print Daftar Induk Wajib Pajak");
		
		$workbook->close();
	}
	
	/**
	 * daftar tutup wp
	 */
	function daftar_wpwr_tutup() {
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$data['kecamatan'] = $this->get_kecamatan();
		$bidang_usaha = array();
		$arr_bidang_usaha = $this->common_model->get_bidang_usaha();
		if (count($arr_bidang_usaha) > 0)
		{
			$bidang_usaha[''] = '--';
			foreach ($arr_bidang_usaha as $row)
			{
				$bidang_usaha[$row->ref_kodus_id] = $row->ref_kodus_kode.'.'.$row->ref_kodus_nama;
			}		
		}
		$data['bidang_usaha'] = $bidang_usaha;
		$this->load->view('form_daftar_wpwr_tutup', $data);
	}
	
	/**
	 * export data wp tutup
	 */
	function export_wp_tutup() {
		$mengetahui = $this->input->get('mengetahui');
		$pemeriksa = $this->input->get('pemeriksa');
	    
	    //data mengetahui
	    $dt_mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='$mengetahui'");
	   	$data['mengetahui'] = array();
	   	if ($dt_mengetahui->num_rows() > 0) {
	   		$data['mengetahui'] = $dt_mengetahui->row();
	   	}
	    
		//data pemeriksa
	    $dt_pemeriksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='$pemeriksa'");
	   	$data['pemeriksa'] = array();
	   	if ($dt_pemeriksa->num_rows() > 0) {
	   		$data['pemeriksa'] = $dt_pemeriksa->row();
	   	}
	   	
		//get from database
		$query = $this->dokumentasi_pengolahan_model->get_list_wp_tutup();
	    $data['arr_data'] = $query;
	    
	    //data pemda
	    $pemda = $this->common_model->get_query('*', 'data_pemerintah_daerah');
	    $data['pemda'] = $pemda->row();
	    
	    //insert history log ($module, $action, $description)
		$this->common_model->history_log("pendaftaran", "P", "Print Daftar Penutupan Wajib Pajak");
	    
	    //load view pdf
	   	$this->load->view('pdf_daftar_wpwr_tutup', $data);
	}
	
	/**
	 * daftar perkembangan wp
	 */
	function daftar_perkembangan_wpwr() {
		$bidang_usaha = array();
		$arr_bidang_usaha = $this->common_model->get_bidang_usaha();
		if (count($arr_bidang_usaha) > 0)
		{
			$bidang_usaha[''] = '-- ALL --';
			foreach ($arr_bidang_usaha as $row)
			{
				$bidang_usaha[$row->ref_kodus_id] = $row->ref_kodus_kode.'.'.$row->ref_kodus_nama;
			}		
		}
		$data['bidang_usaha'] = $bidang_usaha;
		$data['pejabat_daerah'] = $this->get_pejabat_daerah();
		$this->load->view('form_daftar_perkembangan_wpwr', $data);
	}
	
	/**
	 * perkembangan wp
	 */
	function pdf_perkembangan_wp() {
		$mengetahui = $this->input->get('mengetahui');
		$pemeriksa = $this->input->get('pemeriksa');
	    
	    //data mengetahui
	    $dt_mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='$mengetahui'");
	   	$data['mengetahui'] = array();
	   	if ($dt_mengetahui->num_rows() > 0) {
	   		$data['mengetahui'] = $dt_mengetahui->row();
	   	}
	    
		//data pemeriksa
	    $dt_pemeriksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='$pemeriksa'");
	   	$data['pemeriksa'] = array();
	   	if ($dt_pemeriksa->num_rows() > 0) {
	   		$data['pemeriksa'] = $dt_pemeriksa->row();
	   	}
	   	
	   	//insert history log ($module, $action, $description)
		$this->common_model->history_log("pendaftaran", "P", "Print Daftar Perkembangan Wajib Pajak");
	    
	    //load view pdf
	   	$this->load->view('pdf_daftar_perkembangan_wp', $data);
	}
	
	/**
	 * rekap perkembangan wp
	 */
	function pdf_rekap_perkembangan_wp() {
		
	}
	
	/**
	 * export perkembangan wp
	 */
	function pdf_perkembangan_lama() {
		$mengetahui = $this->input->get('mengetahui');
		$pemeriksa = $this->input->get('pemeriksa');
	    
	    //data mengetahui
	    $dt_mengetahui = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='$mengetahui'");
	   	$data['mengetahui'] = array();
	   	if ($dt_mengetahui->num_rows() > 0) {
	   		$data['mengetahui'] = $dt_mengetahui->row();
	   	}
	    
		//data pemeriksa
	    $dt_pemeriksa = $this->common_model->get_query('*', 'v_pejabat_daerah', "pejda_id='$pemeriksa'");
	   	$data['pemeriksa'] = array();
	   	if ($dt_pemeriksa->num_rows() > 0) {
	   		$data['pemeriksa'] = $dt_pemeriksa->row();
	   	}
	    
	    //data pemda
	    $pemda = $this->common_model->get_query('*', 'data_pemerintah_daerah');
	    $data['pemda'] = $pemda->row();
	    
	    //insert history log ($module, $action, $description)
		$this->common_model->history_log("pendaftaran", "P", "Print Daftar Perkembangan Wajib Pajak");
	    
	    //load view pdf
	   	$this->load->view('pdf_lama_daftar_perkembangan_wpwr', $data);
	}
	
	/**
	 * get kecamatan
	 */
	function get_kecamatan($key_nama = TRUE) {
		$kecamatan = $this->common_model->get_kecamatan();
		//get kecamatan
		$arr_kecamatan = array();
		
		if ($this->session->userdata('USER_SPT_CODE') == "10")
			$arr_kecamatan[''] = "--";
			
		foreach ($kecamatan as $row) {
			$arr_kecamatan[$row->camat_id.'|'.$row->camat_nama] = $row->camat_kode.' | '.$row->camat_nama;
		}
		
		return  $arr_kecamatan;
	}
	
	/**
	 * get pejabat daerah
	 */
	function get_pejabat_daerah() {
		$pejabat_daerah = $this->common_model->get_pejabat_daerah();
		$arr_pejabat = array();
		$arr_pejabat['0'] = '--';
		if (count($pejabat_daerah) > 0) {
			foreach ($pejabat_daerah as $row) {
				$arr_pejabat[$row->pejda_id] = $row->pejda_nama.' / '.$row->ref_japeda_nama;
			}
		}
		
		return $arr_pejabat;
	}
}