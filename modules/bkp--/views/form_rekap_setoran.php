<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-user">
			 Cetak REKAP DAFTAR KETETAPAN DAN SETORAN 
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
		
		$attributes = array('id' => 'frm_rekap_setoran');
		echo form_open('frm_rekap_setoran', $attributes);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td class="key" width="150">Periode</td>
                  	<td>
                    	<input type="text" name="periode" id="periode" size="4" value="<?=date("Y");?>" <?= $js;?> tabindex="1"/>
                   	</td>
              	</tr>
               	<tr>
					<td class="key">Jenis Obyek Pajak</td>
					<td>
						<?php
							$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory"';
							echo form_dropdown('spt_jenis_pajakretribusi', $objek_pajak, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
             		<td class="key" width="150">Tanggal Proses</td>
                    <td>
                   		<input type="text" name="tglproses" id="f_date_a" size="11" value="<?= date('d-m-Y');?>" />
               		</td>
              	</tr>
              	<tr>
             		<td class="key" width="150">Tanggal Cetak</td>
                    <td>
                   		<input type="text" name="tglproses" id="f_date_a" size="11" value="<?= date('d-m-Y');?>" />
               		</td>
              	</tr>
              	<tr>
             		<td class="key" width="150">Cetak Penandatangan</td>
                    <td>
                   		<input type="checkbox" name="tandatangan" value="1" checked> Pilih jika diikutsertakan dalam cetakan.
               		</td>
              	</tr>
              	<tr>
					<td class="key">Mengetahui</td>
					<td>
						<?php
							$attributes = 'id="mengetahui" class="inputbox"';
							echo form_dropdown('mengetahui', $pejabat_daerah, '', $attributes);
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
					<td class="key">Baris Spasi</td>
					<td>
						<select name="linespace" id="linespace" tabindex="4"> 
                      		<option value="3.5">3.5</option>
                            <option value="4">4.0</option>
                            <option value="4.5" selected>4.5</option>
                            <option value="5">5.0</option>
                            <option value="5.5">5.5</option>
                            <option value="6">6.0</option>
                            <option value="6.5">6.5</option>
                      	</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="pdf" id="pdf" value=" Cetak " />
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