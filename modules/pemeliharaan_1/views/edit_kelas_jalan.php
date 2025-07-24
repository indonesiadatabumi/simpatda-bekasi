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
			Kelas Jalan : <small><small id='title_head'>[ Baru ]</small></small>
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
			<form id="frm_edit_kelas_jalan" name="frm_edit_kelas_jalan">
				<input type="hidden" name="ref_rkj_id" value="<?= $row->ref_rkj_id; ?>">
				<table class="admintable">
					<tr>
						<td class="key">Kode Kelas Jalan</td>
						<td>
							<input type="text" name="ref_rkj_kode" id="ref_rkj_kode" value="<?= $row->ref_rkj_kode; ?>" class="inputbox mandatory" size="2" maxlength="2" />
						</td>
					</tr>
					<tr>
						<td class="key">Nama Kelas Jalan</td>
						<td>
							<input type="text" name="ref_rkj_nama" id="ref_rkj_nama" value="<?= $row->ref_rkj_nama; ?>" class="inputbox mandatory" size="40"  />
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/edit_kelas_jalan.js"></script>
	