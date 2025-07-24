<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			CETAK DAFTAR STPD
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
		<form name="frm_daftar_surat_teguran" id="frm_daftar_surat_teguran">
			<table class="admintable">
				<tr>
					<td class="key">
						<label for="password">Jenis Pajak</label>
					</td>
					<td>									
						<?php
							$attributes = 'id="jenis_pajak" class="inputbox mandatory"';
							echo form_dropdown('jenis_pajak', $jenis_pajak, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td width="150" class="key">Realisasi</td>
					<td>
						<b>Tahun</b>
						<?php
							$attributes = 'id="tahun" class="inputbox"';
							echo form_dropdown('tahun', $tahun, '', $attributes);
						?>
						&nbsp;&nbsp;&nbsp;
						<b>Bulan</b>
						<?php
							$attributes = 'id="bulan" class="inputbox"';
							echo form_dropdown('bulan', get_month(), date('n')-1, $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key">Kecamatan</td>
					<td>
						<?php
							$attributes = 'id="camat_id" class="inputbox mandatory"';
							echo form_dropdown('camat_id', $kecamatan, '', $attributes);
						?>
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
					<td width="150" class="key">
						<label for="name">Tanggal Cetak</label>
					</td>
					<td>
						<input type="text" name="tgl_cetak" id="tgl_cetak" size="11" />
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
<script type="text/javascript" src="modules/penagihan/scripts/form_cetak_daftar_stpd.js"></script>