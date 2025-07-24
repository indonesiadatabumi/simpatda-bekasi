<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar" id="top">
				<tr>					
					<td class="button">
						<a href="#" class="toolbar" id="btn_simpan">
							<span class="icon-32-save" title="Simpan"></span>
							Simpan
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-sand_watch">
			Konfigurasi Jatuh Tempo
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
			<form id="frm_jatuh_tempo" name="frm_jatuh_tempo">
				<table class="admintable">
					<tr>
						<td class="key">Jumlah HARI Jatuh Tempo *</td>
						<td>
							<input type="text" name="ref_jatem" id="ref_jatem" class="inputbox mandatory" value="<?= $row->ref_jatem; ?>" size="2" maxlength="2" onKeypress = "return numbersonly(this, event)" />
						</td>
					</tr>
					<tr>
						<td class="key">TANGGAL Jatuh Tempo BAYAR Self Assesment</td>
						<td>
							<input type="text" name="ref_jatem_batas_bayar_self" id="ref_jatem_batas_bayar_self" class="inputbox" value="<?= $row->ref_jatem_batas_bayar_self; ?>" size="2" maxlength="2" onKeypress = "return numbersonly(this, event)" />
						</td>
					</tr>
					<tr>
						<td class="key">TANGGAL Jatuh Tempo LAPOR Self Assesment</td>
						<td>
							<input type="text" name="ref_jatem_batas_lapor_self" id="ref_jatem_batas_lapor_self" class="inputbox" value="<?= $row->ref_jatem_batas_lapor_self; ?>" size="2" maxlength="2" onKeypress = "return numbersonly(this, event)" />
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/view_jatuh_tempo.js"></script>
	