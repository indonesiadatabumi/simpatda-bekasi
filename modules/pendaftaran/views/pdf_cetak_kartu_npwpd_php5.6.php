<?php 

$strlen_nama = strlen(str_replace("\\", "", $wp->wp_wr_nama));

if ($strlen_nama > 35)
	$nama = substr(str_replace("\\", "", $wp->wp_wr_nama), 0, 35);
else 
	$nama = str_replace("\\", "", $wp->wp_wr_nama);

$html = '
	<style>
		table { border-collapse: collapse; }
		.kota {font-size: 12;font-weight:bold;padding:0;}
		.dispenda {font-size: 14;font-weight:bold;padding:0;}
		.kartu {font-size: 11;font-weight:bold;padding:0;}
		.garis {border-top: 1.2 solid #000; width: 240;}
		.register {font-size: 8;font-weight:normal;padding:0; text-align:center;}
		.ttd {font-size: 9;font-weight:normal;padding:0; text-align:center;}
		.garis_kecil {border-bottom: 0.8 solid #000;}
	</style>
	<table style=\'font-family:Arial, Verdana; padding: 0; font-size: 10;font-weight:bold;\' cellspacing="1">
		<tr>
			<td valign="top" width="50">
				<img style="vertical-align: top" src="assets/images/logo-kotabekasi.jpg" width="58" height="60" />
			</td>
			<td>
				<table style="text-align: center; padding: 0;border-collapse: collapse;">
					<tr>
						<td class="kota">PEMERINTAH KOTA BEKASI</td>
					</tr>
					<tr>
						<td class="dispenda">BADAN PENDAPATAN DAERAH</td>
					</tr>
					<tr>
						<td class="kartu">KARTU N P W P D</td>
					</tr>
					<tr>
						<td class="garis"></td>
					</tr>
					<tr>
						<td class="register">No. Reg :'.$wp->wp_wr_no_urut.'</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table cellspacing="1" style="width: 300;border-collapse: collapse;">
					<tr>
						<td width="50" valign="top">NAMA</td>
						<td width="10" valign="top">:</td>
						<td>'.$nama.'</td>
					</tr>
	
	';

if (strlen($wp->wp_wr_almt) > 35) {
	$html .= '<tr>
				<td valign="top">ALAMAT</td>
				<td valign="top">:</td>
				<td>'.$wp->wp_wr_almt." KEC.".$wp->wp_wr_camat.'</td>
			</tr>';	
} else {
	$html .= '<tr>
				<td>ALAMAT</td>
				<td>:</td>
				<td>'.$wp->wp_wr_almt.'</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>KEC. '.$wp->wp_wr_camat.'</td>
			</tr>';	
}

$html .= '<tr>
			<td>NPWPD</td>
			<td>:</td>
			<td>'.$wp->npwprd.'</td>
		</tr>
		</table></td></tr>';

$arr_tgl_daftar = explode('-', $wp->wp_wr_tgl_kartu);
$html.= '
		<tr>
			<td colspan="2">
				<table cellspacing="1" style="border-collapse: collapse;">
					<tr>
						<td width="140"></td>
						<td class="register">
							Bekasi, '.$arr_tgl_daftar[2]." ".getNamaBulan($arr_tgl_daftar[1])." ".$arr_tgl_daftar[0].'<br/>
							a.n Walikota Bekasi <br/>
							Kepala Badan Pendapatan Daerah<br/><br/><br/><br/><br/>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<div style="position: absolute; top: 40mm; left: 42mm;">
								<img style="WIDTH:105px; HEIGHT:26px;" opacity="0.9" src="assets/images/TTD KABAN baru.jpg">
							</div>														
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="center"><span class="ttd garis_kecil">'.$pejabat->pejda_nama.'</span></td>
					</tr>
					<tr>
						<td></td>
						<td class="register">'.$pejabat->ref_pangpej_ket.', '.$pejabat->ref_goru_ket.'</td>
					</tr>
					<tr>
						<td></td>
						<td class="register">NIP. '.$pejabat->pejda_nip.'</td>
					</tr>
				</table>
			</td>			
		</tr>
		';

$html .= "</table>";

//cetak pdf
require_once APPPATH.'libraries/mpdf/mpdf.php';

$mpdf=new mPDF('','', 0, '', 3, 3, 1, 1, 0, 0, 'P');

//$mpdf->SetWatermarkImage(base_url().'assets/images/logo-bekasi-bg.jpg', 0.3, array(34, 35), array(28,10));
//$mpdf->showWatermarkImage = true;
$mpdf->WriteHTML($html);

$mpdf->SetAlpha(0.4); 
$mpdf->WriteFixedPosHTML('<img src="assets/images/stempel bapenda.jpg" />', 40, 36, 15, 14, 'auto');

$mpdf->AddPage();

$html2 = "<br/><table style='margin-top: 15; font-family:Arial, Verdana; padding: 0; font-size: 10;font-weight:bold;width:300;text-align:justify;' >
			<tr>
				<td colspan='3' align='center' style='font-size: 12;'>PERHATIAN</td><br/><br/>
			</tr>
			<tr>
				<td valign='top' width='15'>1.</td>
				<td width='5'></td>
				<td>
					Kartu ini harap disimpan baik-baik dan apabila hilang agar segera melaporkan ke Badan Pendapatan Daerah
				</td>
			</tr>
			<tr>
				<td valign='top'>2.</td>
				<td width='5'></td>
				<td>
					Kartu ini hendaknya dibawa apabila saudara akan membayar pajak, melakukan transaksi dan berhubungan dengan instansi-instansi
				</td>
			</tr>
			<tr>
				<td valign='top'>3.</td>
				<td width='5'></td>
				<td>
					Dalam hal wajib pajak pindah domisili, supaya melaporkan ke Badan Pendapatan Daerah Kota Bekasi
				</td>
			</tr>
		</table>";
$mpdf->WriteHTML($html2);

$mpdf->Output();
exit;

?>