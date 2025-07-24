<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar" id="top">
				<tr>					
					<td class="button" id="toolbar-add">
						<a href="#" class="toolbar" id="btn_update">
							<span class="icon-32-save" title="Update"></span>
							Simpan
						</a>
					</td>
					
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_close_edit">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-operator">
			OPERATOR : <small><small id='title_head'>[ Edit ]</small></small>
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
			
			$attributes = array('id' => 'frm_edit_operator');
			$hidden = array(
								'mode' => 'edit',
								'opr_id' => $row->opr_id
						);
			echo form_open('frm_edit_operator', $attributes, $hidden);
			?>
				<table class="admintable">
					<tr>
						<td class="key">Nama Login <?=$defaultFill;?></td>
						<td>
							<input type="text" name="opr_user" id="opr_user" value="<?= $row->opr_user; ?>" class="inputbox mandatory" readonly="true" size="50" maxlength="100" />
						</td>
					</tr>
					<tr>
						<td class="key">Kode <?=$defaultFill;?></td>
						<td>
							<input type="text" name="opr_kode" id="opr_kode" value="<?= $row->opr_kode; ?>" class="inputbox mandatory" size="5" maxlength="2" />
						</td>
					</tr>
					<tr>
						<td class="key">Nama Lengkap <?=$defaultFill;?></td>
						<td>
							<input type="text" name="opr_nama" id="opr_nama" value="<?= $row->opr_nama; ?>" class="inputbox mandatory" size="50" maxlength="100" />
						</td>
					</tr>
					<tr>
						<td class="key">N I P</td>
						<td>
							<input type="text" name="opr_nip" id="opr_nip" value="<?= $row->opr_nip; ?>" class="inputbox" size="25" <?= $js; ?> maxlength="50" />
						</td>
					</tr>
					<tr>
						<td class="key">Jabatan <?=$defaultFill;?></td>
						<td>
							<?php 
							$attributes = 'id="opr_jabatan" class="inputbox mandatory"';
							echo form_dropdown('opr_jabatan', $jabatan, $row->opr_jabatan, $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">Status Aktif <?=$defaultFill;?></td>
						<td>
							<?php 
							$attributes = 'id="opr_status" class="inputbox mandatory"';
							echo form_dropdown('opr_status', $status_aktif, $row->opr_status, $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">Status Login</td>
						<td>
							<?php 
							$attributes = 'id="opr_status_login" class="inputbox"';
							echo form_dropdown('opr_status_login', $status_aktif, $row->opr_status_login, $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">Status Admin <?=$defaultFill;?></td>
						<td>
							<?php 
							$attributes = 'id="opr_admin" class="inputbox mandatory"';
							echo form_dropdown('opr_admin', $status_admin, $row->opr_admin, $attributes);
							?>
						</td>
					</tr>
						<tr>
						<td class="key">PASSWORD <?=$defaultFill;?></td>
						<td>
							<input type="text" name="opr_passwd" id="opr_passwd" value="<?= $row->opr_passwd; ?>" class="inputbox mandatory" size="50" maxlength="100" />
						</td> 
					</tr><tr><td></td><td>reset password: bekasikota --> <font color="red"> 7415d9d5a578c86fceef53955f3f71af </font></td></tr>
				</table>
				 <br/><?=$defaultFill;?>  Wajib diisi <br/>
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/edit_operator.js"></script>
	