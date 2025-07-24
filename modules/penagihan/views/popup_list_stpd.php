<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-popup-cancel">
						<a href="#" id="icon-32-close" class="toolbar">
						<span class="icon-32-close" title="Tutup"></span>
						Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-popup">
			Pilihan STPD
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
		<table id="popup_stpd_table" style="display:none"></table>
		<input type="hidden" name="periode" id="periode" value="<?= $_GET['periode']; ?>" />
		<input type="hidden" name="jenis_pajak" id="jenis_pajak" value="<?= $_GET['jenis_pajak']; ?>" />
		<input type="hidden" name="mode" id="mode" value="<?= $_GET['mode']; ?>" />
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>
<script type="text/javascript" src="modules/penagihan/scripts/popup_list_stpd.js"></script>