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

$pdf = new FPDF_TABLE('P','mm','Letter'); // Landscape,Legal,Lebar = 335
$pdf->Open();
$pdf->SetAutoPageBreak(true, 10); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(15, 10, 10);     // Margin Left, Top, Right 2 cm


$arr_data = $model->call_npwpd_tetap();

if (!empty($arr_data)) {
	foreach ($arr_data as $k1 => $v1) {
		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		//prepare data
		$data_skpd = $model->call_v_nota_perhitungan($v1['spt_id']);
		//print_r($data_skpd);
		
		//set style
		$pdf->SetStyle("sb","arial","B",8,"0,0,0");
		$pdf->SetStyle("ns","arial","",7,"0,0,0");
		$pdf->SetStyle("b","arial","B",9,"0,0,0");
		$pdf->SetStyle("h1","arial","B",10,"0,0,0");
		$pdf->SetStyle("h2","arial","B",9,"0,0,0");
		$pdf->SetStyle("h3","arial","B",11,"0,0,0");
		$pdf->SetStyle("nu","arial","U",9,"0,0,0");
		$pdf->SetStyle("cut","arial","I",8,"170,170,170");
		$pdf->SetStyle("th1","arial","B",8,"0,0,0");
		
		$infopemda = "<th1>PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2)."</th1>\n".
		        "<th1>".strtoupper($pemda->nama_dinas)."</th1>\n".$pemda->dapemda_lokasi."\n".
				"Telp. ".$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax."\n<th1>".strtoupper($pemda->dapemda_nm_dati2)."</th1>";
		$title = ucwords($data_skpd[0]['ketspt_ket']);
		$s_title = strtoupper($data_skpd[0]['ketspt_singkat']); 
		
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
		
		$spacer1[0]['WIDTH'] = 15;$spacer1[1]['WIDTH'] = 50;$spacer1[2]['WIDTH'] = 3;$spacer1[3]['WIDTH'] = 90;$spacer1[4]['WIDTH'] = 2;$spacer1[5]['WIDTH'] = 30;
		$spacer1[0]['TEXT'] = "";$spacer1[1]['TEXT'] = "";$spacer1[2]['TEXT'] = "";$spacer1[3]['TEXT'] = "";$spacer1[4]['TEXT'] = "";$spacer1[5]['TEXT'] = "";
		$spacer1[0]['BRD_TYPE'] = 'LT';$spacer1[1]['BRD_TYPE'] = 'T';$spacer1[2]['BRD_TYPE'] = 'LT';$spacer1[3]['BRD_TYPE'] = 'T';$spacer1[4]['BRD_TYPE'] = 'T';$spacer1[5]['BRD_TYPE'] = 'LRT';
		$spacer1[0]['LN_SIZE'] = 2;$spacer1[1]['LN_SIZE'] = 2;$spacer1[2]['LN_SIZE'] = 2;$spacer1[3]['LN_SIZE'] = 2;$spacer1[4]['LN_SIZE'] = 2;$spacer1[5]['LN_SIZE'] = 2;
		
		$header_type1[0]['TEXT'] = "";
		$header_type1[1]['TEXT'] = "<ns>".$infopemda. "</ns>";
		$header_type1[2]['TEXT'] = "";
		$header_type1[3]['TEXT'] = "<h1>".$s_title."\n(".strtoupper($title).")</h1>";
		$header_type1[4]['TEXT'] = "";
		$header_type1[5]['TEXT'] = "No. Urut\n".format_angka($this->config->item('length_kohir_spt'), $v1['netapajrek_kohir']);
		$header_type1[0]['BRD_TYPE'] = 'L';
		$header_type1[2]['BRD_TYPE'] = 'L';
		$header_type1[5]['BRD_TYPE'] = 'LR';
		$header_type1[1]['T_ALIGN'] = 'L';
		$header_type1[5]['T_SIZE'] = 9;
		$header_type1[1]['LN_SIZE'] = 3;
		$header_type1[0]['ROWSPAN'] = 2;
		$header_type1[1]['ROWSPAN'] = 2;
		$header_type1[2]['ROWSPAN'] = 2;
		$header_type1[4]['ROWSPAN'] = 2;
		$header_type1[5]['ROWSPAN'] = 2;
		
		$artgl = explode("-",$data_skpd[0][spt_periode_jual1]);
		$blnxa = $artgl[1];
		$tahun_pajak = $artgl[0];
		$masa = strtoupper(format_tgl('-'.$blnxa.'-',false,true));
		$header_type2[0]['TEXT'] = "";
		$header_type2[1]['TEXT'] = "";
		$header_type2[2]['TEXT'] = "";
		$header_type2[3]['TEXT'] = "Masa Pajak  : ".$masa."\nTahun  : ".$tahun_pajak;
		$header_type2[4]['TEXT'] = "";
		$header_type2[5]['TEXT'] = "";
		$header_type2[3]['T_ALIGN'] = 'C';
		$header_type2[3]['T_SIZE'] = 8;
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
		$spacer2[0]['LN_SIZE'] = 2;$spacer2[1]['LN_SIZE'] = 2;$spacer2[2]['LN_SIZE'] = 2;$spacer2[3]['LN_SIZE'] = 2;$spacer2[4]['LN_SIZE'] = 2;$spacer2[5]['LN_SIZE'] = 2;
		
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
		$idn[0]['WIDTH'] = 5;$idn[1]['WIDTH'] = 20;$idn[2]['WIDTH'] = 5;$idn[3]['WIDTH'] = 160;
		$pdf->tbSetHeaderType($idn);
		
		for($c=0;$c<$kolom;$c++) {
			$spc[$c] = $table_default_datax_type;
			$tbd[$c] = $table_default_datax_type;
		}
		$spc[0]['TEXT'] = "";
		$spc[0]['COLSPAN'] = 4;
		$spc[0]['BRD_TYPE'] = 'LRT';
		$spc[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($spc);
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "Nama";
		$tbd[2]['TEXT'] = ":";
		$tbd[3]['TEXT'] = "".strtoupper($data_skpd[0][wp_wr_nama]);
		$tbd[0]['BRD_TYPE'] = 'L';$tbd[3]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($tbd);
		
		$wp_wr_lurah = ($data_skpd[0]['wp_wr_lurah'] == "") ? "" : "KEL. ".$data_skpd[0]['wp_wr_lurah'];
		$wp_wr_camat = ($data_skpd[0]['wp_wr_camat'] == "") ? "" : "KEC. ".$data_skpd[0]['wp_wr_camat'];
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "Alamat";
		$tbd[2]['TEXT'] = ":";
		$tbd[3]['TEXT'] = "".strtoupper(ereg_replace("\r|\n","",$data_skpd[0][wp_wr_almt]))." ".strtoupper($wp_wr_lurah." ".$wp_wr_camat);
		$tbd[1]['V_ALIGN'] = 'T';$tbd[2]['V_ALIGN'] = 'T';
		$pdf->tbDrawData($tbd);
		
		if ($data_skpd[0]['spt_jenis_pajakretribusi'] != '4') {
			$tbd[0]['TEXT'] = "";
			$tbd[1]['TEXT'] = "NPWPD";
			$tbd[2]['TEXT'] = ":";
			$tbd[3]['TEXT'] = "".$data_skpd[0][npwprd];
			$pdf->tbDrawData($tbd);
		}
		
		$arr_tgl = explode("-", $data_skpd[0][netapajrek_tgl_jatuh_tempo]);
		$conv_tgl = $arr_tgl[2]."-".$arr_tgl[1]."-".$arr_tgl[0];
		
		$tbd[0]['TEXT'] = "";
		$tbd[1]['TEXT'] = "Tanggal Jatuh Tempo : ". format_tgl($conv_tgl,false,true)."\n\n";
		$tbd[1]['COLSPAN'] = 3;
		$tbd[1]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($tbd);
		
		$pdf->tbOuputData();
		
		$klm = 6;
		$pdf->tbInitialize($klm,true,true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($d=0;$d<$klm;$d++) $tabel[$d] = $table_default_header_type;
		
		for($d=0;$d<$klm;$d++) {
			$tc[$d] = $table_default_datax_type;
		}
		$tc[0]['WIDTH'] = 5;$tc[1]['WIDTH'] = 8;$tc[2]['WIDTH'] = 37;$tc[3]['WIDTH'] = 100;$tc[4]['WIDTH'] = 35;$tc[5]['WIDTH'] = 5;
		
		$pdf->tbSetHeaderType($tc);
		
		for($e=0;$e<$klm;$e++) {
			$th[$e] = $table_default_tblheader_type;
			$td[$e] = $table_data_skpd;
			$tl[$e] = $table_data_skpd;
			$tx[$e] = $table_data_skpd;
		}
		
		//Table Header
		$th[0]['TEXT'] = "";$th[1]['TEXT'] = "No.";$th[2]['TEXT'] = "Kode Rekening";$th[3]['TEXT'] = "Jenis Pajak Daerah";$th[4]['TEXT'] = "J u m l a h  (Rp.)";$th[5]['TEXT'] = "";
		$th[0]['BRD_TYPE'] = 'L';$th[1]['BRD_TYPE'] = 'LT';$th[2]['BRD_TYPE'] = 'LT';$th[3]['BRD_TYPE'] = 'LT';$th[4]['BRD_TYPE'] = 'LT';$th[5]['BRD_TYPE'] = 'LR';
		$pdf->tbDrawData($th);
		
		$td[0]['BRD_TYPE'] = 'L';
		$td[1]['BRD_TYPE'] = 'LT';
		$td[2]['BRD_TYPE'] = 'LT';
		$td[3]['BRD_TYPE'] = 'LT';
		$td[4]['BRD_TYPE'] = 'LT';
		$td[5]['BRD_TYPE'] = 'LR';
		$td[1]['T_ALIGN'] = 'R';
		$td[2]['T_ALIGN'] = 'C';
		$td[4]['T_ALIGN'] = 'R';
		
		$counter = 1;
		if (count($data_skpd) > 1) {
			foreach ($data_skpd as $key => $value) {
				//Bagian datanya...
				$td[0]['TEXT'] = "";
				$td[1]['TEXT'] = $counter .".";
				$td[2]['TEXT'] = $value['rekening'];
				$td[3]['TEXT'] = $value['korek_nama']."\n\n";
				$td[4]['TEXT'] = format_currency($value['spt_dt_pajak']);
				$td[5]['TEXT'] = "";
						
				$pdf->tbDrawData($td);				
				$counter++;
			}
		} else {
			foreach ($data_skpd as $key => $value) {
				if ($data_skpd[0]['spt_jenis_pajakretribusi'] == '4' || $data_skpd[0]['spt_jenis_pajakretribusi'] == '8') {
					//Bagian datanya...
					$td[0]['TEXT'] = "";
					$td[1]['TEXT'] = $counter .".";
					$td[2]['TEXT'] = $value['rekening'];
					if ($data_skpd[0]['spt_jenis_pajakretribusi'] == '4') {
						$dt_rek = $model->get_spt_reklame($data_skpd[0]['spt_dt_id']);
						$td[3]['TEXT'] = $value['korek_nama']."\n".$dt_rek['sptrek_judul']."\n\n\n\n";
					} else {
						$td[3]['TEXT'] = $value['korek_nama']."\n\n\n\n\n\n\n";
					}
					$td[4]['TEXT'] = format_currency($value['spt_dt_pajak']);
					$td[5]['TEXT'] = "";
							
					$pdf->tbDrawData($td);
				} else {
					//Bagian datanya...
					$td[0]['TEXT'] = "";
					$td[1]['TEXT'] = $counter .".";
					$td[2]['TEXT'] = $value['rekening'];
					$td[3]['TEXT'] = $value['korek_nama']."\nDasar Pengenaan : Rp. ".format_currency($value['spt_dt_jumlah'])."\nPeriode : ".format_tgl($data_skpd[0][spt_periode_jual1]).' s/d '.format_tgl($data_skpd[0][spt_periode_jual2])."\n\n\n\n\n\n\n";
					$td[4]['TEXT'] = format_currency($value['spt_dt_pajak']);
					$td[5]['TEXT'] = "";
							
					$pdf->tbDrawData($td);	
				}
			}		
		}
		
		//Bagian Jumlah...
		$total_pajak = $data_skpd[0]['spt_pajak'];
		$tl[0]['TEXT'] = "";$tl[1]['TEXT'] = "";$tl[3]['TEXT'] = "Jumlah Ketetapan Pokok Pajak";$tl[4]['TEXT'] = "".format_currency($total_pajak)."  ";$tl[5]['TEXT'] = "";
		$tl[1]['COLSPAN'] = 2;
		$tl[0]['BRD_TYPE'] = 'L';$tl[1]['BRD_TYPE'] = 'LT';$tl[3]['BRD_TYPE'] = 'LT';$tl[4]['BRD_TYPE'] = 'LT';$tl[5]['BRD_TYPE'] = 'LR';
		$tl[4]['T_ALIGN'] = 'R';
		$pdf->tbDrawData($tl);
		
		$tl[3]['TEXT'] = "Jumlah Sanksi :   a. Bunga";$tl[4]['TEXT'] = "" . format_currency(0) . "  ";
		$tl[1]['BRD_TYPE'] = 'L';
		$pdf->tbDrawData($tl);
		
		$tl[3]['TEXT'] = "                        :   b. Kenaikan";$tl[4]['TEXT'] = "" . format_currency(0) . "  ";
		$pdf->tbDrawData($tl);
		
		$tl[3]['TEXT'] = "Jumlah Keseluruhan";$tl[4]['TEXT'] = "" . format_currency($total_pajak) . "  ";
		$tl[0]['LN_SIZE'] = 7;$tl[1]['LN_SIZE'] = 7;$tl[2]['LN_SIZE'] = 7;$tl[3]['LN_SIZE'] = 7;$tl[4]['LN_SIZE'] = 7;$tl[5]['LN_SIZE'] = 7;
		$pdf->tbDrawData($tl);
		
		$tx[0]['TEXT'] = "";$tx[1]['TEXT'] = "";$tx[5]['TEXT'] = "";
		$tx[1]['COLSPAN'] = 4;
		$tx[0]['BRD_TYPE'] = 'L';$tx[1]['BRD_TYPE'] = 'T';$tx[5]['BRD_TYPE'] = 'R';
		$tx[0]['LN_SIZE'] = 2;$tx[1]['LN_SIZE'] = 2;$tx[5]['LN_SIZE'] = 2;
		$pdf->tbDrawData($tx);
		
		$pdf->tbOuputData();
		
		//Bagian Dengan huruf...
		$kol = 4;
		$pdf->tbInitialize($kol,true,true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($i=0;$i<$kol;$i++) $setw[$i] = $table_default_header_type;
		
		for($i=0;$i<$kol;$i++) {
			$wid[$i] = $table_default_header_type;
		}
		$wid[0]['WIDTH'] = 5;$wid[1]['WIDTH'] = 27;$wid[2]['WIDTH'] = 153;$wid[3]['WIDTH'] = 5;
		
		$pdf->tbSetHeaderType($wid);
		
		for($i=0;$i<$kol;$i++) {
			$dg[$i] = $table_data_skpd;
			$whs[$i] = $table_data_skpd;
		}
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
		
		for($j=0;$j<$cols;$j++) $colw[$j] = $table_default_header_type;
		
		for($j=0;$j<$cols;$j++) {
			$cwid[$j] = $table_data_skpd;
		}
		$cwid[0]['WIDTH'] = 5;$cwid[1]['WIDTH'] = 185;
		$cwid[0]['LN_SIZE'] = 1;$cwid[1]['LN_SIZE'] = 1;
		$pdf->tbSetHeaderType($cwid);
		
		for($k=0;$k<$cols;$k++) {
			$ins[$k] = $table_data_skpd;
			$ket[$k] = $table_data_skpd;
		}
		
		$ins[0]['TEXT'] = "";
		$ins[0]['COLSPAN'] = 2;
		$ins[0]['BRD_TYPE'] = 'LRT';
		$ins[0]['LN_SIZE'] = 4;
		$pdf->tbDrawData($ins);
		
		$ins[0]['TEXT'] = "P  E  R  H  A  T  I  A  N";
		$ins[0]['COLSPAN'] = 2;
		$ins[0]['BRD_TYPE'] = 'LR';
		$ins[0]['LN_SIZE'] = 6;
		$pdf->tbDrawData($ins);
		
		$ket[0]['TEXT'] = "1.";$ket[1]['TEXT'] = "Harap penyetoran dilakukan melalui Bendahara Penerimaan atau Kas Daerah (".$pemda->dapemda_bank_nama." No.Rek ".$pemda->dapemda_bank_norek." atas nama ".$pemda->dapemda_an_bank.") dengan menggunakan Surat Setoran Pajak Daerah (SSPD).";
		$ket[0]['BRD_TYPE'] = 'L';$ket[1]['BRD_TYPE'] = 'R';
		$ket[0]['V_ALIGN'] = 'T';
		$ket[0]['T_ALIGN'] = 'R';
		$pdf->tbDrawData($ket);
		
		$ket[0]['TEXT'] = "2.";$ket[1]['TEXT'] = "Apabila ".$s_title." ini tidak atau Kurang Dibayar setelah lewat waktu paling lama 30 hari  sejak  ".$s_title." ini ditetapkan dikenakan sanksi administrasi berupa bunga sebesar 2%  per bulan.\n";
		$pdf->tbDrawData($ket);
		
		$ins[0]['TEXT'] = "";
		$ins[0]['COLSPAN'] = 2;
		$ins[0]['BRD_TYPE'] = 'LR';
		$ins[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($ins);
		
		$pdf->tbOuputData();
		
		//Logo
		$logo = "assets/". $pemda->dapemda_logo_path;
		$pdf->Image($logo,16,14,14);
		
		//Bagian Tanda Tangan...
		$clm = 2;
		$pdf->tbInitialize($clm,true,true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($l=0;$l<$clm;$l++) $hdrx[$l] = $table_default_header_type;
		for($l=0;$l<$clm;$l++) {
			$lbr[$l] = $table_default_header_type;
		}
		$lbr[0]['WIDTH'] = 95;$lbr[1]['WIDTH'] = 95;
	
		$pdf->tbSetHeaderType($lbr);
		
		for($l=0;$l<$clm;$l++) {
			$tnd[$l] = $table_default_ttd_type;
			$jarak[$l] = $table_default_datax_type;
		}
		$jarak[0]['TEXT'] = "";
		$jarak[0]['COLSPAN'] = 2;
		$jarak[0]['BRD_TYPE'] = 'LRT';
		$jarak[0]['LN_SIZE'] = 2;
		$pdf->tbDrawData($jarak);
		
		list($y,$m,$d) = explode("-",$v1[netapajrek_tgl]);
		$tglx = $d . '-' . $m . '-' . $y;
		
		$tnd[0]['TEXT'] = "";$tnd[1]['TEXT'] = strtoupper($pemda->dapemda_ibu_kota).", ".strtoupper(format_tgl($tglx,false,true));
		$tnd[0]['BRD_TYPE'] = 'L';$tnd[1]['BRD_TYPE'] = 'R';
		$pdf->tbDrawData($tnd);
		
		if($mengetahui->pejda_kode == '01' || $this->session->userdata('USER_SPT_CODE') != '10') {
			$tnd[1]['TEXT'] = $mengetahui->ref_japeda_nama;
		}
		else {
			$tnd[1]['TEXT'] = "a.n. Kepala Dinas Pendapatan Daerah\n".$mengetahui->ref_japeda_nama;
		}
		$pdf->tbDrawData($tnd);
		
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
		$jarak[0]['LN_SIZE'] = 2;
		$jarak[0]['BRD_TYPE'] = 'T';
		$pdf->tbDrawData($jarak);
		$pdf->tbOuputData();
	
		$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Lembar Putih','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Wajib Pajak','','','L'),'','','',2);
		if ($this->session->userdata('USER_SPT_CODE') == "10" && $this->input->get('spt_jenis_pajakretribusi') == "4") 
			$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Lembar Merah','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'BPPT','','','L'),'','','',2);
		else 
			$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Lembar Merah','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Unit Pelaksana Teknis Dinas Pendapatan','','','L'),'','','',2);
			
		$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Lembar Kuning','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Seksi Pembukuan dan Pelaporan','','','L'),'','','',2);
		$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Lembar Hijau','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Bendahara Penerimaan','','','L'),'','','',2);
		$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Lembar Biru','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'Seksi Pendapatan Asli Daerah (PAD)','','','L'),'','','',2);
	
	}
	
	$pdf->Output();
}

?>