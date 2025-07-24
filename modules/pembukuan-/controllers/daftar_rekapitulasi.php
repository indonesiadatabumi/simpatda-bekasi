<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ini_set("memory_limit", "1000M");

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
		$this->load->model('daftar_rekapitulasi_pendataan_model');
		$this->load->model('skpdkb_model');
		$this->load->model('stpd_model');
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
			"Cetak daftar rekapitulasi : ".$_GET['jenis_pajak']." | ".$_GET['jenis_restoran']." | ".$_GET['bulan_masa_pajak']." - ".$_GET['tahun_masa_pajak']." | ".$_GET['status_spt']." | ".$_GET['camat_id']);

		if ($this->input->get('semua_wp') == "0" || $this->input->get('semua_wp') == null) 
		{
			if ($this->input->get('lap') == "realisasi")
			{
				if($this->input->get('status_spt') == "11")
					$this->cetak_daftar_skpdkb(0,1);
				else if ($this->input->get('status_spt') == "3")
					$this->cetak_daftar_stpd(0,1);
				else 
					$this->cetak_daftar(0, 1);
			}
			else 
			{
				if($this->input->get('status_spt') == "11")
					$this->cetak_daftar_skpdkb(0,0);
				else if ($this->input->get('status_spt') == "3")
					$this->cetak_daftar_stpd(0,0);
				else
					$this->cetak_daftar(0, 0);
			}
		} 
		else {
			$this->cetak_daftar(1);
		}
	}

	function cetak_tgl_pendataan() {
		//insert history log
		$this->common_model->history_log("pembukuan", "P", 
			"Cetak daftar rekapitulasi : ".$_GET['jenis_pajak_pendataan']." | ".$_GET['jenis_restoran']." | ".$_GET['bulan_masa_pajak']." - ".$_GET['tahun_masa_pajak']." | ".$_GET['status_spt']." | ".$_GET['camat_id_pendataan']);

		if ($this->input->get('semua_wp') == "0" || $this->input->get('semua_wp') == null) 
		{
			if ($this->input->get('lap') == "pendataan")
			{
				if($this->input->get('status_spt') == "11")
					$this->cetak_daftar_skpdkb(0,1);
				else if ($this->input->get('status_spt') == "3")
					$this->cetak_daftar_stpd(0,1);
				else 
					$this->cetak_pendataan(0, 1);
			}
			else 
			{
				if($this->input->get('status_spt') == "11")
					$this->cetak_daftar_skpdkb(0,0);
				else if ($this->input->get('status_spt') == "3")
					$this->cetak_daftar_stpd(0,0);
				else
					$this->cetak_pendataan(0, 0);
			}
		} 
		else {
			$this->cetak_pendataan(1);
		}
	}

	/**
	 * cetak daftar
	 * @param unknown_type $type_cetak : 0 = hanya spt yang dilapor | 1 = semua data
	 * @param $jenis_laporan
	 */
	function cetak_daftar($type_cetak = 0, $lap_realisasi = 1) 
	{
		error_reporting(E_ERROR);

		//add library	
		require FCPATH."vendor/autoload.php";

		// number of seconds in a day
		$seconds_in_a_day = 86400;
		// Unix timestamp to Excel date difference in seconds
		$ut_to_ed_diff = $seconds_in_a_day * 25569;
		$bulan_pajak = $this->input->get('bulan_masa_pajak');
		$tahun_pajak = $this->input->get('tahun_masa_pajak');
		
		// Create an instance 
		$workbook =& new Spreadsheet_Excel_Writer(); 

		// Send HTTP headers to tell the browser what's coming 
		$workbook->send("daftar-rekapitulasi.xls"); 
		
		$ftitle =& $workbook->addFormat();
		$ftitle->setSize(12);
		$ftitle->setBold();
		$ftitle->setAlign('center');
		$ftitle->setFontFamily("Trebuchet MS");		
		
		$fheader =& $workbook->addFormat();
		$fheader->setSize(10);
		$fheader->setBold();
		$fheader->setBorder(1);
		$fheader->setAlign('center');
		$fheader->setFontFamily("Trebuchet MS");
		
		$fheader_small =& $workbook->addFormat();
		$fheader_small->setSize(7);
		$fheader_small->setBold();
		$fheader_small->setBorder(1);
		$fheader_small->setAlign('center');
		$fheader_small->setFontFamily("Trebuchet MS");
		
		$fkecamatan =& $workbook->addFormat();
		$fkecamatan->setSize(10);
		$fkecamatan->setBold();
		$fkecamatan->setBorder(1);
		$fkecamatan->setAlign('left');
		$fkecamatan->setFontFamily("Trebuchet MS");
		
		$ftotal =& $workbook->addFormat();
		$ftotal->setSize(9);
		$ftotal->setBold();
		$ftotal->setAlign('center');
		$ftotal->setFontFamily("Trebuchet MS");
		$ftotal->setBorder(1);
		
		$ftotal_currency =& $workbook->addFormat();
		$ftotal_currency->setSize(9);
		$ftotal_currency->setNumFormat("#,##0");
		$ftotal_currency->setBold();
		$ftotal_currency->setAlign('right');
		$ftotal_currency->setFontFamily("Trebuchet MS");
		$ftotal_currency->setBorder(1);
		
		$fcurrency =& $workbook->addFormat();
		$fcurrency->setNumFormat("#,##0");
		$fcurrency->setAlign('right');
		$fcurrency->setSize(9);
		$fcurrency->setBorder(1);
		$fcurrency->setFontFamily("Trebuchet MS");
		
		$fsisa =& $workbook->addFormat();
		$fsisa->setNumFormat("#,##0_);[Red](#,##0)");
		$fsisa->setAlign('right');
		$fsisa->setSize(9);
		$fsisa->setBorder(1);
		$fsisa->setFontFamily("Trebuchet MS");
		
		$ftotal_sisa =& $workbook->addFormat();
		$ftotal_sisa->setNumFormat("#,##0_);[Red](#,##0)");
		$ftotal_sisa->setAlign('right');
		$ftotal_sisa->setBold();
		$ftotal_sisa->setSize(9);
		$ftotal_sisa->setBorder(1);
		$ftotal_sisa->setFontFamily("Trebuchet MS");
		
		$fdate =& $workbook->addFormat();
		$fdate->setNumFormat('dd/mm/yyyy');
		$fdate->setAlign('center');
		$fdate->setSize(9);
		$fdate->setBorder(1);
		$fdate->setFontFamily("Trebuchet MS");

		$fdata =& $workbook->addFormat();
		$fdata->setSize(9);
		$fdata->setAlign('left');
		$fdata->setBorder(1);
		$fdata->setFontFamily("Trebuchet MS");
		
		$fdata_center =& $workbook->addFormat();
		$fdata_center->setSize(9);
		$fdata_center->setAlign('center');
		$fdata_center->setBorder(1);
		$fdata_center->setFontFamily("Trebuchet MS");
		
		// Add a worksheet to the file, returning an object to add data to 		

		$worksheet1 =& $workbook->addWorksheet('Daftar Rekapitulasi');
		$worksheet1->setLandscape();

		if ($_GET['status_spt'] == "8") {
			$worksheet1->setColumn(0,0,5);
			$worksheet1->setColumn(0,1,30);
			$worksheet1->setColumn(0,2,15);
			$worksheet1->setColumn(0,3,30);
			$worksheet1->setColumn(0,4,15);
			$worksheet1->setColumn(0,5,10);
			$worksheet1->setColumn(0,6,7);
			$worksheet1->setColumn(0,7,15);
			$worksheet1->setColumn(0,8,14);
			$worksheet1->setColumn(0,9,15);
			$worksheet1->setColumn(0,10,10);
			$worksheet1->setColumn(0,11,14);
			$worksheet1->setColumn(0,12,16);
		} 
		else {
			$worksheet1->setColumn(0,0,5);
			$worksheet1->setColumn(0,1,30);
			$worksheet1->setColumn(0,2,15);
			$worksheet1->setColumn(0,3,30);
			$worksheet1->setColumn(0,4,14);
			$worksheet1->setColumn(0,5,10);
			$worksheet1->setColumn(0,6,7);
			$worksheet1->setColumn(0,7,14);
			$worksheet1->setColumn(0,8,15);
			$worksheet1->setColumn(0,9,10);
			$worksheet1->setColumn(0,10,14);
			$worksheet1->setColumn(0,11,16);
		}
		
		$ket_spt = strtoupper($this->daftar_rekapitulasi_model->get_keterangan_spt($_GET['status_spt']));
		$nama_pajak = strtoupper($this->daftar_rekapitulasi_model->get_ref_pajak($this->input->get('jenis_pajak')));
		$worksheet1->writeString(0, 0, "DAFTAR REKAPITULASI $ket_spt DAN REALISASI $nama_pajak", $ftitle);
		
		if ($lap_realisasi == 1)
		{
			$worksheet1->writeString(1, 0, "Tanggal Realisasi ".format_tgl($this->input->get('fDate'), true, true, false)." - ".
							format_tgl($this->input->get('tDate'), true, true, false), $ftitle);

		}
		else
		{
			$worksheet1->writeString(1, 0, "MASA PAJAK ".strtoupper(getNamaBulan($bulan_pajak))." ".$tahun_pajak, $ftitle);
		}


		if ($_GET['status_spt'] == "8") 
		{
			$worksheet1->mergeCells(0, 0, 0, 12);
			$worksheet1->mergeCells(1, 0, 1, 12);
			
			$worksheet1->writeString(3, 0, "NO", $fheader);
			$worksheet1->mergeCells(3, 0, 4, 0);
			$worksheet1->writeString(3, 1, "WAJIB PAJAK", $fheader);
			$worksheet1->writeBlank(3, 2, $fheader);$worksheet1->writeBlank(3, 3, $fheader);$worksheet1->writeBlank(3, 4, $fheader);
			$worksheet1->mergeCells(3, 1, 3, 4);
			$worksheet1->writeString(3, 5, "$ket_spt", $fheader);
			$worksheet1->writeBlank(3, 6, $fheader);$worksheet1->writeBlank(3, 7, $fheader);$worksheet1->writeBlank(3, 8, $fheader);
			$worksheet1->mergeCells(3, 5, 3, 8);
			$worksheet1->writeString(3, 9, "STS", $fheader);
			$worksheet1->writeBlank(3, 10, $fheader);$worksheet1->writeBlank(3, 11, $fheader);
			$worksheet1->mergeCells(3, 9, 3, 11);
			$worksheet1->writeString(3, 12, "TUNGGAKAN (Rp)", $fheader);
			$worksheet1->mergeCells(3, 12, 4, 12);
			
			$worksheet1->writeBlank(4, 0, $fheader);
			$worksheet1->writeString(4, 1, "NAMA WP", $fheader);
			$worksheet1->writeString(4, 2, "NPWPD", $fheader);
			$worksheet1->writeString(4, 3, "ALAMAT", $fheader);
			$worksheet1->writeString(4, 4, "MASA PAJAK", $fheader);
			$worksheet1->writeString(4, 5, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 6, "NOMOR", $fheader);
			$worksheet1->writeString(4, 7, "OMZET (Rp)", $fheader);
			$worksheet1->writeString(4, 8, "PAJAK (Rp)", $fheader);
			$worksheet1->writeString(4, 9, "NOMOR", $fheader);
			$worksheet1->writeString(4, 10, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 11, "SETORAN (Rp)", $fheader);
			$worksheet1->writeBlank(4, 12, $fheader);
			
			$worksheet1->writeNumber(5, 0, "1", $fheader_small);
			$worksheet1->writeNumber(5, 1, "2", $fheader_small);
			$worksheet1->writeNumber(5, 2, "3", $fheader_small);
			$worksheet1->writeNumber(5, 3, "4", $fheader_small);
			$worksheet1->writeNumber(5, 4, "5", $fheader_small);
			$worksheet1->writeNumber(5, 5, "6", $fheader_small);
			$worksheet1->writeNumber(5, 6, "7", $fheader_small);
			$worksheet1->writeNumber(5, 7, "8", $fheader_small);
			$worksheet1->writeNumber(5, 8, "9", $fheader_small);
			$worksheet1->writeNumber(5, 9, "10", $fheader_small);
			$worksheet1->writeNumber(5, 10, "11", $fheader_small);
			$worksheet1->writeNumber(5, 11, "12", $fheader_small);
			$worksheet1->writeNumber(5, 12, "13", $fheader_small);
		} 
		else {
			$worksheet1->mergeCells(0, 0, 0, 11);
			$worksheet1->mergeCells(1, 0, 1, 11);
			
			$worksheet1->writeString(3, 0, "NO", $fheader);
			$worksheet1->mergeCells(3, 0, 4, 0);
			$worksheet1->writeString(3, 1, "WAJIB PAJAK", $fheader);
			$worksheet1->writeBlank(3, 2, $fheader);$worksheet1->writeBlank(3, 3, $fheader);$worksheet1->writeBlank(3, 4, $fheader);
			$worksheet1->mergeCells(3, 1, 3, 4);
			$worksheet1->writeString(3, 5, "$ket_spt", $fheader);
			$worksheet1->writeBlank(3, 6, $fheader);$worksheet1->writeBlank(3, 7, $fheader);
			$worksheet1->mergeCells(3, 5, 3, 7);
			$worksheet1->writeString(3, 8, "STS", $fheader);
			$worksheet1->writeBlank(3, 8, $fheader);$worksheet1->writeBlank(3, 9, $fheader);$worksheet1->writeBlank(3, 10, $fheader);
			$worksheet1->mergeCells(3, 8, 3, 10);
			$worksheet1->writeString(3, 11, "TUNGGAKAN (Rp)", $fheader);
			$worksheet1->mergeCells(3, 11, 4, 11);
			
			$worksheet1->writeBlank(4, 0, $fheader);
			$worksheet1->writeString(4, 1, "NAMA WP", $fheader);
			$worksheet1->writeString(4, 2, "NPWPD", $fheader);
			$worksheet1->writeString(4, 3, "ALAMAT", $fheader);
			$worksheet1->writeString(4, 4, "MASA PAJAK", $fheader);
			$worksheet1->writeString(4, 5, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 6, "NOMOR", $fheader);
			$worksheet1->writeString(4, 7, "KETETAPAN (Rp)", $fheader);
			$worksheet1->writeString(4, 8, "NOMOR", $fheader);
			$worksheet1->writeString(4, 9, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 10, "SETORAN (Rp)", $fheader);
			$worksheet1->writeBlank(4, 11, $fheader);
			
			$worksheet1->writeNumber(5, 0, "1", $fheader_small);
			$worksheet1->writeNumber(5, 1, "2", $fheader_small);
			$worksheet1->writeNumber(5, 2, "3", $fheader_small);
			$worksheet1->writeNumber(5, 3, "4", $fheader_small);
			$worksheet1->writeNumber(5, 4, "5", $fheader_small);
			$worksheet1->writeNumber(5, 5, "6", $fheader_small);
			$worksheet1->writeNumber(5, 6, "7", $fheader_small);
			$worksheet1->writeNumber(5, 7, "8", $fheader_small);
			$worksheet1->writeNumber(5, 8, "9", $fheader_small);
			$worksheet1->writeNumber(5, 9, "10", $fheader_small);
			$worksheet1->writeNumber(5, 10, "11", $fheader_small);
			$worksheet1->writeNumber(5, 11, "12", $fheader_small);
		}

		$no_baris = 6;
		$no_urut = 1;
		
		//if jenis_pajak selain pajak reklame
		if ($_GET['jenis_pajak'] != "4") 
		{
			$tot_omzet = 0;
			$tot_setoran = 0;
			$tot_tunggakan = 0;

			//load data kecamatan
			$dt_kecamatan = $this->daftar_rekapitulasi_model->get_kecamatan(
													$lap_realisasi,
													$this->input->get('jenis_pajak'), 
													$this->input->get('camat_id'),
													$bulan_pajak, 
													$tahun_pajak,
													$this->input->get('status_spt'),0
												);

			if (count($dt_kecamatan) > 0) 
			{

				foreach ($dt_kecamatan as $camat) 
				{
					if ($no_baris > 6)
						$no_baris++;
						
					$worksheet1->writeBlank($no_baris, 0, $fkecamatan);
					$worksheet1->writeString($no_baris, 1, $camat['camat_nama'], $fkecamatan);
					$worksheet1->writeBlank($no_baris, 2, $fkecamatan);
					if ($_GET['status_spt'] == "8") {
						for ($i = 3; $i <= 12; $i++)
							$worksheet1->writeBlank($no_baris, $i, $fkecamatan);
					} else {
						for ($i = 3; $i <= 11; $i++)
							$worksheet1->writeBlank($no_baris, $i, $fkecamatan);
					}
					
					$worksheet1->mergeCells($no_baris, 1, $no_baris, 2);
					$no_baris++;
					
					//get data wp
					if ($type_cetak == 1) {
						$dt_wp = $this->daftar_rekapitulasi_model->get_wp_kecamatan($camat['camat_id'],
																					"0".$this->input->get('jenis_pajak'),
																					$this->input->get('jenis_restoran'),
																					$bulan_pajak,
																					$tahun_pajak);
						foreach ($dt_wp as $row_wp) {
							$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
							$worksheet1->writeString($no_baris, 1, $row_wp['wp_wr_nama'], $fdata);
							$worksheet1->writeString($no_baris, 2, $row_wp['npwprd'], $fdata_center);
							$worksheet1->writeString($no_baris, 3, strtoupper($row_wp['wp_wr_almt']), $fdata);
							
							//$baris = $no_baris + 1;
							//$worksheet1->writeFormula($no_baris, 10, "=J$baris-G$baris", $fsisa);
							
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
																$this->input->get('status_spt')
																,$this->input->get('jenis_restoran')
													);
						} else {
							$dt_rekap = $this->daftar_rekapitulasi_model->get_data_rekapitulasi(
																$lap_realisasi,
																$this->input->get('jenis_pajak'),
																$camat['camat_id'],
																$bulan_pajak,														
																$tahun_pajak,
																$this->input->get('status_spt')
																,$this->input->get('jenis_restoran')
													);
						}
						
						//if sptpd
						if ($_GET['status_spt'] == "8") {

							foreach ($dt_rekap as $row) 
							{
								$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
								$worksheet1->writeString($no_baris, 1, $row['wp_wr_nama'], $fdata);
								$worksheet1->writeString($no_baris, 2, $row['npwprd'], $fdata_center);
								$worksheet1->writeString($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
								$worksheet1->writeString($no_baris, 4, date('F, Y', strtotime($row['spt_periode_jual1'])), $fdata_center);
								$worksheet1->writeNumber($no_baris, 5, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								$worksheet1->writeString($no_baris, 6, $row['spt_nomor'], $fdata_center);
								$worksheet1->writeNumber($no_baris, 7, $row['omzet'], $fcurrency);
								$worksheet1->writeNumber($no_baris, 8, $row['spt_pajak'], $fcurrency);
								$worksheet1->writeString($no_baris, 9, $row['skbh_no'], $fdata_center);
								
								if ($row['skbh_tgl'] != NULL){
									$worksheet1->writeNumber($no_baris, 10, ceil((strtotime($row['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								}
								else 
									$worksheet1->writeBlank($no_baris, 10, $fdate);
									
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->writeNumber($no_baris, 11, $row['setoran'], $fcurrency);
								else
									$worksheet1->writeBlank($no_baris, 11, $fdata);

								
								$baris = $no_baris + 1;
								
								$tunggakan = $row['setoran']-$row['spt_pajak'];
								$worksheet1->writeNumber($no_baris,12,$tunggakan,$fsisa);

								// $worksheet1->writeFormula($no_baris, 12, "=L".$baris."-I".$baris, $fsisa);
								
								$no_urut++;
								$no_baris++;

								$tot_omzet += $row['omzet'];
								$tot_setoran += $row['setoran'];
								$tot_tunggakan += $tunggakan;

							}
						} 
						else {
							foreach ($dt_rekap as $row) {
								$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
								$worksheet1->writeString($no_baris, 1, $row['wp_wr_nama'], $fdata);
								$worksheet1->writeString($no_baris, 2, $row['npwprd'], $fdata_center);
								$worksheet1->writeString($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
								$worksheet1->writeString($no_baris, 4, date('F, Y', strtotime($row['spt_periode_jual1'])), $fdata_center);
								$worksheet1->writeNumber($no_baris, 5, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								$worksheet1->writeString($no_baris, 6, $row['spt_nomor'], $fdata_center);
								$worksheet1->writeNumber($no_baris, 7, $row['spt_pajak'], $fcurrency);
								$worksheet1->writeString($no_baris, 8, $row['skbh_no'], $fdata_center);
								
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->writeNumber($no_baris, 9, ceil((strtotime($row['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								else 
									$worksheet1->writeBlank($no_baris, 9, $fdate);
									
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->writeNumber($no_baris, 10, $row['setoran'], $fcurrency);
								else
									$worksheet1->writeBlank($no_baris, 10, $fdata);
								
								$baris = $no_baris + 1;

								$tunggakan = $row['setoran']-$row['spt_pajak'];
								$worksheet1->writeNumber($no_baris,11,$tunggakan,$fsisa);

								// $worksheet1->writeFormula($no_baris, 11, "=K".$baris."-H".$baris, $fsisa);
								
								$no_urut++;
								$no_baris++;

								$tot_omzet += $row['omzet'];
								$tot_setoran += $row['setoran'];
								$tot_tunggakan += $tunggakan;
							}
						}
						
					}
				}
				
				if ($_GET['status_spt'] == "8") {
					//bagian total
					$worksheet1->writeString($no_baris, 0, "TOTAL", $ftotal);
					$worksheet1->writeBlank($no_baris, 1, $ftotal);$worksheet1->writeBlank($no_baris, 2, $ftotal);$worksheet1->writeBlank($no_baris, 3, $ftotal);
					$worksheet1->writeBlank($no_baris, 4, $ftotal);$worksheet1->writeBlank($no_baris, 5, $ftotal);$worksheet1->writeBlank($no_baris, 6, $ftotal);
					$worksheet1->mergeCells($no_baris, 0, $no_baris, 6);

					// $worksheet1->write_formula($no_baris, 7, "=SUM(H7:H".$no_baris.")", $ftotal_currency);
					$worksheet1->writeNumber($no_baris, 7, $tot_omzet, $ftotal_currency);
					
					//$worksheet1->writeFormula($no_baris, 8, "=SUM(I7:I$no_baris)", $ftotal_currency);
					$worksheet1->writeBlank($no_baris, 8, $ftotal);
					$worksheet1->writeBlank($no_baris,9, $ftotal);
					$worksheet1->mergeCells($no_baris, 8, $no_baris, 10);$worksheet1->writeBlank($no_baris,10, $ftotal);
					
					// $worksheet1->write_formula($no_baris, 11, "=SUM(L7:L".$no_baris.")", $ftotal_currency);
					$worksheet1->writeNumber($no_baris, 11, $tot_setoran, $ftotal_currency);

					// $worksheet1->write_formula($no_baris, 12, "=SUM(M7:M".$no_baris.")", $ftotal_sisa);
					$worksheet1->writeNumber($no_baris, 12, $tot_tunggakan, $ftotal_sisa);
				} 
				else {
					//bagian total
					$worksheet1->writeString($no_baris, 0, "TOTAL", $ftotal);
					$worksheet1->writeBlank($no_baris, 1, $ftotal);$worksheet1->writeBlank($no_baris, 2, $ftotal);$worksheet1->writeBlank($no_baris, 3, $ftotal);$worksheet1->writeBlank($no_baris, 4, $ftotal);
					$worksheet1->writeBlank($no_baris, 5, $ftotal);$worksheet1->writeBlank($no_baris, 6, $ftotal);
					$worksheet1->mergeCells($no_baris, 0, $no_baris, 6);
					
					// $worksheet1->write_formula($no_baris, 7, "=SUM(H7:H".$no_baris.")", $ftotal_currency);
					$worksheet1->writeNumber($no_baris, 7, $tot_omzet, $ftotal_currency);

					$worksheet1->writeBlank($no_baris, 8, $ftotal);$worksheet1->writeBlank($no_baris, 9, $ftotal);
					$worksheet1->mergeCells($no_baris, 8, $no_baris, 9);

					// $worksheet1->write_formula($no_baris, 10, "=SUM(K7:K".$no_baris.")", $ftotal_currency);
					$worksheet1->writeNumber($no_baris, 10, $tot_setoran, $ftotal_currency);

					// $worksheet1->write_formula($no_baris, 11, "=SUM(L7:L".$no_baris.")", $ftotal_sisa);
					$worksheet1->writeNumber($no_baris, 11, $tot_tunggakan, $ftotal_sisa);
				}
				
				
			}
		} 
		
		else 
		
		{

			$tot_pajak = 0;
			$tot_setoran = 0;
			$tot_tunggakan = 0;

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
				$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
				$worksheet1->writeString($no_baris, 1, $row['wp_wr_nama'], $fdata);
				$worksheet1->writeString($no_baris, 2, $row['npwprd'], $fdata_center);
				$worksheet1->writeString($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
				$worksheet1->writeNumber($no_baris, 4, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				$worksheet1->writeNumber($no_baris, 5, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				$worksheet1->writeString($no_baris, 6, $row['spt_nomor'], $fdata_center);
				$worksheet1->writeNumber($no_baris, 7, $row['spt_pajak'], $fcurrency);
				$worksheet1->writeString($no_baris, 8, $row['skbh_no'], $fdata_center);
				
				if ($row['skbh_tgl'] != NULL)
					$worksheet1->writeNumber($no_baris, 9, ceil((strtotime($row['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				else 
					$worksheet1->writeBlank($no_baris, 9, $fdate);
					
				if ($row['skbh_tgl'] != NULL)
					$worksheet1->writeNumber($no_baris, 10, $row['setoran'], $fcurrency);
				else
					$worksheet1->writeBlank($no_baris, 10, $fdata);
				
				$baris = $no_baris + 1;

				$tunggakan = $row['setoran'] - $row['spt_pajak'];
				$worksheet1->writeNumber($no_baris,11,$tunggakan,$fsisa);

				// $worksheet1->writeFormula($no_baris, 11, "=K".$baris."-H".$baris, $fsisa);
				
				$no_urut++;
				$no_baris++;

				$tot_pajak += $row['spt_pajak'];
				$tot_setoran += $row['setoran'];
				$tot_tunggakan += $tunggakan;

			}
			
			//bagian total
			$worksheet1->writeString($no_baris, 0, "TOTAL", $ftotal);
			$worksheet1->writeBlank($no_baris, 1, $ftotal);$worksheet1->writeBlank($no_baris, 2, $ftotal);$worksheet1->writeBlank($no_baris, 3, $ftotal);
			$worksheet1->writeBlank($no_baris, 4, $ftotal);$worksheet1->writeBlank($no_baris, 5, $ftotal);$worksheet1->writeBlank($no_baris, 6, $ftotal);
			$worksheet1->mergeCells($no_baris, 0, $no_baris, 6);
			
			$worksheet1->writeNumber($no_baris,7,$tot_setoran,$fcurrency);
			// $worksheet1->writeFormula($no_baris, 7, "=SUM(H7:H".$no_baris.")", $ftotal_currency);
			
			$worksheet1->writeBlank($no_baris, 8, $ftotal);$worksheet1->writeBlank($no_baris, 9, $ftotal);
			$worksheet1->mergeCells($no_baris, 8, $no_baris, 9);

			$worksheet1->writeNumber($no_baris,10,$tot_setoran,$fcurrency);
			// $worksheet1->writeFormula($no_baris, 10, "=SUM(K7:K".$no_baris.")", $ftotal_currency);

			$worksheet1->writeNumber($no_baris,11,$tot_tunggakan,$ftotal_sisa);
			// $worksheet1->writeFormula($no_baris, 11, "=SUM(L7:L".$no_baris.")", $ftotal_sisa);
		}
		
		// Finish the spreadsheet, dumping it to the browser 
		$workbook->close(); 	
				
	}
	
	/**
	 * cetak daftar tgl pendataan
	 * @param unknown_type $type_cetak : 0 = hanya spt yang dilapor | 1 = semua data
	 * @param $jenis_laporan
	 */
	function cetak_pendataan($type_cetak = 0, $pendataan = 1) 
	{
		error_reporting(E_ERROR);

		//add library	
		require FCPATH."vendor/autoload.php";

		// number of seconds in a day
		$seconds_in_a_day = 86400;
		// Unix timestamp to Excel date difference in seconds
		$ut_to_ed_diff = $seconds_in_a_day * 25569;
		$bulan_pajak = $this->input->get('bulan_masa_pajak');
		$tahun_pajak = $this->input->get('tahun_masa_pajak');
		
		// Create an instance 
		$workbook =& new Spreadsheet_Excel_Writer(); 

		// Send HTTP headers to tell the browser what's coming 
		$workbook->send("daftar-rekapitulasi-pendataan.xls"); 
		
		$ftitle =& $workbook->addFormat();
		$ftitle->setSize(12);
		$ftitle->setBold();
		$ftitle->setAlign('center');
		$ftitle->setFontFamily("Trebuchet MS");		
		
		$fheader =& $workbook->addFormat();
		$fheader->setSize(10);
		$fheader->setBold();
		$fheader->setBorder(1);
		$fheader->setAlign('center');
		$fheader->setFontFamily("Trebuchet MS");
		
		$fheader_small =& $workbook->addFormat();
		$fheader_small->setSize(7);
		$fheader_small->setBold();
		$fheader_small->setBorder(1);
		$fheader_small->setAlign('center');
		$fheader_small->setFontFamily("Trebuchet MS");
		
		$fkecamatan =& $workbook->addFormat();
		$fkecamatan->setSize(10);
		$fkecamatan->setBold();
		$fkecamatan->setBorder(1);
		$fkecamatan->setAlign('left');
		$fkecamatan->setFontFamily("Trebuchet MS");
		
		$ftotal =& $workbook->addFormat();
		$ftotal->setSize(9);
		$ftotal->setBold();
		$ftotal->setAlign('center');
		$ftotal->setFontFamily("Trebuchet MS");
		$ftotal->setBorder(1);
		
		$ftotal_currency =& $workbook->addFormat();
		$ftotal_currency->setSize(9);
		$ftotal_currency->setNumFormat("#,##0");
		$ftotal_currency->setBold();
		$ftotal_currency->setAlign('right');
		$ftotal_currency->setFontFamily("Trebuchet MS");
		$ftotal_currency->setBorder(1);
		
		$fcurrency =& $workbook->addFormat();
		$fcurrency->setNumFormat("#,##0");
		$fcurrency->setAlign('right');
		$fcurrency->setSize(9);
		$fcurrency->setBorder(1);
		$fcurrency->setFontFamily("Trebuchet MS");
		
		$fsisa =& $workbook->addFormat();
		$fsisa->setNumFormat("#,##0_);[Red](#,##0)");
		$fsisa->setAlign('right');
		$fsisa->setSize(9);
		$fsisa->setBorder(1);
		$fsisa->setFontFamily("Trebuchet MS");
		
		$ftotal_sisa =& $workbook->addFormat();
		$ftotal_sisa->setNumFormat("#,##0_);[Red](#,##0)");
		$ftotal_sisa->setAlign('right');
		$ftotal_sisa->setBold();
		$ftotal_sisa->setSize(9);
		$ftotal_sisa->setBorder(1);
		$ftotal_sisa->setFontFamily("Trebuchet MS");
		
		$fdate =& $workbook->addFormat();
		$fdate->setNumFormat('dd/mm/yyyy');
		$fdate->setAlign('center');
		$fdate->setSize(9);
		$fdate->setBorder(1);
		$fdate->setFontFamily("Trebuchet MS");

		$fdata =& $workbook->addFormat();
		$fdata->setSize(9);
		$fdata->setAlign('left');
		$fdata->setBorder(1);
		$fdata->setFontFamily("Trebuchet MS");
		
		$fdata_center =& $workbook->addFormat();
		$fdata_center->setSize(9);
		$fdata_center->setAlign('center');
		$fdata_center->setBorder(1);
		$fdata_center->setFontFamily("Trebuchet MS");
		
		// Add a worksheet to the file, returning an object to add data to 		

		$worksheet1 =& $workbook->addWorksheet('Daftar Rekapitulasi');
		$worksheet1->setLandscape();

		if ($_GET['status_spt'] == "8") {
			$worksheet1->setColumn(0,0,5);
			$worksheet1->setColumn(0,1,30);
			$worksheet1->setColumn(0,2,15);
			$worksheet1->setColumn(0,3,30);
			$worksheet1->setColumn(0,4,15);
			$worksheet1->setColumn(0,5,10);
			$worksheet1->setColumn(0,6,7);
			$worksheet1->setColumn(0,7,15);
			$worksheet1->setColumn(0,8,14);
			$worksheet1->setColumn(0,9,15);
			$worksheet1->setColumn(0,10,10);
			$worksheet1->setColumn(0,11,14);
			$worksheet1->setColumn(0,12,16);
		} 
		else {
			$worksheet1->setColumn(0,0,5);
			$worksheet1->setColumn(0,1,30);
			$worksheet1->setColumn(0,2,15);
			$worksheet1->setColumn(0,3,30);
			$worksheet1->setColumn(0,4,14);
			$worksheet1->setColumn(0,5,10);
			$worksheet1->setColumn(0,6,7);
			$worksheet1->setColumn(0,7,14);
			$worksheet1->setColumn(0,8,15);
			$worksheet1->setColumn(0,9,10);
			$worksheet1->setColumn(0,10,14);
			$worksheet1->setColumn(0,11,16);
		}
		
		$ket_spt = strtoupper($this->daftar_rekapitulasi_pendataan_model->get_keterangan_spt($_GET['status_spt']));
		$nama_pajak = strtoupper($this->daftar_rekapitulasi_pendataan_model->get_ref_pajak($this->input->get('jenis_pajak')));
		$worksheet1->writeString(0, 0, "DAFTAR REKAPITULASI $ket_spt DAN REALISASI $nama_pajak", $ftitle);
		
		if ($pendataan == 1)
		{
			$worksheet1->writeString(1, 0, "Berdasarkan Tanggal Pendataan ".format_tgl($this->input->get('awDate'), true, true, false)." - ".
							format_tgl($this->input->get('akDate'), true, true, false), $ftitle);

		}
		else
		{
			$worksheet1->writeString(1, 0, "MASA PAJAK ".strtoupper(getNamaBulan($bulan_pajak))." ".$tahun_pajak, $ftitle);
		}


		if ($_GET['status_spt'] == "8") 
		{
			$worksheet1->mergeCells(0, 0, 0, 12);
			$worksheet1->mergeCells(1, 0, 1, 12);
			
			$worksheet1->writeString(3, 0, "NO", $fheader);
			$worksheet1->mergeCells(3, 0, 4, 0);
			$worksheet1->writeString(3, 1, "WAJIB PAJAK", $fheader);
			$worksheet1->writeBlank(3, 2, $fheader);$worksheet1->writeBlank(3, 3, $fheader);$worksheet1->writeBlank(3, 4, $fheader);
			$worksheet1->mergeCells(3, 1, 3, 4);
			$worksheet1->writeString(3, 5, "$ket_spt", $fheader);
			$worksheet1->writeBlank(3, 6, $fheader);$worksheet1->writeBlank(3, 7, $fheader);$worksheet1->writeBlank(3, 8, $fheader);
			$worksheet1->mergeCells(3, 5, 3, 8);
			$worksheet1->writeString(3, 9, "STS", $fheader);
			$worksheet1->writeBlank(3, 10, $fheader);$worksheet1->writeBlank(3, 11, $fheader);
			$worksheet1->mergeCells(3, 9, 3, 11);
			$worksheet1->writeString(3, 12, "TUNGGAKAN (Rp)", $fheader);
			$worksheet1->mergeCells(3, 12, 4, 12);
			
			$worksheet1->writeBlank(4, 0, $fheader);
			$worksheet1->writeString(4, 1, "NAMA WP", $fheader);
			$worksheet1->writeString(4, 2, "NPWPD", $fheader);
			$worksheet1->writeString(4, 3, "ALAMAT", $fheader);
			$worksheet1->writeString(4, 4, "MASA PAJAK", $fheader);
			$worksheet1->writeString(4, 5, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 6, "NOMOR", $fheader);
			$worksheet1->writeString(4, 7, "OMZET (Rp)", $fheader);
			$worksheet1->writeString(4, 8, "PAJAK (Rp)", $fheader);
			$worksheet1->writeString(4, 9, "NOMOR", $fheader);
			$worksheet1->writeString(4, 10, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 11, "SETORAN (Rp)", $fheader);
			$worksheet1->writeBlank(4, 12, $fheader);
			
			$worksheet1->writeNumber(5, 0, "1", $fheader_small);
			$worksheet1->writeNumber(5, 1, "2", $fheader_small);
			$worksheet1->writeNumber(5, 2, "3", $fheader_small);
			$worksheet1->writeNumber(5, 3, "4", $fheader_small);
			$worksheet1->writeNumber(5, 4, "5", $fheader_small);
			$worksheet1->writeNumber(5, 5, "6", $fheader_small);
			$worksheet1->writeNumber(5, 6, "7", $fheader_small);
			$worksheet1->writeNumber(5, 7, "8", $fheader_small);
			$worksheet1->writeNumber(5, 8, "9", $fheader_small);
			$worksheet1->writeNumber(5, 9, "10", $fheader_small);
			$worksheet1->writeNumber(5, 10, "11", $fheader_small);
			$worksheet1->writeNumber(5, 11, "12", $fheader_small);
			$worksheet1->writeNumber(5, 12, "13", $fheader_small);
		} 
		else {
			$worksheet1->mergeCells(0, 0, 0, 11);
			$worksheet1->mergeCells(1, 0, 1, 11);
			
			$worksheet1->writeString(3, 0, "NO", $fheader);
			$worksheet1->mergeCells(3, 0, 4, 0);
			$worksheet1->writeString(3, 1, "WAJIB PAJAK", $fheader);
			$worksheet1->writeBlank(3, 2, $fheader);$worksheet1->writeBlank(3, 3, $fheader);$worksheet1->writeBlank(3, 4, $fheader);
			$worksheet1->mergeCells(3, 1, 3, 4);
			$worksheet1->writeString(3, 5, "$ket_spt", $fheader);
			$worksheet1->writeBlank(3, 6, $fheader);$worksheet1->writeBlank(3, 7, $fheader);
			$worksheet1->mergeCells(3, 5, 3, 7);
			$worksheet1->writeString(3, 8, "STS", $fheader);
			$worksheet1->writeBlank(3, 8, $fheader);$worksheet1->writeBlank(3, 9, $fheader);$worksheet1->writeBlank(3, 10, $fheader);
			$worksheet1->mergeCells(3, 8, 3, 10);
			$worksheet1->writeString(3, 11, "TUNGGAKAN (Rp)", $fheader);
			$worksheet1->mergeCells(3, 11, 4, 11);
			
			$worksheet1->writeBlank(4, 0, $fheader);
			$worksheet1->writeString(4, 1, "NAMA WP", $fheader);
			$worksheet1->writeString(4, 2, "NPWPD", $fheader);
			$worksheet1->writeString(4, 3, "ALAMAT", $fheader);
			$worksheet1->writeString(4, 4, "MASA PAJAK", $fheader);
			$worksheet1->writeString(4, 5, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 6, "NOMOR", $fheader);
			$worksheet1->writeString(4, 7, "KETETAPAN (Rp)", $fheader);
			$worksheet1->writeString(4, 8, "NOMOR", $fheader);
			$worksheet1->writeString(4, 9, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 10, "SETORAN (Rp)", $fheader);
			$worksheet1->writeBlank(4, 11, $fheader);
			
			$worksheet1->writeNumber(5, 0, "1", $fheader_small);
			$worksheet1->writeNumber(5, 1, "2", $fheader_small);
			$worksheet1->writeNumber(5, 2, "3", $fheader_small);
			$worksheet1->writeNumber(5, 3, "4", $fheader_small);
			$worksheet1->writeNumber(5, 4, "5", $fheader_small);
			$worksheet1->writeNumber(5, 5, "6", $fheader_small);
			$worksheet1->writeNumber(5, 6, "7", $fheader_small);
			$worksheet1->writeNumber(5, 7, "8", $fheader_small);
			$worksheet1->writeNumber(5, 8, "9", $fheader_small);
			$worksheet1->writeNumber(5, 9, "10", $fheader_small);
			$worksheet1->writeNumber(5, 10, "11", $fheader_small);
			$worksheet1->writeNumber(5, 11, "12", $fheader_small);
		}

		$no_baris = 6;
		$no_urut = 1;
		
		//if jenis_pajak selain pajak reklame
		if ($_GET['jenis_pajak'] != "4") 
		{
			$tot_omzet = 0;
			$tot_setoran = 0;
			$tot_tunggakan = 0;

			//load data kecamatan
			$dt_kecamatan = $this->daftar_rekapitulasi_pendataan_model->get_kecamatan(
													$pendataan,
													$this->input->get('jenis_pajak'), 
													$this->input->get('camat_id'),
													$bulan_pajak, 
													$tahun_pajak,
													$this->input->get('status_spt'),0
												);

			if (count($dt_kecamatan) > 0) 
			{

				foreach ($dt_kecamatan as $camat) 
				{
					if ($no_baris > 6)
						$no_baris++;
						
					$worksheet1->writeBlank($no_baris, 0, $fkecamatan);
					$worksheet1->writeString($no_baris, 1, $camat['camat_nama'], $fkecamatan);
					$worksheet1->writeBlank($no_baris, 2, $fkecamatan);
					if ($_GET['status_spt'] == "8") {
						for ($i = 3; $i <= 12; $i++)
							$worksheet1->writeBlank($no_baris, $i, $fkecamatan);
					} else {
						for ($i = 3; $i <= 11; $i++)
							$worksheet1->writeBlank($no_baris, $i, $fkecamatan);
					}
					
					$worksheet1->mergeCells($no_baris, 1, $no_baris, 2);
					$no_baris++;
					
					//get data wp
					if ($type_cetak == 1) {
						$dt_wp = $this->daftar_rekapitulasi_pendataan_model->get_wp_kecamatan($camat['camat_id'],
																					"0".$this->input->get('jenis_pajak'),
																					$this->input->get('jenis_restoran'),
																					$bulan_pajak,
																					$tahun_pajak);
						foreach ($dt_wp as $row_wp) {
							$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
							$worksheet1->writeString($no_baris, 1, $row_wp['wp_wr_nama'], $fdata);
							$worksheet1->writeString($no_baris, 2, $row_wp['npwprd'], $fdata_center);
							$worksheet1->writeString($no_baris, 3, strtoupper($row_wp['wp_wr_almt']), $fdata);
							
							//$baris = $no_baris + 1;
							//$worksheet1->writeFormula($no_baris, 10, "=J$baris-G$baris", $fsisa);
							
							$no_urut++;
							$no_baris++;
						}
					} else {
						if ($pendataan == 1) {
							$dt_rekap = $this->daftar_rekapitulasi_pendataan_model->get_data_rekapitulasi(
																$pendataan,
															$this->input->get('jenis_pajak'),
																$camat['camat_id'],
																$this->input->get('awDate'),														
																$this->input->get('akDate'),	
																$this->input->get('status_spt')
																,$this->input->get('jenis_restoran')
													);
						} else {
							$dt_rekap = $this->daftar_rekapitulasi_pendataan_model->get_data_rekapitulasi(
																$pendataan,
																$this->input->get('jenis_pajak'),
																$camat['camat_id'],
																$bulan_pajak,														
																$tahun_pajak,
																$this->input->get('status_spt')
																,$this->input->get('jenis_restoran')
													);
						}
						
						//if sptpd
						if ($_GET['status_spt'] == "8") {

							foreach ($dt_rekap as $row) 
							{
								$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
								$worksheet1->writeString($no_baris, 1, $row['wp_wr_nama'], $fdata);
								$worksheet1->writeString($no_baris, 2, $row['npwprd'], $fdata_center);
								$worksheet1->writeString($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
								$worksheet1->writeString($no_baris, 4, date('F, Y', strtotime($row['spt_periode_jual1'])), $fdata_center);
								$worksheet1->writeNumber($no_baris, 5, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								$worksheet1->writeString($no_baris, 6, $row['spt_nomor'], $fdata_center);
								$worksheet1->writeNumber($no_baris, 7, $row['omzet'], $fcurrency);
								$worksheet1->writeNumber($no_baris, 8, $row['spt_pajak'], $fcurrency);
								$worksheet1->writeString($no_baris, 9, $row['skbh_no'], $fdata_center);
								
								if ($row['skbh_tgl'] != NULL){
									$worksheet1->writeNumber($no_baris, 10, ceil((strtotime($row['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								}
								else 
									$worksheet1->writeBlank($no_baris, 10, $fdate);
									
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->writeNumber($no_baris, 11, $row['setoran'], $fcurrency);
								else
									$worksheet1->writeBlank($no_baris, 11, $fdata);

								
								$baris = $no_baris + 1;
								
								$tunggakan = $row['setoran']-$row['spt_pajak'];
								$worksheet1->writeNumber($no_baris,12,$tunggakan,$fsisa);

								// $worksheet1->writeFormula($no_baris, 12, "=L".$baris."-I".$baris, $fsisa);
								
								$no_urut++;
								$no_baris++;

								$tot_omzet += $row['omzet'];
								$tot_setoran += $row['setoran'];
								$tot_tunggakan += $tunggakan;

							}
						} 
						else {
							foreach ($dt_rekap as $row) {
								$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
								$worksheet1->writeString($no_baris, 1, $row['wp_wr_nama'], $fdata);
								$worksheet1->writeString($no_baris, 2, $row['npwprd'], $fdata_center);
								$worksheet1->writeString($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
								$worksheet1->writeString($no_baris, 4, date('F, Y', strtotime($row['spt_periode_jual1'])), $fdata_center);
								$worksheet1->writeNumber($no_baris, 5, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								$worksheet1->writeString($no_baris, 6, $row['spt_nomor'], $fdata_center);
								$worksheet1->writeNumber($no_baris, 7, $row['spt_pajak'], $fcurrency);
								$worksheet1->writeString($no_baris, 8, $row['skbh_no'], $fdata_center);
								
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->writeNumber($no_baris, 9, ceil((strtotime($row['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								else 
									$worksheet1->writeBlank($no_baris, 9, $fdate);
									
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->writeNumber($no_baris, 10, $row['setoran'], $fcurrency);
								else
									$worksheet1->writeBlank($no_baris, 10, $fdata);
								
								$baris = $no_baris + 1;

								$tunggakan = $row['setoran']-$row['spt_pajak'];
								$worksheet1->writeNumber($no_baris,11,$tunggakan,$fsisa);

								// $worksheet1->writeFormula($no_baris, 11, "=K".$baris."-H".$baris, $fsisa);
								
								$no_urut++;
								$no_baris++;

								$tot_omzet += $row['omzet'];
								$tot_setoran += $row['setoran'];
								$tot_tunggakan += $tunggakan;
							}
						}
						
					}
				}
				
				if ($_GET['status_spt'] == "8") {
					//bagian total
					$worksheet1->writeString($no_baris, 0, "TOTAL", $ftotal);
					$worksheet1->writeBlank($no_baris, 1, $ftotal);$worksheet1->writeBlank($no_baris, 2, $ftotal);$worksheet1->writeBlank($no_baris, 3, $ftotal);
					$worksheet1->writeBlank($no_baris, 4, $ftotal);$worksheet1->writeBlank($no_baris, 5, $ftotal);$worksheet1->writeBlank($no_baris, 6, $ftotal);
					$worksheet1->mergeCells($no_baris, 0, $no_baris, 6);

					// $worksheet1->write_formula($no_baris, 7, "=SUM(H7:H".$no_baris.")", $ftotal_currency);
					$worksheet1->writeNumber($no_baris, 7, $tot_omzet, $ftotal_currency);
					
					//$worksheet1->writeFormula($no_baris, 8, "=SUM(I7:I$no_baris)", $ftotal_currency);
					$worksheet1->writeBlank($no_baris, 8, $ftotal);
					$worksheet1->writeBlank($no_baris,9, $ftotal);
					$worksheet1->mergeCells($no_baris, 8, $no_baris, 10);$worksheet1->writeBlank($no_baris,10, $ftotal);
					
					// $worksheet1->write_formula($no_baris, 11, "=SUM(L7:L".$no_baris.")", $ftotal_currency);
					$worksheet1->writeNumber($no_baris, 11, $tot_setoran, $ftotal_currency);

					// $worksheet1->write_formula($no_baris, 12, "=SUM(M7:M".$no_baris.")", $ftotal_sisa);
					$worksheet1->writeNumber($no_baris, 12, $tot_tunggakan, $ftotal_sisa);
				} 
				else {
					//bagian total
					$worksheet1->writeString($no_baris, 0, "TOTAL", $ftotal);
					$worksheet1->writeBlank($no_baris, 1, $ftotal);$worksheet1->writeBlank($no_baris, 2, $ftotal);$worksheet1->writeBlank($no_baris, 3, $ftotal);$worksheet1->writeBlank($no_baris, 4, $ftotal);
					$worksheet1->writeBlank($no_baris, 5, $ftotal);$worksheet1->writeBlank($no_baris, 6, $ftotal);
					$worksheet1->mergeCells($no_baris, 0, $no_baris, 6);
					
					// $worksheet1->write_formula($no_baris, 7, "=SUM(H7:H".$no_baris.")", $ftotal_currency);
					$worksheet1->writeNumber($no_baris, 7, $tot_omzet, $ftotal_currency);

					$worksheet1->writeBlank($no_baris, 8, $ftotal);$worksheet1->writeBlank($no_baris, 9, $ftotal);
					$worksheet1->mergeCells($no_baris, 8, $no_baris, 9);

					// $worksheet1->write_formula($no_baris, 10, "=SUM(K7:K".$no_baris.")", $ftotal_currency);
					$worksheet1->writeNumber($no_baris, 10, $tot_setoran, $ftotal_currency);

					// $worksheet1->write_formula($no_baris, 11, "=SUM(L7:L".$no_baris.")", $ftotal_sisa);
					$worksheet1->writeNumber($no_baris, 11, $tot_tunggakan, $ftotal_sisa);
				}
				
				
			}
		} 
		
		else 
		
		{

			$tot_pajak = 0;
			$tot_setoran = 0;
			$tot_tunggakan = 0;

			//get data wp
			if ($pendataan == 1) {
				$dt_rekap = $this->daftar_rekapitulasi_pendataan_model->get_data_rekapitulasi(
													1,
													$this->input->get('jenis_pajak_pendataan'),
													NULL,
													$this->input->get('awDate'),														
													$this->input->get('akDate'),
													$this->input->get('status_spt'));
			} else {
				$dt_rekap = $this->daftar_rekapitulasi_pendataan_model->get_data_rekapitulasi(
													0,
													$this->input->get('jenis_pajak'),
													NULL,
													$bulan_pajak,														
													$tahun_pajak,
													$this->input->get('status_spt'));
			}
			
			
			foreach ($dt_rekap as $row) {
				$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
				$worksheet1->writeString($no_baris, 1, $row['wp_wr_nama'], $fdata);
				$worksheet1->writeString($no_baris, 2, $row['npwprd'], $fdata_center);
				$worksheet1->writeString($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
				$worksheet1->writeNumber($no_baris, 4, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				$worksheet1->writeNumber($no_baris, 5, ceil((strtotime($row['spt_tgl_proses']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				$worksheet1->writeString($no_baris, 6, $row['spt_nomor'], $fdata_center);
				$worksheet1->writeNumber($no_baris, 7, $row['spt_pajak'], $fcurrency);
				$worksheet1->writeString($no_baris, 8, $row['skbh_no'], $fdata_center);
				
				if ($row['skbh_tgl'] != NULL)
					$worksheet1->writeNumber($no_baris, 9, ceil((strtotime($row['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				else 
					$worksheet1->writeBlank($no_baris, 9, $fdate);
					
				if ($row['skbh_tgl'] != NULL)
					$worksheet1->writeNumber($no_baris, 10, $row['setoran'], $fcurrency);
				else
					$worksheet1->writeBlank($no_baris, 10, $fdata);
				
				$baris = $no_baris + 1;

				$tunggakan = $row['setoran'] - $row['spt_pajak'];
				$worksheet1->writeNumber($no_baris,11,$tunggakan,$fsisa);

				// $worksheet1->writeFormula($no_baris, 11, "=K".$baris."-H".$baris, $fsisa);
				
				$no_urut++;
				$no_baris++;

				$tot_pajak += $row['spt_pajak'];
				$tot_setoran += $row['setoran'];
				$tot_tunggakan += $tunggakan;

			}
			
			//bagian total
			$worksheet1->writeString($no_baris, 0, "TOTAL", $ftotal);
			$worksheet1->writeBlank($no_baris, 1, $ftotal);$worksheet1->writeBlank($no_baris, 2, $ftotal);$worksheet1->writeBlank($no_baris, 3, $ftotal);
			$worksheet1->writeBlank($no_baris, 4, $ftotal);$worksheet1->writeBlank($no_baris, 5, $ftotal);$worksheet1->writeBlank($no_baris, 6, $ftotal);
			$worksheet1->mergeCells($no_baris, 0, $no_baris, 6);
			
			$worksheet1->writeNumber($no_baris,7,$tot_setoran,$fcurrency);
			// $worksheet1->writeFormula($no_baris, 7, "=SUM(H7:H".$no_baris.")", $ftotal_currency);
			
			$worksheet1->writeBlank($no_baris, 8, $ftotal);$worksheet1->writeBlank($no_baris, 9, $ftotal);
			$worksheet1->mergeCells($no_baris, 8, $no_baris, 9);

			$worksheet1->writeNumber($no_baris,10,$tot_setoran,$fcurrency);
			// $worksheet1->writeFormula($no_baris, 10, "=SUM(K7:K".$no_baris.")", $ftotal_currency);

			$worksheet1->writeNumber($no_baris,11,$tot_tunggakan,$ftotal_sisa);
			// $worksheet1->writeFormula($no_baris, 11, "=SUM(L7:L".$no_baris.")", $ftotal_sisa);
		}
		
		// Finish the spreadsheet, dumping it to the browser 
		$workbook->close(); 	
				
	}
	

	function cetak_daftar_skpdkb($type_cetak = 0, $lap_realisasi = 1) {
		error_reporting(E_ERROR);
		
		//add library	
		require FCPATH."vendor/autoload.php";
		
		// number of seconds in a day
		$seconds_in_a_day = 86400;
		// Unix timestamp to Excel date difference in seconds
		$ut_to_ed_diff = $seconds_in_a_day * 25569;
		$bulan_pajak = $this->input->get('bulan_masa_pajak');
		$tahun_pajak = $this->input->get('tahun_masa_pajak');
						

		// Create an instance 
		$workbook =& new Spreadsheet_Excel_Writer(); 
		
		// Send HTTP headers to tell the browser what's coming 
		$workbook->send("daftar-rekapitulasi-skdbkb.xls"); 

		$ftitle =& $workbook->addFormat();
		$ftitle->setSize(12);
		$ftitle->setBold();
		$ftitle->setAlign('center');
		$ftitle->setFontFamily("Trebuchet MS");
		
		$fheader =& $workbook->addFormat();
		$fheader->setSize(10);
		$fheader->setBold();
		$fheader->setBorder(1);
		$fheader->setAlign('center');
		$fheader->setFontFamily("Trebuchet MS");
		
		$fheader_small =& $workbook->addFormat();
		$fheader_small->setSize(7);
		$fheader_small->setBold();
		$fheader_small->setBorder(1);
		$fheader_small->setAlign('center');
		$fheader_small->setFontFamily("Trebuchet MS");
		
		$fkecamatan =& $workbook->addFormat();
		$fkecamatan->setSize(10);
		$fkecamatan->setBold();
		$fkecamatan->setBorder(1);
		$fkecamatan->setAlign('left');
		$fkecamatan->setFontFamily("Trebuchet MS");
		
		$ftotal =& $workbook->addFormat();
		$ftotal->setSize(9);
		$ftotal->setBold();
		$ftotal->setAlign('center');
		$ftotal->setFontFamily("Trebuchet MS");
		$ftotal->setBorder(1);
		
		$ftotal_currency =& $workbook->addFormat();
		$ftotal_currency->setSize(9);
		$ftotal_currency->setNumFormat("#,##0");
		$ftotal_currency->setBold();
		$ftotal_currency->setAlign('right');
		$ftotal_currency->setFontFamily("Trebuchet MS");

		$ftotal_currency->setBorder(1);
		
		$fcurrency =& $workbook->addFormat();
		$fcurrency->setNumFormat("#,##0");
		$fcurrency->setAlign('right');
		$fcurrency->setSize(9);
		$fcurrency->setBorder(1);
		$fcurrency->setFontFamily("Trebuchet MS");
		
		$fsisa =& $workbook->addFormat();
		$fsisa->setNumFormat("#,##0_);[Red](#,##0)");
		$fsisa->setAlign('right');
		$fsisa->setSize(9);
		$fsisa->setBorder(1);
		$fsisa->setFontFamily("Trebuchet MS");
		
		$ftotal_sisa =& $workbook->addFormat();
		$ftotal_sisa->setNumFormat("#,##0_);[Red](#,##0)");
		$ftotal_sisa->setAlign('right');
		$ftotal_sisa->setBold();
		$ftotal_sisa->setSize(9);
		$ftotal_sisa->setBorder(1);
		$ftotal_sisa->setFontFamily("Trebuchet MS");
		
		$fdate =& $workbook->addFormat();
		$fdate->setNumFormat('dd/mm/yyyy');
		$fdate->setAlign('center');
		$fdate->setSize(9);
		$fdate->setBorder(1);
		$fdate->setFontFamily("Trebuchet MS");

		$fdata =& $workbook->addFormat();
		$fdata->setSize(9);
		$fdata->setAlign('left');
		$fdata->setBorder(1);
		$fdata->setFontFamily("Trebuchet MS");
		
		$fdata_center =& $workbook->addFormat();
		$fdata_center->setSize(9);
		$fdata_center->setAlign('center');
		$fdata_center->setBorder(1);
		$fdata_center->setFontFamily("Trebuchet MS");
		
		$worksheet1 =& $workbook->addWorksheet('Daftar Rekapitulasi');
		$worksheet1->setLandscape();
		
		
		$worksheet1->setColumn(0,0,5);
		$worksheet1->setColumn(0,1,25);
		$worksheet1->setColumn(0,2,17);
		$worksheet1->setColumn(0,3,30);
		$worksheet1->setColumn(0,4,14);
		$worksheet1->setColumn(0,5,10);
		$worksheet1->setColumn(0,6,7);
		$worksheet1->setColumn(0,7,14);
		$worksheet1->setColumn(0,8,15);
		$worksheet1->setColumn(0,9,10);
		$worksheet1->setColumn(0,10,14);
		$worksheet1->setColumn(0,11,16);
		
		
		$ket_spt = strtoupper($this->skpdkb_model->get_keterangan_spt($_GET['status_spt']));
		$nama_pajak = strtoupper($this->skpdkb_model->get_ref_pajak($this->input->get('jenis_pajak')));
		$worksheet1->writeString(0, 0, "DAFTAR REKAPITULASI $ket_spt DAN REALISASI $nama_pajak", $ftitle);
		if ($lap_realisasi == 1)
			$worksheet1->writeString(1, 0, "Tanggal Realisasi ".format_tgl($this->input->get('fDate'), true, true, false)." - ".
							format_tgl($this->input->get('tDate'), true, true, false), $ftitle);
		else
			$worksheet1->writeString(1, 0, "MASA PAJAK ".strtoupper(getNamaBulan($bulan_pajak))." ".$tahun_pajak, $ftitle);
		
		
			$worksheet1->mergeCells(0, 0, 0, 11);
			$worksheet1->mergeCells(1, 0, 1, 11);
			
			$worksheet1->writeString(3, 0, "NO", $fheader);
			$worksheet1->mergeCells(3, 0, 4, 0);
			$worksheet1->writeString(3, 1, "WAJIB PAJAK", $fheader);
			$worksheet1->writeBlank(3, 2, $fheader);$worksheet1->writeBlank(3, 3, $fheader);$worksheet1->writeBlank(3, 4, $fheader);
			$worksheet1->mergeCells(3, 1, 3, 4);
			$worksheet1->writeString(3, 5, "$ket_spt", $fheader);
			$worksheet1->writeBlank(3, 6, $fheader);$worksheet1->writeBlank(3, 7, $fheader);
			$worksheet1->mergeCells(3, 5, 3, 7);
			$worksheet1->writeString(3, 8, "STS", $fheader);
			$worksheet1->writeBlank(3, 8, $fheader);$worksheet1->writeBlank(3, 9, $fheader);$worksheet1->writeBlank(3, 10, $fheader);
			$worksheet1->mergeCells(3, 8, 3, 10);
			$worksheet1->writeString(3, 11, "TUNGGAKAN (Rp)", $fheader);
			$worksheet1->mergeCells(3, 11, 4, 11);
			
			$worksheet1->writeBlank(4, 0, $fheader);
			$worksheet1->writeString(4, 1, "NAMA WP", $fheader);
			$worksheet1->writeString(4, 2, "NPWPD", $fheader);
			$worksheet1->writeString(4, 3, "ALAMAT", $fheader);
			$worksheet1->writeString(4, 4, "MASA PAJAK", $fheader);
			$worksheet1->writeString(4, 5, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 6, "NOMOR", $fheader);
			$worksheet1->writeString(4, 7, "KETETAPAN (Rp)", $fheader);
			$worksheet1->writeString(4, 8, "NOMOR", $fheader);
			$worksheet1->writeString(4, 9, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 10, "SETORAN (Rp)", $fheader);
			$worksheet1->writeBlank(4, 11, $fheader);
			
			$worksheet1->writeNumber(5, 0, "1", $fheader_small);
			$worksheet1->writeNumber(5, 1, "2", $fheader_small);
			$worksheet1->writeNumber(5, 2, "3", $fheader_small);
			$worksheet1->writeNumber(5, 3, "4", $fheader_small);
			$worksheet1->writeNumber(5, 4, "5", $fheader_small);
			$worksheet1->writeNumber(5, 5, "6", $fheader_small);
			$worksheet1->writeNumber(5, 6, "7", $fheader_small);
			$worksheet1->writeNumber(5, 7, "8", $fheader_small);
			$worksheet1->writeNumber(5, 8, "9", $fheader_small);
			$worksheet1->writeNumber(5, 9, "10", $fheader_small);
			$worksheet1->writeNumber(5, 10, "11", $fheader_small);
			$worksheet1->writeNumber(5, 11, "12", $fheader_small);
		
		
		
		$no_baris = 6;
		$no_urut = 1;
		
		$tot_pajak = 0;
		$tot_setoran = 0;
		$tot_tunggakan = 0;

		//if jenis_pajak selain pajak reklame
		if ($_GET['jenis_pajak'] != "4") {			
			//load data kecamatan
			$dt_kecamatan = $this->skpdkb_model->get_kecamatan(
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
						
					$worksheet1->writeBlank($no_baris, 0, $fkecamatan);
					$worksheet1->writeString($no_baris, 1, $camat['camat_nama'], $fkecamatan);
					$worksheet1->writeBlank($no_baris, 2, $fkecamatan);
					
						for ($i = 3; $i <= 11; $i++)	
							$worksheet1->writeBlank($no_baris, $i, $fkecamatan);
					
					
					$worksheet1->mergeCells($no_baris, 1, $no_baris, 2);
					$no_baris++;
					
					//get data wp
					if ($type_cetak == 1) {
						$dt_wp = $this->skpdkb_model->get_wp_kecamatan($camat['camat_id'],
																					"0".$this->input->get('jenis_pajak'),
																					$bulan_pajak,
																					$tahun_pajak);
						foreach ($dt_wp as $row_wp) {
							$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
							$worksheet1->writeString($no_baris, 1, $row_wp['wp_wr_nama'], $fdata);
							$worksheet1->writeString($no_baris, 2, $row_wp['npwprd'], $fdata_center);
							$worksheet1->writeString($no_baris, 3, strtoupper($row_wp['wp_wr_almt']), $fdata);
							
							//$baris = $no_baris + 1;
							//$worksheet1->writeFormula($no_baris, 10, "=J$bar	is-G$baris", $fsisa);
							
							$no_urut++;
							$no_baris++;
						}
					} else {
						if ($lap_realisasi == 1) {
							$dt_rekap = $this->skpdkb_model->get_data_rekapitulasi(
																$lap_realisasi,
																$this->input->get('jenis_pajak'),
																$camat['camat_id'],
																$this->input->get('fDate'),														
																$this->input->get('tDate'),	
																$this->input->get('status_spt'),
																$this->input->get('jenis	_restoran')
													);
						} else {
							$dt_rekap = $this->skpdkb_model->get_data_rekapitulasi(
																$lap_realisasi,
																$this->input->get('jenis_pajak'),
																$camat['camat_id'],
																$bulan_pajak,														
																$tahun_pajak,
																$this->input->get('status_spt'),
																$this->input->get('jenis_restoran')
													);
						}
						

						
							foreach ($dt_rekap as $row) {
								$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
								$worksheet1->writeString($no_baris, 1, $row['wp_wr_nama'], $fdata);
								$worksheet1->writeString($no_baris, 2, $row['npwprd'], $fdata_center);
								$worksheet1->writeString($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
								$worksheet1->writeString($no_baris, 4, date('F, Y', strtotime($row['spt_periode_jual1'])), $fdata_center);
								$worksheet1->writeNumber($no_baris, 5, ceil((strtotime($row['spt_periode_jual1']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								$worksheet1->writeString($no_baris, 6, $row['spt_nomor'], $fdata_center);
								$worksheet1->writeNumber($no_baris, 7, $row['spt_pajak'], $fcurrency);
								$worksheet1->writeString($no_baris, 8, $row['skbh_no'], $fdata_center);
								
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->writeNumber($no_baris, 9, ceil((strtotime($row['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								else 
									$worksheet1->writeBlank($no_baris, 9, $fdate);
									
								if ($row['skbh_tgl'] != NULL)
									$worksheet1->writeNumber($no_baris, 10, $row['setoran'], $fcurrency);
								else
									$worksheet1->writeBlank($no_baris, 10, $fdata);
								
								$baris = $no_baris + 1;
								$tunggakan = $row['setoran']-$row['spt_pajak'];
								$worksheet1->writeNumber($no_baris,11,$tunggakan,$fsisa);

								// $worksheet1->writeFormula($no_baris, 11, "=K".$baris."-H".$baris, $fsisa);
								
								$no_urut++;
								$no_baris++;

								$tot_pajak += $row['spt_pajak'];
								$tot_setoran += $row['tot_setoran'];
								$tot_tunggakan += $tunggakan;
							}
						
					}
				}
				
					//bagian total
					$worksheet1->writeString($no_baris, 0, "TOTAL", $ftotal);
					$worksheet1->writeBlank($no_baris, 1, $ftotal);$worksheet1->writeBlank($no_baris, 2, $ftotal);$worksheet1->writeBlank($no_baris, 3, $ftotal);$worksheet1->writeBlank($no_baris, 4, $ftotal);
					$worksheet1->writeBlank($no_baris, 5, $ftotal);$worksheet1->writeBlank($no_baris, 6, $ftotal);
					$worksheet1->mergeCells($no_baris, 0, $no_baris, 6);
					
					$worksheet1->writeNumber($no_baris,7,$tot_pajak,$ftotal_currency);
					// $worksheet1->writeFormula($no_baris, 7, "=SUM(H7:H".$no_baris.")", $ftotal_currency);

					$worksheet1->writeBlank($no_baris, 8, $ftotal);$worksheet1->writeBlank($no_baris, 9, $ftotal);
					$worksheet1->mergeCells($no_baris, 8, $no_baris, 9);
					
					$worksheet1->writeNumber($no_baris,10,$tot_setoran,$ftotal_currency);
					// $worksheet1->writeFormula($no_baris, 10, "=SUM(K7:K".$no_baris.")", $ftotal_currency);

					$worksheet1->writeNumber($no_baris,11,$tot_tunggakan,$ftotal_sisa);
					$worksheet1->writeFormula($no_baris, 11, "=SUM(L7:L".$no_baris.")", $ftotal_sisa);
			}
		} else {
			//get data wp
			if ($lap_realisasi == 1) {
				$dt_rekap = $this->skpdkb_model->get_data_rekapitulasi(
													1,
													$this->input->get('jenis_pajak'),
													NULL,
													$this->input->get('fDate'),														
													$this->input->get('tDate'),
													$this->input->get('status_spt'));
			} else {
				$dt_rekap = $this->skpdkb_model->get_data_rekapitulasi(
													0,
													$this->input->get('jenis_pajak'),
													NULL,
													$bulan_pajak,														
													$tahun_pajak,
													$this->input->get('status_spt'));
			}
			
			
			foreach ($dt_rekap as $row) {
				$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
				$worksheet1->writeString($no_baris, 1, $row['wp_wr_nama'], $fdata);
				$worksheet1->writeString($no_baris, 2, $row['npwprd'], $fdata_center);
				$worksheet1->writeString($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
				$worksheet1->writeNumber($no_baris, 4, ceil((strtotime($row['spt_periode_jual1']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				$worksheet1->writeNumber($no_baris, 5, ceil((strtotime($row['spt_periode_jual1']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				$worksheet1->writeString($no_baris, 6, $row['spt_nomor'], $fdata_center);
				$worksheet1->writeNumber($no_baris, 7, $row['spt_pajak'], $fcurrency);
				$worksheet1->writeString($no_baris, 8, $row['skbh_no'], $fdata_center);
				
				if ($row['skbh_tgl'] != NULL)
					$worksheet1->writeNumber($no_baris, 9, ceil((strtotime($row['skbh_tgl']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				else 
					$worksheet1->writeBlank($no_baris, 9, $fdate);
					
				if ($row['skbh_tgl'] != NULL)
					$worksheet1->writeNumber($no_baris, 10, $row['setoran'], $fcurrency);
				else
					$worksheet1->writeBlank($no_baris, 10, $fdata);
				
				$baris = $no_baris + 1;
				$tunggakan = $row['setoran']-$row['spt_pajak'];
				$worksheet1->writeNumber($no_baris,11,$tunggakan,$fsisa);
				
				// $worksheet1->writeFormula($no_baris, 11, "=K$baris-H$baris", $fsisa);
				
				$no_urut++;
				$no_baris++;

				$tot_pajak += $row['spt_pajak'];
				$tot_setoran += $row['tot_setoran'];
				$tot_tunggakan += $tunggakan;
			}
			
			//bagian total
			$worksheet1->writeString($no_baris, 0, "TOTAL", $ftotal);
			$worksheet1->writeBlank($no_baris, 1, $ftotal);$worksheet1->writeBlank($no_baris, 2, $ftotal);$worksheet1->writeBlank($no_baris, 3, $ftotal);
			$worksheet1->writeBlank($no_baris, 4, $ftotal);$worksheet1->writeBlank($no_baris, 5, $ftotal);$worksheet1->writeBlank($no_baris, 6, $ftotal);
			$worksheet1->mergeCells($no_baris, 0, $no_baris, 6);
			
			$worksheet1->writeNumber($no_baris, 7, $tot_pajak, $ftotal_currency);
			// $worksheet1->writeFormula($no_baris, 7, "=SUM(H7:H".$no_baris.")", $ftotal_currency);

			$worksheet1->writeBlank($no_baris, 8, $ftotal);$worksheet1->writeBlank($no_baris, 9, $ftotal);
			$worksheet1->mergeCells($no_baris, 8, $no_baris, 9);
			
			$worksheet1->writeNumber($no_baris, 10, $tot_setoran, $ftotal_currency);
			// $worksheet1->writeFormula($no_baris, 10, "=SUM(K7:K".$no_baris.")", $ftotal_currency);

			$worksheet1->writeNumber($no_baris, 11, $tot_tunggakan, $ftotal_sisa);
			// $worksheet1->writeFormula($no_baris, 11, "=SUM(L7:L".$no_baris.")", $ftotal_sisa);
		}
		
		//close workbook
		$workbook->close();
	}

	function cetak_daftar_stpd($type_cetak = 0, $lap_realisasi = 1) {
		error_reporting(E_ERROR);
		
		//add library
		require FCPATH."vendor/autoload.php";
		
		// number of seconds in a day
		$seconds_in_a_day = 86400;
		// Unix timestamp to Excel date difference in seconds
		$ut_to_ed_diff = $seconds_in_a_day * 25569;
		$bulan_pajak = $this->input->get('bulan_masa_pajak');
		$tahun_pajak = $this->input->get('tahun_masa_pajak');
		
		// Create an instance 
		$workbook =& new Spreadsheet_Excel_Writer(); 

		// Send HTTP headers to tell the browser what's coming 
		$workbook->send("daftar-rekapitulasi-stpd.xls"); 

		$ftitle =& $workbook->addFormat();
		$ftitle->setSize(12);
		$ftitle->setBold();
		$ftitle->setAlign('center');
		$ftitle->setFontFamily("Trebuchet MS");
		
		$fheader =& $workbook->addFormat();
		$fheader->setSize(10);
		$fheader->setBold();
		$fheader->setBorder(1);
		$fheader->setAlign('center');
		$fheader->setFontFamily("Trebuchet MS");
		
		$fheader_small =& $workbook->addFormat();
		$fheader_small->setSize(7);
		$fheader_small->setBold();
		$fheader_small->setBorder(1);
		$fheader_small->setAlign('center');
		$fheader_small->setFontFamily("Trebuchet MS");
		
		$fkecamatan =& $workbook->addFormat();
		$fkecamatan->setSize(10);
		$fkecamatan->setBold();
		$fkecamatan->setBorder(1);
		$fkecamatan->setAlign('left');
		$fkecamatan->setFontFamily("Trebuchet MS");
		
		$ftotal =& $workbook->addFormat();
		$ftotal->setSize(9);
		$ftotal->setBold();
		$ftotal->setAlign('center');
		$ftotal->setFontFamily("Trebuchet MS");
		$ftotal->setBorder(1);
		
		$ftotal_currency =& $workbook->addFormat();
		$ftotal_currency->setSize(9);
		$ftotal_currency->setNumFormat("#,##0");
		$ftotal_currency->setBold();
		$ftotal_currency->setAlign('right');
		$ftotal_currency->setFontFamily("Trebuchet MS");


		$ftotal_currency->setBorder(1);
		
		$fcurrency =& $workbook->addFormat();
		$fcurrency->setNumFormat("#,##0");
		$fcurrency->setAlign('right');
		$fcurrency->setSize(9);
		$fcurrency->setBorder(1);
		$fcurrency->setFontFamily("Trebuchet MS");
		
		$fsisa =& $workbook->addFormat();
		$fsisa->setNumFormat("#,##0_);[Red](#,##0)");
		$fsisa->setAlign('right');
		$fsisa->setSize(9);
		$fsisa->setBorder(1);
		$fsisa->setFontFamily("Trebuchet MS");
		
		$ftotal_sisa =& $workbook->addFormat();
		$ftotal_sisa->setNumFormat("#,##0_);[Red](#,##0)");
		$ftotal_sisa->setAlign('right');
		$ftotal_sisa->setBold();
		$ftotal_sisa->setSize(9);
		$ftotal_sisa->setBorder(1);
		$ftotal_sisa->setFontFamily("Trebuchet MS");
		
		$fdate =& $workbook->addFormat();
		$fdate->setNumFormat('dd/mm/yyyy');
		$fdate->setAlign('center');
		$fdate->setSize(9);
		$fdate->setBorder(1);
		$fdate->setFontFamily("Trebuchet MS");

		$fdata =& $workbook->addFormat();
		$fdata->setSize(9);
		$fdata->setAlign('left');
		$fdata->setBorder(1);
		$fdata->setFontFamily("Trebuchet MS");
		
		$fdata_center =& $workbook->addFormat();
		$fdata_center->setSize(9);
		$fdata_center->setAlign('center');
		$fdata_center->setBorder(1);
		$fdata_center->setFontFamily("Trebuchet MS");
		
		$worksheet1 =& $workbook->addWorksheet('Daftar Rekapitulasi');
		$worksheet1->setLandscape();	
		
		$worksheet1->setColumn(0,0,5);
		$worksheet1->setColumn(0,1,25);
		$worksheet1->setColumn(0,2,17);
		$worksheet1->setColumn(0,3,30);
		$worksheet1->setColumn(0,4,14);
		$worksheet1->setColumn(0,5,10);
		$worksheet1->setColumn(0,6,7);
		$worksheet1->setColumn(0,7,14);
		$worksheet1->setColumn(0,8,15);
		$worksheet1->setColumn(0,9,10);
		$worksheet1->setColumn(0,10,14);
		$worksheet1->setColumn(0,11,16);
				
		
		$ket_spt = strtoupper($this->stpd_model->get_keterangan_spt($_GET['status_spt']));
		$nama_pajak = strtoupper($this->stpd_model->get_ref_pajak($this->input->get('jenis_pajak')));
		$worksheet1->writeString(0, 0, "DAFTAR REKAPITULASI $ket_spt DAN REALISASI $nama_pajak", $ftitle);
		if ($lap_realisasi == 1)
			$worksheet1->writeString(1, 0, "Tanggal Realisasi ".format_tgl($this->input->get('fDate'), true, true, false)." - ".
							format_tgl($this->input->get('tDate'), true, true, false), $ftitle);
		else
			$worksheet1->writeString(1, 0, "MASA PAJAK ".strtoupper(getNamaBulan($bulan_pajak))." ".$tahun_pajak, $ftitle);
		
		
			$worksheet1->mergeCells(0, 0, 0, 11);
			$worksheet1->mergeCells(1, 0, 1, 11);
			
			$worksheet1->writeString(3, 0, "NO", $fheader);
			$worksheet1->mergeCells(3, 0, 4, 0);
			$worksheet1->writeString(3, 1, "WAJIB PAJAK", $fheader);
			$worksheet1->writeBlank(3, 2, $fheader);$worksheet1->writeBlank(3, 3, $fheader);$worksheet1->writeBlank(3, 4, $fheader);
			$worksheet1->mergeCells(3, 1, 3, 4);
			$worksheet1->writeString(3, 5, "$ket_spt", $fheader);
			$worksheet1->writeBlank(3, 6, $fheader);$worksheet1->writeBlank(3, 7, $fheader);
			$worksheet1->mergeCells(3, 5, 3, 7);
			$worksheet1->writeString(3, 8, "STS", $fheader);
			$worksheet1->writeBlank(3, 8, $fheader);$worksheet1->writeBlank(3, 9, $fheader);$worksheet1->writeBlank(3, 10, $fheader);
			$worksheet1->mergeCells(3, 8, 3, 10);
			$worksheet1->writeString(3, 11, "TUNGGAKAN (Rp)", $fheader);
			$worksheet1->mergeCells(3, 11, 4, 11);
			
			$worksheet1->writeBlank(4, 0, $fheader);
			$worksheet1->writeString(4, 1, "NAMA WP", $fheader);
			$worksheet1->writeString(4, 2, "NPWPD", $fheader);
			$worksheet1->writeString(4, 3, "ALAMAT", $fheader);
			$worksheet1->writeString(4, 4, "MASA PAJAK", $fheader);
			$worksheet1->writeString(4, 5, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 6, "NOMOR", $fheader);
			$worksheet1->writeString(4, 7, "KETETAPAN (Rp)", $fheader);
			$worksheet1->writeString(4, 8, "NOMOR", $fheader);
			$worksheet1->writeString(4, 9, "TANGGAL", $fheader);
			$worksheet1->writeString(4, 10, "SETORAN (Rp)", $fheader);
			$worksheet1->writeBlank(4, 11, $fheader);
			
			$worksheet1->writeNumber(5, 0, "1", $fheader_small);
			$worksheet1->writeNumber(5, 1, "2", $fheader_small);
			$worksheet1->writeNumber(5, 2, "3", $fheader_small);
			$worksheet1->writeNumber(5, 3, "4", $fheader_small);
			$worksheet1->writeNumber(5, 4, "5", $fheader_small);
			$worksheet1->writeNumber(5, 5, "6", $fheader_small);
			$worksheet1->writeNumber(5, 6, "7", $fheader_small);
			$worksheet1->writeNumber(5, 7, "8", $fheader_small);
			$worksheet1->writeNumber(5, 8, "9", $fheader_small);
			$worksheet1->writeNumber(5, 9, "10", $fheader_small);
			$worksheet1->writeNumber(5, 10, "11", $fheader_small);
			$worksheet1->writeNumber(5, 11, "12", $fheader_small);
		
		
		
		$no_baris = 6;
		$no_urut = 1;
		
		//if jenis_pajak selain pajak reklame
		if ($_GET['jenis_pajak'] != "4") {			

			$tot_pajak = 0;
			$tot_sanksi = 0;
			$tot_tunggakan = 0;

			//load data kecamatan
			$dt_kecamatan = $this->stpd_model->get_kecamatan(
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
						
					$worksheet1->writeBlank($no_baris, 0, $fkecamatan);
					$worksheet1->writeString($no_baris, 1, $camat['wp_wr_camat'], $fkecamatan);
					$worksheet1->writeBlank($no_baris, 2, $fkecamatan);
					if ($_GET['status_spt'] == "8") {
						for ($i = 3; $i <= 12; $i++)
							$worksheet1->writeBlank($no_baris, $i, $fkecamatan);
					} else {
						for ($i = 3; $i <= 11; $i++)
							$worksheet1->writeBlank($no_baris, $i, $fkecamatan);
					}
					
					$worksheet1->mergeCells($no_baris, 1, $no_baris, 2);
					$no_baris++;
					
					//get data wp
					if ($type_cetak == 1) {
						$dt_wp = $this->stpd_model->get_wp_kecamatan($camat['camat_id'],
																					"0".$this->input->get('jenis_pajak'),
																					$bulan_pajak,
																					$tahun_pajak);
						foreach ($dt_wp as $row_wp) {
							$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
							$worksheet1->writeString($no_baris, 1, $row_wp['wp_wr_nama'], $fdata);
							$worksheet1->writeString($no_baris, 2, $row_wp['npwprd'], $fdata_center);
							$worksheet1->writeString($no_baris, 3, strtoupper($row_wp['wp_wr_almt']), $fdata);
							
							//$baris = $no_baris + 1;
							$worksheet1->writeFormula($no_baris, 10, "=J".$baris."-G".$baris, $fsisa);
							
							$no_urut++;
							$no_baris++;
						}
					} else {
						if ($lap_realisasi == 1) {
							$dt_rekap = $this->stpd_model->get_data_rekapitulasi(
																$lap_realisasi,
																$this->input->get('jenis_pajak'),
																$camat['camat_id'],
																$this->input->get('fDate'),														
																$this->input->get('tDate'),	
																$this->input->get('status_spt'),
																$this->input->get('jenis_restoran')
													);
						} else {
							$dt_rekap = $this->stpd_model->get_data_rekapitulasi(
																$lap_realisasi,
																$this->input->get('jenis_pajak'),
																$camat['camat_id'],
																$bulan_pajak,														
																$tahun_pajak,
																$this->input->get('status_spt'),
																$this->input->get('jenis_restoran')
													);
						}
						

						
							foreach ($dt_rekap as $row) {
								$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
								$worksheet1->writeString($no_baris, 1, $row['wp_wr_nama'], $fdata);
								$worksheet1->writeString($no_baris, 2, $row['npwprd'], $fdata_center);
								$worksheet1->writeString($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
								$worksheet1->writeString($no_baris, 4, date('F, Y', strtotime($row['spt_periode_jual1'])), $fdata_center);
								$worksheet1->writeNumber($no_baris, 5, ceil((strtotime($row['stpd_periode_jual1']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								$worksheet1->writeString($no_baris, 6, $row['stpd_nomor'], $fdata_center);
								$worksheet1->writeNumber($no_baris, 7, $row['stpd_pajak'], $fcurrency);
								$worksheet1->writeString($no_baris, 8, $row['skbh_no'], $fdata_center);
								
								if ($row['stpd_tgl_setoran'] != NULL)
									$worksheet1->writeNumber($no_baris, 9, ceil((strtotime($row['stpd_tgl_setoran']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
								else 
									$worksheet1->writeBlank($no_baris, 9, $fdate);
									
								if ($row['stpd_tgl_setoran'] != NULL)
									$worksheet1->writeNumber($no_baris, 10, $row['stpd_sanksi'], $fcurrency);
								else
									$worksheet1->writeBlank($no_baris, 10, $fdata);
								
								$baris = $no_baris + 1;
								$tunggakan = $row['stpd_sanksi'] - $row['stpd_pajak'];
								$worksheet1->writeNumber($no_baris,11,$tunggakan,$fsisa);

								// $worksheet1->writeFormula($no_baris, 11, "=K".$baris."-H".$baris, $fsisa);
								
								$no_urut++;
								$no_baris++;

								$tot_pajak += $row['stpd_pajak'];
								$tot_sanksi += $row['stpd_sanksi'];
								$tot_tunggakan += $tunggakan;

							}
						
					}
				}
				
					//bagian total
					$worksheet1->writeString($no_baris, 0, "TOTAL", $ftotal);
					$worksheet1->writeBlank($no_baris, 1, $ftotal);$worksheet1->writeBlank($no_baris, 2, $ftotal);$worksheet1->writeBlank($no_baris, 3, $ftotal);$worksheet1->writeBlank($no_baris, 4, $ftotal);
					$worksheet1->writeBlank($no_baris, 5, $ftotal);$worksheet1->writeBlank($no_baris, 6, $ftotal);
					$worksheet1->mergeCells($no_baris, 0, $no_baris, 6);
					
					$worksheet1->writeNumber($no_baris,7,$tot_pajak,$ftotal_currency);
					// $worksheet1->writeFormula($no_baris, 7, "=SUM(H7:H".$no_baris.")", $ftotal_currency);

					$worksheet1->writeBlank($no_baris, 8, $ftotal);$worksheet1->writeBlank($no_baris, 9, $ftotal);
					$worksheet1->mergeCells($no_baris, 8, $no_baris, 9);

					$worksheet1->writeNumber($no_baris,10,$tot_sanksi,$ftotal_currency);
					// $worksheet1->writeFormula($no_baris, 10, "=SUM(K7:K".$no_baris.")", $ftotal_currency);

					$worksheet1->writeNumber($no_baris,11,$tot_tunggakan,$ftotal_sisa);
					$worksheet1->writeFormula($no_baris, 11, "=SUM(L7:L".$no_baris.")", $ftotal_sisa);
				
			}
		} else {
			//get data wp
			if ($lap_realisasi == 1) {
				$dt_rekap = $this->stpd_model->get_data_rekapitulasi(
													1,
													$this->input->get('jenis_pajak'),
													NULL,
													$this->input->get('fDate'),														
													$this->input->get('tDate'),
													$this->input->get('status_spt'));
			} else {
				$dt_rekap = $this->stpd_model->get_data_rekapitulasi(
													0,
													$this->input->get('jenis_pajak'),
													NULL,
													$bulan_pajak,														
													$tahun_pajak,
													$this->input->get('status_spt'));
			}
			
			$tot_pajak = 0;
			$tot_sanksi = 0;
			$tot_tunggakan = 0;
			
			foreach ($dt_rekap as $row) {
				$worksheet1->writeNumber($no_baris, 0, $no_urut, $fdata);
				$worksheet1->writeString($no_baris, 1, $row['wp_wr_nama'], $fdata);
				$worksheet1->writeString($no_baris, 2, $row['npwprd'], $fdata_center);
				$worksheet1->writeString($no_baris, 3, strtoupper($row['wp_wr_almt']), $fdata);
				$worksheet1->writeNumber($no_baris, 4, ceil((strtotime($row['stpd_periode_jual1']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				$worksheet1->writeNumber($no_baris, 5, ceil((strtotime($row['stpd_periode_jual1']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				$worksheet1->writeString($no_baris, 6, $row['stpd_nomor'], $fdata_center);
				$worksheet1->writeNumber($no_baris, 7, $row['stpd_pajak'], $fcurrency);
				$worksheet1->writeString($no_baris, 8, $row['skbh_no'], $fdata_center);
				
				if ($row['stpd_tgl_setoran'] != NULL)
					$worksheet1->writeNumber($no_baris, 9, ceil((strtotime($row['stpd_tgl_setoran']) + $ut_to_ed_diff) / $seconds_in_a_day), $fdate);
				else 
					$worksheet1->writeBlank($no_baris, 9, $fdate);
					
				if ($row['stpd_tgl_setoran'] != NULL)
					$worksheet1->writeNumber($no_baris, 10, $row['stpd_sanksi'], $fcurrency);
				else
					$worksheet1->writeBlank($no_baris, 10, $fdata);
				
				$baris = $no_baris + 1;
				$tunggakan = $row['stpd_sanksi'] - $row['stpd_pajak'];
				$worksheet1->writeNumber($no_baris,11,$tunggakan,$fsisa);
				
				// $worksheet1->writeFormula($no_baris, 11, "=K".$baris."-H".$baris, $fsisa);
				
				$no_urut++;
				$no_baris++;

				$tot_pajak += $row['stpd_pajak'];
				$tot_sanksi += $row['stpd_sanksi'];
				$tot_tunggakan += $tunggakan;
			}
			
			//bagian total
			$worksheet1->writeString($no_baris, 0, "TOTAL", $ftotal);
			$worksheet1->writeBlank($no_baris, 1, $ftotal);$worksheet1->writeBlank($no_baris, 2, $ftotal);$worksheet1->writeBlank($no_baris, 3, $ftotal);
			$worksheet1->writeBlank($no_baris, 4, $ftotal);$worksheet1->writeBlank($no_baris, 5, $ftotal);$worksheet1->writeBlank($no_baris, 6, $ftotal);
			$worksheet1->mergeCells($no_baris, 0, $no_baris, 6);
			$worksheet1->writeFormula($no_baris, 7, "=SUM(H7:H".$no_baris.")", $ftotal_currency);
			$worksheet1->writeBlank($no_baris, 8, $ftotal);$worksheet1->writeBlank($no_baris, 9, $ftotal);
			$worksheet1->mergeCells($no_baris, 8, $no_baris, 9);
			$worksheet1->writeFormula($no_baris, 10, "=SUM(K7:K".$no_baris.")", $ftotal_currency);
			$worksheet1->writeFormula($no_baris, 11, "=SUM(L7:L".$no_baris.")", $ftotal_sisa);
		}
		
		//close workbook
		$workbook->close();
	}
}