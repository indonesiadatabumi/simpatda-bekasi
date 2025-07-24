<?php 

error_reporting(E_ERROR | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';

//Class Extention for header and footer 
// require_once APPPATH.'libraries/fpdf/table/header_footer_daftarinduk.inc';

//Table Defintion File
require_once APPPATH.'libraries/fpdf/table/table_def.inc';

session_start();

$_SESSION['username'] = $this->session->userdata('USER_FULL_NAME');
class pdf_usage extends fpdf_table
{	
	public function Header()
	{
		$this->SetY(10);
	    $this->SetFont('Arial','B',14);
	    $this->SetTextColor(0,0,0);
	    $this->MultiCell(0, 4, "", 0, 'C');
	}	
	
	public function Footer()
	{
		$username = $_SESSION['username'];
	    $this->SetY(-15);
	    $this->SetFont('Arial','I',6);
	    $this->SetTextColor(0,0,0);
	    $this->MultiCell(0, 4, "Halaman {$this->PageNo()} / {nb}", 0, 'C');
		// Menambahkan tanggal di sisi kiri
        $this->SetY(-15);
        $this->Cell(0, 10, 'Printed on ' . date('d-m-Y') . ' from SIMPATDA by ' . $username, 0, 0, 'L');
	}
}

$line_spacing = 5;
$pdf = new FPDF();

$pdf = new pdf_usage('L','mm','A4'); // Portrait dengan ukuran kertas A4
$pdf->Open();
$pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
$pdf->SetMargins(10, 20, 10);     // Margin Left, Top, Right 2 cm
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetStyle("sb","arial","B",7,"0,0,0");
$pdf->SetStyle("b","arial","B",8,"0,0,0");
$pdf->SetStyle("h1","arial","B",12,"0,0,0");
$pdf->SetStyle("h2","arial","B",10,"0,0,0");
$pdf->SetStyle("nu","arial","U",8,"0,0,0");

//$logo = "assets/".$pemda->dapemda_logo_path;
$pdf->Image("assets/images/logo-kotabekasi.JPG",10,14,13);


$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,"PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2),'','','L').
						$pdf->SetFont('Arial','B',10).$pdf->Cell(140,3,"DAFTAR SPTPD " . strtoupper($jenis_pajak->ref_jenparet_ket),'','','C'),'','','',0);

$pdf->MultiCell(190,3,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,strtoupper($pemda->nama_dinas),'','','L').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);

if ($_GET['tahun'] == $_GET['tahun2']){
	$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,ucwords(strtolower($pemda->dapemda_lokasi)),'','','L').
						$pdf->SetFont('Arial','B',10).$pdf->Cell(140,4, "TAHUN : " . $_GET['tahun'],'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);
}else{
	$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',7).
						$pdf->Cell(12,3,"",'','','C').
						$pdf->Cell(50,3,ucwords(strtolower($pemda->dapemda_lokasi)),'','','L').
						$pdf->SetFont('Arial','B',10).$pdf->Cell(140,4, "TAHUN : " . $_GET['tahun']. " - ". $_GET['tahun2'],'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);
}

if ($_GET['masa_pajak'] == $_GET['masa_pajak2']){
	$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',7).
						$pdf->Cell(12,4,"",'','','C').
						$pdf->Cell(50,2,"Telp. " .$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax,'','','L').
						$pdf->SetFont('Arial','B',10).$pdf->Cell(140,4, "MASA PAJAK : ".strtoupper(getNamaBulan($_GET['masa_pajak'])),'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);
}else{
	$pdf->MultiCell(190,4,$pdf->SetFont('Arial','',7).
						$pdf->Cell(12,4,"",'','','C').
						$pdf->Cell(50,2,"Telp. " .$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax,'','','L').
						$pdf->SetFont('Arial','B',10).$pdf->Cell(140,4, "MASA PAJAK : ".strtoupper(getNamaBulan($_GET['masa_pajak']). " - ".strtoupper(getNamaBulan($_GET['masa_pajak2']))),'','','C').
						$pdf->Cell(48,3,"",'','','C'),'','','',0);
}


$pdf->MultiCell(182,2,$pdf->SetFont('Arial','B',7).
						$pdf->Cell(12,2,"",'','','C').
						$pdf->Cell(50,2,strtoupper($pemda->dapemda_ibu_kota),'','','L'),'','','',0);

//Untuk Landscape A4 set lebar 270mm
$kol = 11;
$pdf->tbInitialize($kol, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($a=0; $a<$kol; $a++) $lbr[$a] = $table_default_datax_type;

$lbr[0]['WIDTH'] = 8;
$lbr[1]['WIDTH'] = 20;
$lbr[2]['WIDTH'] = 15;
$lbr[3]['WIDTH'] = 40;
$lbr[4]['WIDTH'] = 50;
$lbr[5]['WIDTH'] = 30;
$lbr[6]['WIDTH'] = 25;
$lbr[7]['WIDTH'] = 10;
$lbr[8]['WIDTH'] = 30;
$lbr[9]['WIDTH'] = 30;
$lbr[10]['WIDTH'] = 20;

$pdf->tbSetHeaderType($lbr);

for($b=0; $b<$kol; $b++) {
	$jdl[$b] = $table_default_datax_type;
	$ket[$b] = $table_default_datax_type;
	$tbl1[$b] = $table_default_tblheader_type;
	$grs[$b] = $table_default_datax_type;
	$tbl2[$b] = $table_default_tbldata_type;
	$tbl3[$b] = $table_default_datax_type;
}

/*
$jdl[0]['COLSPAN'] = 10;
$jdl[0]['T_ALIGN'] = 'C';
$jdl[0]['TEXT'] = "<h1>DAFTAR SPTPD " . strtoupper($jenis_pajak->ref_jenparet_ket) . "</h1>\n<h2>TAHUN : " . $_GET['tahun'] . "\nMASA PAJAK : ".strtoupper(getNamaBulan($_GET['masa_pajak']))."</h2>";
$pdf->tbDrawData($jdl);
*/

$jdl[0]['TEXT'] = "";
$pdf->tbDrawData($jdl);

/*
$ket[0]['COLSPAN'] = 10;
$ket[0]['T_ALIGN'] = 'L';
$ket[0]['TEXT'] = "NAMA REKENING : " . $jenis_pajak;
$pdf->tbDrawData($ket);
*/	

if($kecamatan != null) {
	$ket[0]['COLSPAN'] = 10;
	$ket[0]['T_ALIGN'] = 'L';$ket[0]['T_SIZE'] = 9;
	$ket[0]['TEXT'] = "KECAMATAN : " . $kecamatan;
	$pdf->tbDrawData($ket);
}

if($daftar_spt == '1') {
	$ket[0]['COLSPAN'] = 10;
	$ket[0]['T_ALIGN'] = 'L';$ket[0]['T_SIZE'] = 9;
	$ket[0]['TEXT'] = "Status : Sudah Melaporkan";
	$pdf->tbDrawData($ket);
}elseif($daftar_spt == '2'){
	$ket[0]['COLSPAN'] = 10;
	$ket[0]['T_ALIGN'] = 'L';$ket[0]['T_SIZE'] = 9;
	$ket[0]['TEXT'] = "Status : Belum Melaporkan";
	$pdf->tbDrawData($ket);
}else{
	$ket[0]['COLSPAN'] = 10;
	$ket[0]['T_ALIGN'] = 'L';$ket[0]['T_SIZE'] = 9;
	$ket[0]['TEXT'] = "Status : Sudah Melaporkan & Belum Melaporkan";
	$pdf->tbDrawData($ket);
}
	
if(!empty($_GET['sistem_pemungutan']) || !empty($_GET['jenis_pajak_restoran'])) {
	$kettttt = ($sistem_pemunggutan=='2') ? 'OFFICIAL ASSESMENT':'SELF ASSESMENT';
	$ket[0]['COLSPAN'] = 4;
	$ket[0]['T_ALIGN'] = 'L';
	$ket[0]['TEXT'] = "SISTEM PEMUNGGUTAN : " . $kettttt;
	
	//untuk restoran
	if ($_GET['jenis_pajak_restoran'] != "0" && $_GET['jenis_pajak_restoran'] != null) {
		$jenis_restoran = "";
		if ($_GET['jenis_pajak_restoran'] == "1")
			$jenis_restoran = "RUMAH MAKAN";
		elseif ($_GET['jenis_pajak_restoran'] == "2")
			$jenis_restoran = "CATERING";
			
		$ket[5]['COLSPAN'] = 6;
		$ket[5]['T_ALIGN'] = 'L';
		$ket[5]['TEXT'] = "JENIS : " . $jenis_restoran;
	}
	
	$pdf->tbDrawData($ket);
}

$pdf->tbOuputData();

$kol = 11;
$pdf->tbInitialize($kol, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($a=0; $a<$kol; $a++) {
	$header1[$a] = $table_default_tblheader_type;
	$header2[$a] = $table_default_tblheader_type;
}

$header1[0]['WIDTH'] = 8;
$header1[1]['WIDTH'] = 20;
$header1[2]['WIDTH'] = 15;
$header1[3]['WIDTH'] = 40;
$header1[4]['WIDTH'] = 50;
$header1[5]['WIDTH'] = 30;
$header1[6]['WIDTH'] = 25;
$header1[7]['WIDTH'] = 10;
$header1[8]['WIDTH'] = 30;
$header1[9]['WIDTH'] = 30;
$header1[10]['WIDTH'] = 20;

$header1[0]['TEXT'] = "<b>No.</b>";
$header1[1]['TEXT'] = "<b>S P T P D</b>";
$header1[3]['TEXT'] = "<b>Wajib Pajak / Pemilik</b>";
$header1[4]['TEXT'] = "<b>A l a m a t</b>";
$header1[5]['TEXT'] = "<b>N P W P D</b>";
$header1[6]['TEXT'] = "<b>Masa Pajak</b>";
$header1[7]['TEXT'] = "<b>Tarif\n(%)</b>";
$header1[8]['TEXT'] = "<b>O m z e t  (Rp.)</b>";
$header1[9]['TEXT'] = "<b>P a j a k (Rp.)</b>";
$header1[10]['TEXT'] = "<b>Tgl Lapor</b>";

$header1[1]['COLSPAN'] = 2;
$header1[0]['ROWSPAN'] = 2;
$header1[3]['ROWSPAN'] = 2;
$header1[4]['ROWSPAN'] = 2;
$header1[5]['ROWSPAN'] = 2;
$header1[6]['ROWSPAN'] = 2;
$header1[7]['ROWSPAN'] = 2;
$header1[8]['ROWSPAN'] = 2;
$header1[9]['ROWSPAN'] = 2;
$header1[10]['ROWSPAN'] = 2;

$header1[0]['LN_SIZE'] = 6;
$header1[1]['LN_SIZE'] = 6;
$header1[2]['LN_SIZE'] = 6;
$header1[3]['LN_SIZE'] = 6;
$header1[4]['LN_SIZE'] = 6;
$header1[5]['LN_SIZE'] = 6;
$header1[6]['LN_SIZE'] = 6;
$header1[7]['LN_SIZE'] = 6;
$header1[8]['LN_SIZE'] = 6;
$header1[9]['LN_SIZE'] = 6;
$header1[10]['LN_SIZE'] = 6;

$header1[0]['BRD_TYPE'] = 'LT';
$header1[1]['BRD_TYPE'] = 'LT';
$header1[3]['BRD_TYPE'] = 'LT';
$header1[4]['BRD_TYPE'] = 'LT';
$header1[5]['BRD_TYPE'] = 'LT';
$header1[6]['BRD_TYPE'] = 'LT';
$header1[7]['BRD_TYPE'] = 'LT';
$header1[8]['BRD_TYPE'] = 'LT';
$header1[9]['BRD_TYPE'] = 'LRT';
$header1[10]['BRD_TYPE'] = 'LRT';

$header2[1]['TEXT'] = "Tanggal";
$header2[2]['TEXT'] = "No. Urut";
$header2[1]['COLSPAN'] = 1;
$header2[2]['BRD_TYPE'] = 'LRT';
$header2[1]['BRD_TYPE'] = 'LT';
//$pdf->tbDrawData($header1);

$header2[1]['T_TYPE'] = "B";
$header2[2]['T_TYPE'] = "B";

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

$counter = 1;
$omset = 0; $pajak = 0;

$tbl2[0]['T_ALIGN'] = 'R';
$tbl2[1]['T_ALIGN'] = 'C';
$tbl2[2]['T_ALIGN'] = 'C';
$tbl2[5]['T_ALIGN'] = 'C';
$tbl2[6]['T_ALIGN'] = 'C';
$tbl2[7]['T_ALIGN'] = 'C';
$tbl2[8]['T_ALIGN'] = 'R';
$tbl2[9]['T_ALIGN'] = 'R';
$tbl2[10]['T_ALIGN'] = 'C';

$tbl2[0]['BRD_TYPE'] = 'LT';
$tbl2[1]['BRD_TYPE'] = 'LT';
$tbl2[2]['BRD_TYPE'] = 'LT';
$tbl2[3]['BRD_TYPE'] = 'LT';
$tbl2[4]['BRD_TYPE'] = 'LT';
$tbl2[5]['BRD_TYPE'] = 'LT';
$tbl2[6]['BRD_TYPE'] = 'LT';
$tbl2[7]['BRD_TYPE'] = 'LT';
$tbl2[8]['BRD_TYPE'] = 'LT';
$tbl2[9]['BRD_TYPE'] = 'LRT';
$tbl2[10]['BRD_TYPE'] = 'LRT';

$tbl2[0]['T_SIZE'] = '8';
$tbl2[1]['T_SIZE'] = '8';
$tbl2[2]['T_SIZE'] = '8';
$tbl2[3]['T_SIZE'] = '8';
$tbl2[4]['T_SIZE'] = '8';
$tbl2[5]['T_SIZE'] = '8';
$tbl2[6]['T_SIZE'] = '8';
$tbl2[7]['T_SIZE'] = '8';
$tbl2[8]['T_SIZE'] = '8';
$tbl2[9]['T_SIZE'] = '8';
$tbl2[10]['T_SIZE'] = '8';

$tbl2[0]['LN_SIZE'] = $line_spacing;
$tbl2[1]['LN_SIZE'] = $line_spacing;
$tbl2[2]['LN_SIZE'] = $line_spacing;
$tbl2[3]['LN_SIZE'] = $line_spacing;
$tbl2[4]['LN_SIZE'] = $line_spacing;
$tbl2[5]['LN_SIZE'] = $line_spacing;
$tbl2[6]['LN_SIZE'] = $line_spacing;
$tbl2[7]['LN_SIZE'] = $line_spacing;
$tbl2[8]['LN_SIZE'] = $line_spacing;
$tbl2[9]['LN_SIZE'] = $line_spacing;
$tbl2[10]['LN_SIZE'] = $line_spacing;

if (count($rows) > 0) {		
	foreach($rows as $key => $val) {
		
		if ($_GET['spt_jenis_pajakretribusi'] == "3" || $_GET['spt_jenis_pajakretribusi'] == "7") {
			$spt_detail = $model->get_sptpd_detail($val['spt_id']);
			
			$row_span = count($spt_detail);
			
			if ($row_span > 0) {
				$tbl2[0]['TEXT'] = "" . $counter . ".";
				$tbl2[1]['TEXT'] = "" . format_tgl($val['spt_tgl_proses']);
				$tbl2[2]['TEXT'] = "" . $val['spt_nomor'];
				$tbl2[3]['TEXT'] = "" . $val['wp_wr_nama'];
				// $tbl2[4]['TEXT'] = "" . ereg_replace("\r|\n","",$val['wp_wr_almt']);
				$tbl2[4]['TEXT'] = "" . $val['wp_wr_almt'];
				$tbl2[5]['TEXT'] = "" . $val['npwprd'];
				$tbl2[6]['TEXT'] = "" . getNamaBulan(date("m",strtotime($val['spt_periode_jual1'])))." ".date("Y",strtotime($val['spt_periode_jual1']));
				
				$tbl2[0]['ROWSPAN'] = $row_span;$tbl2[1]['ROWSPAN'] = $row_span;$tbl2[2]['ROWSPAN'] = $row_span;$tbl2[3]['ROWSPAN'] = $row_span;
				$tbl2[4]['ROWSPAN'] = $row_span;$tbl2[5]['ROWSPAN'] = $row_span;$tbl2[6]['ROWSPAN'] = $row_span;
				
				
				foreach ($spt_detail as $row_detail) {
					$tbl2[7]['TEXT'] = "" . (!empty($row_detail['spt_dt_persen_tarif'])) ? $row_detail['spt_dt_persen_tarif']:$val['korek_persen_tarif'];
					$tbl2[8]['TEXT'] = "" . format_currency($row_detail['spt_dt_jumlah']);
					$tbl2[9]['TEXT'] = "" . format_currency($row_detail['spt_dt_pajak']);	
					
					$omset += $row_detail['spt_dt_jumlah'];
					$pajak += $row_detail['spt_dt_pajak'];
					
					$pdf->tbDrawData($tbl2);
				}
				$tbl2[10]['TEXT'] = "" . $val['tgl_lapor'];	
			} else {
				$tbl2[0]['TEXT'] = "" . $counter . ".";
				$tbl2[1]['TEXT'] = "" . format_tgl($val['spt_tgl_proses']);
				$tbl2[2]['TEXT'] = "" . $val['spt_nomor'];
				$tbl2[3]['TEXT'] = "" . $val['wp_wr_nama'];
				// $tbl2[4]['TEXT'] = "" . ereg_replace("\r|\n","",$val['wp_wr_almt']);
				$tbl2[4]['TEXT'] = "" . $val['wp_wr_almt'];
				$tbl2[5]['TEXT'] = "" . $val['npwprd'];
				$tbl2[6]['TEXT'] = "" . getNamaBulan(date("m",strtotime($val['spt_periode_jual1'])))." ".date("Y",strtotime($val['spt_periode_jual1']));
				$tbl2[7]['TEXT'] = "";
				$tbl2[8]['TEXT'] = "";
				$tbl2[9]['TEXT'] = "";
				$tbl2[10]['TEXT'] = "". $val['tgl_lapor'];;
				
				$tbl2[0]['ROWSPAN'] = 1;$tbl2[1]['ROWSPAN'] = 1;$tbl2[2]['ROWSPAN'] = 1;$tbl2[3]['ROWSPAN'] = 1;
				$tbl2[4]['ROWSPAN'] = 1;$tbl2[5]['ROWSPAN'] = 1;$tbl2[6]['ROWSPAN'] = 1;
				$pdf->tbDrawData($tbl2);
			}
		} else {
			$tbl2[0]['TEXT'] = "" . $counter . ".";
			$tbl2[1]['TEXT'] = "" . format_tgl($val['spt_tgl_proses']);
			$tbl2[2]['TEXT'] = "" . $val['spt_nomor'];
			$tbl2[3]['TEXT'] = "" . $val['wp_wr_nama'];
			// $tbl2[4]['TEXT'] = "" . ereg_replace("\r|\n","",$val['wp_wr_almt']);
			$tbl2[4]['TEXT'] = "" . $val['wp_wr_almt'];
			$tbl2[5]['TEXT'] = "" . $val['npwprd'];
			$tbl2[6]['TEXT'] = "" . getNamaBulan(date("m",strtotime($val['spt_periode_jual1'])))." ".date("Y",strtotime($val['spt_periode_jual1']));
			$tbl2[7]['TEXT'] = "" . (!empty($val['spt_dt_persen_tarif'])) ? $val['spt_dt_persen_tarif']:$val['korek_persen_tarif'];
			$tbl2[8]['TEXT'] = "" . format_currency($val['spt_dt_jumlah']);
			$tbl2[9]['TEXT'] = "" . format_currency($val['spt_dt_pajak']);	
			$tbl2[10]['TEXT'] = "" . $val['tgl_lapor'];
			
			$omset += $val['spt_dt_jumlah'];
			$pajak += $val['spt_dt_pajak'];
			
			$pdf->tbDrawData($tbl2);
		}
	
		$counter++;
	}
}

$tbl3[0]['TEXT'] = "";
$tbl3[0]['TEXT'] = "J U M L A H";
$tbl3[8]['TEXT'] = number_format($omset,"2",",",".");
$tbl3[9]['TEXT'] = number_format($pajak,"2",",",".");
$tbl3[0]['T_SIZE'] = '8';$tbl3[0]['T_TYPE'] = 'B';
$tbl3[8]['T_SIZE'] = '8';
$tbl3[9]['T_SIZE'] = '8';
$tbl3[8]['T_ALIGN'] = 'R';$tbl3[0]['T_ALIGN'] = 'C';
$tbl3[9]['T_ALIGN'] = 'R';
$tbl3[0]['COLSPAN'] = 8;
// $tbl3[6]['COLSPAN'] = 2;
$tbl3[0]['BRD_TYPE'] = 'LT';
$tbl3[8]['BRD_TYPE'] = 'LRT';
$tbl3[9]['BRD_TYPE'] = 'LT';
$tbl3[10]['T_ALIGN'] = 'C';
$tbl3[10]['BRD_TYPE'] = 'LRT';
$tbl3[10]['T_SIZE'] = '8';
$tbl3[10]['TEXT'] = '';
$pdf->tbDrawData($tbl3);

$grs[0]['TEXT'] = "";
$grs[0]['COLSPAN'] = 11;
$grs[0]['LN_SIZE'] = 6;
$grs[0]['BRD_TYPE'] = 'T';
$pdf->tbDrawData($grs);

$pdf->tbOuputData();

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
  

//Tanda Tangan
$kols = 3;
$pdf->tbInitialize($kols, true, true);
$pdf->tbSetTableType($table_default_tbl_type);

for($c=0; $c<$kols; $c++) $width[$c] = $table_default_datax_type;

$width[0]['WIDTH'] = 94;
$width[1]['WIDTH'] = 94;
$width[2]['WIDTH'] = 89;

$pdf->tbSetHeaderType($width);

for($d=0; $d<$kols; $d++) {
	$ttd1[$d] = $table_default_ttd_type;
	$ket[$d] = $table_default_ttd_type;
}

$ttd1[0]['TEXT'] = "Mengetahui,";
$ttd1[1]['TEXT'] = "Diperiksa Oleh,";
$ttd1[2]['TEXT'] = $pemda->dapemda_nm_dati2.", ". format_tgl($_GET['tgl_cetak'],false,true);
$ttd1[2]['T_ALIGN'] = 'L';
$pdf->tbDrawData($ttd1);

if ($this->session->userdata('USER_SPT_CODE') == "10") {
	$ttd1[0]['TEXT'] = ($mengetahui->pejda_kode != '01') ? "a.n. ".$this->config->item('nama_jabatan_kepala_dinas')."\n".$mengetahui->ref_japeda_nama:"" . $mengetahui->ref_japeda_nama;
} else {
	$ttd1[0]['TEXT'] = $mengetahui->ref_japeda_nama;
}

$ttd1[1]['TEXT'] = "" . $diperiksa->ref_japeda_nama;
$ttd1[2]['TEXT'] = "";
$pdf->tbDrawData($ttd1);

$ttd1[0]['TEXT'] = "";
$ttd1[1]['TEXT'] = "";
$ttd1[2]['TEXT'] = "N a m a            : " . $this->session->userdata('USER_FULL_NAME');
$ttd1[2]['TEXT'] .= "\nJ a b a t a n      : " . $this->session->userdata('USER_JABATAN_NAME');
$pdf->tbDrawData($ttd1);

$ttd1[0]['TEXT'] = "";
$ttd1[1]['TEXT'] = "";
$ttd1[2]['TEXT'] = "";
$pdf->tbDrawData($ttd1);
$pdf->tbDrawData($ttd1);

$ttd1[0]['TEXT'] = "<nu>".$mengetahui->pejda_nama."</nu>";
$ttd1[1]['TEXT'] = "<nu>".$diperiksa->pejda_nama."</nu>";
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

$pdf->Output();

?>