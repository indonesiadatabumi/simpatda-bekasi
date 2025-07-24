<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>
	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_back">
						<span class="icon-32-back" title="Kembali">
						</span>
						Kembali
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-setoran">
			 Pembatalan Setoran
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
		
		$attributes = array('id' => 'frm_batal_setoran');
		echo form_open('frm_batal_setoran', $attributes);
		?>
		<div class="col">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top">
						<table class="admintable">
							<tr>
								<td>
									<table>
										<tr>
											<td class="key">
												<label for="password">Jenis Pajak</label>
											</td>
											<td>									
												<?php
													$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory" style="font-size: 12px;"';
													echo form_dropdown('spt_jenis_pajakretribusi', $objek_pajak, '', $attributes);
												?>
											</td>
										</tr>
										<tr>
											<td class="key">
												Periode SPT
											</td>
											<td>
												<input type="text" name="spt_periode" id="spt_periode" size="4" maxlength="4" class="mandatory" value="<?= date('Y');?>" style="font-weight: bold; font-size: 12px;" <?= $js; ?> >
											</td>
										</tr>								
									</table>
								</td>
								<td>
									<table>																			
										<tr>
											<td class="key">
												<label for="password">Nomor Kohir/SPT</label>
											</td>
											<td>
												<input type="text" name="spt_nomor" id="spt_nomor" class="inputbox mandatory" size="8" maxlength="20" <?= $js; ?> style="font-weight: bold; font-size: 14px;"/> 
											</td>
										</tr>
										<tr>
											<td class="key">
												<label for="password">Kode Ketetapan</label>
											</td>
											<td>
												<?php
													$attributes = 'id="setorpajret_jenis_ketetapan" class="inputbox mandatory" style="font-size: 12px;"';
													echo form_dropdown('setorpajret_jenis_ketetapan', $keterangan_spt, '', $attributes);
												?>
											</td>
										</tr>
									</table>
								</td>	
								<td class="button" id="toolbar-new" valign="top">
									<input type="button" id="btn_batal" name="btn_batal" value="Batal">&nbsp;
									<input type="button" id="btn_reset" name="btn_reset" value="Reset">
								</td>					
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			<table>
				<tr>
					<td>						
						<table id="setoran_batal_table" style="display:none"></table>
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
	var GLOBAL_BATAL_SETORAN_VARS = new Array ();
	GLOBAL_BATAL_SETORAN_VARS["get_list"] = "bkp/setoran_batal/get_list";
	GLOBAL_BATAL_SETORAN_VARS["insert"] = "<?=base_url();?>bkp/setoran_batal/insert";
	GLOBAL_BATAL_SETORAN_VARS["back"] = "bkp/rekam_pajak/setor_pajak";
</script>
<script type="text/javascript" src="modules/bkp/scripts/form_batal_setoran.js"></script>