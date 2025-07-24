<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>
	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button">
						<a href="#" id="btn_cetak_kartu" class="toolbar" style="display: none;">
						<span class="icon-32-print" title="Cetak Kartu NPWPD"></span>
						Cetak Kartu NPWPD 
						</a>
					</td>
					<td class="button" id="toolbar-new">
						<a href="#" id="btn_saved" class="toolbar">
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
		<div class="header icon-48-pendaftaran_bu">
			Form Pendaftaran WP Badan Usaha: <small><small id='title_head'>[ Baru ]</small></small>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<input class="inputbox" id="txt_npwpd" style="display: none;font-weight:bold;font-size:25px;color:#18F518;background-color:black;text-align:center;" />
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
		<span id="callData"></span>
		<form method="post" name="frm_add_wp_bu" id="frm_add_wp_bu" >
		<input type="hidden" name="wp_wr_jenis" value="p"/>
		<input type="hidden" name="wp_wr_id" value=""/>
		<div class="col" style="width: 100%">
			<ul class="tabs">
			    <li><a href="#tab1">IDENTITAS</a></li>
			    <li><a href="#tab2">BIDANG USAHA</a></li>
			</ul>
			
			<div class="tab_container">
   				<div id="tab1" class="tab_content">
					<table class="admintable" border=0 cellspacing="1">
						<tr>
							<td valign="top" class="outsets">
								<table class="admintable" border=0 cellspacing="1">
									<tr>
										<td width="150" class="key">
											<label for="name">No. Reg. Pendaftaran</label>
										</td>
										<td>
											<input type="text" size="9" maxlength="7" class="mandatory" id="wp_wr_no_urut" name="wp_wr_no_urut" />
											<a href="#" id="txt_next_nomor">[refresh]</a>
											<input type="hidden" name="wp_wr_gol" value="2" />
										</td>
									</tr>
									<tr>
										<td class="key"><label for="nama_wp">Nama WP</label></td>
										<td>
											<input style="text-transform: uppercase;" type="text" name="wp_wr_nama" id="wp_wr_nama" class="inputbox mandatory" size="40" />
										</td>
									</tr>
									<tr>
										<td class="key" valign="top"><label for="alamat">Alamat</label></td>
										<td>
											<textarea style="text-transform: uppercase;" cols="30" rows="2" name="wp_wr_almt" id="wp_wr_almt" class="inputbox mandatory"></textarea>
										</td>
									</tr>
									<tr>
										<td valign="top" class="key"><label for="gid">Kecamatan</label></td>
										<td>
											<?php
												$attributes = 'id="wp_wr_kd_camat" class="inputbox mandatory"';
												echo form_dropdown('wp_wr_kd_camat', $kecamatan, '', $attributes);
											?>
										</td>
									</tr>
									<tr>
										<td class="key"><label for="lbl_kelurahan">Kelurahan</label></td>
										<td>
											<?php
												$attributes = 'id="wp_wr_kd_lurah" class="inputbox mandatory"';
												echo form_dropdown('wp_wr_kd_lurah', $kelurahan, '', $attributes);
											?>
										</td>
									</tr>
									<tr>
										<td class="key">Kabupaten/Kota</td>
										<td>
											<input type="text" style="text-transform: uppercase;" name="wp_wr_kabupaten" id="wp_wr_kabupaten" readonly="true" value="<?= strtoupper($kabupaten);?>" class="inputbox" size="40" />
										</td>
									</tr>
									<tr>
										<td class="key">No. Telp</td>
										<td>
											<input type="text" name="wp_wr_telp" id="wp_wr_telp" class="inputbox" size="40" />
										</td>
									</tr>
									<tr>
										<td class="key">Kodepos</td>
										<td>
											<input type="text" name="wp_wr_kodepos" id="wp_wr_kodepos" class="inputbox" size="5" maxlength="5" />
										</td>
									</tr>
								</table>
							</td>
							<td valign="top" class="outsets">
								<table class="admintable" border=0 cellspacing="1">
									<tr>
										<td class="key_small"><label for="name">Nama Pemilik</label></td>
										<td>
											<input type="text" style="text-transform: uppercase;" name="wp_wr_nama_milik" id="wp_wr_nama_milik" class="inputbox" size="40" />
										</td>
									</tr>
									<tr>
										<td class="key_small" valign="top"><label for="username">Alamat</label></td>
										<td>
											<textarea style="text-transform: uppercase;" cols="30" rows="2" name="wp_wr_almt_milik" id="wp_wr_almt_milik" class="inputbox"></textarea>
										</td>
									</tr>
									<tr>
										<td class="key_small"><label for="password">Kelurahan</label></td>
										<td>
											<input style="text-transform: uppercase;" type="text" name="wp_wr_lurah_milik" id="wp_wr_lurah_milik" class="inputbox" size="30"  />
										</td>
									</tr>
									<tr>
										<td valign="top" class="key_small"><label for="gid">Kecamatan</label></td>
										<td>
											<input style="text-transform: uppercase;" type="text" name="wp_wr_camat_milik" id="wp_wr_camat_milik" class="inputbox" size="30" />
										</td>
									</tr>
									<tr>
										<td class="key_small">Kabupaten/Kota</td>
										<td>											
											<input style="text-transform: uppercase;" type="text" name="wp_wr_kabupaten_milik" id="wp_wr_kabupaten_milik" value="<?= strtoupper($kabupaten);?>" class="inputbox" size="40" />
										</td>
									</tr>
									<tr>
										<td class="key_small">No. Telp</td>
										<td>
											<input type="text" name="wp_wr_telp_milik" id="wp_wr_telp_milik" class="inputbox" size="40" autocomplete="off" />
										</td>
									</tr>
									<tr>
										<td class="key_small">Kodepos</td>
										<td>
											<input type="text" name="wp_wr_kodepos_milik" id="wp_wr_kodepos_milik" class="inputbox" size="5" autocomplete="off" maxlength="5" />
										</td>
									</tr>
								</table>
							</td>
							<td valign="top" >
								<table class="admintable" border=0 cellspacing="1">
									<tr>
										<td class="key" width="100px">Tgl Diterima WP</td>
										<td width="100px">
											<input type="text" name="wp_wr_tgl_terima_form" id="f_date_a" size="10" class="mandatory" />
										</td>
									</tr>
									</tr>
										<tr>
										<td class="key">Tgl Batas Kirim</td>
										<td>
											<input type="text" name="wp_wr_tgl_bts_kirim" id="f_date_b" size="10" class="mandatory" />
										</td>
									</tr>
									<tr>
										<td class="key">Tgl Pendaftaran</td>
										<td>
										<input type="text" name="wp_wr_tgl_kartu" id="f_date_c" size="10" class="mandatory" />
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
				<div id="tab2" class="tab_content">
	       			<table class="admintable" border=0 cellspacing="1" style="font-size: 12px;">	
						<tr>
							<td>
								<table>
									<tr>
										<td class="key" valign="top">Bidang Usaha</td>
										<td>
											<?php 
												foreach ($bidang_usaha as $key => $value) {
													echo '<input type="radio" name="bidus" value="'.$key.'" />'.$value.'<br />';
												}
											?>
										</td>
									</tr>
								</table>
							</td>
							<td valign="top">
								<div id="detail_usaha">
								
								</div>
							</td>
						</tr>
					</table>
			    </div>
			</div>
		</div>
		</form>
		<div class="clr"></div>
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<div id="bidus_1" style="display: none;">
	<table class="admintable">
		<tr>
			<td colspan="2" align="center"><b>Detail Hotel</b></td>
		</tr>
		<tr>
			<td class="key">Golongan Hotel</td>
			<td>
				<?php
					$attributes = 'id="gol_hotel" class="inputbox"';
					echo form_dropdown('gol_hotel', $golongan_hotel, '', $attributes);
				?>
			</td>
		</tr>
		<tr>
			<td class="key">Jumlah Kamar</td>
			<td>
				<input type="text" size="5" maxlength="5" name="txt_jumlah_kamar" onKeypress = "return numbersonly(this, event)">
			</td>
		</tr>
	</table>
</div>

<div id="bidus_16" style="display: none;">
	<table class="admintable">
		<tr>
			<td colspan="2" align="center"><b>Detail Restoran</b></td>
		</tr>
		<tr>
			<td class="key">Jenis Restoran</td>
			<td>
				<?php
					$attributes = 'id="ddl_jenis_restoran" class="inputbox"';
					echo form_dropdown('ddl_jenis_restoran', $jenis_restoran, '', $attributes);
				?>
			</td>
		</tr>
		<tr>
			<td class="key">Jumlah Meja</td>
			<td>
				<input type="text" size="5" maxlength="5" name="txt_jumlah_meja" onKeypress = "return numbersonly(this, event)">
			</td>
		</tr>
		<tr>
			<td class="key">Jumlah Kursi</td>
			<td>
				<input type="text" size="5" maxlength="5" name="txt_jumlah_kursi" onKeypress = "return numbersonly(this, event)">
			</td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	var GLOBAL_WP_BU_VARS = new Array ();
	GLOBAL_WP_BU_VARS["get_next_number_wp"] = "<?= base_url();?>common/get_next_number_wp";
	GLOBAL_WP_BU_VARS["view_wp_badan_usaha"] = "<?=base_url();?>pendaftaran/wp_badan_usaha/view/";
	GLOBAL_WP_BU_VARS["save_wp_badan_usaha"] = "<?= base_url();?>pendaftaran/wp_badan_usaha/save/";
	GLOBAL_WP_BU_VARS["cetak"] = "<?=base_url();?>pendaftaran/cetak_kartu_npwpd/cetak_npwpd";
</script>
<script type="text/javascript" src="modules/pendaftaran/scripts/add_wp_badan_usaha.js"></script>