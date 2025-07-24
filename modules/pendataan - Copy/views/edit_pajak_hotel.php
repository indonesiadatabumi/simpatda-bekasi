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
		<div class="header icon-48-hotel">
			Isian SPTPD Pajak Hotel: <small><small id='title_head'>[ Edit ]</small></small>
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
		
		$attributes = array('id' => 'frm_edit_sptpd_hotel');
		$hidden = array(
						'mode' => 'edit', 
						'spt_jenis_pajakretribusi' => $this->config->item('jenis_pajak_hotel'), 
						'kodus_id' => $this->config->item('kodus_hotel') ,
						'spt_id' => $row->spt_id, 
						'spt_dt_id' => $row->spt_dt_id
					);
		echo form_open('frm_edit_sptpd_hotel', $attributes, $hidden);
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
								<input type="button" id="btn_npwpd" size="2" value="..." class="button">
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
								<textarea cols="40" rows="3" name="wp_wr_almt" id="wp_wr_almt" class="inputbox" readonly="readonly"><?= $row->wp_wr_almt; ?></textarea>
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
						<tr>
							<td width="150" class="key">
								<label for="name">Kode  Rekening</label>
							</td>
							<td>
								<input type="hidden" name="spt_kode_rek" id="spt_kode_rek" value="<?= $row->spt_dt_korek;?>">
								<input type="text" name="korek" id="korek" class="inputbox rekening" value="<?= $row->koderek;?>" size="10" readonly="true" />
								Jenis
								<input type="text" name="korek_rincian" id="korek_rincian" value="<?= $row->korek_rincian;?>" class="inputbox rekening" size="2" maxlength="2" />
								Klas
								<input type="text" name="korek_sub1" id="korek_sub1" value="<?= $row->korek_sub1;?>" class="inputbox rekening" size="2" maxlength="2" />
								<input type="button" id="trigger_rek" size="2" value="..." class="button" />
							</td>
						</tr>
						<tr>
							<td width="150" class="key">
								<label for="name">Nama  Rekening</label>
							</td>
							<td>
								<input type="text" name="korek_nama" id="korek_nama" value="<?= $row->korek_nama;?>" class="mandatory" size="40" readonly="true" >
								</td>
						</tr>
						<tr>
							<td class="key">Dasar Pengenaan
								<div id="detailSelf"></div>
							</td>
							<td>
			          			<input type="text" name="spt_nilai" id="spt_nilai" value="<?= format_currency($row->spt_dt_jumlah); ?>" class="inputbox" size="25" <?= $js;?> onfocus="this.value=unformatCurrency(this.value);" onkeyup="getPajak('spt_pajak','spt_nilai','korek_persen_tarif');"
								onblur="getPajak('spt_pajak','spt_nilai','korek_persen_tarif');this.value=formatCurrency(this.value);" style="text-align:right;"/>
								Persen Tarif : <input type="text" name="korek_persen_tarif" id="korek_persen_tarif" value="<?= $row->spt_dt_persen_tarif;?>" class="inputbox" size="5" readonly="true"/> %
							</td>
						</tr>
						<tr>
							<td class="key">Pajak Terhutang</td>
							<td>
								<input type="text" name="spt_pajak" id="spt_pajak" value="<?= format_currency($row->spt_pajak); ?>" class="inputbox" size="20" readonly="true"  style="font-weight:bold;font-size:25px;color:#18F518;background-color:black;text-align:right;"/>
							</td>
						</tr>
					</table>
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
	GLOBAL_PAJAK_HOTEL_VARS["get_rekening"] = "rekening/popup_rekening";
	GLOBAL_PAJAK_HOTEL_VARS["update_pajak"] = "<?=base_url();?>pendataan/pajak_hotel/update";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/edit_pajak_hotel.js"></script>