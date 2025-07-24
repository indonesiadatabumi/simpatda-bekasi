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
			Form Penetapan LHP: <small><small id='title_head'>[ Baru ]</small></small>
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
		
		$attributes = array('id' => 'frm_penetapan_lhp');
		$hidden = array('mode' => 'add');
		echo form_open('frm_penetapan_lhp', $attributes, $hidden);
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
										Tahun
									</td>
									<td>
										<input type="text" name="tahun" id="tahun" size="4" maxlength="4" class="mandatory" value="<?= date('Y');?>" <?= $js; ?> >
									</td>
								</tr>
								<tr>
									<td width="150" class="key">
										<label for="name">NPWPD</label>
									</td>
									<td>
										<input type="hidden" name="wp_wr_id" id="wp_wr_id">
										<input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="inputbox mandatory" size="1" maxlength="1" value="P" readonly="true"/>
										<input type="text" name="wp_wr_golongan" id="wp_wr_golongan" class="inputbox mandatory" size="1" maxlength="1" readonly="true" />
										<input type="text" name="wp_wr_jenis_pajak" id="wp_wr_jenis_pajak" class="inputbox mandatory" size="2" maxlength="2" readonly="true" />
										<input type="text" name="wp_wr_no_registrasi" id="wp_wr_no_registrasi" class="inputbox mandatory" size="7" maxlength="7" readonly="true" />
										<input type="text" name="wp_wr_kode_camat" id="wp_wr_kode_camat" class="inputbox mandatory" size="2" maxlength="2" readonly="true" />
										<input type="text" name="wp_wr_kode_lurah" id="wp_wr_kode_lurah" class="inputbox mandatory" size="2" maxlength="2" readonly="true" />
										<input type="button" id="btn_npwpd" size="2" value="..." class="button">
									</td>
								</tr>
								<tr>
									<td class="key">
										<label for="password">Tanggal Penetapan</label>
									</td>
									<td>
										<input type="text" name="netapajrek_tgl" id="netapajrek_tgl" class="mandatory" size="11" />
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
	var GLOBAL_FORM_LHP_VARS = new Array ();
	GLOBAL_FORM_LHP_VARS["get_wp"] = "penetapan/lhp/get_wp";
	GLOBAL_FORM_LHP_VARS["insert"] = "<?=base_url();?>penetapan/lhp/insert";
	GLOBAL_FORM_LHP_VARS["view"] = "<?=base_url();?>penetapan/lhp/view";
</script>
<script type="text/javascript" src="modules/penetapan/scripts/form_lhp.js"></script>	