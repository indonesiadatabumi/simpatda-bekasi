<?php
error_reporting(E_ERROR);

/*
define('_MPDF_PATH', 'mpdf60/');
include (_MPDF_PATH."mpdf.php");
//$mpdf=new mPDF('utf-8', 'A4-L');
//$mpdf=new mPDF('utf-8', array(80,297));
$mpdf = new mPDF('','A4', 0, 'trebuchet', 10, 15, 5, 50, 9, 9, 'P');

$mpdf->AddPage('P');
*/

$skpd = " ";
$skpdt = " ";
$stpd = " ";
$strd = " ";
$skrdj = " ";
$sptpd = " ";
$skrd = " ";
$skpdkb = " ";
$skpdlb = " ";

switch($setorpajret_jenis_ketetapan) {
	case 1: $skpd="X"; break;
	case 2: $skpdt="X"; break;
	case 3: $stpd="X"; break;
	case 4: $strd="X"; break;
	case 5: $skrdj="X"; break;
	case 8: $sptpd="X"; break;
	case 9: $skrd="X"; break;
	case 11: $skpdkb="X"; break;
	case 12: $skpdlb="X"; break;
}

$first_sspd_number = $this->input->get('spt_nomor1');
$second_sspd_number = $first_sspd_number;
if ($this->input->get('spt_nomor2') != "")
	$second_sspd_number = $this->input->get('spt_nomor2');

$arr_data = $model->get_distinct_sspd($first_sspd_number, $second_sspd_number);

//var_dump($ar_rekam_setor);
if (!empty($arr_data)) {
	foreach ($arr_data as $key => $val) {
		$denda = 0;
		
		if ($val['spt_jenis_pajakretribusi'] != "4")
			$ar_rekam_setor = $model->get_sspd_detail(
												$val['spt_periode'],
												$val['spt_nomor'],
												$val['ketspt_id'],
												$val['spt_jenis_pajakretribusi']
											);
		else 
			$ar_rekam_setor = $model->get_sspd_detail_reklame(
												$val['spt_periode'],
												$val['spt_nomor'],
												$val['ketspt_id'],
												$val['spt_jenis_pajakretribusi']
											);
											
		if (@$_GET['jenis_setoran'] == "1" || @$_GET['jenis_setoran'] == null || @empty($_GET['jenis_setoran'])) {
			if (count($ar_rekam_setor) > 0) {
				$tanggal_setoran = date("Y-m-d");
				
				//cek jika cetak SSPD dari dinas atau UPTD
				if ($this->session->userdata('USER_SPT_CODE') == "10") {
					if ($this->input->get('tanggal_setor') != "") {
						$tanggal_setoran = format_tgl($this->input->get('tanggal_setor'));
					}
				}
				
				if ($ar_rekam_setor[0]['tgl_jatuh_tempo'] != null  && $_REQUEST['spt_jenis_pajakretribusi'] != "'") {
					$diff_month = get_diff_months($ar_rekam_setor[0]['tgl_jatuh_tempo'], $tanggal_setoran, $ar_rekam_setor[0]['ketspt_id']);
					if ($diff_month > 0)
						$denda = ceil(0.02 * $ar_rekam_setor[0]['spt_pajak'] * $diff_month);
				}
			}	
		}
		
		if ($denda > 0) {
			$query = $this->db->query("SELECT * FROM v_kode_rekening_pajak WHERE koderek='41407' AND jenis='0".$_REQUEST['spt_jenis_pajakretribusi']."'");
			$row = $query->row();
			
			$denda_kode_rekening = $row->korek_tipe.".".$row->korek_kelompok.".".$row->korek_jenis.".".$row->korek_objek.".".$row->jenis;
			$denda_nama_rekening = $row->korek_nama;
		}
		
		$title = ucwords("surat setoran pajak daerah");
		$s_title = strtoupper("sspd");
			
		
		$pmda = "<th1>PEMERINTAH ".strtoupper($pemda->dapemda_nama." ".$pemda->dapemda_nm_dati2)."</th1>\n".
		        "<th1>".strtoupper($pemda->nama_dinas)."</th1>\n".$pemda->dapemda_lokasi."\n".
				"Telp. ".$pemda->dapemda_no_telp.", Fax. ".$pemda->dapemda_no_fax."\n";
		
		for($i=0; $i<$columns; $i++) 
			$header_type[$i] = $table_default_headerx_type;
		
	
		for($i=0; $i<$columns; $i++) {
			$spacer1[$i] = $table_default_datax_type;
			$header_type1[$i] = $table_default_headerx_type;
			$header_type2[$i] = $table_default_headerx_type;
			$header_type3[$i] = $table_default_headerx_type;
			$header_type4[$i] = $table_default_headerx_type;
			$spacer2[$i] = $table_default_datax_type;
		}
		for($a=0; $a<$kolom; $a++) $setcol[$a] = $table_default_datax_type;

		$nama_wp = strtoupper($ar_rekam_setor[0]['wp_wr_nama']);
		
	//	echo $nama_wp;
		

		
		//baris ke-3
		
		if ($ar_rekam_setor[0]['spt_jenis_pajakretribusi'] != ' ') {
			$r1[0]['TEXT'] = "";
			$r1[1]['TEXT'] = "NPWPD";
			$r1[2]['TEXT'] = ":";
			$r1[3]['TEXT'] = "" . $ar_rekam_setor[0][npwprd];
		
		}	
		
		//baris ke-4
		$r1[0]['TEXT'] = "";
		$r1[1]['TEXT'] = "KODE BAYAR";
		$r1[2]['TEXT'] = ":";
		$r1[3]['TEXT'] = "" . $ar_rekam_setor[0][spt_kode_billing];
		
		
		
		$artgl = explode("-",$ar_rekam_setor[0][spt_periode_jual1]);
		$blnxa = $artgl[1];
		

		if ($ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_spt_self') || $ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_skpd') ||
			$ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_stpd')) {
				
			
			 $ar_rekam_setor[0]['spt_nomor'];
						
		} else {
			 $ar_rekam_setor[0]['spt_nomor'];
		}
						

		
		for($e=0; $e<$kol; $e++) {
			$m1[$e] = $table_default_tblheader_type;
			$m2[$e] = $table_default_tbldata_type;
			$m3[$e] = $table_default_tbldata_type;
			$m4[$e] = $table_default_datax_type;
		}
		
	
		
		$counter = 1;
		$total_pajak = 0;
	
		if (count($ar_rekam_setor) > 1) {
			if (count($ar_rekam_setor) == 2 && $denda == 0)
				$newline = "\n\n";
			else 
				$newline = "\n";	
		}
		else {
			if ($denda > 0 )
				$newline = "\n\n\n";
			else 
				$newline = "\n\n\n\n";
		}
		
		if ($ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_spt_self') || $ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_skpd') ||
			$ar_rekam_setor[0]['ketspt_id'] == $this->config->item('status_stpd')) {
				
			foreach ($ar_rekam_setor as $k => $v) {
				$total_pajak += $v['spt_dt_pajak'];
				$masa_pajak = $v['spt_periode_jual1'];
				$arr_masa_pajak = explode("-", $masa_pajak);
				$m2[0]['TEXT'] = "";
				$m2[1]['TEXT'] = "" . $counter;
				$m2[2]['TEXT'] = "" . $v['koderek_detail'];
				if ($this->input->get('spt_jenis_pajakretribusi') != "4")
					$m2[3]['TEXT'] = "" . $v['korek_nama_detail'];
				else 
					//if ($this->input->get('spt_jenis_pajakretribusi') = "4")
					$m2[3]['TEXT'] = "" . $v['korek_nama_detail']."\n".$v['sptrek_judul'];
			
				$m2[4]['TEXT'] = format_currency($v['spt_dt_pajak']);
			
				
				$counter ++;
			}	
			
		} else {
			foreach ($ar_rekam_setor as $k => $v) {
				$total_pajak += $v['spt_dt_pajak'];
				$masa_pajak = $v['spt_periode_jual1'];
				$arr_masa_pajak = explode("-", $masa_pajak);
				$m2[0]['TEXT'] = "";
				$m2[1]['TEXT'] = "" . $counter;
				$m2[2]['TEXT'] = "" . $v['koderek_detail'];
				$m2[3]['TEXT'] = "" . $v['korek_nama_detail']."   -   ".getNamaBulan($arr_masa_pajak[1])." ".$arr_masa_pajak[0]; 			
				$m2[4]['TEXT'] = "" .format_currency($v['spt_dt_pajak']);
			
				
				$counter ++;
			}	
		}
		
		if ($denda > 0) {
			$m2[0]['TEXT'] = "";
			$m2[1]['TEXT'] = "" . $counter;
			$m2[2]['TEXT'] = "" . $denda_kode_rekening;
			$m2[3]['TEXT'] = "" . $denda_nama_rekening; 			
			$m2[4]['TEXT'] = "" .format_currency($denda);
			
		}
		
		
		$m3[3]['TEXT'] = "Jumlah Setoran Pajak";
		$m3[4]['TEXT'] = " " . format_currency($total_pajak + $denda);
	
		
		for($f=0; $f<$klm; $f++) $hdr[$f] = $table_default_datax_type;

		
		for($g=0; $g<$klm; $g++) {
			$dt1[$g] = $table_default_datax_type;
			$dt2[$g] = $table_default_datax_type;
		}
		
		$dt1[0]['TEXT'] = "   Dengan huruf :";
		$dt1[1]['TEXT'] = "" . ucwords(strtolower(terbilang($total_pajak + $denda)). " Rupiah");
	
		
//		$pdf->tbOuputData();
		
		//Tanda Tangan
		$col = 3;
//		$pdf->tbInitialize($col, true, true);
//		$pdf->tbSetTableType($table_default_tbl_type);
		
		for($h=0; $h<$col; $h++) $head[$h] = $table_default_datax_type;
		
		$head[0]['WIDTH'] = 63;
		$head[1]['WIDTH'] = 64;
		$head[2]['WIDTH'] = 63;
		
//		$pdf->tbSetHeaderType($head);
		
		for($i=0; $i<$col; $i++) {
			$ket[$i] = $table_default_tblheader_type;
			$ttd[$i] = $table_default_ttd_type;
		}
		
		$ket[0]['TEXT'] = "";
		$ket[1]['TEXT'] = "";
		$ket[2]['TEXT'] = "";
		
		$ket[0]['BRD_TYPE'] = 'LT';
		$ket[1]['BRD_TYPE'] = 'LT';
		$ket[2]['BRD_TYPE'] = 'LRT';
//		$pdf->tbDrawData($ket);
		
		if (empty($cetak_tgl_setoran)) {
			$tgl_cetakan = "..................................";
			$ket[2]['T_ALIGN'] = 'L';
		} else {
			$tgl_cetakan = format_tgl($cetak_tgl_setoran,false,true);
			$ket[2]['T_ALIGN'] = 'C';
		}
		
		
		
		if(!empty($mengetahui['ref_japeda_nama'])) {
			$ket[1]['TEXT'] = "".$mengetahui['ref_japeda_nama'];
		}
		else {
			$ket[1]['TEXT'] = "Petugas Tempat Pembayaran";
		}
		
		
		if(!empty($teraan['pejda_nama'])) {
			$ttd[0]['TEXT'] = "<nu>      ".$teraan['pejda_nama']."      </nu>";
		}
		else {
			$ttd[0]['TEXT'] = "";
		}
		
		
		if(!empty($mengetahui['pejda_nama'])) {
			$ttd[1]['TEXT'] = "<nu>      ".$mengetahui['pejda_nama']."      </nu>";
		}
		else {
			$ttd[1]['TEXT'] = "";
		}
		if(!empty($penyetor)) {
			$ttd[2]['TEXT'] = "(  ".strtoupper($penyetor)."  )";
		}
		else {
			$ttd[2]['TEXT'] = "( ".$nama_wp." )";
		}
		
		if(!empty($teraan['pejda_nip'])) {
			$ttd[0]['TEXT'] = "NIP. ".$teraan['pejda_nip'];
		}
		else {
			$ttd[0]['TEXT'] = "";
		}
		
		if(!empty($mengetahui['pejda_nip'])) {
			$ttd[1]['TEXT'] = "NIP. ".$mengetahui['pejda_nip'];
		}
		else {
			$ttd[1]['TEXT'] = "";
		}
		

		?>
	
<html>
<head>
<title> SPT BILLING</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" type="images/x-icon" href="images/fav.ico" />
<script>
	function PrintPreview()
	{
	var OLECMDID = 7;
	/* OLECMDID values:
	* 6 - print
	* 7 - print preview
	* 1 - open window
	* 4 - Save As
	*/
	var PROMPT = 2; // 2 DONTPROMPTUSER
	var WebBrowser = <OBJECT ID=\"WebBrowser1\" WIDTH=1 HEIGHT=1 ORIENTATION=portrait CLASSID=\"CLSID:8856F961-340A-11D0-A96B-00C04FD705A2\"></OBJECT>
	document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
	WebBrowser1.ExecWB(OLECMDID, PROMPT);
	WebBrowser1.outerHTML = \"\";

	}
	
	function PrintAuto() {
	window.focus();
	window.print();
	window.close();
	}
	</script>
</head>

<body onLoad='window.print()'>

	<table border=0 style="width: 400px; font-family:">
	<tr>
	<td align="right" width="75"><img src="../../assets/images/bekasi-transparent.png" width="55" height="50"></td>
	<td valign="top" style="font-weight:bold; text-align:center;">
			<span style="font-size:12px; ">PEMERINTAH KOTA BEKASI</span> <br />
			<span style="font-size:10px; ">BADAN PENDAPATAN DAERAH</span> <br />
			<div style="font-size:8px; ">Jl. Ir. H.Juanda No. 100 <br />
			Telp. (021)88397963/64 Fax. (021)88397965</div>
			</td>
			<td width="100" valign="top"><img src="../../assets/logo-bank.jpg" width="90" height="50"></td>
			</tr>
		</table>
		<div style="width:400px; border-bottom:1px solid; "></div>
		
		
		<table border=0 style="width: 400px; font-size:10px;">
			<tr>
				<td style="width:100px; ">No. SPTPD</td><td colspan="2" width="300">: <?php echo  $ar_rekam_setor[0]['spt_nomor'];?></td>
			</tr>
			<tr>
			<td>WAJIB PAJAK</td><td colspan="2">: <?php echo $nama_wp;?></td>
			</tr>
			<tr>
				<td>NPWPD</td><td>: <?php echo $ar_rekam_setor[0][npwprd];?></td>
				<td rowspan="4" valign="top" style="width:150px; ">
				<table border=1 align="right" cellpadding="2" cellspacing="0">
				<tr><td align="center">KODE BILLING</td></tr>
				<tr><td style="width:120px; text-align:center; font-size:14px; font-weight:bold; "> <?php echo $ar_rekam_setor[0][spt_kode_billing];?></td></tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>JENIS PAJAK</td>
				<td>: <?php echo  $v['korek_nama_detail']."\n".$v['sptrek_judul'];?></td>
			</tr>
			<tr>
				<td>Masa Pajak</td>
				<td>: <?php echo getNamaBulan($arr_masa_pajak[1]);?> <?php echo $arr_masa_pajak[0];?></td>
			</tr>
			<tr>
				<td>JUMLAH</td><td>: Rp.  <?php echo format_currency($total_pajak + $denda); ?></td>
				
			</tr>
		</table>
	<table>
	<tr>
		<td style="font-size:8px; ">Tanggal Cetak :  <?php echo $tgl_cetakan;?></td>
	</tr>
	</table>	 
	<div style="font-size:8px; width:400px; font-weight:bold; ">** Keterlambatan Pembayaran melewati tanggal jatuh tempo akan dikenakan sanksi administrasi berupa bunga
	sebesar 2% (dua persen) setiap bulannya </div>
	<div>&nbsp;</div>
	<div style="font-weight:bold; text-align:center; width:400px; font-size:10px; ">"PAJAK ANDA MEMBANGUN KOTA BEKASI" <br />-- TERIMA KASIH --</div>
</div>
<br>
<br>
<br>
<br>
<br>
</body>
</html>	

<?php
		
	}	
}
/*
$html=ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output($nama_dokumen.".pdf", "I");
exit;
*/
?>