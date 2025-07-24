
			<div id="toolbar-box">
				<div class="t">
					<div class="t">
						<div class="t"></div>
					</div>
				</div>
				<div class="m">
				<div class="toolbar" id="toolbar">
					<table class="toolbar"><tr>
						<td class="button" id="toolbar-new">
							<a href="#" class="toolbar" id="btn_add">
							<span class="icon-32-new" title="New"></span>
							Baru
							</a>
						</td>
						
						<td class="button" id="toolbar-edit">
							<a href="#" class="toolbar" id="btn_edit">
							<span class="icon-32-edit" title="Edit"></span>
							Edit
							</a>
						</td>
						
						<td class="button" id="toolbar-delete">
							<a href="#" class="toolbar" id="btn_delete">
							<span class="icon-32-delete" title="Delete"></span>
							Hapus
							</a>
						</td>
						
						<td class="button" id="toolbar-new">
							<a href="#" class="toolbar" id="btn_daftar_urusan">
							<span class="icon-32-ref" title="Daftar Urusan"></span>
							Daftar Urusan
							</a>
						</td>
						
						</tr>
					</table>
				</div>

				<div class="header icon-48-master">
					Tabel Bidang
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
		 		<div class="t">
					<div class="t"></div>
		 		</div>

			</div>
			<div class="m">
				<table id="tbl_bidang" ></table>
				<input type="hidden" name="id" value="" />
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
   		</div>
		<div class="clr"></div>
	</div>

<div id="confirmation_delete" title="Konfirmasi" style="display: none;">
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		Apakah anda yakin untuk menghapus ?
	</p>
</div>

<div id="formSelect_urusan" style="display:none;"></div>

<script type="text/javascript">
	var GLOBAL_BIDANG_VARS = new Array();
	GLOBAL_BIDANG_VARS["get_list"] = "<?=base_url();?>pemeliharaan/bidang/get_list";
	GLOBAL_BIDANG_VARS["add"] = "pemeliharaan/bidang/add";
	GLOBAL_BIDANG_VARS["edit"] = "pemeliharaan/bidang/edit";
	GLOBAL_BIDANG_VARS["delete"] = "<?=base_url();?>pemeliharaan/bidang/delete";
	GLOBAL_BIDANG_VARS["form_urusan"] = "pemeliharaan/urusan/view";
</script>
<script type="text/javascript" src="modules/pemeliharaan/scripts/view_bidang.js"></script>