<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<?php 
						if (($row->netapajrek_id == "" && $row->setorpajret_id == "") && 
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
		<div class="header icon-48-hiburan">
			Isian SPTPD Pajak Hiburan: <small><small id='title_head'>[ Edit ]</small></small>
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
		
		$attributes = array('id' => 'frm_edit_sptpd_hiburan');
		$hidden = array(
							'mode' => 'edit', 
							'spt_jenis_pajakretribusi' => $this->config->item('jenis_pajak_hiburan'), 
							'kodus_id' => $this->config->item('kodus_hiburan'), 
							'korek' => $this->config->item('korek_hiburan'), 
							'spt_id' => $row->spt_id
				);
		echo form_open('frm_edit_sptpd_hiburan', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top" class="outsets">
					<table class="admintable">
						<tr>
							<td class="key"><label for="name">No. Reg Form / SPT</label></td>
							<td>
								<input type="text" name="spt_no_register" id="spt_no_register" value="<?= $row->spt_nomor; ?>" class="inputbox mandatory" <?= $js; ?> readonly="true" size="8" maxlength="10" /> 
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password">Tanggal Proses</label>
							</td>
							<td>
								<input type="text" name="spt_tgl_proses" id="spt_tgl_proses" value="<?= format_tgl($row->spt_tgl_proses); ?>" class="mandatory" size="11" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password">Tanggal Entry</label>
							</td>
							<td>
								<input type="text" name="spt_tgl_entry" id="spt_tgl_entry" value="<?= format_tgl($row->spt_tgl_entry); ?>" class="mandatory" size="11" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password">Periode SPT</label>
							</td>
							<td>
								<input type="text" name="spt_periode" id="spt_periode" value="<?= $row->spt_periode;?>" class="inputbox mandatory" size="4" maxlength="4" value="<?= date('Y');?>" />
							</td>
						</tr>
						<!-- 
						<tr>
							<td class="key">
								<label for="password">Nomor SPT</label>
							</td>
							<td>
								<input type="text" name="spt_nomor" id="spt_nomor" class="inputbox" size="11" <?= $js; ?> />
								<input type="button" id="trigger_spt" size="2" value="..." >
								<input type="button" value="Kosongkan" id="btn_reset_spt">
								<input type="hidden" name="spt_nomor_tmp" id="spt_nomor_tmp" />
							</td>
						</tr>
						 -->
						<tr>
							<td class="key">
								<label for="password">NPWPD</label>
							</td>
							<td>
								<input type="hidden" name="wp_wr_id" id="wp_wr_id" value="<?= $row->spt_idwpwr;?>">
								<input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="inputbox mandatory" size="1" maxlength="1" value="P" readonly="true"/>
								<input type="text" name="wp_wr_golongan" id="wp_wr_golongan" value="<?= $row->wp_wr_gol;?>" class="inputbox npwpd mandatory" size="1" maxlength="1" autocomplete="off" />
								<input type="text" name="wp_wr_jenis_pajak" id="wp_wr_jenis_pajak" value="<?= $row->ref_kodus_kode;?>" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
								<input type="text" name="wp_wr_no_registrasi" id="wp_wr_no_registrasi" value="<?= $row->wp_wr_no_urut;?>" class="inputbox npwpd mandatory" size="7" maxlength="7" autocomplete="off" />
								<input type="text" name="wp_wr_kode_camat" id="wp_wr_kode_camat" value="<?= $row->camat_kode;?>" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
								<input type="text" name="wp_wr_kode_lurah" id="wp_wr_kode_lurah" value="<?= $row->lurah_kode;?>" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
								<input type="button" id="btn_npwpd" size="2" value="..." class="button" />
							</td>
						</tr>
						<tr>
							<td width="150" class="key">
								<label for="name">Nama WP</label>
							</td>
							<td>
							<input type="text" name="wp_wr_nama" id="wp_wr_nama" value="<?= $row->wp_wr_nama;?>" class="inputbox" size="40" readonly="true" style="text-transform: uppercase;" />
						</tr>
						<tr>
							<td class="key" valign="top">
								<label for="username">Alamat</label>
							</td>
							<td>		
								<textarea cols="34" rows="3" name="wp_wr_almt" id="wp_wr_almt" class="inputbox" readonly="readonly"><?= $row->wp_wr_almt; ?></textarea>
							</td>
						</tr>
						<tr>
							<td class="key" valign="top">
								<label for="password">Kelurahan</label>
					
							</td>
							<td>
								<input type="text" name="wp_wr_lurah" id="wp_wr_lurah" value="<?= $row->wp_wr_lurah;?>" class="inputbox" size="40" readonly="true" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password2">Kecamatan</label>
					
							</td>
							<td>
								<input type="text" name="wp_wr_camat" id="wp_wr_camat" value="<?= $row->wp_wr_camat;?>" class="inputbox" size="40" readonly="true" />
							</td>
						</tr>
						<tr>
							<td valign="top" class="key">
								<label for="gid">Kabupaten / Kota</label>
					
							</td>
							<td>
								<input type="text" name="wp_wr_kabupaten" id="wp_wr_kabupaten" value="<?= $row->wp_wr_kabupaten;?>" class="inputbox" size="40" readonly="true" />
							</td>		
						</tr>
					</table>
				</td>
				<td valign="top">
					<table class="admintable" border=0 cellspacing="1">
						<tr>
							<td class="key">Sistem Pemungutan</td>
							<td>
								<?php
									$attributes = 'id="spt_jenis_pemungutan" class="inputbox"';
									echo form_dropdown('spt_jenis_pemungutan', $sistem_pemungutan, $row->spt_jenis_pemungutan, $attributes);
								?>
							</td>
						</tr>
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
					
					<br />
					<fieldset class="adminform">
					<legend>DETAIL HIBURAN</legend>
					<table class="admintable" border=0 cellspacing="1">
						<tr>
						<td valign="top">
							<tr>
								<td>
									<div id="detailSelf">
										<table class="adminlist" cellspacing="1" id="detailTable" border="0">
											<thead>
												<tr>
													<th class="title" rowspan="2">Kode Rekening</th>
													<th class="title">Dasar Pengenaan</th>
													<th class="title">Persen Tarip</th>
													<th class="title">Pajak</th>
													<th class="title" rowspan="2" width="40">-</th>
												</tr>
												<tr>
													<th class="title" width="80px">(a)</th>
													<th class="title" width="50px">(b)</th>
													<th class="title" width="80px">(a x b)</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<td colspan="5">
													</td>
												</tr>
											</tfoot>
	
											<tbody id="tbody_detail">
												<?php 
													if ($row_detail->num_rows() > 0) {
														$counter = 1;
														foreach ($row_detail->result() as $detail) {
												?>
													<tr class="row0" id="row_detail<?=$counter?>">
														<td>
															<input type="hidden" name="spt_dt_id[]" value="<?=$detail->spt_dt_id;?>">
															<select name="spt_dt_korek[]" id="spt_dt_korek<?=$counter?>" class="inputbox" onchange="checkKorek(<?=$counter?>);
																getTarif('spt_dt_persen_tarif<?=$counter?>','spt_dt_tarif_dasar<?=$counter?>',this.value);
																getPajak('spt_dt_pajak<?=$counter?>','spt_dt_persen_tarif<?=$counter?>','spt_dt_dasar_pengenaan<?=$counter;?>','spt_dt_dasar_pengenaan<?=$counter;?>','spt_dt_jumlah<?=$counter?>');
																calc1();"> 
															<option value="">--</option>
															<?php
																foreach ($rekening as $key => $value) {
																	$arr_rek = explode(",", $key);
																	if ($detail->spt_dt_korek == $arr_rek[0]) 
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
															<input type="text" name="spt_dt_dasar_pengenaan[]" id="spt_dt_dasar_pengenaan<?=$counter?>" value="<?=format_currency($detail->spt_dt_jumlah)?>" class="inputbox" size="16" onchange="getPajak('spt_dt_pajak<?=$counter?>','spt_dt_persen_tarif<?=$counter?>','spt_dt_dasar_pengenaan<?=$counter;?>','spt_dt_dasar_pengenaan<?=$counter;?>','spt_dt_jumlah<?=$counter?>');calc1();" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" style="text-align:right;" autocomplete="off" />
														</td>
														<td align="right">
															<input type="text" name="spt_dt_persen_tarif[]" id="spt_dt_persen_tarif<?=$counter?>" class="inputbox" value="<?=$detail->spt_dt_persen_tarif?>"  readonly="true" style="text-align:right;width:60%;"/>
														</td>
														<td>
															<input type="text" name="spt_dt_pajak[]" id="spt_dt_pajak<?=$counter?>" class="numeric" value="<?=format_currency($detail->spt_dt_pajak)?>" readonly="true" style="text-align:right;width:100%;"/>
														</td>
														<td>
															<a href="#" onClick="removeFormField('#row_detail<?=$counter?>');calc1();return false;">Hapus</a>
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
									<input type="text" name="spt_pajak" id="spt_pajak" class="inputbox" size="20" 
									value="<?= format_currency($row->spt_pajak); ?>"  
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
	GLOBAL_PAJAK_HIBURAN_VARS["get_rekening"] = "<?=base_url();?>rekening/get_arr_list";
	GLOBAL_PAJAK_HIBURAN_VARS["update_sptpd"] = "<?=base_url();?>pendataan/pajak_hiburan/update";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/edit_pajak_hiburan.js"></script>