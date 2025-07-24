<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			Cetak Daftar Kartu Data
		</div>
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
		<div class="t"><div class="t"></div></div>
	</div>
	<div class="m">
		<form name="frm_daftar_kartu_data" id="frm_daftar_kartu_data">
			<table class="admintable">
				<tr>
					<td class="key">
						Periode SPT
					</td>
					<td>
						<input type="text" name="spt_periode" id="spt_periode" size="4" maxlength="4" class="mandatory" value="<?= date('Y');?>" onKeypress = "return numbersonly(this, event)">
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">Jenis Pajak</label>
					</td>
					<td>									
						<?php
							$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory"';
							echo form_dropdown('spt_jenis_pajakretribusi', $objek_pajak, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Tanggal Pendataan</label>
					</td>
					<td>
						<input type="text" name="tgl_pendataan" id="tgl_pendataan" size="11" />
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Cetak Daftar</label>
					</td>
					<td>
						<input type="checkbox" name="daftar" id="daftar" value="0">Silahkan cek jika hanya data yang dicetak hanya dari <b>dinas</b>.
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Tanggal Cetak</label>
					</td>
					<td>
						<input type="text" name="tgl_cetak" id="tgl_cetak" size="11" />
					</td>
				</tr>
				<tr>
					<td class="key">Cetak Penandatangan</td>
					<td>
						<input type="checkbox" name="tandatangan" id="tandatangan" value="1" checked> Pilih jika diikutsertakan dalam cetakan.
					</td>
				</tr>
				<tr>
					<td class="key">Mengetahui</td>
					<td>
						<?php
							$attributes = 'id="ddl_mengetahui" class="inputbox"';
							echo form_dropdown('ddl_mengetahui', $pejabat_daerah, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key">Diperiksa oleh</td>
					<td>
						<?php
							$attributes = 'id="ddl_pemeriksa" class="inputbox"';
							echo form_dropdown('ddl_pemeriksa', $pejabat_daerah, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak " class="button" />
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_KARTU_DATA_VARS = new Array ();
	GLOBAL_KARTU_DATA_VARS["cetak_daftar"] = "<?=base_url();?>pendataan/kartu_data/pdf_daftar_kartu_data";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/daftar_kartu_data.js"></script>