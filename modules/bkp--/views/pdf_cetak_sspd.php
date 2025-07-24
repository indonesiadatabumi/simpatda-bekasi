<?php

error_reporting(E_ERROR);

// Load library FPDF
define('FPDF_FONTPATH',$this->config->item('fonts_path'));

require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';
require_once APPPATH.'libraries/fpdf/table/table_def.inc';
require_once APPPATH.'libraries/fpdf/table/header_footer.inc';

$pdf = new FPDF_TABLE('P','mm','Letter'); // Portrait, Letter, Lebar = 190
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(15, 10, 10);     // Margin Left, Top, Right 2 cm

$skpd = " ";
$skpdt = " ";
$stpd = " ";
$strd = " ";
$skrdj = " ";
$sptpd = " ";
$skrd = " ";
$skpdkb = " ";
$skpdlb = " ";

switch($setorpajret_jenis_ketetapan) {
	case 1: $skpd="X"; break;
	case 2: $skpdt="X"; break;
	case 3: $stpd="X"; break;
	case 4: $strd="X"; break;
	case 5: $skrdj="X"; break;
	case 8: $sptpd="X"; break;
	case 9: $skrd="X"; break;
	case 11: $skpdkb="X"; break;
	case 12: $skpdlb="X"; break;
}

//var_dump($ar_rekam_setor);
if (!empty($ar_rekam_setor)) {
	//foreach ($ar_rekam_setor as $k1 => $v1) {
	$pdf->AddPage();
	$pdf->AliasNbPages();
	
	$title = ucwords("surat setoran pajak daerah");
	$s_title = strtoupper("sspd");
		
	$pdf->SetStyle("sb","arial","B",7,"0,0,0");
	$pdf->SetStyle("b","arial","B",8,"0,0,0");
	$pdf->SetStyle("h1","arial","B",11,"0,0,0");
	$pdf->SetStyle("nu","arial","U",8,"0,0,0");
	$pdf->SetStyle("th1","arial","B",10,"0,0,0");
	
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
		$header_type3[$i] = $table_default_headerx_type;
		$header_type4[$i] = $table_default_headerx_type;
		$spacer2[$i] = $table_default_datax_type;
	}
	
	$spacer1[0]['WIDTH'] = 22;
	$spacer1[1]['WIDTH'] = 73;
	$spacer1[2]['WIDTH'] = 95;
	
	$spacer1[0]['TEXT'] = "";
	$spacer1[2]['TEXT'] = "";
	$spacer1[0]['COLSPAN'] = 2;
	$spacer1[0]['BRD_TYPE'] = 'LT';
	$spacer1[2]['BRD_TYPE'] = 'LRT';
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
	$header_type1[0]['BRD_TYPE'] = 'L';	
	$header_type1[1]['TEXT'] = $pmda;
	$header_type1[1]['ROWSPAN'] = 4;
	$header_type1[1]['T_ALIGN'] = 'L';
	$header_type1[1]['T_SIZE'] = 8;
	$header_type1[1]['LN_SIZE'] = 4;
	
	$header_type1[2]['TEXT'] = "<h1>SSPD\n(SURAT SETORAN PAJAK DAERAH)</h1>\nTahun : " . $ar_rekam_setor[0]['spt_periode'];
	$header_type1[2]['COLSPAN'] = 2;
	$header_type1[2]['ROWSPAN'] = 4;
	$header_type1[2]['T_SIZE'] = 9;
	$header_type1[2]['BRD_TYPE'] = 'LR';
	
	$spacer2[0]['TEXT'] = "";
	$spacer2[2]['TEXT'] = "";
	$spacer2[0]['COLSPAN'] = 2;
	$spacer2[0]['BRD_TYPE'] = 'L';
	$spacer2[2]['BRD_TYPE'] = 'LR';
	$spacer2[0]['T_SIZE'] = 2;
	$spacer2[0]['LN_SIZE'] = 2;
	$spacer2[2]['T_SIZE'] = 2;
	$spacer2[2]['LN_SIZE'] = 2;
	
	$aHeaderArray = array(
		$spacer1,
		$header_type1,
		$header_type2, 
		$header_type3,
		$header_type4,
		$spacer2
	);

	//set the Table Header
	$pdf->tbSetHeaderType($aHeaderArray, true);
	
	//Draw the Header
	$pdf->tbDrawHeader();
	$pdf->tbOuputData();
	// End of Header
	
	//Bagian Identitas
	$kolom = 7;
	$pdf->tbInitialize($kolom, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($a=0; $a<$kolom; $a++) $setcol[$a] = $table_default_datax_type;
	
	$setcol[0]['WIDTH'] = 10;
	$setcol[1]['WIDTH'] = 35;
	$setcol[2]['WIDTH'] = 5;
	$setcol[3]['WIDTH'] = 70;
	$setcol[4]['WIDTH'] = 30;
	$setcol[5]['WIDTH'] = 30;
	$setcol[6]['WIDTH'] = 10;
	
	$pdf->tbSetHeaderType($setcol);
	
	for($b=0; $b<$kolom; $b++) {
		$pdtop[$b] = $table_default_datax_type;
		$r1[$b] = $table_default_datax_type;
		$r2[$b] = $table_default_datax_type;
		$r3[$b] = $table_default_datax_type;
		$pdbot[$b] = $table_default_datax_type;
	}
	
	//padding atas
	$pdtop[0]['TEXT'] = "";
	$pdtop[0]['COLSPAN'] = 7;
	$pdtop[0]['LN_SIZE'] = 4;
	$pdtop[0]['BRD_TYPE'] = 'LRT';
	$pdf->tbDrawData($pdtop);
	
	//baris ke-1
	$r1[0]['TEXT'] = "";
	$r1[1]['TEXT'] = "NAMA";
	$r1[2]['TEXT'] = ":";

	$nama_wp = strtoupper($ar_rekam_setor[0]['wp_wr_nama']);
	
	$r1[3]['TEXT'] = "" .$nama_wp;
	
	$r1[1]['V_ALIGN'] = 'T';
	$r1[2]['V_ALIGN'] = 'T';
	$r1[3]['V_ALIGN'] = 'T';
	
	$r1[3]['COLSPAN'] = 4;
	$r1[1]['T_ALIGN'] = 'L';
	$r1[0]['BRD_TYPE'] = 'L';
	$r1[3]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($r1);
	
	$wp_wr_lurah = (empty($ar_rekam_setor[0]['wp_wr_lurah']) ? "" : "\nKEL. ".$ar_rekam_setor[0]['wp_wr_lurah']);
	$wp_wr_camat = (empty($ar_rekam_setor[0]['wp_wr_camat']) ? "" : "KEC. ".$ar_rekam_setor[0]['wp_wr_camat']);
	if ($ar_rekam_setor[0]['spt_jenis_pajakretribusi'] != "4")
		$alamat = strtoupper(ereg_replace("\r|\n"," ",$ar_rekam_setor[0]['wp_wr_almt'])). strtoupper($wp_wr_lurah." ".$wp_wr_camat);
	else 
		$alamat = strtoupper(ereg_replace("\r|\n"," ",$ar_rekam_setor[0]['wp_wr_almt']));
	//baris ke-2
	$r1[0]['TEXT'] = "";
	$r1[1]['TEXT'] = "ALAMAT";
	$r1[2]['TEXT'] = ":";
	$r1[3]['TEXT'] = $alamat;
	
	$r1[1]['V_ALIGN'] = 'T';
	$r1[2]['V_ALIGN'] = 'T';
	$r1[3]['V_ALIGN'] = 'T';
	
	$r1[3]['COLSPAN'] = 4;
	$r1[1]['T_ALIGN'] = 'L';
	$r1[0]['BRD_TYPE'] = 'L';
	$r1[3]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($r1);
	
	//baris ke-3
	if ($ar_rekam_setor[0]['spt_jenis_pajakretribusi'] != '4') {
		$r1[0]['TEXT'] = "";
		$r1[1]['TEXT'] = "NPWPD";
		$r1[2]['TEXT'] = ":";
		$r1[3]['TEXT'] = "" . $ar_rekam_setor[0][npwprd];
		
		$r1[1]['V_ALIGN'] = 'T';
		$r1[2]['V_ALIGN'] = 'T';
		$r1[3]['V_ALIGN'] = 'T';
		
		$r1[3]['COLSPAN'] = 4;
		$r1[1]['T_ALIGN'] = 'L';
		$r1[0]['BRD_TYPE'] = 'L';
		$r1[3]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($r1);


		
		
		//baris ke-4
		$r1[0]['TEXT'] = "";
		$r1[1]['TEXT'] = "KODE BAYAR";
		$r1[2]['TEXT'] = ":";
		$r1[3]['TEXT'] = "" . $ar_rekam_setor[0][spt_kode_billing];
		
		$r1[1]['V_ALIGN'] = 'T';
		$r1[2]['V_ALIGN'] = 'T';
		$r1[3]['V_ALIGN'] = 'T';
		
		$r1[3]['COLSPAN'] = 4;
		$r1[1]['T_ALIGN'] = 'L';
		$r1[0]['BRD_TYPE'] = 'L';
		$r1[3]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($r1);
		
	}	
	

	
	$pdf->tbOuputData();
	
	$artgl = explode("-",$ar_rekam_setor[0][spt_periode_jual1]);
	$blnxa = $artgl[1];
	
	$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',5).$pdf->Cell(190,7,'','LR','','C'),'','','',0);
	$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',10).$pdf->Cell(4,4,"",'L','','L').$pdf->Cell(41,4,"Menyetor berdasarkan *)",'','','L').$pdf->Cell(5,4,":",'','','L')
			.$pdf->Cell(5,4,$skpd,'LRTB','','C').$pdf->Cell(40,4,"SKPD",'','','L')
			.$pdf->Cell(5,4,$stpd,'LRTB','','C').$pdf->Cell(40,4,"STPD",'','','L')
			.$pdf->Cell(5,4," ",'LRTB','','C').$pdf->Cell(45,4,"Lain-lain",'R','','L'),'','','',0);
	
	$pdf->MultiCell(190,2,'','LR','','',0);
	
	$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',10).$pdf->Cell(4,4,"",'L','','L').$pdf->Cell(41,4,"",'','','L').$pdf->Cell(5,4,"",'','','L')
			.$pdf->Cell(5,4,$skpdt,'LRTB','','C').$pdf->Cell(40,4,"SKPDT",'','','L')
			.$pdf->Cell(5,4,$sptpd,'LRTB','','C').$pdf->Cell(40,4,"SPTPD",'','','L')
			.$pdf->Cell(5,4," ",'','','C').$pdf->Cell(45,4,"",'R','','L'),'','','',0);
			
	$pdf->MultiCell(190,2,'','LR','','',0);
	
	$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',10).$pdf->Cell(4,4,"",'L','','L').$pdf->Cell(41,4,"",'','','L').$pdf->Cell(5,4,"",'','','L')
			.$pdf->Cell(5,4,$skpdkb,'LRTB','','C').$pdf->Cell(40,4,"SKPDKB",'','','L')
			.$pdf->Cell(5,4," ",'LRTB','','C').$pdf->Cell(40,4,"SK Pembentukan",'','','L')
			.$pdf->Cell(5,4," ",'','','C').$pdf->Cell(45,4,"",'R','','L'),'','','',0);
			
	$pdf->MultiCell(190,2,'','LR','','',0);
	
	$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',10).$pdf->Cell(4,4,"",'L','','L').$pdf->Cell(41,4,"",'','','L').$pdf->Cell(5,4,"",'','','L')
			.$pdf->Cell(5,4," ",'LRTB','','C').$pdf->Cell(40,4,"SKPDKBT",'','','L')
			.$pdf->Cell(5,4," ",'LRTB','','C').$pdf->Cell(40,4,"SK Keberatan",'','','L')
			.$pdf->Cell(5,4," ",'','','C').$pdf->Cell(45,4,"",'R','','L'),'','','',0);
	
	$pdf->MultiCell(190,7,'','LR','','',0);
	
	if ($ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_spt_self') || $ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_skpd') ||
		$ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_stpd')) {
			
		$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',10).$pdf->Cell(45,4,"",'L','','L').$pdf->Cell(4,4,":",'','','L')
			.$pdf->Cell(23,4,"Masa Pajak : ",'','','L').$pdf->Cell(35,4,strtoupper(format_tgl('-'.$blnxa.'-',false,true)),'','','L')
			.$pdf->Cell(15,4,"Tahun : ",'','','L').$pdf->Cell(25,4,$artgl[0],'','','L')
			.$pdf->Cell(17,4,"No. Urut : ",'','','L').$pdf->Cell(26,4,format_angka($this->config->item('length_kohir_spt'), $ar_rekam_setor[0]['spt_nomor']),'R','','L'),'','','',0);
					
	} else {
		$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',10).$pdf->Cell(45,4,"",'L','','L').$pdf->Cell(4,4,":",'','','L')
			.$pdf->Cell(23,4,"",'','','L').$pdf->Cell(35,4,"",'','','L')
			.$pdf->Cell(15,4,"Tahun : ",'','','L').$pdf->Cell(25,4,$artgl[0],'','','L')
			.$pdf->Cell(17,4,"No. Urut : ",'','','L').$pdf->Cell(26,4,format_angka($this->config->item('length_kohir_spt'), $ar_rekam_setor[0]['spt_nomor']),'R','','L'),'','','',0);
	}
					
	$pdf->MultiCell(190,7,'','LR','','',0);
	
	//Detail Rincian
	$kol = 6;
	$pdf->tbInitialize($kol, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($d=0; $d<$kol; $d++) $lbr[$d] = $table_default_datax_type;
	
	$lbr[0]['WIDTH'] = 5;
	$lbr[1]['WIDTH'] = 10;
	$lbr[2]['WIDTH'] = 30;
	$lbr[3]['WIDTH'] = 90;
	$lbr[4]['WIDTH'] = 50;
	$lbr[5]['WIDTH'] = 5;
	
	$pdf->tbSetHeaderType($lbr);
	
	for($e=0; $e<$kol; $e++) {
		$m1[$e] = $table_default_tblheader_type;
		$m2[$e] = $table_default_tbldata_type;
		$m3[$e] = $table_default_tbldata_type;
		$m4[$e] = $table_default_datax_type;
	}
	
	//Table Header
	$m1[0]['TEXT'] = "";
	$m1[1]['TEXT'] = "No.";
	$m1[2]['TEXT'] = "Kode Rekening";
	$m1[3]['TEXT'] = "U r a i a n";
	$m1[4]['TEXT'] = "J u m l a h \n(Rp.)";
	$m1[5]['TEXT'] = "";
	
	$m1[0]['BRD_TYPE'] = 'L';
	$m1[1]['BRD_TYPE'] = 'LT';
	$m1[2]['BRD_TYPE'] = 'LT';
	$m1[3]['BRD_TYPE'] = 'LT';
	$m1[4]['BRD_TYPE'] = 'LT';
	$m1[5]['BRD_TYPE'] = 'LR';
	$pdf->tbDrawData($m1);
	
	$counter = 1;
	$total_pajak = 0;

	if (count($ar_rekam_setor) > 1) {
		if (count($ar_rekam_setor) == 2 && $denda == 0)
			$newline = "\n\n";
		else 
			$newline = "\n";	
	}
	else {
		if ($denda > 0 )
			$newline = "\n\n\n";
		else 
			$newline = "\n\n\n\n";
	}
	
	if ($ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_spt_self') || $ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_skpd') ||
		$ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_stpd')) {
			
		foreach ($ar_rekam_setor as $k => $v) {
			$total_pajak += $v['spt_dt_pajak'];
			$masa_pajak = $v['spt_periode_jual1'];
			$arr_masa_pajak = explode("-", $masa_pajak);
			$m2[0]['TEXT'] = "";
			$m2[1]['TEXT'] = "" . $counter;
			$m2[2]['TEXT'] = "" . $v['koderek_detail'];
			if ($this->input->get('spt_jenis_pajakretribusi') != "4")
				$m2[3]['TEXT'] = "" . $v['korek_nama_detail'];
			else 
				$m2[3]['TEXT'] = "" . $v['korek_nama_detail']."\n".$v['sptrek_judul'];
		
			$m2[4]['TEXT'] = format_currency($v['spt_dt_pajak']);
			$m2[5]['TEXT'] = "";
			
			$m2[1]['T_ALIGN'] = 'C';
			$m2[2]['T_ALIGN'] = 'C';
			$m2[4]['T_ALIGN'] = 'R';
			
			$m2[0]['BRD_TYPE'] = 'L';
			$m2[1]['BRD_TYPE'] = 'LT';
			$m2[2]['BRD_TYPE'] = 'LT';
			$m2[3]['BRD_TYPE'] = 'LT';
			$m2[4]['BRD_TYPE'] = 'LT';
			$m2[5]['BRD_TYPE'] = 'LR';
			
			$pdf->tbDrawData($m2);
			
			$counter ++;
		}	
		
	} else {
		foreach ($ar_rekam_setor as $k => $v) {
			$total_pajak += $v['spt_dt_pajak'];
			$masa_pajak = $v['spt_periode_jual1'];
			$arr_masa_pajak = explode("-", $masa_pajak);
			$m2[0]['TEXT'] = "";
			$m2[1]['TEXT'] = "" . $counter;
			$m2[2]['TEXT'] = "" . $v['koderek_detail'];
			$m2[3]['TEXT'] = "" . $v['korek_nama_detail']."   -   ".getNamaBulan($arr_masa_pajak[1])." ".$arr_masa_pajak[0]; 			
			$m2[4]['TEXT'] = "" .format_currency($v['spt_dt_pajak']);
			$m2[5]['TEXT'] = "";
			
			$m2[1]['T_ALIGN'] = 'C';
			$m2[2]['T_ALIGN'] = 'C';
			$m2[4]['T_ALIGN'] = 'R';
			
			$m2[0]['BRD_TYPE'] = 'L';
			$m2[1]['BRD_TYPE'] = 'LT';
			$m2[2]['BRD_TYPE'] = 'LT';
			$m2[3]['BRD_TYPE'] = 'LT';
			$m2[4]['BRD_TYPE'] = 'LT';
			$m2[5]['BRD_TYPE'] = 'LR';
			
			$pdf->tbDrawData($m2);
			
			$counter ++;
		}	
	}
	
	if ($denda > 0) {
		$m2[0]['TEXT'] = "";
		$m2[1]['TEXT'] = "" . $counter;
		$m2[2]['TEXT'] = "" . $denda_kode_rekening;
		$m2[3]['TEXT'] = "" . $denda_nama_rekening; 			
		$m2[4]['TEXT'] = "" .format_currency($denda);
		$m2[5]['TEXT'] = "";
		
		$m2[1]['T_ALIGN'] = 'C';
		$m2[2]['T_ALIGN'] = 'C';
		$m2[4]['T_ALIGN'] = 'R';
		
		$m2[0]['BRD_TYPE'] = 'L';
		$m2[1]['BRD_TYPE'] = 'LT';
		$m2[2]['BRD_TYPE'] = 'LT';
		$m2[3]['BRD_TYPE'] = 'LT';
		$m2[4]['BRD_TYPE'] = 'LT';
		$m2[5]['BRD_TYPE'] = 'LR';
		
		$pdf->tbDrawData($m2);
	}
	
	$m2[0]['TEXT'] = "";
	$m2[1]['TEXT'] = "";
	$m2[2]['TEXT'] = "".$newline;
	$m2[3]['TEXT'] = ""; 			
	$m2[4]['TEXT'] = "";
	$m2[5]['TEXT'] = "";
	$m2[0]['BRD_TYPE'] = 'L';
	$m2[1]['BRD_TYPE'] = 'L';
	$m2[2]['BRD_TYPE'] = 'L';
	$m2[3]['BRD_TYPE'] = 'L';
	$m2[4]['BRD_TYPE'] = 'L';
	$m2[5]['BRD_TYPE'] = 'LR';	
	$pdf->tbDrawData($m2);
	
	$m3[0]['TEXT'] = "";
	$m3[1]['TEXT'] = "";
	$m3[3]['TEXT'] = "Jumlah Setoran Pajak";
	$m3[4]['TEXT'] = " " . format_currency($total_pajak + $denda);
	$m3[5]['TEXT'] = "";
	
	$m3[1]['COLSPAN'] = 2;
	$m3[4]['T_ALIGN'] = 'R';
	$m3[0]['BRD_TYPE'] = 'L';
	$m3[1]['BRD_TYPE'] = 'T';
	$m3[3]['BRD_TYPE'] = 'LT';
	$m3[4]['BRD_TYPE'] = 'LT';
	$m3[5]['BRD_TYPE'] = 'LR';
	
	$pdf->tbDrawData($m3);
	
	$m4[0]['TEXT'] = "";
	$m4[3]['TEXT'] = "";
	$m4[5]['TEXT'] = "";
	$m4[0]['COLSPAN'] = 3;
	$m4[3]['COLSPAN'] = 2;
	$m4[0]['BRD_TYPE'] = 'L';
	$m4[3]['BRD_TYPE'] = 'T';
	$m4[5]['BRD_TYPE'] = 'R';
	
	$pdf->tbDrawData($m4);
	
	$pdf->tbOuputData();
	
	//Terbilang
	$klm = 3;
	$pdf->tbInitialize($klm, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($f=0; $f<$klm; $f++) $hdr[$f] = $table_default_datax_type;
	
	$hdr[0]['WIDTH'] = 45;
	$hdr[1]['WIDTH'] = 140;
	$hdr[2]['WIDTH'] = 5;
	
	$pdf->tbSetHeaderType($hdr);
	
	for($g=0; $g<$klm; $g++) {
		$dt1[$g] = $table_default_datax_type;
		$dt2[$g] = $table_default_datax_type;
	}
	
	$dt1[0]['TEXT'] = "   Dengan huruf :";
	$dt1[1]['TEXT'] = "" . ucwords(strtolower(terbilang($total_pajak + $denda)). " Rupiah");
	$dt1[2]['TEXT'] = "";
	
	$dt1[0]['BRD_TYPE'] = 'L';
	$dt1[1]['BRD_TYPE'] = 'LT';
	$dt1[2]['BRD_TYPE'] = 'LR';
	$pdf->tbDrawData($dt1);
	
	$dt2[0]['TEXT'] = "";
	$dt2[1]['TEXT'] = "";
	$dt2[2]['TEXT'] = "";
	
	$dt2[0]['BRD_TYPE'] = 'L';
	$dt2[1]['BRD_TYPE'] = 'T';
	$dt2[2]['BRD_TYPE'] = 'R';
	$pdf->tbDrawData($dt2);
	
	$pdf->tbOuputData();
	
	//Tanda Tangan
	$col = 3;
	$pdf->tbInitialize($col, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($h=0; $h<$col; $h++) $head[$h] = $table_default_datax_type;
	
	$head[0]['WIDTH'] = 63;
	$head[1]['WIDTH'] = 64;
	$head[2]['WIDTH'] = 63;
	
	$pdf->tbSetHeaderType($head);
	
	for($i=0; $i<$col; $i++) {
		$ket[$i] = $table_default_tblheader_type;
		$ttd[$i] = $table_default_ttd_type;
	}
	
	$ket[0]['TEXT'] = "";
	$ket[1]['TEXT'] = "";
	$ket[2]['TEXT'] = "";
	
	$ket[0]['BRD_TYPE'] = 'LT';
	$ket[1]['BRD_TYPE'] = 'LT';
	$ket[2]['BRD_TYPE'] = 'LRT';
	$pdf->tbDrawData($ket);
	
	if (empty($cetak_tgl_setoran)) {
		$tgl_cetakan = "..................................";
		$ket[2]['T_ALIGN'] = 'L';
	} else {
		$tgl_cetakan = format_tgl($cetak_tgl_setoran,false,true);
		$ket[2]['T_ALIGN'] = 'C';
	}
	
	$ket[0]['TEXT'] = "Ruang untuk Teraan";
	$ket[1]['TEXT'] = "Diterima oleh,";
	$ket[2]['TEXT'] = "Bekasi,   " .$tgl_cetakan;
	
	$ket[0]['BRD_TYPE'] = 'L';
	$ket[1]['BRD_TYPE'] = 'L';
	$ket[2]['BRD_TYPE'] = 'LR';
	
	$pdf->tbDrawData($ket);
	
	$ket[0]['TEXT'] = "";
	if(!empty($mengetahui['ref_japeda_nama'])) {
		$ket[1]['TEXT'] = "".$mengetahui['ref_japeda_nama'];
	}
	else {
		$ket[1]['TEXT'] = "Petugas Tempat Pembayaran";
	}
	$ket[2]['TEXT'] = "";
	
	$ket[0]['BRD_TYPE'] = 'L';
	$ket[1]['BRD_TYPE'] = 'L';
	$ket[2]['BRD_TYPE'] = 'LR';
	$ket[2]['T_ALIGN'] = 'C';
	$pdf->tbDrawData($ket);
	
	$ttd[0]['TEXT'] = "";
	$ttd[1]['TEXT'] = "Tanggal  : . . .   -  . . . . .  -  . . . . . . . . .";
	$ttd[2]['TEXT'] = "Penyetor,";
	
	//$ttd[1]['T_ALIGN'] = 'L';
	$ttd[0]['BRD_TYPE'] = 'L';
	$ttd[1]['BRD_TYPE'] = 'L';
	$ttd[2]['BRD_TYPE'] = 'LR';
	$pdf->tbDrawData($ttd);
	
	$ket[0]['TEXT'] = "";
	$ket[1]['TEXT'] = "";
	$ket[2]['TEXT'] = "";
	$ket[0]['BRD_TYPE'] = 'L';
	$ket[1]['BRD_TYPE'] = 'L';
	$ket[2]['BRD_TYPE'] = 'LR';
	
	$pdf->tbDrawData($ket);
	$pdf->tbDrawData($ket);
	$pdf->tbDrawData($ket);
	
	if(!empty($teraan['pejda_nama'])) {
		$ttd[0]['TEXT'] = "<nu>      ".$teraan['pejda_nama']."      </nu>";
	}
	else {
		$ttd[0]['TEXT'] = "";
	}
	
	
	if(!empty($mengetahui['pejda_nama'])) {
		$ttd[1]['TEXT'] = "<nu>      ".$mengetahui['pejda_nama']."      </nu>";
	}
	else {
		$ttd[1]['TEXT'] = "";
	}
	if(!empty($penyetor)) {
		$ttd[2]['TEXT'] = "(  ".strtoupper($penyetor)."  )";
	}
	else {
		$ttd[2]['TEXT'] = "( ".$nama_wp." )";
	}
	$ttd[0]['BRD_TYPE'] = 'L';
	$ttd[1]['BRD_TYPE'] = 'L';
	$ttd[2]['BRD_TYPE'] = 'LR';
	$pdf->tbDrawData($ttd);
	
	if(!empty($teraan['pejda_nip'])) {
		$ttd[0]['TEXT'] = "NIP. ".$teraan['pejda_nip'];
	}
	else {
		$ttd[0]['TEXT'] = "";
	}
	
	if(!empty($mengetahui['pejda_nip'])) {
		$ttd[1]['TEXT'] = "NIP. ".$mengetahui['pejda_nip'];
	}
	else {
		$ttd[1]['TEXT'] = "";
	}
	$ttd[2]['TEXT'] = "";
	$ttd[0]['BRD_TYPE'] = 'L';
	$ttd[1]['BRD_TYPE'] = 'L';
	$ttd[2]['BRD_TYPE'] = 'LR';
	$pdf->tbDrawData($ttd);
	
	$ket[0]['TEXT'] = "";
	$ket[0]['COLSPAN'] = 3;
	$ket[0]['BRD_TYPE'] = 'T';
	$ket[0]['LN_SIZE'] = 2;
	$pdf->tbDrawData($ket);
	
	$pdf->tbOuputData();	
	
	$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).$pdf->Cell(25,2,'Lembar Putih','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Wajib Pajak','','','L'),'','','',2);
	if ($this->session->userdata('USER_SPT_CODE') == "10" && $this->input->get('spt_jenis_pajakretribusi') == "4") {
		$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).$pdf->Cell(25,2,'Lembar Merah','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'BPPT','','','L'),'','','',2);
	} else {
		$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).$pdf->Cell(25,2,'Lembar Merah','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'UPTD Pendapatan','','','L'),'','','',2);
	}
	
	$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).$pdf->Cell(25,2,'Lembar Kuning','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Seksi Pembukuan dan Pelaporan','','','L'),'','','',2);
	$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).$pdf->Cell(25,2,'Lembar Hijau','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Bendahara Penerimaan','','','L'),'','','',2);
	$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).$pdf->Cell(25,2,'Lembar Biru','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Seksi Pajak Daerah ','','','L'),'','','',2);
	
	
	//Logo
	$pdf->Image('assets/'.$pemda->dapemda_logo_path,17,14,20,20);
	//}	
}

$pdf->Output();

?>
