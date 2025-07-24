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
			KETERANGAN SPT : <small><small id='title_head'>[ Edit ]</small></small>
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
			<form id="frm_edit_keterangan_spt" name="frm_edit_keterangan_spt">
				<input type="hidden" name="ketspt_id" value="<?= $row->ketspt_id; ?>">
				<table class="admintable">
					<tr>
						<td class="key">Kode</td>
						<td>
							<input type="text" name="ketspt_kode" id="ketspt_kode" value="<?= $row->ketspt_kode; ?>" class="inputbox mandatory" maxlength="1" size="5" style="text-transform: uppercase;" />
						</td>
					</tr>
					<tr>
						<td class="key">Keterangan</td>
						<td>
							<input type="text" name="ketspt_ket" id="ketspt_ket" value="<?= $row->ketspt_ket; ?>" class="inputbox mandatory" maxlength="100" size="50" />
						</td>
					</tr>
					<tr>
						<td class="key">Singkatan</td>
						<td>
							<input type="text" name="ketspt_singkat" id="ketspt_singkat" value="<?= $row->ketspt_singkat; ?>" class="inputbox mandatory" maxlength="100" size="50" />
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/edit_keterangan_spt.js"></script>
	