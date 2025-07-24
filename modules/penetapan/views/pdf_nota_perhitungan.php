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

$pdf = new FPDF_TABLE('L','mm','Letter'); // Landscape,Letter,Lebar = 260cm
$pdf->Open();
$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(10, 10);     // Margin Left, Top, Right 2 cm

$ar_npwpd = $nota_model->call_npwpd_tetap();
$jenis_ketetapan = $_GET['spt_jenis_ketetapan'];

if (!empty($ar_npwpd)) {
	foreach ($ar_npwpd as $k1 => $v1) {
		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		//prepare data
		$data_sptpd = $nota_model->call_v_nota_perhitungan($v1['spt_id']);
		
		$mspjk_tgl = explode("-",$data_sptpd[0]['spt_periode_jual1']);
		$mspjk_bln = getNamaBulan($mspjk_tgl[1]);
		$mspjk_thn = $mspjk_tgl[0];
		
		$arr_tgl = explode("-",$v1['netapajrek_tgl']);
		$conv_tgl = $arr_tgl[2]."-".$arr_tgl[1]."-".$arr_tgl[0];
		
		//set custom style
		$pdf->SetStyle("sb","arial","B",8,"0,0,0");
		$pdf->SetStyle("b","arial","B",9,"0,0,0");
		$pdf->SetStyle("h1","arial","B",12,"0,0,0");
		$pdf->SetStyle("th1","arial","B",11,"0,0,0");
		$pdf->SetStyle("h2","arial","",11,"0,0,0");
		$pdf->SetStyle("nu","arial","U",9,"0,0,0");
		$columns = 7; // bisa disesuaikan
		
		$pdf->tbInitialize($columns, true, true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($i=0;$i<$columns;$i++) $header_type[$i] = $table_default_headerx_type;
		
		for($i=0;$i<$columns;$i++) {
			$ws[$i] = $table_default_datax_type;
			$dt[$i] = $table_default_datax_type;
			$wh[$i] = $table_default_datax_type;
		}
		$ws[0]['WIDTH'] = 20;
		$ws[1]['WIDTH'] = 65;
		$ws[2]['WIDTH'] = 97;
		$ws[3]['WIDTH'] = 5;
		$ws[4]['WIDTH'] = 43;
		$ws[5]['WIDTH'] = 5;
		$ws[6]['WIDTH'] = 25;
	
		$ws[0]['TEXT'] = "";$ws[1]['TEXT'] = "";$ws[2]['TEXT'] = "";$ws[3]['TEXT'] = "";$ws[4]['TEXT'] = "";$ws[5]['TEXT'] = "";$ws[6]['TEXT'] = "";
		
		$ws[0]['LN_SIZE'] = 2;$ws[1]['LN_SIZE'] = 2;$ws[2]['LN_SIZE'] = 2;$ws[3]['LN_SIZE'] = 2;$ws[4]['LN_SIZE'] = 2;$ws[5]['LN_SIZE'] = 2;$ws[6]['LN_SIZE'] = 2;
		$ws[0]['T_SIZE'] = 4;$ws[1]['T_SIZE'] = 4;$ws[2]['T_SIZE'] = 4;$ws[3]['T_SIZE'] = 4;$ws[4]['T_SIZE'] = 4;$ws[5]['T_SIZE'] = 4;$ws[6]['T_SIZE'] = 4;
		
		$ws[0]['BRD_TYPE'] = 'LT';
		$ws[1]['BRD_TYPE'] = 'T';
		$ws[2]['BRD_TYPE'] = 'LT';
		$ws[3]['BRD_TYPE'] = 'LT';
		$ws[4]['BRD_TYPE'] = 'T';
		$ws[5]['BRD_TYPE'] = 'T';
		$ws[6]['BRD_TYPE'] = 'RT';
		
		//Kop
		$dt[0]['TEXT'] = "";
		
		$data_pemda = "<th1>PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2)."</th1>\n".
		        "<th1>B".strtoupper($pemda->nama_dinas)."</th1>\n".$pemda->dapemda_lokasi."\n".
				"Telp. ".$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax."\n<th1>B".strtoupper($pemda->dapemda_nm_dati2)."</th1>";
		
		$dt[1]['TEXT'] = $data_pemda;		
		$dt[2]['TEXT'] = "\n<h1>NOTA PERHITUNGAN PAJAK DAERAH</h1>";
		$dt[2]['TEXT'] .= "\n<h2>MASA PAJAK : ".strtoupper($mspjk_bln)."     TAHUN : ".$mspjk_thn;
		$dt[2]['TEXT'] .= "\n".$data_sptpd[0]['ketspt_singkat']."</h2>";
		
		$dt[3]['TEXT'] = "";
		
		$dt[4]['TEXT'] = "\nNo. Nota Perhitungan";
		$dt[4]['TEXT'] .= "\nNo. SPT yang dikirim";
		
		$dt[5]['TEXT'] = "\n:\n:";
		$dt[6]['TEXT'] = "\n".format_angka($this->config->item('length_kohir_spt'),$data_sptpd[0]['netapajrek_kohir']).
							"\n".format_angka($this->config->item('length_no_spt'),$data_sptpd[0]['spt_nomor']);
		
		$dt[0]['T_SIZE'] = 7;
		$dt[1]['T_SIZE'] = 7;
		$dt[4]['T_SIZE'] = 10;
		$dt[5]['T_SIZE'] = 10;
		$dt[6]['T_SIZE'] = 10;
		$dt[1]['LN_SIZE'] = 4;
		$dt[0]['BRD_TYPE'] = 'L';
		$dt[1]['BRD_TYPE'] = '';
		$dt[2]['BRD_TYPE'] = 'L';
		$dt[3]['BRD_TYPE'] = 'L';
		$dt[4]['BRD_TYPE'] = '';
		$dt[5]['BRD_TYPE'] = '';
		$dt[6]['BRD_TYPE'] = 'R';
		$dt[2]['T_ALIGN'] = 'C';
		
		$wh[0]['LN_SIZE'] = 2;$wh[1]['LN_SIZE'] = 2;$wh[2]['LN_SIZE'] = 2;$wh[3]['LN_SIZE'] = 2;$wh[4]['LN_SIZE'] = 2;$wh[5]['LN_SIZE'] = 2;$wh[6]['LN_SIZE'] = 2;
		$wh[0]['T_SIZE'] = 3;$wh[1]['T_SIZE'] = 3;$wh[2]['T_SIZE'] = 3;$wh[3]['T_SIZE'] = 3;$wh[4]['T_SIZE'] = 3;$wh[5]['T_SIZE'] = 3;$wh[6]['T_SIZE'] = 3;
		$wh[0]['BRD_TYPE'] = 'L';$wh[1]['BRD_TYPE'] = '';$wh[2]['BRD_TYPE'] = 'L';$wh[3]['BRD_TYPE'] = 'L';$wh[4]['BRD_TYPE'] = '';$wh[5]['BRD_TYPE'] = '';$wh[6]['BRD_TYPE'] = 'R';
		
		$arHeader = array($ws,$dt,$wh);
		
		$pdf->tbSetHeaderType($arHeader,true);		
		$pdf->tbDrawHeader();	
		
		//Bagian Nama, Alamat, NPWPD
		for($a=0;$a<$columns;$a++) {
			$sp[$a] = $table_default_datax_type;
			$dt1[$a] = $table_default_datax_type;
		}
		
		$sp[0]['TEXT'] = "";
		$sp[1]['TEXT'] = "";
		$sp[2]['TEXT'] = "";
		$sp[3]['TEXT'] = "";
		$sp[4]['TEXT'] = "";
		$sp[5]['TEXT'] = "";
		$sp[6]['TEXT'] = "";
		$sp[0]['BRD_TYPE'] = 'L';
		$sp[1]['BRD_TYPE'] = '';
		$sp[2]['BRD_TYPE'] = 'L';
		$sp[3]['BRD_TYPE'] = 'L';
		$sp[4]['BRD_TYPE'] = '';
		$sp[5]['BRD_TYPE'] = '';
		$sp[6]['BRD_TYPE'] = 'R';
		$sp[0]['LN_SIZE'] = 2;
		$sp[1]['LN_SIZE'] = 2;
		$sp[2]['LN_SIZE'] = 2;
		$sp[3]['LN_SIZE'] = 2;
		$sp[4]['LN_SIZE'] = 2;
		$sp[5]['LN_SIZE'] = 2;
		$sp[6]['LN_SIZE'] = 2;
		$pdf->tbDrawData($sp);
		
		$sp[0]['TEXT'] = "";
		$sp[1]['TEXT'] = "";
		$sp[2]['TEXT'] = "";
		$sp[3]['TEXT'] = "";
		$sp[4]['TEXT'] = "";
		$sp[5]['TEXT'] = "";
		$sp[6]['TEXT'] = "";
		
		$sp[0]['BRD_TYPE'] = 'LT';
		$sp[1]['BRD_TYPE'] = 'T';
		$sp[2]['BRD_TYPE'] = 'T';
		$sp[3]['BRD_TYPE'] = 'T';
		$sp[4]['BRD_TYPE'] = 'T';
		$sp[5]['BRD_TYPE'] = 'T';
		$sp[6]['BRD_TYPE'] = 'RT';
		$sp[0]['LN_SIZE'] = 2;
		$sp[1]['LN_SIZE'] = 2;
		$sp[2]['LN_SIZE'] = 2;
		$sp[3]['LN_SIZE'] = 2;
		$sp[4]['LN_SIZE'] = 2;
		$sp[5]['LN_SIZE'] = 2;
		$sp[6]['LN_SIZE'] = 2;		
		$pdf->tbDrawData($sp);
		
		$sp[0]['BRD_TYPE'] = 'L';
		$sp[1]['BRD_TYPE'] = '';
		$sp[2]['BRD_TYPE'] = '';
		$sp[3]['BRD_TYPE'] = '';
		$sp[4]['BRD_TYPE'] = '';
		$sp[5]['BRD_TYPE'] = '';
		$sp[6]['BRD_TYPE'] = 'R';
				
		$pdf->tbDrawData($sp);
		$pdf->tbDrawData($sp);
		
		$wp_wr_lurah = ($data_sptpd[0]['wp_wr_lurah'] == "") ? "" : "KEL. ".$data_sptpd[0]['wp_wr_lurah'];
		$wp_wr_camat = ($data_sptpd[0]['wp_wr_camat'] == "") ? "" : "KEC. ".$data_sptpd[0]['wp_wr_camat'];
		
		$dt1[0]['TEXT'] = "NAMA : " . $data_sptpd[0]['wp_wr_nama'];
		// $dt1[2]['TEXT'] = "ALAMAT : " . ereg_replace("\r|\n"," ",$data_sptpd[0]['wp_wr_almt'])."\n ".$wp_wr_lurah." ".$wp_wr_camat;
		$dt1[2]['TEXT'] = "ALAMAT : " . $data_sptpd[0]['wp_wr_almt'] . "\n" .$wp_wr_lurah." ".$wp_wr_camat;
		$dt1[3]['TEXT'] = "NPWPD : " . $data_sptpd[0]['npwprd'];
		
		$dt1[0]['COLSPAN'] = 2;
		$dt1[3]['COLSPAN'] = 4;
		$dt1[0]['BRD_TYPE'] = 'L';
		$dt1[2]['BRD_TYPE'] = '';
		$dt1[3]['BRD_TYPE'] = 'R';
		$dt1[0]['T_SIZE'] = 11;
		$dt1[2]['T_SIZE'] = 11;
		$dt1[3]['T_SIZE'] = 11;
		
		$pdf->tbDrawData($dt1);
		
		$pdf->tbDrawData($sp);
		$pdf->tbDrawData($sp);
		
		$pdf->tbOuputData();
		
		//Data nota perhitungan
		$kol = 12;
		$pdf->tbInitialize($kol, true, true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($b=0;$b<$kol;$b++) $tblhead[$b] = $table_default_datax_type;
		
		for($b=0;$b<$kol;$b++) {
			$sps[$b] = $table_default_datax_type;
		}
		
		$sps[0]['WIDTH'] = 10;
		$sps[1]['WIDTH'] = 30;
		$sps[2]['WIDTH'] = 25;
		$sps[3]['WIDTH'] = 30;
		$sps[4]['WIDTH'] = 20;
		$sps[5]['WIDTH'] = 15;
		$sps[6]['WIDTH'] = 30;
		$sps[7]['WIDTH'] = 25;
		$sps[8]['WIDTH'] = 17;
		$sps[9]['WIDTH'] = 15;
		$sps[10]['WIDTH'] = 15;
		$sps[11]['WIDTH'] = 28;
		
		$pdf->tbSetHeaderType($sps);
		
		for($b=0;$b<$kol;$b++) {
			$th[$b] = $table_default_tblheader_type;
			$tn[$b] = $table_default_tblheader_type;
			$td[$b] = $table_default_tbldata_type;
			$tk[$b] = $table_default_tbldata_type;
			$tf[$b] = $table_default_tblheader_type;
		}
		
		$text_jumlah = ($spt_jenis_pajakretribusi==8 or $spt_jenis_pajakretribusi2==8)?"N P A (Rp.)":"OMSET (Rp.)";
		$th[0]['TEXT'] = "NO.";
		$th[1]['TEXT'] = "JENIS PAJAK";
		$th[2]['TEXT'] = "KODE REKENING";
		$th[3]['TEXT'] = "DASAR PENGENAAN";
		$th[5]['TEXT'] = "TARIF";
		$th[6]['TEXT'] = $text_jumlah;
		$th[7]['TEXT'] = "KETETAPAN PAJAK";
		$th[8]['TEXT'] = "SANKSI ADMINISTRASI";
		$th[11]['TEXT'] = "J U M L A H";
		
		$th[3]['COLSPAN'] = 2;
		$th[8]['COLSPAN'] = 3;
		
		$th[0]['ROWSPAN'] = 2;
		$th[1]['ROWSPAN'] = 2;
		$th[2]['ROWSPAN'] = 2;
		$th[5]['ROWSPAN'] = 2;
		$th[6]['ROWSPAN'] = 2;
		$th[7]['ROWSPAN'] = 2;
		$th[11]['ROWSPAN'] = 2;
		
		$th[0]['BRD_TYPE'] = 'LT';
		$th[1]['BRD_TYPE'] = 'LT';
		$th[2]['BRD_TYPE'] = 'LT';
		$th[3]['BRD_TYPE'] = 'LT';
		$th[4]['BRD_TYPE'] = 'LT';
		$th[5]['BRD_TYPE'] = 'LT';
		$th[6]['BRD_TYPE'] = 'LT';
		$th[7]['BRD_TYPE'] = 'LT';
		$th[8]['BRD_TYPE'] = 'LT';
		$th[9]['BRD_TYPE'] = 'LT';
		$th[10]['BRD_TYPE'] = 'LT';
		$th[11]['BRD_TYPE'] = 'LRT';
		
		$pdf->tbDrawData($th);
		
		$th[3]['TEXT'] = "U R A I A N";
		if($spt_jenis_pajakretribusi==8) {
			$th[4]['TEXT'] = "Volume (M3)";
			$th[3]['COLSPAN'] = 1;
		}	else {
			$th[3]['COLSPAN'] = 2;
			$th[3]['BRD_TYPE'] = 'LRT';
		}
		$th[8]['TEXT'] = "Kenaikan";
		$th[9]['TEXT'] = "Denda";
		$th[10]['TEXT'] = "Bunga";
		
		
		$th[8]['COLSPAN'] = 1;
		
		$th[4]['BRD_TYPE'] = 'LRT';
		$th[10]['BRD_TYPE'] = 'LRT';
		
		$pdf->tbDrawData($th);
		
		if($spt_jenis_pajakretribusi==8 OR $spt_jenis_pajakretribusi2==8) {
				$tn[0]['TEXT'] = "1";
				$tn[1]['TEXT'] = "2";
				$tn[2]['TEXT'] = "3";
				$tn[3]['TEXT'] = "4";
				$tn[4]['TEXT'] = "5";
				$tn[5]['TEXT'] = "6";
				$tn[6]['TEXT'] = "7";
				$tn[7]['TEXT'] = "8 (6x7)";
				$tn[8]['TEXT'] = "9";
				$tn[9]['TEXT'] = "10";
				$tn[10]['TEXT'] = "11";
				$tn[11]['TEXT'] = "12 (8+9+10+11)";
		} else {
				$tn[0]['TEXT'] = "1";
				$tn[1]['TEXT'] = "2";
				$tn[2]['TEXT'] = "3";
				$tn[3]['TEXT'] = "4";
				$tn[5]['TEXT'] = "5";
				$tn[6]['TEXT'] = "6";
				$tn[7]['TEXT'] = "7 (5x6)";
				$tn[8]['TEXT'] = "8";
				$tn[9]['TEXT'] = "9";
				$tn[10]['TEXT'] = "10";
				$tn[11]['TEXT'] = "11 (7+8+9+10)";
			$tn[3]['COLSPAN']=2;
		}
		
		$tn[0]['BRD_TYPE'] = 'LT';
		$tn[1]['BRD_TYPE'] = 'LT';
		$tn[2]['BRD_TYPE'] = 'LT';
		$tn[3]['BRD_TYPE'] = 'LT';
		$tn[4]['BRD_TYPE'] = 'LT';
		$tn[5]['BRD_TYPE'] = 'LT';
		$tn[6]['BRD_TYPE'] = 'LT';
		$tn[7]['BRD_TYPE'] = 'LT';
		$tn[8]['BRD_TYPE'] = 'LT';
		$tn[9]['BRD_TYPE'] = 'LT';
		$tn[10]['BRD_TYPE'] = 'LT';
		$tn[11]['BRD_TYPE'] = 'LRT';
		
		$pdf->tbDrawData($tn);
		
		$td[0]['BRD_TYPE'] = 'LT';$td[1]['BRD_TYPE'] = 'LT';$td[2]['BRD_TYPE'] = 'LT';$td[3]['BRD_TYPE'] = 'LT';$td[4]['BRD_TYPE'] = 'LT';$td[5]['BRD_TYPE'] = 'LT';$td[6]['BRD_TYPE'] = 'LT';$td[7]['BRD_TYPE'] = 'LT';$td[8]['BRD_TYPE'] = 'LT';$td[9]['BRD_TYPE'] = 'LT';$td[10]['BRD_TYPE'] = 'LT';$td[11]['BRD_TYPE'] = 'LRT';
		
		$td[0]['T_ALIGN'] = 'C';
		$td[2]['T_ALIGN'] = 'C';
		$td[4]['T_ALIGN'] = 'R';
		$td[5]['T_ALIGN'] = 'C';
		$td[6]['T_ALIGN'] = 'R';
		$td[7]['T_ALIGN'] = 'R';
		$td[8]['T_ALIGN'] = 'R';
		$td[9]['T_ALIGN'] = 'R';
		$td[10]['T_ALIGN'] = 'R';
		$td[11]['T_ALIGN'] = 'R';
		
		$total_ketetapan = 0;
		$total_kenaikan = 0;
		$total_denda = 0;
		$total_bunga = 0;
		$total_pajak = 0;
		
		$counter = 1;
		//prepare data jumlah pajak
		$jumlah = 0;
		$kenaikan = 0; $denda = 0; $bunga = 0;
		
		foreach ($data_sptpd as $key => $value) {
			$total_kenaikan += $value['kenaikan'];
			$total_denda += $value['denda'];
			$total_bunga += $value['bunga'];
			$jumlah = $value['spt_dt_pajak'] + $value['kenaikan'] + $value['denda'] + $value['bunga'];
			
			if ($spt_jenis_pajakretribusi == 8) {				
				$td[0]['TEXT'] = $counter;
				$td[1]['TEXT'] = $value['jenis_pajak']."\n\n";
				$td[2]['TEXT'] = $value['rekening'];
				$td[3]['TEXT'] = $value['korek_nama'];
				$td[4]['TEXT'] = format_currency_no_comma($value['spt_dt_jumlah']);
				$td[5]['TEXT'] = $value['tarif'].' %';
				$td[6]['TEXT'] = format_currency_no_comma($value['spt_dt_tarif_dasar']);
				$td[7]['TEXT'] = format_currency_no_comma($value['spt_pajak']);
				$td[8]['TEXT'] = format_currency_no_comma($value['kenaikan']);
				$td[9]['TEXT'] = format_currency_no_comma($value['denda']);
				$td[10]['TEXT'] = format_currency_no_comma($value['bunga']);
				$td[11]['TEXT'] = format_currency_no_comma($jumlah);
				$pdf->tbDrawData($td);
			} else {
				$td[0]['TEXT'] = $counter;
				$td[1]['TEXT'] = $value['jenis_pajak'];
				$td[2]['TEXT'] = $value['rekening'];
				$td[3]['TEXT'] = $value['korek_nama'];
				$td[3]['COLSPAN'] = 2;
				$td[5]['TEXT'] = $value['tarif'].' %';
				$td[6]['TEXT'] = format_currency_no_comma($value['spt_dt_jumlah']);
				$td[7]['TEXT'] = format_currency_no_comma($value['spt_dt_pajak']);
				$td[8]['TEXT'] = format_currency_no_comma($value['kenaikan']);
				$td[9]['TEXT'] = format_currency_no_comma($value['denda']);
				$td[10]['TEXT'] = format_currency_no_comma($value['bunga']);
				$td[11]['TEXT'] = format_currency_no_comma($jumlah);
					
				$pdf->tbDrawData($td);
			}
			
			$counter++;
		}
		
		$total_ketetapan = $data_sptpd[0]['spt_pajak'];
		$total_pajak = $total_ketetapan + $total_kenaikan + $total_denda + $total_bunga;		
		
		$tk[0]['COLSPAN'] = 7;
	
		$tk[0]['TEXT'] = "J U M L A H ";
		$tk[7]['TEXT'] = format_currency_no_comma ($total_ketetapan);
		$tk[8]['TEXT'] = format_currency_no_comma($total_kenaikan);
		$tk[9]['TEXT'] = format_currency_no_comma($total_denda);
		$tk[10]['TEXT'] = format_currency_no_comma($total_bunga);
		$tk[11]['TEXT'] = format_currency_no_comma ($total_pajak);
		
		$tk[0]['T_ALIGN'] = 'R';
		$tk[7]['T_ALIGN'] = 'R';
		$tk[8]['T_ALIGN'] = 'R';
		$tk[9]['T_ALIGN'] = 'R';
		$tk[10]['T_ALIGN'] = 'R';
		$tk[11]['T_ALIGN'] = 'R';
	
		$tk[0]['BRD_TYPE'] = 'LT';$tk[6]['BRD_TYPE'] = 'LT';$tk[7]['BRD_TYPE'] = 'LT';$tk[8]['BRD_TYPE'] = 'LT';$tk[9]['BRD_TYPE'] = 'LT';$tk[10]['BRD_TYPE'] = 'LT';$tk[11]['BRD_TYPE'] = 'LRT';	
		
		$pdf->tbDrawData($tk);
		
		$tk[0]['TEXT'] = "";$tk[7]['TEXT'] = "";$tk[8]['TEXT'] = "";$tk[9]['TEXT'] = "";$tk[10]['TEXT'] = "";$tk[11]['TEXT'] = "";
		$tk[0]['LN_SIZE'] = 1;$tk[7]['LN_SIZE'] = 1;$tk[8]['LN_SIZE'] = 1;$tk[9]['LN_SIZE'] = 1;$tk[10]['LN_SIZE'] = 1;$tk[11]['LN_SIZE'] = 1;
		
		$pdf->tbDrawData($tk);
		
		$tf[0]['TEXT'] = "";
		$tf[0]['COLSPAN'] = 12;
		$tf[0]['BRD_TYPE'] = 'T';
		
		$pdf->tbDrawData($tf); 
		
		$tf[0]['TEXT'] = "Jumlah dengan huruf : ( ".ucwords(strtolower(terbilang($total_pajak)))." Rupiah )";
		
		$tf[0]['BRD_TYPE'] = '';
		$tf[0]['T_SIZE'] = 11;
		$pdf->tbDrawData($tf);
		
		$tf[0]['TEXT'] = "";
		$tf[0]['COLSPAN'] = 11;
		$tf[0]['BRD_TYPE'] = '';
		
		$pdf->tbDrawData($tf);//$pdf->tbDrawData($tf);
		
		$pdf->tbOuputData();
		
		//Bagian Tanda Tangan
		$klm = 5;
		$pdf->tbInitialize($klm, true, true);
		$pdf->tbSetTableType($table_defautl_tbl_type);
		
		//for($c=0;$c<$klm;$c++) $hdrxn[$c] = $table_default_headerx_type;
		
		for($c=0;$c<$klm;$c++) $hty[$c] = $table_default_headerx_type;
		
		$hty[0]['WIDTH'] = 80;
		$hty[1]['WIDTH'] = 90;
		$hty[2]['WIDTH'] = 35;
		$hty[3]['WIDTH'] = 15;
		$hty[4]['WIDTH'] = 55;
		
		$pdf->tbSetHeaderType($hty);
		
		//$pdf->tbDrawHeader();
		
		for($c=0;$c<$klm;$c++) {
			$ts[$c] = $table_default_ttd_type;
			$tr[$c] = $table_default_datax_type;
			$ttd1[$c] = $table_default_ttd_type;
			$ttd2[$c] = $table_default_ttd_type;
		}
		
		$ts[0]['TEXT'] = "Mengetahui,";
		$ts[1]['TEXT'] = "Diperiksa Oleh,";
		$ts[2]['TEXT'] = "";
		$ts[3]['TEXT'] = "";
		$ts[4]['TEXT'] = "";
		
		$ts[2]['T_ALIGN'] = 'L';$ts[4]['T_ALIGN'] = 'L';
		
		$pdf->tbDrawData($ts);
		
		if ($this->session->userdata('USER_SPT_CODE') == "10") {
			$ts[0]['TEXT'] = ($mengetahui->pejda_kode != '01') ? "a.n. ".$this->config->item('nama_jabatan_kepala_dinas')."\n".$mengetahui->ref_japeda_nama : $mengetahui->ref_japeda_nama;
			$ts[1]['TEXT'] = $pemeriksa->ref_japeda_nama;
			$ts[2]['TEXT'] = "Dibuat Tanggal";
			$ts[3]['TEXT'] = ":";
			$ts[4]['TEXT'] = format_tgl($conv_tgl,false,true);
		} else {
			$ts[0]['TEXT'] = $mengetahui->ref_japeda_nama;
			$ts[1]['TEXT'] = $pemeriksa->ref_japeda_nama;
			$ts[2]['TEXT'] = "Dibuat Tanggal";
			$ts[3]['TEXT'] = ":";
			$ts[4]['TEXT'] = format_tgl($conv_tgl,false,true);
		}		
		$pdf->tbDrawData($ts);
		
		$ts[0]['TEXT'] = "";
		$ts[1]['TEXT'] = "";
		$ts[2]['TEXT'] = "Oleh";
		$ts[3]['TEXT'] = ":";
		$ts[4]['TEXT'] = $this->session->userdata('USER_FULL_NAME');		
		$pdf->tbDrawData($ts);
		
		$ts[0]['TEXT'] = "";
		$ts[1]['TEXT'] = "";
		$ts[2]['TEXT'] = "Jabatan";
		$ts[3]['TEXT'] = ":";
		$ts[4]['TEXT'] = $this->session->userdata('USER_JABATAN_NAME');
		
		$pdf->tbDrawData($ts);
		
		if ($this->session->userdata('USER_SPT_CODE') == "10") {
			$ts[2]['TEXT'] = "N I P";
			$ts[4]['TEXT'] = $this->session->userdata('USER_NIP');		
			$pdf->tbDrawData($ts);
		}
		
		$ts[2]['TEXT'] = "Tanda Tangan";
		$ts[4]['TEXT'] = "";
		
		$pdf->tbDrawData($ts);
		
		$ts[0]['TEXT'] = "<nu>  ".$mengetahui->pejda_nama."  </nu>";$ts[0]['T_ALIGN']='C';
		$ts[1]['TEXT'] = "<nu>  ".$pemeriksa->pejda_nama."  </nu>";$ts[2]['T_ALIGN']='C';
		$ts[2]['TEXT'] = "";
		$ts[3]['TEXT'] = "";
		$ts[4]['TEXT'] = "";
		
		$pdf->tbDrawData($ts);
		
		$ts[0]['TEXT'] = $mengetahui->ref_pangpej_ket.', '.$mengetahui->ref_goru_ket;
		$ts[1]['TEXT'] = $pemeriksa->ref_pangpej_ket.', '.$pemeriksa->ref_goru_ket;
		
		$pdf->tbDrawData($ts);
		
		$ts[0]['TEXT'] = "NIP. ".$mengetahui->pejda_nip;
		$ts[1]['TEXT'] = "NIP. ".$pemeriksa->pejda_nip;
		
		$pdf->tbDrawData($ts);
	
		$pdf->tbOuputData();
		
		$logo = "assets/". $pemda->dapemda_logo_path;
		//$pdf->Image($logo,12,12,18,20);
		$pdf->Image("assets/images/logo-kotabekasi.JPG",12,12,18,20);
	}
	
	$pdf->Output();
}

?>