<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			Cetak BUKU Kas Umum (BK-11)
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
						<label for="password">Bulan Tahun</label>
					</td>
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
							$attributes = 'id="ddl_diperiksa" class="inputbox"';
							echo form_dropdown('ddl_diperiksa', $pejabat_daerah, '', $attributes);
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