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

 // HTTP headers
HeaderingExcel('daftar-sts.xls');

 // Creating a workbook
$workbook=new Workbook("-");


$ftitle =& $workbook->add_format();
$ftitle->set_size(11);
$ftitle->set_bold();
$ftitle->set_align('center');
	
$fheader =& $workbook->add_format();
$fheader->set_size(10);
$fheader->set_bold();
$fheader->set_border(1);
$fheader->set_align('center');
	
$fcurrency =& $workbook->add_format();
$fcurrency->set_num_format("#,##0");
$fcurrency->set_border(1);
$fcurrency->set_align('right');
	
$fdate =& $workbook->add_format();
$fdate->set_num_format('dd-mm-yyyy');
$fdate->set_align('center');
$fdate->set_border(1);
$fdate->set_text_wrap(0);

$fdata =& $workbook->add_format();
$fdata->set_size(10);
$fdata->set_border(1);
$fdata->set_align('left');
	   
// Creating the first worksheet
$worksheet1 =& $workbook->add_worksheet('Daftar STS');
$worksheet1->set_landscape();
$worksheet1->set_column(0,0,5);
$worksheet1->set_column(0,1,20);
$worksheet1->set_column(0,2,15);
$worksheet1->set_column(0,3,35);
$worksheet1->set_column(0,4,40);
$worksheet1->set_column(0,5,15);
$worksheet1->set_column(0,6,10);
 
$worksheet1->write_string(0, 3, "Daftar STS", $ftitle);

$worksheet1->write_string(2, 0, "Tanggal : ".$_GET['fDate']."- ".$_GET['tDate']);
$worksheet1->write_string(4,0, "No.",$fheader);
$worksheet1->write_string(4,1, "Nomor STS", $fheader);
$worksheet1->write_string(4,2, "Tanggal Setoran", $fheader);
$worksheet1->write_string(4,3, "Nama", $fheader); 
$worksheet1->write_string(4,4, "Alamat", $fheader);
$worksheet1->write_string(4,5, "Jumlah", $fheader);
$worksheet1->write_string(4,6, "Validasi", $fheader);

$no_baris = 5;
$no_urut = 1;

if ($query->num_rows() > 0) {
	// number of seconds in a day
	$seconds_in_a_day = 86400;
	// Unix timestamp to Excel date difference in seconds
	$ut_to_ed_diff = $seconds_in_a_day * 25569;
			
	foreach ($query->result() as $row) {
		$worksheet1->write_number($no_baris,0,$no_urut,$fdata);
		$worksheet1->write_string($no_baris,1,$row->skbh_no, $fdata);
	  	$worksheet1->write_number($no_baris,2,ceil((strtotime($row->skbh_tgl) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
	  	$worksheet1->write_string($no_baris,3,$row->skbh_nama, $fdata);
	  	$worksheet1->write_string($no_baris,4,$row->skbh_alamat, $fdata);
	  	$worksheet1->write_number($no_baris,5,$row->skbh_jumlah, $fcurrency);	
	  	if ($row->skbh_validasi == 'f') 		  	
	  		$worksheet1->write_string($no_baris,6,'Belum', $fdata);
	  	else 
	  		$worksheet1->write_string($no_baris,6,'', $fdata);
	  	
	  	$no_urut++;
	  	$no_baris++;
	}
}

$worksheet1->write_string($no_baris,4,"J U M L A H", $fdata);
$worksheet1->write_formula($no_baris,5,"=SUM(F5:F$no_baris)", $fcurrency);

//close workbook
$workbook->close();

?>