<?php 
	
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Class Extention for header and footer 
require_once APPPATH.'libraries/fpdf/table/header_footer.inc';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';

$pdf = new FPDF_TABLE('P','mm','A4'); // Portrait dengan ukuran kertas A4
$pdf->Open();
$pdf->SetAutoPageBreak(true); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(3, 1, 3);     // Margin Left, Top, Right 2 cm
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetStyle("sb","arial","B",6,"0,0,0");
$pdf->SetStyle("b","arial","B",10,"0,0,0");
$pdf->SetStyle("an","arial","",7,"0,0,0");
$pdf->SetStyle("nu","arial","U",8,"0,0,0");
$pdf->SetStyle("h1","arial","B",9,"0,0,0");
$pdf->SetStyle("h2","arial","B",8,"0,0,0");
$pdf->SetStyle("small","arial","",6,"0,0,0");
$pdf->SetStyle("su","arial","U",7,"0,0,0");
$pdf->SetStyle("i","arial","I",6,"0,0,0");

$kol = 2;
$pdf->tbInitialize($kol, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($a=0; $a<$kol; $a++)
	$w[$a] = $table_kartu_npwp_type;

$w[0]['WIDTH'] = 15;
$w[1]['WIDTH'] = 67;

$pdf->tbSetHeaderType($w);

for($b=0; $b<$kol; $b++) {
	$spc[$b] = $table_kartu_npwp_type;
	$kop[$b] = $table_kartu_npwp_type;
	$ket[$b] = $table_kartu_npwp_type;
}

$spc[0]['TEXT'] = "";
$spc[1]['TEXT'] = "";
$spc[0]['LN_SIZE'] = 2;
$spc[1]['LN_SIZE'] = 2;
$pdf->tbDrawData($spc);

$kop[0]['TEXT'] = "";
$kop[1]['TEXT'] = "PEMERINTAH KOTA BEKASI";
$kop[1]['T_SIZE'] = 11;$kop[1]['T_TYPE'] = 'B';$kop[1]['T_ALIGN'] = 'C';$kop[1]['LN_SIZE'] = 4;
$pdf->tbDrawData($kop);

$kop[0]['TEXT'] = "";
$kop[1]['TEXT'] = "DINAS PENDAPATAN DAERAH";
$kop[1]['T_SIZE'] = 12;$kop[1]['T_TYPE'] = 'B';$kop[1]['T_ALIGN'] = 'C';$kop[1]['LN_SIZE'] = 4;
$pdf->tbDrawData($kop);

$kop[0]['TEXT'] = "";
$kop[1]['TEXT'] = "KARTU  N P W P D";
$kop[1]['T_SIZE'] = 10;$kop[1]['T_TYPE'] = 'B';$kop[1]['T_ALIGN'] = 'C';$kop[1]['LN_SIZE'] = 4;
$pdf->tbDrawData($kop);

$kop[0]['TEXT'] = "";$kop[0]['LN_SIZE']=5;
$kop[1]['TEXT'] = "No. Reg : " . $wp->wp_wr_no_urut;
$kop[1]['T_SIZE'] = 6;$kop[1]['T_TYPE'] = '';$kop[1]['T_ALIGN'] = 'C';$kop[1]['LN_SIZE'] = 5;
$kop[1]['T_ALIGN'] = 'C';$kop[1]['BRD_TYPE'] = 'T';$kop[1]['BRD_SIZE'] = 0.3;
$pdf->tbDrawData($kop);

$pdf->tbOuputData();

//Identitas WP
$col = 5;
$pdf->tbInitialize($col, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($c=0; $c<$col; $c++) 
	$l[$c] = $table_kartu_npwp_type;

$l[0]['WIDTH'] = 1;
$l[1]['WIDTH'] = 14;
$l[2]['WIDTH'] = 3;
$l[3]['WIDTH'] = 65;
$l[4]['WIDTH'] = 1;

$pdf->tbSetHeaderType($l);

for($d=0; $d<$col; $d++) {
	$ws[$d] = $table_kartu_npwp_type;
	$d1[$d] = $table_kartu_npwp_type;
	$d2[$d] = $table_default_ttd_type;
	$d3[$d] = $table_kartu_npwp_type;
	$ws2[$d] = $table_kartu_npwp_type;
}

$ws[0]['COLSPAN'] = 1;
$ws[0]['TEXT'] = "";
$ws[0]['LN_SIZE'] = 1;
//$pdf->tbDrawData($ws);

$d1[0]['TEXT'] = "";
$d1[1]['TEXT'] = "NAMA";
$d1[2]['TEXT'] = ":";
$d1[3]['TEXT'] = str_replace("\\", "", $wp->wp_wr_nama);
$d1[3]['COLSPAN'] = 2;
$pdf->tbDrawData($d1);


if (strlen($wp->wp_wr_almt) > 20) {
	$d1[0]['TEXT'] = "";
	$d1[1]['TEXT'] = "ALAMAT";
	$d1[2]['TEXT'] = ":";
	$d1[3]['TEXT'] = $wp->wp_wr_almt." KEC.".$wp->wp_wr_camat;
	$d1[3]['COLSPAN'] = 2;
	$pdf->tbDrawData($d1);
} else {
	$d1[0]['TEXT'] = "";
	$d1[1]['TEXT'] = "ALAMAT";
	$d1[2]['TEXT'] = ":";
	$d1[3]['TEXT'] = $wp->wp_wr_almt;
	$d1[3]['COLSPAN'] = 2;
	$pdf->tbDrawData($d1);	
	
	$d1[0]['TEXT'] = "";
	$d1[1]['TEXT'] = "";
	$d1[2]['TEXT'] = "";
	$d1[3]['TEXT'] = "KEC. ".$wp->wp_wr_camat;
	$d1[3]['COLSPAN'] = 2;
	$pdf->tbDrawData($d1);
}

$d1[0]['TEXT'] = "";
$d1[1]['TEXT'] = "NPWPD";
$d1[2]['TEXT'] = ":";
$d1[3]['TEXT'] = "" . $wp->npwprd;
$d1[3]['COLSPAN'] = 2;
$pdf->tbDrawData($d1);

$ws[0]['COLSPAN'] = 5;
$ws[0]['TEXT'] = "";
$ws[0]['LN_SIZE'] = 1;
$pdf->tbDrawData($ws);

$pdf->tbOuputData();

//ttd
$col = 2;
$pdf->tbInitialize($col, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($c=0; $c<$col; $c++) 
	$width[$c] = $table_kartu_npwp_type;

$width[0]['WIDTH'] = 35;
$width[1]['WIDTH'] = 50;

$pdf->tbSetHeaderType($width);

for($d=0; $d<$col; $d++) {
	$ws[$d] = $table_kartu_npwp_type;
	$ttd[$d] = $table_default_ttd_type;
}

$ttd[0]['TEXT'] = "";
$ttd[1]['TEXT'] = "<an>Bekasi, ".date('d')." ".getNamaBulan(date('m'))." ".date("Y")."</an>";
//$d2[0]['COLSPAN'] = 3;
//$d2[3]['COLSPAN'] = 2;
$ttd[0]['LN_SIZE'] = 3;
$ttd[1]['LN_SIZE'] = 3;
$pdf->tbDrawData($ttd);

$ttd[0]['TEXT'] = "";
$ttd[1]['TEXT'] = "<an>a.n Walikota Bekasi\nKepala Dinas Pendapatan Daerah</an>";
$ttd[1]['LN_SIZE'] = 2.4;
$pdf->tbDrawData($ttd);

$ws[0]['TEXT'] = "";
$ws[0]['LN_SIZE'] = 7;
$ws[0]['COLSPAN'] = 2;
$pdf->tbDrawData($ws);

$ttd[0]['TEXT'] = "";
$ttd[1]['TEXT'] = "<su>" . $pejabat->pejda_nama. "</su>";
$ttd[0]['LN_SIZE'] = 2.5;$ttd[1]['LN_SIZE'] = 2.5;
$pdf->tbDrawData($ttd);

$ttd[1]['TEXT'] = "<small>" . $pejabat->ref_pangpej_ket . "</small>";
$ttd[0]['LN_SIZE'] = 2;$ttd[1]['LN_SIZE'] = 2;
$pdf->tbDrawData($ttd);

$ttd[1]['TEXT'] = "<small>NIP. " . $pejabat->pejda_nip . "</small>";
$pdf->tbDrawData($ttd);

$pdf->tbOuputData();

$logo = "assets/".$pemda->dapemda_logo_path;
$pdf->Image($logo,1,1,15,17);

$logo = "assets/images/ttd_kadis.jpg";
$pdf->Image($logo,53,40.5,24,7);

$logo = "assets/images/stempel.jpg";
$pdf->Image($logo,40,40,13,13);

//add new page
$pdf->AddPage();
$pdf->AliasNbPages();



//Belakang
$kolom = 4;
$pdf->tbInitialize($kolom, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($e=0; $e<$kolom; $e++) $lk[$e] = $table_default_datax_type;

$lk[0]['WIDTH'] = 3;
$lk[1]['WIDTH'] = 5;
$lk[2]['WIDTH'] = 68;
$lk[3]['WIDTH'] = 2;

$pdf->tbSetHeaderType($lk);

for($f=0; $f<$kolom; $f++) {
	$nl[$f] = $table_kartu_npwp_type;
	$h[$f] = $table_default_datax_type;
	$p[$f] = $table_kartu_npwp_type;
}

$nl[0]['TEXT'] = "";
$nl[0]['COLSPAN'] = 4;
$pdf->tbDrawData($nl);

$pdf->tbDrawData($nl);
//$pdf->tbDrawData($nl);

$h[0]['TEXT'] = "<h1>P E R H A T I A N</h1>";
$h[0]['COLSPAN'] = 4;
$h[0]['T_ALIGN'] = 'C';
$pdf->tbDrawData($h);

$pdf->tbDrawData($nl);

$p[0]['TEXT'] = "";
$p[1]['TEXT'] = "1.";
$p[2]['TEXT'] = "Kartu ini harap disimpan baik-baik dan apabila hilang agar segera melaporkan ke Dinas Pendapatan Daerah.";
$p[3]['TEXT'] = "";
$p[2]['T_ALIGN'] = 'J';
$pdf->tbDrawData($p);

$p[1]['TEXT'] = "2.";
$p[2]['TEXT'] = "Kartu ini hendaknya dibawa apabila saudara akan membayar pajak, melakukan transaksi dan berhubungan dengan instansi-instansi.";
$pdf->tbDrawdata($p);

$p[1]['TEXT'] = "3.";
$p[2]['TEXT'] = "Dalam hal wajib pajak pindah domisili, supaya melaporkan ke Dinas Pendapatan Daerah Kota Bekasi.";
$pdf->tbDrawdata($p);

$pdf->tbDrawData($nl);
$pdf->tbDrawData($nl);
$pdf->tbDrawData($nl);
$pdf->tbDrawData($nl);
$pdf->tbDrawData($nl);
$pdf->tbDrawData($nl);

$pdf->tbOuputData();

$pdf->Output();

?>