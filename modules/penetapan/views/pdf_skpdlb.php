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

$pdf = new FPDF_TABLE('P','mm','Letter'); // Potrait,Letter,Lebar = 335
$pdf->Open();
$pdf->SetFont('Arial','',8);
$pdf->SetAutoPageBreak(true, 10); // Page Break dengan margin bawah 1 cm
$pdf->SetMargins(15, 10, 10);     // Margin Left, Top, Right 2 cm

$data_id = $model->get_ketetapan_id();

if (!empty($data_id)) {
	foreach ($data_id as $k => $v) {
		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		$data = $model->get_ketetapan_by_id($v['netapajrek_id']);
		
		//set style
		$pdf->SetStyle("sb","arial","B",8,"0,0,0");
		$pdf->SetStyle("ns","arial","",7,"0,0,0");
		$pdf->SetStyle("b","arial","B",9,"0,0,0");
		$pdf->SetStyle("i","arial","I",7,"0,0,0");
		$pdf->SetStyle("h1","arial","B",9,"0,0,0");
		$pdf->SetStyle("h2","arial","B",8,"0,0,0");
		$pdf->SetStyle("h3","arial","B",11,"0,0,0");
		$pdf->SetStyle("nu","arial","U",9,"0,0,0");
		$pdf->SetStyle("cut","arial","I",8,"170,170,170");
		$pdf->SetStyle("th1","arial","B",8,"0,0,0");
		
		$infopemda = "<th1>PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2)."</th1>\n".
		        "<th1>".strtoupper($pemda->nama_dinas)."</th1>\n".$pemda->dapemda_lokasi."\n".
				"Telp. ".$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax."\n<th1>".strtoupper($pemda->dapemda_nm_dati2)."</th1>";
		$title = ucwords($data[0]['ketspt_ket']);
		$s_title = strtoupper($data[0]['ketspt_singkat']); 
		
		$kol = 6;
		$pdf->tbInitialize($kol, true, true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($a=0;$a<$kol;$a++) $hdrx[$a] = $table_default_header_type;
		
		for($a=0; $a<$kol; $a++) {
			$spacer1[$a] = $table_default_datax_type;
			$header_type1[$a] = $table_default_headerx_type;
			$header_type2[$a] = $table_default_headerx_type;
			$header_type3[$a] = $table_default_headerx_type;
			$header_type4[$a] = $table_default_headerx_type;
			$spacer2[$a] = $table_default_datax_type;
		}
		
		$spacer1[0]['WIDTH'] = 15;$spacer1[1]['WIDTH'] = 60;$spacer1[2]['WIDTH'] = 5;$spacer1[3]['WIDTH'] = 75;$spacer1[4]['WIDTH'] = 5;$spacer1[5]['WIDTH'] = 30;
		$spacer1[0]['TEXT'] = "";$spacer1[1]['TEXT'] = "";$spacer1[2]['TEXT'] = "";$spacer1[3]['TEXT'] = "";$spacer1[4]['TEXT'] = "";$spacer1[5]['TEXT'] = "";
		$spacer1[0]['BRD_TYPE'] = 'LT';$spacer1[1]['BRD_TYPE'] = 'T';$spacer1[2]['BRD_TYPE'] = 'LT';$spacer1[3]['BRD_TYPE'] = 'T';$spacer1[4]['BRD_TYPE'] = 'T';$spacer1[5]['BRD_TYPE'] = 'LRT';
		$spacer1[0]['LN_SIZE'] = 1;$spacer1[1]['LN_SIZE'] = 1;$spacer1[2]['LN_SIZE'] = 1;$spacer1[3]['LN_SIZE'] = 1;$spacer1[4]['LN_SIZE'] = 1;$spacer1[5]['LN_SIZE'] = 1;
		
		$header_type1[0]['TEXT'] = "";
		$header_type1[1]['TEXT'] = "<ns>".$infopemda. "</ns>";
		$header_type1[2]['TEXT'] = "";
		$header_type1[3]['TEXT'] = "<h1>".$s_title."</h1>\n<h2>(".strtoupper($title).")</h2>";
		$header_type1[4]['TEXT'] = "";
		$header_type1[5]['TEXT'] = "No. Urut\n".format_angka($this->config->item('length_kohir_spt'), $data[0]['netapajrek_kohir']);
		$header_type1[0]['BRD_TYPE'] = 'L';
		$header_type1[2]['BRD_TYPE'] = 'L';
		$header_type1[5]['BRD_TYPE'] = 'LR';
		$header_type1[1]['T_ALIGN'] = 'L';
		$header_type1[5]['T_SIZE'] = 7;
		$header_type1[1]['LN_SIZE'] = 3;
		$header_type1[0]['ROWSPAN'] = 2;
		$header_type1[1]['ROWSPAN'] = 2;
		$header_type1[2]['ROWSPAN'] = 2;
		$header_type1[4]['ROWSPAN'] = 2;
		$header_type1[5]['ROWSPAN'] = 2;
		
		$header_type2[0]['TEXT'] = "";
		$header_type2[1]['TEXT'] = "";
		$header_type2[2]['TEXT'] = "";
		if (count($data) > 1) {
			$lhp_periode = $model->get_min_max_masa_pajak($v['netapajrek_id']);
			$lhp_periode_min = $lhp_periode[0]['lhp_dt_periode1'];
			$lhp_periode_max = $lhp_periode[0]['lhp_dt_periode2'];
			
			$lhp_periode1 = explode("-",$lhp_periode_min);
			$lhp_periode_bulan1 = $lhp_periode1[1];
			$lhp_periode_tahun1 = $lhp_periode1[0];
			$masa_pajak_bulan1 = strtoupper(format_tgl('-'.$lhp_periode_bulan1.'-',false,true));
			
			$lhp_periode2 = explode("-",$lhp_periode_max);
			$lhp_periode_bulan2 = $lhp_periode2[1];
			$lhp_periode_tahun2 = $lhp_periode2[0];
			$masa_pajak_bulan2 = strtoupper(format_tgl('-'.$lhp_periode_bulan2.'-',false,true));
			
			$header_type2[3]['TEXT'] = "Masa Pajak  : ".$masa_pajak_bulan1." ".$lhp_periode_tahun1." s/d ".$masa_pajak_bulan2." ".$lhp_periode_tahun2."\nTahun  : ".$data[0]['lhp_periode'];	
		}
		else {
			$lhp_periode = explode("-",$data[0]['lhp_dt_periode1']);
			$lhp_periode_bulan = $lhp_periode[1];
			$lhp_periode_tahun = $lhp_periode[0];
			$masa_pajak_bulan = strtoupper(format_tgl('-'.$lhp_periode_bulan.'-',false,true));
			
			$header_type2[3]['TEXT'] = "Masa   : ".$masa_pajak_bulan."".$lhp_periode_tahun."\nTahun  : ".$data[0]['lhp_periode'];
		}
		$header_type2[4]['TEXT'] = "";
		$header_type2[5]['TEXT'] = "";
		$header_type2[3]['T_ALIGN'] = 'C';
		$header_type2[3]['T_SIZE'] = 7;
		$header_type2[0]['BRD_TYPE'] = 'L';
		$header_type2[1]['BRD_TYPE'] = '0';
		$header_type2[2]['BRD_TYPE'] = 'L';
		$header_type2[3]['BRD_TYPE'] = '0';
		$header_type2[4]['BRD_TYPE'] = '0';
		$header_type2[5]['BRD_TYPE'] = 'LR';
		
		$spacer2[0]['TEXT'] = "";
		$spacer2[1]['TEXT'] = "";
		$spacer2[2]['TEXT'] = "";
		$spacer2[3]['TEXT'] = "";
		$spacer2[4]['TEXT'] = "";
		$spacer2[5]['TEXT'] = "";
		$spacer2[0]['BRD_TYPE'] = 'L';$spacer2[1]['BRD_TYPE'] = '0';$spacer2[2]['BRD_TYPE'] = 'L';$spacer2[3]['BRD_TYPE'] = '0';$spacer2[4]['BRD_TYPE'] = '0';$spacer2[5]['BRD_TYPE'] = 'LR';
		$spacer2[0]['LN_SIZE'] = 1;$spacer2[1]['LN_SIZE'] = 1;$spacer2[2]['LN_SIZE'] = 1;$spacer2[3]['LN_SIZE'] = 1;$spacer2[4]['LN_SIZE'] = 1;$spacer2[5]['LN_SIZE'] = 1;
		
		$arHeader = array($spacer1,$spacer2,$header_type1,$header_type2,$spacer2,$spacer2);
		$pdf->tbSetHeaderType($arHeader,true);
		
		$pdf->tbDrawHeader();
		$pdf->tbOuputData();
		
		
		$kolom = 4;
		$pdf->tbInitialize($kolom, true, true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($b=0;$b<$kolom;$b++) $jkl[$b] = $table_default_headerx_type;
		
		for($b=0;$b<$kolom;$b++) {
			$idn[$b] = $table_default_headerx_type;
		}
		$idn[0]['WIDTH'] = 5;$idn[1]['WIDTH'] = 30;$idn[2]['WIDTH'] = 3;$idn[3]['WIDTH'] = 152;
		$pdf->tbSetHeaderType($idn);
		
		for($c=0;$c<$kolom;$c++) {
			$spc[$c] = $table_data_ketetapan_type;
			$tbd[$c] = $table_data_ketetapan_type;
			$spc2[$c] = $table_data_ketetapan_type;
		}
		$spc[0]['TEXT'] = "";
		$spc[0]['COLSPAN'] = 4;
		$spc[0]['BRD_TYPE'] = 'LRT';
		$spc[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($spc);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "Nama";
		$tbd[2]['TEXT'] = ":";
		$tbd[3]['TEXT'] = "".strtoupper($data[0][wp_wr_nama]);
		$tbd[0]['BRD_TYPE'] = 'L';$tbd[3]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "Alamat";
		$tbd[2]['TEXT'] = ":";
		$tbd[3]['TEXT'] = "".strtoupper(ereg_replace("\r|\n","",$data[0][wp_wr_almt]))." KEL. ".strtoupper($data[0][wp_wr_lurah]." KEC. ".$data[0][wp_wr_camat]);
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "NPWPD";
		$tbd[2]['TEXT'] = ":";
		$tbd[3]['TEXT'] = "".$data[0][npwprd];
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "Tanggal Jatuh Tempo";
		$tbd[2]['TEXT'] = ":";
		$tbd[3]['TEXT'] = format_tgl(format_tgl($data[0][netapajrek_tgl_jatuh_tempo]),false,true);
		$pdf->tbDrawData($tbd);		
		
		$spc2[0]['TEXT'] = "";
		$spc2[0]['COLSPAN'] = 4;
		$spc2[0]['BRD_TYPE'] = 'LR';
		$spc2[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($spc2);
		
		$pdf->tbOuputData();
		
		//body
		$kolom = 9;
		$pdf->tbInitialize($kolom, true, true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($b=0;$b<$kolom;$b++) $jkl[$b] = $table_default_headerx_type;
		
		for($b=0;$b<$kolom;$b++) {
			$idn[$b] = $table_default_headerx_type;
		}
		$idn[0]['WIDTH'] = 1;
		$idn[1]['WIDTH'] = 4;
		$idn[2]['WIDTH'] = 5;
		$idn[3]['WIDTH'] = 97;
		$idn[4]['WIDTH'] = 12;
		$idn[5]['WIDTH'] = 28;
		$idn[6]['WIDTH'] = 12;
		$idn[7]['WIDTH'] = 28;
		$idn[8]['WIDTH'] = 3;
		$pdf->tbSetHeaderType($idn);
		
		for($c=0;$c<$kolom;$c++) {
			$spc[$c] = $table_data_ketetapan_type;
			$dt[$c] = $table_data_ketetapan_type;
			$dt2[$c] = $table_data_ketetapan_type;
			$dt3[$c] = $table_data_ketetapan_type;
			$dt4[$c] = $table_data_ketetapan_type;
			$spc2[$c] = $table_data_ketetapan_type;
		}
		
		$spc[0]['TEXT'] = "";
		$spc[0]['COLSPAN'] = 9;
		$spc[0]['BRD_TYPE'] = 'LRT';
		$spc[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($spc);
		
		$dt[0]['TEXT'] = "";$dt[0]['BRD_TYPE'] = 'L';
		$dt[1]['TEXT'] = "I.";
		$dt[2]['TEXT'] = "Berdasarkan Pasal 170 Undang-undang No. 28 Tahun 2009 telah dilakukan pemeriksaan atau keterangan lain atas";
		$dt[2]['COLSPAN'] = 6;
		$dt[8]['TEXT'] = "";$dt[8]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[0]['BRD_TYPE'] = 'L';
		$dt[1]['TEXT'] = "";
		$dt[2]['TEXT'] = "pelaksanaan kewajiban :";
		$dt[2]['COLSPAN'] = 6;
		$dt[8]['TEXT'] = "";$dt[8]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[0]['BRD_TYPE'] = 'L';
		$dt[1]['TEXT'] = "";
		$dt[2]['TEXT'] = "Kode Rekening	:   ".$data[0]['rekening'];
		$dt[2]['COLSPAN'] = 6;
		$dt[8]['TEXT'] = "";$dt[8]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[0]['BRD_TYPE'] = 'L';
		$dt[1]['TEXT'] = "";
		$dt[2]['TEXT'] = "Nama Pajak	     :   ".strtoupper($data[0]['ref_jenparet_ket']);
		$dt[2]['COLSPAN'] = 6;
		$dt[9]['TEXT'] = "";$dt[9]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($dt);
		
		$spc2[0]['TEXT'] = "";
		$spc2[0]['COLSPAN'] = 9;
		$spc2[0]['LN_SIZE'] = 3;
		$spc2[0]['BRD_TYPE'] = 'LR';
		$pdf->tbDrawData($spc2);
		
		$dt[0]['TEXT'] = "";$dt[0]['BRD_TYPE'] = 'L';
		$dt[1]['TEXT'] = "II.";
		$dt[2]['TEXT'] = "Dan pemeriksaan atau keterangan lain tersebut diatas, penghitungan jumlah yang masih harus dibayar adalah sebagai berikut :";
		$dt[2]['COLSPAN'] = 6;
		$dt[9]['TEXT'] = "";$dt[9]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt);
		
		//prepare data jumlah pajak
		$lhp_dt_dsr_pengenaan = 0; $lhp_dt_pajak = 0;
		$lhp_dt_kompensasi= 0; $lhp_dt_setoran = 0;
		$lhp_dt_kredit_pjk_lain = 0; $lhp_dt_bunga=0; $lhp_dt_kenaikan = 0;
		
		foreach ($data as $key => $value) {
			$lhp_dt_dsr_pengenaan += $value['lhp_dt_dsr_pengenaan'];
			$lhp_dt_pajak += $value['lhp_dt_pajak'];
			$lhp_dt_kompensasi += $value['lhp_dt_kompensasi'];
			$lhp_dt_setoran += $value['lhp_dt_setoran'];
			$lhp_dt_kredit_pjk_lain += $value['lhp_dt_kredit_pjk_lain'];
			$lhp_dt_bunga += $value['lhp_dt_bunga'];
			$lhp_dt_kenaikan += $value['lhp_dt_kenaikan'];
		}
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "1.";
		$dt2[3]['TEXT'] = "Dasar Pengenaan";
		$dt2[4]['TEXT'] = "";
		$dt2[5]['TEXT'] = "";
		$dt2[6]['TEXT'] = "Rp.";
		$dt2[6]['T_ALIGN'] = 'R';
		$dt2[7]['TEXT'] = format_currency($lhp_dt_dsr_pengenaan);
		$dt2[7]['T_ALIGN'] = 'R';
		$dt2[8]['TEXT'] = "";$dt2[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt2);

		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "2.";
		$dt2[3]['TEXT'] = "Pajak yang terhutang";
		$dt2[4]['TEXT'] = "";
		$dt2[5]['TEXT'] = "";
		$dt2[6]['TEXT'] = "Rp.";
		$dt2[6]['T_ALIGN'] = 'R';
		$dt2[7]['TEXT'] = format_currency($lhp_dt_pajak);
		$dt2[7]['T_ALIGN'] = 'R';
		$dt2[8]['TEXT'] = "";$dt2[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt2);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "3.";
		$dt2[3]['TEXT'] = "Kredit Pajak :";
		$dt2[4]['TEXT'] = "";
		$dt2[5]['TEXT'] = "";
		$dt2[6]['TEXT'] = "";
		$dt2[7]['TEXT'] = "";
		$dt2[8]['TEXT'] = "";$dt2[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt2);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "";
		$dt2[3]['TEXT'] = "a. Kompensasi kelebihan dari tahun sebelumnya";
		$dt2[4]['TEXT'] = "Rp.";$dt2[4]['T_ALIGN'] = 'R';
		$dt2[5]['TEXT'] = format_currency($lhp_dt_kompensasi);$dt2[5]['T_ALIGN'] = 'R';
		$dt2[6]['TEXT'] = "";
		$dt2[7]['TEXT'] = "";
		$dt2[8]['TEXT'] = "";$dt2[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt2);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "";
		$dt2[3]['TEXT'] = "b. Setoran yang dilakukan";
		$dt2[4]['TEXT'] = "Rp.";$dt2[4]['T_ALIGN'] = 'R';
		$dt2[5]['TEXT'] = format_currency($lhp_dt_setoran);$dt2[5]['T_ALIGN'] = 'R';
		$dt2[6]['TEXT'] = "";
		$dt2[7]['TEXT'] = "";
		$dt2[8]['TEXT'] = "";$dt2[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt2);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "";
		$dt2[3]['TEXT'] = "c. Lain-lain";
		$dt2[4]['TEXT'] = "Rp.";$dt2[4]['T_ALIGN'] = 'R';
		$dt2[5]['TEXT'] = format_currency($lhp_dt_kredit_pjk_lain);$dt2[5]['T_ALIGN'] = 'R';
		$dt2[6]['TEXT'] = "";
		$dt2[7]['TEXT'] = "";
		$dt2[8]['TEXT'] = "";$dt2[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt2);
		
		$total_kredit = $lhp_dt_kompensasi + $lhp_dt_setoran + $lhp_dt_kredit_pjk_lain;
		$dt3[0]['TEXT'] = "";$dt3[0]['BRD_TYPE'] = 'L';
		$dt3[1]['TEXT'] = "";
		$dt3[2]['TEXT'] = "";
		$dt3[3]['TEXT'] = "d. Jumlah yang dapat dikreditkan (a+b+c)";
		$dt3[4]['TEXT'] = "";$dt3[4]['BRD_TYPE'] = 'T';
		$dt3[5]['TEXT'] = "";$dt3[5]['BRD_TYPE'] = 'T';
		$dt3[6]['TEXT'] = "Rp.";
		$dt3[6]['T_ALIGN'] = 'R';
		$dt3[7]['TEXT'] = format_currency($total_kredit);
		$dt3[7]['T_ALIGN'] = 'R';
		$dt3[8]['TEXT'] = "";$dt3[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt3);
		
		$kurang_bayar = $total_kredit - $lhp_dt_pajak;
		$dt4[0]['TEXT'] = "";$dt4[0]['BRD_TYPE'] = 'L';
		$dt4[1]['TEXT'] = "";
		$dt4[2]['TEXT'] = "4.";
		$dt4[3]['TEXT'] = "Jumlah kekurangan pembayaran Pokok Pajak (3d-2)";
		$dt4[4]['TEXT'] = "";
		$dt4[5]['TEXT'] = "";
		$dt4[6]['TEXT'] = "Rp.";$dt4[6]['T_ALIGN'] = 'R';$dt4[6]['BRD_TYPE'] = 'T';
		$dt4[7]['TEXT'] = format_currency($kurang_bayar);$dt4[7]['T_ALIGN'] = 'R';$dt4[7]['BRD_TYPE'] = 'T';
		$dt4[8]['TEXT'] = "";$dt4[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt4);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "5.";
		$dt2[3]['TEXT'] = "Sanksi Administrasi :";
		$dt2[4]['TEXT'] = "";
		$dt2[5]['TEXT'] = "";
		$dt2[6]['TEXT'] = "";
		$dt2[7]['TEXT'] = "";
		$dt2[8]['TEXT'] = "";$dt2[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt2);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "";
		$dt2[3]['TEXT'] = "a. Bunga (Psl. 9(1))";
		$dt2[4]['TEXT'] = "Rp.";$dt2[4]['T_ALIGN'] = 'R';
		$dt2[5]['TEXT'] = format_currency($lhp_dt_bunga);$dt2[5]['T_ALIGN'] = 'R';
		$dt2[6]['TEXT'] = "";
		$dt2[7]['TEXT'] = "";
		$dt2[8]['TEXT'] = "";$dt2[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt2);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "";
		$dt2[3]['TEXT'] = "b. Kenaikan (Psl. 9(5))";
		$dt2[4]['TEXT'] = "Rp.";$dt2[4]['T_ALIGN'] = 'R';
		$dt2[5]['TEXT'] = format_currency($lhp_dt_kenaikan);$dt2[5]['T_ALIGN'] = 'R';
		$dt2[6]['TEXT'] = "";
		$dt2[7]['TEXT'] = "";
		$dt2[8]['TEXT'] = "";$dt2[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt2);
		
		$total_sanksi = $lhp_dt_bunga + $lhp_dt_kenaikan;
		$dt3[0]['TEXT'] = "";$dt3[0]['BRD_TYPE'] = 'L';
		$dt3[1]['TEXT'] = "";
		$dt3[2]['TEXT'] = "";
		$dt3[3]['TEXT'] = "c. Jumlah sanksi administrasi (a+b)";
		$dt3[4]['TEXT'] = "";$dt3[4]['BRD_TYPE'] = 'T';
		$dt3[5]['TEXT'] = "";$dt3[5]['BRD_TYPE'] = 'T';
		$dt3[6]['TEXT'] = "Rp.";$dt3[6]['T_ALIGN'] = 'R';
		$dt3[7]['TEXT'] = format_currency($total_sanksi);$dt3[7]['T_ALIGN'] = 'R';
		$dt3[8]['TEXT'] = "";$dt3[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt3);
		
		$total_pajak = $kurang_bayar + $total_sanksi;
		$dt4[0]['TEXT'] = "";$dt4[0]['BRD_TYPE'] = 'L';
		$dt4[1]['TEXT'] = "";
		$dt4[2]['TEXT'] = "6.";
		$dt4[3]['TEXT'] = "Jumlah yang masih harus dibayar (4+5c)";
		$dt4[4]['TEXT'] = "";
		$dt4[5]['TEXT'] = "";
		$dt4[6]['TEXT'] = "Rp.";
		$dt4[7]['TEXT'] = format_currency($total_pajak);
		$dt4[8]['TEXT'] = "";$dt4[8]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($dt4);
		
		$spc2[0]['TEXT'] = "";
		$spc2[0]['COLSPAN'] = 9;
		$spc2[0]['LN_SIZE'] = 3;
		$spc2[0]['BRD_TYPE'] = 'LR';
		$pdf->tbDrawData($spc2);
		
		$pdf->tbOuputData();
		
		//Bagian Huruf
		$kol = 4;
		$pdf->tbInitialize($kol,true,true);
		$pdf->tbSetTableType($table_data_ketetapan_type);
		
		for($i=0;$i<$kol;$i++) $setw[$i] = $table_default_header_type;
		
		for($i=0;$i<$kol;$i++) {
			$wid[$i] = $table_data_ketetapan_type;
		}
		$wid[0]['WIDTH'] = 5;$wid[1]['WIDTH'] = 27;$wid[2]['WIDTH'] = 153;$wid[3]['WIDTH'] = 5;
		
		$pdf->tbSetHeaderType($wid);
		
		for($i=0;$i<$kol;$i++) {
			$spc[$i] = $table_data_ketetapan_type;
			$dg[$i] = $table_data_ketetapan_type;
			$whs[$i] = $table_data_ketetapan_type;
		}
		
		$spc[0]['TEXT'] = "";
		$spc[0]['COLSPAN'] = 4;
		$spc[0]['BRD_TYPE'] = 'LRT';
		$spc[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($spc);
		
		$dg[0]['TEXT'] = "";$dg[1]['TEXT'] = "Dengan huruf :";$dg[2]['TEXT'] = "". ucwords(strtolower(terbilang($total_pajak). " Rupiah"))."";$dg[3]['TEXT'] = "";
		$dg[0]['BRD_TYPE'] = 'L';$dg[1]['BRD_TYPE'] = '0';$dg[2]['BRD_TYPE'] = 'LT';$dg[3]['BRD_TYPE'] = 'LR';
		$pdf->tbDrawData($dg);
		
		$whs[0]['TEXT'] = "";$whs[1]['TEXT'] = "";$whs[2]['TEXT'] = "";$whs[3]['TEXT'] = "";
		$whs[0]['BRD_TYPE'] = 'L';$whs[1]['BRD_TYPE'] = '0';$whs[2]['BRD_TYPE'] = 'T';$whs[3]['BRD_TYPE'] = 'R';
		$whs[0]['LN_SIZE'] = 2;$whs[1]['LN_SIZE'] = 2;$whs[2]['LN_SIZE'] = 2;$whs[3]['LN_SIZE'] = 2;
		$pdf->tbDrawData($whs);
		
		$pdf->tbOuputData();

		//Bagian PERHATIAN...
		$cols = 2;
		$pdf->tbInitialize($cols,true,true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($j=0;$j<$cols;$j++) $colw[$j] = $table_data_ketetapan_type;
		
		for($j=0;$j<$cols;$j++) {
			$cwid[$j] = $table_data_ketetapan_type;
		}
		$cwid[0]['WIDTH'] = 5;$cwid[1]['WIDTH'] = 185;
		$pdf->tbSetHeaderType($cwid);
		
		for($k=0;$k<$cols;$k++) {
			$ins[$k] = $table_data_ketetapan_type;
			$ket[$k] = $table_data_ketetapan_type;
		}
		
		$ins[0]['TEXT'] = "";
		$ins[0]['COLSPAN'] = 2;
		$ins[0]['BRD_TYPE'] = 'LRT';
		$ins[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($ins);
		
		$ins[0]['TEXT'] = "\n P  E  R  H  A  T  I  A  N ";
		$ins[0]['BRD_TYPE'] = 'LR';
		$pdf->tbDrawData($ins);
		
		$ket[0]['TEXT'] = "1.";
		$ket[1]['TEXT'] = "Pengembalian kelebihan pajak dilakukan pada Kas Daerah dengan menggunakan Surat Perintah Membayar Kelebihan Pajak (SPMKP) dan Surat Perintah Mengeluarkan Uang (SPMU).";
		$ket[0]['BRD_TYPE'] = 'L';$ket[1]['BRD_TYPE'] = 'R';
		$ket[0]['V_ALIGN'] = 'T';
		$ket[0]['T_ALIGN'] = 'R';
		$pdf->tbDrawData($ket);
		
		$ins[0]['TEXT'] = "";
		$ins[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($ins);
		
		$pdf->tbOuputData();
		
		//Bagian Tanda Tangan...
		$clm = 2;
		$pdf->tbInitialize($clm,true,true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($l=0;$l<$clm;$l++) $hdrx[$l] = $table_default_header_type;
		for($l=0;$l<$clm;$l++) {
			$lbr[$l] = $table_default_header_type;
		}
		$lbr[0]['WIDTH'] = 120;$lbr[1]['WIDTH'] = 70;
	
		$pdf->tbSetHeaderType($lbr);
		
		for($l=0;$l<$clm;$l++) {
			$tnd[$l] = $table_data_ketetapan_ttd_type;
			$jarak[$l] = $table_data_ketetapan_type;
			$dt[$l] = $table_data_ketetapan_ttd_type;
		}
		$jarak[0]['TEXT'] = "";
		$jarak[0]['COLSPAN'] = 2;
		$jarak[0]['BRD_TYPE'] = 'LRT';
		$jarak[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($jarak);
		
		list($y,$m,$d) = explode("-",$data[0][netapajrek_tgl]);
		$tglx = $d . '-' . $m . '-' . $y;
		
		$tnd[0]['TEXT'] = "";$tnd[1]['TEXT'] = strtoupper($pemda->dapemda_ibu_kota).", ".format_tgl(date('d-m-Y'),false,true);
		$tnd[0]['BRD_TYPE'] = 'L';$tnd[1]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($tnd);
		
		if($mengetahui->pejda_kode == '01') {
			$tnd[1]['TEXT'] = $mengetahui->ref_japeda_nama;
		}
		else {
			$tnd[1]['TEXT'] = "a.n. Kepala Dinas Pendapatan Daerah";
		}
		$pdf->tbDrawData($tnd);
		
		if($mengetahui->pejda_kode == '01') {
			$tnd[1]['TEXT'] = "";
		}
		else {
			$tnd[1]['TEXT'] = $mengetahui->ref_japeda_nama;
			$pdf->tbDrawData($tnd);
		}
		
		$tnd[1]['TEXT'] = "";
		$pdf->tbDrawData($tnd);
		$pdf->tbDrawData($tnd);
		$pdf->tbDrawData($tnd);
		
		$tnd[1]['TEXT'] = "<nu>  ".$mengetahui->pejda_nama."  </nu>";
		$pdf->tbDrawData($tnd);
		
		$tnd[1]['TEXT'] = strtoupper($mengetahui->ref_pangpej_ket);
		$pdf->tbDrawData($tnd);
		
		$tnd[1]['TEXT'] = "NIP. ".$mengetahui->pejda_nip;
		$pdf->tbDrawData($tnd);
		
		$jarak[0]['BRD_TYPE'] = 'LR';
		$pdf->tbDrawData($jarak);
		
		$jarak[0]['TEXT'] = "";
		$jarak[0]['LN_SIZE'] = 1;
		$jarak[0]['BRD_TYPE'] = 'T';
		$pdf->tbDrawData($jarak);
		
		$dt[0]['TEXT'] = "MODEL : DPD - 10F";
		$dt[0]['T_ALIGN'] = 'L';
		$dt[0]['COLSPAN'] = 7;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "<i>..................................................................Gunting disini..........................................................</i>";	
		$dt[0]['COLSPAN'] = 7;$dt[0]['T_ALIGN'] = 'C';
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";	
		$dt[0]['COLSPAN'] = 7;$dt[0]['T_ALIGN'] = 'C';
		$pdf->tbDrawData($dt);
		
		$pdf->tbOuputData();
		
		//Logo
		$logo = "assets/". $pemda->dapemda_logo_path;
		$pdf->Image($logo,16,13,13);
	
		//Bagian Gunting disini
		$kolom = 6;
		$pdf->tbInitialize($kolom, true, true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($b=0;$b<$kolom;$b++) $jkl[$b] = $table_default_headerx_type;
		
		for($b=0;$b<$kolom;$b++) {
			$idn[$b] = $table_default_headerx_type;
		}
		$idn[0]['WIDTH'] = 10;
		$idn[1]['WIDTH'] = 15;
		$idn[2]['WIDTH'] = 5;
		$idn[3]['WIDTH'] = 90;
		$idn[4]['WIDTH'] = 60;
		$idn[5]['WIDTH'] = 10;
		$pdf->tbSetHeaderType($idn);
		
		for($c=0;$c<$kolom;$c++) {
			$tnd[$c] = $table_data_ketetapan_ttd_type;
			$dt[$c] = $table_data_ketetapan_type;
			$dt2[$c] = $table_data_ketetapan_type;
		}
		
		$spc[0]['TEXT'] = "";
		$spc[0]['COLSPAN'] = 6;
		$spc[0]['BRD_TYPE'] = 'LRT';
		$spc[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($spc);
		
		$dt[0]['TEXT'] = "";$dt[0]['BRD_TYPE'] = 'L';
		$dt[1]['TEXT'] = "";$dt[1]['COLSPAN'] = 3;
		$dt[4]['TEXT'] = "No. $s_title :  ".format_angka($this->config->item('length_kohir_spt'), $data[0]['netapajrek_kohir']);
		$dt[5]['TEXT'] = "";$dt[5]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[0]['BRD_TYPE'] = 'L';
		$dt[1]['TEXT'] = "TANDA TERIMA";$dt[1]['T_ALIGN'] = 'C';$dt[1]['T_TYPE'] = "BU";$dt[1]['COLSPAN'] = 4;
		$dt[5]['TEXT'] = "";$dt[5]['BRD_TYPE'] = 'R';	
		$dt[0]['LN_SIZE'] = 7;$dt[1]['LN_SIZE'] = 7;$dt[5]['LN_SIZE'] = 7;
		$pdf->tbDrawData($dt);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "NPWPD";
		$dt2[2]['TEXT'] = ":";
		$dt2[3]['TEXT'] = $data[0]['npwprd'];
		$dt2[4]['TEXT'] = "";
		$dt2[5]['TEXT'] = "";$dt2[5]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($dt2);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "Nama";
		$dt2[2]['TEXT'] = ":";
		$dt2[3]['TEXT'] = $data[0]['wp_wr_nama'];
		$dt2[4]['TEXT'] = "";
		$dt2[5]['TEXT'] = "";$dt2[5]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($dt2);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "Alamat";
		$dt2[2]['TEXT'] = ":";
		$dt2[3]['TEXT'] = strtoupper(ereg_replace("\r|\n","",$data[0][wp_wr_almt]))." KEL. ".strtoupper($data[0][wp_wr_lurah]." KEC. ".$data[0][wp_wr_camat]);
		$dt2[4]['TEXT'] = "";
		$dt2[5]['TEXT'] = "";$dt2[5]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($dt2);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "";
		$dt2[3]['TEXT'] = "";
		$dt2[4]['TEXT'] = "..............................Tahun........";$dt2[4]['T_ALIGN']="C";
		$dt2[5]['TEXT'] = "";$dt2[5]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($dt2);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "";
		$dt2[3]['TEXT'] = "";
		$dt2[4]['TEXT'] = "Yang Menerima";$dt2[4]['T_ALIGN']="C";
		$dt2[5]['TEXT'] = "";$dt2[5]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($dt2);
		
		$tnd[0]['TEXT'] = "";$tnd[0]['COLSPAN'] = 6;$tnd[0]['BRD_TYPE'] = 'LR';
		$pdf->tbDrawData($tnd);
		$pdf->tbDrawData($tnd);
		$pdf->tbDrawData($tnd);
		
		$dt2[0]['TEXT'] = "";$dt2[0]['BRD_TYPE'] = 'L';
		$dt2[1]['TEXT'] = "";
		$dt2[2]['TEXT'] = "";
		$dt2[3]['TEXT'] = "";
		$dt2[4]['TEXT'] = "(......................................)";$dt2[4]['T_ALIGN']="C";
		$dt2[5]['TEXT'] = "";$dt2[5]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($dt2);
		
		
		$dt[0]['TEXT'] = "MODEL : DPD - 10F";
		$dt[0]['BRD_TYPE'] = 'T';	
		$dt[0]['T_ALIGN'] = 'L';
		$dt[0]['COLSPAN'] = 6;
		$pdf->tbDrawData($dt);
		
		$pdf->tbOuputData();
	}

	$pdf->Output();
}

?>