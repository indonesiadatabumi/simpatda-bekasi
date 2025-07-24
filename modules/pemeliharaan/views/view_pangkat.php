<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar" id="top">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" class="toolbar" id="btn_add_pangkat">
							<span class="icon-32-new" title="Baru"></span>Baru
						</a>
					</td>
					
					<td class="button" id="toolbar-delete">
						<a href="#" class="toolbar" id="btn_delete_pangkat">
							<span class="icon-32-delete" title="Hapus"></span>
							Hapus
						</a>
					</td>
					
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_close_pangkat">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-popup">
			Tabel Referensi Pangkat
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
		<table id="pangkat_table"></table>
		<input type="hidden" name="id_pangkat" value="" />
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
							<a class="toolbar" id="btn_pangkat_save">
							<span class="icon-32-save" title="Save"></span>
							Simpan
							</a>
						</td>
						
						<td class="button" id="toolbar-cancel">
							<a id="btn_pangkat_reset" class="toolbar">
							<span class="icon-32-reload" title="Close"></span>
							Reset
							</a>
						</td>

						<td class="button" id="toolbar-new">
							<a id="btn_pangkat_batal" class="toolbar">
							<span class="icon-32-up" title="New"></span>
							Batal
							</a>
						</td>
					</tr>
				</table>
			</div>
			
			<div class="header icon-48-popupAdd">
				Pangkat <!--<small><small>[ <?php if(!empty($idedit)) echo "Edit"; else echo "New"; ?> ]</small></small>-->
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
					<legend>Form Pangkat</legend>
						<form id="frm_pangkat" name="frm_pangkat">
							<table class="admintable" cellspacing="1" id="editor">
								<tr>
									<td width="150" class="key">
										Nama Pangkat
									</td>
									<td>
										<input type="hidden" name="mode" value="add" />
										<input type="hidden" name="ref_pangpej_id" value="" />
										<input type="text" name="ref_pangpej_ket" id="ref_pangpej_ket" class="inputbox mandatory" size="70" value="" />
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
	var GLOBAL_PANGKAT_VARS = new Array();
	GLOBAL_PANGKAT_VARS["get_list"] = "<?=base_url();?>pemeliharaan/pangkat/get_list";
	GLOBAL_PANGKAT_VARS["add"] = "<?=base_url();?>pemeliharaan/pangkat/add";
	GLOBAL_PANGKAT_VARS["edit"] = "<?=base_url();?>pemeliharaan/pangkat/edit";
</script>
<script type="text/javascript" src="modules/pemeliharaan/scripts/view_pangkat.js"></script>