<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar" id="top">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" class="toolbar" id="btn_add_jabatan">
							<span class="icon-32-new" title="Baru"></span>Baru
						</a>
					</td>
					
					<td class="button" id="toolbar-delete">
						<a href="#" class="toolbar" id="btn_delete_jabatan">
							<span class="icon-32-delete" title="Hapus"></span>
							Hapus
						</a>
					</td>
					
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_close_jabatan">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-popup">
			Tabel Referensi Jabatan
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
		<table id="jabatan_table"></table>
		<input type="hidden" name="id_jabatan" value="" />
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
						<td class="button" id="toolbar-save">						
							<a class="toolbar" id="btn_jab_save">
							<span class="icon-32-save" title="Save"></span>
							Simpan
							</a>
						</td>
						
						<td class="button" id="toolbar-cancel">
							<a id="btn_jab_reset" class="toolbar">
							<span class="icon-32-reload" title="Close"></span>
							Reset
							</a>
						</td>

						<td class="button" id="toolbar-new">
							<a id="btn_jab_batal" class="toolbar">
							<span class="icon-32-up" title="New"></span>
							Batal
							</a>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="header icon-48-popupAdd">
				Jabatan <!--<small><small>[ <?php if(!empty($idedit)) echo "Edit"; else echo "New"; ?> ]</small></small>-->
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
				<div class="col width-45">
					<fieldset class="adminform">
					<legend>Form Jabatan</legend>
						<form id="frm_jabatan" name="frm_jabatan">
							<table class="admintable" cellspacing="1" id="editor">
								<tr>
									<td width="150" class="key">
										<label for="name">Nama Jabatan</label>
									</td>
									<td>
										<input type="hidden" name="mode" value="add" />
										<input type="hidden" name="ref_japeda_id" value="" />
										<input type="text" name="ref_japeda_nama" id="ref_japeda_nama" class="inputbox mandatory" size="70" value="" />
									</td>
								</tr>
								<tr>
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
	var GLOBAL_JABATAN_VARS = new Array();
	GLOBAL_JABATAN_VARS["get_list"] = "<?=base_url();?>pemeliharaan/jabatan/get_list";
	GLOBAL_JABATAN_VARS["add"] = "<?=base_url();?>pemeliharaan/jabatan/add";
	GLOBAL_JABATAN_VARS["edit"] = "<?=base_url();?>pemeliharaan/jabatan/edit";
</script>
<script type="text/javascript" src="modules/pemeliharaan/scripts/view_jabatan.js"></script>