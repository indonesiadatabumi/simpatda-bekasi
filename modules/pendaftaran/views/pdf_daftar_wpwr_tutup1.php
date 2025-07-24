<?php
error_reporting(E_ERROR );

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Class Extention for header and footer 
require_once APPPATH.'libraries/fpdf/table/header_footer_daftarinduk.inc';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';
					
if(empty($linespace)) $linespace = 4;

$pdf = new pdf_usage('L','mm','legal'); // Portrait dengan ukuran kertas A4
$pdf->Open();
$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(10, 20, 10);     // Margin Left, Top, Right 2 cm
$pdf->AddPage();
$pdf->AliasNbPages();
$bTableSplitMode = false;
$pdf->SetStyle("sb","arial","B",9,"0,0,0");
$pdf->SetStyle("b","arial","B",6,"0,0,0");
$pdf->SetStyle("h1","arial","B",12,"0,0,0");
$pdf->SetStyle("h2","arial","B",10,"0,0,0");
$pdf->SetStyle("nu","arial","U",9,"0,0,0");
$pdf->SetStyle("s","arial","",6,"0,0,0");

	
$judulplus = "";
if($this->input->get('camat') != "" && $this->input->get('camat') != "0") {
	$arr_kecamatan = explode('|', $this->input->get('camat'));
	$judulplus = " KECAMATAN ".strtoupper($arr_kecamatan[1]);
}

$bidus = "";
if($this->input->get('bidus') != "") {
	$bidus = $this->adodb->GetOne("SELECT ref_kodus_nama FROM ref_kode_usaha WHERE ref_kodus_id='".$this->input->get('bidus')."'");
}


$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',8).$pdf->Cell(12,3,"",'','','C').
					$pdf->Cell(50,3,"PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".
					$pemda->dapemda_nm_dati2),'','','L').$pdf->Cell(80,3,"",'','','C').
					$pdf->Cell(48,3,"",'','','C'),'','','',0);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',8).$pdf->Cell(12,3,"",'','','C').
					$pdf->Cell(50,3,strtoupper($pemda->nama_dinas),'','','L').$pdf->Cell(80,3,"",'','','C').
					$pdf->Cell(48,3,"",'','','C'),'','','',0);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(12,3,"",'','','C').
					$pdf->Cell(50,3,ucwords(strtolower($pemda->dapemda_lokasi))." - ".
					ucwords(strtolower($pemda->dapemda_ibu_kota)),'','','L').$pdf->Cell(80,3,"",'','','C').
					$pdf->Cell(48,3,"",'','','C'),'','','',0);
					
$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',6).$pdf->Cell(12,4,"",'','','C').$pdf->Cell(50,3,"Telp. " .
					$pemda->dapemda_no_telp,'','','L').$pdf->SetFont('Arial','B',8).
					$pdf->Cell(80,4,"DAFTAR WP TUTUP ".strtoupper($bidus).$judulplus,'','','C').$pdf->Cell(48,4,"",'','','C'),'','','',0);
	
$fDate = $this->input->get('fDate');
$tDate = $this->input->get('tDate');
if (empty($fDate))
	$fDate = "-";
else 
	$fDate = tanggal_lengkap($fDate);

if (empty($tDate))
	$tDate = tanggal_lengkap(date("d-m-Y"));
else 
	$tDate = tanggal_lengkap($tDate);

$logo = "assets/".$pemda->dapemda_logo_path;
$pdf->Image($logo,10,10,13);

$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',5).$pdf->Cell(12,4,"",'','','C').$pdf->Cell(50,3,"",'','','L').
					$pdf->SetFont('Arial','B',8).$pdf->Cell(80,4,"Dari tanggal $fDate s/d $tDate ",'','','C').
					$pdf->Cell(48,4,"",'','','C'),'','','',0);

$pdf->MultiCell(190,4,"",'','','',0);

//Printable Area 185 mm
if ($this->input->get('bidus') == "") 
	$kolom = 6;
else 
	$kolom = 5;
	
$pdf->tbInitialize($kolom, true, true);
$pdf->tbSetTableType($table_default_tbl_type);
for($i=0; $i<$kolom; $i++) $header[$i] = $table_default_header_type;
	
for($i=0; $i<$kolom; $i++) {
	//$ket[$i] = $table_noborder;
	$th1[$i] = $table_default_tblheader_type;
	$th2[$i] = $table_default_tblheader_type;
}

if ($this->input->get('bidus') == "") {
	$th1[0]['WIDTH'] = 10;
	$th1[1]['WIDTH'] = 45;
	$th1[2]['WIDTH'] = 70;
	$th1[3]['WIDTH'] = 32;
	$th1[4]['WIDTH'] = 20;
	$th1[5]['WIDTH'] = 20;
} else {
	$th1[0]['WIDTH'] = 10;
	$th1[1]['WIDTH'] = 45;
	$th1[2]['WIDTH'] = 75;
	$th1[3]['WIDTH'] = 32;
	$th1[4]['WIDTH'] = 26;
}

$th1[0]['TEXT'] = "<b>NO.</b>";
$th1[1]['TEXT'] = "<b>N A M A</b>";
$th1[2]['TEXT'] = "<b>A L A M A T   L E N G K A P</b>";
$th1[3]['TEXT'] = "<b>N P W P D</b>";
$th1[4]['TEXT'] = "<b>KETERANGAN</b>";
if ($this->input->get('bidus') == "") {
	$th1[5]['TEXT'] = "<b>JENIS PAJAK</b>";
	$th1[4]['BRD_TYPE'] = 'LT';
	$th1[5]['BRD_TYPE'] = 'LRT';
} else {
	$th1[4]['BRD_TYPE'] = 'LRT';
}
$th1[1]['LN_SIZE'] = 6;
$th1[0]['BRD_TYPE'] = 'LT';
$th1[1]['BRD_TYPE'] = 'LT';
$th1[2]['BRD_TYPE'] = 'LT';
$th1[3]['BRD_TYPE'] = 'LT';

$arHeader = array(
	$th1
);

$pdf->tbSetHeaderType($arHeader, true);
$pdf->tbDrawHeader();

$datax = array();
for($i=0; $i<$kolom; $i++) $datax[$i] = $table_default_tbldata_type_ln_6;

$pdf->tbSetDataType($datax);

if(!empty($arr_data)) {
	$counter = 1;
	$data1 = array();
	foreach($arr_data as $k => $v) {
		if(!empty($wpwr_kdcamat) && empty($wpwr_kdlurah)) {
			$alamat_lengkap = str_replace("\n","",$v['wp_wr_almt']) . ' Kel. ' . $v['wp_wr_lurah'];
		}
		elseif(!empty($wpwr_kdlurah)) {
			$alamat_lengkap = str_replace("\n","",$v['wp_wr_almt']);
		}
		else {
			$alamat_lengkap = str_replace("\n","",$v['wp_wr_almt']) . ' Kel. ' . $v['wp_wr_lurah'] . ' Kec. ' . $v['wp_wr_camat'];
		}
					
		$data1[0]['TEXT'] = $counter . ".";
		$data1[1]['TEXT'] = "" . $v['wp_wr_nama'];
		$data1[2]['TEXT'] = "" . strtoupper($alamat_lengkap);
		$data1[3]['TEXT'] = "" . $v['npwprd'];
		$data1[4]['TEXT'] = format_tgl($v['wp_wr_tgl_tutup']);
		if ($this->input->get('bidus') == "") {
			$data1[5]['TEXT'] = strtoupper($v['ref_kodus_nama']);
		}
		$data1[0]['T_ALIGN'] = 'R';
		$data1[3]['T_ALIGN'] = 'C';
		$data1[4]['T_ALIGN'] = 'C';
		$data1[0]['BRD_TYPE'] = 'LT';
		$data1[1]['BRD_TYPE'] = 'LT';
		$data1[2]['BRD_TYPE'] = 'LT';
		$data1[3]['BRD_TYPE'] = 'LT';
		
		if ($this->input->get('bidus') == "") {
			$data1[4]['BRD_TYPE'] = 'LT';
			$data1[5]['BRD_TYPE'] = 'LRT';
			$data1[5]['T_SIZE'] = 8;
			$data1[5]['LN_SIZE'] = $linespace;
		} else {
			$data1[4]['BRD_TYPE'] = 'LRT';
		}
		
		$data1[0]['T_SIZE'] = 8;
		$data1[1]['T_SIZE'] = 8;
		$data1[2]['T_SIZE'] = 8;
		$data1[3]['T_SIZE'] = 8;
		$data1[4]['T_SIZE'] = 8;
		$data1[0]['LN_SIZE'] = $linespace;
		$data1[1]['LN_SIZE'] = $linespace;
		$data1[2]['LN_SIZE'] = $linespace;
		$data1[3]['LN_SIZE'] = $linespace;
		$data1[4]['LN_SIZE'] = $linespace;
		
		$pdf->tbDrawData($data1);
		
		$counter++;
	}
}

$data3 = array();
$data3[0]['TEXT'] = "";
$data3[0]['COLSPAN'] = $kolom;
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
$ac[0]['WIDTH'] = 95;
$ac[1]['WIDTH'] = 95;

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
		$ttd1[0]['TEXT'] = "a.n. ".$this->config->item('nama_jabatan_kepala_dinas')."\n";
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