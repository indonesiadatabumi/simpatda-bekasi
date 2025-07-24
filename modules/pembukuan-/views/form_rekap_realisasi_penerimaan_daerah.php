
<!--
      REalisasi HANYA menghitung pada tahun realisasi d buat
      Bila wajib pajak mwlakukan pembayaran VIA bank, 
	    maka otomatis dhitung utk penerimaan bendahara, 
	    dan penyetoran bendahara k bank.
      SEilisih merupakan perbedaan antara penerimaan dan penyetoran bendahara ke bank
-->
            <div id="toolbar-box">
   		<div class="t"> <div class="t"> <div class="t"> </div>	</div> </div>
                <div class="m">
                    <div class="toolbar" id="toolbar">
<?php
//if (!empty($attributes['jencet'])) {
?>
                        <table class="toolbar">
                            <tr>
                                <td class="button" id="toolbar-cancel">
                                    <a href="#" onclick="javascript: history.go(-1);" class="toolbar">
                                        <span class="icon-32-cancel" title="Close">
                                        </span>
                                        Kembali
                                    </a>
                                </td>
                            </tr>
                        </table>
<?php
//}
?>
                    </div>
                    <div class="header icon-48-user"> Cetak Laporan Rekap Realisasi Penerimaan Daerah</div>
                    <div class="clr"></div>
                </div>
		<div class="b"> <div class="b"> <div class="b"> </div> </div> </div>
            </div>
            <div class="clr"></div>
            <div id="element-box">
                <div class="t"> <div class="t"> <div class="t"> </div> </div> </div>
                <div class="m"  >

<form action="<?//=$myself.$XFA['dsp_cetak_rekap_realisasi_penerimaan_daerah'];?>" method="post" name="adminForm" >
                    <fieldset> <legend> Jenis Cetak Daftar </legend>
                    <table class="admintable" border=0 cellspacing="3">
                        <tr>
                            <td class="key" width="150">  Tanggal Proses  </td>
                            <td>
								<input type="hidden" name="rekap" value="1">
                                <input type="text" name="tanggal" id="f_date_c" size="11" value="<?= date('d-m-Y');?>" onchange="dateFormat(this);" tabindex="1" /><input type="hidden" name="tahun" id="tahun">
                            </td>
                        </tr>
                        <tr>
                            <td class="key" width="150">  Tanggal Cetak  </td>
                            <td>
                                <input type="text" name="tglcetak" id="f_date_a" size="11" value="<?= date('d-m-Y');?>" onchange="dateFormat(this);" tabindex="2" /><input type="hidden" name="tahun" id="tahun">
                            </td>
                        </tr>
                        <tr>
                            <td class="key">   Bendahara    </td>
                            <td>
								<?php
									$attributes = 'id="bendahara" name="bendahara"';
									echo form_dropdown('bendahara', $pejabat_daerah, '', $attributes);
								?>
                            </td>
                        </tr>
                        <tr>
                            <td>
							</td>
                            <td>
								<input type="button" name="jencet" value="   Cetak Versi I  " onclick="klik(1);" tabindex="4"/>
								<input type="button" name="jencet" value="   Cetak Versi II  " onclick="klik(2);"/>
								<input type="hidden" name="versi" value="">
							</td>
                        </tr>
                    </table>
                    </fieldset>
</form>
		<div class="clr"></div>
		</div>
		<div class="b"><div class="b"><div class="b"></div>
		</div>
		</div>
   		</div>
		<noscript>
			Warning! JavaScript must be enabled for proper operation of the Administrator Back-end </noscript>
		<div class="clr"></div>
	</div>

<script type="text/javascript" src="modules/pembukuan/scripts/form_rekap_realisasi_penerimaan_daerah.js"></script>