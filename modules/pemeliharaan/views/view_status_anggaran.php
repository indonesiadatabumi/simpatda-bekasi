<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar" id="top">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" class="toolbar" id="btn_add_status_anggaran">
							<span class="icon-32-new" title="Baru"></span>Baru
						</a>
					</td>
					
					<td class="button" id="toolbar-delete">
						<a href="#" class="toolbar" id="btn_delete_status_anggaran">
							<span class="icon-32-delete" title="Hapus"></span>
							Hapus
						</a>
					</td>
					
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_close_status_anggaran">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-popup">
			Status Anggaran
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
		<table id="status_anggaran_table"></table>
		<input type="hidden" name="id_status_anggaran" value="" />
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<div id="footer">
	<p class="copyright"></p>
</div>

<!--<div id="content-box">-->
<div class="border">
	<div class="padding">
		<div id="element-box">
			<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
			</div>
			<div class="m">
				<div class="col">
					<fieldset class="adminform">
					<legend>Form Status Anggaran</legend>
						<form id="frm_status_anggaran" name="frm_status_anggaran">
							<table class="admintable" cellspacing="1" id="editor">
								<tr>
									<td class="key">
										<label for="name">Status Anggaran</label>
									</td>
									<td>
										<input type="hidden" name="mode" value="add" />
										<input type="hidden" name="ref_statang_id" value="" />
										<input type="text" name="ref_statang_ket" id="ref_statang_ket" class="inputbox mandatory" size="70" value="" />
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<input type="button" id="btn_status_save" name="btn_status_save" value="Simpan" class="button">
										&nbsp;&nbsp;&nbsp;
										<input type="button" id="btn_status_reset" name="btn_status_reset" value="Reset" class="button">
									</td>
								</tr>
							</table>
						</form>
					</fieldset>
				</div>
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>

				</div>
			</div>
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
	var GLOBAL_STATUS_ANGGARAN_VARS = new Array();
	GLOBAL_STATUS_ANGGARAN_VARS["get_list"] = "<?=base_url();?>pemeliharaan/status_anggaran/get_list";
	GLOBAL_STATUS_ANGGARAN_VARS["add"] = "<?=base_url();?>pemeliharaan/status_anggaran/add";
	GLOBAL_STATUS_ANGGARAN_VARS["edit"] = "<?=base_url();?>pemeliharaan/status_anggaran/edit";
</script>
<script type="text/javascript" src="modules/pemeliharaan/scripts/view_status_anggaran.js"></script>