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
		<div class="header icon-48-parkir">
			Isian SPTPD Pajak Parkir: <small><small id='title_head'>[ Baru ]</small></small>
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
		
		$attributes = array('id' => 'frm_add_sptpd_parkir');
		$hidden = array(
							'mode' => 'add',
							'spt_jenis_pajakretribusi' => $this->config->item('jenis_pajak_parkir'), 
							'kodus_id' => $this->config->item('kodus_parkir'), 
							'korek' => $this->config->item('korek_parkir')
					);
		echo form_open('frm_add_sptpd_parkir', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top" class="outsets">
					<table class="admintable">
						<tr>
							<td class="key"><label for="name">No. Reg Form / SPT</label></td>
							<td>
								<input type="text" name="spt_kode" id="spt_kode" class="inputbox mandatory" size="2" value="<?= $this->session->userdata('USER_SPT_CODE'); ?>" readonly="readonly" />
								<input type="text" name="spt_no_register" id="spt_no_register" class="inputbox mandatory" <?= $js; ?> size="10" maxlength="5" /> 
								<a href="#" onclick="getNextNomor();">[refresh]
							</td>
						</tr>
						<td class="key">Tanggal Proses</td>
							<td>
								<input type="text" name="spt_tgl_proses" id="spt_tgl_proses" class="mandatory" size="11" value="<?= date("d-m-Y")?>" readonly />
							</td>
						</tr>
						<tr>
							<td class="key">Tanggal Entry</td>
							<td>
								<input type="text" name="spt_tgl_entry" id="spt_tgl_entry" class="mandatory" size="11" value="<?= date("d-m-Y")?>" readonly />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password">Periode SPT</label>
							</td>
							<td>
								<input type="text" name="spt_periode" id="spt_periode" class="inputbox mandatory" size="4" maxlength="4" value="<?= date('Y');?>" />
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
								<input type="hidden" name="wp_wr_id" id="wp_wr_id">
								<input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="inputbox mandatory" size="1" maxlength="1" value="P" readonly="true"/>
								<input type="text" name="wp_wr_golongan" id="wp_wr_golongan" class="inputbox npwpd mandatory" size="1" maxlength="1" autocomplete="off" />
								<input type="text" name="wp_wr_jenis_pajak" id="wp_wr_jenis_pajak" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
								<input type="text" name="wp_wr_no_registrasi" id="wp_wr_no_registrasi" class="inputbox npwpd mandatory" size="7" maxlength="7" autocomplete="off" />
								<input type="text" name="wp_wr_kode_camat" id="wp_wr_kode_camat" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
								<input type="text" name="wp_wr_kode_lurah" id="wp_wr_kode_lurah" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
								<input type="button" id="btn_npwpd" size="2" value="..." class="button">
							</td>
						</tr>
						<tr>
							<td width="150" class="key">
								<label for="name">Nama WP</label>
							</td>
							<td>
							<input type="text" name="wp_wr_nama" id="wp_wr_nama" class="inputbox" size="40" readonly="true" style="text-transform: uppercase;" />
						</tr>
						<tr>
							<td class="key" valign="top">
								<label for="username">Alamat</label>
							</td>
							<td>		
								<textarea cols="34" rows="3" name="wp_wr_almt" id="wp_wr_almt" class="inputbox" readonly="true" style="text-transform: uppercase;"></textarea>
							</td>
						</tr>
						<tr>
							<td class="key" valign="top">
								<label for="password">Kelurahan</label>
					
							</td>
							<td>
								<input type="text" name="wp_wr_lurah" id="wp_wr_lurah" class="inputbox" size="40" readonly="true" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password2">Kecamatan</label>
					
							</td>
							<td>
								<input type="text" name="wp_wr_camat" id="wp_wr_camat" class="inputbox" size="40" readonly="true" />
							</td>
						</tr>
						<tr>
							<td valign="top" class="key">
								<label for="gid">Kabupaten / Kota</label>
					
							</td>
							<td>
								<input type="text" name="wp_wr_kabupaten" id="wp_wr_kabupaten" class="inputbox" size="40" readonly="true" />
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
									echo form_dropdown('spt_jenis_pemungutan', $sistem_pemungutan, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td valign="top" class="key">
								<label for="gid">Periode Penjualan</label>
			
							</td>
							<td>
								<input type="text" name="spt_periode_jual1" id="fDate" class="mandatory" size="11" />
								S / D
								<input type="text" name="spt_periode_jual2" id="tDate" class="mandatory" size="11" />
							</td>
						</tr>
					</table>
					
					<br />
					<fieldset class="adminform">
					<legend>DETAIL PARKIR</legend>
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
									value=""  
									readonly="true"  style="font-weight:bold;font-size:25px;color:#18F518;background-color:black;text-align:right;"/>
								</td>
							</tr>
						</table>
					</fieldset>
				</td>
				</tr>
			</table>
		</div>
		</form>
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_PAJAK_PARKIR_VARS = new Array ();
	GLOBAL_PAJAK_PARKIR_VARS["get_rekening"] = "<?=base_url();?>rekening/get_arr_list";
	GLOBAL_PAJAK_PARKIR_VARS["insert_sptpd"] = "<?=base_url();?>pendataan/pajak_parkir/save";
	GLOBAL_PAJAK_PARKIR_VARS["view_sptpd"] = "<?=base_url();?>pendataan/pajak_parkir/view";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/add_pajak_parkir.js"></script>