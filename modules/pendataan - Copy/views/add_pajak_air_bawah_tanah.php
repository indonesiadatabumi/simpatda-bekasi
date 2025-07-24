<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<?php 
						if(($this->session->userdata('USER_SPT_CODE') == "10")) {
					?>
						<td class="button" id="toolbar-new">
							<a href="#" id="btn_save" class="toolbar">
							<span class="icon-32-save" title="Save">
							</span>
							Simpan
							</a>
						</td>
					<?php		
						}
					
					?>
					<td class="button" id="toolbar-ref">
						<a href="#" id="btn_view" class="toolbar">
							<span class="icon-32-ref" title="Lihat Data"></span>Lihat Data
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-user">
			Isian SKPD Pajak Air Tanah : <small><small id='title_head'>[ Baru ]</small></small>
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
		
		$attributes = array('id' => 'frm_add_sptpd_air');
		$hidden = array(
						'mode' => 'add', 
						'spt_jenis_pajakretribusi' => $this->config->item('jenis_pajak_air_bawah_tanah'), 
						'kodus_id' => $this->config->item('kodus_air_bawah_tanah'), 
						'korek' => $this->config->item('korek_air_bawah_tanah') 
					);
		echo form_open('frm_add_sptpd_air', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top" class="outsets">
					<table class="admintable">
						<tr>
							<td class="key"><label for="name">No. Reg Form</label></td>
							<td>
								<input type="text" name="spt_kode" id="spt_kode" class="inputbox mandatory" size="2" value="<?= $this->session->userdata('USER_SPT_CODE'); ?>" readonly="readonly" />
								<input type="text" name="spt_no_register" id="spt_no_register" class="inputbox mandatory" <?= $js; ?> size="10" maxlength="5" /> 
								<a href="#" onclick="getNextNomor();">[refresh]
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password">Tanggal Proses</label>
							</td>
							<td>
								<input type="text" name="spt_tgl_proses" id="spt_tgl_proses" class="mandatory" size="11" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password">Tanggal Entry</label>
							</td>
							<td>
								<input type="text" name="spt_tgl_entry" id="spt_tgl_entry" class="mandatory" size="11" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="password">Periode</label>
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
					<legend>Detail Air Bawah Tanah</legend>
						<table class="admintable" border=0 cellspacing="1">
							<tr>
								<td>
									<div id="detailSelf">
									<table class="adminlist" cellspacing="1" id="detailTable" border="0">
										<thead>
											<tr>
												<th class="title" rowspan="3">Kode Rekening</th>
												<th width="8%" class="title" rowspan="2"> Volume (M3) </th>
												<th width="8%" class="title" rowspan="2">DASAR PENGENAAN<br> / NPA  (Rp.)</th>
												<th class="title" colspan="2">Pajak</th>
												<!-- <th class="title" rowspan="3" width="40">-</th> -->
											</tr>
											<tr>
												<th class="title">%</th>
												<th class="title">NILAI   (Rp.)</th>
												</tr>
												<tr>
												<th class="title">(a)</th>
												<th class="title">(b)</th>
												<th class="title">(c)</th>
												<th class="title">(b x c)</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<td colspan="12">
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
								<!-- <input type="BUTTON" value="TAMBAH DETAIL" id="btn_add_detail">  -->
								&nbsp;&nbsp;&nbsp;  <b>TOTAL</b> &nbsp;&nbsp;&nbsp; 
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
		<?=	form_close(); ?>
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var GLOBAL_PAJAK_AIR_VARS = new Array ();
	GLOBAL_PAJAK_AIR_VARS["get_rekening"] = "<?=base_url();?>pendataan/pajak_air_bawah_tanah/get_rekening";
	GLOBAL_PAJAK_AIR_VARS["insert_sptpd"] = "<?=base_url();?>pendataan/pajak_air_bawah_tanah/save";
	GLOBAL_PAJAK_AIR_VARS["view_sptpd"] = "<?=base_url();?>pendataan/pajak_air_bawah_tanah/view";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/add_pajak_air_bawah_tanah.js"></script>