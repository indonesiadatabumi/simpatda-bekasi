<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Class Extention for header and footer 
require_once APPPATH.'libraries/fpdf/table/header_footer_daftarinduk.inc';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';
					
if(empty($linespace)) $linespace = 4;

$pdf = new pdf_usage('L','mm','legal');
$pdf->Open();
$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(10, 20, 10);     // Margin Left, Top, Right 1 cm
$pdf->AddPage();
$pdf->AliasNbPages();
//$bTableSplitMode = true;

$pdf->SetStyle("kop1","times","B",14,"0,0,0");
$pdf->SetStyle("kop2","times","B",12,"0,0,0");
$pdf->SetStyle("kop3","times","B",10,"0,0,0");

$pdf->SetStyle("sb","arial","B",7,"0,0,0");
$pdf->SetStyle("b","arial","B",8,"0,0,0");
$pdf->SetStyle("bi","arial","BI",8,"0,0,0");
$pdf->SetStyle("h1","arial","B",12,"0,0,0");
$pdf->SetStyle("h2","arial","B",10,"0,0,0");
$pdf->SetStyle("nu","arial","U",9,"0,0,0");
$pdf->SetStyle("bu","arial","BU",8,"0,0,0");
$pdf->SetStyle("s","arial","",6,"0,0,0");

$kol = 28;
$pdf->tbInitialize($kol,true,true);
$pdf->tbSetTableType($table_default_tbl_type);

for($a=0;$a<$kol;$a++) 
	$header[$a] = $table_default_header_type;

for($a=0;$a<$kol;$a++) {
	$th1[$a] = $table_default_tblheader2_type;
	$th2[$a] = $table_default_tblheader2_type;
	$th3[$a] = $table_default_tblheader_type;
	$th4[$a] = $table_default_tblheader_type;
	$th5[$a] = $table_default_tblheader_type;
	$ws[$a] = $table_default_tblheader_type;
}

$th1[0]['WIDTH'] = 10;
$th1[1]['WIDTH'] = 65;

$th1[2]['WIDTH'] = 10;
$th1[3]['WIDTH'] = 9;
$th1[4]['WIDTH'] = 10;
$th1[5]['WIDTH'] = 9;

$th1[6]['WIDTH'] = 10;
$th1[7]['WIDTH'] = 9;
$th1[8]['WIDTH'] = 10;
$th1[9]['WIDTH'] = 9;

$th1[10]['WIDTH'] = 10;
$th1[11]['WIDTH'] = 9;
$th1[12]['WIDTH'] = 10;
$th1[13]['WIDTH'] = 9;

$th1[14]['WIDTH'] = 10;
$th1[15]['WIDTH'] = 9;
$th1[16]['WIDTH'] = 10;
$th1[17]['WIDTH'] = 9;

$th1[18]['WIDTH'] = 10;
$th1[19]['WIDTH'] = 9;
$th1[20]['WIDTH'] = 10;
$th1[21]['WIDTH'] = 9;

$th1[22]['WIDTH'] = 10;
$th1[23]['WIDTH'] = 9;
$th1[24]['WIDTH'] = 10;
$th1[25]['WIDTH'] = 9;

$th1[26]['WIDTH'] = 15;
$th1[27]['WIDTH'] = 10;

$th1[0]['TEXT'] = "<h1>DAFTAR PERKEMBANGAN WAJIB PAJAK DAERAH SE-KOTA BEKASI</h1>";
$th1[0]['COLSPAN'] = 28;
//$th1[0]['T_ALIGN'] = 'C';
$th1[0]['BRD_TYPE'] = 0;

$tkartu1 = $this->input->get('fDate');
$tkartu2 = $this->input->get('tDate');
if (empty($tkartu1))
	$tkartu1 = "-";
else 
	$tkartu1 = format_tgl($tkartu1);

if (empty($tkartu2))
	$tkartu2 = date("Y-m-d");
else 
	$tkartu2 = format_tgl($tkartu2);
	
$th2[0]['TEXT'] = "<h2>( Keadaan ".tanggal_lengkap($this->input->get('fDate'))." s/d ".tanggal_lengkap($this->input->get('tDate'))." )</h2>";
$th2[0]['COLSPAN'] = 28;
//$th2[0]['T_ALIGN'] = 'C';
$th2[0]['BRD_TYPE'] = 0;

$ws[0]['TEXT'] = "";
$ws[0]['COLSPAN'] = 28;
$ws[0]['BRD_TYPE'] = 0;

$th3[0]['TEXT'] = "No."; $th3[0]['ROWSPAN'] = 2;
$th3[1]['TEXT'] = "BADAN / KECAMATAN"; $th3[1]['ROWSPAN'] = 2;
$th3[2]['TEXT'] = "HOTEL"; $th3[2]['COLSPAN'] = 4;
$th3[6]['TEXT'] = "RESTORAN"; $th3[6]['COLSPAN'] = 4;
$th3[10]['TEXT'] = "HIBURAN"; $th3[10]['COLSPAN'] = 4;
$th3[14]['TEXT'] = "GENSET"; $th3[14]['COLSPAN'] = 4;
$th3[18]['TEXT'] = "PARKIR SWASTA"; $th3[18]['COLSPAN'] = 4;
$th3[22]['TEXT'] = "AIR TANAH"; $th3[22]['COLSPAN'] = 4;
$th3[26]['TEXT'] = "JUMLAH"; $th3[26]['COLSPAN'] = 2; $th3[26]['ROWSPAN'] = 2;

$th3[0]['BRD_TYPE'] = 'LT';$th3[1]['BRD_TYPE'] = 'LT';$th3[2]['BRD_TYPE'] = 'LT';$th3[6]['BRD_TYPE'] = 'LT';$th3[10]['BRD_TYPE'] = 'LT';$th3[14]['BRD_TYPE'] = 'LT';$th3[18]['BRD_TYPE'] = 'LT';$th3[22]['BRD_TYPE'] = 'LT';$th3[24]['BRD_TYPE'] = 'LT';$th3[26]['BRD_TYPE'] = 'LRT';

$th4[2]['TEXT'] = "LAMA"; $th4[2]['COLSPAN'] = 2;
$th4[4]['TEXT'] = "BARU"; $th4[4]['COLSPAN'] = 2;
$th4[6]['TEXT'] = "LAMA"; $th4[6]['COLSPAN'] = 2;
$th4[8]['TEXT'] = "BARU"; $th4[8]['COLSPAN'] = 2;
$th4[10]['TEXT'] = "LAMA"; $th4[10]['COLSPAN'] = 2;
$th4[12]['TEXT'] = "BARU"; $th4[12]['COLSPAN'] = 2;
$th4[14]['TEXT'] = "LAMA"; $th4[14]['COLSPAN'] = 2;
$th4[16]['TEXT'] = "BARU"; $th4[16]['COLSPAN'] = 2;
$th4[18]['TEXT'] = "LAMA"; $th4[18]['COLSPAN'] = 2;
$th4[20]['TEXT'] = "BARU"; $th4[20]['COLSPAN'] = 2;
$th4[22]['TEXT'] = "LAMA"; $th4[22]['COLSPAN'] = 2;
$th4[24]['TEXT'] = "BARU"; $th4[24]['COLSPAN'] = 2;

$th4[2]['BRD_TYPE'] = 'LT';
$th4[4]['BRD_TYPE'] = 'LT';
$th4[6]['BRD_TYPE'] = 'LT';
$th4[8]['BRD_TYPE'] = 'LT';
$th4[10]['BRD_TYPE'] = 'LT';
$th4[12]['BRD_TYPE'] = 'LT';
$th4[14]['BRD_TYPE'] = 'LT';
$th4[16]['BRD_TYPE'] = 'LT';
$th4[18]['BRD_TYPE'] = 'LT';
$th4[20]['BRD_TYPE'] = 'LT';
$th4[22]['BRD_TYPE'] = 'LT';
$th4[24]['BRD_TYPE'] = 'LRT';
$th4[26]['BRD_TYPE'] = 'LRT';

$th5[0]['TEXT'] = "<s>1</s>";
$th5[1]['TEXT'] = "<s>2</s>";
$th5[2]['TEXT'] = "<s>3</s>"; $th5[2]['COLSPAN'] = 2;
$th5[4]['TEXT'] = "<s>4</s>"; $th5[4]['COLSPAN'] = 2;
$th5[6]['TEXT'] = "<s>5</s>"; $th5[6]['COLSPAN'] = 2;
$th5[8]['TEXT'] = "<s>6</s>"; $th5[8]['COLSPAN'] = 2;
$th5[10]['TEXT'] = "<s>7</s>"; $th5[10]['COLSPAN'] = 2;
$th5[12]['TEXT'] = "<s>8</s>"; $th5[12]['COLSPAN'] = 2;
$th5[14]['TEXT'] = "<s>9</s>"; $th5[14]['COLSPAN'] = 2;
$th5[16]['TEXT'] = "<s>10</s>"; $th5[16]['COLSPAN'] = 2;
$th5[18]['TEXT'] = "<s>11</s>"; $th5[18]['COLSPAN'] = 2;
$th5[20]['TEXT'] = "<s>12</s>"; $th5[20]['COLSPAN'] = 2;
$th5[22]['TEXT'] = "<s>13</s>"; $th5[22]['COLSPAN'] = 2;
$th5[24]['TEXT'] = "<s>14</s>"; $th5[24]['COLSPAN'] = 2;
$th5[26]['TEXT'] = "<s>15</s>"; $th5[26]['COLSPAN'] = 2;

$th5[0]['BRD_TYPE'] = 'LT';$th5[1]['BRD_TYPE'] = 'LT';$th5[2]['BRD_TYPE'] = 'LT';$th5[4]['BRD_TYPE'] = 'LT';$th5[6]['BRD_TYPE'] = 'LT';$th5[8]['BRD_TYPE'] = 'LT';$th5[10]['BRD_TYPE'] = 'LT';$th5[12]['BRD_TYPE'] = 'LT';$th5[14]['BRD_TYPE'] = 'LT';$th5[16]['BRD_TYPE'] = 'LT';$th5[18]['BRD_TYPE'] = 'LT';$th5[20]['BRD_TYPE'] = 'LT';$th5[22]['BRD_TYPE'] = 'LT';$th5[24]['BRD_TYPE'] = 'LT';$th5[26]['BRD_TYPE'] = 'LRT';

$th5[0]['T_ALIGN'] = 'C';$th5[1]['T_ALIGN'] = 'C';$th5[2]['T_ALIGN'] = 'C';$th5[4]['T_ALIGN'] = 'C';$th5[6]['T_ALIGN'] = 'C';$th5[8]['T_ALIGN'] = 'C';$th5[10]['T_ALIGN'] = 'C';$th5[12]['T_ALIGN'] = 'C';$th5[14]['T_ALIGN'] = 'C';$th5[16]['T_ALIGN'] = 'C';$th5[18]['T_ALIGN'] = 'C';$th5[20]['T_ALIGN'] = 'C';$th5[22]['T_ALIGN'] = 'C';$th5[24]['T_ALIGN'] = 'C';$th5[26]['T_ALIGN'] = 'C';

$arHeader = array(
	$th1,
	$th2,
	$ws,
	$th3,
	$th4,
	$th5
);

$pdf->tbSetHeaderType($arHeader, true);

$pdf->tbDrawHeader();

$datax = array();
for($i=0; $i<$kol; $i++) $datax[$i] = $table_default_tbldata_type;

$pdf->tbSetDataType($datax);

for($i=0; $i<$kol; $i++) {
	$spc[$i] = $table_default_tbldata2_type;
	$data1[$i] = $table_default_tbldata2_type;
	$data2[$i] = $table_default_tbldata2_type;
	$data3[$i] = $table_default_tbldata2_type;
}

$spc[0]['TEXT'] = ""; $spc[0]['LN_SIZE'] = 3;
$spc[1]['TEXT'] = ""; $spc[1]['LN_SIZE'] = 3;
$spc[2]['TEXT'] = ""; $spc[2]['COLSPAN'] = 2; $spc[2]['LN_SIZE'] = 2;
$spc[4]['TEXT'] = ""; $spc[4]['COLSPAN'] = 2; $spc[4]['LN_SIZE'] = 2;
$spc[6]['TEXT'] = ""; $spc[6]['COLSPAN'] = 2; $spc[6]['LN_SIZE'] = 2;
$spc[8]['TEXT'] = ""; $spc[8]['COLSPAN'] = 2; $spc[8]['LN_SIZE'] = 2;
$spc[10]['TEXT'] = ""; $spc[10]['COLSPAN'] = 2; $spc[10]['LN_SIZE'] = 2;
$spc[12]['TEXT'] = ""; $spc[12]['COLSPAN'] = 2; $spc[12]['LN_SIZE'] = 2;
$spc[14]['TEXT'] = ""; $spc[14]['COLSPAN'] = 2; $spc[14]['LN_SIZE'] = 2;
$spc[16]['TEXT'] = ""; $spc[16]['COLSPAN'] = 2; $spc[16]['LN_SIZE'] = 2;
$spc[18]['TEXT'] = ""; $spc[18]['COLSPAN'] = 2; $spc[18]['LN_SIZE'] = 2;
$spc[20]['TEXT'] = ""; $spc[20]['COLSPAN'] = 2; $spc[20]['LN_SIZE'] = 2;
$spc[22]['TEXT'] = ""; $spc[22]['COLSPAN'] = 2; $spc[22]['LN_SIZE'] = 2;
$spc[24]['TEXT'] = ""; $spc[24]['COLSPAN'] = 2; $spc[24]['LN_SIZE'] = 2;
$spc[26]['TEXT'] = ""; $spc[26]['COLSPAN'] = 2; $spc[26]['LN_SIZE'] = 2;

$spc[0]['BRD_TYPE'] = 'LT';
$spc[1]['BRD_TYPE'] = 'LT';
$spc[2]['BRD_TYPE'] = 'LT';
$spc[4]['BRD_TYPE'] = 'LT';
$spc[6]['BRD_TYPE'] = 'LT';
$spc[8]['BRD_TYPE'] = 'LT';
$spc[10]['BRD_TYPE'] = 'LT';
$spc[12]['BRD_TYPE'] = 'LT';
$spc[14]['BRD_TYPE'] = 'LT';
$spc[16]['BRD_TYPE'] = 'LT';
$spc[18]['BRD_TYPE'] = 'LT';
$spc[20]['BRD_TYPE'] = 'LT';
$spc[22]['BRD_TYPE'] = 'LT';
$spc[24]['BRD_TYPE'] = 'LT';
$spc[26]['BRD_TYPE'] = 'LRT';

$pdf->tbDrawData($spc);

$no = 1;
$sqlx = $this->adodb->GetAll("SELECT * FROM kecamatan WHERE camat_kode <> '00' ORDER BY camat_kode ASC");
foreach($sqlx as $k => $v) {
	$data1[0]['TEXT'] = $no; $data1[0]['T_ALIGN'] = 'C';
	$data1[1]['TEXT'] = "  ".$v[camat_nama];
	
	//JML WP HOTEL LAMA
	//echo "SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='1' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'";
	$j1 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='1' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
	if($j1 == '0') $r1 = "- ";
	else $r1 = $j1 . " ";
	$data1[2]['TEXT'] = $r1; $data1[2]['T_ALIGN'] = 'R';
	$data1[3]['TEXT'] = " WP";
	
	//JML WP HOTEL BARU
	$j2 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='1' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
	if($j2 == '0') $r2 = "- ";
	else $r2 = $j2 . " ";
	$data1[4]['TEXT'] = $r2; $data1[4]['T_ALIGN'] = 'R';
	$data1[5]['TEXT'] = " WP";
	
	//JML WP RESTORAN LAMA
	$j3 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='16' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
	if($j3 == '0') $r3 = "- ";
	else $r3 = $j3 . " ";
	$data1[6]['TEXT'] = $r3; $data1[6]['T_ALIGN'] = 'R';
	$data1[7]['TEXT'] = " WP";
	
	//JML WP RESTORAN BARU
	$j4 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='16' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
	if($j4 == '0') $r4 = "- ";
	else $r4 = $j4 . " ";
	$data1[8]['TEXT'] = $r4; $data1[8]['T_ALIGN'] = 'R';
	$data1[9]['TEXT'] = " WP";
	
	//JML WP HIBURAN LAMA
	$j5 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='11' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
	if($j5 == '0') $r5 = "- ";
	else $r5 = $j5 . " ";
	$data1[10]['TEXT'] = $r5; $data1[10]['T_ALIGN'] = 'R';
	$data1[11]['TEXT'] = " WP";
	
	//JML WP HIBURAN BARU
	$j6 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='11' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
	if($j6 == '0') $r6 = "- ";
	else $r6 = $j6 . " ";
	$data1[12]['TEXT'] = $r6; $data1[12]['T_ALIGN'] = 'R';
	$data1[13]['TEXT'] = " WP";
	
	//JML WP GENSET LAMA
	$j7 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='12' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
	if($j7 == '0') $r7 = "- ";
	else $r7 = $j7 . " ";
	$data1[14]['TEXT'] = $r7; $data1[14]['T_ALIGN'] = 'R';
	$data1[15]['TEXT'] = " WP";
	
	//JML WP GENSET BARU
	$j8 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='12' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
	if($j8 == '0') $r8 = "- ";
	else $r8 = $j8 . " ";
	$data1[16]['TEXT'] = $r8; $data1[16]['T_ALIGN'] = 'R';
	$data1[17]['TEXT'] = " WP";
	
	//JML WP PARKIR SWASTA LAMA
	$j9 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='14' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
	if($j9 == '0') $r9 = "- ";
	else $r9 = $j9 . " ";
	$data1[18]['TEXT'] = $r9; $data1[18]['T_ALIGN'] = 'R';
	$data1[19]['TEXT'] = " WP";
	
	//JML WP PARKIR SWASTA BARU
	$j10 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='14' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
	if($j10 == '0') $r10 = "- ";
	else $r10 = $j10 . " ";
	$data1[20]['TEXT'] = $r10; $data1[20]['T_ALIGN'] = 'R';
	$data1[21]['TEXT'] = " WP";
	
	//JML WP AIR TANAH LAMA
	$j11 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='18' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
	if($j11 == '0') $r11 = "- ";
	else $r11 = $j11 . " ";
	$data1[22]['TEXT'] = $r11; $data1[22]['T_ALIGN'] = 'R';
	$data1[23]['TEXT'] = " WP";
	
	//JML WP AIR TANAH BARU
	$j12 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_bidang_usaha='18' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
	if($j12 == '0') $r12 = "- ";
	else $r12 = $j12 . " ";
	$data1[24]['TEXT'] = $r12; $data1[24]['T_ALIGN'] = 'R';
	$data1[25]['TEXT'] = " WP";
	
	//JML WP PER KECAMATAN
	$j13 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_kd_camat='$v[camat_id]' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu <= '$tkartu2'");
	if($j13 == '0') $r13 = "- ";
	else $r13 = $j13 . " ";
	$data1[26]['TEXT'] = $r13; $data1[26]['T_ALIGN'] = 'R';
	$data1[27]['TEXT'] = " WP";
	
	
	$data1[0]['BRD_TYPE'] = 'L';$data1[1]['BRD_TYPE'] = 'L';$data1[2]['BRD_TYPE'] = 'L';$data1[3]['BRD_TYPE'] = '';$data1[4]['BRD_TYPE'] = 'L';$data1[5]['BRD_TYPE'] = '';$data1[6]['BRD_TYPE'] = 'L';$data1[7]['BRD_TYPE'] = '';$data1[8]['BRD_TYPE'] = 'L';$data1[9]['BRD_TYPE'] = '';$data1[10]['BRD_TYPE'] = 'L';$data1[11]['BRD_TYPE'] = '';$data1[12]['BRD_TYPE'] = 'L';$data1[13]['BRD_TYPE'] = '';$data1[14]['BRD_TYPE'] = 'L';$data1[15]['BRD_TYPE'] = '';$data1[16]['BRD_TYPE'] = 'L';$data1[17]['BRD_TYPE'] = '';$data1[18]['BRD_TYPE'] = 'L';$data1[19]['BRD_TYPE'] = '';$data1[20]['BRD_TYPE'] = 'L';$data1[21]['BRD_TYPE'] = '';$data1[22]['BRD_TYPE'] = 'L';$data1[23]['BRD_TYPE'] = '';$data1[24]['BRD_TYPE'] = 'L';$data1[25]['BRD_TYPE'] = '';$data1[26]['BRD_TYPE'] = 'L';$data1[27]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($data1);
	$no++;
}

$spc[0]['BRD_TYPE'] = 'L';$spc[1]['BRD_TYPE'] = 'L';$spc[2]['BRD_TYPE'] = 'L';$spc[4]['BRD_TYPE'] = 'L';$spc[6]['BRD_TYPE'] = 'L';$spc[8]['BRD_TYPE'] = 'L';$spc[10]['BRD_TYPE'] = 'L';$spc[12]['BRD_TYPE'] = 'L';$spc[14]['BRD_TYPE'] = 'L';$spc[16]['BRD_TYPE'] = 'L';$spc[18]['BRD_TYPE'] = 'L';$spc[20]['BRD_TYPE'] = 'L';$spc[22]['BRD_TYPE'] = 'L';$spc[24]['BRD_TYPE'] = 'L';$spc[26]['BRD_TYPE'] = 'LR';
$pdf->tbDrawData($spc);

$data2[0]['TEXT'] = "JUMLAH"; $data2[0]['COLSPAN'] = 2; $data2[0]['T_ALIGN'] = 'C';

//JML WP HOTEL LAMA SELURUH KECAMATAN
$jk1 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='1' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
if($jk1 == '0') $rk1 = "- ";
else $rk1 = $jk1 . " ";
$data2[2]['TEXT'] = $rk1; $data2[2]['T_ALIGN'] = 'R';
$data2[3]['TEXT'] = " WP";

//JML WP HOTEL BARU SELURUH KECAMATAN
$jk2 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='1' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
if($jk2 == '0') $rk2 = "- ";
else $rk2 = $jk2 . " ";
$data2[4]['TEXT'] = $rk2; $data2[4]['T_ALIGN'] = 'R';
$data2[5]['TEXT'] = " WP";

//JML WP RESTORAN LAMA SELURUH KECAMATAN
$jk3 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='16' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
if($jk3 == '0') $rk3 = "- ";
else $rk3 = $jk3 . " ";
$data2[6]['TEXT'] = $rk3; $data2[6]['T_ALIGN'] = 'R';
$data2[7]['TEXT'] = " WP";

//JML WP RESTORAN BARU SELURUH KECAMATAN
$jk4 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='16' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
if($jk4 == '0') $rk4 = "- ";
else $rk4 = $jk4 . " ";
$data2[8]['TEXT'] = $rk4; $data2[8]['T_ALIGN'] = 'R';
$data2[9]['TEXT'] = " WP";

//JML WP HIBURAN LAMA SELURUH KECAMATAN
$jk5 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='11' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
if($jk5 == '0') $rk5 = "- ";
else $rk5 = $jk5 . " ";
$data2[10]['TEXT'] = $rk5; $data2[10]['T_ALIGN'] = 'R';
$data2[11]['TEXT'] = " WP";

//JML WP HIBURAN BARU SELURUH KECAMATAN
$jk6 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='11' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
if($jk6 == '0') $rk6 = "- ";
else $rk6 = $jk6 . " ";
$data2[12]['TEXT'] = $rk6; $data2[12]['T_ALIGN'] = 'R';
$data2[13]['TEXT'] = " WP";

//JML WP GENSET LAMA SELURUH KECAMATAN
$jk7 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='12' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
if($jk7 == '0') $rk7 = "- ";
else $rk7 = $jk7 . " ";
$data2[14]['TEXT'] = $rk7; $data2[14]['T_ALIGN'] = 'R';
$data2[15]['TEXT'] = " WP";

//JML WP GENSET BARU SELURUH KECAMATAN
$jk8 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='12' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
if($jk8 == '0') $rk8 = "- ";
else $rk8 = $jk8 . " ";
$data2[16]['TEXT'] = $rk8; $data2[16]['T_ALIGN'] = 'R';
$data2[17]['TEXT'] = " WP";

//JML WP PARKIR SWASTA LAMA SELURUH KECAMATAN
$jk9 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='14' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
if($jk9 == '0') $rk9 = "- ";
else $rk9 = $jk9 . " ";
$data2[18]['TEXT'] = $rk9; $data2[18]['T_ALIGN'] = 'R';
$data2[19]['TEXT'] = " WP";

//JML WP PARKIR SWASTA BARU SELURUH KECAMATAN
$jk10 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='14' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
if($jk10 == '0') $rk10 = "- ";
else $rk10 = $jk10 . " ";
$data2[20]['TEXT'] = $rk10; $data2[20]['T_ALIGN'] = 'R';
$data2[21]['TEXT'] = " WP";

//JML WP AIR TANAH LAMA SELURUH KECAMATAN
$jk11 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='18' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu < '$tkartu1'");
if($jk11 == '0') $rk11 = "- ";
else $rk11 = $jk11 . " ";
$data2[22]['TEXT'] = $rk11; $data2[22]['T_ALIGN'] = 'R';
$data2[23]['TEXT'] = " WP";

//JML WP AIR TANAH BARU SELURUH KECAMATAN
$jk12 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='18' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu BETWEEN '$tkartu1' AND '$tkartu2'");
if($jk12 == '0') $rk12 = "- ";
else $rk12 = $jk12 . " ";
$data2[24]['TEXT'] = $rk12; $data2[24]['T_ALIGN'] = 'R';
$data2[25]['TEXT'] = " WP";

$data2[26]['TEXT'] = "";
$data2[27]['TEXT'] = "";

$data2[0]['BRD_TYPE'] = 'LT';$data2[2]['BRD_TYPE'] = 'LT';$data2[3]['BRD_TYPE'] = 'T';$data2[4]['BRD_TYPE'] = 'LT';$data2[5]['BRD_TYPE'] = 'T';$data2[6]['BRD_TYPE'] = 'LT';$data2[7]['BRD_TYPE'] = 'T';$data2[8]['BRD_TYPE'] = 'LT';$data2[9]['BRD_TYPE'] = 'T';$data2[10]['BRD_TYPE'] = 'LT';$data2[11]['BRD_TYPE'] = 'T';$data2[12]['BRD_TYPE'] = 'LT';$data2[13]['BRD_TYPE'] = 'T';$data2[14]['BRD_TYPE'] = 'LT';$data2[15]['BRD_TYPE'] = 'T';$data2[16]['BRD_TYPE'] = 'LT';$data2[17]['BRD_TYPE'] = 'T';$data2[18]['BRD_TYPE'] = 'LT';$data2[19]['BRD_TYPE'] = 'T';$data2[20]['BRD_TYPE'] = 'LT';$data2[21]['BRD_TYPE'] = 'T';$data2[22]['BRD_TYPE'] = 'LT';$data2[23]['BRD_TYPE'] = 'T';$data2[24]['BRD_TYPE'] = 'LT';$data2[25]['BRD_TYPE'] = 'T';$data2[26]['BRD_TYPE'] = 'LT';$data2[27]['BRD_TYPE'] = 'RT';

$pdf->tbDrawData($data2);

$data3[0]['TEXT'] = "JUMLAH TOTAL"; $data3[0]['COLSPAN'] = 2; $data3[0]['T_ALIGN'] = 'C';

//JML WP HOTEL SELURUH KECAMATAN
$nw1 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='1' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu <= '$tkartu2'");
if($nw1 == '0') $rw1 = "- ";
else $rw1 = $nw1." ";
$data3[2]['TEXT'] = $rw1; $data3[2]['COLSPAN'] = 2; $data3[2]['T_ALIGN'] = 'R';
$data3[4]['TEXT'] = " WP"; $data3[4]['COLSPAN'] = 2; $data3[4]['T_ALIGN'] = 'L';

//JML WP RESTORAN SELURUH KECAMATAN
$nw2 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='16' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu <= '$tkartu2'");
if($nw2 == '0') $rw2 = "- ";
else $rw2 = $nw2." ";
$data3[6]['TEXT'] = $rw2; $data3[6]['COLSPAN'] = 2; $data3[6]['T_ALIGN'] = 'R';
$data3[8]['TEXT'] = " WP"; $data3[8]['COLSPAN'] = 2; $data3[8]['T_ALIGN'] = 'L';

//JML WP HIBURAN SELURUH KECAMATAN
$nw3 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='11' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu <= '$tkartu2'");
if($nw3 == '0') $rw3 = "- ";
else $rw3 = $nw3." ";
$data3[10]['TEXT'] = $rw3; $data3[10]['COLSPAN'] = 2; $data3[10]['T_ALIGN'] = 'R';
$data3[12]['TEXT'] = " WP"; $data3[12]['COLSPAN'] = 2; $data3[12]['T_ALIGN'] = 'L';

//JML WP GENSET SELURUH KECAMATAN
$nw4 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='12' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu <= '$tkartu2'");
if($nw4 == '0') $rw4 = "- ";
else $rw4 = $nw4." ";
$data3[14]['TEXT'] = $rw4; $data3[14]['COLSPAN'] = 2; $data3[14]['T_ALIGN'] = 'R';
$data3[16]['TEXT'] = " WP"; $data3[16]['COLSPAN'] = 2; $data3[16]['T_ALIGN'] = 'L';

//JML WP PARKIR SWASTA SELURUH KECAMATAN
$nw5 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='14' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu <= '$tkartu2'");
if($nw5 == '0') $rw5 = "- ";
else $rw5 = $nw5." ";
$data3[18]['TEXT'] = $rw5; $data3[18]['COLSPAN'] = 2; $data3[18]['T_ALIGN'] = 'R';
$data3[20]['TEXT'] = " WP"; $data3[20]['COLSPAN'] = 2; $data3[20]['T_ALIGN'] = 'L';

//JML WP AIR TANAH SELURUH KECAMATAN
$nw7 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_bidang_usaha='18' AND wp_wr_status_aktif='t' AND wp_wr_tgl_kartu <= '$tkartu2'");
if($nw7 == '0') $rw7 = "- ";
else $rw7 = $nw7." ";
$data3[22]['TEXT'] = $rw7; $data3[22]['COLSPAN'] = 2; $data3[22]['T_ALIGN'] = 'R';
$data3[24]['TEXT'] = " WP"; $data3[24]['COLSPAN'] = 2; $data3[24]['T_ALIGN'] = 'L';

//JML WP SE-KOTA BEKASI
$nw6 = $this->adodb->GetOne("SELECT count(wp_wr_id) FROM wp_wr WHERE wp_wr_status_aktif='t' AND wp_wr_tgl_kartu <= '$tkartu2'");
if($nw6 == '0') $rw6 = "- ";
else $rw6 = $nw6." ";
$data3[26]['TEXT'] = "<bi>".$rw6."</bi>"; $data3[26]['T_ALIGN'] = 'R';
$data3[27]['TEXT'] = "<bi> WP</bi>";

$data3[0]['BRD_TYPE'] = 'LT';$data3[2]['BRD_TYPE'] = 'LT';$data3[4]['BRD_TYPE'] = 'T';$data3[6]['BRD_TYPE'] = 'LT';$data3[8]['BRD_TYPE'] = 'T';$data3[10]['BRD_TYPE'] = 'LT';$data3[12]['BRD_TYPE'] = 'T';$data3[14]['BRD_TYPE'] = 'LT';$data3[16]['BRD_TYPE'] = 'T';$data3[18]['BRD_TYPE'] = 'LT';$data3[20]['BRD_TYPE'] = 'T';$data3[22]['BRD_TYPE'] = 'LT';$data3[24]['BRD_TYPE'] = 'T';$data3[26]['BRD_TYPE'] = 'LT';$data3[27]['BRD_TYPE'] = 'RT';

$pdf->tbDrawData($data3);

$data4[0]['TEXT'] = ""; $data4[0]['COLSPAN'] = 28; $data4[0]['BRD_TYPE'] = 'T';
$pdf->tbDrawData($data4);
$pdf->tbOuputData();

//mengetahui dan diperiksa
$klm = 2;
$pdf->tbInitialize($klm, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($c=0;$c<$klm;$c++) $hdrt[$c] = $table_default_header_type;

for($c=0;$c<$klm;$c++) {
	$ac[$c] = $table_default_header_type;
}
$ac[0]['WIDTH'] = 165;
$ac[1]['WIDTH'] = 165;

$arhdr = array($ac);
$pdf->tbSetHeaderType($arhdr,true);

$dtxs = array();
for($c=0;$c<$klm;$c++) $dtxs[$c] = $table_default_datax_type;

$pdf->tbSetDataType($dtxs);

for($c=0;$c<$klm;$c++) {
	$ttd1[$c] = $table_default_ttd_type;
	$ttd2[$c] = $table_default_ttd_type;
}

if ($this->input->get('mengetahui') != "0" && $this->input->get('pemeriksa') != "0") {
	$ttd1[0]['TEXT'] = "Mengetahui,";
	$ttd1[1]['TEXT'] = "Bekasi, ". tanggal_lengkap($this->input->get('tgl_cetak'));
	$pdf->tbDrawData($ttd1);
	
	if ($this->session->userdata('USER_SPT_CODE') == "10" && $mengetahui->pejda_jabatan != "80") {
		$ttd1[0]['TEXT'] = "a.n. ".$this->config->item('nama_jabatan_kepala_dinas')."\n";
		$ttd1[0]['TEXT'] .= $mengetahui->ref_japeda_nama;
		$ttd1[1]['TEXT'] = $pemeriksa->ref_japeda_nama;
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