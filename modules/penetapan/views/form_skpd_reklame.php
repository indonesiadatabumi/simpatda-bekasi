<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" id="btn_save" class="toolbar">
						<span class="icon-32-save" title="Tetapkan"></span>
						Tetapkan
						</a>
					</td>
					<td class="button" id="toolbar-ref">
						<a href="#" id="btn_view" class="toolbar">
							<span class="icon-32-ref" title="Lihat Data"></span>Lihat Data
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-penetapan">
			Form Penetapan Reklame: <small><small id='title_head'>[ Baru ]</small></small>
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
		
		$attributes = array('id' => 'frm_penetapan_skpd_reklame');
		$hidden = array('mode' => 'add', 'spt_jenis_pajakretribusi' => $this->config->item('jenis_pajak_reklame'));
		echo form_open('frm_penetapan_skpd_reklame', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top">
						<fieldset class="detailForm">
							<legend>Form Penetapan</legend>
							<table class="admintable">
								<tr>
									<td class="key">
										Periode SPT
									</td>
									<td>
										<input type="text" name="spt_periode" id="spt_periode" size="4" maxlength="4" tabindex="1" class="mandatory" value="<?= date('Y');?>" <?= $js; ?> >
									</td>
								</tr>
								<tr>
									<td class="key">
										<label for="password">Dari Nomor SPT</label>
									</td>
									<td>
										<input type="text" name="spt_nomor1" id="spt_nomor1" tabindex="2" class="inputbox mandatory" size="8"/> 
										<input type="button" id="trigger_spt1" size="2" value="..." >
										s/d Nomor SPT
										<input type="text" name="spt_nomor2" id="spt_nomor2" tabindex="3" class="inputbox mandatory" size="8"/> 
										<input type="button" id="trigger_spt2" size="2" value="..." >
									</td>
								</tr>
								<tr>
									<td class="key">
										<label for="password">Tanggal Penetapan</label>
									</td>
									<td>
										<input type="text" name="netapajrek_tgl" id="netapajrek_tgl" tabindex="4" class="mandatory" size="11" />
									</td>
								</tr>
							</table>
						</fieldset>
					</td>
				</tr>
			</table>
		</div>
		<?=form_close();?>
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_FORM_SKPD_REKLAME_VARS = new Array ();
	GLOBAL_FORM_SKPD_REKLAME_VARS["get_spt"] = "penetapan/skpd/get_spt";
	GLOBAL_FORM_SKPD_REKLAME_VARS["insert_skpd"] = "<?=base_url();?>penetapan/skpd/insert";
	GLOBAL_FORM_SKPD_REKLAME_VARS["view_skpd"] = "<?=base_url();?>penetapan/skpd/view";
</script>
<script type="text/javascript" src="modules/penetapan/scripts/form_skpd_reklame.js"></script>