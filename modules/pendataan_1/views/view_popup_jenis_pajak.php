<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-default">
						<a href="#" id="btn_pilih_pajak" class="toolbar">
							<span class="icon-32-default" title="Default"></span>
							Pilih
						</a>
					</td>
					
					<td class="button" id="toolbar-help">
						<a href="#" id="btn_popup_close" class="toolbar">
							<span class="icon-32-close" title="Batal"></span>
							Batal
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-menulist">
			Pilihan Jenis Pajak 
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
		<form>		
			<table class="adminlist">
			<thead>
			<tr>
				<th width="20">#</th>
				<th width="30">&nbsp;</th>
				<th class="title">Keterangan</th>
			</tr>
			</thead>

			<tfoot>
			<tr>
				<td colspan="8">
					<del class="container">
						<div class="pagination">
							<div class="limit"></div>
							<input type="hidden" name="limitstart" value="0" />
						</div>
					</del>				
				</td>
			</tr>
			</tfoot>
			<?php
			$counter = 1;
			foreach ($jenis_pajak as $key => $value) {
			?>
			<tbody id="tbl_menu">
				<tr class="row0">
					<td width="20">
						<?= $counter; ?>
					</td>

					<td width="20">
						<input type="radio" name="cid[]" onclick="setJenisPajak('<?= $key; ?>');" value="<?= $key; ?>" />
					</td>
					<td>
						<a href="#" style="font-size: 12px;" onclick="loadForm('<?= $key; ?>');"><?= $value; ?></a>
					</td>
				</tr>
			</tbody>
			<?php
			$counter++;
			}
			?>
		</table>
		<input type="hidden" name="boxchecked" value="" />
		</form>
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
function showFormJenisPajak(idRefJenisPajak) {
	$("#content_panel").html(GLOBAL_MAIN_VARS["progress_indicator"]);
	if (idRefJenisPajak == "1")
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_hotel/add");
	else if (idRefJenisPajak == "2")
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_restoran/add");
	else if (idRefJenisPajak == "3")
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_hiburan/add");
	else if (idRefJenisPajak == "4")
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_reklame/add");
	else if (idRefJenisPajak == "5")
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_genset/add");
	else if (idRefJenisPajak == "6")
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_pln/add");
	else if (idRefJenisPajak == "7")
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_parkir/add");
	else if (idRefJenisPajak == "8")
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_air_bawah_tanah/add");
	else if (idRefJenisPajak == "9")
		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_sarang_walet/add");
};

function loadForm(idRefJenisPajak) {
	if (idRefJenisPajak != "") {
		showFormJenisPajak(idRefJenisPajak);
	}
	$('#div_dialog_box').dialog('close');
};

function setJenisPajak(idRefJenisPajak) {
	$('input[name=boxchecked]').val(idRefJenisPajak);
};

$(document).ready(function() {
	$("#btn_pilih_pajak").click(function() {
		loadForm($('input[name=boxchecked]').val());
	});

	$("#btn_popup_close").click(function() {
		$('#div_dialog_box').dialog('close');
	});
	
	$('#link_jenis_pajak').click(function() {
		loadForm($(this).attr('value'));
	});
});
</script>