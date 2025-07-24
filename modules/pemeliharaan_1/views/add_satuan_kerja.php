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
			Satuan Kerja : <small><small id='title_head'>[ Baru ]</small></small>
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
			<legend>Detail Satuan Kerja</legend>
			<form id="frm_add_skpd" name="frm_add_skpd">
				<table class="admintable">
					<tr>
						<td class="key">Bidang</td>
						<td>
							<?php 
							$attributes = 'id="skpd_id_bidang" class="inputbox mandatory"';
							echo form_dropdown('skpd_id_bidang', $bidang, '', $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">Kode Unit Kerja</td>
						<td>
							<input type="text" name="skpd_kode" id="skpd_kode" class="inputbox mandatory" size="5" />
						</td>
					</tr>
					<tr>
						<td class="key">Nama Unit Kerja1</td>
						<td>
							<input type="text" name="skpd_nama" id="skpd_nama" class="inputbox mandatory" size="50" />
						</td>
					</tr>
					<tr>
						<td class="key">Nama Unit Kerja2</td>
						<td>
							<input type="text" name="skpd_nama2" id="skpd_nama2" class="inputbox" size="50" />
						</td>
					</tr>
					<tr>
						<td class="key">Singkatan</td>
						<td>
							<input type="text" name="skpd_singkatan" id="skpd_singkatan" class="inputbox" size="30" />
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/add_satuan_kerja.js"></script>
	