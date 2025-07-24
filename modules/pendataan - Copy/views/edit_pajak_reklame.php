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
							'spt_dt_id' => $row_detail->spt_dt_id,
							'sptrek_id' => ''
					);
		echo form_open('frm_edit_reklame', $attributes, $hidden);
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
								<tr>
									<td class="outsets" valign="top">
										<table>
											<tr>
												<td class="key">
												Jenis Reklame
												</td>
												<td>
													<select name="spt_dt_korek" id="spt_dt_korek" class="inputbox mandatory"> 
													<option value="">--</option>
													<?php
														foreach ($rekening as $key => $value) {
															$arr_rek = explode(",", $key);
															if ($row_detail->spt_dt_korek == $arr_rek[0]) 
																$selected = "selected";
															else 
																$selected = "";
													?>
														<option value="<?= $key ?>" <?= $selected; ?> ><?= $value; ?></option>
													<?php
														}
													?>
													</select>
													<input type="hidden" name="txt_korek" value="">
												</td>
											</tr>
											<tr>
												<td class="key">Area</td>
												<td>
													<input type="radio" name="area" id="area" value="1" checked="checked" />&nbsp;Outdoor&nbsp;&nbsp;
													<input type="radio" name="area" id="area" value="2" />&nbsp;Indoor
												</td>
											</tr>
											<tr>
												<td class="key">Naskah / Judul</td>
												<td>
													<textarea cols="30" rows="2" name="txt_judul" id="txt_judul" class="inputbox mandatory" style="text-transform: uppercase;"></textarea>
												</td>		
											</tr>
											<tr>
												<td class="key">
												Lokasi Pasang
												</td>
												<td>
													<textarea class="inputbox" name="txt_lokasi_pasang" id="txt_lokasi_pasang" cols="30" rows="2" style="text-transform: uppercase;"></textarea>
												</td>
											</tr>
											<tr>
												<td class="key">
												Perda Lama
												</td>
												<td>
													<input type="checkbox" name="chb_perda_lama" id="chb_perda_lama" value="1">Ya</input>
												</td>
											</tr>
											<!-- 
											<tr>
												<td class="key" style="color:#8BCF40">Nilai Sewa Reklame (NSR)</td>
												<td>
													Rp.&nbsp;<input type="text" name="nsr" id="nsr" value="0" style="text-align:right" readonly="readonly" />
												</td>
											</tr>
											 
											<tr id="row_persen_tarif" style="display: none;">
												<td class="key">
												Tarif
												</td>
												<td>
													<input type="text" name="spt_dt_persen_tarif" id="spt_dt_persen_tarif" class="inputbox" size="2" value=""  readonly="true" style="text-align:right;"/>
												</td>
											</tr>
											-->
										</table>
									</td>
									<td id="detail_nsr" valign="top">
										
									</td>
								</tr>
								<tr>
									<td align="center">
										<br/>
										<!-- <input type="BUTTON" value="TAMBAH DETAIL" id="btn_add_detail">  -->
										&nbsp;&nbsp;&nbsp;<b>P A J A K</b> &nbsp;&nbsp;&nbsp; 
										<input type="text" name="spt_pajak" id="spt_pajak" value="<?= format_currency($row->spt_pajak); ?>" class="inputbox" size="20" 
										value="" onfocus="this.value=unformatCurrency(this.value);" onblur="this.value=formatCurrency(this.value);" 
										readonly="true"  style="font-weight:bold;font-size:25px;color:#18F518;background-color:black;text-align:right;"/>
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
	GLOBAL_PAJAK_REKLAME_VARS["get_rekening"] = "<?=base_url();?>rekening/get_arr_list";
	GLOBAL_PAJAK_REKLAME_VARS["get_kelas_jalan"] = "<?=base_url();?>pendataan/pajak_reklame/get_kelas_jalan";
	GLOBAL_PAJAK_REKLAME_VARS["get_nilai_kelas_jalan"] = "<?=base_url();?>pendataan/pajak_reklame/get_nilai_kelas_jalan";
	GLOBAL_PAJAK_REKLAME_VARS["detail_reklame"] = "<?=base_url();?>pendataan/pajak_reklame/get_spt_reklame";
	GLOBAL_PAJAK_REKLAME_VARS["update_sptpd"] = "<?=base_url();?>pendataan/pajak_reklame/update";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/edit_pajak_reklame.js"></script>