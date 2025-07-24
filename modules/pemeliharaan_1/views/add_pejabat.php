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
						<a href="#" class="toolbar" id="btn_close_add">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-bos">
			Pejabat Daerah: <small><small>[ Baru ]</small></small>
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
		
		$attributes = array('id' => 'frm_add_pejabat');
		$hidden = array(
							'mode' => 'add'
					);
		echo form_open('frm_add_pejabat', $attributes, $hidden);
		?>
		<div class="col">
			<fieldset class="adminform">
			<legend>Detail Pejabat Daerah</legend>
				<table class="admintable" border=0 cellspacing="1">
					<tr>
						<td class="key"><label for="name">Kode Pejabat</label><?=$defaultFill?></td>
						<td>
							<input type="text" name="pejda_kode" id="pejda_kode" class="inputbox mandatory" size="2" maxlength="2" tabindex="1" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="password">Nama Pejabat</label><?=$defaultFill?>
						</td>
						<td>
							<input type="text" name="pejda_nama" id="pejda_nama" class="inputbox mandatory" size="40" tabindex="2" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="password">Jabatan</label><?=$defaultFill?>
						</td>
						<td>
							<?php
								$attributes = 'id="pejda_jabatan" class="inputbox mandatory" tabindex="3"';
								echo form_dropdown('pejda_jabatan', $arr_jabatan, '', $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="password">Golongan</label>
						</td>
						<td>
							<?php
								$attributes = 'id="pejda_gol_ruang" class="inputbox mandatory" tabindex="4"';
								echo form_dropdown('pejda_gol_ruang', $arr_golongan, '', $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="nip">NIP</label>
						</td>
						<td>
							<input type="text" name="pejda_nip" id="pejda_nip" class="inputbox" size="40" tabindex="5" />
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="pangkat">Pangkat</label>
						</td>
						<td>
							<?php
								$attributes = 'id="pejda_pangkat" class="inputbox mandatory" tabindex="6"';
								echo form_dropdown('pejda_pangkat', $arr_pangkat, '', $attributes);
							?>
							</div>
						</td>
					</tr>
					<tr>
						<td class="key">
							<label for="pangkat">Status</label><?=$defaultFill?>
						</td>
						<td>
							<select name="pejda_aktif" id="pejda_aktif"  class="inputbox mandatory" tabindex="7"> 
								<option value="" >--</option>
								<option value="t">Aktif</option>
								<option value="f">Non Aktif</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">
	                    	<label for="ttd">   Tanda Tangan  </label>
						</td>
						<td>
							<select name="pejda_ttd" id="pejda_ttd"  class="inputbox" tabindex="8">
								<option value="0">--</option>
								<option value="1">Mengetahui</option>
								<option value="2">Diperiksa oleh</option>
							</select>
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

<script type="text/javascript">
	GLOBAL_MASTER_PEJABAT_VARS["save"] = "<?=base_url();?>pemeliharaan/pejabat/save";
</script>
<script type="text/javascript" src="modules/pemeliharaan/scripts/add_pejabat.js"></script>