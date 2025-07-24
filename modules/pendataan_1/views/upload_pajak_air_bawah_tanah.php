<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-ref">
						<a href="#" id="btn_view" class="toolbar">
							<span class="icon-32-ref" title="Lihat Data"></span>Lihat Data
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-user">
			Upload Data Pajak Air Tanah : <small><small id='title_head'>[ Baru ]</small></small>
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
		$attributes = array('id' => 'frm_upload_air_tanah');
		$hidden = array(
						'spt_jenis_pajakretribusi' => $this->config->item('jenis_pajak_air_bawah_tanah'), 
						'kodus_id' => $this->config->item('kodus_air_bawah_tanah'), 
						'korek' => $this->config->item('korek_air_bawah_tanah') 
					);
		echo form_open('', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td colspan="2">
						<b>Download template Excel : </b>
						<a href="<?= base_url(); ?>files/template/template_air_tanah.xls">template_air_tanah.xls</a>
					</td>
				</tr>
				<tr>
					<td class="key">File</td>
					<td>
						<input type="file" id="userfile" name="userfile" size="50">
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" value="Upload" id="pxUpload" style="margin-right: 10px;" class="button" />
						<input type="reset" value="Clear" id="pxClear" class="button"  />
					</td>
				</tr>
			</table>
		</div>
		<?php 
			echo form_close();
		?>
		<div class="clr"></div>
		
		<div id="confirmation" style="display: none">
			<table>
				<tr>
					<td></td>
					<td>
						<p>
							<input type="hidden" id="file_path" />
							<b>Jumlah data Air Tanah akan dimasukkan : <span id="total"></span></b>.<br/> Apakah anda yakin untuk mengupload data?
						</p>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="button" name="btn_approve" id="btn_approve" value="Ya" class="button" />&nbsp;&nbsp;&nbsp;
						<input type="button" name="btn_cancel" id="btn_cancel" value="Tidak" class="button" />
					</td>
				</tr>
			</table>
			
		</div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>
<script type="text/javascript" src="modules/pendataan/scripts/upload_pajak_air_tanah.js"></script>