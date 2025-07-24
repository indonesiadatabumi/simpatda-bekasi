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

$pdf->MultiCell(210,5,$pdf->Cell(210,5,$pdf->SetFont('Arial','B',9)."DAFTAR TUNGGAKAN ".strtoupper($jenis_pajak),'',0,'C'),'','','C');
	
if ($kecamatan != "")
	$pdf->MultiCell(210,5,$pdf->Cell(210,5,$pdf->SetFont('Arial','B',9)."KECAMATAN ".strtoupper($kecamatan),'',0,'C'),'','','C');

if ($fDate != "" && $tDate != "")
	$pdf->MultiCell(210,5,$pdf->Cell(210,5,$pdf->SetFont('Arial','B',8)."TANGGAL $fDate s/d $tDate",'',0,'C'),'','','C');
else if($fDate != "")
	$pdf->MultiCell(210,5,$pdf->Cell(210,5,$pdf->SetFont('Arial','B',8)."TANGGAL $fDate",'',0,'C'),'','','C');
else if($tDate != "")
	$pdf->MultiCell(210,5,$pdf->Cell(210,5,$pdf->SetFont('Arial','B',8)."TANGGAL s/d $tDate",'',0,'C'),'','','C');

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
$th1[1]['WIDTH'] = 65;
$th1[2]['WIDTH'] = 25;
$th1[3]['WIDTH'] = 20;
$th1[4]['WIDTH'] = 25;
$th1[5]['WIDTH'] = 25;
$th1[6]['WIDTH'] = 15;
	
$th1[0]['TEXT'] = "<b>NO</b>.";
$th1[1]['TEXT'] = "<b>NAMA WP</b>.";
$th1[2]['TEXT'] = "<b>N.P.W.P.D</b>";
$th1[3]['TEXT'] = "<b>NOMOR</b>";
$th1[4]['TEXT'] = "<b>MASA PAJAK</b>";
$th1[5]['TEXT'] = "<b>JUMLAH (Rp)</b>";
$th1[6]['TEXT'] = "<b>KET.</b>";

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

$total=0;

$datax = array();
for($i=0; $i<$kolom; $i++) $datax[$i] = $table_default_tbldata_type;
$pdf->tbSetDataType($datax);

$counter = 1;

while ($row = $arr_data->FetchNextObject(false)) {
		$arr_masa_pajak = explode("-", $row->spt_periode_jual1);
		$data1[0]['TEXT'] = $counter;
		$data1[1]['TEXT'] = $row->wp_wr_nama;
		$data1[2]['TEXT'] = $row->npwprd;
		$data1[3]['TEXT'] = $row->spt_nomor;
		$data1[4]['TEXT'] = getNamaBulan($arr_masa_pajak[1])." ".$arr_masa_pajak[0];
		$data1[5]['TEXT'] = number_format($row->spt_pajak, 0,',','.');
		if ($jenis_pajak != "")
			$data1[6]['TEXT'] = "";
		else 
			$data1[6]['TEXT'] = $row->ref_jenparet_ket;
		
		$data1[0]['BRD_TYPE'] = "LTB";
		$data1[1]['BRD_TYPE'] = "LTB";
		$data1[2]['BRD_TYPE'] = "LTB";
		$data1[3]['BRD_TYPE'] = "LTB";
		$data1[4]['BRD_TYPE'] = "LTB";
		$data1[5]['BRD_TYPE'] = "LTB";
		$data1[6]['BRD_TYPE'] = "LRTB";
		
		$data1[0]['T_ALIGN'] = "L";
		$data1[1]['T_ALIGN'] = "L";
		$data1[2]['T_ALIGN'] = "L";
		$data1[3]['T_ALIGN'] = "C";
		$data1[4]['T_ALIGN'] = "L";
		$data1[5]['T_ALIGN'] = "R";
		$data1[6]['T_ALIGN'] = "L";
		
		$pdf->tbDrawData($data1);
		
		$total += $row->spt_pajak;
		$counter++;
}

$data[0]['TEXT'] = "<b>J U M L A H</b>";
$data[4]['TEXT'] = "<b>".number_format ($total, 0,',','.')."</b>";

$data[0]['T_ALIGN'] = "C";
$data[4]['T_ALIGN'] = "R";
		
$data[0]['BRD_TYPE'] = "LRTB";
$data[4]['BRD_TYPE'] = "LTB";
$data[6]['BRD_TYPE'] = "LRTB";

$data[0]['COLSPAN'] = 4;$data[4]['COLSPAN'] = 2;

$pdf->tbDrawData($data);

$data[0]['TEXT'] = "";
$data[0]['BRD_TYPE'] = "T";
$data[0]['COLSPAN'] = 7;
$pdf->tbDrawData($data);

$pdf->tbOuputData();
      
$pdf->Output();

?>