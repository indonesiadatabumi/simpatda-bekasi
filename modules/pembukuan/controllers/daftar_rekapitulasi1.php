<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Daftar_rekapitulasi controller
 * @package Simpatda
 */
class Daftar_rekapitulasi extends Master_Controller {
	
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('pembukuan_model');
		$this->load->model('daftar_rekapitulasi_model');
		$this->load->model('common_model');
		$this->load->model('objek_pajak_model');
	}
	
	
	/**
	 * index page controller
	 */
	function index() {
		$data['keterangan_spt'] = array('8' => 'Surat Pemberitahuan Pajak Daerah', '1' => 'Surat Ketetapan Pajak Daerah', '11' => 'Surat Ketetapan Pajak Daerah Kurang Bayar', '3' => 'Surat Tagihan Pajak Daerah');
		$data['kecamatan'] = $this->pembukuan_model->kecamatan();
		$data['jenis_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(false);
		$data['jenis_pajak_restoran'] = array('0' => 'Semua Jenis', '1' => 'Rumah Makan', '2' => 'Catering');
		
		$year = date('Y');
		$years[$year] = $year;
		for ($i = 1; $i < 5; $i++) {
			$years[$year - $i] = $year - $i;
		}
		$data['tahun_pajak'] = $years;
		
		$this->load->view('form_daftar_rekapitulasi', $data);
	}
	
	/**
	 * cetak daftar rekapitulasi
	 */
	function cetak() {
		//insert history log
		$this->common_model->history_log("pembukuan", "P", 
			"Cetak daftar rekapitulasi : ".$_GET['jenis_pajak']." | ".$_GET['bulan_masa_pajak']." - ".$_GET['tahun_masa_pajak']." | ".$_GET['status_spt']." | ".$_GET['camat_id']);

		if ($this->input->get('semua_wp') == "0" || $this->input->get('semua_wp') == null) {
			if ($this->input->get('lap') == "realisasi"){
//				if($this->input->get('status_spt') == "11")
//					$this->cetak_skpdkb2();
//				else
					$this->cetak_daftar(0, 1);
			}else {
//				if($this->input->get('status_spt') == "11")
//					$this->cetak_skpdkb2();
//				else
					$this->cetak_daftar(0, 0);
			}
		} else {
			$this->cetak_daftar(1);
		}
	}
/*
	function cetak_skpdkb2(){
		$jenis_pajak = $this->daftar_rekapitulasi_model->get_ref_pajak($this->input->get('jenis_pajak'));
		$data['jenis_pajak'] = strtoupper($jenis_pajak);
		$data['camat_id'] = $this->input->get('camat_id');
		$lap = $this->input->get('lap');
		$data['status_spt'] = $this->input->get('status_spt');
		$data['koderek'] = $this->daftar_rekapitulasi_model->get_koderek($jenis_pajak);
		if($lap=="realisasi"){
			$data['jenis_laporan'] = 1;
			$first_param = $this->input->get('fDate');
			$second_param = $this->input->get('tDate');
			$data['first_param'] = $this->input->get('fDate');
			$data['second_param'] =  $this->input->get('tDate');
		}else {
			$data['jenis_laporan'] = 0;
			$first_param = $this->input->get('bulan_masa_pajak');
			$second_param = $this->input->get('tahun_masa_pajak');
			$data['first_param'] = $this->input->get('bulan_masa_pajak');
			$data['second_param'] = $this->input->get('tahun_masa_pajak');
		}
		if($lap == "masa_pajak"){
		$dt_kecamatan = $this->daftar_rekapitulasi_model->kecamatan_skpdkb(
													$lap_realisasi,
													$this->daftar_rekapitulasi_model->get_koderek($jenis_pajak), 
													$this->daftar_rekapitulasi_model->get_kd_camat($this->input->get('camat_id')),
													$first_param, 
													$second_param,
													$this->input->get('status_spt'),
													$this->input->get('jenis_restoran'),
													0
												);
//		$data['jml_kec'] = count($dt_kecamatan);
		$data['dt_kecamatan']= $dt_kecamatan;
		$this->load->view('form_cetak_skpdkb', $data);
		}
		if($lap == "realisasi"){
		$dt_kecamatan = $this->daftar_rekapitulasi_model->kecamatan_skpdkb_realisasi(
													$lap_realisasi,
													$this->daftar_rekapitulasi_model->get_koderek($jenis_pajak), 
													$this->daftar_rekapitulasi_model->get_kd_camat($this->input->get('camat_id')),
													$first_param, 
													$second_param,
													$this->input->get('status_spt'),
													$this->input->get('jenis_restoran'),
													0
												);

		$data['dt_kecamatan']= $dt_kecamatan;
		$this->load->view('form_cetak_skpdkb_realisasi', $data);
		}
	}
		
	function cetak_skpdkb(){
		$jenis_pajak = $this->daftar_rekapitulasi_model->get_ref_pajak($this->input->get('jenis_pajak'));
		$data['jenis_pajak'] = strtoupper($jenis_pajak);
		$data['bulan_pajak'] = $this->input->get('bulan_masa_pajak');
		$data['tahun_pajak'] = $this->input->get('tahun_masa_pajak');
		$data['camat_id'] = $this->input->get('camat_id');
		$data['lap'] = $this->input->get('lap');
		$data['status_spt'] = $this->input->get('status_spt');
		
		$dt_kecamatan = $this->daftar_rekapitulasi_model->kecamatan_skpdkb(
													$lap_realisasi,
													$this->daftar_rekapitulasi_model->get_koderek($jenis_pajak), 
													$this->daftar_rekapitulasi_model->get_kd_camat($this->input->get('camat_id')),
													$this->input->get('bulan_masa_pajak'), 
													$this->input->get('tahun_masa_pajak'),
													$this->input->get('status_spt'),
													$this->input->get('jenis_restoran'),
													0
												);
		$data['data_skpdkb'] = $dt_kecamatan;
		if (count($dt_kecamatan) > 0) {
			foreach ($dt_kecamatan as $camat) {
				$data['camat_nama'] = $camat['camat_nama'];
/*
				$data['data_skpdkb'] = $this->daftar_rekapitulasi_model->data_skpdkb(
																				$this->input->get('lap'),
																				$this->daftar_rekapitulasi_model->get_koderek($jenis_pajak),
																				$camat['camat_kode'],
																				$this->input->get('bulan_masa_pajak'),
																				$this->input->get('tahun_masa_pajak'),
																				$this->input->get('status_spt')
																				);

*/
/*
			}
		}
		$this->load->view('form_cetak_skpdkb', $data);
	}
*/
	/**
	 * cetak daftar
	 * @param unknown_type $type_cetak : 0 = hanya spt yang dilapor | 1 = semua data
	 * @param $jenis_laporan
	 */
	function cetak_daftar($type_cetak = 0, $lap_realisasi = 1) {
		error_reporting(E_ERROR);
		
		//add library
		require_once(APPPATH.'libraries/Worksheet.php');
		require_once(APPPATH.'libraries/Workbook.php');
		
		// number of seconds in a day
		$seconds_in_a_day = 86400;
		// Unix timestamp to Excel date difference in seconds
		$ut_to_ed_diff = $seconds_in_a_day * 25569;
		$bulan_pajak = $this->input->get('bulan_masa_pajak');
		$tahun_pajak = $this->input->get('tahun_masa_pajak');
		
		function HeaderingExcel($filename){
		    header("Content-type:application/vnd.ms-excel");
		    header("Content-Disposition:attachment;filename=$filename");
		    header("Expires:0");
		    header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
		    header("Pragma: public");
		}
		
		// HTTP headers
		HeaderingExcel('daftar-rekapitulasi.xls');

		 // Creating a workbook
		$workbook=new Workbook("-");
		
		$ftitle =& $workbook->add_format();
		$ftitle->set_size(12);
		$ftitle->set_bold();
		$ftitle->set_align('center');
		$ftitle->set_font("Trebuchet MS");
		
		$fheader =& $workbook->add_format();
		$fheader->set_size(10);
		$fheader->set_bold();
		$fheader->set_border(1);
		$fheader->set_align('center');
		$fheader->set_font("Trebuchet MS");
		
		$fheader_small =& $workbook->add_format();
		$fheader_small->set_size(7);
		$fheader_small->set_bold();
		$fheader_small->set_border(1);
		$fheader_small->set_align('center');
		$fheader_small->set_font("Trebuchet MS");
		
		$fkecamatan =& $workbook->add_format();
		$fkecamatan->set_size(10);
		$fkecamatan->set_bold();
		$fkecamatan->set_border(1);
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
		
		$fsisa =& $workbook->add_format();
		$fsisa->set_num_format("#,##0_);[Red](#,##0)");
		$fsisa->set_align('right');
		$fsisa->set_size(9);
		$fsisa->set_border(1);
		$fsisa->set_font("Trebuchet MS");
		
		$ftotal_sisa =& $workbook->add_format();
		$ftotal_sisa->set_num_format("#,##0_);[Red](#,##0)");
		$ftotal_sisa->set_align('right');
		$ftotal_sisa->set_bold();
		$ftotal_sisa->set_size(9);
		$ftotal_sisa->set_border(1);
		$ftotal_sisa->set_font("Trebuchet MS");
		
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
		
		$fdata_center =& $workbook->add_format();
		$fdata_center->set_size(9);
		$fdata_center->set_align('center');
		$fdata_center->set_border(1);
		$fdata_center->set_font("Trebuchet MS");
		
		$worksheet1 =& $workbook->add_worksheet('Daftar Rekapitulasi');
		$worksheet1->set_landscape();
		
		if ($_GET['status_spt'] == "8") {
			$worksheet1->set_column(0,0,5);
			$worksheet1->set_column(0,1,25);
			$worksheet1->set_column(0,2,17);
			$worksheet1->set_column(0,3,30);
			$worksheet1->set_column(0,4,15);
			$worksheet1->set_column(0,5,10);
			$worksheet1->set_column(0,6,7);
			$worksheet1->set_column(0,7,15);
			$worksheet1->set_column(0,8,14);
			$worksheet1->set_column(0,9,15);
			$worksheet1->set_column(0,10,10);
			$worksheet1->set_column(0,11,14);
			$worksheet1->set_column(0,12,16);
		} else {
			$worksheet1->set_column(0,0,5);
			$worksheet1->set_column(0,1,25);
			$worksheet1->set_column(0,2,17);
			$worksheet1->set_column(0,3,30);
			$worksheet1->set_column(0,4,14);
			$worksheet1->set_column(0,5,10);
			$worksheet1->set_column(0,6,7);
			$worksheet1->set_column(0,7,14);
			$worksheet1->set_column(0,8,15);
			$worksheet1->set_column(0,9,10);
			$worksheet1->set_column(0,10,14);
			$worksheet1->set_column(0,11,16);
			$worksheet1->set_column(0,12,16);
		}
		
		$ket_spt = strtoupper($this->daftar_rekapitulasi_model->get_keterangan_spt($_GET['status_spt']));
		$nama_pajak = strtoupper($this->daftar_rekapitulasi_model->get_ref_pajak($this->input->get('jenis_pajak')));
		$worksheet1->write_string(0, 0, "DAFTAR REKAPITULASI $ket_spt DAN REALISASI $nama_pajak", $ftitle);
		if ($lap_realisasi == 1)
			$worksheet1->write_string(1, 0, "Tanggal Realisasi ".format_tgl($this->input->get('fDate'), true, true, false)." - ".
							format_tgl($this->input->get('tDate'), true, true, false), $ftitle);
		else
			$worksheet1->write_string(1, 0, "MASA PAJAK ".strtoupper(getNamaBulan($bulan_pajak))." ".$tahun_pajak, $ftitle);
		
		
		if ($_GET['status_spt'] == "8") {
			$worksheet1->merge_cells(0, 0, 0, 12);
			$worksheet1->merge_cells(1, 0, 1, 12);
			
			$worksheet1->write_string(3, 0, "NO", $fheader);
			$worksheet1->merge_cells(3, 0, 4, 0);
			$worksheet1->write_string(3, 1, "WAJIB PAJAK", $fheader);
			$worksheet1->write_blank(3, 2, $fheader);$worksheet1->write_blank(3, 3, $fheader);$worksheet1->write_blank(3, 4, $fheader);
			$worksheet1->merge_cells(3, 1, 3, 4);
			$worksheet1->write_string(3, 5, "$ket_spt", $fheader);
			$worksheet1->write_blank(3, 6, $fheader);$worksheet1->write_blank(3, 7, $fheader);$worksheet1->write_blank(3, 8, $fheader);
			$worksheet1->merge_cells(3, 5, 3, 8);
			$worksheet1->write_string(3, 9, "STS", $fheader);
			$worksheet1->write_blank(3, 10, $fheader);$worksheet1->write_blank(3, 11, $fheader);
			$worksheet1->merge_cells(3, 9, 3, 11);
			$worksheet1->write_string(3, 12, "TUNGGAKAN (Rp)", $fheader);
			$worksheet1->merge_cells(3, 12, 4, 12);
			
			$worksheet1->write_blank(4, 0, $fheader);
			$worksheet1->write_string(4, 1, "NAMA WP", $fheader);
			$worksheet1->write_string(4, 2, "NPWPD", $fheader);
			$worksheet1->write_string(4, 3, "ALAMAT", $fheader);
			$worksheet1->write_string(4, 4, "MASA PAJAK", $fheader);
			$worksheet1->write_string(4, 5, "TANGGAL", $fheader);
			$worksheet1->write_string(4, 6, "NOMOR", $fheader);
			$worksheet1->write_string(4, 7, "OMZET (Rp)", $fheader);
			$worksheet1->write_string(4, 8, "PAJAK (Rp)", $fheader);
			$worksheet1->write_string(4, 9, "NOMOR", $fheader);
			$worksheet1->write_string(4, 10, "TANGGAL", $fheader);
			$worksheet1->write_string(4, 11, "SETORAN (Rp)", $fheader);
			$worksheet1->write_blank(4, 12, $fheader);
			
			$worksheet1->write_number(5, 0, "1", $fheader_small);
			$worksheet1->write_number(5, 1, "2", $fheader_small);
			$worksheet1->write_number(5, 2, "3", $fheader_small);
			$worksheet1->write_number(5, 3, "4", $fheader_small);
			$worksheet1->write_number(5, 4, "5", $fheader_small);
			$worksheet1->write_number(5, 5, "6", $fheader_small);
			$worksheet1->write_number(5, 6, "7", $fheader_small);
			$worksheet1->write_number(5, 7, "8", $fheader_small);
			$worksheet1->write_number(5, 8, "9", $fheader_small);
			$worksheet1->write_number(5, 9, "10", $fheader_small);
			$worksheet1->write_number(5, 10, "11", $fheader_small);
			$worksheet1->write_number(5, 11, "12", $fheader_small);
			$worksheet1->write_number(5, 12, "13", $fheader_small);
		} else {
			$worksheet1->merge_cells(0, 0, 0, 11);
			$worksheet1->merge_cells(1, 0, 1, 11);
			
			$worksheet1->write_string(3, 0, "NO", $fheader);
			$worksheet1->merge_cells(3, 0, 4, 0);
			$worksheet1->write_string(3, 1, "WAJIB PAJAK", $fheader);
			$worksheet1->write_blank(3, 2, $fheader);$worksheet1->write_blank(3, 3, $fheader);$worksheet1->write_blank(3, 4, $fheader);
			$worksheet1->merge_cells(3, 1, 3, 4);
			$worksheet1->write_string(3, 5, "$ket_spt", $fheader);
			$worksheet1->write_blank(3, 6, $fheader);$worksheet1->write_blank(3, 7, $fheader);
			$worksheet1->merge_cells(3, 5, 3, 7);
			$worksheet1->write_string(3, 8, "STS", $fheader);
			$worksheet1->write_blank(3, 8, $fheader);$worksheet1->write_blank(3, 9, $fheader);$worksheet1->write_blank(3, 10, $fheader);
			$worksheet1->merge_cells(3, 8, 3, 10);
			$worksheet1->write_string(3, 11, "TUNGGAKAN (Rp)", $fheader);
			$worksheet1->merge_cells(3, 11, 4, 11);
			
			$worksheet1->write_blank(4, 0, $fheader);
			$worksheet1->write_string(4, 1, "NAMA WP", $fheader);
			$worksheet1->write_string(4, 2, "NPWPD", $fheader);
			$worksheet1->write_string(4, 3, "ALAMAT", $fheader);
			$worksheet1->write_string(4, 4, "MASA PAJAK", $fheader);
			$worksheet1->write_string(4, 5, "TANGGAL", $fheader);
			$worksheet1->write_string(4, 6, "NOMOR", $fheader);
			$worksheet1->write_string(4, 7, "KETETAPAN (Rp)", $fheader);
			$worksheet1->write_string(4, 8, "NOMOR", $fheader);
			$worksheet1->write_string(4, 9, "TANGGAL", $fheader);
			$worksheet1->write_string(4, 10, "SETORAN (Rp)", $fheader);
			$worksheet1->write_blank(4, 11, $fheader);
			
			$worksheet1->write_number(5, 0, "1", $fheader_small);
			$worksheet1->write_number(5, 1, "2", $fheader_small);
			$worksheet1->write_number(5, 2, "3", $fheader_small);
			$worksheet1->write_number(5, 3, "4", $fheader_small);
			$worksheet1->write_number(5, 4, "5", $fheader_small);
			$worksheet1->write_number(5, 5, "6", $fheader_small);
			$worksheet1->write_number(5, 6, "7", $fheader_small);
			$worksheet1->write_number(5, 7, "8", $fheader_small);
			$worksheet1->write_number(5, 8, "9", $fheader_small);
			$worksheet1->write_number(5, 9, "10", $fheader_small);
			$worksheet1->write_number(5, 10, "11", $fheader_small);
			$worksheet1->write_number(5, 11, "12", $fheader_small);
		}
		
		$no_baris = 6;
		$no_urut = 1;
		
		//if jenis_pajak selain pajak reklame
		if ($_GET['jenis_pajak'] != "4") {			
			//load data kecamatan
			$dt_kecamatan = $this->daftar_rekapitulasi_model->get_kecamatan(
													$lap_realisasi,
													$this->input->get('jenis_pajak'), 
													$this->input->get('camat_id'),
													$bulan_pajak, 
													$tahun_pajak,
													$this->input->get('status_spt'),
													$this->input->get('jenis_restoran'),
													0
												);

			if (count($dt_kecamatan) > 0) {
				foreach ($dt_kecamatan as $camat) {
					if ($no_baris > 6)
						$no_baris++;
						
					$worksheet1->write_blank($no_baris, 0, $fkecamatan);
					$worksheet1->write_string($no_baris, 1, $camat['camat_nama'], $fkecamatan);
					$worksheet1->write_blank($no_baris, 2, $fkecamatan);
					if ($_GET['status_spt'] == "8") {
						for ($i = 3; $i <= 11; $i++)
							$worksheet1->write_blank($no_baris, $i, $fkecamatan);
					} else {
						for ($i = 3; $i <= 10; $i++)
							$worksheet1->write_blank($no_baris, $i, $fkecamatan);
					}
					
					$worksheet1->merge_cells($no_baris, 1, $no_baris, 2);
					$no_baris++;
					
					//get data wp
					if ($type_cetak == 1) {
						$dt_wp = $this->daftar_rekapitulasi_model->get_wp_kecamatan($camat['camat_id'],
																					"0".$this->input->get('jenis_pajak'),
																					$bulan_pajak,
																					$tahun_pajak);
						foreach ($dt_wp as $row_wp) {
							$worksheet1->write_number($no_baris, 0, $no_urut, $fdata);
							$worksheet1->write_string($no_baris, 1, $row_wp['wp_wr_nama'], $fdata);
							$worksheet1->write_string($no_baris, 2, $row_wp['npwprd'], $fdata_center);
							$worksheet1->write_string($no_baris, 3, strtoupper($row_wp['wp_wr_almt']), $fdata);
							
							//$baris = $no_baris + 1;
							//$worksheet1->write_formula($no_baris, 10, "=J$baris-G$baris", $fsisa);
							
							$no_urut++;
							$no_baris++;
						}
					} else {
						if ($lap_realisasi == 1) {
							$dt_rekap = $this->daftar_rekapitulasi_model->get_data_rekapitulasi(
																$lap_realisasi,
																$this->input->get('jenis_pajak'),
																$camat['camat_id'],
																$this->input->get('fDate'),														
																$this->input->get('tDate'),	
																$this->input->get('status_spt'),
																$this->input->get('jenis_restoran')
													);
						} else {
							$dt_rekap = $this->daftar_rekapitulasi_model->get_data_rekapitulasi(
																$lap_realisasi,
																$this->input->get('jenis_pajak'),
																$camat['camat_id'],
																$bulan_pajak,														
																$tahun_pajak,
																$this->input->get('status_spt'),
																$this->input->get('jenis_restoran')
													);
						}
						
						//if sptpd
						if ($_GET['status_spt'] == "8") {
							foreach ($dt_rekap as $row) {
								$worksheet1->write_number($no_baris, 0, $no_urut, $fdata);
								$worksheet1->write_string($no_baris, 1, $row['wp_wr_nama'], $fdata);
								$worksheet1->write_string($no_baris, 2, $row['npwprd'], $fdata_center);
								$worksheet1->write_string($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
								$worksheet1->write_string($no_baris, 4, date('F', strtotime($row['spt_periode_jual1'])), $fdata_center);
								$worksheet1->write_number($no_baris, 5, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								$worksheet1->write_string($no_baris, 6, $row['spt_nomor'], $fdata_center);
								$worksheet1->write_number($no_baris, 7, $row['omzet'], $fcurrency);
								$worksheet1->write_number($no_baris, 8, $row['spt_pajak'], $fcurrency);
								$worksheet1->write_string($no_baris, 9, $row['skbh_no'], $fdata_center);
								
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->write_number($no_baris, 10, ceil((strtotime($row['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								else 
									$worksheet1->write_blank($no_baris, 10, $fdate);
									
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->write_number($no_baris, 11, $row['setoran'], $fcurrency);
								else
									$worksheet1->write_blank($no_baris, 11, $fdata);
								
								$baris = $no_baris + 1;
								$worksheet1->write_formula($no_baris, 12, "=L$baris-I$baris", $fsisa);
								
								$no_urut++;
								$no_baris++;
							}
						} else {
							foreach ($dt_rekap as $row) {
								$worksheet1->write_number($no_baris, 0, $no_urut, $fdata);
								$worksheet1->write_string($no_baris, 1, $row['wp_wr_nama'], $fdata);
								$worksheet1->write_string($no_baris, 2, $row['sptrek_judul'], $fdata_center);
								$worksheet1->write_string($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
								$worksheet1->write_string($no_baris, 4,  date('F', strtotime($row['spt_periode_jual1'])), $fdata_center);
								$worksheet1->write_number($no_baris, 5, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								$worksheet1->write_string($no_baris, 6, $row['spt_nomor'], $fdata_center);
								$worksheet1->write_number($no_baris, 7, $row['spt_pajak'], $fcurrency);
								$worksheet1->write_string($no_baris, 8, $row['skbh_no'], $fdata_center);
								
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->write_number($no_baris, 9, ceil((strtotime($row['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								else 
									$worksheet1->write_blank($no_baris, 9, $fdate);
									
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->write_number($no_baris, 10, $row['setoran'], $fcurrency);
								else
									$worksheet1->write_blank($no_baris, 10, $fdata);
								
								$baris = $no_baris + 1;
								$worksheet1->write_formula($no_baris, 11, "=K$baris-H$baris", $fsisa);
								
								$no_urut++;
								$no_baris++;
							}
						}
					}
				}
				
				if ($_GET['status_spt'] == "8") {
					//bagian total
					$worksheet1->write_string($no_baris, 0, "TOTAL", $ftotal);
					$worksheet1->write_blank($no_baris, 1, $ftotal);$worksheet1->write_blank($no_baris, 2, $ftotal);$worksheet1->write_blank($no_baris, 3, $ftotal);
					$worksheet1->write_blank($no_baris, 4, $ftotal);$worksheet1->write_blank($no_baris, 5, $ftotal);$worksheet1->write_blank($no_baris, 6, $ftotal);
					$worksheet1->merge_cells($no_baris, 0, $no_baris, 6);
					$worksheet1->write_formula($no_baris, 7, "=SUM(H7:H$no_baris)", $ftotal_currency);
					$worksheet1->write_formula($no_baris, 8, "=SUM(I7:I$no_baris)", $ftotal_currency);
					$worksheet1->write_blank($no_baris, 9, $ftotal);$worksheet1->write_blank($no_baris,10, $ftotal);
					$worksheet1->merge_cells($no_baris, 9, $no_baris, 10);
					$worksheet1->write_formula($no_baris, 11, "=SUM(L7:L$no_baris)", $ftotal_currency);
					$worksheet1->write_formula($no_baris, 12, "=SUM(M7:M$no_baris)", $ftotal_sisa);
				} else {
					//bagian total
					$worksheet1->write_string($no_baris, 0, "TOTAL", $ftotal);
					$worksheet1->write_blank($no_baris, 1, $ftotal);$worksheet1->write_blank($no_baris, 2, $ftotal);$worksheet1->write_blank($no_baris, 3, $ftotal);$worksheet1->write_blank($no_baris, 4, $ftotal);
					$worksheet1->write_blank($no_baris, 5, $ftotal);$worksheet1->write_blank($no_baris, 6, $ftotal);
					$worksheet1->merge_cells($no_baris, 0, $no_baris, 6);
					$worksheet1->write_formula($no_baris, 7, "=SUM(H7:H$no_baris)", $ftotal_currency);
					$worksheet1->write_blank($no_baris, 8, $ftotal);$worksheet1->write_blank($no_baris, 9, $ftotal);
					$worksheet1->merge_cells($no_baris, 8, $no_baris, 9);
					$worksheet1->write_formula($no_baris, 10, "=SUM(K7:K$no_baris)", $ftotal_currency);
					$worksheet1->write_formula($no_baris, 11, "=SUM(L7:L$no_baris)", $ftotal_sisa);
				}
			}
		} else {
			//get data wp
			if ($lap_realisasi == 1) {
				$dt_rekap = $this->daftar_rekapitulasi_model->get_data_rekapitulasi(
													1,
													$this->input->get('jenis_pajak'),
													NULL,
													$this->input->get('fDate'),														
													$this->input->get('tDate'),
													$this->input->get('status_spt'));
			} else {
				$dt_rekap = $this->daftar_rekapitulasi_model->get_data_rekapitulasi(
													0,
													$this->input->get('jenis_pajak'),
													NULL,
													$bulan_pajak,														
													$tahun_pajak,
													$this->input->get('status_spt'));
			}
			
			
			foreach ($dt_rekap as $row) {
				$worksheet1->write_number($no_baris, 0, $no_urut, $fdata);
				$worksheet1->write_string($no_baris, 1, $row['wp_wr_nama'], $fdata);
				$worksheet1->write_string($no_baris, 2, $row['npwprd'], $fdata_center);
				$worksheet1->write_string($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
				$worksheet1->write_number($no_baris, 4, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				$worksheet1->write_number($no_baris, 5, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				$worksheet1->write_string($no_baris, 6, $row['spt_nomor'], $fdata_center);
				$worksheet1->write_number($no_baris, 7, $row['spt_pajak'], $fcurrency);
				$worksheet1->write_string($no_baris, 8, $row['skbh_no'], $fdata_center);
				
				if ($row['skbh_tgl'] != NULL)
					$worksheet1->write_number($no_baris, 9, ceil((strtotime($row['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				else 
					$worksheet1->write_blank($no_baris, 9, $fdate);
					
				if ($row['skbh_tgl'] != NULL)
					$worksheet1->write_number($no_baris, 10, $row['setoran'], $fcurrency);
				else
					$worksheet1->write_blank($no_baris, 10, $fdata);
				
				$baris = $no_baris + 1;
				$worksheet1->write_formula($no_baris, 11, "=K$baris-H$baris", $fsisa);
				
				$no_urut++;
				$no_baris++;
			}
			
			//bagian total
			$worksheet1->write_string($no_baris, 0, "TOTAL", $ftotal);
			$worksheet1->write_blank($no_baris, 1, $ftotal);$worksheet1->write_blank($no_baris, 2, $ftotal);$worksheet1->write_blank($no_baris, 3, $ftotal);
			$worksheet1->write_blank($no_baris, 4, $ftotal);$worksheet1->write_blank($no_baris, 5, $ftotal);
			$worksheet1->merge_cells($no_baris, 0, $no_baris, 6);
			$worksheet1->write_formula($no_baris, 7, "=SUM(H7:H$no_baris)", $ftotal_currency);
			$worksheet1->write_blank($no_baris, 8, $ftotal);$worksheet1->write_blank($no_baris, 9, $ftotal);
			$worksheet1->merge_cells($no_baris, 8, $no_baris, 9);
			$worksheet1->write_formula($no_baris, 10, "=SUM(k7:K$no_baris)", $ftotal_currency);
			$worksheet1->write_formula($no_baris, 11, "=SUM(L7:L$no_baris)", $ftotal_sisa);
		}
		
		//close workbook
		$workbook->close();
	}
}