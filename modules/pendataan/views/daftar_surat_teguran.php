<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			CETAK DAFTAR SURAT TEGURAN
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
							$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory"';
							echo form_dropdown('spt_jenis_pajakretribusi', $jenis_pajak, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td width="150" class="key">Masa Pajak</td>
					<td>
						<?php
							$attributes = 'id="bulan" class="inputbox"';
							echo form_dropdown('bulan', get_month(), '', $attributes);
						?>
						Tahun 
						<input type="text" name="tahun" id="tahun" class="inputbox" size="4" maxlength="4" value="<?= date('Y') ?>" tabindex="3" />
					</td>
				</tr>
				<tr>
					<td class="key">Kecamatan</td>
					<td>
						<?php
							$attributes = 'id="wp_wr_kd_camat" class="inputbox mandatory"';
							echo form_dropdown('wp_wr_kd_camat', $kecamatan, '', $attributes);
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
						<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak " />
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
	var GLOBAL_DAFTAR_SURAT_TEGURAN_VARS = new Array ();
	GLOBAL_DAFTAR_SURAT_TEGURAN_VARS["cetak"] = "<?=base_url();?>pendataan/surat_teguran/pdf_daftar_surat_teguran";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/daftar_surat_teguran.js"></script>