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
			Pilihan Formulir SPTPD
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
		<table id="popup_nota_spt_table" style="display:none"></table>
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var GLOBAL_POPUP_NOTA_SPT_VARS = new Array ();
	GLOBAL_POPUP_NOTA_SPT_VARS["mode"] = "<?= $_GET['mode']; ?>";
	GLOBAL_POPUP_NOTA_SPT_VARS["get_list_data"] = "<?= $flexigrid_url;?>";
</script>
<script type="text/javascript" src="modules/penetapan/scripts/popup_nota_spt.js"></script>