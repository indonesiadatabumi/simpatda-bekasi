<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH',$this->config->item('fonts_path'));

require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';
require_once APPPATH.'libraries/fpdf/table/table_def.inc';
require_once APPPATH.'libraries/fpdf/table/header_footer_daftarinduk.inc';


$pdf = new pdf_usage('P','mm','A4'); // Portrait dengan ukuran kertas A4
$pdf->Open();
$pdf->SetAutoPageBreak(true, 15); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(10, 20, 10);     // Margin Left, Top, Right 2 cm
$pdf->AddPage();
$pdf->AliasNbPages();
$bTableSplitMode = true;

$pdf->SetStyle("btgl","arial","B",6,"0,0,0");
$pdf->SetStyle("btgl2","arial","B",6,"c,c,c");
$pdf->SetStyle("b","arial","B",7,"0,0,0");
$pdf->SetStyle("h1","arial","B",12,"0,0,0");
$pdf->SetStyle("h2","arial","B",10,"0,0,0");
$pdf->SetStyle("nu","arial","U",8,"0,0,0");
$pdf->SetStyle("s","arial","",6,"0,0,0");


$fDate = $this->input->get('fDate');
$tDate = $this->input->get('tDate');

$pdf->MultiCell(210,5,$pdf->Cell(210,5,$pdf->SetFont('Arial','B',9)."LAPORAN PENERIMAAN ".strtoupper($jenis_pajak),'',0,'C'),'','','C');
	
if ($kecamatan != "")
	$pdf->MultiCell(210,5,$pdf->Cell(210,5,$pdf->SetFont('Arial','B',9)."KECAMATAN ".strtoupper($kecamatan),'',0,'C'),'','','C');
	
$pdf->MultiCell(210,5,$pdf->Cell(210,5,$pdf->SetFont('Arial','B',8)."TANGGAL $fDate s/d $tDate",'',0,'C'),'','','C');

$pdf->Ln(5);

$kolom = 7;
$pdf->tbInitialize($kolom, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($i=0; $i<$kolom; $i++) $header[$i] = $table_default_header_type;

$table_default_tblheader_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 7,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'C',
		'V_ALIGN' => 'M',
		'LN_SIZE' => 4,
		'BRD_SIZE' => 0.2,
		'BG_COLOR' => array(255,255,255),
	);

if(empty($linespace)) $linespace = 4.5;
 	
$table_default_tbldata_type = array(
		'T_COLOR' => array(0,0,0),
		'T_SIZE' => 6,
		'T_FONT' => 'Arial',
		'T_ALIGN' => 'C',
		'V_ALIGN' => 'M',
		'LN_SIZE' => 4,
		'BRD_SIZE' => 0.1,
		'BG_COLOR' => array(255,255,255),
	);	
	
for($i=0; $i<$kolom; $i++) {
	$th1[$i] = $table_default_tblheader_type;
}

$th1[0]['WIDTH'] = 10;
$th1[1]['WIDTH'] = 20;
$th1[2]['WIDTH'] = 25;
$th1[3]['WIDTH'] = 60;
$th1[4]['WIDTH'] = 25;
$th1[5]['WIDTH'] = 23;
$th1[6]['WIDTH'] = 23;
	
$th1[0]['TEXT'] = "<b>NO</b>.";
$th1[1]['TEXT'] = "<b>NO. STS</b>.";
$th1[2]['TEXT'] = "<b>TGL. SETORAN</b>";
$th1[3]['TEXT'] = "<b>URAIAN (NAMA WP)</b>";
$th1[4]['TEXT'] = "<b>N.P.W.P.D</b>";
$th1[5]['TEXT'] = "<b>MASA PAJAK</b>";
$th1[6]['TEXT'] = "<b>JUMLAH (Rp)</b>";

$th1[0]['BRD_TYPE'] = "LTB";
$th1[1]['BRD_TYPE'] = "LTB";
$th1[2]['BRD_TYPE'] = "LTB";
$th1[3]['BRD_TYPE'] = "LTB";
$th1[4]['BRD_TYPE'] = "LTB";
$th1[5]['BRD_TYPE'] = "LTB";
$th1[6]['BRD_TYPE'] = "LRTB";

$arHeader = array(
	$th1
);

$pdf->tbSetHeaderType($arHeader, true);

$pdf->tbDrawHeader();

$counter_header = 1;

$jml=0;

$datax = array();
for($i=0; $i<$kolom; $i++) $datax[$i] = $table_default_tbldata_type;
$pdf->tbSetDataType($datax);

$counter_header_tgl = 0;
$counter_header = 0;
$counter = 1;
$start_tgl = true;
$start_ayat = true;
$tampung_tgl = "";
	
if (count($arr_data) > 0) {
	$tmp_skbh_no = ""; $tmp_skbh_id = 0;
	$tmp_counter = "";
	foreach ($arr_data as $row) {
		if ($row->skbh_id != $tmp_skbh_id) {
			$tmp_skbh_no = $row->skbh_no;
			$tmp_skbh_id = $row->skbh_id;
			$tmp_counter = $counter++;
		}			
		else {
			$tmp_skbh_no = "";
			$tmp_counter = "";
		}
			
		
		$arr_masa_pajak = explode("-", $row->setorpajret_periode_jual1);
		$data1[0]['TEXT'] = $tmp_counter;
		$data1[1]['TEXT'] = $tmp_skbh_no;
		$data1[2]['TEXT'] = format_tgl($row->skbh_tgl);
		$data1[3]['TEXT'] = $row->wp_wr_nama;
		$data1[4]['TEXT'] = $row->npwprd;
		$data1[5]['TEXT'] = getNamaBulan($arr_masa_pajak[1])." ".$arr_masa_pajak[0];
		$data1[6]['TEXT'] = number_format($row->setorpajret_dt_jumlah, 0,',','.');
		
		$data1[0]['BRD_TYPE'] = "LTB";
		$data1[1]['BRD_TYPE'] = "LTB";
		$data1[2]['BRD_TYPE'] = "LTB";
		$data1[3]['BRD_TYPE'] = "LTB";
		$data1[4]['BRD_TYPE'] = "LTB";
		$data1[5]['BRD_TYPE'] = "LTB";
		$data1[6]['BRD_TYPE'] = "LRTB";
		
		$data1[0]['T_ALIGN'] = "L";
		$data1[1]['T_ALIGN'] = "L";
		$data1[2]['T_ALIGN'] = "C";
		$data1[3]['T_ALIGN'] = "L";
		$data1[4]['T_ALIGN'] = "L";
		$data1[5]['T_ALIGN'] = "L";
		$data1[6]['T_ALIGN'] = "R";
		
		$pdf->tbDrawData($data1);
		
		$jml=$jml+intval($row->setorpajret_dt_jumlah);
	}
}

$data[0]['TEXT'] = "<b>J U M L A H</b>";
$data[5]['TEXT'] = "<b>".number_format ($jml, 0,',','.')."</b>";

$data[0]['T_ALIGN'] = "C";
$data[5]['T_ALIGN'] = "R";
		
$data[0]['BRD_TYPE'] = "LRTB";
$data[5]['BRD_TYPE'] = "LRTB";

$data[0]['COLSPAN'] = 5;
$data[5]['COLSPAN'] = 2;

$pdf->tbDrawData($data);

$data[0]['TEXT'] = "";
$data[0]['BRD_TYPE'] = "T";
$data[0]['COLSPAN'] = 7;
$pdf->tbDrawData($data);

$pdf->tbOuputData();


//Tanda Tangan
if ($_GET['tandatangan'] == "1") {
	// set page constants
	// height of resulting cell
	$cell_height = 5 + 1; // I have my cells at a height of five so set to six for a padding
	$height_of_cell = ceil( 10 * $cell_height );
	$page_height = $pdf->h; ; // mm (landscape legal)
	$bottom_margin = 20; // mm
	
	// mm until end of page (less bottom margin of 20mm)
	$space_left = $page_height - $pdf->GetY(); // space left on page
	$space_left -= $bottom_margin; // less the bottom margin
	
	// test if height of cell is greater than space left
	if ( $height_of_cell >= $space_left) {
		$pdf->Ln();                        
	
	    $pdf->AddPage(); // page break.
	}
	
	//mengetahui dan bendahara
	$klm = 2;
	$pdf->tbInitialize($klm, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($c=0;$c<$klm;$c++) $hdrt[$c] = $table_default_header_type;
	
	for($c=0;$c<$klm;$c++) {
		$ac[$c] = $table_default_header_type;
	}
	$ac[0]['WIDTH'] = 95;$ac[1]['WIDTH'] = 95;
	
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
	
	if ($mengetahui != null && $bendahara != null) {
		$ttd1[0]['TEXT'] = "Mengetahui,";
		$ttd1[1]['TEXT'] = "";
		//$pdf->tbDrawData($ttd1);
		
		if ($this->session->userdata('USER_SPT_CODE') == "10" && $mengetahui->pejda_jabatan != "80") {
			//$ttd1[0]['TEXT'] = "a.n. ".$this->config->item('nama_jabatan_kepala_dinas');
			$ttd1[0]['TEXT'] .= "\n".$mengetahui->ref_japeda_nama;
			$ttd1[1]['TEXT'] = "\n".$bendahara->ref_japeda_nama;
		} else {
			$ttd1[0]['TEXT'] = $mengetahui->ref_japeda_nama;
			$ttd1[1]['TEXT'] = $bendahara->ref_japeda_nama;
		}
		$pdf->tbDrawData($ttd1);
			
		$ttd2[0]['TEXT'] = "";
		$ttd2[1]['TEXT'] = "";
		$pdf->tbDrawData($ttd2);
		$pdf->tbDrawData($ttd2);
		$pdf->tbDrawData($ttd2);
		
		$ttd1[0]['TEXT'] = "<nu>  ".$mengetahui->pejda_nama . "  </nu>";
		$ttd1[1]['TEXT'] = "<nu>  ".$bendahara->pejda_nama . "  </nu>";
		$pdf->tbDrawData($ttd1);
		
		$ttd1[0]['TEXT'] = "NIP. " . $mengetahui->pejda_nip;
		$ttd1[1]['TEXT'] = "NIP. " . $bendahara->pejda_nip;
		$pdf->tbDrawData($ttd1);
		
		$pdf->tbOuputData();
	}	
} else {
	$klm = 2;
	$pdf->tbInitialize($klm, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($c=0;$c<$klm;$c++) $hdrt[$c] = $table_default_header_type;
	
	for($c=0;$c<$klm;$c++) {
		$ac[$c] = $table_default_header_type;
	}
	$ac[0]['WIDTH'] = 95;$ac[1]['WIDTH'] = 95;
	
	$arhdr = array($ac);
	$pdf->tbSetHeaderType($arhdr,true);
	
	$dtxs = array();
	for($c=0;$c<$klm;$c++) $dtxs[$c] = $table_default_datax_type;
	
	$pdf->tbSetDataType($dtxs);
	
	for($c=0;$c<$klm;$c++) {
		$ttd1[$c] = $table_default_ttd_type;
	}
	
	$ttd1[0]['TEXT'] = "";
	$ttd1[1]['TEXT'] = "Bekasi, ". tanggal_lengkap($this->input->get('tgl_cetak'));
	$pdf->tbDrawData($ttd1);
	
	$pdf->tbOuputData();
}
      
$pdf->Output();

?>