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
						<a href="#" class="toolbar" id="btn_close">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-master">
			Tahun Anggaran : <small><small id='title_head'>[ Edit ]</small></small>
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
			<legend>Detail Anggaran</legend>
			<form id="frm_edit_anggaran" name="frm_edit_anggaran">
				<input type="hidden" name="tahang_id" value="<?= $tahun_anggaran->tahang_id; ?>">
				<table class="admintable" cellspacing="1" id="editor">
					<tr>
						<td class="key">
							<label for="name">Tahun Anggaran</label>
						</td>
						<td>
							<input type="text" name="tahang_thn1" id="tahang_thn1" class="inputbox mandatory" size="10" value="<?= $tahun_anggaran->tahang_thn1; ?>" maxlength="4" /> 
							&nbsp;&nbsp;format: "YYYY"
						</td>
					</tr>
					<tr>
						<td class="key"><label for="username">Status Anggaran</label></td>
						<td>
							<?php 
								$attributes = 'id="tahang_status" class="inputbox mandatory"';
								echo form_dropdown('tahang_status', $status_anggaran, $tahun_anggaran->tahang_status, $attributes);								
							?>
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/edit_anggaran.js"></script>
	