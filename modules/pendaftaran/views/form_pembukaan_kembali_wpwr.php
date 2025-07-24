<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div id="toolbar" class="toolbar">
			<table class="toolbar">
				<tr>
					<td id="toolbar-save" class="button">
						<a class="toolbar" href="#" id="btn_save">
							<span class="icon-32-save" title="Simpan"></span>Simpan
						</a>
					</td>
					<td class="button" id="toolbar-ref">
						<a href="#" id="btn_view" class="toolbar">
							<span class="icon-32-ref" title="Lihat Data"></span>Lihat WP Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-menulist">
			Form Pembukaan Kembali WP/WR
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
		<form method="post" name="frm_pembukaan" id="frm_pembukaan">
		<input type="hidden" name="task" value="add" />
		<table class="admintable">
			<tr>
				<td class="outsets" valign="top">
					<table class="admintable">
						<tr>
				<td class="key">Tgl. Pembukaan</td>
				<td>
					<input type="text" name="tgl_buka" id="f_date_buka" size="10" tabindex="1" />
				</td>
			</tr>
			<tr>
				<td class="key">NPWPD</td>
				<td>
					<input type="hidden" name="wp_wr_id" id="wp_wr_id">
					<input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="inputbox" size="1" maxlength="1" value="P" readonly="true"/>
					<input type="text" name="wp_wr_golongan" id="wp_wr_golongan" class="inputbox mandatory" size="1" maxlength="1" readonly="true" />
					<input type="text" name="wp_wr_jenis_pajak" id="wp_wr_jenis_pajak" class="inputbox mandatory" size="2" maxlength="2" readonly="true" />
					<input type="text" name="wp_wr_no_registrasi" id="wp_wr_no_registrasi" class="inputbox mandatory" size="7" maxlength="7" readonly="true" />
					<input type="text" name="wp_wr_kode_camat" id="wp_wr_kode_camat" class="inputbox mandatory" size="2" maxlength="2" readonly="true" />
					<input type="text" name="wp_wr_kode_lurah" id="wp_wr_kode_lurah" class="inputbox mandatory" size="2" maxlength="2" readonly="true" />
					<input type="button" id="btn_npwpd" size="2" value="...">
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
			<label for="gid">Kabupaten</label>
		</td>
		<td>
			<input type="text" name="wp_wr_kabupaten" id="wp_wr_kabupaten" class="inputbox" size="40" readonly="true" />
		</td>
	</tr>
			</table>
			</td>
			<td valign="top">
				<table>										
					<tr>
						<td class="key">No. Berita Acara</td>
						<td><input type="text" name="no_berita" id="no_berita" size="10" maxlength="5" /></td>
					</tr>
					<tr>
						<td class="key" valign="top">Isi Berita Acara</td>
						<td><textarea name="isi_berita" id="isi_berita" cols="40" rows="5"></textarea></td>
					</tr>
				</table>
			</td>
			</tr>
		</table>
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
	var GLOBAL_BUKA_KEMBALI_VARS = new Array ();
	GLOBAL_BUKA_KEMBALI_VARS["add_wpwr_buka_kembali"] = "<?=base_url();?>pendaftaran/pembukaan_kembali_wpwr/add";
</script>
<script type="text/javascript" src="modules/pendaftaran/scripts/form_pembukaan_kembali_wpwr.js"></script>