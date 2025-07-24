<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			CETAK SURAT TEGURAN LAPORAN
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
							$attributes = 'id="masa_pajak" class="inputbox"';
							echo form_dropdown('masa_pajak', get_month(), '', $attributes);
						?>
						<label class="key">Tahun</label> 
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
					<td class="key">N.P.W.P.D</td>
					<td>
						<input type="hidden" name="wp_wr_id" id="wp_wr_id">
						<input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="inputbox mandatory" size="1" maxlength="1" value="P" readonly="true"/>
						<input type="text" name="wp_wr_golongan" id="wp_wr_golongan" class="inputbox npwpd mandatory" size="1" maxlength="1" readonly="true" />
						<input type="text" name="wp_wr_jenis_pajak" id="wp_wr_jenis_pajak" class="inputbox npwpd mandatory" size="2" maxlength="2" readonly="true" />
						<input type="text" name="wp_wr_no_registrasi" id="wp_wr_no_registrasi" class="inputbox npwpd mandatory" size="7" maxlength="7" readonly="true" />
						<input type="text" name="wp_wr_kode_camat" id="wp_wr_kode_camat" class="inputbox npwpd mandatory" size="2" maxlength="2" readonly="true" />
						<input type="text" name="wp_wr_kode_lurah" id="wp_wr_kode_lurah" class="inputbox npwpd mandatory" size="2" maxlength="2" readonly="true" />
						<input type="button" id="btn_npwpd" size="2" value="...">
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Tanggal Cetak</label>
					</td>
					<td>
						<input type="text" name="tgl_cetak" class="mandatory" id="tgl_cetak" size="11" />
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
					<td class="key">Diperiksa Oleh</td>
					<td>
						<?php
							$attributes = 'id="ddl_diperiksa" class="inputbox"';
							echo form_dropdown('ddl_diperiksa', $pejabat_daerah, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						 
						&nbsp;&nbsp;&nbsp;
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
	var GLOBAL_SURAT_TEGURAN_VARS = new Array ();
	GLOBAL_SURAT_TEGURAN_VARS["cetak"] = "<?=base_url();?>penagihan/surat_teguran_laporan/pdf_surat_teguran_laporan";
	GLOBAL_SURAT_TEGURAN_VARS["daftar"] = "<?=base_url();?>penagihan/surat_teguran_laporan/pdf_daftar_surat_teguran_laporan";
</script>
<script type="text/javascript" src="modules/penagihan/scripts/surat_teguran_laporan.js"></script>