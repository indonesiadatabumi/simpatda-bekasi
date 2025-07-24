<?php 
	
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';

$ar_wp = $model->get_header();
if (!empty($ar_wp)) {
	
	$pdf = new FPDF_TABLE('P','mm','A4'); // Landscape,Legal,Lebar = 335 : Potrait = 190
	$pdf->Open();
	$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
	$pdf->SetMargins(10, 10, 10);     // Margin Left, Top, Right 2 cm

	foreach ($ar_wp as $k => $v) {		
		//prepare data
		$detail = $model->get_detail($v['wp_wr_id']);
		$nomor_surat = $model->get_no_surat_teguran();
		

		//arr data into db
		$arr_insert = array();
		$arr_insert['st_tgl'] = format_tgl($_GET['tgl_cetak']);
		$arr_insert['st_wp_id'] = $v['wp_wr_id'];
		$arr_insert['st_nomor'] = $nomor_surat;
		
		$masa=$_GET['bulan'];
		if($masa==1){$masa_pajak='Januari';}
		else if ($masa==2){$masa_pajak='Februari';}
		else if ($masa==3){$masa_pajak='Maret';}
		else if ($masa==4){$masa_pajak='April';}
		else if ($masa==5){$masa_pajak='Mei';}
		else if ($masa==6){$masa_pajak='Juni';}
		else if ($masa==7){$masa_pajak='Juli';}
		else if ($masa==8){$masa_pajak='Agustus';}
		else if ($masa==9){$masa_pajak='September';}
		else if ($masa==10){$masa_pajak='Oktober';}
		else if ($masa==11){$masa_pajak='November';}
		else if ($masa==12){$masa_pajak='Desember';}
	
	
		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		//set style
		$pdf->SetStyle("sb","arial","B",8,"0,0,0");
		$pdf->SetStyle("ns","arial","",7,"0,0,0");
		$pdf->SetStyle("b","arial","B",9,"0,0,0");
		$pdf->SetStyle("i","arial","I",7,"0,0,0");
		$pdf->SetStyle("h1","arial","B",9,"0,0,0");
		$pdf->SetStyle("h2","arial","B",7,"0,0,0");
		$pdf->SetStyle("h3","arial","B",11,"0,0,0");
		$pdf->SetStyle("nu","arial","U",9,"0,0,0");
		$pdf->SetStyle("cut","arial","I",8,"170,170,170");
		$pdf->SetStyle("th1","arial","B",8,"0,0,0");
		
		$infopemda = "<th1>PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2)."</th1>\n".
		        "<th1>".strtoupper($pemda->nama_dinas)."</th1>\n".$pemda->dapemda_lokasi."\n".
				"Telp. ".$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax."\n<th1>".strtoupper($pemda->dapemda_nm_dati2)."</th1>";
	//	$title = ucwords($v['ketspt_ket']);
	//	$s_title = strtoupper($v['ketspt_singkat']); 
		
		$kol = 3;
		$pdf->tbInitialize($kol, true, true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($a=0;$a<$kol;$a++) $hdrx[$a] = $table_default_header_type;
		
		for($a=0; $a<$kol; $a++) {
			$spacer1[$a] = $table_default_datax_type;
			$header[$a] = $table_default_headerx_type;
			$spacer2[$a] = $table_default_datax_type;
		}
		
		$spacer1[0]['WIDTH'] = 15;
		$spacer1[1]['WIDTH'] = 170;
		$spacer1[2]['WIDTH'] = 5;
		$spacer1[0]['TEXT'] = "";$spacer1[1]['TEXT'] = "";$spacer1[2]['TEXT'] = "";;
		$spacer1[0]['LN_SIZE'] = 3;$spacer1[1]['LN_SIZE'] = 3;$spacer1[2]['LN_SIZE'] = 3;
		
		$header[0]['TEXT'] = "";
		$header[1]['TEXT'] = $infopemda;
		$header[2]['TEXT'] = "";
		$header[1]['T_ALIGN'] = 'L';
		$header[1]['T_SIZE'] = 6;
		$header[1]['LN_SIZE'] = 3;
		
		$spacer2[0]['TEXT'] = "";
		$spacer2[1]['TEXT'] = "";
		$spacer2[2]['TEXT'] = "";
		$spacer2[0]['LN_SIZE'] = 3;$spacer2[1]['LN_SIZE'] = 3;$spacer2[2]['LN_SIZE'] = 3;
		
		$arHeader = array($spacer1,$header,$spacer2);
		$pdf->tbSetHeaderType($arHeader,true);
		
		$pdf->tbDrawHeader();
		$pdf->tbOuputData();
		
		//NPWPD
		$kolom = 4;
		$pdf->tbInitialize($kolom, true, true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($b=0;$b<$kolom;$b++) $jkl[$b] = $table_default_headerx_type;
		
		for($b=0;$b<$kolom;$b++) {
			$idn[$b] = $table_default_headerx_type;
		}
		$idn[0]['WIDTH'] = 1;
		$idn[1]['WIDTH'] = 119;
		$idn[2]['WIDTH'] = 65;
		$idn[3]['WIDTH'] = 5;
		$pdf->tbSetHeaderType($idn);
		
		for($c=0;$c<$kolom;$c++) {
			$spc[$c] = $table_default_datax_type;
			$tbd[$c] = $table_default_datax_type;
			$dt[$c] = $table_default_datax_type;
		}
		$spc[0]['TEXT'] = "";
		$spc[0]['COLSPAN'] = 4;
		$spc[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($spc);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "NPWPD	:	".strtoupper($v['npwprd']);
		$tbd[2]['TEXT'] = "";
		$tbd[3]['TEXT'] = "";
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "";
		$tbd[2]['TEXT'] = "Kepada";$tbd[2]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";		
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "";
		$tbd[2]['TEXT'] = "Yth. ".strtoupper($v['wp_wr_nama']); 
		$tbd[2]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "";
		$tbd[2]['TEXT'] = "di ".strtoupper(ereg_replace("\r|\n","",$v[wp_wr_almt]))." KEL. ".strtoupper($v[wp_wr_lurah]." KEC. ".$v[wp_wr_camat])." - BEKASI"; 
		$tbd[2]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";	
		$pdf->tbDrawData($tbd);
		
		$pdf->tbDrawData($spc);
		$pdf->tbDrawData($spc);
		
		$dt[0]['TEXT'] = "";
		$dt[1]['TEXT'] = "S U R A T   T E G U R A N";$dt[1]['COLSPAN'] = 2;
		$dt[1]['T_ALIGN'] = "C";$dt[1]['T_SIZE'] = 12;$dt[1]['T_TYPE'] = "B";
		$dt[3]['TEXT'] = "";	
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";
		$dt[1]['TEXT'] = "";$dt[1]['COLSPAN'] = 2;
		$dt[1]['T_ALIGN'] = "C";$dt[1]['T_SIZE'] = 12;$dt[1]['T_TYPE'] = "B";
		$dt[3]['TEXT'] = "";	
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";
		$dt[1]['TEXT'] = "UNTUK MEMASUKAN SPTPD";$dt[1]['COLSPAN'] = 2;
		$dt[1]['T_ALIGN'] = "C";$dt[1]['T_SIZE'] = 10;$dt[1]['T_TYPE'] = "B";
		$dt[3]['TEXT'] = "";	
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";
		$dt[1]['TEXT'] = "NOMOR : ".strtoupper($nomor_surat);$dt[1]['COLSPAN'] = 2;
		$dt[1]['T_ALIGN'] = "C";$dt[1]['T_SIZE'] = 8;$dt[1]['T_TYPE'] = "B";
		$dt[3]['TEXT'] = "";	
		$pdf->tbDrawData($dt);
		
		$pdf->tbDrawData($spc);
		$pdf->tbDrawData($spc);
		$pdf->tbDrawData($spc);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "
		Berdasarkan catatan kami, ternyata sampai saat ini Saudara belum memasukan Surat Pemberitahuan Pajak Daerah Masa Pajak ".$masa_pajak." ".$_GET['tahun']." Maka dengan ini kami minta agar saudara menyerahkan SPTPD paling lambat 7 (tujuh)hari setelah menerima Surat ini.";$tbd[1]['COLSPAN'] = 2;
		$tbd[1]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";	
		$pdf->tbDrawData($tbd);		
		$pdf->tbOuputData();
	

	///Bagian Dengan huruf...
		$kol = 4;
		$pdf->tbInitialize($kol,true,true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($i=0;$i<$kol;$i++) $setw[$i] = $table_default_header_type;
		
		for($i=0;$i<$kol;$i++) {
			$wid[$i] = $table_default_header_type;
		}
		$wid[0]['WIDTH'] = 1;$wid[1]['WIDTH'] = 27;$wid[2]['WIDTH'] = 153;$wid[3]['WIDTH'] = 5;
		
		$pdf->tbSetHeaderType($wid);
		
		for($i=0;$i<$kol;$i++) {
			$dg[$i] = $table_default_tbldata_type;
			$dt[$i] = $table_default_tbldata_type;
		}
		$dg[0]['TEXT'] = "";
		$dg[1]['TEXT'] = "";
		$dg[2]['TEXT'] = "";
		$dg[3]['TEXT'] = "";
		$dg[1]['BRD_TYPE'] = '0';$dg[2]['BRD_TYPE'] = '';
		$pdf->tbDrawData($dg);
		
		$dt[0]['TEXT'] = "";
		$dt[1]['TEXT'] = "
		Apabila Surat Teguran ini tidak juga Saudara indahkan, Maka kami akan melakukan Penetapan Atas Objek Pajak yang Saudara miliki secara Jabatan, yang akan merugikan Saudara sendiri.";
		
		$dt[1]['COLSPAN'] = 2;$dt[1]['LN_SIZE'] = 4;$dt[1]['T_ALIGN'] = 'J';
		$dt[3]['TEXT'] = "";
		$dt[1]['BRD_TYPE'] = '0';$dt[2]['BRD_TYPE'] = '';
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";
		$dt[1]['TEXT'] = "
		Untuk menjadi perhatian Saudara, agar kewajiban Saudara dapat dipenuhi sebagai mana mestinya.\n\n\n";
		$dt[1]['COLSPAN'] = 2;$dt[1]['LN_SIZE'] = 4;
		$dt[3]['TEXT'] = "";
		$dt[1]['BRD_TYPE'] = '0';$dt[2]['BRD_TYPE'] = '';
		$pdf->tbDrawData($dt);
		
		$pdf->tbOuputData();
		
		//Bagian Tanda Tangan
		$kol = 5;
		$pdf->tbInitialize($kol,true,true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($i=0;$i<$kol;$i++) $setw[$i] = $table_default_header_type;
		
		for($i=0;$i<$kol;$i++) {
			$wid[$i] = $table_default_header_type;
		}
		$wid[0]['WIDTH'] = 3;
		$wid[1]['WIDTH'] = 50;
		$wid[2]['WIDTH'] = 64;
		$wid[3]['WIDTH'] = 80;
		$wid[4]['WIDTH'] = 5;
		
		$pdf->tbSetHeaderType($wid);
		
		for($i=0;$i<$kol;$i++) {
			$jarak[$i] = $table_data_ketetapan_type;
			$dt[$i] = $table_data_small;
		}
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "BEKASI, ".strtoupper(format_tgl($_GET['tgl_cetak'],false,true));
		$dt[1]['T_ALIGN'] = "C";$dt[3]['T_SIZE']=8;
	//	$dt[1]['BRD_TYPE'] = 'LT';$dt[2]['BRD_TYPE'] = 'L'; // garis tabel
		$dt[0]['LN_SIZE'] = 8;$dt[1]['LN_SIZE'] = 8;$dt[2]['LN_SIZE'] = 8;$dt[3]['LN_SIZE'] = 8;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";
		$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "a.n. Kepala Badan Pendapatan Daerah";
		$dt[1]['T_ALIGN'] = "L";
	//	$dt[1]['BRD_TYPE'] = 'L';$dt[2]['BRD_TYPE'] = 'L'; // garis tabel
		$dt[0]['LN_SIZE'] = 4;$dt[1]['LN_SIZE'] = 4;$dt[2]['LN_SIZE'] = 4;$dt[3]['LN_SIZE'] = 4;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";
		$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = $pejabat->ref_japeda_nama;
		$dt[1]['T_ALIGN'] = "L";
	//	$dt[1]['BRD_TYPE'] = 'L';$dt[2]['BRD_TYPE'] = 'L'; // garis tabel
		$dt[0]['LN_SIZE'] = 4;$dt[1]['LN_SIZE'] = 4;$dt[2]['LN_SIZE'] = 4;$dt[3]['LN_SIZE'] = 4;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";
	//	$dt[1]['BRD_TYPE'] = 'L';$dt[2]['BRD_TYPE'] = 'L'; // garis tabel
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";
	//	$dt[1]['BRD_TYPE'] = 'L';$dt[2]['BRD_TYPE'] = 'L'; // garis tabel
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";
	//	$dt[1]['BRD_TYPE'] = 'L';$dt[2]['BRD_TYPE'] = 'L'; // garis tabel
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";
	//	$dt[1]['BRD_TYPE'] = 'L';$dt[2]['BRD_TYPE'] = 'L'; // garis tabel
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = $pejabat->pejda_nama;
		$dt[1]['T_ALIGN'] = "L";$dt[3]['T_TYPE']='U';
	//	$dt[1]['BRD_TYPE'] = 'L';$dt[2]['BRD_TYPE'] = 'L';  // garis tabel
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = $pejabat->pejda_nip;
		$dt[1]['T_ALIGN'] = "L";$dt[3]['T_TYPE']='';
	//	$dt[1]['BRD_TYPE'] = 'T';$dt[2]['BRD_TYPE'] = ''; // garis tabel
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";$dt[3]['T_TYPE']='';
	// 	$dt[1]['BRD_TYPE'] = '';$dt[2]['BRD_TYPE'] = ''; // garis tabel
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "Model : DPD-06";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";$dt[1]['T_SIZE']=7;
		$pdf->tbDrawData($dt);


		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "-------------------------------------------------------------------------------------------------------- gunting disini---------------------------------------------------------------------------------------------------------------------";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['COLSPAN'] = 4;$dt[1]['LN_SIZE'] = 4;
		$dt[1]['T_ALIGN'] = "L";$dt[1]['T_SIZE']=7;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";
		$dt[1]['TEXT'] = "TANDA TERIMA";$dt[1]['COLSPAN'] = 4;
		$dt[1]['T_ALIGN'] = "C";$dt[1]['T_SIZE'] = 10;$dt[1]['T_TYPE'] = "B";
		$dt[3]['TEXT'] = "";	
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['COLSPAN'] = 4;$dt[1]['LN_SIZE'] = 4;
		$dt[1]['T_ALIGN'] = "L";$dt[1]['T_SIZE']=7;
		$pdf->tbDrawData($dt);
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['COLSPAN'] = 4;$dt[1]['LN_SIZE'] = 4;
		$dt[1]['T_ALIGN'] = "L";$dt[1]['T_SIZE']=7;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "NPWPD	  : ".strtoupper($v['npwprd']);$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['COLSPAN'] = 4;$dt[1]['LN_SIZE'] = 4;
		$dt[1]['T_ALIGN'] = "L";$dt[1]['T_SIZE']=7;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "NAMA	    : ".strtoupper($v['wp_wr_nama']);$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['COLSPAN'] = 4;$dt[1]['LN_SIZE'] = 4;
		$dt[1]['T_ALIGN'] = "L";$dt[1]['T_SIZE']=7;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "ALAMAT              : ".strtoupper(ereg_replace("\r|\n","",$v[wp_wr_almt]))." KEL. ".strtoupper($v[wp_wr_lurah]." KEC. ".$v[wp_wr_camat])."";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['COLSPAN'] = 4;$dt[1]['LN_SIZE'] = 4;
		$dt[1]['T_ALIGN'] = "L";$dt[1]['T_SIZE']=7;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "BEKASI, ".strtoupper(format_tgl($_GET['tgl_cetak'],false,true));
		$dt[1]['T_ALIGN'] = "C";$dt[3]['T_SIZE']=8;
		$dt[0]['LN_SIZE'] = 8;$dt[1]['LN_SIZE'] = 8;$dt[2]['LN_SIZE'] = 8;$dt[3]['LN_SIZE'] = 8;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";
		$dt[1]['COLSPAN'] = 2;$dt[1]['LN_SIZE'] = 4;
		$dt[1]['T_ALIGN'] = "R";$dt[1]['T_SIZE']=7;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "Yang Menerima";$dt[1]['T_ALIGN'] = "L";
		$dt[0]['LN_SIZE'] = 4;$dt[1]['LN_SIZE'] = 4;$dt[2]['LN_SIZE'] = 4;$dt[3]['LN_SIZE'] = 4;
		$pdf->tbDrawData($dt);
		
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] =".................................";
		$dt[1]['T_ALIGN'] = "L";$dt[3]['T_TYPE']='U';
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";$dt[3]['T_TYPE']='';
	// 	$dt[1]['BRD_TYPE'] = '';$dt[2]['BRD_TYPE'] = ''; // garis tabel
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "Model : DPD-06";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";$dt[1]['T_SIZE']=7;
		$pdf->tbDrawData($dt);
		$pdf->tbOuputData();
		
		//Logo
		$logo = "assets/". $pemda->dapemda_logo_path;
		$pdf->Image($logo,11,13,14);
	}
	
	$pdf->Output();
} 

else {
	echo "<script type='text/javascript'>alert('Data tidak ditemukan.');</script>";
}



?>