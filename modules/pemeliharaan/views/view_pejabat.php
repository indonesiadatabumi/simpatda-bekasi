
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
				<!-- 
				<td class="button" id="toolbar-delete">
					<a href="#" onclick="openChildGB('Cetak Daftar Pejabat','<?//= $myself.$XFA['dsp_cetak_mstr_pejabat'];?>','win2')" style="cursor:pointer" >
						<span class="icon-32-print" title="Cetak Daftar"></span>
						Cetak Daftar
					</a>
				</td>
				 -->
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
				<td class="button" id="toolbar-ref">
					<a href="#" id="btn_jabatan" class="toolbar">
						<span class="icon-32-ref" title="Jabatan"></span>
						Daftar Jabatan
					</a>
				</td>
				<td class="button" id="toolbar-ref">
					<a href="#" id="btn_golongan" class="toolbar">
						<span class="icon-32-ref" title="Golongan"></span>
						Daftar Golongan
					</a>
				</td>

				<td class="button" id="toolbar-ref">
					<a href="#" id="btn_pangkat" class="toolbar">
					<span class="icon-32-ref" title="Pangkat"></span>
					Daftar Pangkat
					</a>
				</td>

		</tr>
		</table>
	</div>

			<div class="header icon-48-bos">
			Tabel Pejabat Daerah
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
				<form name="adminForm">
				<table id="tbl_pejabat" ></table>
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

<div id="formSelect" style="display:none;"></div>
<div id="formSelect_gol" style="display:none;"></div>
<div id="formSelect_pang" style="display:none;"></div>

<script type="text/javascript">
	var GLOBAL_MASTER_PEJABAT_VARS = new Array();
	GLOBAL_MASTER_PEJABAT_VARS["get_list"] = "<?=base_url();?>pemeliharaan/pejabat/get_list";
	GLOBAL_MASTER_PEJABAT_VARS["add"] = "pemeliharaan/pejabat/add";
	GLOBAL_MASTER_PEJABAT_VARS["edit"] = "pemeliharaan/pejabat/edit";
	GLOBAL_MASTER_PEJABAT_VARS["delete"] = "<?=base_url();?>pemeliharaan/pejabat/delete";
	GLOBAL_MASTER_PEJABAT_VARS["form_jabatan"] = "pemeliharaan/jabatan/view";
	GLOBAL_MASTER_PEJABAT_VARS["form_golongan"] = "pemeliharaan/golongan/view";
	GLOBAL_MASTER_PEJABAT_VARS["form_pangkat"] = "pemeliharaan/pangkat/view";
</script>
<script type="text/javascript" src="modules/pemeliharaan/scripts/view_pejabat.js"></script>
