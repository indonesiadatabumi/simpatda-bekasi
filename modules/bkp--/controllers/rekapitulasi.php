<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Rekapitulasi Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Rekapitulasi extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$this->load->view('form_rekapitulasi_penerimaan');
	}
	
	/**
	 * cetak penerimaan
	 */
	function cetak_penerimaan() {
		error_reporting(E_ERROR);
		
		//add library
		require_once(APPPATH.'libraries/Worksheet.php');
		require_once(APPPATH.'libraries/Workbook.php');
		
		$this->load->model('rekapitulasi_model');
		$list_header = $this->rekapitulasi_model->get_list_header(format_tgl($_REQUEST['tgl_penerimaan'], $_REQUEST['camat_id']));
		
		function HeaderingExcel($filename){
		    header("Content-type:application/vnd.ms-excel");
		    header("Content-Disposition:attachment;filename=$filename");
		    header("Expires:0");
		    header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
		    header("Pragma: public");
		}
		
		 // HTTP headers
		HeaderingExcel('rekap-harian.xls');

		 // Creating a workbook
		$workbook=new Workbook("-");
		
		$ftitle =& $workbook->add_format();
		$ftitle->set_size(11);
		$ftitle->set_bold();
		$ftitle->set_align('center');
		
		$fheader =& $workbook->add_format();
		$fheader->set_size(10);
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
		$worksheet1 =& $workbook->add_worksheet('Rekapitulasi Harian');
		$worksheet1->set_landscape();
		$worksheet1->set_column(0,0,5);
		$worksheet1->set_column(0,1,15);
		$worksheet1->set_column(0,2,15);
		$worksheet1->set_column(0,3,35);
		$worksheet1->set_column(0,4,35);
		$worksheet1->set_column(0,5,15);
		$worksheet1->set_column(0,6,15);
		 
		$worksheet1->write_string(0, 3, "Rekapitulasi Harian Bendahara Penerimaan", $ftitle);
		 
		$arr_tgl_penerimaan = explode('-', $this->input->get_post('tgl_penerimaan'));
		$worksheet1->write_string(2, 0, "Bulan : ".getNamaBulan($arr_tgl_penerimaan[1])." ".$arr_tgl_penerimaan[2]);
		
		$worksheet1->write_string(4,0, "No.",$fheader);
	  	$worksheet1->write_string(4,1, "Tanggal Setoran", $fheader);
	  	$worksheet1->write_string(4,2, "Bukti Setoran", $fheader); 
	  	$worksheet1->write_string(4,3, "SKPD / UPTD / SEKOLAH", $fheader);
	  	$worksheet1->write_string(4,4, "U R A I A N", $fheader);
	  	$worksheet1->write_string(4,5, "Rincian (Rp)", $fheader);
	  	$worksheet1->write_string(4,6, "NILAI (Rp)", $fheader);
		 
	  	$worksheet1->write_string(5,0, "", $fheader);
	  	$worksheet1->write_string(5,1, "", $fheader);
	  	$worksheet1->write_string(5,2, "STS/SSPD/Kliring", $fheader);
	  	$worksheet1->write_string(5,3, "", $fheader);
	  	$worksheet1->write_string(5,4, "", $fheader);
	  	$worksheet1->write_string(5,5, "", $fheader);
	  	$worksheet1->write_string(5,6, "", $fheader);
	  	
	  	$worksheet1->merge_cells(4, 0, 5, 0);
		$worksheet1->merge_cells(4, 1, 5, 1);
		$worksheet1->merge_cells(4, 3, 5, 3);
		$worksheet1->merge_cells(4, 4, 5, 4);
		$worksheet1->merge_cells(4, 5, 5, 5);
		$worksheet1->merge_cells(4, 6, 5, 6);
	  	
		$no_baris = 6;
		$no_urut = 1;
		
		if ($list_header->num_rows() > 0) {
			// number of seconds in a day
			$seconds_in_a_day = 86400;
			// Unix timestamp to Excel date difference in seconds
			$ut_to_ed_diff = $seconds_in_a_day * 25569;

			foreach ($list_header->result()	as $row) {
				$worksheet1->write_number($no_baris,0,$no_urut,$fdata);
			  	$worksheet1->write_number($no_baris,1,ceil((strtotime($row->skbh_tgl) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
			  	$worksheet1->write_string($no_baris,2,$row->bukti_setoran, $fdata);
			  	$worksheet1->write_string($no_baris,3,$row->skbh_nama, $fdata);
			  	$worksheet1->write_string($no_baris,4,$row->skbh_keterangan, $fdata);
			  	
			  	$list_detail = $this->rekapitulasi_model->get_detail($row->skbh_id);
			  	if ($list_detail->num_rows() > 1) {
			  		$tmp_no_baris = $no_baris;
			  		foreach ($list_detail->result() as $row_dt) {
			  			$worksheet1->write_number($no_baris,5, $row_dt->setorpajret_jlh_bayar, $fcurrency);
			  			$no_baris++;
			  		}
			  		
			  		$no_baris = $tmp_no_baris;
			  	} else {
			  		$worksheet1->write_string($no_baris,5,'', $fdata);
			  	}		
			  		  	
			  	$worksheet1->write_number($no_baris,6,$row->skbh_jumlah, $fcurrency);
			  	
			  	$no_urut++;
			  	if ($list_detail->num_rows() > 1)
			  		$no_baris += $list_detail->num_rows();
			  	else
			  		$no_baris++;
			}
		}
		
		$worksheet1->write_string($no_baris,4,"J U M L A H", $fdata);
		$worksheet1->write_formula($no_baris,5,"=SUM(F5:F$no_baris)", $fcurrency);
		$worksheet1->write_formula($no_baris,6,"=SUM(G5:G$no_baris)", $fcurrency);
		
		//insert history log
		$this->common_model->history_log("bkp", "P", "Cetak Rekapitulasi Bendahara Penerimaan : ".$_REQUEST['tgl_penerimaan']);
		
		//close workbook
		$workbook->close();
	}
}