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
						<span class="icon-32-save" title="Save">
						</span>
						Simpan
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
		<div class="header icon-48-reklame">
			Isian SKPD Pajak Reklame: <small><small id='title_head'>[ Baru ]</small></small>
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
		
		$attributes = array('id' => 'frm_add_reklame');
		$hidden = array('mode' => 'add', 'spt_jenis_pajakretribusi' => '4', 'kodus_id' => '5', 'korek' => $this->config->item('korek_reklame'));
		echo form_open(base_url().'pendataan/pajak_reklame/save', $attributes, $hidden);
		?>
		<div class="col">
			
			<table class="admintable" border=0 cellspacing="1" style="min-width: 850px;">
				<tr> 
					<td valign="top" class="outsets">
					<table class="admintable">
						<tr>
							<td class="key"><label for="name">No. Reg Form</label></td>
							<td>
								<input type="text" name="spt_kode" id="spt_kode" class="inputbox mandatory" size="2" value="<?= $this->session->userdata('USER_SPT_CODE'); ?>" readonly="readonly" />
								<input type="text" name="spt_no_register" id="spt_no_register" class="inputbox mandatory" <?= $js; ?> size="10" maxlength="10" /> 
								<a href="#" onclick="getNextNomor();">[refresh]
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password">Tanggal Proses</label>
							</td>
							<td>
								<input type="text" name="spt_tgl_proses" id="spt_tgl_proses" class="inputbox mandatory" size="11" value="<?= date("d-m-Y")?>" readonly />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password">Tanggal Entry</label>
							</td>
							<td>
								<input type="text" name="spt_tgl_entry" id="spt_tgl_entry" class="inputbox mandatory" size="11" value="<?= date("d-m-Y")?>" readonly />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password">Periode SPT</label>
							</td>
							<td>
								<input type="text" name="spt_periode" id="spt_periode" class="inputbox" size="4" maxlength="4" value="<?= date('Y');?>" />
							</td>
						</tr>
						<tr>
							<td class="key">Sistem Pemungutan</td>
							<td>
								<?php
									$attributes = 'id="spt_jenis_pemungutan" class="inputbox"';
									echo form_dropdown('spt_jenis_pemungutan', $sistem_pemungutan, '', $attributes);
								?>
							</td>
						</tr>
						<!-- 
						<tr>
							<td class="key">
								<label for="password">NPWPD</label>
							</td>
							<td>
								<input type="hidden" name="wp_wr_id" id="wp_wr_id">
								<input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="inputbox" size="1" maxlength="1" value="P" readonly="true"/>
								<input type="text" name="wp_wr_golongan" id="wp_wr_golongan" class="inputbox" size="1" maxlength="1" tabindex="2" autocomplete="off" />
								<input type="text" name="wp_wr_jenis_pajak" id="wp_wr_jenis_pajak" class="inputbox" size="2" maxlength="2" autocomplete="off" />
								<input type="text" name="wp_wr_no_registrasi" id="wp_wr_no_registrasi" class="inputbox" size="7" maxlength="7" autocomplete="off" />
								<input type="text" name="wp_wr_kode_camat" id="wp_wr_kode_camat" class="inputbox" size="2" maxlength="2" autocomplete="off" />
								<input type="text" name="wp_wr_kode_lurah" id="wp_wr_kode_lurah" class="inputbox" size="2" maxlength="2" autocomplete="off" />
								<input type="button" id="btn_npwpd" size="2" value="...">
							</td>
						</tr>
						 -->
						
					</table>
				</td>
				<td valign="top">
					<table class="admintable" border=0 cellspacing="1">
						<tr>
							<td class="key">
								<label for="name">Nama WP</label>
							</td>
							<td>
							<input type="text" name="wp_wr_nama" id="wp_wr_nama" class="inputbox mandatory" size="50" style="text-transform: uppercase;" />
						</tr>
						<tr>
							<td class="key" valign="top">
								<label for="username">Alamat WP</label>
							</td>
							<td>		
								<textarea cols="40" rows="3" name="wp_wr_almt" id="wp_wr_almt" class="inputbox mandatory" style="text-transform: uppercase;"></textarea>
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
								<input type="text" name="spt_periode_jual1" id="fDate" size="11" class="mandatory" />
								S / D
								<input type="text" name="spt_periode_jual2" id="tDate" size="11" class="mandatory" />
							</td>
						</tr>
					</table>
				</td>
				</tr>
				<tr>
					<td colspan="2">
						<fieldset class="adminform">
						<legend>DETAIL REKLAME</legend>
							<table class="admintable" border="0" cellspacing="1">
								<tbody id="ads-detail-tbody">
									<tr id="row-1">
										<td class="outsets" valign="top">
											<table>
												<tr>
													<tr>
														<td class="key">
														Jenis Reklame
														</td>
														<td>
															<select name="spt_dt_korek1" id="spt_dt_korek1" onchange="load_ads_assess_panel(1)" class="inputbox mandatory">
															</select>
															<input type="hidden" name="txt_korek1" value="">
														</td>
													</tr>
													<tr>
														<td class="key">Area</td>
														<td>
															<input type="radio" name="area1" id="area1_1" onchange="execute_area_function(1)" value="1" checked="checked" />&nbsp;Outdoor&nbsp;&nbsp;
															<input type="radio" name="area1" id="area1_2" onchange="execute_area_function(1)" value="2" />&nbsp;Indoor
														</td>
													</tr>
													<tr>
														<td class="key">Naskah / Judul</td>
														<td>
															<textarea cols="30" rows="2" name="txt_judul1" id="txt_judul1" class="inputbox mandatory" style="text-transform: uppercase;"></textarea>
														</td>
													</tr>
													<tr>
														<td class="key">
														Lokasi Pasang
														</td>
														<td>
															<textarea class="inputbox" name="txt_lokasi_pasang1" id="txt_lokasi_pasang1" cols="30" rows="2" style="text-transform: uppercase;"></textarea>
														</td>
													</tr>
													<!-- 
													<tr>
														<td class="key">
														Perda Lama
														</td>
														<td>
															<input type="checkbox" name="chb_perda_lama1" onclick="execute_old_govregulation(1)" id="chb_perda_lama1" value="1">Ya</input>
														</td>
													</tr>
													-->
												</tr>
											</table>
										</td>
										<td id="detail_nsr1" valign="top"></td>
									</tr>
								</tbody>
								<tfoot>									
									<tr>
										<td align="center">
											<br/>
											<input type="button" value="TAMBAH DETAIL" onclick="add_detail_row();">
											&nbsp;&nbsp;&nbsp;<b>TOTAL PAJAK</b> &nbsp;&nbsp;&nbsp; 
											<input type="text" name="spt_pajak" id="spt_pajak" class="inputbox" size="20" 
											value="" onfocus="this.value=unformatCurrency(this.value);" onblur="this.value=formatCurrency(this.value);" 
											readonly="true"  style="font-weight:bold;font-size:25px;color:#18F518;background-color:black;text-align:right;"/>
										</td>
									</tr>
								</tfoot>
							</table>
							<input type="hidden" id="n_detail_rows" name="n_detail_rows" value="1"/>
						</fieldset>
					</td>
				</tr>
			</table>
			
			</form>
		</div>
		<?php
			// echo form_close();
		?>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_PAJAK_REKLAME_VARS = new Array ();
	GLOBAL_PAJAK_REKLAME_VARS["get_rekening"] = "<?=base_url();?>rekening/get_arr_list";
	GLOBAL_PAJAK_REKLAME_VARS["get_kelas_jalan"] = "<?=base_url();?>pendataan/pajak_reklame/get_kelas_jalan";
	GLOBAL_PAJAK_REKLAME_VARS["get_nilai_kelas_jalan"] = "<?=base_url();?>pendataan/pajak_reklame/get_nilai_kelas_jalan";
	GLOBAL_PAJAK_REKLAME_VARS["insert"] = "<?=base_url();?>pendataan/pajak_reklame/save";
	GLOBAL_PAJAK_REKLAME_VARS["view"] = "<?=base_url();?>pendataan/pajak_reklame/view";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/add_pajak_reklame.js"></script>