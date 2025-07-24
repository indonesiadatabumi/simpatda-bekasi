<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>
	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-ref">
						<a href="#" id="btn_view" class="toolbar">
							<span class="icon-32-ref" title="Lihat Data"></span>Lihat Data
						</a>
					</td>
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_batal">
						<span class="icon-32-delete" title="Pembatalan Setoran">
						</span>
						Pembatalan
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-setoran">
			 Rekam Setoran Pajak
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
		
		$attributes = array('id' => 'frm_setoran_pajak');
		echo form_open('frm_setoran_pajak', $attributes);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top">
						<fieldset class="detailForm">
							<legend>Form Rekam</legend>
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
							             		<td class="key" width="150">Tanggal Penyetoran</td>
							                    <td>
							                   		<input type="text" name="tanggal_setor" id="tanggal_setor" size="11" class="mandatory" />
							               		</td>
							              	</tr>
							              	<tr>
							              		<td class="key">Via Bayar</td>
							              		<td>
							              			<select name="via_bayar" id="via_bayar" class="inputbox mandatory" size="1">
														<!--<option value="1" selected="selected">BENDAHARA PENERIMAAN</option> -->
														<option value="2" >BANK</option>
													</select>	
							              		</td>
							              	</tr>									
										</table>
									</td>
									<td>
										<table>
											<tr>
												<td class="key">
													Periode SPT
												</td>
												<td>
													<input type="text" name="spt_periode" id="spt_periode" size="4" maxlength="4" class="mandatory" value="<?= date('Y');?>" style="font-weight: bold; font-size: 12px;" <?= $js; ?> >
												</td>
											</tr>								
											<tr>
												<td class="key">
													<label for="password">Nomor Kohir/SPT</label>
												</td>
												<td>
													<input type="text" name="spt_nomor" id="spt_nomor" class="inputbox mandatory" size="8" maxlength="20" <?= $js; ?> style="font-weight: bold; font-size: 14px;"/> 
													<input type="button" id="trigger_spt" size="2" class="button" value="..." >
												</td>
											</tr>
											<tr>
												<td class="key">
													<label for="password">Kode Ketetapan</label>
												</td>
												<td>
													<?php
														$attributes = 'id="setorpajret_jenis_ketetapan" class="inputbox mandatory" style="font-size: 12px;"';
														echo form_dropdown('setorpajret_jenis_ketetapan', $keterangan_spt, '8', $attributes);
													?>
												</td>
											</tr>
										</table>
									</td>	
									<td valign="top">
										<input type="button" id="btn_proses" name="btn_proses" title="Proses" class="button" value="Proses">&nbsp;
										<input type="button" id="btn_reset" name="btn_reset" title="Reset" class="button" value="Reset">
									</td>					
								</tr>
							</table>
						</fieldset>
					</td>
				</tr>
				
				<tr>
					<td>
						<div id="div_setoran">					
						</div>
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
	var GLOBAL_SETOR_PAJAK_VARS = new Array ();
	GLOBAL_SETOR_PAJAK_VARS["get_spt"] = "bkp/rekam_pajak/get_sspd";
	GLOBAL_SETOR_PAJAK_VARS["proses_setoran"] = "<?=base_url();?>bkp/rekam_pajak/proses_setoran";
	GLOBAL_SETOR_PAJAK_VARS["view_setoran"] = "<?=base_url();?>bkp/rekam_pajak/view_setoran";
	GLOBAL_SETOR_PAJAK_VARS["batal_setoran"] = "<?=base_url();?>bkp/setoran_batal/";
</script>
<script type="text/javascript" src="modules/bkp/scripts/form_rekam_setoran_pajak.js"></script>