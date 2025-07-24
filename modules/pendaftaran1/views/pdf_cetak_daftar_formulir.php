<?php 

global $pdf;

$max_baris = 25;
$baris = 1;

$pdf = new CellPDF('L','mm','letter');
$pdf->Open();
$pdf->AddPage();
$pdf->SetMargins(20, 20, 20);
$pdf->SetFont('Arial','',10);

$pdf->MultiCell(180,10,$pdf->Cell(180,10,"",'',0,'C'),'','','C');

/* ------------------------------- Start Header --------------------------------------- */
$pdf->SetFont('Arial','',14);
$judul = $pdf->WriteHTML("<P ALIGN='center'><B>DAFTAR FORMULIR PENDAFTARAN\n");

switch ($_GET['status']) {
	case "0":
		$status = "STATUS : BELUM KEMBALI";
	break;
	case "1":
		$status = "STATUS : DIKIRIM";
		break;
	case "2":
		$status = "STATUS : KEMBALI";
		break;
	default:
		$status = "STATUS : DIKIRIM/KEMBALI/BELUM KEMBALI";
	break;
}
//$judul .= $pdf->WriteHTML("$status</B></P>");
$pdf->MultiCell(180,5,$pdf->Cell(180,5,$judul,'',0,'C'),'','','C');
$pdf->SetFont('Arial','',10);
/* ------------------------------- End Header --------------------------------------- */

table_header();

$pdf->SetFont('Arial','',9);
$counter_header = 1;

if (count($result) > 0) {
	foreach($result as $row)
	{
		if ($baris > $max_baris) {
			closing();
			$pdf->AddPage();
			table_header();
			$baris = 1;
		}
			
		
     	if (!empty($row->wp_wr_tgl_terima_form))
        	$ket = "Sudah di terima WP";
     	else
     		$ket = "Belum di terima WP";
    
		$pdf->MultiCell(180,5,$pdf->Cell(10,5,"$counter_header",'LR',0,'C').
											$pdf->Cell(25,5,"$row->form_nomor",'R',0,'C').
											$pdf->Cell(40,5,"$row->form_nama",'R',0,'L').
											$pdf->Cell(70,5,preg_replace("/[\r|\n]/"," ",$row->form_alamat),'R',0,'L').
											//$pdf->Cell(27,5,"",'R',0,'L').
											$pdf->Cell(27,5,format_tgl($row->form_tgl_kirim),'R',0,'C').
											$pdf->Cell(27,5,format_tgl($row->form_tgl_kembali),'R',0,'C').
											$pdf->Cell(35,5,'','R',0,'C'),'','','L');
		$counter_header++;
		$baris++;
	}
	
	$pdf->MultiCell(180,1,$pdf->Cell(10,1," ",'LBR',0,'C').
							$pdf->Cell(25,1," ",'BR',0,'L').
							$pdf->Cell(40,1," ",'BR',0,'C').
							$pdf->Cell(70,1," ",'BR',0,'L').
							//$pdf->Cell(27,1," ",'BR',0,'C').
							$pdf->Cell(27,1," ",'BR',0,'C').
							$pdf->Cell(27,1," ",'BR',0,'C').
							$pdf->Cell(35,1," ",'BR',0,'R'),'','','L');
                
   	//$pdf->MultiCell(180,5,$pdf->Cell(180,5,"BK II - 01",'',0,'L'),'','','L');
}

	$pdf->MultiCell(180,5,$pdf->Cell(180,5,"",'',0,'L'),'','','L');

    $pdf->MultiCell(180,5,$pdf->Cell(30,5," ",' ',0,'R').$pdf->Cell(50,5,"Mengetahui",' ',0,'C').
    						$pdf->Cell(30,5," ",' ',0,'C').$pdf->Cell(50,5,"Diperiksa Oleh",' ',0,'C').
    						$pdf->Cell(30,5," ",' ',0,'C').$pdf->Cell(70,5," ",' ',0,'L'),'','','C');
                
    $pdf->MultiCell(180,5,$pdf->Cell(30,5," ",' ',0,'R').$pdf->Cell(50,5,$mengetahui_jabatan,' ',0,'C').
    						$pdf->Cell(30,5," ",' ',0,'C').$pdf->Cell(45,5,$pemeriksa_jabatan,' ',0,'C').
    						$pdf->Cell(30,5," ",' ',0,'C').$pdf->Cell(70,5,"Tanggal dibuat : ".format_tgl($_GET['tgl_cetak'], false, true),' ',0,'L'),'','','C');

    $pdf->MultiCell(180,5,$pdf->Cell(30,5," ",' ',0,'R').$pdf->Cell(50,5," ",' ',0,'C').
    						$pdf->Cell(30,5," ",' ',0,'C').$pdf->Cell(45,5," ",' ',0,'C').
    						$pdf->Cell(30,5," ",' ',0,'C').$pdf->Cell(70,5,"Nama : ".$this->session->userdata('USER_FULL_NAME'),' ',0,'L'),'','','C');

    $pdf->MultiCell(180,7,$pdf->Cell(30,7," ",' ',0,'R').$pdf->Cell(50,7," ",' ',0,'C').
    						$pdf->Cell(30,7," ",' ',0,'C').$pdf->Cell(45,7," ",' ',0,'C').
    						$pdf->Cell(30,7," ",' ',0,'C').$pdf->Cell(70,7," ",' ',0,'L'),'','','C');

    $pdf->MultiCell(180,1,$pdf->Cell(30,1," ",' ',0,'R').$pdf->Cell(50,1,$mengetahui_nama,' ',0,'C').
    						$pdf->Cell(30,1," ",' ',0,'C').$pdf->Cell(45,1,$pemeriksa_nama,' ',0,'C').
    						$pdf->Cell(30,1," ",' ',0,'C').$pdf->Cell(70,1,"Tanda Tangan :",' ',0,'L'),'','','C');

    $pdf->MultiCell(180,1,$pdf->Cell(30,1," ",' ',0,'R').$pdf->Cell(50,1,"",'B',0,'C').
    						$pdf->Cell(30,1," ",' ',0,'C').$pdf->Cell(50,1,"",'B',0,'C').
    						$pdf->Cell(30,1," ",' ',0,'C').$pdf->Cell(70,1," ",' ',0,'L'),'','','C');

    $pdf->MultiCell(180,5,$pdf->Cell(30,5," ",' ',0,'R').$pdf->Cell(50,5,$mengetahui_ket_jabatan,' ',0,'C').
    						$pdf->Cell(30,5," ",' ',0,'C').$pdf->Cell(50,5,$pemeriksa_ket_jabatan,' ',0,'C').
    						$pdf->Cell(30,5," ",' ',0,'C').$pdf->Cell(70,5," ",' ',0,'L'),'','','C');
    						
    $pdf->MultiCell(180,3,$pdf->Cell(30,3," ",' ',0,'R').$pdf->Cell(50,3,"NIP.$mengetahui_nip",' ',0,'C').
    						$pdf->Cell(30,3," ",' ',0,'C').$pdf->Cell(50,3,"NIP.$pemeriksa_nip",' ',0,'C').
    						$pdf->Cell(30,3," ",' ',0,'C').$pdf->Cell(70,3," ",' ',0,'L'),'','','C');
																						
$pdf->Output('daftar-formulir.pdf','I');

/**
 * table header function
 */
function table_header() {
	global $pdf;
	$pdf->MultiCell(180,15,$pdf->Cell(10,15,"No.",'LTBR',0,'C').
											$pdf->Cell(25,15," Nomor\n Formulir",'TBR',0,'C').
											$pdf->Cell(40,15,"Nama",'TBR',0,'C').
											$pdf->Cell(70,15,"Alamat Lengkap",'TBR',0,'C').
											//$pdf->Cell(27,15,"No. Telepon",'TBR',0,'C').
											$pdf->Cell(27,15,"Tanggal \n Dikirim",'TBR',0,'C').
											$pdf->Cell(27,15,"Tanggal \n Kembali",'TBR',0,'C').
											$pdf->Cell(35,15,"Keterangan",'TBR',0,'C'),'','','L');
}

/**
 * closing table
 */
function closing() {
	global $pdf;
	
	$pdf->MultiCell(180,1,$pdf->Cell(10,1," ",'LBR',0,'C').
								$pdf->Cell(25,1," ",'BR',0,'L').
								$pdf->Cell(40,1," ",'BR',0,'C').
								$pdf->Cell(70,1," ",'BR',0,'L').
								//$pdf->Cell(27,1," ",'BR',0,'C').
								$pdf->Cell(27,1," ",'BR',0,'C').
								$pdf->Cell(27,1," ",'BR',0,'C').
								$pdf->Cell(35,1," ",'BR',0,'R'),'','','L');
}
?>