<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH',$this->config->item('fonts_path'));

require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';
require_once APPPATH.'libraries/fpdf/table/table_def.inc';
require_once APPPATH.'libraries/fpdf/table/header_footer.inc';

$pdf = new FPDF_TABLE('P','mm','Letter'); // Portrait dengan ukuran kertas Letter and width 190 px
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10); // Page Break dengan margin bawah 1 cm
$pdf->SetMargins(15, 10, 10);     // Margin Left, Top, Right 2 cm

if (!empty($arr_data)) {
	
	$pdf->AddPage();
	$pdf->AliasNbPages();
	
	$pdf->SetStyle("sb","arial","B",7,"0,0,0");
	$pdf->SetStyle("b","arial","B",8,"0,0,0");
	$pdf->SetStyle("h1","arial","B",12,"0,0,0");
	$pdf->SetStyle("h2","arial","",12,"0,0,0");
	$pdf->SetStyle("nu","arial","U",8,"0,0,0");
	$pdf->SetStyle("th1","arial","B",8,"0,0,0");
	
	$columns = 3; // bisa disesuaikan
	$pdf->tbInitialize($columns, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	$pmda = "<th1>PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2)."</th1>\n".
	        "<th1>".strtoupper($pemda->nama_dinas)."</th1>\n".$pemda->dapemda_lokasi."\n".
			"Telp. ".$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax."\n<th1>".strtoupper($pemda->dapemda_nm_dati2)."</th1>";
	
	for($i=0; $i<$columns; $i++) 
		$header_type[$i] = $table_default_headerx_type;
	
	
	for($i=0; $i<$columns; $i++) {
		$spacer1[$i] = $table_default_datax_type;
		$header_type1[$i] = $table_default_headerx_type;
		$header_type2[$i] = $table_default_headerx_type;
		$spacer2[$i] = $table_default_datax_type;
	}
	
	$spacer1[0]['WIDTH'] = 16;
	$spacer1[1]['WIDTH'] = 79;
	$spacer1[2]['WIDTH'] = 95;
	
	$spacer1[0]['TEXT'] = "";
	$spacer1[2]['TEXT'] = "";
	$spacer1[0]['COLSPAN'] = 2;
	$spacer1[0]['T_SIZE'] = 2;
	$spacer1[0]['LN_SIZE'] = 2;
	$spacer1[1]['T_SIZE'] = 2;
	$spacer1[1]['LN_SIZE'] = 6;
	$spacer1[1]['T_ALIGN'] = "C";
	$spacer1[2]['T_SIZE'] = 2;
	$spacer1[2]['LN_SIZE'] = 4;
	
	//Baris ke-1
	$header_type1[0]['TEXT'] = "";
	$header_type1[0]['ROWSPAN'] = 4;
	$header_type1[1]['TEXT'] = $pmda;
	$header_type1[1]['T_ALIGN'] = 'L';
	$header_type1[1]['T_SIZE'] = 7;
	$header_type1[1]['LN_SIZE'] = 3;
	$header_type1[2]['TEXT'] = "<h2>Serie : </h2><h1> A</h1>";
	$header_type1[2]['COLSPAN'] = 2;
	$header_type1[2]['T_SIZE'] = 8;
	
	$spacer2[0]['TEXT'] = "";
	$spacer2[2]['TEXT'] = "";
	$spacer2[0]['COLSPAN'] = 1;
	$spacer2[0]['T_SIZE'] = 1;
	$spacer2[0]['LN_SIZE'] = 1;
	$spacer2[2]['T_SIZE'] = 1;
	$spacer2[0]['LN_SIZE'] = 1;$spacer2[1]['LN_SIZE'] = 1;$spacer2[2]['LN_SIZE'] = 1;
	
	$aHeaderArray = array(
		$spacer1,
		$header_type1,
		$header_type2,
		$spacer2
	);
	
	//set the Table Header
	$pdf->tbSetHeaderType($aHeaderArray, true);
	
	//Draw the Header
	$pdf->tbDrawHeader();
	$pdf->tbOuputData();
	// End of Header
	
	
	//Bagian Data
	$kolom = 5;
	$pdf->tbInitialize($kolom, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($a=0; $a<$kolom; $a++) $setcol[$a] = $table_default_datax_type;
	
	$setcol[0]['WIDTH'] = 3;
	$setcol[1]['WIDTH'] = 60;
	$setcol[2]['WIDTH'] = 58;
	$setcol[3]['WIDTH'] = 68;
	$setcol[4]['WIDTH'] = 1;
	
	$pdf->tbSetHeaderType($setcol);
	
	for($b=0; $b<$kolom; $b++) {
		$header[$b] = $table_default_datax_type;
		$pdtop[$b] = $table_data_sts;
		$dt1[$b] = $table_data_sts;
		$dt2[$b] = $table_data_sts;
		$pdbot[$b] = $table_data_sts;
	}
	
	$header[0]['TEXT'] = "";
	$header[1]['TEXT'] = "SURAT TANDA SETORAN";
	$header[1]['COLSPAN'] = 3;$header[1]['T_ALIGN'] = 'C';$header[1]['T_TYPE'] = 'B';
	$pdf->tbDrawData($header);
	
	$dt2[0]['TEXT'] = "";
	$dt2[0]['COLSPAN'] = 5; $dt2[0]['BRD_TYPE'] = 'T';$dt2[0]['LN_SIZE'] = 2;
	$pdf->tbDrawData($dt2);
	
	$dt1[0]['TEXT'] = "";
	$dt1[1]['TEXT'] = "Setoran seperti ini yang ke ".$arr_data[0]['skbh_no_surat'];
	$dt1[2]['TEXT'] = "Surat Tanda Setoran";
	$dt1[3]['TEXT'] = "Setoran ini yang terakhir telah dilakukan pada";
	$dt1[1]['COLSPAN'] = 1;$dt1[1]['T_ALIGN'] = 'L';$dt1[1]['T_TYPE'] = '';
	$dt1[2]['T_ALIGN'] = 'L';$dt1[3]['T_SIZE']=9;
	$pdf->tbDrawData($dt1);
	
	$tgl_setoran = $arr_data[0]['skbh_tgl'];
	$arr_tgl_setoran = explode('-', $tgl_setoran);
	
	$dt1[0]['TEXT'] = "";
	$dt1[1]['TEXT'] = "dalam bulan ".getNamaBulan($arr_tgl_setoran[1]);
	$dt1[2]['TEXT'] = "Nomor : ".$arr_data[0]['skbh_no'];$dt1[2]['ROWSPAN'] = 2;$dt1[2]['V_ALIGN'] = 'T';
	$dt1[3]['TEXT'] = "Tanggal : ............................";
	$pdf->tbDrawData($dt1);
	
	$dt1[0]['TEXT'] = "";
	$dt1[1]['TEXT'] = "Tahun ".$arr_tgl_setoran[0];
	$dt1[3]['TEXT'] = "Nomor : ............................";
	$pdf->tbDrawData($dt1);
	
	$pdtop[0]['TEXT'] = "";
	$pdtop[0]['COLSPAN'] = 5;
	$pdtop[0]['LN_SIZE'] = 2;
	$pdf->tbDrawData($pdtop);
	
	$pdf->tbDrawData($dt2);
	
	$pdf->tbOuputData();
	
	
	//bagian data
	$kolom = 5;
	$pdf->tbInitialize($kolom, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($a=0; $a<$kolom; $a++) $setcol[$a] = $table_default_datax_type;
	
	$setcol[0]['WIDTH'] = 63;
	$setcol[1]['WIDTH'] = 58;
	$setcol[2]['WIDTH'] = 68;
	$setcol[3]['WIDTH'] = 1;
	
	$pdf->tbSetHeaderType($setcol);
	
	for($b=0; $b<$kolom; $b++) {
		$dt1[$b] = $table_data_sts;
		$dt2[$b] = $table_data_sts;
		$dt3[$b] = $table_data_sts;
	}
	
	$dt3[0]['TEXT'] = "";
	$dt3[0]['TEXT'] = "Harap menerima uang sebesar : Rp. ".format_currency($arr_data[0]['skbh_jumlah']);
	$dt3[0]['COLSPAN'] = 3;
	$dt3[3]['TEXT'] = "";
	$pdf->tbDrawData($dt3);
	
	$pdf->tbDrawData($pdtop);
	$pdf->tbDrawData($pdtop);
	$pdf->tbDrawData($pdtop);
	
	$dt1[0]['TEXT'] = "(dengan huruf)     ". ucwords(strtolower(terbilang($arr_data[0]['skbh_jumlah']))). " Rupiah";
	$dt1[0]['COLSPAN']=3;
	$dt1[4]['TEXT'] = "";
	$pdf->tbDrawData($dt1);
	
	$dt1[0]['TEXT'] = "Dari       : ".$arr_data[0]['skbh_nama'];
	$dt1[0]['COLSPAN']=3;
	$dt1[4]['TEXT'] = "";
	$pdf->tbDrawData($dt1);
	
	//$wp_wr_lurah = (empty($arr_data[0]['wp_wr_lurah']) ? "" : "KEL. ".$arr_data[0]['wp_wr_lurah']);
	//$wp_wr_camat = (empty($arr_data[0]['wp_wr_camat']) ? "" : "KEC. ".$arr_data[0]['wp_wr_camat']);
	$dt1[0]['TEXT'] = "Alamat   : ".$arr_data[0]['skbh_alamat'];
	$dt1[0]['COLSPAN']=3;
	$dt1[4]['TEXT'] = "";
	$pdf->tbDrawData($dt1);

	$dt1[0]['TEXT'] = "Sebagai penyetoran pajak/retribusi : ".$arr_data[0]['ref_jenparet_ket'];
	$dt1[0]['COLSPAN']=3;
	$dt1[4]['TEXT'] = "";
	$pdf->tbDrawData($dt1);
	
	$pdf->tbOuputData();
	
	//Detail Rincian
	$kol = 6;
	$pdf->tbInitialize($kol, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($d=0; $d<$kol; $d++) $lbr[$d] = $table_default_datax_type;
	
	$lbr[0]['WIDTH'] = 1;
	$lbr[1]['WIDTH'] = 10;
	$lbr[2]['WIDTH'] = 38;
	$lbr[3]['WIDTH'] = 70;
	$lbr[4]['WIDTH'] = 70;
	$lbr[5]['WIDTH'] = 1;
	
	$pdf->tbSetHeaderType($lbr);
	
	for($e=0; $e<$kol; $e++) {
		$data1[$e] = $table_default_tblheader_type;
		$data2[$e] = $table_data_sts;
		$data3[$e] = $table_data_sts;
		$data4[$e] = $table_data_sts;
	}
	
	//Table Header
	$data1[0]['TEXT'] = "";
	$data1[1]['TEXT'] = "No.";
	$data1[2]['TEXT'] = "Kode Rekening";
	$data1[3]['TEXT'] = "U r a i a n";
	$data1[4]['TEXT'] = "J u m l a h \n(Rp.)";
	$data1[5]['TEXT'] = "";
	
	$data1[1]['BRD_TYPE'] = 'LT';
	$data1[2]['BRD_TYPE'] = 'LT';
	$data1[3]['BRD_TYPE'] = 'LT';
	$data1[4]['BRD_TYPE'] = 'LT';
	$data1[5]['BRD_TYPE'] = 'L';
	$pdf->tbDrawData($data1);
	
	$counter = 1;
	$jumlah = 0;
	
	$newline = "\n";
	switch (count($arr_data)) {
		case 1:
			$newline = "\n\n\n\n\n\n";
			break;
		case 2:
			$newline = "\n\n\n\n";
			break;
		case 3:
			$newline = "\n\n\n";
			break;
		case 4:
			$newline = "\n\n";
			break;
		default:
			break;
	};
	
	foreach ($arr_data as $key => $val) {
		$masa_pajak = $val['setorpajret_periode_jual1'];
		$arr_masa_pajak = explode("-", $masa_pajak);
				
		$data2[0]['TEXT'] = "";
		$data2[1]['TEXT'] = $counter;
		$data2[2]['TEXT'] = $val['koderek'];
		
		if ($val['korek_jenis'] != "4") {
			$data2[3]['TEXT'] = $val['wp_wr_nama']."   -   ".getNamaBulan($arr_masa_pajak[1])." ".$arr_masa_pajak[0].$newline;
		} else {
			$data2[3]['TEXT'] = $val['korek_nama'].$newline;
		}
	
		if ($val['koderek']=='4.1.1.08.01' || $val['koderek']=='4.1.1.04.01' ){

		$data2[4]['TEXT'] = format_currency($val['skbh_jumlah']);
		}else {
			$data2[4]['TEXT'] = format_currency($val['setorpajret_dt_jumlah']);

		}
		$data2[5]['TEXT'] = "";
		$data2[1]['T_ALIGN'] = 'C';
		$data2[2]['T_ALIGN'] = 'C';
		$data2[4]['T_ALIGN'] = 'R';
		
		$data2[1]['BRD_TYPE'] = 'LT';
		$data2[2]['BRD_TYPE'] = 'LT';
		$data2[3]['BRD_TYPE'] = 'LT';
		$data2[4]['BRD_TYPE'] = 'LT';
		$data2[5]['BRD_TYPE'] = 'L';
		$pdf->tbDrawData($data2);	
		
		$jumlah += $val['setorpajret_dt_jumlah'];

		$jumlah_air_reklame= $val['skbh_jumlah'];
		$counter ++;
	}
	
	$data3[0]['TEXT'] = "";
	$data3[1]['TEXT'] = "";
	$data3[3]['TEXT'] = "Jumlah : ";
	if ($val['koderek']=='4.1.1.08.01' || $val['koderek']=='4.1.1.04.01' ){
	$data3[4]['TEXT'] = format_currency($jumlah_air_reklame);
	}else {
		$data3[4]['TEXT'] = format_currency($jumlah);

	}

	$data3[5]['TEXT'] = "";	
	$data3[4]['T_ALIGN'] = 'R';
	$data3[0]['BRD_TYPE'] = '';$data3[0]['LN_SIZE'] = 6.5;
	$data3[1]['BRD_TYPE'] = 'L';$data3[1]['LN_SIZE'] = 6.5;
	$data3[2]['BRD_TYPE'] = 'L';$data3[2]['LN_SIZE'] = 6.5;
	$data3[3]['BRD_TYPE'] = 'L';$data3[3]['T_ALIGN'] = 'C';$data3[3]['LN_SIZE'] = 6.5;
	$data3[4]['BRD_TYPE'] = 'LT';$data3[4]['LN_SIZE'] = 6.5;
	$data3[5]['BRD_TYPE'] = 'L';$data3[5]['LN_SIZE'] = 6.5;
	$pdf->tbDrawData($data3);
	
	$data4[0]['TEXT'] = "";
	$data4[3]['TEXT'] = "";
	$data4[5]['TEXT'] = "";
	$data4[0]['BRD_TYPE'] = '';
	$data4[1]['BRD_TYPE'] = 'T';
	$data4[2]['BRD_TYPE'] = 'T';
	$data4[3]['BRD_TYPE'] = 'T';
	$data4[4]['BRD_TYPE'] = 'T';
	$data4[5]['BRD_TYPE'] = '';
	$pdf->tbDrawData($data4);
	
	$pdf->tbOuputData();
	
	//Tanda Tangan
	$col = 5;
	$pdf->tbInitialize($col, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($h=0; $h<$col; $h++) $head[$h] = $table_default_datax_type;
	
	$head[0]['WIDTH'] = 1;
	$head[1]['WIDTH'] = 48;
	$head[2]['WIDTH'] = 70;
	$head[3]['WIDTH'] = 70;
	$head[4]['WIDTH'] = 1;
	
	$pdf->tbSetHeaderType($head);
	
	for($i=0; $i<$col; $i++) {
		$ket[$i] = $table_default_tblheader_type;
		$ttd[$i] = $table_default_ttd_type;
	}
	
	$ket[0]['TEXT'] = "";
	$ket[1]['TEXT'] = "";
	$ket[2]['TEXT'] = "";
	$ket[3]['TEXT'] = "";
	$ket[4]['TEXT'] = "";
	$ket[0]['BRD_TYPE'] = '';
	$ket[1]['BRD_TYPE'] = 'LT';
	$ket[2]['BRD_TYPE'] = 'LT';
	$ket[3]['BRD_TYPE'] = 'LT';
	$ket[4]['BRD_TYPE'] = 'L';
	$pdf->tbDrawData($ket);
	
	$arr_tgl_setor = explode("-", $arr_data[0]['setorpajret_tgl_bayar']);
		
	$ket[0]['TEXT'] = "";
	$ket[1]['TEXT'] = "Mengetahui";
	$ket[2]['TEXT'] = "Bekasi,    ".format_tgl(format_tgl($tgl_setoran), false, true, false);
	$ket[3]['TEXT'] = "Uang tersebut di atas diterima pada :";
	$ket[4]['TEXT'] = "";
	$ket[0]['BRD_TYPE'] = '';
	$ket[1]['BRD_TYPE'] = 'L';
	$ket[2]['BRD_TYPE'] = 'L';$ket[2]['T_ALIGN'] = 'L';
	$ket[3]['BRD_TYPE'] = 'L';
	$ket[4]['BRD_TYPE'] = 'L';
	$pdf->tbDrawData($ket);
	
	$ket[0]['TEXT'] = "";
	$ket[1]['TEXT'] = "";
	$ket[2]['TEXT'] = "Bendahara     ............................................";
	$ket[3]['TEXT'] = ".................................................      ...........";
	$ket[4]['TEXT'] = "";
	$ket[0]['BRD_TYPE'] = '';
	$ket[1]['BRD_TYPE'] = 'L';
	$ket[2]['BRD_TYPE'] = 'L';$ket[2]['T_ALIGN'] = 'L';
	$ket[3]['BRD_TYPE'] = 'L';
	$ket[4]['BRD_TYPE'] = 'L';
	$pdf->tbDrawData($ket);
	
	$ket[0]['TEXT'] = "";
	$ket[1]['TEXT'] = "";
	$ket[2]['TEXT'] = "";
	$ket[3]['TEXT'] = "";
	$ket[4]['TEXT'] = "";
	$ket[0]['BRD_TYPE'] = '';
	$ket[1]['BRD_TYPE'] = 'L';
	$ket[2]['BRD_TYPE'] = 'L';$ket[2]['T_ALIGN'] = 'L';
	$ket[3]['BRD_TYPE'] = 'L';
	$ket[4]['BRD_TYPE'] = 'L';
	$pdf->tbDrawData($ket);
	$pdf->tbDrawData($ket);
	$pdf->tbDrawData($ket);
	$pdf->tbDrawData($ket);
	
	
	$ttd[0]['TEXT'] = "";
	$ttd[1]['TEXT'] = "";
	$ttd[2]['TEXT'] = "";
	$ttd[3]['TEXT'] = "";
	$ttd[4]['TEXT'] = "";
	$ttd[0]['BRD_TYPE'] = '';
	$ttd[1]['BRD_TYPE'] = 'L';$ttd[1]['T_ALIGN'] = 'L';
	$ttd[2]['BRD_TYPE'] = 'L';$ttd[2]['T_ALIGN'] = 'L';
	$ttd[3]['BRD_TYPE'] = 'L';$ttd[3]['T_ALIGN'] = 'L';
	$ttd[4]['BRD_TYPE'] = 'L';
	$pdf->tbDrawData($ttd);
	
	$ket[1]['TEXT'] = "";
	$ket[1]['COLSPAN'] = 3;
	$ket[1]['BRD_TYPE'] = 'T';
	$ket[4]['BRD_TYPE'] = "";
	$ket[0]['LN_SIZE'] = 2;$ket[1]['LN_SIZE'] = 2;$ket[4]['LN_SIZE'] = 2;
	$pdf->tbDrawData($ket);
	
	$pdf->tbOuputData();
	
	$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'- Lembar 1 ','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Untuk UPTD Pendapatan','','','L'),'','','',2);
	$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'- Lembar 2 ','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Untuk Pelaporan dan Pembukuan','','','L'),'','','',2);
	$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'- Lembar 3 ','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Untuk Akuntansi','','','L'),'','','',2);
	$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'- Lembar 4 ','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Untuk Kasda','','','L'),'','','',2);
	$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'- Lembar 5 ','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Untuk Bendahara Penerimaan','','','L'),'','','',2);
	$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'- Lembar 6 ','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Untuk Bank','','','L'),'','','',2);
	
	//Logo
	$logo = "assets/". $pemda->dapemda_logo_path;
	$pdf->Image($logo,16,13, 15);
	
	$pdf->Output();

}

?>