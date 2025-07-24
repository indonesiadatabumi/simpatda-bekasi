<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			Cetak Rekapitulasi Harian Bendahara Penerimaan
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
		
		$attributes = array('id' => 'frm_rekapitulasi');
		echo form_open('frm_rekapitulasi', $attributes);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top">
						<fieldset class="detailForm">
							<legend>Form Rekapitulasi</legend>
							<table class="admintable">
								<tr>
									<td class="key">
										Tanggal Penerimaan
									</td>
									<td>
										<input type="text" name="fDate" id="fDate" size="11" tabindex="1"/> 
									</td>
								</tr>								
								<tr>
									<td colspan="2" align="center">
										<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak Excel " class="button" />
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
	var GLOBAL_REKAPITULASI_VARS = new Array ();
	GLOBAL_REKAPITULASI_VARS["cetak"] = "<?=base_url();?>bkp/rekapitulasi/cetak_penerimaan";
</script>
<script type="text/javascript" src="modules/bkp/scripts/form_rekapitulasi_penerimaan.js"></script>