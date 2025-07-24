<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar" id="top">
				<tr>					
					<td class="button" id="toolbar-add">
						<a href="#" class="toolbar" id="btn_insert">
							<span class="icon-32-save" title="Insert"></span>
							Simpan
						</a>
					</td>
					
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_close_add">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-master">
			Kelurahan : <small><small id='title_head'>[ Baru ]</small></small>
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
			<legend>Detail Kelurahan</legend>
			<form id="frm_add_kelurahan" name="frm_add_kelurahan">
				<table class="admintable">
					<tr>
						<td class="key">Kecamatan</td>
						<td>
							<?php 
							$attributes = 'id="lurah_kecamatan" class="inputbox mandatory"';
							echo form_dropdown('lurah_kecamatan', $kecamatan, '', $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">Kode Kelurahan</td>
						<td>
							<input type="text" name="lurah_kode" id="lurah_kode" class="inputbox mandatory" size="2" maxlength="2" />
						</td>
					</tr>
					<tr>
						<td class="key">Nama Kelurahan</td>
						<td>
							<input type="text" name="lurah_nama" id="lurah_nama" class="inputbox mandatory" size="40" style="text-transform: uppercase;" />
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/add_kelurahan.js"></script>
	