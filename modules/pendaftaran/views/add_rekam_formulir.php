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
		<div class="header icon-48-pendaftaran_bu">
			Rekam Formulir Pendaftaran: <small><small id='title_head'>[ Baru ]</small></small>
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
		<form name="frm_rekam_formulir" id="frm_rekam_formulir">
			<span id="callData"></span>
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td width="150" class="key">
						<label for="name">No. Formulir</label>
					</td>
					<td>
						<input type="text" size="10" maxlength="8" class="mandatory" id="txt_no_formulir" name="txt_no_formulir" />
						<a href="#" id="txt_next_nomor">[refresh]</a>
					</td>
				</tr>
				<tr>
					<td class="key"><label for="nama_wp">Nama</label></td>
					<td>
						<input style="text-transform: uppercase;" type="text" name="txt_nama" id="txt_nama" class="inputbox mandatory" size="40" />
					</td>
				</tr>
				<tr>
					<td class="key" valign="top"><label for="alamat">Alamat</label></td>
					<td>
						<textarea style="text-transform: uppercase;" cols="40" rows=2 name="txt_alamat" id="txt_alamat" class="inputbox mandatory"></textarea>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key"><label for="gid">Kecamatan</label></td>
					<td>
						<?php
							$attributes = 'id="txt_kode_camat" class="inputbox mandatory"';
							echo form_dropdown('txt_kode_camat', $kecamatan, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key"><label for="lbl_kelurahan">Kelurahan</label></td>
					<td>
						<?php
							$attributes = 'id="txt_kode_lurah" class="inputbox"';
							echo form_dropdown('txt_kode_lurah', $kelurahan, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key">Kabupaten/Kota</td>
					<td>
						<input type="text" style="text-transform: uppercase;" name="txt_kabupaten" id="txt_kabupaten" readonly="true" value="<?= strtoupper($kabupaten);?>" class="inputbox" size="40" />
					</td>
				</tr>
				<tr>
					<td class="key">Status</td>
					<td>
						<?php
							$attributes = 'id="ddl_status" class="inputbox"';
							echo form_dropdown('ddl_status', $status, '0', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key">Tanggal</td>
					<td>
						<input type="text" name="txt_tgl_kirim" id="txt_tgl_kirim" size="10" class="mandatory" />
					</td>
				</tr>				
			</table>
		</form>
	</div>
	<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_FORMULIR_VARS = new Array ();
	GLOBAL_FORMULIR_VARS["next_no_formulir"] = "<?= base_url();?>pendaftaran/rekam_formulir/next_no_formulir";
	GLOBAL_FORMULIR_VARS["view"] = "<?=base_url();?>pendaftaran/rekam_formulir/view/";
	GLOBAL_FORMULIR_VARS["save"] = "<?= base_url();?>pendaftaran/rekam_formulir/save/";
</script>
<script type="text/javascript" src="modules/pendaftaran/scripts/add_rekam_formulir.js"></script>