<style>
.title_key {
	margin-left:5px;
	background-color: #FAFFF4;
	text-align: left;
	color: #274F0A;
	font-weight: bold;
	border-bottom: 1px dashed #CAD0D5;
}
</style>

<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-retribusi">
			DAFTAR TUNGGAKAN WAJIB PAJAK
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
											<td class="title_key">Periode</td>
											<td>
												<input type="text" name="periode" id="periode" size="5" value="<?= date('Y'); ?>" />
											</td>
										</tr>
										<tr>
											<td class="title_key">Jenis Pajak</td>
											<td>
												<?php
													$attributes = 'id="jenis_pajak" class="inputbox"';
													echo form_dropdown('jenis_pajak', $jenis_pajak, '1', $attributes);
												?>
											</td>
										</tr>																	
									</table>
								</td>
								<td valign="top">
									<table>
										<tr>
											<td class="title_key">Kecamatan</td>
											<td>
												<?php
													$attributes = 'id="camat_id" class="inputbox"';
													echo form_dropdown('camat_id', $kecamatan, '', $attributes);
												?>
											</td>
										</tr>
										<tr>
											<td class="title_key">
												<label for="password">Jatuh Tempo</label>
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
									<input type="button" id="btn_cari" name="btn_cari" value="Cari" class="button">&nbsp;
									<input type="button" id="btn_cetak" name="btn_cetak" value="Cetak" class="button">
									<input type="button" id="btn_reset" name="btn_reset" value="Reset" class="button">
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
						<table id="tunggakan_table" style="display:none"></table>
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
	var GLOBAL_VIEW_TUNGGAKAN_VARS = new Array ();
	GLOBAL_VIEW_TUNGGAKAN_VARS["get_list"] = "<?=base_url();?>penagihan/tunggakan/get_list";
	GLOBAL_VIEW_TUNGGAKAN_VARS["cetak"] = "<?=base_url();?>penagihan/tunggakan/cetak";
</script>
<script type="text/javascript" src="modules/penagihan/scripts/view_tunggakan.js"></script>