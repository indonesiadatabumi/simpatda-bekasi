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
			Pos Anggaran : <small><small id='title_head'>[ Edit ]</small></small>
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
			<legend>Detail Pos Anggaran</legend>
			<form id="frm_edit_pos_anggaran" name="frm_edit_pos_anggaran">
				<input type="hidden" name="posang_id" value="<?= $row->posang_id; ?>">
				<table class="admintable">
					<tr>
						<td class="key">Kode Posisi</td>
						<td>
							<input type="text" name="posang_kode" id="posang_kode" class="inputbox mandatory" value="<?= $row->posang_kode; ?>" size="15" maxlength="5" />
						</td>
					</tr>
					<tr>
						<td class="key">Nama Posisi</td>
						<td>
							<input type="text" name="posang_ket" id="posang_ket" class="inputbox mandatory" value="<?= $row->posang_ket; ?>" size="40" style="text-transform: uppercase;" />
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/edit_pos_anggaran.js"></script>
	