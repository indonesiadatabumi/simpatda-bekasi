<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" class="toolbar" id="btn_add">
							<span class="icon-32-new" title="Baru"></span>Baru
						</a>
					</td>
					<!-- 
					<td class="button" id="toolbar-edit">
						<a href="#" class="toolbar" id="btn_edit">
							<span class="icon-32-edit" title="Edit"></span>Edit
						</a>
					</td>
					 -->
					<td class="button" id="toolbar-delete">
						<a href="#" class="toolbar" id="btn_delete">
							<span class="icon-32-delete" title="Hapus"></span>
							Hapus
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-setoran_bank">
			DAFTAR SURAT TANDA SETORAN
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
		<div class="col">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top">
						<form id="frm_view_sts">
						<table class="admintable">
							<tr>
								<td>
									<table>
										<tr>
											<td class="key">
												<label for="password">Tanggal STS</label>
											</td>
											<td>									
												<input type="text" name="fDate" id="fDate" size="11" class="mandatory" />
												S / D
												<input type="text" name="tDate" id="tDate" size="11" class="mandatory" />
											</td>
										</tr>							
									</table>
								</td>	
								<td class="button" id="toolbar-new" valign="top">
									<input type="button" id="btn_cari" name="btn_cari" value="Cari">&nbsp;
									<input type="button" id="btn_cetak" name="btn_cetak" value="Cetak Excel">
									<input type="button" id="btn_reset" name="btn_reset" value="Reset">
								</td>					
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
			
			<table>
				<tr>
					<td>						
						<table id="sts_table" style="display:none"></table>
						<input type="hidden" name="id" value="" />
					</td>
				</tr>
			</table>
		</div>
	
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
	var GLOBAL_VIEW_STS_VARS = new Array ();
	GLOBAL_VIEW_STS_VARS["get_list"] = "<?=base_url();?>bkp/sts/get_list";
	GLOBAL_VIEW_STS_VARS["cetak"] = "<?=base_url();?>bkp/sts/cetak_sts";
	GLOBAL_VIEW_STS_VARS["add"] = "<?=base_url();?>bkp/setor_bank";
	GLOBAL_VIEW_STS_VARS["edit"] = "<?=base_url();?>bkp/sts/edit";
	GLOBAL_VIEW_STS_VARS["delete"] = "<?=base_url();?>bkp/sts/delete";
	GLOBAL_VIEW_STS_VARS["validasi"] = "<?=base_url();?>bkp/sts/validasi";
	GLOBAL_VIEW_STS_VARS["search"] = "<?=base_url();?>bkp/sts/search";
	GLOBAL_VIEW_STS_VARS["cetak_daftar"] = "<?=base_url();?>bkp/sts/cetak_daftar";
</script>
<script type="text/javascript" src="modules/bkp/scripts/view_sts.js"></script>