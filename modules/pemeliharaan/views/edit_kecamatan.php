<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar" id="top">
				<tr>					
					<td class="button">
						<a href="#" class="toolbar" id="btn_update">
							<span class="icon-32-save" title="Update"></span>
							Update
						</a>
					</td>
					
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_close_edit">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-master">
			Kecamatan : <small><small id='title_head'>[ Edit ]</small></small>
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
		<div class="col">
			<fieldset class="adminform">
			<legend>Detail Kecamatan</legend>
			<form id="frm_edit_kecamatan" name="frm_edit_kecamatan">
				<input type="hidden" name="camat_id" value="<?= $kecamatan->camat_id; ?>">
				<table class="admintable">
					<tr>
						<td class="key">Kode Kecamatan</td>
						<td>
							<input type="text" name="camat_kode" id="camat_kode" class="inputbox mandatory" value="<?= $kecamatan->camat_kode; ?>" size="2" maxlength="2" />
						</td>
					</tr>
					<tr>
						<td class="key">Nama Kecamatan</td>
						<td>
							<input type="text" name="camat_nama" id="camat_nama" class="inputbox mandatory" value="<?= $kecamatan->camat_nama; ?>" size="40" style="text-transform: uppercase;" />
						</td>
					</tr>
				</table>
			</form>
			</fieldset>
		</div>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>

		</div>
	</div>
</div>
<script type="text/javascript" src="modules/pemeliharaan/scripts/edit_kecamatan.js"></script>
	