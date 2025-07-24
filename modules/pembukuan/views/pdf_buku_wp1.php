<?php 

error_reporting(E_ERROR);

// Load library FPDF
define('FPDF_FONTPATH',$this->config->item('fonts_path'));

require_once APPPATH.'libraries/fpdf/cellpdf.php';

$pdf = new CellPDF('L','mm','Legal'); // Portrait dengan ukuran kertas A3
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetLeftMargin(25);

$pdf->SetStyle("sb","arial","B",7,"0,0,0");
$pdf->SetStyle("b","arial","B",8,"0,0,0");
$pdf->SetStyle("h1","arial","B",8,"0,0,0");
$pdf->SetStyle("nu","arial","U",8,"0,0,0");
$pdf->SetStyle("th1","arial","B",10,"0,0,0");

if($this->input->get('jenis_pemungutan') == 2) {    //  OFFICIAL ASSESMENT
    $title_column = "P E N E T A P A N";
    $jenis_pemungutan = "OFFICIAL ASSESMENT";
    $column_tgl = "TANGGAL";
    $column_kohir = "NO. KOHIR";
    $column_jumlah = "JUMLAH KETETAPAN";
    $column_ketetapan = "KETETAPAN";
}
elseif($this->input->get('jenis_pemungutan') == 1) {   //  SELF ASSESMENT
    $title_column = "D A T A   S P T P D ";
    $jenis_pemungutan = "SELF ASSESMENT";
    $column_tgl = "TANGGAL";
    $column_kohir = "NO. SPT";
    $column_jumlah = "DASAR OMSET";
    $column_ketetapan = "PAJAK";
}

if (!empty($dt_rows)) {
	$logo = "assets/".$pemda['dapemda_logo_path'];   
	$infopemda = "\n\nPEMERINTAH ".strtoupper($pemda['dapemda_nama']." ".$pemda['dapemda_nm_dati2'])."\n".strtoupper($pemda['nama_dinas'])."\n";
	$pemda_lokasi = $pemda['dapemda_lokasi']." - ".$pemda['dapemda_ibu_kota']."\nTelp. ".$pemda['dapemda_no_telp'];
	
	$pdf->Image($logo,25,11,14,15);
	
	$wp = $dt_rows[0];

    $pdf->Cell(14); 
    $pdf->SetFont('Arial','B',10);$pdf->Cell(1,8,$infopemda);
    $pdf->SetFont('Arial','',8);$pdf->Cell(1,24,$pemda_lokasi,0,0,'L');
    $pdf->SetFont('Arial','B',10);$pdf->Cell(310,5,"BUKU WAJIB PAJAK",0,2,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Ln(0);
    $pdf->Cell(120); $pdf->Cell(30,5,"NAMA WAJIB PAJAK",0,0);$pdf->Cell(4,5,": ",0,0);$pdf->Cell(160,5,$wp['wp_wr_nama'],0,2);
    $pdf->Ln(0);
    $pdf->Cell(120);$pdf->Cell(30,5,"N.P.W.P.D",0,0);$pdf->Cell(4,5,": ",0,0);$pdf->Cell(110,5,$wp['npwprd'],0,2);  
    $ax = explode("\n",$wp[wp_wr_almt]);  $alamat = implode(' ',$ax);
    $pdf->Ln(0);
    $pdf->Cell(120);$pdf->Cell(30,5,"A L A M A T",0,0);$pdf->Cell(4,5,": ",0,0);$pdf->Cell(110,5,$alamat,0,2);
    $pdf->Ln(0);
    $pdf->Cell(120);$pdf->Cell(30,5,"",0,0);$pdf->Cell(4,5,": ",0,0);$pdf->Cell(110,5,"KELURAHAN ".$wp[wp_wr_lurah]." - KECAMATAN ".$wp[wp_wr_camat],0,2);
    $pdf->Ln(0);
    $pdf->Cell(120);$pdf->Cell(30,5,"TAHUN PAJAK",0,0);$pdf->Cell(4,5,": ",0,0);$pdf->Cell(110,5,$_GET['tahun']."  ( $jenis_pemungutan )",0,2);
    $pdf->Ln(0);
    $pdf->Cell(155,5,"Tanggal Proses:  ".$_GET['tgl_cetak'],0,0);
    $pdf->Cell(155,5,"Halaman : ".$pdf->PageNo()."/{nb}",0,2,'R');
                
    $pdf->Ln(0);
    $pdf->Cell(140,5,"",1,0,'C');
    $pdf->Cell(90,5,$title_column,1,0,'C');
    $pdf->Cell(62,5,"P E N Y E T O R A N",1,0,'C');
    $pdf->Cell(28,5,"",1,2,'C');
       
    $pdf->Ln(0);
    $pdf->Cell(7,5,"No.",1,0,'C');
    $pdf->Cell(28,5,"REKENING",1,0,'C');
    $pdf->Cell(105,5,"U R A I A N",1,0,'C');
    $pdf->Cell(17,5,$column_tgl,1,0,'C');
    $pdf->Cell(17,5,$column_kohir,1,0,'C');
    $pdf->Cell(28,5,$column_jumlah,1,0,'C');
    $pdf->Cell(28,5,$column_ketetapan,1,0,'C');
    $pdf->Cell(17,5,"NO. REG",1,0,'C');
    $pdf->Cell(17,5,"TGL REG",1,0,'C');
    $pdf->Cell(28,5,"JUMLAH SETOR",1,0,'C');
    $pdf->Cell(28,5," S I S A",1,2,'C');   

    $counter = 1;
    $contain = array();
    $n=count($ar_npwpd); $pdf->Ln(0);
    $pdf->Cell(7,1,"",'LR',0,'C').$pdf->Cell(28,1,"",'R',0,'C').$pdf->Cell(105,1,"",'R',0,'C').$pdf->Cell(17,1,"",'R',0,'C').$pdf->Cell(17,1,"",'R',0,'C').$pdf->Cell(28,1,"",'R',0,'C').$pdf->Cell(28,1,"",'R',0,'C').$pdf->Cell(17,1,"",'R',0,'C').$pdf->Cell(17,1,"",'R',0,'C').$pdf->Cell(28,1,"",'R',0,'C').$pdf->Cell(28,1,"",'R',2,'C');
    $pdf->Ln(0);
    $total_tetap = 0;
    $total_setor = 0;
    $total_sisa = 0;
    
	foreach ($dt_rows as $vw) {                                  
    	if($_GET['jenis_pemungutan'] == 2) {
	        $sisa = $vw['spt_pajak'] - $vw['setorpajret_jlh_bayar'];
	        if ($sisa < 0)
	        	$sisa = 0; 
	        $total_sisa += $sisa;
        
        	$pdf->MultiCell(310, 5, $pdf->Cell(7,5,$counter,'LR',0,'L').
        							$pdf->Cell(28,5,$vw['koderek'],'R',0,'L').
        							$pdf->Cell(105,5,$vw['korek_nama'],'R',0,'L').
        							$pdf->Cell(17,5,format_tgl($vw['netapajrek_tgl']),'R',0,'C').
        							$pdf->Cell(17,5,$vw['netapajrek_kohir'],'R',0,'C').
        							$pdf->Cell(28,5,format_currency($vw['spt_pajak']),'R',0,'R').
        							$pdf->Cell(28,5,'SKPD','R',0,'C').
        							$pdf->Cell(17,5,$vw['setorpajret_no_bukti'],'R',0,'C').
        							$pdf->Cell(17,5,format_tgl($vw['setorpajret_tgl_bayar']),'R',0,'C').
        							$pdf->Cell(28,5,format_currency($vw['setorpajret_jlh_bayar']),'R',0,'R').
        							$pdf->Cell(28,5,format_currency($sisa),'R',0,'R'),'','','L');
        }
        else {
        	$sisa = $vw['spt_pajak'] - $vw['setorpajret_jlh_bayar'];
	        if ($sisa < 0)
	        	$sisa = 0; 
	        $total_sisa += $sisa;
	        $dt_detail = $model->get_sptpd_detail($vw['spt_id']);
	        $omset = 0;
	        foreach ($dt_detail as $row_detail) {
	        	$omset += $row_detail['spt_dt_jumlah'];
	        }
	        
           $pdf->MultiCell(310,5,$pdf->Cell(7,5,$counter,'LR',0,'L').
           							$pdf->Cell(28,5,$vw['koderek'],'R',0,'L').
           							$pdf->Cell(105,5,$vw['korek_nama'],'R',0,'L').
           							$pdf->Cell(17,5,format_tgl($vw['spt_tgl_proses']),'R',0,'C').
           							$pdf->Cell(17,5,$vw['spt_nomor'],'R',0,'C').
           							$pdf->Cell(28,5,format_currency($omset),'R',0,'R').
           							$pdf->Cell(28,5,format_currency($vw['spt_pajak']),'R',0,'C').
           							$pdf->Cell(17,5,$vw['setorpajret_no_bukti'],'R',0,'C').
           							$pdf->Cell(17,5,format_tgl($vw['setorpajret_tgl_bayar']),'R',0,'C').
           							$pdf->Cell(28,5,format_currency($vw['setorpajret_jlh_bayar']),'R',0,'R').
           							$pdf->Cell(28,5,format_currency($sisa),'R',0,'R'),'','','L');
        }
        
        $counter++;
        $total_tetap = $total_tetap + $vw['spt_pajak'];
	    $total_setor = $total_setor + $vw['setorpajret_jlh_bayar'];
	}
    
	if($_GET['jenis_pemungutan'] == 2) {
    	$pdf->MultiCell(310,5,$pdf->Cell(7+28+50+55,5,"T O T A L  S E L U R U H N Y A",'LTB',0,'C').$pdf->Cell(17+17,5,'','TB').$pdf->Cell(28,5,number_format ($total_tetap, 2,',','.'),'TB',0,'R').$pdf->Cell(28+17+17,5,"",'TB',0,'C').$pdf->Cell(28,5,number_format ($total_setor, 2,',','.'),'TB',0,'R').$pdf->Cell(28,5,number_format ($total_sisa, 2,',','.'),$b.'TRB',0,'R'),'','','L');
  	} else {
    	$pdf->MultiCell(310,5,$pdf->Cell(7+28+50+55+28,5,"T O T A L  S E L U R U H N Y A",'LTB',0,'C').$pdf->Cell(17+17,5,'','TB').$pdf->Cell(28,5,number_format ($total_tetap, 2,',','.'),'TB',0,'R').$pdf->Cell(17+17,5,"",'TB',0,'C').$pdf->Cell(28,5,number_format ($total_setor, 2,',','.'),'TB',0,'R').$pdf->Cell(28,5,number_format ($total_sisa, 2,',','.'),$b.'TRB',0,'R'),'','','L');
	}
              
    $pdf->Output();
} else {
	echo "<script>alert('Data Tidak ada!!');</script>";
}

?>