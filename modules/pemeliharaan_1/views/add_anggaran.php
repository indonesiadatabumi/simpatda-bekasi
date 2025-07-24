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
						<a href="#" class="toolbar" id="btn_close">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-master">
			Tahun Anggaran : <small><small id='title_head'>[ New ]</small></small>
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
			<form id="frm_add_anggaran" name="frm_add_anggaran">
				<input type="hidden" name="tahang_id" value="<?= $tahun_anggaran->tahang_id; ?>">
				<table class="admintable" cellspacing="1" id="editor">
					<tr>
						<td class="key">
							<label for="name">Tahun Anggaran</label>
						</td>
						<td>
							<input type="text" name="tahang_thn1" id="tahang_thn1" class="inputbox mandatory" size="10" value="" maxlength="4" onKeypress = "return numbersonly(this, event)" /> &nbsp;&nbsp;format: "YYYY"
						</td>
					</tr>
					<tr>
						<td class="key"><label for="username">Status Anggaran</label></td>
						<td>
							<?php 
								$attributes = 'id="tahang_status" class="inputbox mandatory"';
								echo form_dropdown('tahang_status', $status_anggaran, "", $attributes);								
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/add_anggaran.js"></script>
	