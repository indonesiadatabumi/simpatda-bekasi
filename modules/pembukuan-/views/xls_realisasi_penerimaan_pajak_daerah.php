<?php 

error_reporting(E_ERROR | _WARNING | E_PARSE);

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

 // HTTP headers
HeaderingExcel('realisasi-pajak.xls');

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

$fkecamatan =& $workbook->add_format();
$fkecamatan->set_size(10);
$fkecamatan->set_bold();
$fkecamatan->set_align('left');
$fkecamatan->set_font("Trebuchet MS");

$ftotal =& $workbook->add_format();
$ftotal->set_size(9);
$ftotal->set_bold();
$ftotal->set_align('center');
$ftotal->set_font("Trebuchet MS");
$ftotal->set_border(1);

$ftotal_currency =& $workbook->add_format();
$ftotal_currency->set_size(9);
$ftotal_currency->set_num_format("#,##0");
$ftotal_currency->set_bold();
$ftotal_currency->set_align('right');
$ftotal_currency->set_font("Trebuchet MS");
$ftotal_currency->set_border(1);

$fcurrency =& $workbook->add_format();
$fcurrency->set_num_format("#,##0");
$fcurrency->set_align('right');
$fcurrency->set_size(9);
$fcurrency->set_border(1);
$fcurrency->set_font("Trebuchet MS");

$fdate =& $workbook->add_format();
$fdate->set_num_format('dd/mm/yyyy');
$fdate->set_align('center');
$fdate->set_size(9);
$fdate->set_border(1);
$fdate->set_font("Trebuchet MS");

$fdata =& $workbook->add_format();
$fdata->set_size(9);
$fdata->set_align('left');
$fdata->set_border(1);
$fdata->set_font("Trebuchet MS");
	   
// Creating the first worksheet
$worksheet1 =& $workbook->add_worksheet('Realisasi Pajak Daerah');
$worksheet1->set_landscape();
$worksheet1->set_column(0,0,3);
$worksheet1->set_column(0,1,3);
$worksheet1->set_column(0,2,3);
$worksheet1->set_column(0,3,3);
$worksheet1->set_column(0,4,3);
$worksheet1->set_column(0,5,40);
$worksheet1->set_column(0,6,20);
$worksheet1->set_column(0,7,20);
$worksheet1->set_column(0,8,8);
$worksheet1->set_column(0,9,20);
$worksheet1->set_column(0,10,8);
$worksheet1->set_column(0,11,20);
$worksheet1->set_column(0,12,8);
$worksheet1->set_column(0,13,20);
$worksheet1->set_column(0,14,20);
 
$tgl_proses = $_GET['tgl_proses'];
$arr_tgl_proses = explode('-', $tgl_proses);
$tahun_anggaran = $arr_tgl_proses[2];

$worksheet1->write_string(0, 6, "LAPORAN : ",$ftitle_right);
$worksheet1->write_string(0, 7, "TARGET DAN REALISASI PENDAPATAN DAERAH KOTA BEKASI", $ftitle);
$worksheet1->write_string(1, 7, "TAHUN ANGGARAN ".$tahun_anggaran, $ftitle);
$worksheet1->write_string(2, 7, "BULAN ".strtoupper(getNamaBulan($arr_tgl_proses[1]))." ".$tahun_anggaran, $ftitle);

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

//close workbook
$workbook->close();

?>