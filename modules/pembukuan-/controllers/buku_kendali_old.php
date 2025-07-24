<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ini_set("memory_limit", "300M");

/**
 * Buku_kendali controller
 * @package Simpatda
 */
class Buku_kendali extends Master_Controller {
	
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('pembukuan_model');
		$this->load->model('buku_kendali_model');
		$this->load->model('common_model');
		$this->load->model('objek_pajak_model');
	}
	
	
	/**
	 * index page controller
	 */
	function index() {
		$data['keterangan_spt'] = $this->pembukuan_model->keterangan_spt();
		$data['kecamatan'] = $this->pembukuan_model->kecamatan();
		$data['jenis_pajak'] = $this->objek_pajak_model->get_jenis_pajak_by_operator(false);
		
		$year = date('Y');
		$years[$year] = $year;
		for ($i = 1; $i < 5; $i++) {
			$years[$year - $i] = $year - $i;
		}
		$data['tahun_pajak'] = $years;
		
		$this->load->view('form_buku_kendali', $data);
	}
	
	/**
	 * fungsi untuk mencetak realisasi
	 */
	function cetak_realisasi() {
		error_reporting(E_ERROR);
		
		//insert history log
		$this->common_model->history_log("pembukuan", "P", 
			"Cetak realisasi : ".$_GET['jenis_pajak_realisasi']." | ".$_GET['f_bulan_realisasi']." - ".$_GET['f_tahun_realisasi']." | ".$_GET['t_bulan_realisasi']." - ".$_GET['t_tahun_realisasi']);
		
		//add library
		require_once(APPPATH.'libraries/Worksheet.php');
		require_once(APPPATH.'libraries/Workbook.php');
		
		// number of seconds in a day
		$seconds_in_a_day = 86400;
		// Unix timestamp to Excel date difference in seconds
		$ut_to_ed_diff = $seconds_in_a_day * 25569;
		
		//load data kecamatan
		$dt_kecamatan = $this->buku_kendali_model->get_kecamatan($this->input->get('camat_id_realisasi'));
		
		 // HTTP headers
		Buku_kendali::HeaderingExcel('realisasi.xls');

		 // Creating a workbook
		$workbook=new Workbook("-");
		
		$ftitle =& $workbook->add_format();
		$ftitle->set_size(12);
		$ftitle->set_bold();
		$ftitle->set_align('left');
		$ftitle->set_font("Trebuchet MS");
		
		$fheader =& $workbook->add_format();
		$fheader->set_size(10);
		$fheader->set_bold();
		$fheader->set_border(1);
		$fheader->set_align('center');
		$fheader->set_font("Trebuchet MS");
		$fheader->set_fg_color(31);
		$fheader->set_pattern();
		
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
		
		$fmasa_pajak =& $workbook->add_format();
		$fmasa_pajak->set_num_format('mm/yy');
		$fmasa_pajak->set_align('center');
		$fmasa_pajak->set_size(9);
		$fmasa_pajak->set_border(1);
		$fmasa_pajak->set_font("Trebuchet MS");
		
		$fdate =& $workbook->add_format();
		$fdate->set_num_format('dd/mm/yy');
		$fdate->set_align('center');
		$fdate->set_size(9);
		$fdate->set_border(1);
		$fdate->set_font("Trebuchet MS");

		$fdata =& $workbook->add_format();
		$fdata->set_size(9);
		$fdata->set_align('left');
		$fdata->set_border(1);
		$fdata->set_font("Trebuchet MS");
		
		$f_bulan_realisasi = $this->input->get('f_bulan_realisasi');
		$f_tahun_realisasi = $this->input->get('f_tahun_realisasi');
		$t_bulan_realisasi = $this->input->get('t_bulan_realisasi');
		$t_tahun_realisasi = $this->input->get('t_tahun_realisasi');
		$diff_realisasi = get_diff_months($f_tahun_realisasi."-".((strlen($f_bulan_realisasi) == 1) ? "0".$f_bulan_realisasi : $f_bulan_realisasi)."-01", 
							$t_tahun_realisasi."-".((strlen($t_bulan_realisasi) == 1) ? "0".$t_bulan_realisasi : $t_bulan_realisasi)."-01");
							
		/***** Creating the first worksheet - Realisasi ***********/
		$worksheet1 =& $workbook->add_worksheet('Realisasi');
		$worksheet1->set_landscape();
		$worksheet1->freeze_panes(array(4, 3));
		$worksheet1->set_column(0,0,5);
		$worksheet1->set_column(0,1,40);
		$worksheet1->set_column(0,2,16);
		if ($diff_realisasi == 0) {
			$worksheet1->set_column(0,3,8);
			$worksheet1->set_column(0,4,10);
			$worksheet1->set_column(0,5,12);
		} elseif ($diff_realisasi > 0) {
			for ($i=1; $i <= 3 + ($diff_realisasi * 3); $i++) {
				if ($i % 3 == 0)
					$worksheet1->set_column(0, 2 + $i, 12);
				elseif ($i % 3 == 1)
					$worksheet1->set_column(0, 2 + $i, 8);
				else 
					$worksheet1->set_column(0, 2 + $i, 10);
			}			
		}
		$worksheet1->write_string(0, 0, "REALISASI ".strtoupper($this->buku_kendali_model->get_ref_pajak($this->input->get('jenis_pajak_realisasi'))), $ftitle);
		$worksheet1->merge_cells(0, 0, 0, 2);
		
		$worksheet1->set_row(2, 20);
		$worksheet1->write_string(2, 0, "NO", $fheader);
		$worksheet1->write_string(2, 1, "NAMA", $fheader);
		$worksheet1->write_string(2, 2, "NPWPD", $fheader);
		
		if ($diff_realisasi == 0) {
			$worksheet1->write_string(2, 3, getNamaBulan($f_bulan_realisasi)." ".$f_tahun_realisasi, $fheader);
			$worksheet1->write_blank(2, 4, $fheader);
			$worksheet1->write_blank(2, 5, $fheader);
			$worksheet1->merge_cells(2, 3, 2, 5);
		} elseif ($diff_realisasi > 0) {
			$diff_month = 0;
			for ($i=1; $i <= 3 + ($diff_realisasi * 3); $i++) {
				if ($i % 3 == 0) {
					$times = mktime(0, 0, 0, $f_bulan_realisasi + $diff_month, 1, $f_tahun_realisasi);
					$worksheet1->write_string(2, 3 * ($diff_month + 1), getNamaBulan(date('m', $times))." ".date('Y', $times), $fheader);
					$worksheet1->merge_cells(2, 3 * ($diff_month + 1), 2, (3 + ($diff_month + 1) * 3) - 1);
					$worksheet1->write_string(3, 3 * ($diff_month + 1), "MP", $fheader);
					$diff_month++;
				} else if ($i % 3 == 1) {
					$worksheet1->write_blank(2, $i + 3, $fheader);
					$worksheet1->write_string(3, $i + 3, "Tgl", $fheader);
				} else {
					$worksheet1->write_blank(2, $i + 3, $fheader);
					$worksheet1->write_string(3, $i + 3, "Rp", $fheader);
				}
			}	
		}
		
		$no_baris = 4;
		$dt_realisasi = $this->buku_kendali_model->get_data_realisasi($this->input->get('jenis_pajak_realisasi'), 
																	$f_bulan_realisasi, $f_tahun_realisasi, 
																	$t_bulan_realisasi, $t_tahun_realisasi,
																	$this->input->get('denda_realisasi'));
		
		if (count($dt_kecamatan) > 0) {
			foreach ($dt_kecamatan as $camat) {
				$start_baris_kecamatan = $no_baris + 2;
							
				$worksheet1->write_string($no_baris, 0, $camat['camat_nama'], $fkecamatan);
				$no_baris++;
				
				//get data wp
				$dt_wp = $this->buku_kendali_model->get_wp_kecamatan(
														$camat['camat_id'],
														"0".$this->input->get('jenis_pajak_realisasi'),														
														$this->input->get('f_bulan_realisasi'),
														$this->input->get('f_tahun_realisasi')
													);
				if (count($dt_wp) > 0) {
					$no_urut = 1;
					foreach ($dt_wp as $row_wp) {
						$tmp_baris_wp = 1;
											
						$worksheet1->write_number($no_baris, 0, $no_urut, $fdata);
						$worksheet1->write_string($no_baris, 1, $row_wp['wp_wr_nama'], $fdata);
						$worksheet1->write_string($no_baris, 2, $row_wp['npwprd'], $fdata);
						
						$diff_month = 0;						
						for ($i=0; $i <= $diff_realisasi; $i++) {							
							$times = mktime(0, 0, 0, $f_bulan_realisasi + $i, 1, $f_tahun_realisasi);
							$dt_pajak = $dt_realisasi[date('Y', $times)][date('m', $times)][$row_wp['wp_wr_id']];
							if (count($dt_pajak) > $tmp_baris_wp)
								$tmp_baris_wp = count($dt_pajak);
							
							if (count($dt_pajak) > 0) {
								$tmp_baris = 0;
								foreach ($dt_pajak as $row_pajak) {
									$worksheet1->write_number($no_baris + $tmp_baris, $diff_month + 3, ceil((strtotime($row_pajak['setorpajret_periode_jual1']) + $ut_to_ed_diff) / $seconds_in_a_day), $fmasa_pajak);
									$worksheet1->write_number($no_baris + $tmp_baris, $diff_month + 4, ceil((strtotime($row_pajak['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
									$worksheet1->write_number($no_baris + $tmp_baris, $diff_month + 5, $row_pajak['setorpajret_dt_jumlah'], $fcurrency);
									$tmp_baris++;
								}
							} else {
								$worksheet1->write_blank($no_baris, $diff_month + 3, $fdata);
								$worksheet1->write_blank($no_baris, $diff_month + 4, $fdata);
								$worksheet1->write_blank($no_baris, $diff_month + 5, $fdata);
							}
							
							$diff_month += 3;
						}

						$no_baris += $tmp_baris_wp;
						$no_urut++;
					}
				}
				
				//bagian totalnya
				$worksheet1->write_string($no_baris, 0, "TOTAL", $ftotal);
				$worksheet1->write_string($no_baris, 1, "", $ftotal);
				$worksheet1->write_string($no_baris, 2, "", $ftotal);
				$worksheet1->merge_cells($no_baris, 0, $no_baris, 2);
				$diff_month = 0;				
				for ($i=0; $i <= $diff_realisasi; $i++) {	
					$column = $diff_month + 5;
					$column_name = $this->get_name_column($column);
					
					$worksheet1->write_blank($no_baris, $diff_month + 3, $fdata);
					$worksheet1->write_blank($no_baris, $diff_month + 4, $fdata);
					if (count($dt_wp) == 0) {
						$worksheet1->write_formula($no_baris, $column, "=SUM(".$column_name."".$no_baris.":".$column_name."".$no_baris.")", $ftotal_currency);
					} else 
						$worksheet1->write_formula($no_baris, $diff_month + 5, "=SUM(".$column_name."".$start_baris_kecamatan.":".$column_name."".$no_baris.")", $ftotal_currency);

					$diff_month += 3;
					$arr_total_kecamatan[$column_name][$no_baris] = $column_name."".($no_baris+1);
				}

				$no_baris++; 
			}
			
			//bagian jumlah total
			$worksheet1->write_string($no_baris, 0, "JUMLAH TOTAL", $ftotal);
			$worksheet1->write_string($no_baris, 1, "", $ftotal);
			$worksheet1->write_string($no_baris, 2, "", $ftotal);
			$worksheet1->merge_cells($no_baris, 0, $no_baris, 2);
			$diff_month = 0;				
			for ($i=0; $i <= $diff_realisasi; $i++) {	
				$column = $diff_month + 5;
				$column_name = $this->get_name_column($column);
			
				$array = $arr_total_kecamatan[$column_name];
				//print_r($array);
				$delimiter = "";
				$arr_total = "";
				
				foreach ($array as $val) {
					$arr_total .= $val.",";
				}
				$arr_total = substr($arr_total, 0, strlen($arr_total) - 1);
				
				$worksheet1->write_blank($no_baris, $diff_month + 3, $fdata);
				$worksheet1->write_blank($no_baris, $diff_month + 4, $fdata);
				$worksheet1->write_formula($no_baris, $diff_month + 5, "=SUM(".$arr_total.")", $ftotal_currency);
				
				$diff_month += 3;
			}
		}
		/***** End Of Realisasi **************************/
		
		//close workbook
		$workbook->close();
	}
	
	/**
	 * fungsi untuk mencetak buku kendali
	 */
	function cetak_kendali() {
		error_reporting(E_ERROR);
		
		//insert history log
		$this->common_model->history_log("pembukuan", "P", 
			"Cetak buku kendali : ".$_GET['jenis_pajak_kendali']." | ".$_GET['f_bulan_kendali']." - ".$_GET['f_tahun_kendali']." | ".$_GET['t_bulan_kendali']." - ".$_GET['t_tahun_kendali']);
		
		//add library
		require_once(APPPATH.'libraries/Worksheet.php');
		require_once(APPPATH.'libraries/Workbook.php');
		
		// number of seconds in a day
		$seconds_in_a_day = 86400;
		// Unix timestamp to Excel date difference in seconds
		$ut_to_ed_diff = $seconds_in_a_day * 25569;
		
		//load data kecamatan
		$dt_kecamatan = $this->buku_kendali_model->get_kecamatan($this->input->get('camat_id_kendali'));
		
		 // HTTP headers
		Buku_kendali::HeaderingExcel('buku-kendali.xls');

		 // Creating a workbook
		$workbook=new Workbook("-");
		
		$ftitle =& $workbook->add_format();
		$ftitle->set_size(12);
		$ftitle->set_bold();
		$ftitle->set_align('left');
		$ftitle->set_font("Trebuchet MS");
		
		$fheader =& $workbook->add_format();
		$fheader->set_size(10);
		$fheader->set_bold();
		$fheader->set_border(1);
		$fheader->set_align('center');
		$fheader->set_font("Trebuchet MS");
		$fheader->set_fg_color(31);
		$fheader->set_pattern();
		
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
		
		$fmasa_pajak =& $workbook->add_format();
		$fmasa_pajak->set_num_format('mm/yy');
		$fmasa_pajak->set_align('center');
		$fmasa_pajak->set_size(9);
		$fmasa_pajak->set_border(1);
		$fmasa_pajak->set_font("Trebuchet MS");
		
		$fdate =& $workbook->add_format();
		$fdate->set_num_format('dd/mm/yy');
		$fdate->set_align('center');
		$fdate->set_size(9);
		$fdate->set_border(1);
		$fdate->set_font("Trebuchet MS");

		$fdata =& $workbook->add_format();
		$fdata->set_size(9);
		$fdata->set_align('left');
		$fdata->set_border(1);
		$fdata->set_font("Trebuchet MS");
		
		$f_bulan = $this->input->get('f_bulan_kendali');
		$f_tahun = $this->input->get('f_tahun_kendali');
		$t_bulan = $this->input->get('t_bulan_kendali');
		$t_tahun = $this->input->get('t_tahun_kendali');
		$diff_masa_pajak = get_diff_months($f_tahun."-".((strlen($f_bulan) == 1) ? "0".$f_bulan : $f_bulan)."-01", 
							$t_tahun."-".((strlen($t_bulan) == 1) ? "0".$t_bulan : $t_bulan)."-01");
							
		/***** Creating the second worksheet - Buku kendali ***********/
		$worksheet2 =& $workbook->add_worksheet('Buku Kendali');
		$worksheet2->set_landscape();
		$worksheet2->freeze_panes(array(3, 3));
		$worksheet2->set_column(0,0,5);
		$worksheet2->set_column(0,1,40);
		$worksheet2->set_column(0,2,16);
		if ($diff_masa_pajak == 0) {
			$worksheet2->set_column(0,3,10);
			$worksheet2->set_column(0,4,15);
		} elseif ($diff_masa_pajak > 0) {
			for ($i=1; $i <= 2 + ($diff_masa_pajak * 2); $i++) {
				if ($i % 2 == 0)
					$worksheet2->set_column(0, 2 + $i, 15);
				else 
					$worksheet2->set_column(0, 2 + $i, 10);
			}			
		}
		
		$worksheet2->write_string(0, 0, "BUKU KENDALI ".strtoupper($this->buku_kendali_model->get_ref_pajak($this->input->get('jenis_pajak_kendali'))), $ftitle);
		$worksheet2->merge_cells(0, 0, 0, 2);
		
		$worksheet2->set_row(2, 20);
		$worksheet2->write_string(2, 0, "NO", $fheader);
		$worksheet2->write_string(2, 1, "NAMA", $fheader);
		$worksheet2->write_string(2, 2, "NPWPD", $fheader);
		
		if ($diff_masa_pajak == 0) {
			$worksheet2->write_string(2, 3, getNamaBulan($f_bulan)." ".$f_tahun, $fheader);
			$worksheet2->write_string(2, 4, "", $fheader);
			$worksheet2->merge_cells(2, 3, 2, 4);
		} elseif ($diff_masa_pajak > 0) {
			$diff_month = 0;
			
			for ($i=1; $i <= 2 + ($diff_masa_pajak * 2); $i++) {						
				if ($i % 2 == 0) {
					$worksheet2->write_string(2, $i + 2, "", $fheader);
					$worksheet2->merge_cells(2, $i + 1, 2, (($i /2) * 2) + 2);
					$diff_month ++;
				} else {
					if ($diff_month == 0)
						$worksheet2->write_string(2, $i + 2, getNamaBulan($f_bulan)." ".$f_tahun, $fheader);
					else {
						$times = mktime(0, 0, 0, $f_bulan + $diff_month, 1, $f_tahun);
						$worksheet2->write_string(2, $i + 2, getNamaBulan(date('m', $times))." ".date('Y', $times), $fheader);
					}
				}
			}	
		}
		
		$no_baris = 3;
		$dt_penerimaan = $this->buku_kendali_model->get_data_pajak($this->input->get('jenis_pajak_kendali'), $f_bulan, 
																	$f_tahun, $t_bulan, $t_tahun, $this->input->get('denda_kendali'));
		$start_baris_kecamatan = 3;
		$arr_total_kecamatan = array();
		
		if (count($dt_kecamatan) > 0) {
			foreach ($dt_kecamatan as $camat) {
				$start_baris_kecamatan = $no_baris + 2;
							
				$worksheet2->write_string($no_baris, 0, $camat['camat_nama'], $fkecamatan);
				$no_baris++;
				
				//get data wp
				$dt_wp = $this->buku_kendali_model->get_wp_kecamatan(
														$camat['camat_id'],
														"0".$this->input->get('jenis_pajak_kendali'),														
														$this->input->get('f_bulan_kendali'),
														$this->input->get('f_tahun_kendali')
													);
				if (count($dt_wp) > 0) {
					$no_urut = 1;
					foreach ($dt_wp as $row_wp) {
						$tmp_baris_wp = 1;
											
						$worksheet2->write_number($no_baris, 0, $no_urut, $fdata);
						$worksheet2->write_string($no_baris, 1, $row_wp['wp_wr_nama'], $fdata);
						$worksheet2->write_string($no_baris, 2, $row_wp['npwprd'], $fdata);
						
						$diff_month = 0;
						
						for ($i=1; $i < 2 + ($diff_masa_pajak * 2); $i++) {
							if ($i == $diff_masa_pajak + 2)
								break;
							
							$times = mktime(0, 0, 0, $f_bulan + $diff_month, 1, $f_tahun);
							$dt_pajak = $dt_penerimaan[date('Y', $times)][date('m', $times)][$row_wp['wp_wr_id']];
							if (count($dt_pajak) > $tmp_baris_wp)
								$tmp_baris_wp = count($dt_pajak);
							
							if (count($dt_pajak) > 0) {
								$tmp_baris = 0;
								foreach ($dt_pajak as $row_pajak) {
									$worksheet2->write_number($no_baris + $tmp_baris, $i + $diff_month + 2, ceil((strtotime($row_pajak['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
									$worksheet2->write_number($no_baris + $tmp_baris, $i + $diff_month + 3, $row_pajak['setorpajret_dt_jumlah'], $fcurrency);
									$tmp_baris++;
								}
							} else {
								$worksheet2->write_blank($no_baris, $i + $diff_month + 2, $fdata);
								$worksheet2->write_blank($no_baris, $i + $diff_month + 3, $fdata);
							}
							
							$diff_month++;
						}
						
						$no_baris += $tmp_baris_wp;
						$no_urut++;
					}
				}
				
				//bagian totalnya
				$worksheet2->write_string($no_baris, 0, "TOTAL", $ftotal);
				$worksheet2->write_string($no_baris, 1, "", $ftotal);
				$worksheet2->write_string($no_baris, 2, "", $ftotal);
				$worksheet2->merge_cells($no_baris, 0, $no_baris, 2);
				$diff_month = 0;
					
				for ($i=1; $i < 2 + ($diff_masa_pajak * 2); $i++) {
					if ($i == $diff_masa_pajak + 2)
						break;
						
					$worksheet2->write_string($no_baris, $i + $diff_month + 2,"", $fdata);
					$column = $i + $diff_month + 3;
					$column_name = $this->get_name_column($column);
					if (count($dt_wp) == 0) {
						$worksheet2->write_formula($no_baris, $column, "=SUM(".$column_name."".$no_baris.":".$column_name."".$no_baris.")", $ftotal_currency);
					} else 
						$worksheet2->write_formula($no_baris, $column, "=SUM(".$column_name."".$start_baris_kecamatan.":".$column_name."".$no_baris.")", $ftotal_currency);
					
					$arr_total_kecamatan[$column_name][$no_baris] = $column_name."".($no_baris+1);
					$diff_month ++;
				}
				
				$no_baris++;
			}
			
			//bagian jumlah total
			$worksheet2->write_string($no_baris, 0, "JUMLAH TOTAL", $ftotal);
			$worksheet2->write_string($no_baris, 1, "", $ftotal);
			$worksheet2->write_string($no_baris, 2, "", $ftotal);
			$worksheet2->merge_cells($no_baris, 0, $no_baris, 2);
			$diff_month = 0;
			for ($i=1; $i < 2 + ($diff_masa_pajak * 2); $i++) {
				if ($i == $diff_masa_pajak + 2)
					break;
					
				$worksheet2->write_string($no_baris, $i + $diff_month + 2,"", $fdata);
				$column = $i + $diff_month + 3;
				$column_name = $this->get_name_column($column);
				
				$array = $arr_total_kecamatan[$column_name];
				//print_r($array);
				$delimiter = "";
				$arr_total = "";
				
				foreach ($array as $val) {
					$arr_total .= $val.",";
				}
				$arr_total = substr($arr_total, 0, strlen($arr_total) - 1);
				
				$worksheet2->write_formula($no_baris, $column, "=SUM(".$arr_total.")", $ftotal_currency);
				
				$diff_month ++;
			}
		}
		
		//close workbook
		$workbook->close();
	}	
	
	function HeaderingExcel($filename){
	    header("Content-type:application/vnd.ms-excel");
	    header("Content-Disposition:attachment;filename=$filename");
	    header("Expires:0");
	    header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
	    header("Pragma: public");
	}
	
	function get_name_column($num, $index=0) {
        $index = abs($index*1); //make sure index is a positive integer
        $numeric = ($num - $index) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num -$index) / 26);
        if ($num2 > 0) {
            return $this->get_name_column($num2 - 1 + $index) . $letter;
        } else {
            return $letter;
        }
    }
    
	function has_next($array) {
	    if (is_array($array)) {
	        if (next($array) === false) {
	            return false;
	        } else {
	            return true;
	        }
	    } else {
	        return false;
	    }
	}
}
