<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>
	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" id="btn_update" class="toolbar">
						<span class="icon-32-save" title="Save"></span>Update
						</a>
					</td>
					<td class="button" id="toolbar-new">
						<a href="#" id="btn_add" class="toolbar">
						<span class="icon-32-new" title="Baru"></span>Baru
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
		<div class="header icon-48-setoran">
			 Rekam Setoran dari Dinas Lain <small><small id='title_head'>[ Edit ]</small></small>
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
		
		$attributes = array('id' => 'frm_setoran_dinas');
		$hidden = array('slh_id' => $header->slh_id);
		echo form_open('frm_setoran_dinas', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top">
						<table class="admintable">
							<tr>
								<td class="key">
									Periode
								</td>
								<td>
									<input type="text" name="spt_periode" id="spt_periode" size="4" maxlength="4" class="mandatory" value="<?= $header->slh_tahun;?>" style="font-weight: bold; font-size: 10px;" <?= $js; ?> >
								</td>
							</tr>
							<tr>
								<td class="key">
									 Kode Unit Kerja / Dinas
								</td>
								<td>
									<?php
										$attributes = 'id="ddl_dinas" class="inputbox mandatory" style="font-size: 11px;"';
										echo form_dropdown('ddl_dinas', $skpd, $header->slh_satuan_kerja, $attributes);
									?>
								</td>
							</tr>		
							<tr>
			             		<td class="key" width="150">Tanggal STS</td>
			                    <td>
			                   		<input type="text" name="tanggal_setor" id="tanggal_setor" size="11" value="<?= format_tgl($header->slh_tgl); ?>" class="mandatory" />
			               		</td>
			              	</tr>
			              	<tr>
			                  	<td width="10%" class="key">Dari</td>
			           			<td>
			           				<input type="text" name="txt_dari" id="txt_dari" value="<?= $header->slh_dari; ?>" size="60" class="inputbox mandatory" /> *	
			           			</td>
			           		</tr>			      
			           		<tr>
			                  	<td width="10%" class="key">Keterangan / Uraian</td>
			           			<td>
			           				<input type="text" name="txt_keterangan" id="txt_keterangan" value="<?= $header->slh_keterangan; ?>" class="inputbox" size="80"/>			
			           			</td>
			           		</tr>
			              	<tr>
			              		<td colspan="2" align="left">
			              			<fieldset class="adminform">
									<legend>DETAIL SETORAN DINAS LAIN-LAIN</legend>
			              				<table class="admintable" border=0 cellspacing="1">
										<tr>
										<td valign="top">
											<tr>
												<td>
													<div id="detailSelf">
														<table class="adminlist" cellspacing="1" id="detailTable" border="0">
															<thead>
																<tr>
																	<th class="title">Kode Rekening</th>
																	<th class="title">Nilai Penerimaan</th>
																	<th class="title" rowspan="2" width="40">-</th>
																</tr>											
															</thead>
															<tfoot>
																<tr>
																	<td colspan="3">
																	</td>
																</tr>
															</tfoot>
					
															<tbody id="tbody_detail">
																<?php 
																	if ($detail->num_rows() > 0) {
																		$counter = 0;
																		foreach ($detail->result() as $dt) {
																?>
																	<tr class="row0" id="row_detail<?=$counter?>">
																		<td>
																			<input type="hidden" name="sld_id[]" value="<?=$dt->sld_id;?>">
																			<select name="ddl_korek[]" id="ddl_korek<?=$counter?>" class="inputbox mandatory" onchange="hitungSetoran();"> 
																			<option value="">--</option>
																			<?php																				
																				foreach ($rekening['list'] as $rek) {
																					$key = $rek['key'];
																					$value = $rek['value'];
																					
																					$arr_rek = explode(",", $key);
																					if ($dt->sld_id_rekening == $arr_rek[0]) 
																						$selected = "selected";
																					else 
																						$selected = "";
																			?>
																				<option value="<?= $key ?>" <?= $selected; ?> ><?= $value; ?></option>
																			<?php
																				}
																			?>
																			</select>
																		</td>
																		<td>
																			<input type="text" name="txt_dt_setoran[]" id="txt_dt_setoran<?=$counter?>" value="<?=format_currency($dt->sld_jlh_setor)?>" 
																				class="inputbox mandatory" size="16" style="font-weight: bold; font-size: 10px; text-align:right;" 
																				onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" 
																				onKeypress = "return numbersonly(this, event)" />
																		</td>
																		<td>
																			<a href="#" onClick="removeFormField('#row_detail<?=$counter?>');hitungSetoran();return false;">Hapus</a>
																		</td>
																	</tr>												
																<?php 
																		$counter++;
																		}	
																	}
																?>
															</tbody>
														</table>
													</div>
												</td>
											</tr>
											<tr>
												<td align="center">
													<input type="BUTTON" value="TAMBAH DETAIL" id="btn_add_detail"> 
													&nbsp;&nbsp;&nbsp; TOTAL &nbsp;&nbsp;&nbsp; 
													<input type="text" name="txt_setoran" id="txt_setoran" class="inputbox" size="20" 
													value="<?= format_currency($header->slh_jumlah); ?>"  
													readonly="true"  style="font-weight:bold;font-size:25px;color:#18F518;background-color:black;text-align:right;"/>
												</td>
											</tr>
										</table>
			              			</fieldset>
			              		</td>
			              	</tr>
						</table>
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
	var GLOBAL_SETORAN_DINAS_VARS = new Array ();
	GLOBAL_SETORAN_DINAS_VARS["get_rekening"] = "<?=base_url();?>rekening/get_rekening_retribusi";
	GLOBAL_SETORAN_DINAS_VARS["update"] = "<?=base_url();?>bkp/setoran_dinas/update";
	GLOBAL_SETORAN_DINAS_VARS["add"] = "<?=base_url();?>bkp/setoran_dinas/";
	GLOBAL_SETORAN_DINAS_VARS["view"] = "<?=base_url();?>bkp/setoran_dinas/view";
</script>
<script type="text/javascript" src="modules/bkp/scripts/edit_setoran_dinas.js"></script>