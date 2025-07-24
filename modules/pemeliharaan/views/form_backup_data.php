<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
		</div>
		<div class="header icon-48-master">
			Backup Data SPT
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
		<!-- content body -->
		<span id="callData"></span>
		<?php
		$js = 'onKeypress = "return numbersonly(this, event)"';
		
		$attributes = array('id' => 'frm_backup_data');
		echo form_open('frm_backup_data', $attributes);
		?>
		<div class="col" style="width: 100%">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top">
						<table>
							<tr>
								<td valign="top" class="key">Tanggal Entry Pendataan</td>
								<td>
									<input type="text" name="fDate" id="fDate" size="11" class="mandatory" />
									S / D
									<input type="text" name="tDate" id="tDate" size="11" class="mandatory" />
								</td>
							</tr>
							<tr>
								<td valign="top" class="key">Jenis Pajak</td>
								<td>
									<?php 
										foreach ($jenis_pajak as $key => $value) {
											if ($key != "4")
											echo "<input type='checkbox' name='jenis_pajak[]' id='jenis_pajak' value='".$key."'>".$value."<br/>";
										}						
									?>
								</td>
							</tr>
							<tr>
								<td valign="top" class="key">Kecamatan</td>
								<td>
									<?php 
										foreach ($kecamatan as $row) {
											echo "<input type='checkbox' name='kecamatan[]' id='kecamatan' value='$row->camat_id'>".$row->camat_kode." | ".$row->camat_nama."<br/>";
										}						
									?>
								</td>
							</tr>
							<!-- 
							<tr>
								<td valign="top" class="key">Tanggal Penyetoran</td>
								<td>
									<input type="text" name="from_penyetoran" id="from_penyetoran" size="11" class="mandatory" />
									S / D
									<input type="text" name="to_penyetoran" id="to_penyetoran" size="11" class="mandatory" />
								</td>
							</tr>
							 -->
							<tr>
								<td></td>
								<td>
									<input type="button" name="btn_view" id="btn_view" value="Tampilkan"/>&nbsp;&nbsp;&nbsp;
									<input type="button" name="btn_backup" id="btn_backup" value="Backup"/>
								</td>
							</tr>
						
						</table>
					</td>
					<td style="padding-left: 5px;" valign="top">
						<div id="backup_panel">
							<table id="backup_table" style="display: none;"></table>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<?php 
			echo form_close();
		?>
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>
	
<script type="text/javascript">
	var GLOBAL_BACKUP_DATA_VARS = new Array ();
	GLOBAL_BACKUP_DATA_VARS["view"] = "<?=base_url();?>pemeliharaan/backup_data/view";
	GLOBAL_BACKUP_DATA_VARS["export"] = "<?=base_url();?>pemeliharaan/backup_data/export";
</script>
<script type="text/javascript" src="modules/pemeliharaan/scripts/form_backup_data.js"></script>