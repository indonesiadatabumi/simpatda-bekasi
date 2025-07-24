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
						<span class="icon-32-save" title="Simpan"></span>
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
		<div class="header icon-48-penetapan">
			Rekam STPD Sanksi Administrasi: <small><small id='title_head'>[ Baru ]</small></small>
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
		
		$attributes = array('id' => 'frm_add_stpd');
		$hidden = array('setorpajret_id' => '');
		echo form_open('frm_add_stpd', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top" class="outsets">
						<table class="admintable">
							<tr>
								<td class="key">
									Masa Pajak
								</td>
								<td>
									<?php
										$attributes = 'id="bulan_realisasi" class="inputbox"';
										echo form_dropdown('bulan_realisasi', get_month(), date("n"), $attributes);
									?>
									<?php
										$attributes = 'id="tahun_realisasi" class="inputbox"';
										echo form_dropdown('tahun_realisasi', $tahun_pajak, date("Y"), $attributes);
									?>
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="password">Jenis Pajak</label>
								</td>
								<td>									
									<?php
										$attributes = 'id="jenis_pajak" class="inputbox mandatory"';
										echo form_dropdown('jenis_pajak', $objek_pajak, '', $attributes);
									?>
								</td>
							</tr>
							<tr>
								<td class="key"><label for="name">No. Reg STPD</label></td>
								<td>
									<input type="text" name="stpd_nomor" id="stpd_nomor" class="inputbox mandatory" <?= $js; ?> size="7" maxlength="6" /> 
									<a href="#" onclick="getNextNomor();">[refresh]
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="password">Tanggal Proses</label>
								</td>
								<td>
									<input type="text" name="tgl_proses" id="tgl_proses" class="mandatory" size="11" />
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="password">Periode</label>
								</td>
								<td>
									<input type="text" name="periode" id="periode" class="inputbox mandatory" size="4" maxlength="4" value="<?= date('Y');?>" />
								</td>
							</tr>							
							<tr>
								<td width="150" class="key">
									<label for="name">Rekening Jenis Pajak</label>
								</td>
								<td>
									<input type="hidden" name="spt_kode_rek" id="spt_kode_rek">
									<input type="text" name="korek" id="korek" class="inputbox rekening" size="10"/>
									Jenis
									<input type="text" name="korek_rincian" id="korek_rincian" class="inputbox rekening" size="2" maxlength="2" />
									Klas
									<input type="text" name="korek_sub1" id="korek_sub1" class="inputbox rekening" size="2" maxlength="2" />
									<input type="button" id="trigger_rek" size="2" value="..." class="button">
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">Nama  Rekening</label>
								</td>
								<td>
									<input type="text" name="korek_nama" id="korek_nama" class="mandatory" size="40" readonly="true">
									</td>
							</tr>												
						</table>
					</td>
					<td valign="top">
						<table class="admintable" border=0 cellspacing="1">							
							<tr>
								<td class="key">
									<label for="password">Nomor SPT/Kohir</label>
								</td>
								<td>
									<input type="text" name="spt_nomor" id="spt_nomor" class="inputbox mandatory" size="8"/> 
									<input type="button" id="trigger_spt1" size="2" value="..." class="button" >
								</td>
							</tr>						
							<tr>
								<td class="key">
									<label for="password">NPWPD</label>
								</td>
								<td>
									<input type="hidden" name="wp_wr_id" id="wp_wr_id">
									<input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="inputbox" size="1" maxlength="1" value="">
									<input type="text" name="wp_wr_golongan" id="wp_wr_golongan" class="inputbox npwpd" size="1" maxlength="1"/>
									<input type="text" name="wp_wr_jenis_pajak" id="wp_wr_jenis_pajak" class="inputbox npwpd" size="2" maxlength="2"/>
									<input type="text" name="wp_wr_no_registrasi" id="wp_wr_no_registrasi" class="inputbox npwpd" size="7" maxlength="7"/>
									<input type="text" name="wp_wr_kode_camat" id="wp_wr_kode_camat" class="inputbox npwpd" size="2" maxlength="2"/>
									<input type="text" name="wp_wr_kode_lurah" id="wp_wr_kode_lurah" class="inputbox npwpd" size="2" maxlength="2"/>
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">Nama WP</label>
								</td>
								<td>
								<input type="text" name="wp_wr_nama" id="wp_wr_nama" class="inputbox mandatory" size="40"style="text-transform: uppercase;" />
							</tr>
							<tr>
								<td class="key" valign="top">
									<label for="username">Alamat</label>
								</td>
								<td>		
									<textarea cols="40" rows="2" name="wp_wr_almt" id="wp_wr_almt" class="inputbox mandatory"style="text-transform: uppercase;"></textarea>
								</td>
							</tr>						
							<tr>
								<td valign="top" class="key">
									<label for="gid">Masa Pajak</label>
				
								</td>
								<td>
									<input type="text" name="setorpajret_periode_jual1" id="setorpajret_periode_jual1" size="11"class="mandatory" />
									S / D
									<input type="text" name="setorpajret_periode_jual2" id="setorpajret_periode_jual2" size="11"class="mandatory" />
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="password2">Jatuh Tempo Laporan</label>
						
								</td>
								<td>
									<input type="text" name="setorpajret_jatuh_tempo" id="setorpajret_jatuh_tempo" size="11"/>
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="password2">Tanggal Lapor</label>
						
								</td>
								<td>
									<input type="text" name="setorpajret_tgl_bayar" id="setorpajret_tgl_bayar" class="inputbox mandatory" size="11"/>
								</td>
							</tr>
							<tr>
								<td class="key">Jumlah Setoran</td>
								<td>
									<input type="text" name="setorpajret_jlh_bayar" id="setorpajret_jlh_bayar" class="inputbox mandatory" size="20" style="font-weight:bold;text-align:right;"/>
								</td>
							</tr>
							<tr>
								<td class="key">Sanksi Administrasi</td>
								<td>
									<input type="hidden" name="bulan_pengenaan" id="bulan_pengenaan" class="inputbox mandatory" value="1" size="3"/>
									<!-- <input type="text" name="bunga" id="bunga" class="mandatory"size="2" value="<?= $this->config->item('bunga');?>"/> % -->
									<input type="text" name="bunga" id="bunga" class="mandatory"size="15" />
								</td>
							</tr>
							<tr>
								<td class="key">Pajak Terhutang</td>
								<td>
									<input type="text" name="spt_pajak" id="spt_pajak" class="inputbox mandatory" size="20" style="font-weight:bold;font-size:25px;color:#18F518;background-color:black;text-align:right;"/>
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
<script type="text/javascript" src="modules/penagihan/scripts/add_stpd_pelaporan.js"></script>
	