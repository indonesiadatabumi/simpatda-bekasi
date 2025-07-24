<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" class="toolbar" id="btn_print">
							<span class="icon-32-print" title="Cetak"></span>
							Cetak
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-print">
			Daftar Cetak NPWPD
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
		<table id="kartu_npwpd_table" style="display:none"></table>
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
	var GLOBAL_CETAK_KARTU_VARS = new Array ();
	GLOBAL_CETAK_KARTU_VARS["get_list_data"] = "<?=base_url();?>pendaftaran/cetak_kartu_npwpd/get_list?sqtype=&squery=";
	GLOBAL_CETAK_KARTU_VARS["cetak"] = "<?=base_url();?>pendaftaran/cetak_kartu_npwpd/cetak_npwpd";
</script>
<script type="text/javascript" src="modules/pendaftaran/scripts/view_cetak_kartu_npwpd.js"></script>