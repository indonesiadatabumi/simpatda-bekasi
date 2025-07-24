<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			Cetak Realisasi Penerimaan Setoran Pendapatan Daerah
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
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td class="key">
						<label for="password">Obyek Pajak</label>
					</td>
					<td>									
						<?php
							$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory"';
							echo form_dropdown('spt_jenis_pajakretribusi', $objek_pajak, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">Kecamatan</label>
					</td>
					<td>									
						<?php
							$attributes = 'id="kecamatan" class="inputbox mandatory"';
							echo form_dropdown('kecamatan', $kecamatan, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">Kategori</label>
					</td>
					<td>									
						<input type="radio" name="kategori" value="harian"> Harian <input type="radio" name="kategori" value="bulanan" checked> Bulanan 
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">Tanggal Proses</label>
					</td>
					<td>
						<input type="text" name="tgl_proses" id="tgl_proses" class="inputbox" size="10" maxlength="12" tabindex="3" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">Tanggal Cetak</label>
					</td>
					<td>
						<input type="text" name="tgl_cetak" id="tgl_cetak" class="inputbox" size="10" maxlength="12" tabindex="3" />
					</td>
				</tr>
				<tr>
					<td class="key">Bendahara</td>
					<td>
						<?php
							$attributes = 'id="ddl_mengetahui" class="inputbox"';
							echo form_dropdown('ddl_mengetahui', $pejabat_daerah, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak "/>
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