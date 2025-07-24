<?php 

	error_reporting(E_ERROR | E_PARSE);

	// Load library FPDF
	define('FPDF_FONTPATH', $this->config->item('fonts_path'));
	
	
	$pdf=new CellPDF('L','mm','A4');
   	$pdf->Open();
    $pdf->AddPage();

    $pdf->SetFont('Arial','',14);
    $judul .=$pdf->WriteHTML("<P ALIGN='center'><B>DAFTAR TARIF KODE REKENING</B></P>");
    $pdf->SetFont('Arial','',10);

    $pdf->MultiCell(180,15,$pdf->Cell(10,15,"NO.",'LTBR',0,'C').$pdf->Cell(35,15,"KODE REKENING",'TBR',0,'C').$pdf->Cell(70,15,"NAMA REKENING",'TBR',0,'C').$pdf->Cell(15,15,"TARIF %",'TBR',0,'C').$pdf->Cell(35,15,"TARIF DASAR (Rp)",'TBR',0,'C').$pdf->Cell(35,15,"P E R D A",'TBR',0,'C'),'','','L');
                
    $pdf->SetFont('Arial','',9);
    $counter_header = 1;

    $jml=0;
    $sql = "SELECT a.*,b.*,c.* 
    		FROM kode_rekening a LEFT JOIN dasar_hukum_kode_rekening b ON a.korek_id_hukum = b.dahukorek_id, ref_kategori_kode_rekening c 
    		WHERE a.korek_kategori=c.ref_kakorek_id and a.korek_tipe ~~* '4%' AND korek_status_aktif='TRUE'
    		ORDER BY korek_tipe, korek_kelompok, korek_jenis, korek_objek, korek_rincian, korek_sub1, korek_sub2, korek_sub3";
    
    $qr_data_mstr = $this->adodb->GetAll($sql) ;
    foreach($qr_data_mstr as $qr_mstr1 => $qr_mstr)
    {
    	if (!empty($qr_mstr[korek_tipe])) { $tamp1 = $qr_mstr[korek_tipe];}
        if (!empty($qr_mstr[korek_kelompok])) { $tamp2 = '.'.$qr_mstr[korek_kelompok];}
        if (!empty($qr_mstr[korek_jenis])) { $tamp3 = '.'.$qr_mstr[korek_jenis];}
        if (!empty($qr_mstr[korek_objek])) { $tamp4 = '.'.$qr_mstr[korek_objek];}
        if (!empty($qr_mstr[korek_rincian])) { $tamp5 = '.'.$qr_mstr[korek_rincian];}
        if (!empty($qr_mstr[korek_sub1])) { $tamp6 = '.'.$qr_mstr[korek_sub1];}
        if (!empty($qr_mstr[korek_sub2])) { $tamp7 = '.'.$qr_mstr[korek_sub2];}
        if (!empty($qr_mstr[korek_sub3])) { $tamp8 = '.'.$qr_mstr[korek_sub3];}
        $tamp = $tamp1.$tamp2.$tamp3.$tamp4.$tamp5.$tamp6.$tamp7.$tamp8;
        $korek_tarif_dsr=number_format ($qr_mstr[korek_tarif_dsr], 2,',','.');
                       
        $pdf->MultiCell(180,5,$pdf->Cell(10,5,"$counter_header",'LR',0,'C').$pdf->Cell(35,5,"$tamp",'R',0,'L').$pdf->Cell(70,5,"$qr_mstr[korek_nama]",'R',0,'L').$pdf->Cell(15,5,"$qr_mstr[korek_persen_tarif]",'R',0,'C').$pdf->Cell(35,5,"$korek_tarif_dsr",'R',0,'R').$pdf->Cell(35,5,"$qr_mstr[dahukorek_no_perda]",'R',0,'R'),'','','R');
        $counter_header++;
  	}

 	$pdf->MultiCell(180,5,$pdf->Cell(10,1," ",'LBR',0,'C').$pdf->Cell(35,1," ",'BR',0,'L').$pdf->Cell(70,1," ",'BR',0,'C').$pdf->Cell(15,1," ",'BR',0,'C').$pdf->Cell(35,1," ",'BR',0,'C').$pdf->Cell(35,1," ",'BR',0,'R'),'','','C');
    $pdf->Output();
                
?>