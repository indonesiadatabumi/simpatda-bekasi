
<div id="toolbar-box">
	<div class="t">
		<div class="t">
			<div class="t"></div>
		</div>
	</div>
	
	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
			<tr>
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
			</tr>
			</table>
		</div>

		<div class="header icon-48-master">
			Tabel Nilai Kelas Jalan
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
				<table id="tbl_nilai_kelas_jalan" ></table>
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

<div id="form_status_anggaran" style="display:none;"></div>

<script type="text/javascript">
	var GLOBAL_NILAI_KELAS_JALAN_VARS = new Array();
	GLOBAL_NILAI_KELAS_JALAN_VARS["get_list"] = "<?=base_url();?>pemeliharaan/nilai_kelas_jalan/get_list";
	GLOBAL_NILAI_KELAS_JALAN_VARS["add"] = "pemeliharaan/nilai_kelas_jalan/add";
	GLOBAL_NILAI_KELAS_JALAN_VARS["edit"] = "pemeliharaan/nilai_kelas_jalan/edit";
	GLOBAL_NILAI_KELAS_JALAN_VARS["delete"] = "<?=base_url();?>pemeliharaan/nilai_kelas_jalan/delete";
</script>
<script type="text/javascript" src="modules/pemeliharaan/scripts/view_nilai_kelas_jalan.js"></script>
