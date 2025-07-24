<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" class="toolbar" id="btn_add">
							<span class="icon-32-new" title="Baru"></span>Baru
						</a>
					</td>
					<td class="button" id="toolbar-edit">
						<a href="#" class="toolbar" id="btn_edit">
							<span class="icon-32-edit" title="Edit"></span>Edit
						</a>
					</td>
					<td class="button" id="toolbar-delete">
						<a href="#" class="toolbar" id="btn_delete">
							<span class="icon-32-delete" title="Hapus"></span>
							Hapus
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-penetapan_stprd">
			Tabel Daftar STPD
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
		<table id="stpd_table" style="display:none"></table>
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
	var GLOBAL_STPD_VARS = new Array ();
	GLOBAL_STPD_VARS["get_list"] = "<?=base_url();?>penagihan/stpd/get_list";
	GLOBAL_STPD_VARS["add_stpd"] = "penagihan/stpd/add";
	GLOBAL_STPD_VARS["edit_stpd"] = "penagihan/stpd/edit";
	GLOBAL_STPD_VARS["delete_stpd"] = "<?=base_url();?>penagihan/stpd/delete";
</script>
<script type="text/javascript" src="modules/penagihan/scripts/view_stpd.js"></script>