<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Load library FPDF
define('FPDF_FONTPATH', $this->config->item('fonts_path'));

////Table Base Classs
require_once APPPATH . 'libraries/fpdf/table/class.fpdf_table.php';

//Table Defintion File
require_once APPPATH . 'libraries/fpdf/table/table_def.inc';

$ar_wp = $model->getDataReklame($npwprd, $tgl_awal, $tgl_akhir);

foreach ($ar_wp as $wp){
    $pdf = new FPDF_TABLE('P', 'mm', 'A4'); // Landscape,Legal,Lebar = 335 : Potrait = 190
    $pdf->Open();
    $pdf->SetAutoPageBreak(true, 20); // Page Break dengan margin bawah 2 cm
    $pdf->SetMargins(10, 10, 5);     // Margin Left, Top, Right 2 cm
    $pdf->AddPage();
    $pdf->AliasNbPages();


    $logo = "assets/images/logo-kotabekasi.jpg";
    $pdf->Image($logo,18,10,19);

    $pdf->MultiCell(180, 3, $pdf->Cell(1, 4, "", '', 0, 'C') . $pdf->SetFont('Arial', '', 20) . $pdf->Cell(210, 5, "PEMERINTAH KOTA BEKASI", '', 0, 'C'), '', '', 'L');
    $pdf->MultiCell(180, 3, $pdf->Cell(1, 4, "", '', 0, 'C') . $pdf->SetFont('Arial', 'B', 26) . $pdf->Cell(210, 13, "BADAN PENDAPATAN DAERAH", '', 0, 'C'), '', '', 'L');
    $pdf->MultiCell(180, 3, $pdf->Cell(1, 3, "", '', 0, 'C') . $pdf->Cell(210, 18, $pdf->SetFont('Arial', '', 11) . "Jl. Ir. H. Juanda No. 100 Telp. (021) 88397963, Fax (021) 88397965", '', 0, 'C'), '', '', 'L');
    $pdf->MultiCell(180, 3, $pdf->Cell(1, 3, "", '', 0, 'C') . $pdf->Cell(210, 22, $pdf->SetFont('Arial', 'B', 16) . "B E K A S I ", '', 0, 'C'), '', '', 'L');


    //membuat garis ganda tebal dan tipis
    $pdf->SetLineWidth(1);
    $pdf->Line(10, 36, 200, 36);
    $pdf->SetLineWidth(0);
    $pdf->Line(10, 35, 200, 35);

    $pdf->ln(20);
    $pdf->SetFont('Arial', '', 10);
    $y = $pdf->GetY();
    $pdf->MultiCell(90,5,"",0,'L',0);
    $pdf->SetXY(130,$y);
    $pdf->MultiCell(70,3,"Bekasi, ".format_tgl($_GET['tgl_cetak'],false,true),0,'L',0);

    $pdf->ln();
    $y = $pdf->GetY();
    $pdf->MultiCell(90,5,"",0,'L',0);
    $pdf->SetXY(130,$y);
    $pdf->MultiCell(70,7,"Kepada",0,'L',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(120,6,"Nomor                 :   973 / ".$no_surat_teguran."-Bapenda.Wasdalpenda                          Yth.",0,'L',0);
    $pdf->SetXY(130,$y);
    $pdf->MultiCell(70,4,"". $wp['wp_wr_nama'],0,'L',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(90,6,"Sifat                     :  Segera",0,'L',0);
    $pdf->SetXY(130,$y);
	$pdf->MultiCell(75,4,"". $wp['wp_wr_almt'],0,'L',0);
    //$pdf->MultiCell(70,5,"",0,'L',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(90,2,"Lampiran             :  -",0,'L',0);
    $pdf->SetXY(130,$y);
    $pdf->MultiCell(70,5,"",0,'L',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(90,3,"Hal                       :  Pemberitahuan",0,'L',0);
    $pdf->SetXY(130,$y);
  //  $pdf->MultiCell(70,5,"". $wp['wp_wr_almt'],0,'L',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(90,5,"",0,'L',0);
    $pdf->SetXY(130,$y);
    $pdf->MultiCell(70,2,"di-",0,'L',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(90,5,"",0,'L',0);
    $pdf->SetXY(140,$y);
    $pdf->MultiCell(60,11,"Bekasi",0,'L',0);

    $pdf->ln();
    $y = $pdf->GetY();
    $pdf->MultiCell(10,10,"",0,'L',0);
    $pdf->SetXY(40,$y);
    $pdf->MultiCell(150,5,"             Berkenaan Peraturan Daerah Kota Bekasi Nomor 11 Tahun 2016 tentang Ketentuan Umum Pajak Daerah dan catatan pembukuan pada Badan Pendapatan Daerah Kota Bekasi, dengan ini disampaikan hal sebagai berikut : ",0,'J',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(35,5,"1.",0,'R',0);
    $pdf->SetXY(50,$y);
    $pdf->MultiCell(140,5,"Berdasarkan Surat Ketetapan Pajak Daerah (SKPD) Nomor ".$wp['spt_nomor']." tanggal ".format_tgl($wp['spt_periode_jual1'])." terkait pajak reklame atas nama ". $wp['wp_wr_nama'] . " belum melakukan pembayaran pajak reklame sebesar Rp. ".format_currency($wp['spt_pajak'])." (".ucwords(strtolower(terbilang($wp['spt_pajak'])))." Rupiah).",0,'J',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(35,5,"2.",0,'R',0);
    $pdf->SetXY(50,$y);
    $pdf->MultiCell(140,5,"Apabila sampai dengan batas waktu 7 (tujuh) hari setelah tanggal surat pemberitahuan ini belum melakukan pembayaran, maka akan diterbitkan Surat Panggilan.",0,'J',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(35,5,"3.",0,'R',0);
    $pdf->SetXY(50,$y);
    $pdf->MultiCell(140,5,"Apabila Saudara telah melakukan pembayaran pajak reklame dimaksud, dimohon agar Saudara segera melaporkan kepada Bidang Pengawasan dan Pengendalian Pendapatan Daerah pada Badan Pendapatan Daerah Kota Bekasi.",0,'J',0);

    $pdf->ln();
    $y = $pdf->GetY();
    $pdf->MultiCell(10,5,"",0,'L',0);
    $pdf->SetXY(40,$y);
    $pdf->MultiCell(150,5,"             Demikian agar menjadi maklum, atas perhatian dan kerja sama yang baik diucapkan terima kasih.",0,'J',0);

    $pdf->ln();
    $y = $pdf->GetY();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(90,5,"",0,'L',0);
    $pdf->SetXY(110,$y);
    $pdf->MultiCell(80,5,"   ".$pejabat->ref_japeda_nama,0,'L',0);

    $pdf->ln(20);
    $y = $pdf->GetY();
    $pdf->SetFont('Arial', 'BU', 10);
    $pdf->MultiCell(90,5,"",0,'L',0);
    $pdf->SetXY(113,$y);
    $pdf->MultiCell(80,5,"".$pejabat->pejda_nama,0,'L',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->SetFont('Arial', '', 9);
    $pdf->MultiCell(90,5,"",0,'L',0);
    $pdf->SetXY(113,$y);
    $pdf->MultiCell(80,3,"".$pejabat->ref_pangpej_ket,0,'L',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->SetFont('Arial', '', 9);
    $pdf->MultiCell(90,5,"",0,'L',0);
    $pdf->SetXY(113,$y);
    $pdf->MultiCell(80,3,"NIP. ". $pejabat->pejda_nip,0,'L',0);

    $pdf->ln(10);
    $y = $pdf->GetY();
    $pdf->MultiCell(90,5,"Tembusan:",0,'L',0);
    $pdf->SetXY(120,$y);
    $pdf->MultiCell(70,5,"",0,'L',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(9,5,"Yth. ",0,'L',0);
    $pdf->SetXY(18,$y);
    $pdf->MultiCell(120,5,"1. Plt. Inspektur Daerah Kota Bekasi;",0,'L',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(9,5,"",0,'L',0);
    $pdf->SetXY(18,$y);
    $pdf->MultiCell(120,5,"2. Asisten Administrasi Umum dan Perekonomian Setda Kota Bekasi;",0,'L',0);

    $pdf->ln(0);
    $y = $pdf->GetY();
    $pdf->MultiCell(9,5,"",0,'L',0);
    $pdf->SetXY(18,$y);
    $pdf->MultiCell(120,5,"3. Kepala Badan Pengelolaan Keuangan dan Aset Daerah Kota Bekasi.",0,'L',0);
    
    // $pdf->MultiCell(180, 5, $pdf->Cell(1, 5, $pdf->SetFont('Arial', '', 10) . "", '', 0, 'L') . $pdf->Cell(280, 5, "Bekasi, ".format_tgl($_GET['tgl_cetak'],false,true)."", '', 0, 'C'), '', '', 'L');
    // $pdf->MultiCell(180, 3, $pdf->Cell(1, 3, "", '', 0, 'L') . $pdf->Cell(280, 3, "", '', 0, 'C'), '', '', 'L');
    // $pdf->MultiCell(180, 5, $pdf->Cell(1, 5, "", '', 0, 'L') . $pdf->Cell(249, 5, "Kepada", '', 0, 'C'), '', '', 'L');
    // $pdf->MultiCell(180, 5, $pdf->Cell(1, 5, "Nomor           :      /      -Bapenda.Wasdalpenda", '', 0, 'L') . $pdf->Cell(240, 5, "Yth.   " . $wp['wp_wr_nama'], '', 0, 'C'), '', '', 'L');
    // $pdf->MultiCell(180, 5, $pdf->Cell(1, 5, "Sifat               : Segera", '', 0, 'L') . $pdf->Cell(297, 5, "", '', 0, 'C'), '', '', 'L');
    // $pdf->MultiCell(180, 5, $pdf->Cell(1, 5, "Lampiran        : - ", '', 0, 'L') . $pdf->Cell(270, 5, $wp['wp_wr_almt'], '', 0, 'C'), '', '', 'L');
    // $pdf->MultiCell(180, 5, $pdf->Cell(1, 5, "Hal                 : Pemberitahuan", '', 0, 'L') . $pdf->Cell(270, 5, "Kelurahan " . $wp['wp_wr_lurah'], '', 0, 'C'), '', '', 'L');
    // $pdf->MultiCell(180, 5, $pdf->Cell(1, 5, "", '', 0, 'L') . $pdf->Cell(270, 5, "Kecamatan " . $wp['wp_wr_camat'], '', 0, 'C'), '', '', 'L');
    // $pdf->MultiCell(180, 5, $pdf->Cell(100, 5, "", '', 0, 'L') . $pdf->Cell(250, 5, "di-", '', 0, 'L'), '', '', 'L');
    // $pdf->MultiCell(180, 5, $pdf->Cell(1, 5, "", '', 0, 'L') . $pdf->Cell(270, 5, $wp['wp_wr_kabupaten'], '', 0, 'C'), '', '', 'L');

    // $pdf->ln(10);
    // $pdf->Cell(15.4);
    // $pdf->MultiCell(170, 5, "       Berkenaan Peraturan Daerah Kota Bekasi Nomor 11 Tahun 2016 tentang Ketentuan Umum Pajak Daerah dan catatan pembukuan pada Badan Pendapatan Daerah Kota Bekasi, dengan ini disampaikan hal sebagai berikut : ", 0, 'J');
    // $pdf->Cell(15.4);
    // $pdf->MultiCell(170, 5, "1.	Berdasarkan Surat Ketetapan Pajak Daerah (SKPD) Nomor ".$wp['spt_nomor']." tanggal ".format_tgl($wp['spt_periode_jual1'])." terkait pajak reklame atas nama ". $wp['wp_wr_nama'] . " belum melakukan pembayaran pajak reklame sebesar Rp. ".format_currency($wp['spt_pajak'])." (".ucwords(strtolower(terbilang($wp['spt_pajak']))).") Rupiah.", 0, 'J');
    // $pdf->Ln(2);
    // $pdf->Cell(15.4);
    // $pdf->MultiCell(170, 5, "2. Apabila sampai dengan batas waktu 7 (tujuh) hari setelah tanggal surat pemberitahuan ini belum melakukan pembayaran, maka akan diterbitkan Surat Panggilan.", 0, 'J');
    // $pdf->Ln(2);
    // $pdf->Cell(15.4);
    // $pdf->MultiCell(170, 5, "3. Apabila Saudara telah melakukan pembayaran pajak reklame dimaksud, dimohon agar Saudara segera melaporkan kepada Bidang Pengawasan dan Pengendalian Pendapatan Daerah pada Badan Pendapatan Daerah Kota Bekasi.", 0, 'J');

    // $pdf->Ln(4);
    // $pdf->Cell(15.4);
    // $pdf->MultiCell(170, 5, "          Demikian agar menjadi maklum, atas perhatian dan kerja sama yang baik diucapkan terima kasih.", 0, 'J');

    // $pdf->Ln(10);
    // $pdf->Cell(15.4);
    // $pdf->SetFont('Arial', 'B', 10);
    // $pdf->MultiCell(165, 5, $pejabat->ref_japeda_nama, 0, 'R');

    // $pdf->Ln(10);
    // $pdf->Cell(55.4);
    // $pdf->SetFont('Arial', 'BU', 10);
    // $pdf->MultiCell(170, 5, $pejabat->pejda_nama, 0, 'C');

    // $pdf->Cell(55.4);
    // $pdf->SetFont('Arial', '', 9);
    // $pdf->MultiCell(170, 5, $pejabat->ref_pangpej_ket, 0, 'C');

    // $pdf->Cell(55.4);
    // $pdf->SetFont('Arial', '', 9);
    // $pdf->MultiCell(170, 5, 'NIP. ' . $pejabat->pejda_nip, 0, 'C');

    // $pdf->Ln(15);
    // $pdf->MultiCell(180, 5, $pdf->Cell(10, 5, $pdf->SetFont('Arial', '', 10) . "Tembusan :", '', 0, 'L') . $pdf->Cell(306, 5, "", '', 0, 'C'), '', '', 'L');
    // $pdf->MultiCell(180, 5, $pdf->Cell(10, 5, $pdf->SetFont('Arial', '', 10) . "Yth. ", '', 0, 'L') . $pdf->Cell(200, 5, "1. Plt. Inspektur Daerah Kota Bekasi;", '', 0, 'L'), '', '', 'L');
    // $pdf->MultiCell(180, 5, $pdf->Cell(10, 5, $pdf->SetFont('Arial', '', 10) . "", '', 0, 'L') . $pdf->Cell(200, 5, "2. Asisten Administrasi Umum dan Perekonomian Setda Kota Bekasi;", '', 0, 'L'), '', '', 'L');
    // $pdf->MultiCell(180, 5, $pdf->Cell(10, 5, $pdf->SetFont('Arial', '', 10) . "", '', 0, 'L') . $pdf->Cell(200, 5, "3. Kepala Badan Pengelolaan Keuangan dan Aset Daerah Kota Bekasi.", '', 0, 'L'), '', '', 'L');

    // $pdf->ln(10);

    $pdf->Output();
}
