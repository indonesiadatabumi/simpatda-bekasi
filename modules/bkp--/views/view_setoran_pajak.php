<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-back">
						<a href="#" id="btn_back" class="toolbar">
							<span class="icon-32-back" title="Kembali"></span>
							Kembali
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-setoran">
			Daftar Setoran
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
		<table id="setoran_table" style="display:none"></table>
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_VIEW_SETORAN_VARS = new Array ();
	GLOBAL_VIEW_SETORAN_VARS["get_list"] = "<?=base_url();?>bkp/rekam_pajak/get_list_setoran";
	GLOBAL_VIEW_SETORAN_VARS["back"] = "<?=base_url();?>bkp/rekam_pajak/setor_pajak";
</script>
<script type="text/javascript" src="modules/bkp/scripts/view_setoran_pajak.js"></script>