<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar" id="top">
				<tr>					
					<td class="button" id="toolbar-add">
						<a href="#" class="toolbar" id="btn_update">
							<span class="icon-32-save" title="Update"></span>
							Simpan
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
			UPTD : <small><small id='title_head'>[ Edit ]</small></small>
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
			<form id="frm_edit_uptd" name="frm_edit_uptd">
				<input type="hidden" name="uptd_id" value="<?= $row->uptd_id; ?>">
				<table class="admintable">
					<tr>
						<td class="key">Nama UPTD</td>
						<td>
							<input type="text" name="uptd_nama" id="uptd_nama" value="<?= $row->uptd_nama; ?>" class="inputbox mandatory" size="60" />
						</td>
					</tr>
					<tr>
						<td class="key">Alamat</td>
						<td>
							<input type="text" name="uptd_alamat" id="uptd_alamat" value="<?= $row->uptd_alamat; ?>" class="inputbox mandatory" size="80" />
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/edit_uptd.js"></script>
	