<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			NOTA PERHITUNGAN PAJAK
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
		
		$attributes = array('id' => 'frm_nota_perhitungan');
		$hidden = array('mode' => 'add');
		echo form_open('frm_nota_perhitungan', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td class="key">Tahun Pajak</td>
					<td>
						<input type="text" name="spt_periode" id="spt_periode" class="inputbox" size="4" maxlength="4" value="<?=date('Y')?>"/>
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Jenis Ketetapan</label>
					</td>
					<td>
						<?php 
							$attributes = 'id="spt_jenis_ketetapan" class="inputbox mandatory"';
							echo form_dropdown('spt_jenis_ketetapan', $jenis_ketetapan, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Jenis Pajak</label>
					</td>
					<td>
						<?php
							$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory"';
							echo form_dropdown('spt_jenis_pajakretribusi', $objek_pajak, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Nomor Kohir</label>
					</td>
					<td>
						<input type="text" name="spt_nomor1" id="spt_nomor1" class="inputbox mandatory" size="8"/> 
						<input type="button" id="trigger_spt1" size="2" value="..." class="button" >
						s/d
						<input type="text" name="spt_nomor2" id="spt_nomor2" class="inputbox mandatory" size="8"/> 
						<input type="button" id="trigger_spt2" size="2" value="..." class="button" >
					</td>
				</tr>
				<tr>
					<td class="key">Mengetahui</td>
					<td>
						<?php
							$attributes = 'id="ddl_mengetahui" class="inputbox"';
							echo form_dropdown('ddl_mengetahui', $pejabat_daerah, $this->config->item('default_mengetahui'), $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key">Diperiksa oleh</td>
					<td>
						<?php
							$attributes = 'id="ddl_pemeriksa" class="inputbox"';
							echo form_dropdown('ddl_pemeriksa', $pejabat_daerah, $this->config->item('default_diperiksa'), $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak " class="button" />
					</td>
				</tr>
			</table>
		</div>
		<div class="clr"></div>
		<?=form_close();?>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_NOTA_VARS = new Array ();
	GLOBAL_NOTA_VARS["get_spt"] = "penetapan/nota_perhitungan/get_spt";
	GLOBAL_NOTA_VARS["cetak"] = "<?=base_url();?>penetapan/nota_perhitungan/cetak_nota";
</script>
<script type="text/javascript" src="modules/penetapan/scripts/form_nota_perhitungan.js"></script>