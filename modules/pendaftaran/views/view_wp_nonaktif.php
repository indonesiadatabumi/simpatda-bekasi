<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div id="toolbar" class="toolbar">
			<table class="toolbar">
				<tr>
					<td id="toolbar-save" class="button">
						<a class="toolbar" href="#" id="btn_change">
							<span class="icon-32-save" title="Ubah Status Aktif"></span>Ubah Status Aktif
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-pendaftaran_bu">
			Tabel Data WP Non Aktif
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
		<table id="wp_nonaktif_table" style="display:none"></table>
		<input type="hidden" name="id" value="" />
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<div id="confirmation_status" title="Konfirmasi" style="display: none;">
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		Apakah anda yakin untuk mengubah status ?
	</p>
</div>

<script type="text/javascript">
	var GLOBAL_WP_NONAKTIF_VARS = new Array ();
	GLOBAL_WP_NONAKTIF_VARS["get_list"] = "<?=base_url();?>wajib_pajak/get_list_wp_nonaktif?sqtype=&squery=";
</script>
<script type="text/javascript" src="modules/pendaftaran/scripts/view_wp_nonaktif.js"></script>