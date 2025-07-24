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
						<span class="icon-32-save" title="Save">
						</span>
						Update
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
		<div class="header icon-48-pendaftaran_bu">
			Form Pendaftaran WP Badan Usaha: <small><small id='title_head'>[ Edit ]</small></small>
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
		<form method="post" name="frm_edit_calon_wp" id="frm_edit_calon_wp" >
		<input type="hidden" name="wp_wr_jenis" value="p"/>
		<input type="hidden" name="wp_wr_id" value="<?= $row->wp_wr_id;?>"/>
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
											<input type="text" size="9" maxlength="7" class="mandatory" id="wp_wr_no_urut" name="wp_wr_no_urut" readonly="true" value="<?=$row->wp_wr_no_urut;?>" />
											<!-- <a href="#" id="txt_next_nomor">[refresh]</a> -->
											<input type="hidden" name="wp_wr_gol" value="1" />
										</td>
									</tr>
									<tr>
										<td class="key"><label for="nama_wp">Nama WP</label></td>
										<td>
											<input style="text-transform: uppercase;" type="text" name="wp_wr_nama" id="wp_wr_nama" value="<?=$row->wp_wr_nama;?>" class="inputbox mandatory" size="40" />
										</td>
									</tr>
									<tr>
										<td class="key" valign="top"><label for="alamat">Alamat</label></td>
										<td>
											<textarea style="text-transform: uppercase;" cols="30" rows="2" name="wp_wr_almt" id="wp_wr_almt" class="inputbox mandatory"><?=$row->wp_wr_almt;?></textarea>
										</td>
									</tr>
									<tr>
										<td valign="top" class="key"><label for="gid">Kecamatan</label></td>
										<td>
											<?php
												$attributes = 'id="wp_wr_kd_camat" class="inputbox mandatory"';
												echo form_dropdown('wp_wr_kd_camat', $kecamatan, $row->wp_wr_kd_camat.'|'.$row->wp_wr_camat, $attributes);
											?>
										</td>
									</tr>
									<tr>
										<td class="key"><label for="lbl_kelurahan">Kelurahan</label></td>
										<td>
											<?php
												$attributes = 'id="wp_wr_kd_lurah" class="inputbox"';
												echo form_dropdown('wp_wr_kd_lurah', $kelurahan, $row->wp_wr_kd_lurah.'|'.$row->wp_wr_lurah, $attributes);
											?>
										</td>
									</tr>
									<tr>
										<td class="key">Kabupaten/Kota</td>
										<td>
											<input type="text" style="text-transform: uppercase;" name="wp_wr_kabupaten" id="wp_wr_kabupaten" readonly="true" value="<?= $row->wp_wr_kabupaten;?>" class="inputbox" size="40" />
										</td>
									</tr>
									<tr>
										<td class="key">No. Telp</td>
										<td>
											<input type="text" name="wp_wr_telp" id="wp_wr_telp" value="<?= $row->wp_wr_telp;?>" class="inputbox" size="40" />
										</td>
									</tr>
									<tr>
										<td class="key">Kodepos</td>
										<td>
											<input type="text" name="wp_wr_kodepos" id="wp_wr_kodepos" value="<?= $row->wp_wr_kodepos;?>" class="inputbox" size="5" maxlength="5" />
										</td>
									</tr>
									<tr>
										<td class="key">NIB</td>
										<td>
											<input type="text" name="wp_wr_nib" id="wp_wr_nib" class="inputbox" size="40" value="<?= $row->wp_wr_nib;?>"/>
										</td>
									</tr>
									<tr>
										<td class="key">NPWP Perusahaan</td>
										<td>
											<input type="text" name="wp_wr_npwp_perusahaan" id="wp_wr_npwp_perusahaan" class="inputbox" size="40" value="<?= $row->wp_wr_npwp_perusahaan;?>"/>
										</td>
									</tr>
								</table>
							</td>
							<td valign="top" class="outsets">
								<table class="admintable" border=0 cellspacing="1">
									<tr>
										<td class="key_small"><label for="name">Nama Pemilik</label></td>
										<td>
											<input type="text" style="text-transform: uppercase;" name="wp_wr_nama_milik" id="wp_wr_nama_milik" value="<?= $row->wp_wr_nama_milik;?>" class="inputbox" size="40" />
										</td>
									</tr>
									<tr>
										<td class="key_small" valign="top"><label for="username">Alamat</label></td>
										<td>
											<textarea style="text-transform: uppercase;" cols="30" rows="2" name="wp_wr_almt_milik" id="wp_wr_almt_milik" class="inputbox"><?=$row->wp_wr_almt_milik;?></textarea>
										</td>
									</tr>
									<tr>
										<td class="key_small"><label for="password">Kelurahan</label></td>
										<td>
											<input style="text-transform: uppercase;" type="text" name="wp_wr_lurah_milik" value="<?= $row->wp_wr_lurah_milik;?>" id="wp_wr_lurah_milik" class="inputbox" size="30"  />
										</td>
									</tr>
									<tr>
										<td valign="top" class="key_small"><label for="gid">Kecamatan</label></td>
										<td>
											<input style="text-transform: uppercase;" type="text" name="wp_wr_camat_milik" id="wp_wr_camat_milik" value="<?= $row->wp_wr_camat_milik;?>" class="inputbox" size="30" />
										</td>
									</tr>
									<tr>
										<td class="key_small">Kabupaten/Kota</td>
										<td>											
											<input style="text-transform: uppercase;" type="text" name="wp_wr_kabupaten_milik" id="wp_wr_kabupaten_milik" value="<?= $row->wp_wr_kabupaten_milik;?>" class="inputbox" size="40" />
										</td>
									</tr>
									<tr>
										<td class="key_small">No. Telp</td>
										<td>
											<input type="text" name="wp_wr_telp_milik" id="wp_wr_telp_milik" value="<?= $row->wp_wr_telp_milik;?>" class="inputbox" size="40" autocomplete="off" />
										</td>
									</tr>
									<tr>
										<td class="key_small">Kodepos</td>
										<td>
											<input type="text" name="wp_wr_kodepos_milik" id="wp_wr_kodepos_milik" value="<?= $row->wp_wr_kodepos_milik;?>" class="inputbox" size="5" autocomplete="off" maxlength="5" />
										</td>
									</tr>
									<tr>
										<td class="key">NIK</td>
										<td>
											<input type="text" name="wp_wr_nik" id="wp_wr_nik" class="inputbox mandatory" size="40" value="<?= $row->wp_wr_nik?>"/>
										</td>
									</tr>
									<tr>
										<td class="key">NPWP Pemilik</td>
										<td>
											<input type="text" name="wp_wr_npwp_pemilik" id="wp_wr_npwp_pemilik" class="inputbox" size="40" value="<?= $row->wp_wr_npwp_pemilik;?>"/>
										</td>
									</tr>
									<tr>
										<td class="key">Omset Per Bulan</td>
										<td>
											<input type="text" name="omset" id="omset" class="inputbox" size="11" value="<?= $row->omset;?>"/>
										</td>
									</tr>
								</table>
							</td>
							<td valign="top">
								<table class="admintable" border=0 cellspacing="1">
									<tr>
										<td class="key" >Tgl Diterima WP</td>
										<td width="100px">
											<input type="text" name="wp_wr_tgl_terima_form" id="f_date_a" value="<?= date_format(date_create($row->wp_wr_tgl_terima_form), 'd-m-Y');?>" size="10" class="mandatory" />
										</td>
									</tr>
									</tr>
										<tr>
										<td class="key">Tgl Batas Kirim</td>
										<td>
											<input type="text" name="wp_wr_tgl_bts_kirim" id="f_date_b" value="<?= date_format(date_create($row->wp_wr_tgl_bts_kirim), 'd-m-Y');?>" size="10" class="mandatory" />
										</td>
									</tr>
									<tr>
										<td class="key">Tgl Pendaftaran</td>
										<td>
										<input type="text" name="wp_wr_tgl_kartu" id="f_date_c" value="<?= date_format(date_create($row->wp_wr_tgl_kartu), 'd-m-Y');?>" size="10" class="mandatory" />
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
													if ($key == $row->wp_wr_bidang_usaha) {
														echo '<input type="radio" name="bidus" value="'.$key.'" checked="checked" />'.$value.'<br />';
													} else {
														echo '<input type="radio" name="bidus" value="'.$key.'" />'.$value.'<br />';
													}
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
	var GLOBAL_CALON_WP_VARS = new Array ();
	GLOBAL_CALON_WP_VARS["get_next_number_calon_wp"] = "<?= base_url();?>common/get_next_number_calon_wp";
	GLOBAL_CALON_WP_VARS["view_calon_wp"] = "<?=base_url();?>pendaftaran/calon_wp/view";
	GLOBAL_CALON_WP_VARS["add_calon_wp"] = "<?=base_url();?>pendaftaran/calon_wp/add";
	GLOBAL_CALON_WP_VARS["update_calon_wp"] = "<?=base_url();?>pendaftaran/calon_wp/update";
</script>
<script type="text/javascript" src="modules/pendaftaran/scripts/edit_calon_wp.js"></script>