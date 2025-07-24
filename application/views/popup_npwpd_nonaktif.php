<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-close">
						<a href="#" id="btn_popup_cancel" class="toolbar">
						<span class="icon-32-close" title="Tutup"></span>
						Batal
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-pendaftaran_p">
			<?= $title; ?>
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
		<table id="popup_wp_table" style="display:none"></table>
		<input type="hidden" name="id" value="" />
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var GLOBAL_POPUP_NPWPD_VARS = new Array ();
	GLOBAL_POPUP_NPWPD_VARS["get_list_data"] = "<?= $flexigrid_url;?>";
</script>
<script type="text/javascript" src="assets/scripts/private/popup_npwpd_nonaktif.js"></script>