
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
<a href="#" onclick="javascript:hideMainMenu(); submitbutton('add')" class="toolbar">
<span class="icon-32-new" title="New">
</span>

Baru
</a>
</td>

<td class="button" id="toolbar-edit">
<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Silahkan tentukan pilihan dari daftar untuk melakukan EDIT');}else{ hideMainMenu(); submitbutton('edit')}" class="toolbar">
<span class="icon-32-edit" title="Edit">
</span>
Edit
</a>
</td>

<td class="button" id="toolbar-delete">
<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Silahkan tentukan pilihan dari daftar untuk melakukan HAPUS');}else{ 
 konfirm('remove');}" class="toolbar">
<span class="icon-32-delete" title="Delete">

</span>
Hapus
</a>
</td>

</tr></table>
</div>
				<div class="header icon-48-master">
Table Kelas Jalan

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
				<table id="kelas_jalan_table" style="display:none"></table>
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
	var GLOBAL_KELAS_JALAN_VARS = new Array ();
	GLOBAL_KELAS_JALAN_VARS["get_list"] = "<?=base_url();?>pemeliharaan/dsp_list_kelas_jalan/get_list";
	GLOBAL_KELAS_JALAN_VARS["add_stpd"] = "<?=base_url();?>pemeliharaan/dsp_list_kelas_jalan/add";
	GLOBAL_KELAS_JALAN_VARS["delete_stpd"] = "<?=base_url();?>pemeliharaan/dsp_list_kelas_jalan/delete";
</script>
<script type="text/javascript" src="modules/pemeliharaan/scripts/view_dsp_list_kelas_jalan.js"></script>