<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			Cetak Daftar SPTPD Self Assesment
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
					<td width="150" class="key">
						<label for="name">Obyek Pajak</label>
					</td>
					<td>
						<?php
							$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory"';
							echo form_dropdown('spt_jenis_pajakretribusi', $objek_pajak, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key" width="150">Sistem Pemunggutan</td>
					<td>
                    	<select name="sistem_pemunggutan" id="sistem_pemunggutan">
                        	<option value="1">Self Assesment</option>                               
                      	</select>
                  	</td>
				</tr>
				<tr>
					<td class="key" width="150">Kecamatan</td>
					<td>
						<?php
							$attributes = 'id="kecamatan" class="inputbox"';
							echo form_dropdown('kecamatan', $kecamatan, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td width="150" class="key">Masa Pajak</td>
					<td>
						<?php
							$attributes = 'id="masa_pajak" class="inputbox"';
							echo form_dropdown('masa_pajak', get_month(), date('n')-1, $attributes);
						?>
						Tahun 
						<input type="text" name="spt_periode" id="spt_periode" class="inputbox" size="4" maxlength="4" value="<?= date('Y') ?>" tabindex="3" />
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Tanggal Entry Pendataan</label>
					</td>
					<td>
						<input type="text" name="tgl_entry" id="tgl_entry" size="11" />
					</td>
				</tr>
				<!-- 
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
				 -->
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
	var GLOBAL_SPTPD_VARS = new Array ();
	GLOBAL_SPTPD_VARS["cetak"] = "<?=base_url();?>pendataan/sptpd/cetak_sptpd";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/form_sptpd.js"></script>