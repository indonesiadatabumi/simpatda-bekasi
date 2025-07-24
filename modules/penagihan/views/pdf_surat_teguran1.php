<?php 
	
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';

$ar_wp = $model->get_header();
// var_dump($ar_wp);die;
if (!empty($ar_wp)) {
	
	$pdf = new FPDF_TABLE('P','mm','A4'); // Landscape,Legal,Lebar = 335 : Potrait = 190
	$pdf->Open();
	$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
	$pdf->SetMargins(10, 10, 5);     // Margin Left, Top, Right 2 cm

	foreach ($ar_wp as $k => $v) {		
		//prepare data
		$detail = $model->get_detail($v['npwprd']);
		// var_dump($detail);die;
		$nomor_surat = $model->get_no_surat_teguran();

		//arr data into db
		$arr_insert = array();
		$arr_insert['st_tgl'] = format_tgl($_GET['tgl_cetak']);
		$arr_insert['st_wp_id'] = $v['wp_wr_id'];
		$arr_insert['st_nomor'] = $nomor_surat;
		
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
		$title = ucwords($v['ketspt_ket']);
		$s_title = strtoupper($v['ketspt_singkat']); 
		
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
		$idn[2]['WIDTH'] = 80;
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
		$tbd[2]['TEXT'] = "      Kepada";$tbd[2]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";		
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "";
		$tbd[2]['TEXT'] = "Yth.  ".strtoupper($v['wp_wr_nama']); 
		$tbd[2]['T_SIZE'] = 8;
		$tbd[2]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "";
		$tbd[2]['TEXT'] = "         di  ".strtoupper($v['wp_wr_almt']); 
		$tbd[2]['T_SIZE'] = 7;
		$tbd[2]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";	
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "";
		$tbd[2]['TEXT'] = "          KEL. ".strtoupper($v['wp_wr_lurah']." KEC. ".$v['wp_wr_camat'])." - BEKASI"; 
		$tbd[2]['T_SIZE'] = 7;
		$tbd[2]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";	
		$pdf->tbDrawData($tbd);
	/**
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "";
		$tbd[2]['TEXT'] = "       di ".strtoupper(ereg_replace("\r|\n","",$v[wp_wr_almt])); 
		$tbd[2]['T_SIZE'] = 8;
		$tbd[2]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";	
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "";
		$tbd[2]['TEXT'] = "       KEL. ".strtoupper($v[wp_wr_lurah]); 
		$tbd[2]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";	
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "";
		$tbd[2]['TEXT'] = "       KEC. ".strtoupper($v[wp_wr_camat]); 
		$tbd[2]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";	
		$pdf->tbDrawData($tbd);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "";
		$tbd[2]['TEXT'] = "        BEKASI"; 
		$tbd[2]['T_SIZE'] = 8;
		$tbd[2]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";	
		$pdf->tbDrawData($tbd);
		*/
		$pdf->tbDrawData($spc);
		$pdf->tbDrawData($spc);
	
		$dt[0]['TEXT'] = "";
		$dt[1]['TEXT'] = "S U R A T   T E G U R A N";$dt[1]['COLSPAN'] = 2;
		$dt[1]['T_ALIGN'] = "C";$dt[1]['T_SIZE'] = 12;$dt[1]['T_TYPE'] = "UB";
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
		$tbd[1]['TEXT'] = "Berdasarkan Catatan Pembukuan kami, sampai saat ini Saudara masih mempunyai Piutang/Tunggakan Pajak Daerah sebagai berikut : ";$tbd[1]['COLSPAN'] = 2;
		$tbd[1]['T_ALIGN'] = "L";
		$tbd[3]['TEXT'] = "";	
		$pdf->tbDrawData($tbd);		
		$pdf->tbOuputData();
		
		//Table
		$klm = 7;
		$pdf->tbInitialize($klm,true,true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($d=0;$d<$klm;$d++) $tabel[$d] = $table_default_header_type;
		
		for($d=0;$d<$klm;$d++) {
			$tc[$d] = $table_default_datax_type;
		}
		$tc[0]['WIDTH'] = 2;
		$tc[1]['WIDTH'] = 43;
		$tc[2]['WIDTH'] = 15;
		$tc[3]['WIDTH'] = 70;
		$tc[4]['WIDTH'] = 25;
		$tc[5]['WIDTH'] = 30;	
		$tc[6]['WIDTH'] = 5;	
		$pdf->tbSetHeaderType($tc);
		
		for($e=0;$e<$klm;$e++) {
			$th[$e] = $table_default_tblheader_type;
			$td[$e] = $table_default_tbldata_type;
			$tl[$e] = $table_default_tbldata_type;
			$tx[$e] = $table_default_tbldata_type;
		}
		
		//Table Header
		$th[0]['TEXT'] = "";
		$th[1]['TEXT'] = "Jenis Pajak Daerah";
		$th[2]['TEXT'] = "Tahun";
		$th[3]['TEXT'] = "Nomor & Tanggal SPTPD, SKPD, SKPDT, SKPDKB, SKPDKBT, STPD, SK. Keberatan, SK. Pembetulan, SK. Putusan Banding *)";
		$th[4]['TEXT'] = "Tanggal Jatuh Tempo";
		$th[5]['TEXT'] = "Jumlah Tunggakan Rp.";
		$th[6]['TEXT'] = "";
		$th[1]['BRD_TYPE'] = 'LT';$th[1]['T_SIZE'] = 9;$th[1]['T_TYPE'] = "B";$th[2]['BRD_TYPE'] = 'LT';$th[2]['T_SIZE'] = 9;$th[2]['T_TYPE'] = "B";
		$th[3]['BRD_TYPE'] = 'LT';$th[3]['T_SIZE'] = 9;$th[3]['T_TYPE'] = "B";$th[4]['BRD_TYPE'] = 'LT';$th[4]['T_SIZE'] = 9;$th[4]['T_TYPE'] = "B";
		$th[5]['BRD_TYPE'] = 'LT';$th[5]['T_SIZE'] = 9;$th[5]['T_TYPE'] = "B";
		$th[6]['BRD_TYPE'] = 'L';
		$pdf->tbDrawData($th);		

		$td[1]['BRD_TYPE'] = 'LT';
		$td[2]['BRD_TYPE'] = 'LT';
		$td[3]['BRD_TYPE'] = 'LT';
		$td[4]['BRD_TYPE'] = 'LT';
		$td[5]['BRD_TYPE'] = 'LT';
		$td[6]['BRD_TYPE'] = 'L';
		$td[2]['T_ALIGN'] = 'C';
		$td[4]['T_ALIGN'] = 'C';
		$td[5]['T_ALIGN'] = 'R';
		
		// print_r($v);

		//Bagian datanya...
		if (!empty($detail)) {
		//	$new_line = "\n\n\n\n\n";
		$new_line = "\n\n";
			
			$total_denda = 0;
			$total_kenaikan = 0;
			$total_bunga = 0;
			
			foreach ($detail as $key => $val) {
				$total_bunga += $val['spt_dt_bunga'];
				$total_denda += $val['spt_dt_denda'];
				$total_kenaikan += $val['spt_dt_kenaikan'];
				//$total_pajak += $val['spt_dt_pajak'];
				$total_pajak += $val['spt_pajak'];

				$pajak = 0;
				if ($val['ketspt_singkat'] == "STPD") {
					$pajak = $val['spt_pajak'];
				} else 
					$pajak = $val['spt_pajak'] + $total_bunga + $total_denda + $total_kenaikan;
				
				$td[0]['TEXT'] = "";
				// $td[1]['TEXT'] = $val['jenis_pajak'];
				$td[1]['TEXT'] = $val['ref_jenparet_ket'];		
				$td[2]['TEXT'] = $val['spt_periode'];

				$bulan=substr($val['spt_periode_jual1'],5,2);
				if ($bulan=='1'){$nmbln='Januari';}
					else if  ($bulan=='2'){$nmbln='Februari';}
					else if ($bulan=='3'){$nmbln='Maret';}
					else if ($bulan=='4'){$nmbln='April';}
					else if ($bulan=='5'){$nmbln='Mei';}
					else if ($bulan=='6'){$nmbln='Juni';}
					else if ($bulan=='7'){$nmbln='Juli';}
					else if ($bulan=='8'){$nmbln='Agustus';}
					else if ($bulan=='9'){$nmbln='September';}
					else if ($bulan=='10'){$nmbln='Oktober';}
					else if ($bulan=='11'){$nmbln='November';}
					else if ($bulan=='12'){$nmbln='Desember';}

				$td[3]['TEXT'] = $val['ketspt_singkat']." - Nomor ".$val['spt_nomor']."  Masa Pajak ".$nmbln."  ".substr($val['spt_periode_jual1'],0,4) ;
				if ($val['ketspt_singkat'] == "STPD") {
					if ($total_bunga > 0) $td[3]['TEXT'] .= "\nBunga ";
				}
				$td[3]['TEXT'] .= $new_line;

				$tanggal = $val['spt_periode_jual1'];
				$jatuh_tempo = date('Y-m-d', strtotime('+30 days', strtotime($tanggal))); 
				
				// $td[4]['TEXT'] = format_tgl($val['jatuh_tempo']);
				$td[4]['TEXT'] = format_tgl($jatuh_tempo);
				$td[5]['TEXT'] = format_currency($pajak);
				if ($val['ketspt_singkat'] == "STPD") {
					if ($total_bunga > 0) $td[5]['TEXT'] .= "\n".format_currency($total_bunga);
				}
				
				$td[6]['TEXT'] = "";
				
				$pdf->tbDrawData($td);
			}
						
			//data surat teguran
			$arr_insert['st_spt_id'] = $detail[0]['spt_id'];
			$arr_insert['st_jenis_pajak_id'] = $detail[0]['spt_jenis_pajakretribusi'];
			$arr_insert['st_spt_periode'] = $detail[0]['spt_periode'];
			$arr_insert['st_jenis_ketetapan'] = $detail[0]['ketspt_id'];
			$arr_insert['st_uraian'] = $detail[0]['ketspt_singkat']." - Nomor ".$detail[0]['spt_nomor']."  Tanggal ".format_tgl($detail[0]['spt_periode_jual1']);
			$arr_insert['st_tgl_jatuh_tempo'] = $detail[0]['jatuh_tempo'];
			$arr_insert['st_jumlah'] = $pajak;
			$arr_insert['st_pejabat_ttd'] = $_GET['pejabat'];
			$arr_insert['st_dibuat_oleh'] = $this->session->userdata('USER_ID');
			$arr_insert['st_dibuat_tgl'] = "now()";
			$model->insert($arr_insert);
		} 
		
		//Bagian Jumlah...
		// $total_pajak = 0;
		$tl[0]['TEXT'] = "";
		$tl[1]['TEXT'] = "";
		$tl[3]['TEXT'] = "";
		$tl[4]['TEXT'] = "Jumlah";
		if ($detail[0]['ketspt_singkat'] == "STPD") {
			$total_pajak = $total_pajak + $total_bunga + $total_denda + $total_kenaikan;
		}
		else 
			$total_pajak = $total_pajak;

		$tl[5]['TEXT'] = format_currency($total_pajak);
			
		$tl[6]['TEXT'] = "";
		$tl[1]['COLSPAN'] = 2;
		$tl[1]['BRD_TYPE'] = 'T';$tl[3]['BRD_TYPE'] = 'T';$tl[4]['BRD_TYPE'] = 'LBT';$tl[5]['BRD_TYPE'] = 'LTB';$tl[6]['BRD_TYPE'] = 'L';
		$tl[4]['T_ALIGN'] = 'C';$tl[5]['T_ALIGN'] = 'R';
		$pdf->tbDrawData($tl);
		
		$tl[0]['TEXT'] = "";
		$tl[1]['TEXT'] = "";
		$tl[3]['TEXT'] = "";
		$tl[4]['TEXT'] = "";
		$tl[5]['TEXT'] = "";			
		$tl[6]['TEXT'] = "";
		$tl[0]['BRD_TYPE'] = '';$tl[1]['BRD_TYPE'] = '';$tl[2]['BRD_TYPE'] = '';$tl[3]['BRD_TYPE'] = '';$tl[4]['BRD_TYPE'] = 'T';$tl[5]['BRD_TYPE'] = 'T';$tl[6]['BRD_TYPE'] = '';
		$tl[0]['LN_SIZE'] = 1;$tl[1]['LN_SIZE'] = 1;$tl[2]['LN_SIZE'] = 1;$tl[3]['LN_SIZE'] = 1;$tl[4]['LN_SIZE'] = 1;$tl[5]['LN_SIZE'] = 1;$tl[6]['LN_SIZE'] = 1;
		$pdf->tbDrawData($tl);
		
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
		$dg[1]['TEXT'] = "Dengan huruf :";
		$dg[2]['TEXT'] = "( ". ucwords(strtolower(terbilang($total_pajak). " Rupiah"))." )";
		$dg[3]['TEXT'] = "";
		$dg[1]['BRD_TYPE'] = '0';$dg[2]['BRD_TYPE'] = '';
		$pdf->tbDrawData($dg);
		
		$dt[0]['TEXT'] = "";
		$dt[1]['TEXT'] = "Untuk mencegah tindakan penagihan dengan Surat Panggilan berdasarkan peraturan Daerah nomor 11 Tahun 2016 tentang Ketentuan umum pajak daerah, maka diminta kepada Saudara agar melunasi jumlah Piutang/Tunggakan dalam waktu 7 (tujuh) hari setalah tanggal Surat Teguran ini sesuai peraturan perundang-undangan.\n\n";
		$dt[1]['COLSPAN'] = 2;$dt[1]['LN_SIZE'] = 4;$dt[1]['T_ALIGN'] = 'J';
		$dt[3]['TEXT'] = "";
		$dt[1]['BRD_TYPE'] = '0';$dt[2]['BRD_TYPE'] = '';
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";
		$dt[1]['TEXT'] = "Dalam hal Saudara telah melunasi Piutang/Tunggakan tersebut diatas, surat teguran ini dapat diabaikan dan diminta agar saudara segera melaporkan bukti pembayaran kepada kami (Bidang Pengawasan dan Pengendalian Pajak Daerah pada badan Pendapatan Daerah Kota Bekasi).\n\n\n";
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
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "CATATAN";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "BEKASI, ".strtoupper(format_tgl($_GET['tgl_cetak'],false,true));
		$dt[1]['T_ALIGN'] = "C";$dt[3]['T_SIZE']=8;$dt[3]['T_ALIGN'] = "L";
		$dt[1]['BRD_TYPE'] = 'LT';$dt[2]['BRD_TYPE'] = 'L';
		$dt[0]['LN_SIZE'] = 8;$dt[1]['LN_SIZE'] = 8;$dt[2]['LN_SIZE'] = 5;$dt[3]['LN_SIZE'] = 5;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "Apabila sampai dengan batas waktu 7 (tujuh) hari ";
		$dt[2]['TEXT'] = "";$dt[3]['TEXT'] =  $dt[3]['TEXT'] = $pejabat->ref_japeda_nama; //"Plt. KEPALA BADAN PENDAPATAN DAERAH";
		$dt[1]['T_ALIGN'] = "L"; $dt[3]['T_ALIGN'] = "L";
		$dt[1]['BRD_TYPE'] = 'L';$dt[2]['BRD_TYPE'] = 'L';
		$dt[0]['LN_SIZE'] = 4;$dt[1]['LN_SIZE'] = 4;$dt[2]['LN_SIZE'] = 4;$dt[3]['LN_SIZE'] = 4;
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = " setelah tanggal surat teguran ini belum melunasi pembayaran maka akan diterbitkan Surat Panggilan (Peraturan Daerah Kota Bekasi Nomor 11 tahun 2016, BAB VI Penagihan, Bagian Kesatu ";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";
		$dt[1]['BRD_TYPE'] = 'L';$dt[2]['BRD_TYPE'] = 'L';
		$pdf->tbDrawData($dt);
		
		//$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "Surat Teguran Pajak Daerah, pasal 18)";$dt[2]['TEXT'] = "  ";$dt[3]['TEXT'] = "                            ~ "; //$dt[3]['TEXT'] = "       ".$pejabat->pejda_nama;
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "Surat Teguran Pajak Daerah, pasal 18)";$dt[2]['TEXT'] = "  ";$dt[3]['TEXT'] = " ".$pejabat->pejda_nama;
		$dt[1]['T_ALIGN'] = "L";$dt[3]['T_TYPE']='';$dt[3]['T_ALIGN'] = "L";
		$dt[1]['BRD_TYPE'] = 'L';$dt[2]['BRD_TYPE'] = 'L';
		$pdf->tbDrawData($dt);
		
		//$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "     ";//$dt[3]['TEXT'] = "     ".$pejabat->pejda_nip;
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = " NIP. ".$pejabat->pejda_nip;
		$dt[1]['T_ALIGN'] = "L";$dt[3]['T_TYPE']=''; $dt[3]['T_ALIGN'] = "L";
		$dt[1]['BRD_TYPE'] = 'T';$dt[2]['BRD_TYPE'] = '';
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "*) Coret yang tidak perlu";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";$dt[3]['T_TYPE']='';
		$dt[1]['BRD_TYPE'] = '';$dt[2]['BRD_TYPE'] = '';
		$pdf->tbDrawData($dt);
		
		$dt[0]['TEXT'] = "";$dt[1]['TEXT'] = "MODEL : DPD-29";$dt[2]['TEXT'] = "";$dt[3]['TEXT'] = "";
		$dt[1]['T_ALIGN'] = "L";$dt[1]['T_SIZE']=7;
		$pdf->tbDrawData($dt);
		
		$pdf->tbOuputData();
		
		//Logo logo-kotabekasi.jpg
		//$logo = "assets/". $pemda->dapemda_logo_path;
	  //  $logo = 'assets/images/kotabekasi.jpg';
	$pdf->Image('assets/images/logo-kotabekasi.jpg',11,13,14);
		//$pdf->Image($logo,11,13,14);
		
    // Line break
    $pdf->Ln(20);
	}
	
	$pdf->Output();
} else {
	echo "<script type='text/javascript'>alert('Data tidak ditemukan.');</script>";
}



?>