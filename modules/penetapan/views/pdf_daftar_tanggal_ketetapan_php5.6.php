<?php 

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Class Extention for header and footer 
require_once APPPATH.'libraries/fpdf/table/header_footer_daftarinduk.inc';

//require_once APPPATH.'libraries/fpdf/table/header_footer_daftarinduk.inc';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';

/*

         1         2         3         4         5         6         7         8         9         10        11        12        13        14        15        16        17        18        19        20
1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345
                                                                                         DAFTAR SURAT KETETAPAN PAJAK DAERAH
                                                                                         -----------------------------------
  Tanggal Ketetapan : 01-01-2008 s/d 08-05-2008
  Nama Rekening     : PAJAK HOTEL ( 4.1.1.01 )                                                                                                                                        H a l a m a n : 1
         1         2         3         4         5         6         7         8         9         10        11        12        13        14        15        16        17        18        19        20
1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345
=============================================================================================================================================================================================================
|    |        SKPD          |                               |                                                           |                   |                     |                             |           |
| No |----------------------|      Nama Wajib Pajak         |                      Alamat                               |     N P W P D     |    Ketetapan (Rp.)  |          Masa Pajak         |  Tanggal  |
|    | Tanggal   | No Kohir |                               |                                                           |                   |                     |                             | Jth.Tempo |
|----|-----------|----------|-------------------------------|-----------------------------------------------------------|-------------------|---------------------|-----------------------------|-----------|
         1         2         3         4         5         6         7         8         9         10        11        12        13        14        15        16        17        18        19        20
1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345
|   1| 06-02-2008| 000000001| HOTEL ABADI                   | JL ABADI - MUARA SUNGSANG                                 | P.2.0000001.02.03 |     10.000.000,00   |   01-01-2008 / 31-01-2008   | 07-03-2008|
|   2| 02-05-2008| 000000008| HOTEL ABADI                   | JL ABADI - MUARA SUNGSANG                                 | P.2.0000001.02.03 |            556,00   |   01-01-2008 / 31-01-2008   | 01-06-2008|
|   3| 08-05-2008| 000000013| HOTEL ABADI                   | JL ABADI - MUARA SUNGSANG                                 | P.2.0000001.02.03 |      1.000.000,00   |   01-01-2008 / 31-01-2008   | 01-06-2008|
|-------------------------------------------------------------------------------------------------------------------------------------------|---------------------|-----------------------------------------|
|                                                                                                            J u m l a h   T o ta l         |     11.000.556,00   |                                         |
=============================================================================================================================================================================================================
         1         2         3         4         5         6         7         8         9         10        11        12        13        14        15        16        17        18        19        20
1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345
                     Menyetujui                                             Mengetahui                                           Diperiksa Oleh                     Tanggal Cetak :  8 Mei 2008
           KEPALA DINAS PENDAPATAN DAERAH                            KEPALA BIDANG PENDAPATAN
                KABUPATEN BANYUASIN
                                                                                                                                                                    N a m a       : MULYADI.K,S.Sos
                                                                                                                                                                    N I P         : 440028652
                                                                                                                                                                    Jabatan       : ADMINISTRATOR
         1         2         3         4         5         6         7         8         9         10        11        12        13        14        15        16        17        18        19        20
1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345
              Drs. H.MUHAMMAD TOBI, MM                                Drs. H.SINARDIN SAIDI                                                                         Tanda Tangan  :
            ---------------------------                            ---------------------------                            ---------------------------
                 PEMBINA UTAMA MUDA                                       P E M B I N A
                   NIP. 440015846                                         NIP. 440017047                                              NIP.


$tahun = $attributes['tahun'];
$bulan = $attributes['bulan'];
$koderek = $attributes['korek'];
$koderek_jenis = $attributes['korek_jenis'];

$jentak_daftar  = $attributes['jenis_cetak_daftar'];
$taptgl_1  = $attributes['netapajrek_tgl_1'];
$taptgl_2  = $attributes['netapajrek_tgl_2'];
$ketspt_id = $attributes['ketspt_id'];
$tgl_cetak = $attributes['tgl_cetak'];

$menyetujui = $attributes['menyetujui'];
$mengetahui = $attributes['mengetahui'];
$pemeriksa = $attributes['pemeriksa'];
$pembuat = $attributes['pembuat'];


*/

$line_spacing = 5;

if ($_GET['spt_jenis_pajakretribusi'] == '8') {
	$pdf = new pdf_usage('L','mm','Letter'); // Landscape dengan ukuran kertas Letter
	$pdf->Open();
	$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
	$pdf->SetMargins(5, 20, 10);     // Margin Left, Top, Right 2 cm
	$pdf->AddPage();
	$pdf->AliasNbPages();
} else {
	$pdf = new pdf_usage('L','mm','Folio'); // Landscape dengan ukuran kertas A4
	$pdf->Open();
	$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
	$pdf->SetMargins(10, 20, 10);     // Margin Left, Top, Right 2 cm
	$pdf->AddPage();
	$pdf->AliasNbPages();
}

$pdf->SetStyle("sb","arial","B",7,"0,0,0");
$pdf->SetStyle("b","arial","B",8,"0,0,0");
$pdf->SetStyle("h1","arial","B",12,"0,0,0");
$pdf->SetStyle("h2","arial","B",10,"0,0,0");
$pdf->SetStyle("nu","arial","U",8,"0,0,0");

$logo = "assets/".$pemda->dapemda_logo_path;
if ($_GET['spt_jenis_pajakretribusi'] == '8') {
	$pdf->Image($logo,5,14,13);
} else {
	$pdf->Image($logo,10,14,13);
}

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,"PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2),'','','L').
						$pdf->Cell(80,3,"",'','','C'),'','','',0);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,strtoupper($pemda->nama_dinas),'','','L').
						$pdf->SetFont('Arial','B',10).$pdf->Cell(140,4,strtoupper($ketetapan->ketspt_ket),'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,ucwords(strtolower($pemda->dapemda_lokasi)),'','','L').
						$pdf->Cell(80,3,"",'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);
					
$pdf->MultiCell(190,3,$pdf->SetFont('Arial','',7).
						$pdf->Cell(12,4,"",'','','C').
						$pdf->Cell(50,3,"Telp. " .$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax,'','','L').
						$pdf->Cell(80,3,"",'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);

$pdf->MultiCell(182,4,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,4,"",'','','C').
						$pdf->Cell(50,3,strtoupper($pemda->dapemda_ibu_kota),'','','L'),'','','',0);

$pdf->ln(2);


$kol = 2;
$pdf->tbInitialize($kol, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($a=0; $a<$kol; $a++) $lbr[$a] = $table_default_datax_type;

$lbr[0]['WIDTH'] = 90;
$lbr[1]['WIDTH'] = 150;

$pdf->tbSetHeaderType($lbr);

for($b=0; $b<$kol; $b++) {
	$jdl[$b] = $table_default_tbldata_type;
}

if ($_GET['spt_jenis_pajakretribusi'] == '8') {	
	$jdl[0]['TEXT'] = "Jenis Pajak   : ".strtoupper($jenis_pajak);
	$jdl[1]['TEXT'] = "Tanggal Ketetapan : ".$_GET['tgl_penetapan1']." s/d ".$_GET['tgl_penetapan2'];
} else {	
	$jdl[0]['TEXT'] = "Jenis Pajak   : ".strtoupper($jenis_pajak);
	$jdl[1]['TEXT'] = "Tanggal Ketetapan : ".$_GET['tgl_penetapan1']." s/d ".$_GET['tgl_penetapan2'];
}
$pdf->tbDrawData($jdl);

if($kecamatan != null || $kecamatan != "") {
	$jdl[0]['TEXT'] = "Kecamatan     : ".strtoupper($kecamatan);
	$jdl[1]['TEXT'] = "";
	$pdf->tbDrawData($jdl);
}

$pdf->tbOuputData();	
	
//Untuk Landscape A4 set lebar 270mm
$kol = 10;
$pdf->tbInitialize($kol, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($a=0; $a<$kol; $a++) {
	$header1[$a] = $table_default_tblheader_type;
	$header2[$a] = $table_default_tblheader_type;
}

$header1[0]['WIDTH'] = 10;
$header1[1]['WIDTH'] = 18;
$header1[2]['WIDTH'] = 18;
$header1[3]['WIDTH'] = 30;
$header1[4]['WIDTH'] = 55;
$header1[5]['WIDTH'] = 60;
$header1[6]['WIDTH'] = 27;
$header1[7]['WIDTH'] = 25;

$header1[0]['ROWSPAN'] = 2;
$header1[1]['COLSPAN'] = 2;$header1[1]['T_ALIGN'] = 'C';
$header1[3]['ROWSPAN'] = 2;
$header1[4]['ROWSPAN'] = 2;
$header1[5]['ROWSPAN'] = 2;
$header1[6]['ROWSPAN'] = 2;
$header1[7]['ROWSPAN'] = 2;

if ($_GET['spt_jenis_pajakretribusi'] == '8') {
	$header1[8]['WIDTH'] = 21;
	$header1[8]['LN_SIZE'] = 6;
} else {
	$header1[8]['WIDTH'] = 40;
	$header1[9]['WIDTH'] = 21;
	$header1[8]['LN_SIZE'] = 6;
	$header1[9]['LN_SIZE'] = 6;
}


$header1[0]['TEXT'] = "<b>NO.</b>";
$header1[1]['TEXT'] = "<b>$ketetapan->ketspt_singkat</b>";
$header1[3]['TEXT'] = "<b>N P W P D</b>";	
$header1[4]['TEXT'] = "<b>NAMA WAJIB PAJAK</b>";
$header1[5]['TEXT'] = "<b>ALAMAT</b>";
if ($_GET['spt_jenis_pajakretribusi'] == '8')
	$header1[6]['TEXT'] = "<b>N.P.A</b>";
else 
	$header1[6]['TEXT'] = "<b>OMSET</b>";
	
$header1[7]['TEXT'] = "<b>KETETAPAN</b>";

$header1[0]['BRD_TYPE'] = 'LT';
$header1[1]['BRD_TYPE'] = 'LT';
$header1[3]['BRD_TYPE'] = 'LT';
$header1[4]['BRD_TYPE'] = 'LT';
$header1[5]['BRD_TYPE'] = 'LT';
$header1[6]['BRD_TYPE'] = 'LT';
$header1[7]['BRD_TYPE'] = 'LT';

if ($_GET['spt_jenis_pajakretribusi'] == '8') {
	$header1[8]['TEXT'] = "<b>JATUH TEMPO</b>";
	$header1[8]['ROWSPAN'] = 2;
	$header1[8]['BRD_TYPE'] = "LRT";
}	
else {
	$header1[8]['TEXT'] = "<b>MASA PAJAK</b>";
	$header1[9]['TEXT'] = "<b>JATUH TEMPO</b>";
	$header1[8]['ROWSPAN'] = 2;
	$header1[9]['ROWSPAN'] = 2;
	$header1[8]['BRD_TYPE'] = "LT";
	$header1[9]['BRD_TYPE'] = "LRT";
}

$header2[2]['BRD_TYPE'] = 'LRT';
$header2[1]['BRD_TYPE'] = 'LT';
$header2[1]['TEXT'] = "<b>TANGGAL</b>";
$header2[2]['TEXT'] = "<b>NO.KOHIR</b>";
$header2[6]['TEXT'] = "<b>( Rp.)</b>";
$header2[7]['TEXT'] = "<b>( Rp.)</b>";
$header2[1]['COLSPAN'] = 1;

$arHeader = array(
	$header1,
	$header2
);

$pdf->tbSetHeaderType($arHeader, true);
$pdf->tbDrawHeader();

for($b=0; $b<$kol; $b++) {
	$jdl[$b] = $table_default_datax_type;
	$ket[$b] = $table_default_datax_type;
	$tbl1[$b] = $table_default_tblheader_type;
	$grs[$b] = $table_default_datax_type;
	$tbl2[$b] = $table_default_datax_type;
	$tbl3[$b] = $table_default_datax_type;
}

/*
$ket[0]['COLSPAN'] = 10;
$ket[0]['T_ALIGN'] = 'L';
$ket[0]['TEXT'] = "NAMA REKENING : " . $jenis_pajak;
$pdf->tbDrawData($ket);
*/
$tbl1[1]['COLSPAN'] = 2;
$tbl1[0]['ROWSPAN'] = 2;
$tbl1[3]['ROWSPAN'] = 2;
$tbl1[4]['ROWSPAN'] = 2;
$tbl1[5]['ROWSPAN'] = 2;


$tbl1[0]['LN_SIZE'] = 6;
$tbl1[1]['LN_SIZE'] = 6;
$tbl1[2]['LN_SIZE'] = 6;
$tbl1[3]['LN_SIZE'] = 6;
$tbl1[4]['LN_SIZE'] = 6;
$tbl1[5]['LN_SIZE'] = 6;
$tbl1[6]['LN_SIZE'] = 6;
$tbl1[7]['LN_SIZE'] = 6;

$tbl1[0]['BRD_TYPE'] = 'LT';
$tbl1[1]['BRD_TYPE'] = 'LT';
$tbl1[3]['BRD_TYPE'] = 'LT';
$tbl1[4]['BRD_TYPE'] = 'LT';
$tbl1[5]['BRD_TYPE'] = 'LT';
$tbl1[6]['BRD_TYPE'] = 'LT';
$tbl1[7]['BRD_TYPE'] = 'LT';
if ($_GET['spt_jenis_pajakretribusi'] == '8') {
	$tbl1[8]['BRD_TYPE'] = 'LRT';
}	
else {
	$tbl1[8]['BRD_TYPE'] = 'LT';
	$tbl1[9]['BRD_TYPE'] = 'LRT';
}


$counter = 1;
$omset = 0; $pajak = 0;
if (!empty($data)) {	
	$tbl2[0]['T_ALIGN'] = 'R';
	$tbl2[1]['T_ALIGN'] = 'C';
	$tbl2[2]['T_ALIGN'] = 'C';
	$tbl2[5]['T_ALIGN'] = 'L';
	$tbl2[6]['T_ALIGN'] = 'R';
	$tbl2[7]['T_ALIGN'] = 'R';
	
	$tbl2[0]['BRD_TYPE'] = 'LT';
	$tbl2[1]['BRD_TYPE'] = 'LT';
	$tbl2[2]['BRD_TYPE'] = 'LT';
	$tbl2[3]['BRD_TYPE'] = 'LT';
	$tbl2[4]['BRD_TYPE'] = 'LT';
	$tbl2[5]['BRD_TYPE'] = 'LT';
	$tbl2[6]['BRD_TYPE'] = 'LT';
	$tbl2[7]['BRD_TYPE'] = 'LT';
	
	
	$tbl2[0]['T_SIZE'] = '8';
	$tbl2[1]['T_SIZE'] = '8';
	$tbl2[2]['T_SIZE'] = '8';
	$tbl2[3]['T_SIZE'] = '8';
	$tbl2[4]['T_SIZE'] = '8';
	$tbl2[5]['T_SIZE'] = '8';
	$tbl2[6]['T_SIZE'] = '8';
	$tbl2[7]['T_SIZE'] = '8';
	
	
	$tbl2[0]['LN_SIZE'] = $line_spacing;
	$tbl2[1]['LN_SIZE'] = $line_spacing;
	$tbl2[2]['LN_SIZE'] = $line_spacing;
	$tbl2[3]['LN_SIZE'] = $line_spacing;
	$tbl2[4]['LN_SIZE'] = $line_spacing;
	$tbl2[5]['LN_SIZE'] = $line_spacing;
	$tbl2[6]['LN_SIZE'] = $line_spacing;
	$tbl2[7]['LN_SIZE'] = $line_spacing;
	
	foreach($data as $key => $val) {
		$tbl2[0]['TEXT'] = "" . $counter . ".";
		$tbl2[1]['TEXT'] = "" . format_tgl($val['netapajrek_tgl']);
		$tbl2[2]['TEXT'] = "" . $val['netapajrek_kohir'];
		$tbl2[3]['TEXT'] = "" . $val['npwprd'];
		$tbl2[4]['TEXT'] = "" . $val['wp_wr_nama'];
		$tbl2[5]['TEXT'] = "" . ereg_replace("\r|\n","",$val['wp_wr_almt']);
		$tbl2[6]['TEXT'] = "" . format_currency($val['omset']);
		$tbl2[7]['TEXT'] = "" . format_currency($val['spt_pajak']);
		if ($_GET['spt_jenis_pajakretribusi'] == '8') {
			$tbl2[8]['TEXT'] = "" . format_tgl($val['netapajrek_tgl_jatuh_tempo']);		
			$tbl2[8]['T_ALIGN'] = 'C';
			$tbl2[8]['BRD_TYPE'] = 'LRT';
			$tbl2[8]['T_SIZE'] = '8';
			$tbl2[8]['LN_SIZE'] = $line_spacing;			
		} else {
			$tbl2[8]['TEXT'] = "" . format_tgl($val['spt_periode_jual1'])." s.d ".format_tgl($val['spt_periode_jual2']);
			$tbl2[9]['TEXT'] = "" . format_tgl($val['netapajrek_tgl_jatuh_tempo']);
			$tbl2[8]['T_ALIGN'] = 'C';
			$tbl2[9]['T_ALIGN'] = 'C';
			$tbl2[8]['BRD_TYPE'] = 'LT';
			$tbl2[9]['BRD_TYPE'] = 'LRT';
			$tbl2[8]['T_SIZE'] = '8';
			$tbl2[9]['T_SIZE'] = '8';
			$tbl2[8]['LN_SIZE'] = $line_spacing;
			$tbl2[9]['LN_SIZE'] = $line_spacing;
		}
		
		$omset += $val['omset'];
		$pajak += $val['spt_pajak'];		
		
		$pdf->tbDrawData($tbl2);
		
		$counter++;
	}
}

$tbl3[0]['TEXT'] = "J U M L A H";
$tbl3[6]['TEXT'] = format_currency($omset);
$tbl3[7]['TEXT'] = format_currency($pajak);
$tbl3[0]['T_SIZE'] = '8';$tbl3[0]['T_TYPE'] = 'B';
$tbl3[6]['T_SIZE'] = '8';
$tbl3[7]['T_SIZE'] = '8';
$tbl3[0]['COLSPAN'] = 6;
$tbl3[0]['T_ALIGN'] = 'C';
$tbl3[6]['T_ALIGN'] = 'R';
$tbl3[7]['T_ALIGN'] = 'R';
$tbl3[0]['BRD_TYPE'] = 'LT';
$tbl3[5]['BRD_TYPE'] = 'LRT';
$tbl3[6]['BRD_TYPE'] = 'LRT';
$tbl3[7]['BRD_TYPE'] = 'LRT';
if ($_GET['spt_jenis_pajakretribusi'] == '8') {
	$tbl3[8]['BRD_TYPE'] = 'LRT';
} else {
	$tbl3[8]['BRD_TYPE'] = 'LRT';
	$tbl3[9]['BRD_TYPE'] = 'RT';
}
$pdf->tbDrawData($tbl3);

$grs[0]['TEXT'] = "";
$grs[0]['COLSPAN'] = 10;
$grs[0]['LN_SIZE'] = 6;
$grs[0]['BRD_TYPE'] = 'T';
$pdf->tbDrawData($grs);

$pdf->tbOuputData();

//Tanda Tangan
if ($_GET['tandatangan'] == "1") {
	// set page constants
	// height of resulting cell
	$cell_height = 5 + 1; // I have my cells at a height of five so set to six for a padding
	$height_of_cell = ceil( 10 * $cell_height );
	$page_height = 215.9; // mm (landscape legal)
	$bottom_margin = 20; // mm
	
	// mm until end of page (less bottom margin of 20mm)
	$space_left = $page_height - $pdf->GetY(); // space left on page
	$space_left -= $bottom_margin; // less the bottom margin
	
	// test if height of cell is greater than space left
	if ( $height_of_cell >= $space_left) {
		$pdf->Ln();                        
	
	    $pdf->AddPage(); // page break.
	}

	$kols = 3;
	$pdf->tbInitialize($kols, true, true);
	$pdf->tbSetTableType($table_default_tbl_type);
	
	for($c=0; $c<$kols; $c++) $width[$c] = $table_default_datax_type;
	
	if ($_GET['spt_jenis_pajakretribusi'] == '8') {
		$width[0]['WIDTH'] = 94;
		$width[1]['WIDTH'] = 102;
		$width[2]['WIDTH'] = 94;
	} else {
		$width[0]['WIDTH'] = 94;
		$width[1]['WIDTH'] = 124;
		$width[2]['WIDTH'] = 89;
	}
	
	
	$pdf->tbSetHeaderType($width);
	
	for($d=0; $d<$kols; $d++) {
		$ttd1[$d] = $table_default_ttd_type;
		$ket[$d] = $table_default_ttd_type;
	}
	
	$ttd1[0]['TEXT'] = "Mengetahui,";
	$ttd1[1]['TEXT'] = "Diperiksa Oleh,";
	$ttd1[2]['TEXT'] = $pemda->dapemda_nm_dati2.", ". format_tgl($_GET['tgl_cetak'],false,true);
	$ttd1[2]['T_ALIGN'] = "L";
	$pdf->tbDrawData($ttd1);
	
	if ($this->session->userdata('USER_SPT_CODE') == "10") {
		$ttd1[0]['TEXT'] = ($mengetahui->pejda_kode != '01') ? "a.n. ".$this->config->item('nama_jabatan_kepala_dinas')."\n".$mengetahui->ref_japeda_nama:"" . $mengetahui->ref_japeda_nama;
	} else {
		$ttd1[0]['TEXT'] = $mengetahui->ref_japeda_nama;
	}
	$ttd1[1]['TEXT'] = $diperiksa->ref_japeda_nama;
	$ttd1[2]['TEXT'] = "";
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "";
	$ttd1[1]['TEXT'] = "";
	$ttd1[2]['TEXT'] = "N a m a            : " . $this->session->userdata('USER_FULL_NAME'). "\nJ a b a t a n      : " . $this->session->userdata('USER_JABATAN_NAME');
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "";
	$ttd1[1]['TEXT'] = "";
	$ttd1[2]['TEXT'] = "";
	$pdf->tbDrawData($ttd1);
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "<nu>  " . $mengetahui->pejda_nama . "  </nu>";
	$ttd1[1]['TEXT'] = "<nu>  " . $diperiksa->pejda_nama . "  </nu>";
	$ttd1[2]['TEXT'] = "Tanda Tangan : . . . . . . . . . . . . . . . . . . . . .";
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "" . $mengetahui->ref_pangpej_ket;
	$ttd1[1]['TEXT'] = "" . $diperiksa->ref_pangpej_ket;
	$ttd1[2]['TEXT'] = "";
	$pdf->tbDrawData($ttd1);
	
	$ttd1[0]['TEXT'] = "NIP. " . $mengetahui->pejda_nip;
    $ttd1[1]['TEXT'] = "NIP. " . $diperiksa->pejda_nip;
	$ttd1[2]['TEXT'] = "";
	$pdf->tbDrawData($ttd1);
	
	$pdf->tbOuputData();	
}

$pdf->Output();

?>