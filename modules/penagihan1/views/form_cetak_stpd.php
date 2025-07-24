<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			CETAK STPD
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
		
		$attributes = array('id' => 'frm_penetapan_skpd');
		$hidden = array('mode' => 'add', 'jenis_ketetapan' => $this->config->item('status_stpd'));
		echo form_open('frm_penetapan_skpd', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td class="key">Periode</td>
					<td>
						<input type="text" name="periode" id="periode" class="inputbox mandatory" size="4" maxlength="4" value="<?=date('Y');?>" <?= $js; ?> />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">Jenis Pajak</label>
					</td>
					<td>									
						<?php
							$attributes = 'id="jenis_pajak" class="inputbox mandatory"';
							echo form_dropdown('jenis_pajak', $objek_pajak, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">Nomor STPD</label>
					</td>
					<td>
						<input type="text" name="stpd_nomor1" id="stpd_nomor1" class="inputbox mandatory" size="8"/> 
						<input type="button" id="trigger_spt1" size="2" value="..." class="button" >
						s/d
						<input type="text" name="stpd_nomor2" id="stpd_nomor2" class="inputbox mandatory" size="8"/> 
						<input type="button" id="trigger_spt2" size="2" value="..." class="button" >
					</td>
				</tr>
				<tr>
					<td class="key">Pejabat</td>
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
						<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak " class="button" />
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

<script type="text/javascript">
	var GLOBAL_KET_STPD_VARS = new Array ();
	GLOBAL_KET_STPD_VARS["get_spt"] = "penagihan/stpd/get_list_cetak_stpd";
	GLOBAL_KET_STPD_VARS["cetak"] = "<?=base_url();?>penagihan/stpd/pdf_stpd";
</script>
<script type="text/javascript" src="modules/penagihan/scripts/form_cetak_stpd.js"></script>