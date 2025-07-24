			<div class="t"><div class="t"><div class="t"></div></div></div>
				<div class="m">
					<!-- content body -->
					<table class="admintable">
						<tr>
							<td valign="top" class="outsets" style="min-width: 75%">
								<div id="cpanel">
<?php
//Administrator
if(($this->session->userdata('USER_JABATAN') == '98') || ($this->session->userdata('USER_JABATAN') == '99')) {
?>
				<div style="float:left;">
			<div class="icon">
				<a href="pendaftaran/wp_pribadi">
					<img src="assets/images/khepri/header/icon-48-pend_p.png" alt="Pendaftaran WPWR Pribadi"  /><span>Pendaftaran WPWR Pribadi</span></a>
			</div>
		</div>
				<div style="float:left;">
			<div class="icon">
				<a href="pendaftaran/wp_badan_usaha">
					<img src="assets/images/khepri/header/icon-48-pend_bu.png" alt="Pendaftaran WPWR BU"  /><span>Pendaftaran WPWR BU</span></a>
			</div>
		</div>
				<div style="float:left;">
					<div class="icon">
						<a href="popup_pendataan/objek_pajak/popup_jenis_pajak" >
							<img src="assets/images/khepri/header/icon-48-menulist.png" alt="Pendataan SPT"  />
							<span>Pendataan SPT</span></a>
					</div>
				</div>

				<div style="float:left;">
			<div class="icon">
				<a href="pendataan/hasil_pemeriksaan">
					<img src="assets/images/khepri/header/icon-48-lhp.png" alt="LHP"  /><span>LHP</span></a>
			</div>
		</div>

				<div style="float:left;">
			<div class="icon">
				<a href="penetapan/skpd">
					<img src="assets/images/khepri/header/icon-48-penetapan.png" alt="Penetapan Pajak"  />
					<span>Penetapan Pajak</span>
				</a>
			</div>
		</div>
				<div style="float:left;">
			<div class="icon">
				<a href="penagihan/stpd/add">
					<img src="assets/images/khepri/header/icon-48-penetapan_stprd.png" alt="Penetapan STPD"  />
					<span>Penagihan STPD</span>
				</a>
			</div>
		</div>

		<div style="float:left;">
			<div class="icon">
				<a href="bkp/rekam_pajak/setor_pajak">
					<img src="assets/images/khepri/header/icon-48-setoran.png" alt="Penerimaan(Setoran)"  />
					<span>Penerimaan(Setoran)</span>
				</a>
			</div>
		</div>
				<div style="float:left;">
			<div class="icon">
				<a href="bkp/setor_bank">
					<img src="assets/images/khepri/header/icon-48-setoran_bank.png" alt="Setoran ke Bank"  />
					<span>Setoran ke Bank</span>
				</a>
			</div>
		</div>
		<!--
				<div style="float:left;">
			<div class="icon">
				<a>
					<img src="assets/images/khepri/header/icon-48-bb_persediaan.png" alt="Global Configuration"  />
					<span>Persediaan Awal Benda Berharga</span>
				</a>
			</div>
		</div>

				<div style="float:left;">
			<div class="icon">

				<a>
					<img src="assets/images/khepri/header/icon-48-bb_surat.png" alt="User Manager"  />					<span>Surat Permintaan Benda Berharga</span></a>
			</div>
		</div>

				<div style="float:left;">
			<div class="icon">

				<a>
					<img src="assets/images/khepri/header/icon-48-bb_order.png" alt="User Manager"  />					<span>Order Benda Berharga</span></a>
			</div>
		</div>


				<div style="float:left;">
			<div class="icon">

				<a href="<?= $myself.$XFA['dsp_tanda_terima_benda_berharga']; ?>">
					<img src="assets/images/khepri/header/icon-48-bb_terima.png" alt="User Manager"  />					<span>Tanda Terima Benda Berharga</span></a>
			</div>
		</div>

				<div style="float:left;">
			<div class="icon">

				<a>
					<img src="assets/images/khepri/header/icon-48-bb_bukti.png" alt="User Manager"  />					<span>Bukti Pengeluaran Benda Berharga</span></a>
			</div>
		</div>

				<div style="float:left;">
			<div class="icon">

				<a>
					<img src="assets/images/khepri/header/icon-48-bb_setor.png" alt="User Manager"  />					<span>Setoran Benda Berharga</span></a>
			</div>
		</div>
		-->
<?php } 
//Operator Pajak Hotel
elseif($this->session->userdata('USER_JABATAN') == '1') {
?>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/pajak_hotel/add" >
				<img src="assets/images/khepri/header/icon-48-hotel.png" alt="Pendataan Objek Pajak Hotel"  />
				<span>Rekam Data Objek Pajak Hotel</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/kartu_data/pajak_hotel">
				<img src="assets/images/khepri/header/icon-48-printkardat.png" alt="Cetak Kartu Data"  />
				<span>Cetak Kartu Data</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/skpd">
				<img src="assets/images/khepri/header/icon-48-penetapan.png" alt="Penetapan SPT Hotel"  />
				<span>Penetapan SPT Hotel</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/nota_perhitungan">
				<img src="assets/images/khepri/header/icon-48-printnota.png" alt="Cetak Nota Perhitungan"  />
				<span>Cetak Nota Perhitungan</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/surat_ketetapan">
				<img src="assets/images/khepri/header/icon-48-printskp.png" alt="Cetak Surat Ketetapan"  />
				<span>Cetak<br />Surat Ketetapan</span>
			</a>
		</div>
	</div>
<?php
}
//Operator Pajak Restoran
elseif($this->session->userdata('USER_JABATAN') == '2') {
?>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/pajak_restoran/add">
				<img src="assets/images/khepri/header/icon-48-restoran.png" alt="Pendataan Objek Pajak Restoran"  />
				<span>Rekam Data Objek Pajak Restoran</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/kartu_data/pajak_restoran">
				<img src="assets/images/khepri/header/icon-48-printkardat.png" alt="Cetak Kartu Data"  />
				<span>Cetak Kartu Data</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/skpd">
				<img src="assets/images/khepri/header/icon-48-penetapan.png" alt="Penetapan SPT Restoran"  />
				<span>Penetapan SPT Restoran</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/nota_perhitungan">
				<img src="assets/images/khepri/header/icon-48-printnota.png" alt="Cetak Nota Perhitungan"  />
				<span>Cetak Nota Perhitungan</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/surat_ketetapan">
				<img src="assets/images/khepri/header/icon-48-printskp.png" alt="Cetak Surat Ketetapan"  />
				<span>Cetak<br />Surat Ketetapan</span>
			</a>
		</div>
	</div>
<?php
}
//Operator Pajak Hiburan
elseif($this->session->userdata('USER_JABATAN') == '3') {
?>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/pajak_hiburan/add">
				<img src="assets/images/khepri/header/icon-48-hiburan.png" alt="Pendataan Objek Pajak Hiburan"  />
				<span>Rekam Data Objek Pajak Hiburan</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/kartu_data/pajak_hiburan">
				<img src="assets/images/khepri/header/icon-48-printkardat.png" alt="Cetak Kartu Data"  />
				<span>Cetak Kartu Data</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/skpd">
				<img src="assets/images/khepri/header/icon-48-penetapan.png" alt="Penetapan SPT Restoran"  />
				<span>Penetapan SPT Restoran</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/nota_perhitungan">
				<img src="assets/images/khepri/header/icon-48-printnota.png" alt="Cetak Nota Perhitungan"  />
				<span>Cetak Nota Perhitungan</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/surat_ketetapan">
				<img src="assets/images/khepri/header/icon-48-printskp.png" alt="Cetak Surat Ketetapan"  />
				<span>Cetak<br />Surat Ketetapan</span>
			</a>
		</div>
	</div>
<?php
}
//Operator Pajak Reklame
elseif($this->session->userdata('USER_JABATAN') == '4') {
?>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/pajak_reklame/add">
				<img src="assets/images/khepri/header/icon-48-reklame.png" alt="Pendataan Objek Pajak Reklame"  />
				<span>Rekam Data Objek Pajak Reklame</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/kartu_data/pajak_reklame">
				<img src="assets/images/khepri/header/icon-48-printkardat.png" alt="Cetak Kartu Data"  />
				<span>Cetak Kartu Data</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/skpd">
				<img src="assets/images/khepri/header/icon-48-penetapan.png" alt="Penetapan SPT Reklame"  />
				<span>Penetapan SPT Reklame</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/nota_perhitungan">
				<img src="assets/images/khepri/header/icon-48-printnota.png" alt="Cetak Nota Perhitungan"  />
				<span>Cetak Nota Perhitungan</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/surat_ketetapan">
				<img src="assets/images/khepri/header/icon-48-printskp.png" alt="Cetak Surat Ketetapan"  />
				<span>Cetak<br />Surat Ketetapan</span>
			</a>
		</div>
	</div>
<?php
}
//Operator Pajak Penerangan Jalan / Genset
elseif($this->session->userdata('USER_JABATAN') == '5') {
?>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/pajak_genset/add">
				<img src="assets/images/khepri/header/icon-48-electric.png" alt="Pendataan Objek PPJ / Genset"  />
				<span>Rekam Data Objek PPJ / Genset</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/kartu_data/pajak_genset">
				<img src="assets/images/khepri/header/icon-48-printkardat.png" alt="Cetak Kartu Data"  />
				<span>Cetak Kartu Data</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/skpd">
				<img src="assets/images/khepri/header/icon-48-penetapan.png" alt="Penetapan SPT PPJ / Genset"  />
				<span>Penetapan SPT PPJ / Genset</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/nota_perhitungan">
				<img src="assets/images/khepri/header/icon-48-printnota.png" alt="Cetak Nota Perhitungan"  />
				<span>Cetak Nota Perhitungan</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/surat_ketetapan">
				<img src="assets/images/khepri/header/icon-48-printskp.png" alt="Cetak Surat Ketetapan"  />
				<span>Cetak<br />Surat Ketetapan</span>
			</a>
		</div>
	</div>
<?php
}
//Operator Pajak Parkir
elseif($this->session->userdata('USER_JABATAN') == '7') {
?>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/pajak_parkir/add">
				<img src="assets/images/khepri/header/icon-48-parkir.png" alt="Pendataan Objek Pajak Parkir"  />
				<span>Rekam Data Objek Pajak Parkir</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/kartu_data/pajak_parkir">
				<img src="assets/images/khepri/header/icon-48-printkardat.png" alt="Cetak Kartu Data"  />
				<span>Cetak Kartu Data</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/skpd">
				<img src="assets/images/khepri/header/icon-48-penetapan.png" alt="Penetapan SPT Pajak Parkir"  />
				<span>Penetapan SPT Pajak Parkir</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/nota_perhitungan">
				<img src="assets/images/khepri/header/icon-48-printnota.png" alt="Cetak Nota Perhitungan"  />
				<span>Cetak Nota Perhitungan</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/surat_ketetapan">
				<img src="assets/images/khepri/header/icon-48-printskp.png" alt="Cetak Surat Ketetapan"  />
				<span>Cetak<br />Surat Ketetapan</span>
			</a>
		</div>
	</div>
<?php
}
//Operator Pajak ABT
elseif($this->session->userdata('USER_JABATAN') == '8') {
?>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/pajak_air_bawah_tanah/add">
				<img src="assets/images/khepri/header/icon-48-user.png" alt="Pendataan Objek Pajak Bawah Air Tanah"  />
				<span>Rekam Data Objek Air Bawah Tanah</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="pendataan/kartu_data/pajak_air_bawah_tanah">
				<img src="assets/images/khepri/header/icon-48-printkardat.png" alt="Cetak Kartu Data"  />
				<span>Cetak Kartu Data</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/skpd">
				<img src="assets/images/khepri/header/icon-48-penetapan.png" alt="Penetapan SPT Pajak Air Bawah Tanah"  />
				<span>Penetapan SPT Air Bawah Tanah</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/nota_perhitungan">
				<img src="assets/images/khepri/header/icon-48-printnota.png" alt="Cetak Nota Perhitungan"  />
				<span>Cetak Nota Perhitungan</span>
			</a>
		</div>
	</div>
	<div style="float:left;">
		<div class="icon">
			<a href="penetapan/surat_ketetapan">
				<img src="assets/images/khepri/header/icon-48-printskp.png" alt="Cetak Surat Ketetapan"  />
				<span>Cetak<br />Surat Ketetapan</span>
			</a>
		</div>
	</div>
<?php
}
// admin operator
else if($this->session->userdata('USER_JABATAN') == '10') {
?>
		<div style="float:left;">
			<div class="icon">
				<a href="pendaftaran/master_wp">
					<img src="assets/images/khepri/header/icon-48-pend_bu.png" alt="Data WP"  /><span>Data Wajib Pajak</span></a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_hotel/add" >
					<img src="assets/images/khepri/header/icon-48-hotel.png" alt="Pendataan Objek Pajak Hotel"  />
					<span>Rekam Data Objek Pajak Hotel</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_restoran/add">
					<img src="assets/images/khepri/header/icon-48-restoran.png" alt="Pendataan Objek Pajak Restoran"  />
					<span>Rekam Data Objek Pajak Restoran</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_hiburan/add">
					<img src="assets/images/khepri/header/icon-48-hiburan.png" alt="Pendataan Objek Pajak Hiburan"  />
					<span>Rekam Data Objek Pajak Hiburan</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_reklame/add">
					<img src="assets/images/khepri/header/icon-48-reklame.png" alt="Pendataan Objek Pajak Reklame"  />
					<span>Rekam Data Objek Pajak Reklame</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_genset/add">
					<img src="assets/images/khepri/header/icon-48-electric.png" alt="Pendataan Objek PPJ / Genset"  />
					<span>Rekam Data Objek PPJ / Genset</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_parkir/add">
					<img src="assets/images/khepri/header/icon-48-parkir.png" alt="Pendataan Objek Pajak Parkir"  />
					<span>Rekam Data Objek Pajak Parkir</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_air_bawah_tanah/add">
					<img src="assets/images/khepri/header/icon-48-user.png" alt="Pendataan Objek Pajak Air Bawah Tanah"  />
					<span>Rekam Data Objek Air Bawah Tanah</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="bkp/rekam_pajak/cetak_sspd">
					<img src="assets/images/khepri/header/icon-48-setoran.png" alt="Cetak SSPD"  />
					<span>Cetak SSPD</span>
				</a>
			</div>
		</div>
<?php 
} 
// Operator Bendahara
elseif($this->session->userdata('USER_JABATAN') == '21') {
?>
	<div style="float:left;">
		<div class="icon">
			<a href="bkp/rekam_pajak/setor_pajak">
				<img src="assets/images/khepri/header/icon-48-setoran.png" alt="Penerimaan Setoran"  />
				<span>Penerimaan(Setoran)</span></a>
		</div>
	</div>
			<div style="float:left;">
		<div class="icon">

			<a href="bkp/setor_bank">
				<img src="assets/images/khepri/header/icon-48-setoran_bank.png" alt="Setoran Bank"  />
				<span>Setoran ke Bank</span></a>
		</div>
	</div>
<?php
}
// Operator Pembukuan
elseif($this->session->userdata('USER_JABATAN') == '22') {
?>

<?php
}
if(
	($this->session->userdata('USER_JABATAN') == '31') || ($this->session->userdata('USER_JABATAN') == '32') || ($this->session->userdata('USER_JABATAN') == '33') ||
	($this->session->userdata('USER_JABATAN') == '34') || ($this->session->userdata('USER_JABATAN') == '35') || ($this->session->userdata('USER_JABATAN') == '36') ||
	($this->session->userdata('USER_JABATAN') == '37') || ($this->session->userdata('USER_JABATAN') == '38') || ($this->session->userdata('USER_JABATAN') == '39') ||
	($this->session->userdata('USER_JABATAN') == '40') || ($this->session->userdata('USER_JABATAN') == '41') || ($this->session->userdata('USER_JABATAN') == '42')
) {
?>
		<div style="float:left;">
			<div class="icon">
				<a href="pendaftaran/master_wp">
					<img src="assets/images/khepri/header/icon-48-pend_bu.png" alt="Data WP"  /><span>Data Wajib Pajak</span></a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_hotel/add" >
					<img src="assets/images/khepri/header/icon-48-hotel.png" alt="Pendataan Objek Pajak Hotel"  />
					<span>Rekam Data Objek Pajak Hotel</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_restoran/add">
					<img src="assets/images/khepri/header/icon-48-restoran.png" alt="Pendataan Objek Pajak Restoran"  />
					<span>Rekam Data Objek Pajak Restoran</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_hiburan/add">
					<img src="assets/images/khepri/header/icon-48-hiburan.png" alt="Pendataan Objek Pajak Hiburan"  />
					<span>Rekam Data Objek Pajak Hiburan</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_reklame/add">
					<img src="assets/images/khepri/header/icon-48-reklame.png" alt="Pendataan Objek Pajak Reklame"  />
					<span>Rekam Data Objek Pajak Reklame</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_genset/add">
					<img src="assets/images/khepri/header/icon-48-electric.png" alt="Pendataan Objek PPJ / Genset"  />
					<span>Rekam Data Objek PPJ / Genset</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_parkir/add">
					<img src="assets/images/khepri/header/icon-48-parkir.png" alt="Pendataan Objek Pajak Parkir"  />
					<span>Rekam Data Objek Pajak Parkir</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="pendataan/pajak_air_bawah_tanah/add">
					<img src="assets/images/khepri/header/icon-48-user.png" alt="Pendataan Objek Pajak Air Bawah Tanah"  />
					<span>Rekam Data Objek Air Bawah Tanah</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="penetapan/skpd_reklame">
					<img src="assets/images/khepri/header/icon-48-penetapan.png" alt="Penetapan SPT Reklame"  />
					<span>Penetapan SPT Reklame</span>
				</a>
			</div>
		</div>
		<div style="float:left;">
			<div class="icon">
				<a href="bkp/rekam_pajak/cetak_sspd">
					<img src="assets/images/khepri/header/icon-48-setoran.png" alt="Cetak SSPD"  />
					<span>Cetak SSPD</span>
				</a>
			</div>
		</div>
<?php 
} 
?>
		</div>
							</td>
							<td valign="top">
							<span style="color:#0057BF;font-weight:bold;text-decoration:underline;">DETAIL ANDA :</span><br />
							<table style="border:solid 2px #7DAF57;background-color:#DAFFBF;">
								<tr>
									<td class="key">Kode Operator</td>
									<td><?php echo strtoupper($this->session->userdata('USER_OPR_CODE'));?></td>
								</tr>
								<tr>
									<td class="key">Nama Lengkap</td>
									<td><?php echo strtoupper($this->session->userdata('USER_FULL_NAME'));?></td>
								</tr>
								<tr>
									<td class="key">NIP</td>
									<td><?php echo strtoupper($this->session->userdata('USER_NIP'));?></td>
								</tr>
								<tr>
									<td class="key">Jabatan</td>
									<td><?php echo strtoupper($this->session->userdata('USER_JABATAN_NAME'));?></td>
								</tr>
								<tr>
									<td class="key">Login terakhir</td>
									<td><?=$this->session->userdata('USER_LOGIN_TIME')?></td>
								</tr>
							</table>
							</td>
						</tr>
					</table>
					<div class="clr"></div>
				</div>
				<div class="b"><div class="b"><div class="b"></div></div></div>
			</div>
<div style="margin-left:15px; margin-right:30px; "><marquee scrolldelay="200" style="color:#FF0000; font-size:800; font-weight:bold;" onmouseover="this.stop();" onmouseout="this.start();"> >> PENYALAHGUNAAN USER MENJADI TANGGUNGJAWAB PEMILIK USER, UNTUK KEAMANAN GANTI PASSWORD SECARA BERKALA!!! << </marquee></div>
<script type="text/javascript" src="<?=base_url();?>/assets/scripts/private/home.js"></script>