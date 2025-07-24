<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			Cetak  BPPS
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
		
		$attributes = array('id' => 'frm_bpps');
		echo form_open('frm_bpps', $attributes);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top">
						<fieldset class="detailForm">
							<legend>Form BPPS</legend>
							<table class="admintable">
								<tr>
									<td class="key">
										Tanggal Penerimaan
									</td>
									<td>
										<input type="text" name="fDate" id="fDate" size="11" tabindex="1"/> 										
										S/D <input type="text" name="tDate" id="tDate" size="11" tabindex="2"/>
									</td>
								</tr>
								<tr>
									<td class="key">Kode  Rekening</td>
									<td>
										<input type="hidden" name="spt_kode_rek" id="spt_kode_rek">
										<input type="text" name="korek" id="korek" class="inputbox rekening" value="" size="5" />
										<input type="button" id="trigger_rek" size="2" value="..." class="button" >
									</td>
								</tr>
								<tr>
									<td width="150" class="key">
										<label for="name">Nama  Rekening</label>
									</td>
									<td>
										<input type="text" name="korek_nama" id="korek_nama" class="mandatory" size="40" readonly="true" >
									</td>
								</tr>
								<tr>
									<td class="key">
										<label for="password">BPPS Via :</label>
									</td>
									<td>
										<select name="via" id="via" class="inputbox" size="1" tabindex="4">
											<option value="" selected="selected">-- Pilih --</option>
											<option value="1" >BENDAHARA PENERIMAAN</option>
											<option value="2" >BANK</option>
										</select>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type="button" name="btn_bpps" id="btn_bpps" value=" Cetak " class="button" /> &nbsp;&nbsp;
										<input type="button" name="btn_reset" id="btn_reset" value=" Reset " class="button" />
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
	var GLOBAL_BPPS_VARS = new Array ();
	GLOBAL_BPPS_VARS["cetak_bpps"] = "<?=base_url();?>bkp/bpps/bpps_pdf";
</script>
<script type="text/javascript" src="modules/bkp/scripts/form_bpps.js"></script>