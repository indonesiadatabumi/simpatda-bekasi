<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>
	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
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
		<div class="header icon-48-pendaftaran_p">
			Form Pendaftaran WP Pribadi: <small><small id='title_head'>[ Baru ]</small></small>
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
		<form method="post" name="frm_add_wp_pribadi" id="frm_add_wp_pribadi" >
		<input type="hidden" name="wp_wr_jenis" value="p"/>
		<div class="col" style="width: 100%">
			<ul class="tabs">
			    <li><a href="#tab1">IDENTITAS</a></li>
			    <li><a href="#tab2">JENIS PAJAK</a></li>
			</ul>
			
			<div class="tab_container" style="min-width: 990px;">
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
										<input type="hidden" name="wp_wr_gol" value="1" size="1" maxlength="1" readonly="true"/>
										<input type="text" size="9" class="mandatory" maxlength="7" id="wp_wr_no_urut" name="wp_wr_no_urut"> 
										<a href="#" id="txt_next_nomor">[refresh]</a>
									</td>
								</tr>
								<tr>
									<td class="key"><label for="username">Nama Wajib Pajak</label></td>
									<td>
										<input type="text" name="wp_wr_nama" id="wp_wr_namas" class="inputbox mandatory" size="40" style="text-transform: uppercase;" />
									</td>
								</tr>
								<tr>
									<td class="key" valign="top">
										<label for="password">Alamat Wajib Pajak<br />(Jalan/No., RT/RW/RK)</label>
									</td>
									<td>
										<textarea cols=34 rows=3 name="wp_wr_almt" id="wp_wr_almt" class="inputbox mandatory" style="text-transform: uppercase;"></textarea>
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
									<td class="key">
										<label for="password2">Kelurahan</label>
									</td>
									<td>
										<?php
											$attributes = 'id="wp_wr_kd_lurah" class="inputbox"';
											echo form_dropdown('wp_wr_kd_lurah', $kelurahan, '', $attributes);
										?>
									</td>
								</tr>
								<tr>
									<td class="key">Kabupaten/Kota</td>
									<td>
										<input type="text" name="wp_wr_kabupaten" id="wp_wr_kabupaten" class="inputbox" size="40" value="<?= strtoupper($kabupaten);?>" readonly />
									</td>
								</tr>
								<tr>
									<td class="key">Kodepos</td>
									<td>
										<input type="text" class="inputbox" name="wp_wr_kodepos" id="wp_wr_kodepos" size="10" maxlength="5"  />
									</td>
								</tr>
								<tr>
									<td class="key">No. Telepon</td>
									<td>
										<input type="text" name="wp_wr_telp" id="wp_wr_telp" class="inputbox" size="40" autocomplete="off" />
									</td>
								</tr>
								<tr>
									<td class="key">Kewarganegaraan</td>
									<td>
										<select name="wp_wr_wn" id="wp_wr_wn" class="inputbox">
										<option value="WNI">WNI</option>
										<option value="WNA">WNA</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="key" valign="top">Tanda Bukti Diri</td>
									<td>
										<select name="wp_wr_jns_tb" id="wp_wr_jns_tb" class="inputbox">
											<option value="KTP">KTP</option>
											<option value="KTP">SIM</option>
											<option value="PASPOR">PASPOR</option>
										</select>&nbsp;&nbsp;
										No.
										<input type="text" class="inputbox" name="wp_wr_no_tb" id="wp_wr_no_tb" size="20" />&nbsp;&nbsp;Tgl. Lahir
										<input type="text" name="wp_wr_tgl_tb" id="f_date_ktp" size="10" />
									</td>
								</tr>
							</table>
						</td>
			
						<td valign="top">
							<table class="admintable" border=0 cellspacing="1">
								<tr>
									<td class="key">No. Kartu Keluarga</td>
									<td>
										<input type="text" name="wp_wr_no_kk" id="wp_wr_no_kk" class="inputbox" size="20"  />&nbsp;&nbsp;Tgl.&nbsp;
										<input type="text" name="wp_wr_tgl_kk" id="f_date_kk" size="10" />
									</td>
								</tr>
								<tr>
									<td class="key">
										Pekerjaan/Usaha</td>
									<td>
										<select class="inputbox mandatory" id="ddl_wp_wr_pekerjaan">
											<option value="">--</option>
											<option value="PEGAWAI NEGERI">PEGAWAI NEGERI</option>
											<option value="PEGAWAI SWASTA">PEGAWAI SWASTA</option>
											<option value="ABRI">ABRI</option>
											<option value="PEMILIK USAHA">PEMILIK USAHA</option>
											<option value="-">LAINNYA</option>
										</select>&nbsp;
										<input type="text" class="inputbox mandatory" name="wp_wr_pekerjaan" id ="wp_wr_pekerjaan" size="40" style="text-transform: uppercase;" />
									</td>
								</tr>
								<tr>
									<td class="key">Nama Instansi<br />Tempat Bekerja/Usaha</td>
									<td><input type="text" name="wp_wr_nm_instansi" id="wp_wr_nm_instansi" class="inputbox" size="40" style="text-transform: uppercase;" /></td>
								</tr>
								<tr>
									<td class="key" valign="top">
										<label for="password">Alamat Instansi</label>
									</td>
									<td>
										<textarea cols=34 rows=3 name="wp_wr_alm_instansi" id="wp_wr_alm_instansi" class="inputbox" style="text-transform: uppercase;"></textarea>
									</td>
								</tr>
								<tr>
									<td class="key">Tgl Form Diterima WP</td>
									<td>
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
							<td class="key" valign="top">Jenis Pajak</td>
							<td>
								<?php 
									foreach ($bidang_usaha as $key => $value) {
										echo '<input type="radio" name="bidus" value="'.$key.'" />'.$value.'<br />';
									}
								?>
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
<script type="text/javascript">
	var GLOBAL_WP_PRIBADI_VARS = new Array ();
	GLOBAL_WP_PRIBADI_VARS["get_next_number_wp"] = "<?= base_url();?>common/get_next_number_wp";
	GLOBAL_WP_PRIBADI_VARS["save_wp_pribadi"] = "<?= base_url();?>pendaftaran/wp_pribadi/save/";
	GLOBAL_WP_PRIBADI_VARS["view_wp_pribadi"] = "<?=base_url();?>pendaftaran/wp_pribadi/view/";
</script>
<script type="text/javascript" src="modules/pendaftaran/scripts/add_wp_pribadi.js"></script>