<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			Cetak Daftar WP/WR Non Aktif
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
				<td class="key">Tgl. Non Aktif</td>
				<td>
					<input type="text" id="fDate" name="fDate" size="10" />
					s / d
					<input type="text" id="tDate" name="tDate" size="10" />
				</td>
			</tr>
			<tr>
				<td class="key" id="namabidus">Jenis Pajak</td>
				<td id="pilihbidus">
					<?php
						$attributes = 'id="bidus" class="inputbox"';
						echo form_dropdown('bidus', $bidang_usaha, '', $attributes);
					?>
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
                	<td class="key">   Baris Spasi    </td> 
                    <td>
                    	<select name="linespace" id="linespace" tabindex="4"> 
                        	<option value="3.5">3.5</option>
                            <option value="4">4.0</option>
                            <option value="4.5" selected>4.5</option>
                            <option value="5">5.0</option>
                            <option value="5.5">5.5</option>
                            <option value="6">6.0</option>
                            <option value="6.5">6.5</option>
                            <option value="7">7</option>
                            <option value="7.5">7.5</option>
                        </select>
                        </select>
                	</td>
            	</tr>
			<tr>
				<td class="key" valign="top">Tgl. Cetak</td>
				<td>
					<input type="text" name="tgl_cetak" id="tgl_cetak" tabindex="4" size="10" value="<?= date('d-m-Y'); ?>"/>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="button" name="btn_cetak" id="btn_cetak" value="  Cetak PDF " class="button" />
					&nbsp;&nbsp;&nbsp;
					<input type="button" name="btn_cetak_excel" id="btn_cetak_excel" value="  Cetak Excel " class="button" />
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
	var GLOBAL_WP_NONAKTIF_VARS = new Array ();
	GLOBAL_WP_NONAKTIF_VARS["cetak"] = "<?=base_url();?>pendaftaran/dokumentasi_pengolahan/export_wp_nonaktif";
	GLOBAL_WP_NONAKTIF_VARS["cetak_excel"] = "<?=base_url();?>pendaftaran/dokumentasi_pengolahan/export_excel_wp_nonaktif";
</script>
<script type="text/javascript" src="modules/pendaftaran/scripts/form_daftar_wpwr_nonaktif.js"></script>