<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH',$this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';
//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';
//Class Extention for header and footer	
require_once APPPATH.'libraries/fpdf/table/header_footer_daftarinduk.inc';

if(empty($linespace)) $linespace = 5;

if ($this->input->get('wp_wr_jenis') == "p")
	$paret = "WAJIB PAJAK";
elseif ($this->input->get('wp_wr_jenis') == "r") 
	$paret = "WAJIB RETRIBUSI";
	
$judulplus = "";
  if($this->input->get('camat') == "") {
	$judulplus = " SE-KOTA BEKASI";
}

$bidus = "";
if($this->input->get('bidus') != "") {
	//$bidus = getKodusName($wpwr_kdusaha);
	$bidus = $this->adodb->GetOne("SELECT ref_kodus_nama FROM ref_kode_usaha WHERE ref_kodus_id='".$this->input->get('bidus')."'");
}

$pdf = new pdf_usage('L','mm','legal'); // Portrait dengan ukuran kertas A4
$pdf->Open();
$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(10, 20, 10);     // Margin Left, Top, Right 2 cm
$pdf->AddPage();
$pdf->AliasNbPages();
$bTableSplitMode = true;
$pdf->SetStyle("sb","arial","B",8,"0,0,0");
$pdf->SetStyle("b","arial","B",6,"0,0,0");
$pdf->SetStyle("h1","arial","B",12,"0,0,0");
$pdf->SetStyle("h2","arial","B",10,"0,0,0");
$pdf->SetStyle("nu","arial","U",9,"0,0,0");
$pdf->SetStyle("s","arial","",6,"0,0,0");

$logo = "assets/".$pemda->dapemda_logo_path;
$pdf->Image($logo,10,13,13);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',10).$pdf->Cell(12,3,"",'','','C').
					$pdf->Cell(50,3,"PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".
					$pemda->dapemda_nm_dati2),'','','L').$pdf->Cell(80,3,"",'','','C').
					$pdf->Cell(48,3,"",'','','C'),'','','',0);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',10).$pdf->Cell(12,3,"",'','','C').
					$pdf->Cell(50,3,strtoupper($pemda->nama_dinas),'','','L').$pdf->Cell(80,3,"",'','','C').
					$pdf->Cell(48,3,"",'','','C'),'','','',0);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',8).$pdf->Cell(12,3,"",'','','C').
					$pdf->Cell(50,3,ucwords(strtolower($pemda->dapemda_lokasi))." - ".
					ucwords(strtolower($pemda->dapemda_ibu_kota)),'','','L').$pdf->Cell(80,3,"",'','','C').
					$pdf->Cell(48,3,"",'','','C'),'','','',0);
					
$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',8).$pdf->Cell(12,4,"",'','','C').$pdf->Cell(50,3,"Telp. " .
					$pemda->dapemda_no_telp,'','','L').$pdf->SetFont('Arial','B',12).
					$pdf->Cell(190,4,"DAFTAR INDUK ".$paret." ".strtoupper($bidus).$judulplus,'','','C').$pdf->Cell(192,4,"",'','','C'),'','','',0);
	
$fDate = $this->input->get('fDate');
$tDate = $this->input->get('tDate');

if (empty($fDate)) {
	$fDate = "Keadaan";
}
else {
	$fDate = "Yang terdaftar dari tanggal ".tanggal_lengkap($fDate);
}

if (empty($tDate))
	$tDate = "tanggal ".tanggal_lengkap(date("d-m-Y"));
else 
	$tDate = "tanggal ".tanggal_lengkap($tDate);

$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',5).$pdf->Cell(12,4,"",'','','C').$pdf->Cell(50,3,"",'','','L').
					$pdf->SetFont('Arial','B',9).$pdf->Cell(190,4,"$fDate s/d $tDate ",'','','C').
					$pdf->Cell(192,4,"",'','','C'),'','','',0);

$pdf->MultiCell(190,4,"",'','','',0);

$kecamatan = "";
$kelurahan = "";

$pdf->MultiCell(190,4,"",'','','',0);
if ($_GET['camat'] != "")  { 
	$camat = explode("|", $_GET['camat']);
	$kecamatan = "Kecamatan : " . $camat[1];
	if($_GET['lurah'] == "") {
		$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',8).$pdf->Cell(190,4,"".$kecamatan,'','','L'),'','','',0);
	}
	else {
		$lurah = explode("|", $_GET['lurah']);
		$kelurahan = "Kelurahan : " . $lurah[1];
		$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',8).$pdf->Cell(95,4,"".$kecamatan,'','','L').$pdf->Cell(95,4,"".$kelurahan,'','','L'),'','','',0);
	}
}

//Printable Area 185 mm
$kolom = 5;
$pdf->tbInitialize($kolom, true, true);
$pdf->tbSetTableType($table_default_tbl_type);
for($i=0; $i<$kolom; $i++) $header[$i] = $table_default_header_type;
	
for($i=0; $i<$kolom; $i++) {
	//$ket[$i] = $table_noborder;
	$th1[$i] = $table_default_tblheader_type;
	$th2[$i] = $table_default_tblheader_type;
}

$th1[0]['WIDTH'] = 10;
$th1[1]['WIDTH'] = 90;
$th1[2]['WIDTH'] = 150;
$th1[3]['WIDTH'] = 40;
$th1[4]['WIDTH'] = 26;

$th1[0]['TEXT'] = "<b>NO.</b>";
$th1[1]['TEXT'] = "<b>N A M A</b>";
$th1[2]['TEXT'] = "<b>A L A M A T   L E N G K A P</b>";
$th1[3]['TEXT'] = "<b>N P W P D</b>";
$th1[4]['TEXT'] = "<b>KETERANGAN</b>";
$th1[1]['LN_SIZE'] = 8;
$th1[0]['BRD_TYPE'] = 'LT';
$th1[1]['BRD_TYPE'] = 'LT';
$th1[2]['BRD_TYPE'] = 'LT';
$th1[3]['BRD_TYPE'] = 'LT';
$th1[4]['BRD_TYPE'] = 'LRT';

$arHeader = array(
	$th1
);

$pdf->tbSetHeaderType($arHeader, true);
$pdf->tbDrawHeader();

$datax = array();
for($i=0; $i<$kolom; $i++) $datax[$i] = $table_default_tbldata_type_ln_6;

$pdf->tbSetDataType($datax);

//Prepare data
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

//echo $case."                 ".$sql;

switch($case) {
	case 2:
		$ar_data = $this->adodb->GetAll($sql);
		if(!empty($ar_data)) {
			$counter = 1;
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
					$nmr = 1;
					$data2 = array();
					foreach($ardat as $k1 => $v1) {
						if($case = 2) $alamat_lengkap = str_replace("\n","",$v1[wp_wr_almt]);
						if($case = 3) $alamat_lengkap .= ' Kel. ' . $v1[wp_wr_lurah];
						$data2[0]['TEXT'] = $nmr . ".";
						$data2[1]['TEXT'] = $v1[wp_wr_nama];
						$data2[2]['TEXT'] = strtoupper($alamat_lengkap);
						$data2[3]['TEXT'] = $v1[npwprd];
						//$data2[4]['TEXT'] = $v1[wp_wr_nama_milik];
						$data2[4]['TEXT'] = "";
						
						$data2[0]['T_ALIGN'] = 'R';$data2[3]['T_ALIGN'] = 'C';$data2[4]['T_ALIGN'] = 'C';
						$data2[0]['BRD_TYPE'] = 'LT';$data2[1]['BRD_TYPE'] = 'LT';$data2[2]['BRD_TYPE'] = 'LT';$data2[3]['BRD_TYPE'] = 'LT';$data2[4]['BRD_TYPE'] = 'LRT';
						$data2[0]['T_SIZE'] = 8;$data2[1]['T_SIZE'] = 8;$data2[2]['T_SIZE'] = 8;$data2[3]['T_SIZE'] = 8;$data2[4]['T_SIZE'] = 8;
						$data2[0]['LN_SIZE'] = $linespace;$data2[1]['LN_SIZE'] = $linespace;$data2[2]['LN_SIZE'] = $linespace;$data2[3]['LN_SIZE'] = $linespace;$data2[4]['LN_SIZE'] = $linespace;
						
						$pdf->tbDrawData($data2);
						
						$nmr++;
					}
				}
				
				$counter++;
			}
		}
		break;
	case 3:
		$ar_data = $this->adodb->GetAll($sql);
		if(!empty($ar_data)) {
			$counter = 1;
			$spc = array();
			$data1 = array();
			foreach($ar_data as $k => $v) {
				//$spc[0]['TEXT'] = "";$spc[1]['TEXT'] = "";$spc[2]['TEXT'] = "";$spc[3]['TEXT'] = "";$spc[4]['TEXT'] = "";$spc[5]['TEXT'] = "";$spc[6]['TEXT'] = "";
				//$spc[0]['BRD_TYPE'] = 'LT';$spc[1]['BRD_TYPE'] = 'LT';$spc[2]['BRD_TYPE'] = 'LT';$spc[3]['BRD_TYPE'] = 'LT';$spc[4]['BRD_TYPE'] = 'LT';$spc[5]['BRD_TYPE'] = 'LT';$spc[6]['BRD_TYPE'] = 'LRT';
				//$pdf->tbDrawData($spc);
				
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
					$nmr = 1;
					$data2 = array();
					foreach($ardat as $k1 => $v1) {
						if($case = 2) $alamat_lengkap = str_replace("\n","",$v1[wp_wr_almt]);
						if($case = 3) $alamat_lengkap .= ' Kel. ' . $v1[wp_wr_lurah];
						$data2[0]['TEXT'] = $nmr . ".";
						$data2[1]['TEXT'] = $v1[wp_wr_nama];
						$data2[2]['TEXT'] = strtoupper($alamat_lengkap);
						$data2[3]['TEXT'] = $v1[npwprd];
						//$data2[4]['TEXT'] = $v1[wp_wr_nama_milik];
						$data2[4]['TEXT'] = "";
						
						$data2[0]['T_ALIGN'] = 'R';$data2[3]['T_ALIGN'] = 'C';$data2[4]['T_ALIGN'] = 'C';
						$data2[0]['BRD_TYPE'] = 'LT';$data2[1]['BRD_TYPE'] = 'LT';$data2[2]['BRD_TYPE'] = 'LT';$data2[3]['BRD_TYPE'] = 'LT';$data2[4]['BRD_TYPE'] = 'LRT';
						$data2[0]['T_SIZE'] = 8;$data2[1]['T_SIZE'] = 8;$data2[2]['T_SIZE'] = 8;$data2[3]['T_SIZE'] = 8;$data2[4]['T_SIZE'] = 8;
						$data2[0]['LN_SIZE'] = $linespace;$data2[1]['LN_SIZE'] = $linespace;$data2[2]['LN_SIZE'] = $linespace;$data2[3]['LN_SIZE'] = $linespace;$data2[4]['LN_SIZE'] = $linespace;
						
						$pdf->tbDrawData($data2);
						
						$nmr++;
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
			$counter = 1;
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
				
				$data1[0]['TEXT'] = $counter . ".";
				$data1[1]['TEXT'] = "" . $v[wp_wr_nama];
				$data1[2]['TEXT'] = "" . strtoupper($alamat_lengkap);
				$data1[3]['TEXT'] = "" . $v[npwprd];
				//$data1[4]['TEXT'] = "" . $v[wp_wr_nama_milik];
				if(!empty($wpwr_kdusaha)) $data1[4]['TEXT'] = "";
				else $data1[4]['TEXT'] = strtoupper($kodus);

				$data1[0]['T_ALIGN'] = 'R';$data1[3]['T_ALIGN'] = 'C';$data1[4]['T_ALIGN'] = 'C';
				$data1[0]['BRD_TYPE'] = 'LT';$data1[1]['BRD_TYPE'] = 'LT';$data1[2]['BRD_TYPE'] = 'LT';$data1[3]['BRD_TYPE'] = 'LT';$data1[4]['BRD_TYPE'] = 'LRT';
				$data1[0]['T_SIZE'] = 8;$data1[1]['T_SIZE'] = 8;$data1[2]['T_SIZE'] = 8;$data1[3]['T_SIZE'] = 8;$data1[4]['T_SIZE'] = 8;
				$data2[0]['LN_SIZE'] = $linespace;$data2[1]['LN_SIZE'] = $linespace;$data2[2]['LN_SIZE'] = $linespace;$data2[3]['LN_SIZE'] = $linespace;$data2[4]['LN_SIZE'] = $linespace;
				$pdf->tbDrawData($data1);
				
				$counter++;
			}
		}
		break;
}

$data3 = array();
$data3[0]['TEXT'] = "";
$data3[0]['COLSPAN'] = 5;
$data3[0]['BRD_TYPE'] = 'T';
$pdf->tbDrawData($data3);

$pdf->tbOuputData();

//mengetahui dan diperiksa
$klm = 2;
$pdf->tbInitialize($klm, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($c=0;$c<$klm;$c++) $hdrt[$c] = $table_default_header_type;

for($c=0;$c<$klm;$c++) {
	$ac[$c] = $table_default_header_type;
}
$ac[0]['WIDTH'] = 95;$ac[1]['WIDTH'] = 295;

$arhdr = array($ac);
$pdf->tbSetHeaderType($arhdr,true);

$dtxs = array();
for($c=0;$c<$klm;$c++) $dtxs[$c] = $table_default_datax_type;

$pdf->tbSetDataType($dtxs);

for($c=0;$c<$klm;$c++) {
	$ttd1[$c] = $table_default_ttd_type;
	$ttd2[$c] = $table_default_ttd_type;
}

$ttd1[0]['TEXT'] = "";
$ttd1[1]['TEXT'] = "Bekasi, ". tanggal_lengkap($this->input->get('tgl_cetak'));
$pdf->tbDrawData($ttd1);

if ($this->input->get('mengetahui') != "0" && $this->input->get('pemeriksa') != "0") {
	$ttd1[0]['TEXT'] = "Mengetahui,";
	$ttd1[1]['TEXT'] = "";
	$pdf->tbDrawData($ttd1);
	
	if ($this->session->userdata('USER_SPT_CODE') == "10" && $mengetahui->pejda_jabatan != "80") {
		$ttd1[0]['TEXT'] = " ";
		$ttd1[0]['TEXT'] .= $mengetahui->ref_japeda_nama;
		$ttd1[1]['TEXT'] = "\n".$pemeriksa->ref_japeda_nama;
	} else {
		$ttd1[0]['TEXT'] = $mengetahui->ref_japeda_nama;
		$ttd1[1]['TEXT'] = $pemeriksa->ref_japeda_nama;
	}
	$pdf->tbDrawData($ttd1);
		
	$ttd2[0]['TEXT'] = "";
	$ttd2[1]['TEXT'] = "";
	$pdf->tbDrawData($ttd2);
	$pdf->tbDrawData($ttd2);
	$pdf->tbDrawData($ttd2);
	
	$ttd1[0]['TEXT'] = "<nu>  ".$mengetahui->pejda_nama . "  </nu>";
	$ttd1[1]['TEXT'] = "<nu>  ".$pemeriksa->pejda_nama . "  </nu>";
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = $mengetahui->ref_pangpej_ket;
	$ttd1[1]['TEXT'] = $pemeriksa->ref_pangpej_ket;
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "NIP. " . $mengetahui->pejda_nip;
	$ttd1[1]['TEXT'] = "NIP. " . $pemeriksa->pejda_nip;
	$pdf->tbDrawData($ttd1);
	
	$pdf->tbOuputData();
}

$pdf->Output();
?>