<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH',$this->config->item('fonts_path'));

require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';
require_once APPPATH.'libraries/fpdf/table/table_def.inc';
require_once APPPATH.'libraries/fpdf/table/header_footer_daftarinduk.inc';


$pdf = new pdf_usage('P','mm','legal'); // Portrait dengan ukuran kertas A4
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

if($this->input->get('via_bayar') == "") $via = "BENDAHARA PENERIMAAN DAN BANK";
if($this->input->get('via_bayar') == "1") $via = "BENDAHARA PENERIMAAN";
if($this->input->get('via_bayar') == "2") $via = "BANK";

$logo = 'assets/'.$pemda->dapemda_logo_path;
$pdf->Image($logo,10,14,14);

$attr_tgl1 = $this->input->get('fDate');
$attr_tgl2 = $this->input->get('tDate');

$tgl_1=substr("$attr_tgl1",0,2).'-'.substr("$attr_tgl1",3,2).'-'.substr("$attr_tgl1",6,4);
$tgl_2=substr("$attr_tgl2",0,2).'-'.substr("$attr_tgl2",3,2).'-'.substr("$attr_tgl2",6,4);
$tgl1=substr("$attr_tgl1",6,4).'-'.substr("$attr_tgl1",3,2).'-'.substr("$attr_tgl1",0,2);
$tgl2=substr("$attr_tgl2",6,4).'-'.substr("$attr_tgl2",3,2).'-'.substr("$attr_tgl2",0,2);
$thn=substr("$attr_tgl1",6,4);

$pdf->MultiCell(180,3,$pdf->Cell(14,4,"",'',0,'C').$pdf->SetFont('Arial','B',8).$pdf->Cell(210,4,"PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2),'',0,'L'),'','','L');
$pdf->MultiCell(180,3,$pdf->Cell(14,4,"",'',0,'C').$pdf->SetFont('Arial','B',8).$pdf->Cell(210,4,strtoupper($pemda->nama_dinas),'',0,'L'),'','','L');
$pdf->MultiCell(180,3,$pdf->Cell(14,3,"",'',0,'C').$pdf->Cell(210,3,$pdf->SetFont('Arial','',7).$pemda->dapemda_lokasi,'',0,'L'),'','','L');
$pdf->MultiCell(180,3,$pdf->Cell(14,3,"",'',0,'C').$pdf->Cell(210,3,"Telp. ".$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax,'',0,'L'),'','','L');
$pdf->MultiCell(180,3,$pdf->Cell(14,4,"",'',0,'C').$pdf->SetFont('Arial','B',8).$pdf->Cell(210,4,strtoupper($pemda->dapemda_nm_dati2),'',0,'L'),'','','L');

$pdf->ln(5);

$pdf->MultiCell(210,5,$pdf->Cell(210,5,$pdf->SetFont('Arial','B',9)."BUKU PEMBANTU PENERIMAAN SEJENIS VIA ".$via,'',0,'C'),'','','C');
$pdf->MultiCell(210,5,$pdf->Cell(210,5,$pdf->SetFont('Arial','B',9)."TAHUN ANGGARAN ".$thn,'',0,'C'),'','','C');
$pdf->MultiCell(210,5,$pdf->Cell(210,5,$pdf->SetFont('Arial','B',8)."Periode tanggal $tgl_1 s/d $tgl_2",'',0,'C'),'','','C');

$pdf->Ln(2);

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
$th1[1]['WIDTH'] = 17;
$th1[2]['WIDTH'] = 43;
$th1[3]['WIDTH'] = 15;
$th1[4]['WIDTH'] = 64;
$th1[5]['WIDTH'] = 23;
$th1[6]['WIDTH'] = 25;
	
$th1[0]['TEXT'] = "<b>NO</b>.";
$th1[1]['TEXT'] = "<b>REKENING</b>";
$th1[2]['TEXT'] = "<b>NAMA REKENING</b>";
$th1[3]['TEXT'] = "<b>TGL. SETORAN</b>";
$th1[4]['TEXT'] = "<b>DITERIMA DARI</b>";
$th1[5]['TEXT'] = "<b>N.P.W.P.D</b>";
$th1[6]['TEXT'] = "<b>JUMLAH</b>";

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
	foreach ($arr_data as $row) {
		$data1[0]['TEXT'] = $counter;
		$data1[1]['TEXT'] = $row->rekening;
		$data1[2]['TEXT'] = $row->korek_nama;
		$data1[3]['TEXT'] = format_tgl($row->setorpajret_tgl_bayar);
		$data1[4]['TEXT'] = $row->wp_wr_nama;
		$data1[5]['TEXT'] = $row->npwprd;
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
		$data1[2]['T_ALIGN'] = "L";
		$data1[3]['T_ALIGN'] = "C";
		$data1[4]['T_ALIGN'] = "L";
		$data1[5]['T_ALIGN'] = "L";
		$data1[6]['T_ALIGN'] = "R";
		
		$pdf->tbDrawData($data1);
		
		$counter++;
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
      
$pdf->Output();

?>