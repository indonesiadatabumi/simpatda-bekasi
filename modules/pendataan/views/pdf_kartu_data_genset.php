<?php 
	
	error_reporting(E_ERROR);

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
	$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
	//$pdf->SetMargins(10, 10, 10);     // Margin Left, Top, Right 2 cm
	$pdf->AddPage();
	$pdf->AliasNbPages();
	
	$pdf->SetStyle("sb","arial","B",7,"0,0,0");
	$pdf->SetStyle("b","arial","B",12,"0,0,0");
	$pdf->SetStyle("h1","arial","B",14,"0,0,0");
	$pdf->SetStyle("nu","arial","U",8,"0,0,0");
	$columns = 5; // bisa disesuaikan
	// Lebar = 190
	
	$pdf->tbInitialize($columns, true, true);
	$pdf->tbSetTableType($table_default_kartu_type);
				
	if (!empty($wp)) {
		for($i=0; $i<$columns; $i++) 
			$header_type[$i] = $table_default_kartu_type;
		
	
		for($i=0; $i<$columns; $i++) {
			$spacer1[$i] = $table_default_kartu_type;
			$header_type1[$i] = $table_default_kartu_type;
			$header_type2[$i] = $table_default_kartu_type;
			$header_type3[$i] = $table_default_kartu_type;
			$spacer2[$i] = $table_default_kartu_type;
		}
	
		$spacer1[0]['WIDTH'] = 15;
		$spacer1[1]['WIDTH'] = 50;
		$spacer1[2]['WIDTH'] = 40;
		$spacer1[3]['WIDTH'] = 35;
		$spacer1[4]['WIDTH'] = 50;
		
		$spacer1[0]['TEXT'] = "";
		$spacer1[0]['COLSPAN'] = 5;
		$spacer1[0]['BRD_TYPE'] = 'LRT';
		$spacer1[0]['T_SIZE'] = 2;
		$spacer1[0]['LN_SIZE'] = 2;
		
		//Baris ke-1
		$header_type1[0]['TEXT'] = "";
		$header_type1[0]['ROWSPAN'] = 4;
		$header_type1[0]['BRD_TYPE'] = 'L';
		
		$header_type1[1]['TEXT'] = "";
		$header_type1[1]['ROWSPAN'] = 4;
		$header_type1[1]['T_ALIGN'] = 'L';
		$header_type1[1]['T_SIZE'] = 6;
		$header_type1[1]['LN_SIZE'] = 3;
		
		// ganti header
		// $pdf->SetFont('Arial','B',14);
		// $pdf->Cell(190,5,'KARTU DATA',0,1,'C');

		// $pdf->SetFont('Arial','B',12);
		// $pdf->Cell(190,7,'PAJAK PENERANGAN JALAN UMUM Non PLN',0,1,'C');

		// $pdf->SetFont('Arial','',10);
		// $pdf->Cell(190,7,"Tahun Pajak : ". $this->input->get('spt_periode'),0,1,'C');

		// $pdf->SetFont('Arial','',10);
		// $pdf->Cell(190,5,"N.P.W.P.D  \n" . $wp['npwprd'],0,1,'C');

		// end ganti header

		$header_type1[2]['TEXT'] = "\n<h1>KARTU DATA</h1>\n<b>PPAJAK PENERANGAN JALAN UMUM Non PLN </b>\n<p>TTahun Pajak : " . $this->input->get('spt_periode')."</p>";
		$header_type1[2]['TEXT'] .= "\n<p>NN.P.W.P.D\n " . $wp['npwprd'] . "</p>";
		$header_type1[2]['COLSPAN'] = 2;
		$header_type1[2]['ROWSPAN'] = 4;
		$header_type1[2]['T_ALIGN'] = 'C';
		$header_type1[2]['T_TYPE'] = '';
		$header_type1[2]['T_SIZE'] = 8;

		$header_type1[4]['ROWSPAN'] = 4;
		$header_type1[4]['T_ALIGN'] = 'R';
		$header_type1[4]['T_TYPE'] = 'B';
		$header_type1[4]['BRD_TYPE'] = 'R';
		
		$spacer2[0]['TEXT'] = "\n\n";
		$spacer2[0]['COLSPAN'] = 5;
		$spacer2[0]['BRD_TYPE'] = 'LR';
		$spacer2[0]['T_SIZE'] = 2;
		$spacer2[0]['LN_SIZE'] = 2;
		
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
		
		// Baris Identitas
		$coldata = 4;
		$pdf->tbInitialize($coldata, true, true);
		$pdf->tbSetTableType($table_default_kartu_type);
		
		for($i=0; $i<$coldata; $i++) $header_type[$i] = $table_default_header_type;
		
		$header_type[0]['WIDTH'] = 10;
		$header_type[1]['WIDTH'] = 35;
		$header_type[2]['WIDTH'] = 3;
		$header_type[3]['WIDTH'] = 142;
		
		$pdf->tbSetHeaderType($header_type);
		
		$data_type = Array();//reset the array
		for ($i=0; $i<4; $i++) $data_type[$i] = $table_default_kartu_type;
	
		$pdf->tbSetDataType($data_type);
		for($j=0;$j<$coldata;$j++) {
			$top[$j] = $table_default_kartu_type;
			$data1[$j] = $table_default_kartu_type;
			$data2[$j] = $table_default_kartu_type;
			$data3[$j] = $table_default_kartu_type;
			$data4[$j] = $table_default_kartu_type;
			$bot[$j] = $table_default_kartu_type;
		}
		
		//Padding Atas
		$top[0]['TEXT'] = "";
		$top[0]['COLSPAN'] = 4;
		$top[0]['T_SIZE'] = 2;
		$top[0]['LN_SIZE'] = 4;
		$top[0]['BRD_TYPE'] = 'LRT';
		$pdf->tbDrawData($top);
					
		$data = Array();
		$data[0]['T_ALIGN'] = 'R';		
		$data[0]['BRD_TYPE'] = 'L';
		$data[0]['TEXT'] = "1.";
		$data[1]['TEXT'] = "Bentuk Usaha";
		$data[2]['TEXT'] = ":";
		$data[3]['BRD_TYPE'] = 'R';
		if ($wp['wp_wr_gol'] == "2")
			$data[3]['TEXT'] = "[  ] Orang Pribadi          [ X ] Badan";
		else if ($wp['wp_wr_gol'] == "1")
			$data[3]['TEXT'] = "[ X ] Orang Pribadi         [  ] Badan";		
		$pdf->tbDrawData($data);
		
		$data1 = Array();
		$data1[0]['T_ALIGN'] = 'R';		
		$data1[0]['BRD_TYPE'] = 'L';
		$data1[0]['TEXT'] = "2.";
		$data1[1]['TEXT'] = "Nama / Merek Usaha";
		$data1[2]['TEXT'] = ":";
		$data1[3]['BRD_TYPE'] = 'R';
		$data1[3]['TEXT'] = "" . $wp['wp_wr_nama'];
		$pdf->tbDrawData($data1);
		
		$data2 = Array();
		$data2[0]['T_ALIGN'] = 'R';
		$data2[0]['BRD_TYPE'] = 'L';
		$data2[0]['TEXT'] = "3.";
		$data2[1]['TEXT'] = "Alamat Usaha";
		$data2[2]['TEXT'] = ":";
		// $data2[3]['TEXT'] = "" . preg_replace("\r\n|\n",", ",$wp['wp_wr_almt']);
		$data2[3]['TEXT'] = "" . $wp['wp_wr_almt'];
		$data2[3]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($data2);
		
		$data3 = Array();
		$data3[0]['T_ALIGN'] = 'R';
		$data3[0]['BRD_TYPE'] = 'L';
		$data3[0]['TEXT'] = "4.";
		$data3[1]['TEXT'] = "Nama Pemilik";
		$data3[2]['TEXT'] = ":";
		$data3[3]['TEXT'] = "" . $wp['wp_wr_nama_milik'];
		$data3[3]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($data3);
		
		$data4 = Array();
		$data4[0]['T_ALIGN'] = 'R';
		$data4[0]['BRD_TYPE'] = 'L';
		$data4[0]['TEXT'] = "5.";
		$data4[1]['TEXT'] = "Alamat Tempat Tinggal";
		$data4[2]['TEXT'] = ":";
		// $data4[3]['TEXT'] = "" . preg_replace("\r\n|\n",", ",$wp['wp_wr_almt']);
		$data4[3]['TEXT'] = "" . $wp['wp_wr_almt'];
		$data4[3]['BRD_TYPE'] = 'R';		
		$pdf->tbDrawData($data4);
		
		//Padding Bawah
		$bot = array();
		$bot[0]['TEXT'] = "";
		$bot[0]['COLSPAN'] = 4;
		$bot[0]['T_SIZE'] = 2;
		$bot[0]['LN_SIZE'] = 4;
		$bot[0]['BRD_TYPE'] = 'LR';
		$pdf->tbDrawData($bot);

		$pdf->tbOuputData();
		// End of Baris Identitas
		
		// Baris Detail
		$kolom = 7;
		$pdf->tbInitialize($kolom, true, true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($i=0; $i<$kolom; $i++) 
			$setcol[$i] = $table_default_kartu_type;
		
		$setcol[0]['WIDTH'] = 10;
		$setcol[1]['WIDTH'] = 35;
		$setcol[2]['WIDTH'] = 5;
		$setcol[3]['WIDTH'] = 15;
		$setcol[4]['WIDTH'] = 40;
		$setcol[5]['WIDTH'] = 45;
		$setcol[6]['WIDTH'] = 40;
		
		$pdf->tbSetHeaderType($setcol);
		
		$tipedata = Array();
		for($j=0; $j<$kolom; $j++) $tipedata[$j] = $table_default_kartu_type;
		
		$pdf->tbSetDataType($tipedata);
		
		for($k=0; $k<$kolom; $k++) {
			$padtop[$k] = $table_default_kartu_type;
			$datax1[$k] = $table_default_kartu_type;
			$datax2[$k] = $table_default_kartu_type;
			$datax3[$k] = $table_default_kartu_type;
			$datax4[$k] = $table_default_kartu_type;
		}
		
		//Padding Atas
		$padtop[0]['TEXT'] = "";
		$padtop[0]['COLSPAN'] = 7;
		$padtop[0]['T_SIZE'] = 2;
		$padtop[0]['LN_SIZE'] = 2;
		$padtop[0]['BRD_TYPE'] = 'LRT';
		$pdf->tbDrawData($padtop);
		
		$datax1 = Array();
		$datax1[0]['BRD_TYPE'] = 'L';
		$datax1[0]['TEXT'] = "1.";
		$datax1[0]['T_ALIGN'] = 'R';
		$datax1[1]['TEXT'] = "Asal Tenaga Listrik";
		$datax1[2]['TEXT'] = ":";
		$datax1[3]['TEXT'] = "[    ]";
		$datax1[4]['TEXT'] = "1. PLN";
		$datax1[5]['COLSPAN'] = 2;
		$datax1[5]['BRD_TYPE'] = 'R';
		$datax1[5]['TEXT'] = "2. Non PLN";
		$pdf->tbDrawData($datax1);
		
		//space
		$space = Array();
		$space[0]['LN_SIZE'] = 2;
		$space[0]['COLSPAN'] = 7;
		$space[0]['BRD_TYPE'] = 'LR';
		$pdf->tbDrawData($space);
		
		$data = Array();
		$data[0]['BRD_TYPE'] = 'L';
		$data[0]['TEXT'] = "2.";
		$data[0]['T_ALIGN'] = 'R';
		$data[1]['TEXT'] = "Golongan Tarif";
		$data[2]['TEXT'] = ":";
		$data[3]['TEXT'] = "[    ]";
		$data[4]['TEXT'] = "1. Industri";
		$data[5]['TEXT'] = "2. Rumah Tangga";
		$data[6]['BRD_TYPE'] = 'R';
		$data[6]['TEXT'] = "3. Sosial";
		$pdf->tbDrawData($data);
		
		//space
		$space = Array();
		$space[0]['LN_SIZE'] = 2;
		$space[0]['COLSPAN'] = 7;
		$space[0]['BRD_TYPE'] = 'LR';
		$pdf->tbDrawData($space);
		
		$data = Array();
		$data[0]['BRD_TYPE'] = 'L';
		$data[0]['TEXT'] = "3.";
		$data[0]['T_ALIGN'] = 'R';
		$data[1]['TEXT'] = "Volume";
		$data[2]['TEXT'] = ":";
		$data[3]['TEXT'] = "[    ]";
		$data[4]['TEXT'] = "1. 110 V";
		$data[5]['TEXT'] = "2. 450 V";
		$data[6]['BRD_TYPE'] = 'R';
		$data[6]['TEXT'] = "3. 990 V";
		$pdf->tbDrawData($data);
		
		$data = Array();
		$data[0]['BRD_TYPE'] = 'L';
		$data[0]['TEXT'] = "";
		$data[0]['T_ALIGN'] = 'R';
		$data[1]['TEXT'] = "";
		$data[2]['TEXT'] = "";
		$data[3]['TEXT'] = "";
		$data[4]['TEXT'] = "4. 1600 V";
		$data[5]['TEXT'] = "5. 2200 V";
		$data[6]['BRD_TYPE'] = 'R';
		$data[6]['TEXT'] = "6. > 2200 V";
		$pdf->tbDrawData($data);
		
		
		for($m=0; $m<$kolom; $m++) {
			$bar1[$m] = $table_default_kartu_type;
			$bar2[$m] = $table_default_kartu_type;
			$bar3[$m] = $table_default_kartu_type;
			$bar4[$m] = $table_default_kartu_type;
		}
		
		//space
		$space = Array();
		$space[0]['LN_SIZE'] = 2;
		$space[0]['COLSPAN'] = 7;
		$space[0]['BRD_TYPE'] = 'LR';
		$pdf->tbDrawData($space);
		
		$data = Array();
		$data[0]['BRD_TYPE'] = 'L';
		$data[0]['TEXT'] = "4.";
		$data[0]['T_ALIGN'] = 'R';
		$data[1]['COLSPAN'] = 6;
		$data[1]['BRD_TYPE'] = 'R';
		$data[1]['TEXT'] = "Penggunaan listrik dan setoran yang dilakukan";
		$pdf->tbDrawData($data);
		
		$pdf->tbOuputData();
		
		//Rincian Omzet dan Setoran
		$kol = 7;
		$pdf->tbInitialize($kol, true, true);
		$pdf->tbSetTableType($table_default_kartu_type);
		
		for($a=0; $a<$kol; $a++) 
			$klm[$a] = $table_default_kartu_type;
		
		$klm[0]['WIDTH'] = 5;
		$klm[1]['WIDTH'] = 10;
		$klm[2]['WIDTH'] = 35;
		$klm[3]['WIDTH'] = 55;
		$klm[4]['WIDTH'] = 40;
		$klm[5]['WIDTH'] = 40;
		$klm[6]['WIDTH'] = 5;
		
		$klm[0]['TEXT'] = "";
		$klm[0]['BRD_TYPE'] = 'L';
		$klm[1]['TEXT'] = "No.";
		$klm[1]['T_ALIGN'] = 'C';
		$klm[1]['BRD_TYPE'] = 'LT';
		$klm[2]['TEXT'] = "Tanggal";
		$klm[2]['T_ALIGN'] = 'C';
		$klm[2]['BRD_TYPE'] = 'LT';
		$klm[3]['TEXT'] = "Masa Pajak";
		$klm[3]['T_ALIGN'] = 'C';
		$klm[3]['BRD_TYPE'] = 'LT';
		$klm[4]['TEXT'] = "Jumlah Pajak (Rp)";
		$klm[4]['T_ALIGN'] = 'C';
		$klm[4]['BRD_TYPE'] = 'LT';
		$klm[5]['TEXT'] = "Setoran (Rp)";
		$klm[5]['T_ALIGN'] = 'C';
		$klm[5]['BRD_TYPE'] = 'LT';
		$klm[6]['TEXT'] = "";
		$klm[6]['BRD_TYPE'] = 'LR';
		
		$pdf->tbSetHeaderType($klm);		
		$pdf->tbDrawHeader();
		
		//Table Data Settings
	    $data_type = Array();//reset the array
	    for ($i=0; $i<$kol; $i++) 
	    	$data_type[$i] = $table_default_kartu_type;
	
	    $pdf->tbSetDataType($data_type);
    
		$counter = 1;
		$jumlah_pajak = 0;
		$jumlah_setoran = 0;
		
		if (count($arr_spt) > 0) {
			foreach ($arr_spt as $row) {
				$dat[0]['TEXT'] = "";
				$dat[0]['BRD_TYPE'] = 'L';
				$dat[1]['TEXT'] = "" . $counter . ".";
				$dat[1]['T_ALIGN'] = 'R';
				$dat[1]['BRD_TYPE'] = 'LT';
				$dat[2]['TEXT'] = "" . format_tgl($row['spt_tgl_proses']);
				$dat[2]['T_ALIGN'] = 'C';
				$dat[2]['BRD_TYPE'] = 'LT';
				$dat[3]['TEXT'] = format_tgl($row['spt_periode_jual1'])." s.d ".format_tgl($row['spt_periode_jual2']);
				$dat[3]['BRD_TYPE'] = 'LT';$dat[3]['T_ALIGN'] = 'C';
				$dat[4]['TEXT'] = "" . format_currency($row['spt_pajak']);
				$dat[4]['T_ALIGN'] = 'R';
				$dat[4]['BRD_TYPE'] = 'LT'; 
				$dat[5]['TEXT'] = "" . format_currency($row['setorpajret_jlh_bayar']);
				$dat[5]['T_ALIGN'] = 'R';
				$dat[5]['BRD_TYPE'] = 'LT';
				$dat[6]['TEXT'] = "";
				$dat[6]['BRD_TYPE'] = 'LR';
				
				$pdf->tbDrawData($dat);
				$jumlah_pajak += $row['spt_pajak'];
				$jumlah_setoran += $row['setorpajret_jlh_bayar'];
				
				$counter++;
			}
		} 
		
		for ($i = count($arr_spt); $i < 12; $i++) {
			$dat[0]['TEXT'] = "";
			$dat[0]['BRD_TYPE'] = 'L';
			$dat[1]['TEXT'] = "" . $counter . ".";
			$dat[1]['T_ALIGN'] = 'R';
			$dat[1]['BRD_TYPE'] = 'LT';
			$dat[2]['TEXT'] = "";
			$dat[2]['T_ALIGN'] = 'C';
			$dat[2]['BRD_TYPE'] = 'LT';
			$dat[3]['TEXT'] = "";
			$dat[3]['BRD_TYPE'] = 'LT';$dat[3]['T_ALIGN'] = 'C';
			$dat[4]['TEXT'] = "";
			$dat[4]['T_ALIGN'] = 'R';
			$dat[4]['BRD_TYPE'] = 'LT'; 
			$dat[5]['TEXT'] = "";
			$dat[5]['T_ALIGN'] = 'R';
			$dat[5]['BRD_TYPE'] = 'LT';
			$dat[6]['TEXT'] = "";
			$dat[6]['BRD_TYPE'] = 'LR';
			
			$pdf->tbDrawData($dat);
			$counter++;
		}
		
		$dat[0]['TEXT'] = "";
		$dat[0]['BRD_TYPE'] = 'L';
		$dat[1]['TEXT'] = "J U M L A H";
		$dat[1]['T_ALIGN'] = 'C'; $dat[1]['BRD_TYPE'] = 'LT'; $dat[1]['COLSPAN'] = 3;
		$dat[4]['TEXT'] = format_currency($jumlah_pajak);
		$dat[4]['T_ALIGN'] = 'R';
		$dat[4]['BRD_TYPE'] = 'LT'; 
		$dat[5]['TEXT'] = format_currency($jumlah_setoran);
		$dat[5]['T_ALIGN'] = 'R';
		$dat[5]['BRD_TYPE'] = 'LT';
		$dat[6]['TEXT'] = "";
		$dat[6]['BRD_TYPE'] = 'LR';		
		$pdf->tbDrawData($dat);
		
		for($c=0; $c<$kol; $c++) 
			$ntbl[$c] = $table_default_kartu_type;
		
		$ntbl[0]['TEXT'] = "";
		$ntbl[1]['TEXT'] = "";
		$ntbl[2]['TEXT'] = "";
		$ntbl[3]['TEXT'] = "";
		$ntbl[4]['TEXT'] = "";
		$ntbl[5]['TEXT'] = "";
		$ntbl[6]['TEXT'] = "";
		$ntbl[0]['BRD_TYPE'] = 'L';
		$ntbl[1]['BRD_TYPE'] = 'T';
		$ntbl[2]['BRD_TYPE'] = 'T';
		$ntbl[3]['BRD_TYPE'] = 'T';
		$ntbl[4]['BRD_TYPE'] = 'T';
		$ntbl[5]['BRD_TYPE'] = 'T';
		$ntbl[6]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($ntbl);
		
		//output the table data to the pdf
		$pdf->tbOuputData();
		//End of Rincian Omzet dan Setoran
		
		//Baris Tanda Tangan
		$jkol = 2;
		$pdf->tbInitialize($jkol, true, true);
		$pdf->tbSetTableType($table_default_kartu_type);
		
		for($d=0; $d<$jkol; $d++) $kols[$d] = $table_default_kartu_type;
		
		$kols[0]['WIDTH'] = 95;
		$kols[1]['WIDTH'] = 95;
		
		$pdf->tbSetHeaderType($kols);
		$pdf->tbDrawHeader();
		
		for($e=0; $e<$jkol; $e++) {
			$jarak1[$e] = $table_default_kartu_type;
			$ket1[$e] = $table_default_kartu_type;
			$ket2[$e] = $table_default_kartu_type;
			$ttd[$e] = $table_default_kartu_type;
			$nama[$e] = $table_default_kartu_type;
			$jbtn[$e] = $table_default_kartu_type;
			$nip[$e] = $table_default_kartu_type;
			$jarak2[$e] = $table_default_kartu_type;
		}
		
		$jarak1[0]['TEXT'] = "";
		$jarak1[0]['COLSPAN'] = 3;
		$jarak1[0]['T_SIZE'] = 3;
		$jarak1[0]['LN_SIZE'] = 3;
		$pdf->tbDrawData($jarak1);
		
		$ket1[0]['T_ALIGN'] = 'C';
		$ket1[0]['TEXT'] = "Mengetahui,";
		$ket1[1]['T_ALIGN'] = 'C';
		$ket1[1]['TEXT'] = "Dibuat Oleh,";
		$pdf->tbDrawData($ket1);
		
		$ket2[0]['T_ALIGN'] = 'C';
		$ket2[0]['TEXT'] = "" . $mengetahui['ref_japeda_nama'];
		$ket2[1]['T_ALIGN'] = 'C';
		$ket2[1]['TEXT'] = "" . $dibuat['ref_japeda_nama'];
		$pdf->tbDrawData($ket2);
		
		$ttd[0]['TEXT'] = "";
		$ttd[0]['COLSPAN'] = 2;
		$pdf->tbDrawData($ttd);
		$pdf->tbDrawData($ttd);
		$pdf->tbDrawData($ttd);
		
		$nama[0]['T_ALIGN'] = 'C';
		$nama[0]['TEXT'] = "<nu>  " . $mengetahui['pejda_nama'] . "  </nu>";
		$nama[1]['T_ALIGN'] = 'C';
		$nama[1]['TEXT'] = "<nu>  " . $dibuat['pejda_nama'] . "  </nu>";
		$pdf->tbDrawData($nama);
		
		$jbtn[0]['T_ALIGN'] = 'C';
		$jbtn[0]['TEXT'] = "" . $mengetahui['ref_pangpej_ket'];
		$jbtn[1]['T_ALIGN'] = 'C';
		$jbtn[1]['TEXT'] = "" . $dibuat['ref_pangpej_ket'];
		$pdf->tbDrawData($jbtn);
		
		$nip[0]['T_ALIGN'] = 'C';
		$nip[0]['TEXT'] = "NIP.  " . $mengetahui['pejda_nip'];
		$nip[1]['T_ALIGN'] = 'C';
		$nip[1]['TEXT'] = "NIP.  " . $dibuat['pejda_nip'];
		$pdf->tbDrawData($nip);
	
		$jarak2[0]['TEXT'] = "";
		$jarak2[0]['COLSPAN'] = 2;
		$jarak2[0]['T_SIZE'] = 2;
		$jarak2[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($jarak2);
		
		$pdf->tbOuputData();
		$pdf->tbDrawBorder();
		
		//write to pdf
		$pdf->Output();
	} else {
		echo "Maaf data tidak ditemukan.";
	}
