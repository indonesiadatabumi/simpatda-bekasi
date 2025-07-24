<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			LAPORAN PENERIMAAN BENDAHARA
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
		<span id="callData"></span>
		<?php
		$js = 'onKeypress = "return numbersonly(this, event)"';
		
		$attributes = array('id' => 'frm_laporan_penerimaan');
		$hidden = array('mode' => 'add');
		echo form_open('frm_laporan_penerimaan', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td class="key">
						Tanggal Penerimaan
					</td>
					<td>
						<input type="text" name="fDate" id="fDate" size="11" /> 										
						S/D <input type="text" name="tDate" id="tDate" size="11" />
					</td>
				</tr>
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
					<td class="key">Kecamatan</td>
					<td>
						<?php
							$attributes = 'id="camat_id" class="inputbox mandatory"';
							echo form_dropdown('camat_id', $kecamatan, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key">Tanggal Cetak</td>
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
					<td class="key">Bendahara</td>
					<td>
						<?php
							$attributes = 'id="ddl_bendahara" class="inputbox"';
							echo form_dropdown('ddl_bendahara', $pejabat_daerah, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak " class="button" />&nbsp;&nbsp;
						<input type="button" name="btn_reset" id="btn_reset" value=" Reset " class="button" />
					</td>
				</tr>
			</table>
		</div>
		
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>
<script type="text/javascript" src="modules/bkp/scripts/form_laporan_penerimaan.js"></script>