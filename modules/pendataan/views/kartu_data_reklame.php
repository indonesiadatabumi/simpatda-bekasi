<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			Cetak Kartu Data Pajak Reklame
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
		<form name="frm_kartu_data_restoran" id="frm_kartu_data_restoran">
			<input type="hidden" name="kodus_id" value="<?= $this->config->item('kodus_reklame'); ?>">
			<table class="admintable">
				<tr>
					<td class="key">Periode</td>
					<td>
						<input type="text" name="period" id="period" class="inputbox" size="4" maxlength="4" value="<?= date('Y'); ?>" onKeypress = "return numbersonly(this, event)"/>
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
						<input type="submit" name="pdf" id="pdf" value=" Cetak " />
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

<script type="text/javascript" src="modules/pendataan/scripts/kartu_data_reklame.js"></script>