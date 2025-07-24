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

$masa_pajak = $data[0]['spt_periode_jual1'];
$arr_masa_pajak = explode('-', $masa_pajak);
$tgl_proses = $_GET['tgl_cetak'];
$arr_tgl_proses = explode('-', $tgl_proses);
$tahun_anggaran = $arr_tgl_proses[2];
$arrbulan = array(1=>'JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER');

 // HTTP headers
HeaderingExcel('daftar_ketetapan.xls');

// Creating a workbook
$workbook=new Workbook("-");

$ftitle =& $workbook->add_format();
$ftitle->set_size(10);
$ftitle->set_bold();
$ftitle->set_align('center');
$ftitle->set_font("Trebuchet MS");

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
$fdate->set_num_format('dd-mm-yyyy');
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
$worksheet1 =& $workbook->add_worksheet("DAFTAR KETETAPAN ");
$worksheet1->set_landscape();
$worksheet1->set_column(0,0,5);
$worksheet1->set_column(0,1,10);
$worksheet1->set_column(0,2,10);
$worksheet1->set_column(0,3,25);
$worksheet1->set_column(0,4,30);
$worksheet1->set_column(0,5,35);
$worksheet1->set_column(0,6,35);
$worksheet1->set_column(0,7,35);
$worksheet1->set_column(0,8,17);


$worksheet1->write_string(0,0, strtoupper($ketetapan->ketspt_ket), $ftitle); 
$worksheet1->merge_cells(0, 0, 0, 8);

$worksheet1->write_string(1,0, "TAHUN : " . $_GET['tahun'], $ftitle); 
$worksheet1->merge_cells(1, 0, 1, 8);

$worksheet1->write_string(2,0, "MASA PAJAK : ".getNamaBulan($arr_masa_pajak[1])." ".$arr_masa_pajak[0],$ftitle); 
$worksheet1->merge_cells(2, 0, 2, 8);

//start no baris
$no_baris = 4;

$worksheet1->write_string($no_baris,0, "NO",$fheader);
$worksheet1->merge_cells($no_baris, 0, $no_baris + 1, 0);
$worksheet1->write_string($no_baris,1, $ketetapan->ketspt_singkat,$fheader);
$worksheet1->write_string($no_baris,2, "",$fheader);
$worksheet1->merge_cells($no_baris, 1, $no_baris, 2);
$worksheet1->write_string($no_baris,3, "N P W P D",$fheader);
$worksheet1->merge_cells($no_baris, 3, $no_baris + 1, 3);
$worksheet1->write_string($no_baris,4, "NAMA WAJIB PAJAK",$fheader);
$worksheet1->merge_cells($no_baris, 4, $no_baris + 1, 4);
$worksheet1->write_string($no_baris,5, "A L A M A T", $fheader);
$worksheet1->merge_cells($no_baris, 5, $no_baris + 1, 5);
if ($_GET['spt_jenis_pajakretribusi'] == '8')
	$worksheet1->write_string($no_baris,6, "N.P.A", $fheader);
else 
	$worksheet1->write_string($no_baris,6, "OMZET", $fheader);

//$worksheet1->write_string($no_baris,6, "N.P.A", $fheader);
$worksheet1->merge_cells($no_baris, 6, $no_baris + 1, 6);
$worksheet1->write_string($no_baris,7, "KETETAPAN", $fheader);
$worksheet1->merge_cells($no_baris, 7, $no_baris + 1, 7);
$worksheet1->write_string($no_baris,8, "JATUH TEMPO", $fheader);
$worksheet1->merge_cells($no_baris, 8, $no_baris + 1, 8);

$no_baris++;
$worksheet1->write_string($no_baris,0, "",$fheader);
$worksheet1->write_string($no_baris,1, "TANGGAL",$fheader);
$worksheet1->write_string($no_baris,2, "NO. KOHIR",$fheader);
$worksheet1->write_string($no_baris,3, "",$fheader);
$worksheet1->write_string($no_baris,4, "",$fheader);
$worksheet1->write_string($no_baris,5, "", $fheader);
$worksheet1->write_string($no_baris,6, "", $fheader);
$worksheet1->write_string($no_baris,7, "", $fheader); 
$worksheet1->write_string($no_baris,8, "", $fheader);


//add new line
$no_baris++;

$counter = 1;
$pajak = 0;

// number of seconds in a day
$seconds_in_a_day = 86400;
// Unix timestamp to Excel date difference in seconds
$ut_to_ed_diff = $seconds_in_a_day * 25569;


if (!empty($data)) {
	foreach($data as $key => $val) {
		$worksheet1->write_number($no_baris,0, $counter, $fdata);
		$worksheet1->write_number($no_baris,1, ceil((strtotime($val['netapajrek_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
		$worksheet1->write($no_baris,2, $val['netapajrek_kohir'],$fdata);
		$worksheet1->write($no_baris,3, $val['npwprd'],$fdata);
		$worksheet1->write($no_baris,4, $val['wp_wr_nama'],$fdata);
		$worksheet1->write($no_baris,5, ereg_replace("\r|\n","",$val['wp_wr_almt']),$fdata);
		$worksheet1->write_number($no_baris,6, $val['omset'],$fcurrency);
		$worksheet1->write_number($no_baris,7, $val['spt_pajak'],$fcurrency);
		$worksheet1->write_number($no_baris,8, ceil((strtotime($val['netapajrek_tgl_jatuh_tempo']) + $ut_to_ed_diff) / $seconds_in_a_day),$fdate);
		
		$no_baris++; $counter++;
		$omset += $val['omset'];
		$pajak += $val['spt_pajak'];
	}
}


$worksheet1->write_string($no_baris,0, "JUMLAH",$fheader_number);
$worksheet1->write_string($no_baris,1, "",$fheader);
$worksheet1->write_string($no_baris,2, "",$fheader);
$worksheet1->write_string($no_baris,3, "",$fheader);
$worksheet1->write_string($no_baris,4, "",$fheader);
$worksheet1->write_string($no_baris,5, "", $fheader);
$worksheet1->merge_cells($no_baris, 0, $no_baris, 5);
$worksheet1->write_number($no_baris,6, $omset, $ftotal_currency);
$worksheet1->write_number($no_baris,7, $pajak, $ftotal_currency); 
$worksheet1->write_string($no_baris,8, "", $fheader);


//close workbook
$workbook->close();

?>