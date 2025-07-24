<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<?php 
						if (($row->netapajrek_id == "") && 
							(($this->session->userdata('USER_SPT_CODE') == $row->spt_kode) || ($this->session->userdata('USER_JABATAN') == "98"))) {
					?>
					<td class="button" id="toolbar-new">
						<a href="#" id="btn_update" class="toolbar">
						<span class="icon-32-save" title="Save"></span>Update
						</a>
					</td>
					<?php 
						}
					?>
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_close">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-reklame">
			Isian SKPD Pajak Reklame: <small><small id='title_head'>[ Edit ]</small></small>
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
		
		$attributes = array('id' => 'frm_edit_reklame');
		$hidden = array(
							'mode' => 'edit', 
							'spt_jenis_pajakretribusi' => $this->config->item('jenis_pajak_reklame'), 
							'kodus_id' => $this->config->item('kodus_reklame'), 
							'korek' => $this->config->item('korek_reklame'), 
							'wp_rek_id' => $row->spt_idwpwr,
							'spt_id' => $row->spt_id,
					);
		echo form_open(base_url().'pendataan/pajak_reklame/update', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top" class="outsets">
						<table class="admintable">
							<tr>
								<td class="key"><label for="name">No. Reg Form</label></td>
								<td>
									<input type="text" name="spt_no_register" id="spt_no_register" value="<?= $row->spt_nomor; ?>" class="inputbox mandatory" <?= $js; ?> readonly="true" size="10" maxlength="8" /> 
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="password">Tanggal Proses</label>
								</td>
								<td>
									<input type="text" name="spt_tgl_proses" id="spt_tgl_proses" class="inputbox mandatory" value="<?= format_tgl($row->spt_tgl_proses); ?>" size="11" />
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="password">Tanggal Entry</label>
								</td>
								<td>
									<input type="text" name="spt_tgl_entry" id="spt_tgl_entry" class="inputbox mandatory" value="<?= format_tgl($row->spt_tgl_entry); ?>" size="11" />
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="password">Periode SPT</label>
								</td>
								<td>
									<input type="text" name="spt_periode" id="spt_periode" class="inputbox" value="<?= $row->spt_periode;?>" size="4" maxlength="4" value="<?= date('Y');?>" />
								</td>
							</tr>
							<tr>
								<td class="key">Sistem Pemungutan</td>
								<td>
									<?php
										$attributes = 'id="spt_jenis_pemungutan" class="inputbox"';
										echo form_dropdown('spt_jenis_pemungutan', $sistem_pemungutan, $row->spt_jenis_pemungutan, $attributes);
									?>
								</td>
							</tr>							
					</table>
				</td>
				<td valign="top">
					<table class="admintable" border=0 cellspacing="1">
						<tr>
							<td class="key">
								<label for="name">Nama WP</label>
							</td>
							<td>
							<input type="text" name="wp_wr_nama" id="wp_wr_nama" value="<?= $row->wp_wr_nama;?>" class="inputbox mandatory" size="50" style="text-transform: uppercase;" />
						</tr>
						<tr>
							<td class="key" valign="top">
								<label for="username">Alamat WP</label>
							</td>
							<td>		
								<textarea cols="40" rows="3" name="wp_wr_almt" id="wp_wr_almt" class="inputbox mandatory" style="text-transform: uppercase;"><?= $row->wp_wr_almt; ?></textarea>
							</td>
						</tr>
						<!-- 
						<tr>
							<td class="key">
								<label for="name">Merk Usaha</label>
							</td>
							<td>
							<input type="text" name="txt_merk_usaha" id="txt_merk_usaha" class="inputbox" size="50" style="text-transform: uppercase;" />
						</tr>
						 -->
						<tr>
							<td valign="top" class="key">
								<label for="gid">Masa Pajak</label>
			
							</td>
							<td>
								<input type="text" name="spt_periode_jual1" id="fDate" value="<?= format_tgl($row->spt_periode_jual1);?>" size="11" class="mandatory" />
								S / D
								<input type="text" name="spt_periode_jual2" id="tDate" value="<?= format_tgl($row->spt_periode_jual2);?>" size="11" class="mandatory" />
							</td>
						</tr>
					</table>
				</td>
				</tr>
				<tr>
					<td colspan="2">
						<fieldset class="adminform">
						<legend>DETAIL REKLAME</legend>
							<table class="admintable" border=0 cellspacing="1">
								<tbody id="ads-detail-tbody">
									<?php
									$no = 0;
									foreach($rows_detail as $row_detail){
										$no++;
										echo "
										<tr id='row-".$no."'>
											<td class='outsets' valign='top'>
												<input type='hidden' name='spt_dt_id".$no."' value='".$row_detail->spt_dt_id."'/>												
												<input type='hidden' name='sptrek_id".$no."' value=''/>
												<table>
													<tr>
														<td class='key'>
														Jenis Reklame
														</td>
														<td>
															<select name='spt_dt_korek".$no."' id='spt_dt_korek".$no."' onchange=\"load_ads_assess_panel(".$no.")\" class='inputbox mandatory'> 
															<option value=''>--</option>";															
																foreach ($rekening as $key => $value) {
																	$arr_rek = explode(",", $key);
																	if ($row_detail->spt_dt_korek == $arr_rek[0]) 
																		$selected = "selected";
																	else 
																		$selected = "";															
																	
																	echo "<option value='".$key."' ".$selected.">".$value."</option>";
																}

															echo "</select>
															<input type='hidden' name='txt_korek".$no."' value=''>
														</td>
													</tr>
													<tr>
														<td class='key'>Area</td>
														<td>
															<input type='radio' name='area".$no."' id='area".$no."_1' value='1' onchange=\"execute_area_function(".$no.")\" ".($row_detail->sptrek_area=='1'?'checked':'')."/>&nbsp;Outdoor&nbsp;&nbsp;
															<input type='radio' name='area".$no."' id='area".$no."_2' value='2' onchange=\"execute_area_function(".$no.")\" ".($row_detail->sptrek_area=='1'?'checked':'')."/>&nbsp;Indoor
														</td>
													</tr>
													<tr>
														<td class='key'>Tembakau dan Minuman keras</td>
														<td>
															<input type='checkbox' name='tmk".$no."' id='tmk".$no."_1' value='1' onclick=\"execute_tmk_function(".$no.")\" value='1'/>&nbsp;Rokok&nbsp;&nbsp;
															<input type='checkbox' name='tmk".$no."' id='tmk".$no."_2' value='2' onclick=\"execute_tmk_function(".$no.")\" value='1'/>&nbsp;Minuman Keras
														</td>
													</tr>
													<tr>
														<td class='key'>Penambahan Ketinggian</td>
														<td>
															<input type='checkbox' name='tinggi".$no."' id='tinggi".$no."_1' value='1' onclick=\"execute_tinggi_function(".$no.")\" value='1'/>&nbsp;tinggi&nbsp;&nbsp
															
														</td>
													</tr>
													<tr>
														<td class='key'>Naskah / Judul</td>
														<td>
															<textarea cols='30' rows='2' name='txt_judul".$no."' id='txt_judul".$no."' class='inputbox mandatory' style='text-transform: uppercase;'></textarea>
														</td>		
													</tr>
													<tr>
														<td class='key'>
														Lokasi Pasang
														</td>
														<td>
															<textarea class='inputbox' name='txt_lokasi_pasang".$no."' id='txt_lokasi_pasang".$no."' cols='30' rows='2' style='text-transform: uppercase;'></textarea>
														</td>
													</tr>
													<tr>
														<td class='key'>
														Perda Lama
														</td>
														<td>
															<input type='checkbox' name='chb_perda_lama".$no."' id='chb_perda_lama".$no."' onclick=\"execute_old_govregulation(".$no.")\" value='1'>Ya</input>
														</td>
													</tr>";

													if($no>1){
														echo "<tr>
															<td colspan='2' align='center'><input type='button' value='Hapus Detail' onclick=\"if(confirm('Anda yakin akan menghapus detail tersebut?')) {delete_detail_row(".$no.")}\"/></td>
														</tr>";
													}
												echo "</table>
											</td>
											<td id='detail_nsr".$no."' valign='top'>
											</td>
										</tr>";
									}

									?>
								</tbody>
								<tfoot>
									<tr>
										<td align="center">
											<br/>
											<input type="button" value="TAMBAH DETAIL" onclick="add_detail_row();">
											&nbsp;&nbsp;&nbsp;<b>TOTAL PAJAK</b> &nbsp;&nbsp;&nbsp; 
											<input type="text" name="spt_pajak" id="spt_pajak" value="<?= format_currency($row->spt_pajak); ?>" class="inputbox" size="20" 
											value="" onfocus="this.value=unformatCurrency(this.value);" onblur="this.value=formatCurrency(this.value);" 
											readonly="true"  style="font-weight:bold;font-size:25px;color:#18F518;background-color:black;text-align:right;"/>
										</td>
									</tr>
								</tfoot>
							</table>
							<input type="hidden" id="n_detail_rows" name="n_detail_rows" value="<?=$no;?>"/>							
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
	GLOBAL_PAJAK_REKLAME_VARS["get_rekening"] = "<?=base_url();?>rekening/get_arr_list";
	GLOBAL_PAJAK_REKLAME_VARS["get_kelas_jalan"] = "<?=base_url();?>pendataan/pajak_reklame/get_kelas_jalan";
	GLOBAL_PAJAK_REKLAME_VARS["get_nilai_kelas_jalan"] = "<?=base_url();?>pendataan/pajak_reklame/get_nilai_kelas_jalan";
	GLOBAL_PAJAK_REKLAME_VARS["detail_reklame"] = "<?=base_url();?>pendataan/pajak_reklame/get_spt_reklame";
	GLOBAL_PAJAK_REKLAME_VARS["update_sptpd"] = "<?=base_url();?>pendataan/pajak_reklame/update";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/edit_pajak_reklame.js"></script>