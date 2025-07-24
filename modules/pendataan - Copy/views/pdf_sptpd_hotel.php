<?php 

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH',$this->config->item('fonts_path'));

require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';
require_once APPPATH.'libraries/fpdf/table/table_def.inc';
require_once APPPATH.'libraries/fpdf/table/header_footer.inc';

$pdf = new FPDF_TABLE('P','mm','A4'); // Portrait dengan ukuran kertas A4
$pdf->Open();
$pdf->SetAutoPageBreak(true); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(10, 5, 10);     // Margin Left, Top, Right 2 cm


$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetStyle("sb","arial","B",7,"0,0,0");
$pdf->SetStyle("b","arial","B",8,"0,0,0");
$pdf->SetStyle("h1","arial","B",8,"0,0,0");
$pdf->SetStyle("nu","arial","U",8,"0,0,0");
$pdf->SetStyle("th1","arial","B",10,"0,0,0");

$columns = 7; // bisa disesuaikan
$pdf->tbInitialize($columns, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

$pmda = "<th1>PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2)."</th1>\n".
	        "<th1>".strtoupper($pemda->nama_dinas)."</th1>\n".$pemda->dapemda_lokasi."\n".
			"Telp. ".$pemda->dapemda_no_telp."\n<th1>".strtoupper($pemda->dapemda_nm_dati2)."</th1>";
	
for($i=0; $i<$columns; $i++) 
	$header_type[$i] = $table_default_headerx_type;


for($i=0; $i<$columns; $i++) {
	$spacer1[$i] = $table_sptpd_type;
	$header_type1[$i] = $table_sptpd_type;
	$header_type2[$i] = $table_sptpd_type;
	$header_type3[$i] = $table_sptpd_type;
	$header_type4[$i] = $table_sptpd_type;
	$header_type5[$i] = $table_sptpd_type;
	$spacer2[$i] = $table_sptpd_type;
}

$spacer1[0]['WIDTH'] = 22;
$spacer1[1]['WIDTH'] = 73;
$spacer1[2]['WIDTH'] = 20;
$spacer1[3]['WIDTH'] = 25;
$spacer1[4]['WIDTH'] = 5;
$spacer1[5]['WIDTH'] = 45;

//space
$spacer1[0]['TEXT'] = "";
$spacer1[0]['COLSPAN'] = 2;
$spacer1[0]['LN_SIZE'] = 1;
$spacer1[0]['BRD_TYPE'] = 'LRT';
$spacer1[2]['TEXT'] = "";
$spacer1[2]['LN_SIZE'] = 1;
$spacer1[2]['COLSPAN'] = 4;
$spacer1[2]['BRD_TYPE'] = "LRT";

//Baris ke-1
$header_type1[0]['TEXT'] = "";
$header_type1[0]['ROWSPAN'] = 3;
$header_type1[0]['BRD_TYPE'] = 'L';	
$header_type1[1]['TEXT'] = $pmda;
$header_type1[2]['BRD_TYPE'] = 'R';
$header_type1[1]['ROWSPAN'] = 3;
$header_type1[1]['T_ALIGN'] = 'L';
$header_type1[2]['BRD_TYPE'] = 'L';
$header_type1[3]['TEXT'] = "<sb>No. SPTPD</sb>";
$header_type1[3]['T_ALIGN'] = "L";
$header_type1[4]['TEXT'] = " : ";
$header_type1[5]['TEXT'] = " ........ ";
$header_type1[5]['T_ALIGN'] = "L";
$header_type1[5]['BRD_TYPE'] = 'R';

$header_type2[2]['BRD_TYPE'] = 'L';
$header_type2[3]['TEXT'] = "<sb>Masa Pajak</sb>";
$header_type2[3]['T_ALIGN'] = "L";
$header_type2[4]['TEXT'] = " : ";
$header_type2[5]['TEXT'] = " ........ ";
$header_type2[5]['T_ALIGN'] = "L";
$header_type2[5]['BRD_TYPE'] = 'R';

$header_type3[2]['BRD_TYPE'] = 'L';
$header_type3[3]['TEXT'] = "<sb>Tahun Pajak</sb>";
$header_type3[3]['T_ALIGN'] = "L";
$header_type3[4]['TEXT'] = " : ";
$header_type3[5]['TEXT'] = " ........ ";
$header_type3[5]['T_ALIGN'] = "L";
$header_type3[5]['BRD_TYPE'] = 'R';

$spacer2[0]['TEXT'] = "";
$spacer2[0]['COLSPAN'] = 2;
$spacer2[0]['LN_SIZE'] = 1;
$spacer2[0]['BRD_TYPE'] = 'LR';
$spacer2[2]['TEXT'] = "";
$spacer2[2]['LN_SIZE'] = 1;
$spacer2[2]['COLSPAN'] = 4;
$spacer2[2]['BRD_TYPE'] = "LR";

$aHeaderArray = array(
	$spacer1,
	$header_type1,
	$header_type2,
	$header_type3,
	$spacer2
);

//set the Table Header
$pdf->tbSetHeaderType($aHeaderArray, true);

//Draw the Header
$pdf->tbDrawHeader();
$pdf->tbOuputData();
// End of Header

//Bagian center
$kolom = 4;
$pdf->tbInitialize($kolom, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($a=0; $a<$kolom; $a++) $setcol[$a] = $table_sptpd_type;

$setcol[0]['WIDTH'] = 3;
$setcol[1]['WIDTH'] = 107;
$setcol[2]['WIDTH'] = 70;
$setcol[3]['WIDTH'] = 10;


$pdf->tbSetHeaderType($setcol);
for($b=0; $b<$kolom; $b++) {
	$pdtop[$b] = $table_sptpd_type;
	$r1[$b] = $table_sptpd_type;
	$r2[$b] = $table_sptpd_type;
	$r3[$b] = $table_sptpd_type;
	$r4[$b] = $table_sptpd_type;
	$r5[$b] = $table_sptpd_type;
	$r6[$b] = $table_sptpd_type;
}

//padding atas
$pdtop[0]['TEXT'] = "";
$pdtop[0]['COLSPAN'] = 4;
$pdtop[0]['BRD_TYPE'] = 'LRT';
$pdf->tbDrawData($pdtop);

//baris ke-1
$r1[0]['TEXT'] = "";
$r1[0]['BRD_TYPE'] = 'L';
$r1[1]['TEXT'] = "<th1>SPTPD</th1>";
$r1[1]['COLSPAN'] = 2;
$r1[1]['T_ALIGN'] = 'C';
$r1[3]['TEXT'] = "";
$r1[3]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($r1);

$r2[0]['TEXT'] = "";
$r2[0]['BRD_TYPE'] = 'L';
$r2[1]['TEXT'] = "<h1>(SURAT PEMBERITAHUAN PAJAK DAERAH)</h1>";
$r2[1]['COLSPAN'] = 2;
$r2[1]['T_ALIGN'] = 'C';
$r2[3]['TEXT'] = "";
$r2[3]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($r2);

$r3[0]['TEXT'] = "";
$r3[0]['LN_SIZE'] = 5;
$r3[0]['BRD_TYPE'] = 'L';
$r3[1]['TEXT'] = "<h1>PAJAK HOTEL</h1>";
$r3[1]['COLSPAN'] = 2;
$r3[1]['T_ALIGN'] = 'C';
$r3[3]['TEXT'] = "";
$r3[3]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($r3);

$r4[0]['BRD_TYPE'] = 'L';
$r4[1]['TEXT'] = "N. P. W. P. D";
$r4[1]['T_ALIGN'] = 'L';
$r4[2]['TEXT'] = "Kepada Yth.";
$r4[3]['TEXT'] = "";
$r4[3]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($r4);

$r5[0]['BRD_TYPE'] = 'L';
$r5[1]['TEXT'] = "P.1.02.0003233.12.02";
$r5[1]['T_ALIGN'] = 'L';
$r5[2]['TEXT'] = "PT. X";
$r5[3]['TEXT'] = "";
$r5[3]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($r5);

$r6[0]['BRD_TYPE'] = 'L';
$r6[1]['TEXT'] = "";
$r6[1]['T_ALIGN'] = 'L';
$r6[2]['TEXT'] = "di";
$r6[3]['TEXT'] = "";
$r6[3]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($r6);

$pdf->tbOuputData();

//Bagian PERHATIAN...
$cols = 3;
$pdf->tbInitialize($cols,true,true);
$pdf->tbSetTableType($table_default_tbl_type);

for($j=0;$j<$cols;$j++) 
	$colw[$j] = $table_sptpd_type;

for($j=0;$j<$cols;$j++) {
	$cwid[$j] = $table_sptpd_type;
}
$cwid[0]['WIDTH'] = 3;
$cwid[1]['WIDTH'] = 4;
$cwid[2]['WIDTH'] = 183;
$pdf->tbSetHeaderType($cwid);

for($k=0;$k<$cols;$k++) {
	$ins[$k] = $table_sptpd_type;
	$ket1[$k] = $table_sptpd_type;
	$ket[$k] = $table_sptpd_type;
}


$ins[0]['TEXT'] = "";
$ins[0]['COLSPAN'] = 3;
$ins[0]['BRD_TYPE'] = 'LR';
$ins[0]['LN_SIZE'] = 2;
$pdf->tbDrawData($ins);

$ket1[0]['TEXT'] = "";
$ket1[0]['BRD_TYPE'] = 'L';
$ket1[0]['V_ALIGN'] = 'T';
$ket1[0]['T_ALIGN'] = 'R';
$ket1[1]['TEXT'] = "PERHATIAN :";
$ket1[1]['COLSPAN'] = 2;
$ket1[1]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($ket1);

$ket[0]['TEXT'] = "";
$ket[0]['BRD_TYPE'] = 'L';
$ket[0]['V_ALIGN'] = 'T';
$ket[0]['T_ALIGN'] = 'R';
$ket[1]['TEXT'] = "1.";
$ket[2]['TEXT'] = "Harap diisi dalam rangkap 5 (lima) ditulis dengan huruf CETAK.";
$ket[2]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($ket);

$ket[0]['TEXT'] = "";
$ket[1]['TEXT'] = "2.";
$ket[2]['TEXT'] = "Beri nomor pada kotak [   ] yang tersedia untuk jawaban yang diberikan.";
$pdf->tbDrawData($ket);

$ket[0]['TEXT'] = "";
$ket[1]['TEXT'] = "3.";
$ket[2]['TEXT'] = "Setelah diisi dan ditanda tangani, harap diserahkan kembali kepada UPTD Pendapatan paling lambat tanggal 20 bulan berikutnya.";
$pdf->tbDrawData($ket);

$ket[0]['TEXT'] = "";
$ket[1]['TEXT'] = "4.";
$ket[2]['TEXT'] = "Keterlambatan penyerahan dari tanggal tersebut diatas akan dikenakan Denda.";
$pdf->tbDrawData($ket);

$ins[0]['TEXT'] = "";
$ins[0]['COLSPAN'] = 3;
$ins[0]['LN_SIZE'] = 2;
$pdf->tbDrawData($ins);

$ins[0]['TEXT'] = "";
$ins[0]['COLSPAN'] = 3;
$ins[0]['LN_SIZE'] = 1;
$ins[0]['BRD_TYPE'] = 'LRT';
$pdf->tbDrawData($ins);

$ket[0]['TEXT'] = "<h1>A. DIISI OLEH PENGUSAHA HOTEL</h1>";
$ket[0]['COLSPAN'] = 3;
$ket[0]['BRD_TYPE'] = 'LR';
$ket[0]['T_ALIGN'] = "C";
$pdf->tbDrawData($ket);

$ins[0]['TEXT'] = "";
$ins[0]['LN_SIZE'] = 2;
$pdf->tbDrawData($ins);

$pdf->tbOuputData();

// Baris Detail
$kolom = 7;
$pdf->tbInitialize($kolom, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($i=0; $i<$kolom; $i++) $setcol[$i] = $table_sptpd_type;

$setcol[0]['WIDTH'] = 3;
$setcol[1]['WIDTH'] = 4;
$setcol[2]['WIDTH'] = 10;
$setcol[3]['WIDTH'] = 40;
$setcol[4]['WIDTH'] = 40;
$setcol[5]['WIDTH'] = 45;

$pdf->tbSetHeaderType($setcol);

$tipedata = Array();
for($j=0; $j<$kolom; $j++) $tipedata[$j] = $table_sptpd_type;

$pdf->tbSetDataType($tipedata);

for($k=0; $k<$kolom; $k++) {
	$padtop[$k] = $table_sptpd_type;
	$datax2[$k] = $table_sptpd_type;
	$datax3[$k] = $table_sptpd_type;
	$datax4[$k] = $table_sptpd_type;
	$datax1[$k] = $table_sptpd_type;
}

$datax2 = Array();
$datax2[0]['BRD_TYPE'] = 'L';
$datax2[0]['TEXT'] = "";
$datax2[1]['TEXT'] = "1.";
$datax2[1]['T_ALIGN'] = "L";
$datax2[2]['COLSPAN'] = 2;
$datax2[2]['TEXT'] = "Golongan Hotel  :    	[   ][   ]";
$datax2[4]['COLSPAN'] = 2;
$datax2[4]['TEXT'] = "01  Bintang lima	             06  Melati tiga";
$datax2[6]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($datax2);

$datax2 = Array();
$datax2[0]['BRD_TYPE'] = 'L';
$datax2[0]['TEXT'] = "";
$datax2[0]['T_ALIGN'] = 'R';
$datax2[1]['TEXT'] = "";
$datax2[2]['COLSPAN'] = 2;
$datax2[2]['TEXT'] = "";
$datax2[4]['COLSPAN'] = 2;
$datax2[4]['TEXT'] = "02  Bintang empat	          07  Melati dua";
$datax2[6]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($datax2);

$datax2 = Array();
$datax2[0]['BRD_TYPE'] = 'L';
$datax2[0]['TEXT'] = "";
$datax2[0]['T_ALIGN'] = 'R';
$datax2[1]['TEXT'] = "";
$datax2[2]['COLSPAN'] = 2;
$datax2[2]['TEXT'] = "";
$datax2[4]['COLSPAN'] = 2;
$datax2[4]['TEXT'] = "03  Bintang tiga	              08  Melati satu";
$datax2[6]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($datax2);

$datax2 = Array();
$datax2[0]['BRD_TYPE'] = 'L';
$datax2[0]['TEXT'] = "";
$datax2[0]['T_ALIGN'] = 'R';
$datax2[1]['TEXT'] = "";
$datax2[2]['COLSPAN'] = 2;
$datax2[2]['TEXT'] = "";
$datax2[4]['COLSPAN'] = 2;
$datax2[4]['TEXT'] = "04  Bintang dua	              09  Ekonomi";
$datax2[6]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($datax2);

$datax2 = Array();
$datax2[0]['BRD_TYPE'] = 'L';
$datax2[0]['TEXT'] = "";
$datax2[0]['T_ALIGN'] = 'R';
$datax2[1]['TEXT'] = "";
$datax2[2]['COLSPAN'] = 2;
$datax2[2]['TEXT'] = "";
$datax2[4]['COLSPAN'] = 2;
$datax2[4]['TEXT'] = "05  Bintang satu	             10  Lainnya : .........";
$datax2[6]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($datax2);

$datax3 = array();
$datax3[0]['BRD_TYPE'] = 'L';
$datax3[0]['TEXT'] = "";
$datax3[1]['TEXT'] = "2.";
$datax3[2]['TEXT'] = "Tarif dan jumlah kamar hotel";
$datax3[2]['COLSPAN'] = 4;
$datax3[6]['TEXT'] = "";
$datax3[6]['BRD_TYPE'] = 'R';		
$pdf->tbDrawData($datax3);		

$data_tarif = array();
$data_tarif[0]['BRD_TYPE'] = 'L';
$data_tarif[0]['TEXT'] = "";
$data_tarif[1]['TEXT'] = "";

$data_tarif[2]['TEXT'] = "No.";
$data_tarif[2]['T_ALIGN'] = 'C';
$data_tarif[2]['BRD_TYPE'] = 'LT';

$data_tarif[3]['TEXT'] = "Golongan Kamar";
$data_tarif[3]['T_ALIGN'] = 'C';
$data_tarif[3]['BRD_TYPE'] = 'LT';

$data_tarif[4]['TEXT'] = "Tarif (Rp)";
$data_tarif[4]['T_ALIGN'] = 'C';
$data_tarif[4]['BRD_TYPE'] = 'LT';

$data_tarif[5]['TEXT'] = "Jumlah Kamar";
$data_tarif[5]['T_ALIGN'] = 'C';
$data_tarif[5]['BRD_TYPE'] = 'LT';

$data_tarif[6]['TEXT'] = "";
$data_tarif[6]['BRD_TYPE'] = 'LR';

$pdf->tbDrawData($data_tarif);
for ($i=1; $i <= 3; $i++) {
	$dtx = Array();
	$dtx[0]['TEXT'] = "";
	$dtx[0]['BRD_TYPE'] = 'L';
	$dtx[1]['TEXT'] = "";
	$dtx[2]['TEXT'] = $i . ".";
	$dtx[2]['T_ALIGN'] = 'C';
	$dtx[2]['BRD_TYPE'] = 'LT';
	$dtx[3]['TEXT'] = "";
	$dtx[3]['BRD_TYPE'] = 'LT';
	$dtx[4]['TEXT'] = "";
	$dtx[4]['T_ALIGN'] = 'R';
	$dtx[4]['BRD_TYPE'] = 'LT';
	$dtx[5]['TEXT'] = "";
	$dtx[5]['T_ALIGN'] = 'C';
	$dtx[5]['BRD_TYPE'] = 'LT';
	$dtx[6]['TEXT'] = "";
	$dtx[6]['BRD_TYPE'] = 'LR';
	
	$pdf->tbDrawData($dtx);
}

$datax4[0]['TEXT'] = "";
$datax4[1]['TEXT'] = "";
$datax4[2]['TEXT'] = "";
$datax4[3]['TEXT'] = "";
$datax4[4]['TEXT'] = "";
$datax4[5]['TEXT'] = "";
$datax4[6]['TEXT'] = "";

$datax4[0]['BRD_TYPE'] = 'L';
$datax4[2]['BRD_TYPE'] = 'T';
$datax4[3]['BRD_TYPE'] = 'T';
$datax4[4]['BRD_TYPE'] = 'T';
$datax4[5]['BRD_TYPE'] = 'T';
$datax4[6]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($datax4);

$datax2 = Array();
$datax2[0]['BRD_TYPE'] = 'L';
$datax2[0]['TEXT'] = "";
$datax2[1]['TEXT'] = "3.";
$datax2[1]['T_ALIGN'] = "L";
$datax2[2]['COLSPAN'] = 2;
$datax2[2]['TEXT'] = "Menggunakan kas register";
$datax2[4]['COLSPAN'] = 2;
$datax2[4]['TEXT'] = "[   ]   1. Ya";
$datax2[6]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($datax2);

$datax2 = Array();
$datax2[0]['BRD_TYPE'] = 'L';
$datax2[0]['TEXT'] = "";
$datax2[1]['TEXT'] = "";
$datax2[1]['T_ALIGN'] = "L";
$datax2[2]['COLSPAN'] = 2;
$datax2[2]['TEXT'] = "";
$datax2[4]['COLSPAN'] = 2;
$datax2[4]['TEXT'] = "        2. Tidak";
$datax2[6]['BRD_TYPE'] = 'R';
$pdf->tbDrawData($datax2);

$datax2 = Array();
$datax2[0]['BRD_TYPE'] = 'LRT';
$datax2[0]['LN_SIZE'] = 2;
$pdf->tbDrawData($datax2);

$datax2 = Array();
$datax2[0]['BRD_TYPE'] = 'L';
$datax2[0]['TEXT'] = "";
$datax2[1]['TEXT'] = "";
$datax2[1]['T_ALIGN'] = "L";
$datax2[2]['COLSPAN'] = 5;
$datax2[2]['TEXT'] = "<h1>B. DIISI OLEH PENGUSAHA HOTEL</h1>";
$datax2[6]['BRD_TYPE'] = 'BR';
$pdf->tbDrawData($datax2);

$pdf->tbOuputData();

//Logo
$pdf->Image('assets/'.$pemda->dapemda_logo_path,14,9,16, 15);

$pdf->Output();

?>