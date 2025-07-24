<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar" id="top">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" class="toolbar" id="btn_add_target">
							<span class="icon-32-new" title="New"></span>
							Baru
						</a>
					</td>
					<td class="button" id="toolbar-edit">
						<a href="#" class="toolbar" id="btn_edit_target">
							<span class="icon-32-edit" title="Edit"></span>
							Edit
						</a>
					</td>
					<td class="button" id="toolbar-delete">
						<a href="#" class="toolbar" id="btn_delete_target">
							<span class="icon-32-delete" title="Delete"></span>
							Hapus
						</a>
					</td>
					
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_close_target">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-master">
			<?= $title; ?>
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
		<table id="target_anggaran_table"></table>
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
					<legend>Form Target Anggaran</legend>
						<?php
							$js = 'onKeypress = "return numbersonly(this, event)"';
							
							$attributes = array('id' => 'frm_target_anggaran');
							$hidden = array(
											'mode' => 'add', 
											'tahangdet_id_header' => $tahangdet_id_header,
											'tahangdet_id' => ""
										);
							echo form_open('frm_target_anggaran', $attributes, $hidden);
							?>
							<table class="admintable" cellspacing="1" id="editor">
								<tr>
									<td class="key">
										<label for="name">Kode Rekening</label>
									</td>
									<td>										
										<?php
											$attributes = 'id="tahangdet_id_rek" class="inputbox mandatory"';
											echo form_dropdown('tahangdet_id_rek', $kode_rekening, '', $attributes);
										?>
									</td>
								</tr>
								<tr>
									<td class="key">
										<label for="name">Jumlah Target</label>
									</td>
									<td>										
										<input type="text" name="tahangdet_jumlah" id="tahangdet_jumlah" class="inputbox mandatory" size="30" value="" 
										onfocus="this.value=unformatCurrency(this.value);" onblur="this.value=formatCurrency(this.value);" <?=$js;?> style="text-align:right;" />
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<input type="button" id="btn_target_save" name="btn_target_save" value="Simpan" class="button">
										&nbsp;&nbsp;&nbsp;
										<input type="button" id="btn_target_reset" name="btn_target_reset" value="Reset" class="button">
									</td>
								</tr>
							</table>
						<?=	form_close(); ?>
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
	var GLOBAL_TARGET_ANGGARAN_VARS = new Array();
	GLOBAL_TARGET_ANGGARAN_VARS["get_list"] = "<?=base_url();?>pemeliharaan/target_anggaran/get_list";
	GLOBAL_TARGET_ANGGARAN_VARS["add"] = "<?=base_url();?>pemeliharaan/target_anggaran/add";
	GLOBAL_TARGET_ANGGARAN_VARS["edit"] = "<?=base_url();?>pemeliharaan/target_anggaran/edit";
</script>
<script type="text/javascript" src="modules/pemeliharaan/scripts/view_target_anggaran.js"></script>