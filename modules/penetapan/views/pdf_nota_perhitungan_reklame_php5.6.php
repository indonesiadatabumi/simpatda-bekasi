<?php 
	
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf.php';

require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Class Extention for header and footer 
require_once APPPATH.'libraries/fpdf/table/header_footer.inc';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';




$pdf = new FPDF_TABLE('L','mm','Letter'); // Landscape,Letter,Lebar = 290
 
$pdf->Open();
$pdf->SetAutoPageBreak(true, 8); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(10, 10);     // Margin Left, Top, Right 2 cm


//$logo = "assets/". $pemda->dapemda_logo_path;



$ar_npwpd = $nota_model->call_npwpd_tetap();
$jenis_ketetapan = $_GET['spt_jenis_ketetapan'];

if (!empty($ar_npwpd)) 
{
	foreach ($ar_npwpd as $k1 => $v1) {

		$pdf->AddPage();
		$pdf->AliasNbPages();
		
		$pdf->setImageKey = [4];
		//prepare data
		$_data_sptpd = $nota_model->call_v_nota_perhitungan($v1['spt_id']);		
		
		
		$mspjk_tgl = explode("-",$_data_sptpd[0]['spt_periode_jual1']);
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
		$ws[2]['WIDTH'] = 87;
		$ws[3]['WIDTH'] = 5;
		$ws[4]['WIDTH'] = 43;
		$ws[5]['WIDTH'] = 5;
		$ws[6]['WIDTH'] = 35;
	
		$ws[0]['TEXT'] = "";$ws[1]['TEXT'] = "";$ws[2]['TEXT'] = "";$ws[3]['TEXT'] = "";$ws[4]['TEXT'] = "";$ws[5]['TEXT'] = "";$ws[6]['TEXT'] = "";
		
		$ws[0]['LN_SIZE'] = 2;$ws[1]['LN_SIZE'] = 2;$ws[2]['LN_SIZE'] = 2;$ws[3]['LN_SIZE'] = 2;$ws[4]['LN_SIZE'] = 2;$ws[5]['LN_SIZE'] = 2;$ws[6]['LN_SIZE'] = 2;
		$ws[0]['T_SIZE'] = 6;$ws[1]['T_SIZE'] = 6;$ws[2]['T_SIZE'] = 6;$ws[3]['T_SIZE'] = 6;$ws[4]['T_SIZE'] = 6;$ws[5]['T_SIZE'] = 6;$ws[6]['T_SIZE'] = 6;
		
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
		        "<th1>".strtoupper($pemda->nama_dinas)."</th1>\n".$pemda->dapemda_lokasi."\n".
				"Telp. ".$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax."\n<th1>".strtoupper($pemda->dapemda_nm_dati2)."</th1>";
		
		$dt[1]['TEXT'] = $data_pemda;		
		$dt[2]['TEXT'] = "\n<h1>NOTA PERHITUNGAN PAJAK DAERAH</h1>";
		$dt[2]['TEXT'] .= "\n<th1>PAJAK REKLAME</th1>";
		$dt[2]['TEXT'] .= "\nMASA PAJAK : ".strtoupper($mspjk_bln)."     TAHUN : ".$mspjk_thn;
		
		$dt[3]['TEXT'] = "";
		
		$dt[4]['TEXT'] = "\nDasar Pengenaan : Perda No. 10 Tahun 2019";$dt[4]['COLSPAN']=3;
		$dt[4]['TEXT'] .= "\nNo. Nota Perhitungan : ".format_angka($this->config->item('length_no_spt'),$_data_sptpd[0][netapajrek_kohir]);
		
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
		$dt[4]['BRD_TYPE'] = 'R';
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
				
		//$pdf->tbDrawData($sp);
		//$pdf->tbDrawData($sp);
		
		$dt1[0]['TEXT'] = "NAMA : " . $_data_sptpd[0]['wp_wr_nama'];
		$dt1[2]['TEXT'] = "ALAMAT : " . ereg_replace("\r|\n"," ",$_data_sptpd[0]['wp_wr_almt']);
		
		$dt1[0]['COLSPAN'] = 2;
		$dt1[2]['COLSPAN'] = 5;
		$dt1[0]['BRD_TYPE'] = 'L';
		$dt1[2]['BRD_TYPE'] = 'R';
		$dt1[0]['T_SIZE'] = 8;
		$dt1[2]['T_SIZE'] = 8;
		
		$pdf->tbDrawData($dt1);
		
		$pdf->tbDrawData($sp);
		$pdf->tbDrawData($sp);
		
		$pdf->tbOuputData();
		
		//Data nota perhitungan
		$kol = 7;
		$pdf->tbInitialize($kol, true, true);
		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($b=0;$b<$kol;$b++) $tblhead[$b] = $table_default_datax_type;
		
		for($b=0;$b<$kol;$b++) {
			$sps[$b] = $table_default_datax_type;
		}
		
		$sps[0]['WIDTH'] = 7;
		$sps[1]['WIDTH'] = 22;
		$sps[2]['WIDTH'] = 40;
		$sps[3]['WIDTH'] = 38;
		$sps[4]['WIDTH'] = 70;
		$sps[5]['WIDTH'] = 28;
		$sps[6]['WIDTH'] = 55;
		
		$pdf->tbSetHeaderType($sps);
		
		for($b=0;$b<$kol;$b++) {
			$th[$b] = $table_default_tblheader_type;
			$tn[$b] = $table_default_tblheader_type;
			$td[$b] = $table_default_tbldata_type;
			$tk[$b] = $table_default_tbldata_type;
			$tf[$b] = $table_default_tblheader_type;
			$space[$b] = $table_default_tbldata_type;
		}
		
		$th[0]['TEXT'] = "No.";
		$th[1]['TEXT'] = "Ayat";
		$th[2]['TEXT'] = "Jenis Reklame";
		$th[3]['TEXT'] = "Naskah Reklame";
		$th[4]['TEXT'] = "Perhitungan";
		$th[5]['TEXT'] = "Jumlah";
		$th[6]['TEXT'] = "Alamat Lokasi Pemasangan Reklame";
		
		$th[0]['BRD_TYPE'] = 'LT';$th[0]['T_SIZE'] = 7;$th[0]['LN_SIZE'] = 7;
		$th[1]['BRD_TYPE'] = 'LT';$th[1]['T_SIZE'] = 7;$th[1]['LN_SIZE'] = 7;
		$th[2]['BRD_TYPE'] = 'LT';$th[2]['T_SIZE'] = 7;$th[2]['LN_SIZE'] = 7;
		$th[3]['BRD_TYPE'] = 'LT';$th[3]['T_SIZE'] = 7;$th[3]['LN_SIZE'] = 7;
		$th[4]['BRD_TYPE'] = 'LT';$th[4]['T_SIZE'] = 7;$th[4]['LN_SIZE'] = 7;
		$th[5]['BRD_TYPE'] = 'LT';$th[5]['T_SIZE'] = 7;$th[5]['LN_SIZE'] = 7;
		$th[6]['BRD_TYPE'] = 'LRT';$th[6]['T_SIZE'] = 7;$th[6]['LN_SIZE'] = 7;
		$pdf->tbDrawData($th);
		
		$th[0]['TEXT'] = "1";
		$th[1]['TEXT'] = "2";
		$th[2]['TEXT'] = "3";
		$th[3]['TEXT'] = "4";
		$th[4]['TEXT'] = "5";
		$th[5]['TEXT'] = "6";
		$th[6]['TEXT'] = "7";
		
		$th[0]['BRD_TYPE'] = 'LT';$th[0]['T_SIZE'] = 5;$th[0]['LN_SIZE'] = 5;
		$th[1]['BRD_TYPE'] = 'LT';$th[1]['T_SIZE'] = 5;$th[1]['LN_SIZE'] = 5;
		$th[2]['BRD_TYPE'] = 'LT';$th[2]['T_SIZE'] = 5;$th[2]['LN_SIZE'] = 5;
		$th[3]['BRD_TYPE'] = 'LT';$th[3]['T_SIZE'] = 5;$th[3]['LN_SIZE'] = 5;
		$th[4]['BRD_TYPE'] = 'LT';$th[4]['T_SIZE'] = 5;$th[5]['LN_SIZE'] = 5;
		$th[6]['BRD_TYPE'] = 'LTR';$th[6]['T_SIZE'] = 5;$th[6]['LN_SIZE'] = 5;
		$pdf->tbDrawData($th);
		
		$total_pajak = 0;
		
		$counter = 1;
		//prepare data jumlah pajak
		$jumlah = 0;
		$kenaikan = 0; $denda = 0; $bunga = 0;
		
		$space[0]['BRD_TYPE']='L';$space[1]['BRD_TYPE']='L';$space[2]['BRD_TYPE']='L';$space[3]['BRD_TYPE']='L';$space[4]['BRD_TYPE']='L';$space[5]['BRD_TYPE']='L';$space[6]['BRD_TYPE']='LR';
		
		$td[0]['BRD_TYPE'] = 'LT';$td[1]['BRD_TYPE'] = 'LT';$td[2]['BRD_TYPE'] = 'LT';$td[3]['BRD_TYPE'] = 'LT';$td[4]['BRD_TYPE'] = 'LT';$td[5]['BRD_TYPE'] = 'LT';$td[6]['BRD_TYPE'] = 'LRT';
		$td[0]['LN_SIZE'] = 5;$td[1]['LN_SIZE'] = 5;$td[2]['LN_SIZE'] = 5;$td[3]['LN_SIZE'] = 5;$td[4]['LN_SIZE'] = 5;$td[5]['LN_SIZE'] = 5;$td[6]['LN_SIZE'] = 5;
		$pdf->tbDrawData($td);
			
		if (!empty($_data_sptpd)) {
		
			$td[0]['BRD_TYPE'] = 'L';$td[1]['BRD_TYPE'] = 'L';$td[2]['BRD_TYPE'] = 'L';$td[3]['BRD_TYPE'] = 'L';$td[4]['BRD_TYPE'] = 'L';$td[5]['BRD_TYPE'] = 'L';$td[6]['BRD_TYPE'] = 'LR';
			
			foreach ($_data_sptpd as $key => $value) 
			{
				$dt_rek = $nota_model->get_spt_reklame($value['spt_dt_id']);			
				$td[0]['TEXT'] = $counter.".";
				$td[1]['TEXT'] = $value['rekening'];
				$td[2]['TEXT'] = $value['korek_nama'];
				$td[3]['TEXT'] = $dt_rek['sptrek_judul'];
				
				$tmk=$dt_rek['tembakau_miras'];
				$tinggi=$dt_rek['tambah_tinggi'];
				if ($tmk=="1" ||$tmk=="2"){
					$tembakau_miras='50';
				}
				if ($tinggi=="1" ){
					$tambah_tinggi='20';
				}
				if ($dt_rek['tembakau_miras'] == "1" || $dt_rek['tembakau_miras'] == "2" AND $dt_rek['tambah_tinggi'] == "1") {
					$td[4]['TEXT'] = format_currency_no_comma($dt_rek['sptrek_nilai_tarif'])." x ".$dt_rek['sptrek_luas']." x ".$dt_rek['sptrek_jumlah']." x ".
									$dt_rek['sptrek_lama_pasang']." x ".$dt_rek['sptrek_tarif_pajak']." % + ".$tembakau_miras."% + ".$tambah_tinggi."% ";	
				}else if  ($dt_rek['tembakau_miras'] == "1" || $dt_rek['tembakau_miras'] == "2" ) {
					$td[4]['TEXT'] = format_currency_no_comma($dt_rek['sptrek_nilai_tarif'])." x ".$dt_rek['sptrek_luas']." x ".$dt_rek['sptrek_jumlah']." x ".
									$dt_rek['sptrek_lama_pasang']." x ".$dt_rek['sptrek_tarif_pajak']." % + ".$tembakau_miras."% ";	
				} 
				else {
				
				if ($dt_rek['korek_jenis'] == "01" || $dt_rek['korek_jenis'] == "02") {
					$td[4]['TEXT'] = format_currency_no_comma($dt_rek['sptrek_nilai_tarif'])." x ".$dt_rek['sptrek_luas']." x ".$dt_rek['sptrek_jumlah']." x ".
									$dt_rek['sptrek_lama_pasang']." x ".$dt_rek['sptrek_tarif_pajak']." % + ".$tambah_tinggi."% ";	
				} elseif ($dt_rek['korek_jenis'] == "05") {
					$td[4]['TEXT'] = format_currency_no_comma($dt_rek['sptrek_nilai_tarif'])." x ". $dt_rek['sptrek_luas']." x ".$dt_rek['sptrek_lama_pasang']." x ".$dt_rek['sptrek_tarif_pajak']." %";
				} elseif ($dt_rek['korek_jenis'] == "04" || $dt_rek['korek_jenis'] == "03") {
					$td[4]['TEXT'] = format_currency_no_comma($dt_rek['sptrek_nilai_tarif'])." x ". $dt_rek['sptrek_luas']." x ".$dt_rek['sptrek_tarif_pajak']." %";
				} elseif ($dt_rek['korek_jenis'] == "06") {
					$td[4]['TEXT'] = format_currency_no_comma($dt_rek['sptrek_nilai_tarif'])." x ".$dt_rek['sptrek_lama_pasang'] ." x ". $dt_rek['sptrek_jumlah']." x ".$dt_rek['sptrek_tarif_pajak']." %";
				} elseif ($dt_rek['korek_jenis'] == "09") {
					$td[4]['TEXT'] = format_currency_no_comma($dt_rek['sptrek_nilai_tarif'])." x "."(".$dt_rek['sptrek_durasi']."/15".")"." x ".$dt_rek['sptrek_teater']." x ".$dt_rek['sptrek_jumlah']." x ".$dt_rek['sptrek_lama_pasang'] ." x ". $dt_rek['sptrek_tarif_pajak']." %";
				} elseif ($dt_rek['korek_jenis'] == "07" || $dt_rek['korek_jenis'] == "08" || $dt_rek['korek_jenis'] == "11") {
					$td[4]['TEXT'] = $dt_rek['sptrek_jumlah']." x ".$dt_rek['sptrek_tarif_pajak'];
				} elseif ($dt_rek['korek_jenis'] == "12") {
					$td[4]['TEXT'] = format_currency_no_comma($dt_rek['sptrek_nilai_tarif'])." x ".$dt_rek['sptrek_luas']." x ".$dt_rek['sptrek_jumlah']." x ".
					$dt_rek['sptrek_lama_pasang']." x ".$dt_rek['sptrek_tarif_pajak']." %";	
				} else {
					$td[4]['TEXT'] = $dt_rek['sptrek_luas']." x ".$dt_rek['sptrek_tarif_pajak'];
				}
		}		
				if ($dt_rek['sptrek_area'] == "2") {
					$td[4]['TEXT'] .= " x 50%";
				}
				
				$td[5]['TEXT'] = format_currency_no_comma($value['spt_dt_pajak']);

				if($_data_sptpd[0]['wp_wr_lurah'] == null){
					$td[6]['TEXT'] = $dt_rek['sptrek_lokasi'];
				}else{
					$td[6]['TEXT'] = $dt_rek['sptrek_lokasi']."Kel. " . $_data_sptpd[0]['wp_wr_lurah']. " Kec. ". $_data_sptpd[0]['wp_wr_camat'];
				}
				
				$td[1]['T_ALIGN'] = "L";$td[4]['T_ALIGN'] = "C";$td[5]['T_ALIGN'] = "R";
				$td[6]['T_SIZE'] = "8";
				$pdf->tbDrawData($td);
				
				$total_pajak += $value[spt_dt_pajak];
				$counter++;
			}
		}
	
		$pdf->tbDrawData($space);
		//$pdf->tbDrawData($space);
		
		$tk[4]['TEXT'] = "J u m l a h ";
		$tk[5]['TEXT'] = format_currency_no_comma($total_pajak);
		$tk[6]['TEXT'] = "";
		
		$tk[4]['T_ALIGN'] = 'C';$tk[4]['T_TYPE'] = 'B';
		$tk[5]['T_ALIGN'] = 'R';
		
		$tk[0]['BRD_TYPE'] = 'LT';
		$tk[1]['BRD_TYPE'] = 'T';
		$tk[2]['BRD_TYPE'] = 'T';
		$tk[3]['BRD_TYPE'] = 'T';
		$tk[4]['BRD_TYPE'] = 'LT';
		$tk[5]['BRD_TYPE'] = 'LT';
		$tk[6]['BRD_TYPE'] = 'LRT';
		
		$pdf->tbDrawData($tk);
		
		$tk[0]['TEXT'] = "";$tk[1]['TEXT'] = "";$tk[2]['TEXT'] = "";$tk[3]['TEXT'] = "";$tk[4]['TEXT'] = "";$tk[5]['TEXT'] = "";$tk[6]['TEXT'] = "";
		$tk[0]['LN_SIZE'] = 1;$tk[1]['LN_SIZE'] = 1;$tk[2]['LN_SIZE'] = 1;$tk[3]['LN_SIZE'] = 1;$tk[4]['LN_SIZE'] = 1;$tk[5]['LN_SIZE'] = 1;$tk[6]['LN_SIZE'] = 1;
		
		//$pdf->tbDrawData($tk);

		$tf[0]['BRD_TYPE'] = 'T';
		$tf[1]['BRD_TYPE'] = 'T';
		$tf[2]['BRD_TYPE'] = 'T';
		$tf[3]['BRD_TYPE'] = 'T';
		$tf[4]['BRD_TYPE'] = 'T';
		$tf[5]['BRD_TYPE'] = 'T';
		$tf[6]['BRD_TYPE'] = 'T';
		$pdf->tbDrawData($tf); 
		
		$tf[0]['TEXT'] = "Jumlah dengan huruf : ( ".ucwords(strtolower(terbilang($total_pajak)))." Rupiah )";
		$tf[0]['COLSPAN'] = 7;
		$tf[0]['BRD_TYPE'] = '';
		$tf[0]['T_SIZE'] = 10;
		$pdf->tbDrawData($tf);
		
		$tf[0]['TEXT'] = "";
		$tf[0]['COLSPAN'] = 7;
		$tf[0]['BRD_TYPE'] = '';
		
		$pdf->tbDrawData($tf);//$pdf->tbDrawData($tf);
		
		$pdf->tbOuputData();
		// bagian dasar perhitungan
		$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Dasar Perhitungan','','','L').$pdf->Cell(15,2,':','','','C').$pdf->Cell(80,2,'','','','L'),'','','',2);
		if ($this->session->userdata('USER_SPT_CODE') == "10" && $this->input->get('spt_jenis_pajakretribusi') == "4") 
			$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Reklame Billboard/videotron/kain dan sejenisnya','','','L').$pdf->Cell(118,2,':  Nilai KJ x Ukuran x Jumlah x Jangka Waktu x25%','','','C').$pdf->Cell(80,2,'','','','L'),'','','',2);
		else 
			$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'','','','L').$pdf->Cell(3,2,':','','','C').$pdf->Cell(80,2,'','','','L'),'','','',2);
			
		$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Reklame Film/Slide','','','L').$pdf->Cell(157,2,':  (NSR x (Durasi / 15 detik) x Jumlah Studio x Jumlah Tayang x Jangka Waktu x 25%) x 50%','','','C').$pdf->Cell(80,2,'','','','L'),'','','',2);
		$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Reklame Berjalan','','','L').$pdf->Cell(107,2,':  NSR x Ukuran x Jangka Waktu x 25%','','','C').$pdf->Cell(80,2,'','','','L'),'','','',2);
		$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Reklame Melekat','','','L').$pdf->Cell(91,2,':  NSR x Ukuran x 25%','','','C').$pdf->Cell(80,2,'','','','L'),'','','',2);
	    $pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Reklame Rokok dan Miras','','','L').$pdf->Cell(125,2,':  Nilai KJ x Ukuran x Jumlah x Jangka Waktu x 25% + 50%','','','C').$pdf->Cell(80,2,'','','','L'),'','','',2);
		$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'Reklame Tambah Ketinggian','','','L').$pdf->Cell(125,2,':  Nilai KJ x Ukuran x Jumlah x Jangka Waktu x 25% + 20%','','','C').$pdf->Cell(80,2,'','','','L'),'','','',2);
	    $pdf->MultiCell(190,3,$pdf->SetFont('Arial','',6).$pdf->Cell(15,2,'','','','L').$pdf->Cell(3,2,'','','','C').$pdf->Cell(80,2,'','','','L'),'','','',2);
		
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
		
		//$pdf->tbDrawData($ts);
		
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

		/*
		$ts[0]['TEXT'] = "";
		$ts[1]['TEXT'] = "";
		$ts[2]['TEXT'] = "Jabatan";
		$ts[3]['TEXT'] = ":";
		$ts[4]['TEXT'] = $this->session->userdata('USER_JABATAN_NAME');		
		$pdf->tbDrawData($ts);
		*/
//$logo = "assets/". $pemda->dapemda_logo_path;
//$pdf->Image($logo,12,12,18);

		if ($this->session->userdata('USER_SPT_CODE') == "10") {
			$ts[2]['TEXT'] = "N I P";
			$ts[4]['TEXT'] = $this->session->userdata('USER_NIP');		
			$pdf->tbDrawData($ts);
		}		
		
		$ts[0]['TEXT'] = "";
		$ts[1]['TEXT'] = "";
		$ts[2]['TEXT'] = "";
		$ts[3]['TEXT'] = "";
		$ts[4]['TEXT'] = "";		
		$pdf->tbDrawData($ts);
		
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
		//$logo = "assets/". $pemda->dapemda_logo_path;
		//$pdf->Image($logo,12,12,18, 20);
		
	}
	
	$pdf->Output();

}


?>