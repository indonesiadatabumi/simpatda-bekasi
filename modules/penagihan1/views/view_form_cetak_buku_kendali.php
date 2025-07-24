<?php
/*
$xajax->printJavascript('scripts/'); 
if (!empty($attributes[idedit])) {
$now_date = "";
$nextweek = "";
}
*/
?>
				<div id="toolbar-box">
   			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
				<div class="toolbar" id="toolbar">
				<table class="toolbar"><tr></tr></table>
				</div>
				<div class="header icon-48-print">Cetak Buku Kendali:</div>
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
  		</div>
   		<div class="clr"></div>
		<div id="element-box">
			<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
			</div>
			<div class="m">
<form action="<?//php echo $myself.$XFA['dsp_cetak_buku_kendali']; ?>" method="post" name="adminForm" id="adminForm">
	<div class="col width-51">
		<fieldset class="adminform">
		<legend>FORM BUKU KENDALI OFFICIAL ASSESMENT</legend>

			<table class="admintable" border=0 cellspacing="1">
			<tr><TD valign="top">
			<table class="admintable" border=0 cellspacing="1">

				<tr>
					<td class="key" width="100">
						<label for="password">Tanggal Cetak</label>
					</td>
					<td>
						<input type="text" name="tanggal" id="f_date_c" size="10" value="<?= date('d-m-Y'); ?>" maxlength="10" onchange="dateFormat(this);" tabindex="1"/>
					</td>
				</tr>
				<tr>
					<td class="key" width="100">
						<label for="password">Masa Pajak</label>
					</td>
					<td>
						<input type="text" name="masa1" id="f_date_a" size="11" value="" <?php //echo $dis; ?> onchange="dateFormat(this);" tabindex="2"/>
					&nbsp; S/D &nbsp;
						<input type="text" name="masa2" id="f_date_b" size="11" value="" <?php //echo $dis; ?> onchange="dateFormat(this);" tabindex="3"/>
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Nomor  Rekening</label>
					</td>
					<td>
						<input type="hidden" name="spt_kode_rek" id="spt_kode_rek" value="<?//=$ar_edit_data[spt_kode_rek];?>">
						<input type="text" name="korek" id="korek" class="inputbox" size="5" maxlength="5" value="<?//= $ar_edit_data[koderek]; ?>" onchange="submitSignup('chosen_korek');" onkeypress="submitSignup('chosen_korek');" tabindex="4"/>
						Jenis
						<input type="text" name="korek_rincian" id="korek_rincian" class="inputbox" size="2" maxlength="2" value="<?//= $ar_edit_data[korek_rincian]; ?>" onchange="submitSignup('chosen_korek');" onkeypress="submitSignup('chosen_korek');" tabindex="5"/>
						Klas
						<input type="text" name="korek_sub1" id="korek_sub1" class="inputbox" size="2" maxlength="2" value="<?//= $ar_edit_data[korek_sub1]; ?>" onchange="submitSignup('chosen_korek');" onkeypress="submitSignup('chosen_korek');" tabindex="6"/>
						<input type="button" id="trigger_rek" size="2" value="...">
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">Nama  Rekening</label>
					</td>
					<td>
						<input type="text" name="korek_nama" id="korek_nama" class="inputbox" size="40" value="<?//= $ar_edit_data[korek_nama]; ?>" readonly="true" />
					</td>
				</tr>
				<tr>
					<td class="key">
						Status SPT
					</td>
					<td>
						<?php
							$attributes = 'id="status_spt" name="status_spt"';
							echo form_dropdown('status_spt', $keterangan_spt, '', $attributes);
						?>
						</select> &nbsp;

					</td>
				</tr>
				<tr>
					<td class="key">Kode Kecamatan</td>
					<td>
						<?php
							$attributes = 'id="camat_id" name="camat_id"';
							echo form_dropdown('camat_id', $kecamatan, '', $attributes);
						?>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="key">Nama Petugas</td>
					<td>
						<input type="text" name="opr_nama" id="opr_nama" class="inputbox" size="30" value="<?//=$ar_operator['opr_nama']?>" readonly="true"/>
					</td>
				</tr>
				<tr>
					<td class="key">Jabatan</td>
					<td>
						<input type="text" name="ref_jab_nama" id="ref_jab_nama" class="inputbox" size="30" value="<?//=$ar_operator['ref_jab_nama']?>" readonly="true"/>
					</td>
				</tr>
				<tr>
					<td class="key">NIP</td>
					<td>
						<input type="text" name="opr_nip" id="opr_nip" class="inputbox" size="30" value="<?//=format_nip ($ar_operator['opr_nip'])?>" readonly="true"/>
					</td>
				</tr>
				<tr>
					<td class="key">Menyetujui</td>
					<td>
						<?php
							$attributes = 'id="menyetujui" name="menyetujui"';
							echo form_dropdown('menyetujui', $pejabat, '', $attributes);
						?>						
					</td>
				</tr>
				<tr>
					<td class="key">Mengetahui</td>
					<td>
						<?php
							$attributes = 'id="mengetahui" name="mengetahui"';
							echo form_dropdown('mengetahui', $pejabat, '', $attributes);
						?>												
					</td>
				</tr>
				<tr>
					<td class="key">Diperiksa Oleh</td>
					<td>
						<?php
							$attributes = 'id="pemeriksa" name="pemeriksa"';
							echo form_dropdown('pemeriksa', $pejabat, '', $attributes);
						?>																		
						<input type="submit" name="cetak" value="Cetak" tabindex="12">
						<input type="submit" name="cetak" value="Cetak per WP/WR">
				</tr>
			</table>
			</TD>
			</tr>
			</table>
		</fieldset>
	</div>
	<div class="clr"></div>

	<input type="hidden" name="cid[]" value="" />
	<input type="hidden" name="spt_jenis_pemungutan" value="" />
	<input type="hidden" name="wp_wr_nama" value="" />
	<input type="hidden" name="wp_wr_almt" value="" />
	<input type="hidden" name="wp_wr_lurah" value="" />
	<input type="hidden" name="wp_wr_camat" value="" />
	<input type="hidden" name="wp_wr_kabupaten" value="" />

	<input type="hidden" name="jepem" value="<?//= $attributes[jepem]; ?>" />

	<input type="hidden" name="form" value="sptprd" />
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="spt_id" id="spt_id" value="<?//= $ar_edit_data[spt_id]; ?>" />
	<input type="hidden" name="operator" value="<?//= $staff_id; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="contact_id" value="" />
		<input type="hidden" name="4e5df0df35b0914f3fbb6b63af22c21d" value="1" /></form>
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>

				</div>
			</div>
   		</div>
		<noscript>
			Warning! JavaScript must be enabled for proper operation of the Administrator Back-end </noscript>
		<div class="clr"></div>
	</div>

<div id="border-bottom"><div><div></div></div></div>

<script type="text/javascript" src="modules/penagihan/scripts/form_cetak_buku_kendali.js"></script>