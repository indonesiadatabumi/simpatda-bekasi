<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button">
						<a href="#" class="toolbar" id="btn_add">
							<span class="icon-32-new" title="Baru"></span>Baru
						</a>
					</td>
					<td class="button">
						<a href="#" class="toolbar" id="btn_delete">
							<span class="icon-32-delete" title="Hapus"></span>
							Hapus
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-penetapan">
			Tabel Daftar SKPD yang sudah ditetapkan
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
		<table id="skpd_table" style="display:none"></table>
		<input type="hidden" name="id" value="" />
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<div id="confirmation_delete" title="Konfirmasi" style="display: none;">
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		Apakah anda yakin untuk menghapus ?
	</p>
</div>

<script type="text/javascript">
	var GLOBAL_PENETAPAN_SKPD_VARS = new Array ();
	GLOBAL_PENETAPAN_SKPD_VARS["get_list"] = "<?=base_url();?>penetapan/skpd/get_list_penetapan";
	GLOBAL_PENETAPAN_SKPD_VARS["add"] = "<?=base_url();?>penetapan/skpd";
	GLOBAL_PENETAPAN_SKPD_VARS["delete"] = "<?=base_url();?>penetapan/skpd/delete";
</script>
<script type="text/javascript" src="modules/penetapan/scripts/view_skpd.js"></script>