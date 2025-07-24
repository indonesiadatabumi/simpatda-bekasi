<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar" id="top">
				<tr>					
					<td class="button" id="toolbar-add">
						<a href="#" class="toolbar" id="btn_insert">
							<span class="icon-32-save" title="Insert"></span>
							Simpan
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
		<div class="header icon-48-operator">
			OPERATOR : <small><small id='title_head'>[ Baru ]</small></small>
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
			<?php
			$defaultFill = '<font size="3" color="red">*</font>';
			$js = 'onKeypress = "return numbersonly(this, event)"';
			
			$attributes = array('id' => 'frm_add_operator');
			$hidden = array(
								'mode' => 'add'
						);
			echo form_open('frm_add_operator', $attributes, $hidden);
			?>
				<table class="admintable">
					<tr>
						<td class="key">Nama Login <?=$defaultFill;?></td>
						<td>
							<input type="text" name="opr_user" id="opr_user" class="inputbox mandatory" size="50" maxlength="100" />
						</td>
					</tr>
					<tr>
						<td class="key">Kode <?=$defaultFill;?></td>
						<td>
							<input type="text" name="opr_kode" id="opr_kode" class="inputbox mandatory" size="5" maxlength="5" />
						</td>
					</tr>
					<tr>
						<td class="key">Nama Lengkap <?=$defaultFill;?></td>
						<td>
							<input type="text" name="opr_nama" id="opr_nama" class="inputbox mandatory" size="50" maxlength="100" />
						</td>
					</tr>
					<tr>
						<td class="key">N I P</td>
						<td>
							<input type="text" name="opr_nip" id="opr_nip" class="inputbox" size="25" <?= $js; ?> maxlength="50" />
						</td>
					</tr>
					<tr>
						<td class="key">Jabatan <?=$defaultFill;?></td>
						<td>
							<?php 
							$attributes = 'id="opr_jabatan" class="inputbox mandatory"';
							echo form_dropdown('opr_jabatan', $jabatan, '', $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">Status Aktif <?=$defaultFill;?></td>
						<td>
							<?php 
							$attributes = 'id="opr_status" class="inputbox mandatory"';
							echo form_dropdown('opr_status', $status_aktif, '', $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">Status Login</td>
						<td>
							<?php 
							$attributes = 'id="opr_status_login" class="inputbox"';
							echo form_dropdown('opr_status_login', $status_aktif, '', $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">Status Admin <?=$defaultFill;?></td>
						<td>
							<?php 
							$attributes = 'id="opr_admin" class="inputbox mandatory"';
							echo form_dropdown('opr_admin', $status_admin, '', $attributes);
							?>
						</td>
					</tr>
				</table>
				 <br/><?=$defaultFill;?>  Wajib diisi <br/>
				Password user baru sama dengan Nama Login. Silahkan diganti setelah login.
			<?php 
			echo form_close();
			?>
		</div>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>

		</div>
	</div>
</div>
<script type="text/javascript" src="modules/pemeliharaan/scripts/add_operator.js"></script>
	