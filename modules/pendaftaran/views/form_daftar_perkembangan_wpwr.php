<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			Cetak Daftar Perkembangan WP/WR
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
		<!-- content body -->
		<form name="adminForm" id="adminForm">
		<table class="admintable">
			<tr>
				<td class="key">Jenis Pajak</td>
				<td>
					<?php
						$attributes = 'id="bidus" class="inputbox"';
						echo form_dropdown('bidus', $bidang_usaha, '', $attributes);
					?>
				</td>
			</tr>
			<tr>
				<td class="key">Tgl. Terdaftar</td>
				<td>
					<input type="text" id="fDate" name="fDate" size="10" />
					s / d
					<input type="text" id="tDate" name="tDate" size="10" />
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
				<td class="key" valign="top">Tgl. Cetak</td>
				<td>
					<input type="text" name="tgl_cetak" id="tgl_cetak" tabindex="5" size="10" />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak " class="button" />
					&nbsp;&nbsp;
				<!--	<input type="button" name="btn_cetak_lama" id="btn_cetak_lama" value=" Cetak Versi Lama " class="button" /> -->
				</td>
			</tr>
		</table>
		</form>
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_WP_PERKEMBANGAN_VARS = new Array ();
	GLOBAL_WP_PERKEMBANGAN_VARS["cetak"] = "<?=base_url();?>pendaftaran/dokumentasi_pengolahan/pdf_perkembangan_wp";
	GLOBAL_WP_PERKEMBANGAN_VARS["cetak_lama"] = "<?=base_url();?>pendaftaran/dokumentasi_pengolahan/pdf_perkembangan_lama";
</script>
<script type="text/javascript" src="modules/pendaftaran/scripts/form_daftar_perkembangan_wpwr.js"></script>