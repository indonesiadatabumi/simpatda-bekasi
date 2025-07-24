<?php 

error_reporting(E_ERROR);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Class Extention for header and footer 
require_once APPPATH.'libraries/fpdf/table/header_footer_daftarinduk.inc';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';


$line_spacing = $_GET['linespace'];

$pdf = new pdf_usage('L','mm','Folio'); // Landscape dengan ukuran kertas A4
$pdf->Open();
$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(10, 20, 10);     // Margin Left, Top, Right 2 cm
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetStyle("sb","arial","B",7,"0,0,0");
$pdf->SetStyle("b","arial","B",8,"0,0,0");
$pdf->SetStyle("h1","arial","B",12,"0,0,0");
$pdf->SetStyle("h2","arial","B",10,"0,0,0");
$pdf->SetStyle("nu","arial","U",8,"0,0,0");

$logo = "assets/".$pemda->dapemda_logo_path;
$pdf->Image($logo,10,14,13);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,"PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2),'','','L').
						$pdf->Cell(80,3,"",'','','C'),'','','',0);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,strtoupper($pemda->nama_dinas),'','','L').
						$pdf->SetFont('Arial','B',10).$pdf->Cell(140,4,"DAFTAR SURAT KETETAPAN PAJAK DAERAH (SKPD) REKLAME",'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,ucwords(strtolower($pemda->dapemda_lokasi)),'','','L').
						$pdf->Cell(80,3,"",'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);
					
$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).
						$pdf->Cell(12,4,"",'','','C').
						$pdf->Cell(50,3,"Telp. " .$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax,'','','L').
						$pdf->Cell(80,3,"",'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);

$pdf->MultiCell(182,4,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,4,"",'','','C').
						$pdf->Cell(50,3,strtoupper($pemda->dapemda_ibu_kota),'','','L'),'','','',0);

$pdf->ln(2);

if($kecamatan != null || $kecamatan != "") 
	$pdf->Cell(310,4,$pdf->SetFont('Arial','',10)."Kecamatan     : ".strtoupper($kecamatan),0,0);
	
$pdf->ln(5);

$arrbulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
$pdf->MultiCell(310,4,$pdf->SetFont('Arial','',10).
						$pdf->Cell(310,4,"Bulan : ".$arrbulan[$_GET['bulan']]." ".$_GET['tahun'],'','','L'),'','','',0);

$pdf->ln(5);
//Untuk Landscape A4 set lebar 270mm
$kol = 11;
$pdf->tbInitialize($kol, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($a=0; $a<$kol; $a++) {
	$header1[$a] = $table_default_tblheader_type;
	$header2[$a] = $table_default_tblheader_type;
}

$header1[0]['WIDTH'] = 10;
$header1[1]['WIDTH'] = 17;
$header1[2]['WIDTH'] = 17;
$header1[3]['WIDTH'] = 45;
$header1[4]['WIDTH'] = 45;
$header1[5]['WIDTH'] = 40;
$header1[6]['WIDTH'] = 52;
$header1[7]['WIDTH'] = 25;
$header1[8]['WIDTH'] = 27;
$header1[9]['WIDTH'] = 25;
$header1[10]['WIDTH'] = 12;

$header1[0]['TEXT'] = "<b>NO.</b>";
$header1[1]['TEXT'] = "<b>$ketetapan->ketspt_singkat</b>";
$header1[3]['TEXT'] = "<b>NAMA WAJIB PAJAK</b>";
$header1[4]['TEXT'] = "<b>NASKAH REKLAME</b>";
$header1[5]['TEXT'] = "<b>ALAMAT WAJIB PAJAK</b>";
$header1[6]['TEXT'] = "<b>LOKASI PASANG</b>";	
$header1[7]['TEXT'] = "<b>JENIS REKLAME</b>";	
$header1[8]['TEXT'] = "<b>KETETAPAN</b>";
$header1[9]['TEXT'] = "<b>JATUH TEMPO</b>";
$header1[10]['TEXT'] = "<b>KET.</b>";

$header1[1]['COLSPAN'] = 2;$header1[0]['ROWSPAN'] = 2;$header1[3]['ROWSPAN'] = 2;$header1[4]['ROWSPAN'] = 2;
$header1[5]['ROWSPAN'] = 2;$header1[6]['ROWSPAN'] = 2;$header1[7]['ROWSPAN'] = 2;$header1[8]['ROWSPAN'] = 2;$header1[9]['ROWSPAN'] = 2;

$header1[0]['LN_SIZE'] = 6;$header1[1]['LN_SIZE'] = 6;$header1[2]['LN_SIZE'] = 6;$header1[3]['LN_SIZE'] = 6;$header1[4]['LN_SIZE'] = 6;
$header1[5]['LN_SIZE'] = 6;$header1[6]['LN_SIZE'] = 6;$header1[7]['LN_SIZE'] = 6;$header1[8]['LN_SIZE'] = 6;$header1[9]['LN_SIZE'] = 6;$header1[10]['LN_SIZE'] = 6;

$header1[0]['BRD_TYPE'] = 'LT';$header1[1]['BRD_TYPE'] = 'LT';$header1[3]['BRD_TYPE'] = 'LT';$header1[4]['BRD_TYPE'] = 'LT';
$header1[5]['BRD_TYPE'] = 'LT';$header1[6]['BRD_TYPE'] = 'LT';$header1[7]['BRD_TYPE'] = 'LT';$header1[8]['BRD_TYPE'] = 'LT';$header1[9]['BRD_TYPE'] = 'LT';
$header1[10]['BRD_TYPE'] = 'LRT';

$header2[1]['TEXT'] = "<b>TANGGAL</b>";
$header2[2]['TEXT'] = "<b>NO.KOHIR</b>";
$header2[6]['TEXT'] = "";
$header2[7]['TEXT'] = "";
$header2[8]['TEXT'] = "<b>( Rp.)</b>";
$header2[1]['COLSPAN'] = 1;
$header2[1]['BRD_TYPE'] = 'LT';
$header2[2]['BRD_TYPE'] = 'LRT';
$header2[6]['BRD_TYPE'] = 'LR';
$header2[7]['BRD_TYPE'] = 'LR';
$header2[8]['BRD_TYPE'] = 'LR';
$header2[9]['BRD_TYPE'] = 'LR';
$header2[10]['BRD_TYPE'] = 'LR';

$arHeader = array(
	$header1,
	$header2
);

$pdf->tbSetHeaderType($arHeader, true);
$pdf->tbDrawHeader();

for($b=0; $b<$kol; $b++) {
	$ket[$b] = $table_default_datax_type;
	$grs[$b] = $table_default_datax_type;
	$tbl2[$b] = $table_default_datax_type;
	$tbl3[$b] = $table_default_datax_type;
}

$pdf->tbSetDataType($tbl2);

$counter = 1;
$omset = 0; $pajak = 0;
if (!empty($data)) {
	$tbl2[0]['V_ALIGN'] = 'T';
	$tbl2[1]['V_ALIGN'] = 'T';
	$tbl2[2]['V_ALIGN'] = 'T';
	$tbl2[3]['V_ALIGN'] = 'T';
	$tbl2[4]['V_ALIGN'] = 'T';
	$tbl2[5]['V_ALIGN'] = 'T';
	$tbl2[6]['V_ALIGN'] = 'T';
	$tbl2[7]['V_ALIGN'] = 'T';
	$tbl2[8]['V_ALIGN'] = 'T';
	$tbl2[9]['V_ALIGN'] = 'T';
	$tbl2[10]['V_ALIGN'] = 'T';
	
	$tbl2[0]['T_ALIGN'] = 'R';
	$tbl2[1]['T_ALIGN'] = 'C';
	$tbl2[2]['T_ALIGN'] = 'C';
	$tbl2[5]['T_ALIGN'] = 'L';
	$tbl2[6]['T_ALIGN'] = 'L';
	$tbl2[7]['T_ALIGN'] = 'L';
	$tbl2[8]['T_ALIGN'] = 'R';
	$tbl2[9]['T_ALIGN'] = 'C';
	$tbl2[10]['T_ALIGN'] = 'C';
	
	$tbl2[0]['BRD_TYPE'] = 'LT';
	$tbl2[1]['BRD_TYPE'] = 'LT';
	$tbl2[2]['BRD_TYPE'] = 'LT';
	$tbl2[3]['BRD_TYPE'] = 'LT';
	$tbl2[4]['BRD_TYPE'] = 'LT';
	$tbl2[5]['BRD_TYPE'] = 'LT';
	$tbl2[6]['BRD_TYPE'] = 'LT';
	$tbl2[7]['BRD_TYPE'] = 'LT';
	$tbl2[8]['BRD_TYPE'] = 'LT';
	$tbl2[9]['BRD_TYPE'] = 'LT';
	$tbl2[10]['BRD_TYPE'] = 'LRT';
	
	$tbl2[0]['T_SIZE'] = '8';
	$tbl2[1]['T_SIZE'] = '8';
	$tbl2[2]['T_SIZE'] = '8';
	$tbl2[3]['T_SIZE'] = '8';
	$tbl2[4]['T_SIZE'] = '8';
	$tbl2[5]['T_SIZE'] = '8';
	$tbl2[6]['T_SIZE'] = '8';
	$tbl2[7]['T_SIZE'] = '8';
	$tbl2[8]['T_SIZE'] = '8';
	$tbl2[9]['T_SIZE'] = '8';
	$tbl2[10]['T_SIZE'] = '8';
	
	$tbl2[0]['LN_SIZE'] = $line_spacing;
	$tbl2[1]['LN_SIZE'] = $line_spacing;
	$tbl2[2]['LN_SIZE'] = $line_spacing;
	$tbl2[3]['LN_SIZE'] = $line_spacing;
	$tbl2[4]['LN_SIZE'] = $line_spacing;
	$tbl2[5]['LN_SIZE'] = $line_spacing;
	$tbl2[6]['LN_SIZE'] = $line_spacing;
	$tbl2[7]['LN_SIZE'] = $line_spacing;
	$tbl2[8]['LN_SIZE'] = $line_spacing;
	$tbl2[9]['LN_SIZE'] = $line_spacing;
	$tbl2[10]['LN_SIZE'] = $line_spacing;
	
	foreach($data as $key => $value) {
		//$dt_rek = get_spt_reklame($value['sptrek_id']);
		$tbl2[0]['TEXT'] = $counter;
		$tbl2[1]['TEXT'] = format_tgl($value['netapajrek_tgl']);
		$tbl2[2]['TEXT'] = $value['netapajrek_kohir'];
		$tbl2[3]['TEXT'] = $value['wp_wr_nama'];
		$tbl2[4]['TEXT'] = $value['sptrek_judul'];
		$tbl2[5]['TEXT'] = ereg_replace("\r|\n","",$value['wp_wr_almt']);
		if($value['wp_wr_lurah'] == null){
			$tbl2[6]['TEXT'] = $value['sptrek_lokasi'];
		}else{
			$tbl2[6]['TEXT'] = $value['sptrek_lokasi'] . " Kel. " . $value['wp_wr_lurah'] . " Kec. " . $value['wp_wr_camat'];
		}
		$tbl2[7]['TEXT'] = $value['korek_nama_detail'];
		$tbl2[8]['TEXT'] = format_currency($value['spt_dt_pajak']);
		$tbl2[9]['TEXT'] = format_tgl($value['netapajrek_tgl_jatuh_tempo']);
		$tbl2[10]['TEXT'] = "";
		
		$counter++;
		//$lokasi += $val['sptrek_lokasi'];
		$pajak += $value['spt_dt_pajak'];
		
		$pdf->tbDrawData($tbl2);
	}
}

$tbl3[0]['TEXT'] = "J U M L A H";
$tbl3[6]['TEXT'] = "";
$tbl3[7]['TEXT'] = "";
$tbl3[8]['TEXT'] = format_currency($pajak);
$tbl3[0]['T_SIZE'] = '8';$tbl3[0]['T_TYPE'] = 'B';
$tbl3[6]['T_SIZE'] = '8';
$tbl3[7]['T_SIZE'] = '8';
$tbl3[8]['T_SIZE'] = '8';
$tbl3[0]['COLSPAN'] = 6;
$tbl3[0]['T_ALIGN'] = 'C';
$tbl3[6]['T_ALIGN'] = 'R';
$tbl3[7]['T_ALIGN'] = 'R';
$tbl3[8]['T_ALIGN'] = 'R';
$tbl3[10]['T_ALIGN'] = 'C';
$tbl3[0]['BRD_TYPE'] = 'LT';
$tbl3[6]['BRD_TYPE'] = 'T';
$tbl3[7]['BRD_TYPE'] = 'LT';
$tbl3[8]['BRD_TYPE'] = 'LT';
$tbl3[9]['BRD_TYPE'] = 'LRT';
$tbl3[10]['BRD_TYPE'] = 'LRT';
$pdf->tbDrawData($tbl3);

$grs[0]['TEXT'] = "";
$grs[0]['COLSPAN'] = 11;
$grs[0]['LN_SIZE'] = 6;
$grs[0]['BRD_TYPE'] = 'T';
$pdf->tbDrawData($grs);

$pdf->tbOuputData();

// set page constants
// height of resulting cell
$cell_height = 5 + 1; // I have my cells at a height of five so set to six for a padding
$height_of_cell = ceil( 10 * $cell_height );
$page_height = 215.9; // mm (landscape legal)
$bottom_margin = 20; // mm

// mm until end of page (less bottom margin of 20mm)
$space_left = $page_height - $pdf->GetY(); // space left on page
$space_left -= $bottom_margin; // less the bottom margin

// test if height of cell is greater than space left
if ( $height_of_cell >= $space_left) {
	$pdf->Ln();                        

    $pdf->AddPage(); // page break.
}

//Tanda Tangan
if ($_GET['tandatangan'] == "1") {
	$kols = 3;
	$pdf->tbInitialize($kols, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($c=0; $c<$kols; $c++) $width[$c] = $table_default_datax_type;
	
	$width[0]['WIDTH'] = 94;
	$width[1]['WIDTH'] = 124;
	$width[2]['WIDTH'] = 89;
	
	$pdf->tbSetHeaderType($width);
	
	for($d=0; $d<$kols; $d++) {
		$ttd1[$d] = $table_default_ttd_type;
		$ket[$d] = $table_default_ttd_type;
	}
	
	$ttd1[0]['TEXT'] = "Mengetahui,";
	$ttd1[1]['TEXT'] = "Diperiksa Oleh,";
	$ttd1[2]['TEXT'] = $pemda->dapemda_nm_dati2.", ". format_tgl($_GET['tgl_cetak'],false,true);
	$ttd1[2]['T_ALIGN'] = "L";
	$pdf->tbDrawData($ttd1);
	
	if ($this->session->userdata('USER_SPT_CODE') == "10") {
		$ttd1[0]['TEXT'] = ($mengetahui->pejda_kode != '01') ? "a.n. ".$this->config->item('nama_jabatan_kepala_dinas')."\n".$mengetahui->ref_japeda_nama:"" . $mengetahui->ref_japeda_nama;
	} else {
		$ttd1[0]['TEXT'] = $mengetahui->ref_japeda_nama;
	}
	$ttd1[1]['TEXT'] = $diperiksa->ref_japeda_nama;
	$ttd1[2]['TEXT'] = "";	
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "";
	$ttd1[1]['TEXT'] = "";
	$ttd1[2]['TEXT'] = "Nama   : " . $this->session->userdata('USER_FULL_NAME')."\nNIP       : " . $this->session->userdata('USER_NIP');
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "";
	$ttd1[1]['TEXT'] = "";
	$ttd1[2]['TEXT'] = "";
	$pdf->tbDrawData($ttd1);
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "<nu>  " . $mengetahui->pejda_nama . "  </nu>";
	$ttd1[1]['TEXT'] = "<nu>  " . $diperiksa->pejda_nama . "  </nu>";
	$ttd1[2]['TEXT'] = "Tanda Tangan : . . . . . . . . . . . . . . . . . . . . .";
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "" . $mengetahui->ref_pangpej_ket;
	$ttd1[1]['TEXT'] = "" . $diperiksa->ref_pangpej_ket;
	$ttd1[2]['TEXT'] = "";
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "NIP. " . $mengetahui->pejda_nip;
$ttd1[1]['TEXT'] = "NIP. " . $diperiksa->pejda_nip;
	$ttd1[2]['TEXT'] = "";
	$pdf->tbDrawData($ttd1);
	
	$pdf->tbOuputData();
}

$pdf->Output();

?>