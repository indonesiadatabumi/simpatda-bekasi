<?php 

error_reporting(E_ERROR);

//add library
require_once(APPPATH.'libraries/Worksheet.php');
require_once(APPPATH.'libraries/Workbook.php');

function HeaderingExcel($filename){
    header("Content-type:application/vnd.ms-excel");
    header("Content-Disposition:attachment;filename=$filename");
    header("Expires:0");
    header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
    header("Pragma: public");
}

$tgl_proses = $_GET['tgl_proses'];
$arr_tgl_proses = explode('-', $tgl_proses);
$tahun_anggaran = $arr_tgl_proses[2];

 // HTTP headers
HeaderingExcel('laporan-pajak.xls');

// Creating a workbook
$workbook=new Workbook("-");

$ftitle =& $workbook->add_format();
$ftitle->set_size(12);
$ftitle->set_bold();
$ftitle->set_align('left');
$ftitle->set_font("Trebuchet MS");

$ftitle_right =& $workbook->add_format();
$ftitle_right->set_size(12);
$ftitle_right->set_bold();
$ftitle_right->set_align('right');
$ftitle_right->set_font("Trebuchet MS");

$fheader =& $workbook->add_format();
$fheader->set_size(8);
$fheader->set_bold();
$fheader->set_border(1);
$fheader->set_align('center');
$fheader->set_font("Trebuchet MS");
$fheader->set_text_wrap();

$fheader_number =& $workbook->add_format();
$fheader_number->set_size(6);
$fheader_number->set_bold();
$fheader_number->set_border(1);
$fheader_number->set_align('center');
$fheader_number->set_font("Trebuchet MS");

$ftotal_currency =& $workbook->add_format();
$ftotal_currency->set_size(8);
$ftotal_currency->set_num_format("#,##0.00");
$ftotal_currency->set_bold();
$ftotal_currency->set_align('right');
$ftotal_currency->set_font("Trebuchet MS");
$ftotal_currency->set_border(1);

$fcurrency =& $workbook->add_format();
$fcurrency->set_num_format("#,##0.00");
$fcurrency->set_align('right');
$fcurrency->set_size(8);
$fcurrency->set_border(1);
$fcurrency->set_font("Trebuchet MS");

$fdate =& $workbook->add_format();
$fdate->set_num_format('dd/mm/yyyy');
$fdate->set_align('center');
$fdate->set_size(8);
$fdate->set_border(1);
$fdate->set_font("Trebuchet MS");

$fdata_bold =& $workbook->add_format();
$fdata_bold->set_bold();
$fdata_bold->set_size(8);
$fdata_bold->set_align('left');
$fdata_bold->set_border(1);
$fdata_bold->set_font("Trebuchet MS");

$fdata =& $workbook->add_format();
$fdata->set_size(8);
$fdata->set_align('left');
$fdata->set_border(1);
$fdata->set_font("Trebuchet MS");
	   
// Creating the first worksheet
$worksheet1 =& $workbook->add_worksheet('Realisasi Pajak Daerah');
$worksheet1->set_landscape();
$worksheet1->set_column(0,0,2);
$worksheet1->set_column(0,1,2);
$worksheet1->set_column(0,2,2);
$worksheet1->set_column(0,3,2);
$worksheet1->set_column(0,4,2);
$worksheet1->set_column(0,5,50);
$worksheet1->set_column(0,6,20);
$worksheet1->set_column(0,7,20);
$worksheet1->set_column(0,8,8);
$worksheet1->set_column(0,9,20);
$worksheet1->set_column(0,10,8);
$worksheet1->set_column(0,11,20);
$worksheet1->set_column(0,12,8);
$worksheet1->set_column(0,13,20);
$worksheet1->set_column(0,14,20);

$worksheet1->write_string(0, 6, "LAPORAN : ",$ftitle_right);
$worksheet1->write_string(0, 7, "TARGET DAN REALISASI PENDAPATAN PAJAK DAERAH KOTA BEKASI", $ftitle);
$worksheet1->write_string(1, 7, "TAHUN ANGGARAN ".$tahun_anggaran, $ftitle);
$week_number = ceil(substr(format_tgl($tgl_proses), -2) / 7);
$worksheet1->write_string(2, 7, "MINGGU KE   :   ".format_romawi($week_number)." (S.D. ".strtoupper(tanggal_lengkap($tgl_proses)).")", $ftitle);
$worksheet1->write_string(3, 7, "BULAN          :   ".strtoupper(getNamaBulan($arr_tgl_proses[1]))." ".$tahun_anggaran, $ftitle);

//start no baris
$no_baris = 5;
$worksheet1->write_string($no_baris,0, "KODE REKENING",$fheader);
$worksheet1->write_string($no_baris,1, "",$fheader);
$worksheet1->write_string($no_baris,2, "",$fheader);
$worksheet1->write_string($no_baris,3, "",$fheader);
$worksheet1->write_string($no_baris,4, "",$fheader);
$worksheet1->merge_cells($no_baris, 0, $no_baris, 4);
$worksheet1->write_string($no_baris,5, "URAIAN", $fheader);
$worksheet1->write_string($no_baris,6, "TARGET\n T.A. $tahun_anggaran\n (Rp)", $fheader);
$worksheet1->write_string($no_baris,7, "REALISASI S.D.\n MINGGU LALU\n (Rp)", $fheader); 
$worksheet1->write_string($no_baris,8, "%", $fheader);
$worksheet1->write_string($no_baris,9, "REALISASI\n MINGGU INI\n (Rp)", $fheader);
$worksheet1->write_string($no_baris,10, "%", $fheader);
$worksheet1->write_string($no_baris,11, "REALISASI S.D\n MINGGU INI\n (Rp)", $fheader);
$worksheet1->write_string($no_baris,12, "%", $fheader);
$worksheet1->write_string($no_baris,13, "SISA TARGET\n (Rp)", $fheader);
$worksheet1->write_string($no_baris,14, "KETERANGAN", $fheader);

$no_baris++;
$worksheet1->write_number($no_baris,0, "1",$fheader_number);
$worksheet1->write_string($no_baris,1, "",$fheader_number);
$worksheet1->write_string($no_baris,2, "",$fheader_number);
$worksheet1->write_string($no_baris,3, "",$fheader_number);
$worksheet1->write_string($no_baris,4, "",$fheader_number);
$worksheet1->merge_cells($no_baris, 0, $no_baris, 4);
$worksheet1->write_number($no_baris,5, "2", $fheader_number);
$worksheet1->write_number($no_baris,6, "3", $fheader_number);
$worksheet1->write_number($no_baris,7, "4", $fheader_number); 
$worksheet1->write_number($no_baris,8, "5", $fheader_number);
$worksheet1->write_number($no_baris,9, "6", $fheader_number);
$worksheet1->write_number($no_baris,10, "7", $fheader_number);
$worksheet1->write_number($no_baris,11, "8", $fheader_number);
$worksheet1->write_number($no_baris,12, "9", $fheader_number);
$worksheet1->write_number($no_baris,13, "10", $fheader_number);
$worksheet1->write_number($no_baris,14, "11", $fheader_number);

$no_baris++;
$no_urut = 1;

$rekening = $realisasi_model->get_rekening("1", "1", "");
if (count($rekening) > 0) {
	$total_target = 0;
	$total_realisasi_minggu_lalu = 0;
	$total_realisasi_minggu_ini = 0;
	$total_realisasi = 0;
	
	$target = $realisasi_model->get_target_anggaran($tahun_anggaran);
	
	$realisasi_minggu_lalu = $realisasi_model->realisasi_pajak(
								format_tgl($tgl_proses), $tahun_anggaran, 1, "1", "1"
							);
							
	$realisasi_minggu_ini = $realisasi_model->realisasi_pajak(
								format_tgl($tgl_proses), $tahun_anggaran, 2, "1", "1"
							);
							
	foreach ($rekening as $row_rekening) {
		if ($row_rekening['korek_rincian'] == "00") {
			for ($i = 0; $i <= 14; $i++) {
				$worksheet1->write_blank($no_baris,$i, $format_data);
			}
			$no_baris++;
			$format_data = $fdata_bold;
			$format_currency = $ftotal_currency;
		} else {
			$format_data = $fdata;
			$format_currency = $fcurrency;
		}
		
		$worksheet1->write($no_baris,0, $row_rekening['korek_tipe'],$format_data);
		$worksheet1->write($no_baris,1, $row_rekening['korek_kelompok'],$format_data);
		$worksheet1->write($no_baris,2, $row_rekening['korek_jenis'],$format_data);
		$worksheet1->write_string($no_baris,3, $row_rekening['korek_objek'],$format_data);
		if ($row_rekening['korek_rincian'] == "00")
			$worksheet1->write_blank($no_baris,4, $format_data);
		else 
			$worksheet1->write_string($no_baris,4, $row_rekening['korek_rincian'],$format_data);
		$worksheet1->write_string($no_baris,5, $row_rekening['korek_nama'],$format_data);
		
		//target
		$dt_target = $target[$tahun_anggaran][$row_rekening['korek_id']];
		if ($dt_target != null) {
			$worksheet1->write_number($no_baris,6, $dt_target,$format_currency);
		} else {
			$dt_target = 0;
			$worksheet1->write_string($no_baris,6, "-",$format_currency);
		}
		
		//realisasi penerimaan minggu lalu
		$dt_real_minggu_lalu = $realisasi_minggu_lalu[$tahun_anggaran][$row_rekening['korek_id']];
		if ($dt_real_minggu_lalu != null && $dt_real_minggu_lalu != 0) {
			$worksheet1->write_number($no_baris,7, $dt_real_minggu_lalu,$format_currency);
		} else {
			$dt_real_minggu_lalu = 0;
			$worksheet1->write_string($no_baris,7, "-",$format_currency);
		}
		
		if ($dt_target != 0 && $dt_real_minggu_lalu != 0) {
			$persen_minggu_lalu = round(($dt_real_minggu_lalu / $dt_target) * 100, 2);
			$worksheet1->write_number($no_baris, 8, $persen_minggu_lalu, $fcurrency);
		} else {
			$worksheet1->write_string($no_baris, 8, "-", $format_currency);
		}
		
		//realisasi penerimaan minggu ini
		$dt_real_minggu_ini = $realisasi_minggu_ini[$tahun_anggaran][$row_rekening['korek_id']];
		if ($dt_real_minggu_ini != null && $dt_real_minggu_ini != 0) {
			$worksheet1->write_number($no_baris,9, $dt_real_minggu_ini, $format_currency);
		} else {
			$dt_real_minggu_ini = 0;
			$worksheet1->write_string($no_baris,9, "-", $format_currency);
		}
		
		if ($dt_target != 0 && $dt_real_minggu_ini != 0) {
			$persen_minggu_ini = round(($dt_real_minggu_ini/ $dt_target) * 100, 2);
			$worksheet1->write_number($no_baris, 10, $persen_minggu_ini, $fcurrency);
		} else {
			$worksheet1->write_string($no_baris, 10, "-", $format_currency);
		}
		
		//realisasi s.d minggu ini
		$realisasi = $dt_real_minggu_lalu + $dt_real_minggu_ini;
		if ($realisasi != 0) {
			$worksheet1->write_number($no_baris,11, $realisasi, $format_currency);
		} else {
			$worksheet1->write_string($no_baris,11, "-", $format_currency);
		}
		
		if ($dt_target != 0 && $realisasi != 0) {
			$persen = round(($realisasi/ $dt_target) * 100, 2);
			$worksheet1->write_number($no_baris, 12, $persen, $fcurrency);
		} else {
			$worksheet1->write_string($no_baris, 12, "-", $format_currency);
		}
		
		//sisa target
		$sisa_target = $dt_target - $realisasi;
		if ($sisa_target > 0)
			$worksheet1->write_number($no_baris,13, $sisa_target, $format_currency);
		else 
			$worksheet1->write_string($no_baris, 13, "-", $format_currency);
			
		$worksheet1->write_blank($no_baris, 14, $fdata);
		
		//total pajak
		if ($row_rekening['korek_rincian'] == "00") {
			$total_target += $dt_target;
			$total_realisasi_minggu_lalu += $dt_real_minggu_lalu;
			$total_realisasi_minggu_ini += $dt_real_minggu_ini;
			$total_realisasi += $realisasi;
		}
		
		$no_baris++;
	}
	
	//Bagian total
	$worksheet1->write_string($no_baris, 0, "JUMLAH HASIL PAJAK DAERAH", $fheader);
	$worksheet1->write_blank($no_baris, 1, $fdata);
	$worksheet1->write_blank($no_baris, 2, $fdata);
	$worksheet1->write_blank($no_baris, 3, $fdata);
	$worksheet1->write_blank($no_baris, 4, $fdata);
	$worksheet1->write_blank($no_baris, 5, $fdata);
	$worksheet1->merge_cells($no_baris, 0, $no_baris, 5);
	$worksheet1->write_number($no_baris,6, $total_target,$ftotal_currency);	
	$worksheet1->write_number($no_baris,7, $total_realisasi_minggu_lalu,$ftotal_currency);
	if ($total_target != 0) {
		$total_persen_minggu_lalu = round(($total_realisasi_minggu_lalu/ $total_target) * 100, 2);
		$worksheet1->write_number($no_baris, 8, $total_persen_minggu_lalu, $ftotal_currency);
	} else {
		$worksheet1->write_string($no_baris, 8, "-", $ftotal_currency);
	}
	
	$worksheet1->write_number($no_baris,9, $total_realisasi_minggu_ini,$ftotal_currency);
	if ($total_target != 0) {
		$total_persen_minggu_ini = round(($total_realisasi_minggu_ini/ $total_target) * 100, 2);
		$worksheet1->write_number($no_baris, 10, $total_persen_minggu_ini, $ftotal_currency);
	} else {
		$worksheet1->write_string($no_baris, 10, "-", $ftotal_currency);
	}
	
	$worksheet1->write_number($no_baris,11, $total_realisasi,$ftotal_currency);
	if ($total_target != 0) {
		$total_persen = round(($total_realisasi/ $total_target) * 100, 2);
		$worksheet1->write_number($no_baris, 12, $total_persen, $ftotal_currency);
	} else {
		$worksheet1->write_string($no_baris, 12, "-", $ftotal_currency);
	}
	
	$total_sisa = $total_target - $total_realisasi;
	if ($total_sisa > 0)
		$worksheet1->write_number($no_baris,13, $total_sisa,$ftotal_currency);
	else 
		$worksheet1->write_string($no_baris, 13, "-", $ftotal_currency);
		
	$worksheet1->write_blank($no_baris, 14, $ftotal_currency);
	$no_baris ++;
}


//bagian denda
$rekening = $realisasi_model->get_rekening("1", "4", "07");
if (count($rekening) > 0) {
	$total_target = 0;
	$total_realisasi_minggu_lalu = 0;
	$total_realisasi_minggu_ini = 0;
	$total_realisasi = 0;
	
	$target = $realisasi_model->get_target_anggaran($tahun_anggaran);
	
	$realisasi_minggu_lalu = $realisasi_model->realisasi_pajak(
								format_tgl($tgl_proses), $tahun_anggaran, 1, "1", "4", "07"
							);
							
	$realisasi_minggu_ini = $realisasi_model->realisasi_pajak(
								format_tgl($tgl_proses), $tahun_anggaran, 2, "1", "4", "07"
							);
							
	foreach ($rekening as $row_rekening) {
		if ($row_rekening['korek_rincian'] == "00") {
			for ($i = 0; $i <= 14; $i++) {
				$worksheet1->write_blank($no_baris,$i, $format_data);
			}
			$no_baris++;
			$format_data = $fdata_bold;
			$format_currency = $ftotal_currency;
		} else {
			$format_data = $fdata;
			$format_currency = $fcurrency;
		}
		
		$worksheet1->write($no_baris,0, $row_rekening['korek_tipe'],$format_data);
		$worksheet1->write($no_baris,1, $row_rekening['korek_kelompok'],$format_data);
		$worksheet1->write($no_baris,2, $row_rekening['korek_jenis'],$format_data);
		$worksheet1->write_string($no_baris,3, $row_rekening['korek_objek'],$format_data);
		if ($row_rekening['korek_rincian'] == "00")
			$worksheet1->write_blank($no_baris,4, $format_data);
		else 
			$worksheet1->write_string($no_baris,4, $row_rekening['korek_rincian'],$format_data);
		$worksheet1->write_string($no_baris,5, $row_rekening['korek_nama'],$format_data);
		
		//target
		$dt_target = $target[$tahun_anggaran][$row_rekening['korek_id']];
		if ($dt_target != null) {
			$worksheet1->write_number($no_baris,6, $dt_target,$format_currency);
		} else {
			$dt_target = 0;
			$worksheet1->write_string($no_baris,6, "-",$format_currency);
		}
		
		//realisasi penerimaan minggu lalu
		$dt_real_minggu_lalu = $realisasi_minggu_lalu[$tahun_anggaran][$row_rekening['korek_id']];
		if ($dt_real_minggu_lalu != null && $dt_real_minggu_lalu != 0) {
			$worksheet1->write_number($no_baris,7, $dt_real_minggu_lalu,$format_currency);
		} else {
			$dt_real_minggu_lalu = 0;
			$worksheet1->write_string($no_baris,7, "-",$format_currency);
		}
		
		if ($dt_target != 0 && $dt_real_minggu_lalu != 0) {
			$persen_minggu_lalu = round(($dt_real_minggu_lalu / $dt_target) * 100, 2);
			$worksheet1->write_number($no_baris, 8, $persen_minggu_lalu, $fcurrency);
		} else {
			$worksheet1->write_string($no_baris, 8, "-", $format_currency);
		}
		
		//realisasi penerimaan minggu ini
		$dt_real_minggu_ini = $realisasi_minggu_ini[$tahun_anggaran][$row_rekening['korek_id']];
		if ($dt_real_minggu_ini != null && $dt_real_minggu_ini != 0) {
			$worksheet1->write_number($no_baris,9, $dt_real_minggu_ini, $format_currency);
		} else {
			$dt_real_minggu_ini = 0;
			$worksheet1->write_string($no_baris,9, "-", $format_currency);
		}
		
		if ($dt_target != 0 && $dt_real_minggu_ini != 0) {
			$persen_minggu_ini = round(($dt_real_minggu_ini/ $dt_target) * 100, 2);
			$worksheet1->write_number($no_baris, 10, $persen_minggu_ini, $fcurrency);
		} else {
			$worksheet1->write_string($no_baris, 10, "-", $format_currency);
		}
		
		//realisasi s.d minggu ini
		$realisasi = $dt_real_minggu_lalu + $dt_real_minggu_ini;
		if ($realisasi != 0) {
			$worksheet1->write_number($no_baris,11, $realisasi, $format_currency);
		} else {
			$worksheet1->write_string($no_baris,11, "-", $format_currency);
		}
		
		if ($dt_target != 0 && $realisasi != 0) {
			$persen = round(($realisasi/ $dt_target) * 100, 2);
			$worksheet1->write_number($no_baris, 12, $persen, $fcurrency);
		} else {
			$worksheet1->write_string($no_baris, 12, "-", $format_currency);
		}
		
		//sisa target
		$sisa_target = $dt_target - $realisasi;
		if ($sisa_target > 0)
			$worksheet1->write_number($no_baris,13, $sisa_target, $format_currency);
		else 
			$worksheet1->write_string($no_baris, 13, "-", $format_currency);
			
		$worksheet1->write_blank($no_baris, 14, $fdata);
		
		//total pajak
		if ($row_rekening['korek_rincian'] == "00") {
			$total_target += $dt_target;
			$total_realisasi_minggu_lalu += $dt_real_minggu_lalu;
			$total_realisasi_minggu_ini += $dt_real_minggu_ini;
			$total_realisasi += $realisasi;
		}
		
		$no_baris++;
	}
	
	//Bagian total
	$worksheet1->write_string($no_baris, 0, "JUMLAH PENDAPATAN DENDA", $fheader);
	$worksheet1->write_blank($no_baris, 1, $fdata);
	$worksheet1->write_blank($no_baris, 2, $fdata);
	$worksheet1->write_blank($no_baris, 3, $fdata);
	$worksheet1->write_blank($no_baris, 4, $fdata);
	$worksheet1->write_blank($no_baris, 5, $fdata);
	$worksheet1->merge_cells($no_baris, 0, $no_baris, 5);
	$worksheet1->write_number($no_baris,6, $total_target,$ftotal_currency);	
	$worksheet1->write_number($no_baris,7, $total_realisasi_minggu_lalu,$ftotal_currency);
	if ($total_target != 0) {
		$total_persen_minggu_lalu = round(($total_realisasi_minggu_lalu/ $total_target) * 100, 2);
		$worksheet1->write_number($no_baris, 8, $total_persen_minggu_lalu, $ftotal_currency);
	} else {
		$worksheet1->write_string($no_baris, 8, "-", $ftotal_currency);
	}
	
	$worksheet1->write_number($no_baris,9, $total_realisasi_minggu_ini,$ftotal_currency);
	if ($total_target != 0) {
		$total_persen_minggu_ini = round(($total_realisasi_minggu_ini/ $total_target) * 100, 2);
		$worksheet1->write_number($no_baris, 10, $total_persen_minggu_ini, $ftotal_currency);
	} else {
		$worksheet1->write_string($no_baris, 10, "-", $ftotal_currency);
	}
	
	$worksheet1->write_number($no_baris,11, $total_realisasi,$ftotal_currency);
	if ($total_target != 0) {
		$total_persen = round(($total_realisasi/ $total_target) * 100, 2);
		$worksheet1->write_number($no_baris, 12, $total_persen, $ftotal_currency);
	} else {
		$worksheet1->write_string($no_baris, 12, "-", $ftotal_currency);
	}
	
	$total_sisa = $total_target - $total_realisasi;
	if ($total_sisa > 0)
		$worksheet1->write_number($no_baris,13, $total_sisa,$ftotal_currency);
	else 
		$worksheet1->write_string($no_baris, 13, "-", $ftotal_currency);
		
	$worksheet1->write_blank($no_baris, 14, $ftotal_currency);
}

//close workbook
$workbook->close();

?>