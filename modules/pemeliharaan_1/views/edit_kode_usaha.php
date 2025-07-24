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
			Kode Usaha : <small><small id='title_head'>[ Edit ]</small></small>
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
			<legend>Detail Kode Usaha</legend>
			<form id="frm_edit_kodus" name="frm_edit_kodus">
				<input type="hidden" name="ref_kodus_id" value="<?= $row->ref_kodus_id; ?>">
				<table class="admintable">
					<tr>
						<td class="key">Kode Usaha</td>
						<td>
							<input type="text" name="ref_kodus_kode" id="ref_kodus_kode" class="inputbox mandatory" value="<?= $row->ref_kodus_kode; ?>" size="2" maxlength="2" />
						</td>
					</tr>
					<tr>
						<td class="key">Nama Kecamatan</td>
						<td>
							<input type="text" name="ref_kodus_nama" id="ref_kodus_nama" class="inputbox mandatory" value="<?= $row->ref_kodus_nama; ?>" size="40" />
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/edit_kode_usaha.js"></script>
	