
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
                    </div>
                    <div class="header icon-48-user"> Cetak Laporan Realisasi Penerimaan Daerah</div>
                    <div class="clr"></div>
                </div>
		<div class="b"> <div class="b"> <div class="b"> </div> </div> </div>
            </div>
            <div class="clr"></div>
            <div id="element-box">
                <div class="t"> <div class="t"> <div class="t"> </div> </div> </div>
                <div class="m"  >

<form name="adminForm" >
                    <fieldset> <legend> Jenis Cetak Daftar </legend>
                    <table class="admintable" border=0 cellspacing="3">
                        <tr>
                            <td class="key" width="150">  Tanggal Proses  </td>
                            <td>
                                <input type="text" name="tanggal" id="f_date_c" size="11" value="<?= date('d-m-Y');?>" onchange="dateFormat(this);" tabindex="1"/><input type="hidden" name="tahun" id="tahun">
                            </td>
                        </tr>
                        <tr>
                            <td class="key" width="150">  Tanggal Cetak  </td>
                            <td>
                                <input type="text" name="tglcetak" id="f_date_a" size="11" value="<?= date('d-m-Y');?>" onchange="dateFormat(this);" tabindex="2"/><input type="hidden" name="tahun" id="tahun">
                            </td>
                        </tr>
                        <tr>
                            <td class="key">   Pejabat    </td>
                            <td>
								<?php
									$attributes = 'id="bendahara" name="bendahara"';
									echo form_dropdown('bendahara', $pejabat_daerah, '', $attributes);
								?>
                                <input type="button" name="jencet" value="Cetak" tabindex="4"/> </td>
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
		<div class="clr"></div>
	</div>

<script type="text/javascript" src="modules/pembukuan/scripts/form_realisasi_penerimaan_daerah.js"></script>