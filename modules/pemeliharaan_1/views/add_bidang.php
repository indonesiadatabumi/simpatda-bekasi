<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" id="btn_save" class="toolbar">
							<span class="icon-32-save" title="Save"></span>Simpan
						</a>
					</td>
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_close">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-master">
			Bidang: <small><small>[ Baru ]</small></small>
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
			
<?php $defaultFill = '<font size="3" color="red">*</font>'; ?>
<div id="element-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>
	<div class="m">
		<!-- content body -->
		<span id="callData"></span>
		<?php
		$js = 'onKeypress = "return numbersonly(this, event)"';
		
		$attributes = array('id' => 'frm_add_bidang');
		$hidden = array(
							'mode' => 'add'
					);
		echo form_open('frm_add_bidang', $attributes, $hidden);
		?>
		<div class="col">
			<fieldset class="adminform">
			<legend>Detail Bidang</legend>
				<table class="admintable" border=0 cellspacing="1">
					<tr>
						<td class="key"><label for="email">Urusan</label> <?=$defaultFill?> </td>
						<td>
							<?php
								$attributes = 'id="bdg_urusan" class="inputbox mandatory"';
								echo form_dropdown('bdg_urusan', $dt_urusan, '', $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="password">Kode Bidang</label><?=$defaultFill?>
						</td>
						<td>
							<input type="text" name="bdg_kode" id="bdg_kode" class="inputbox" size="2" maxlength="2" value="" <?= $js; ?> /> <span id='cek'></span>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="password">Nama Bidang</label><?=$defaultFill?>
						</td>
						<td>
							<input type="text" name="bdg_nama" id="bdg_nama" class="inputbox" size="40" value="" />							
						</td>
					</tr>
				</table> <?=$defaultFill?>  Wajib diisi
			</fieldset>
		</div>
		</form>
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="modules/pemeliharaan/scripts/add_bidang.js"></script>