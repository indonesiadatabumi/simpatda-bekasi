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
			Nilai Kelas Jalan : <small><small id='title_head'>[ Edit ]</small></small>
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
			<form id="frm_edit_nilai_kelas_jalan" name="frm_edit_nilai_kelas_jalan">
				<input type="hidden" name="id" value="<?= $row->id; ?>" />
				<table class="admintable">
					<tr>
						<td class="key">Kode Rekening</td>
						<td>
							<?php
								$attributes = 'id="rek_id" class="inputbox"';
								echo form_dropdown('rek_id', $rekening, $row->rek_id, $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">Kelas Jalan</td>
						<td>
							<?php
								$attributes = 'id="klas_jalan_id" class="inputbox"';
								echo form_dropdown('klas_jalan_id', $kelas_jalan, $row->klas_jalan_id, $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">Luas</td>
						<td>
							<input type="text" name="luas" id="luas" class="inputbox mandatory" value="<?= $row->luas; ?>" size="2" maxlength="2" onKeypress = "return numbersonly(this, event)" />
						</td>
					</tr>
					<tr>
						<td class="key">Jumlah</td>
						<td>
							<input type="text" name="jumlah" id="jumlah" class="inputbox mandatory" value="<?= $row->jumlah; ?>" size="2" maxlength="2" onKeypress = "return numbersonly(this, event)" />
						</td>
					</tr>
					<tr>
						<td class="key">Lama Pasang</td>
						<td>
							<input type="text" name="jangka_waktu" id="jangka_waktu" class="inputbox mandatory" value="<?= $row->jangka_waktu; ?>" size="2" maxlength="2" onKeypress = "return numbersonly(this, event)" />
						</td>
					</tr>
					<tr>
						<td class="key">Nilai</td>
						<td>
							<input type="text" name="nilai" id="nilai" class="inputbox mandatory" value="<?= format_currency($row->nilai); ?>" size="20" maxlength="10" onKeypress = "return numbersonly(this, event)" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" />
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/edit_nilai_kelas_jalan.js"></script>
	