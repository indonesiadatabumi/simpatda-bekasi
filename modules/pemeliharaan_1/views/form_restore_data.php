<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
		</div>
		<div class="header icon-48-master">
			Restore Data SPT
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
		<form method="post" action="" id="frm_restore_data">
		<div class="col">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td class="key">File</td>
					<td>
						<input type="file" id="userfile" name="userfile" size="50">
						<?php 
							$attributes = array(
															'name' => 'txt_attachment',
															'id' => 'txt_attachment',
															'size' => 50,
															'class' => 'mandatory',
															'style' => 'width: 0px; border-width: 0px;'
														);
							//echo form_upload($attributes);
							//echo "<br/>";
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" value="Upload" id="pxUpload" style="margin-right: 10px;" class="button" />
						<input type="reset" value="Clear" id="pxClear" class="button"  />
						<!-- <input type="button" name="btn_upload" id="btn_upload" value="Upload"/> -->
					</td>
				</tr>
			</table>
		</div>
		</form>
						
		<div class="clr"></div>
		
		<div id="confirmation" style="display: none">
			<table>
				<tr>
					<td></td>
					<td>
						<p>
							<input type="hidden" id="file_path" />
							<b>Jumlah data SPT akan di-restore : <span id="total_spt"></span></b>.<br/> Apakah anda yakin untuk re-store data?
						</p>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="button" name="btn_restore" id="btn_restore" value="Ya" class="button" />&nbsp;&nbsp;&nbsp;
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
<script type="text/javascript" src="modules/pemeliharaan/scripts/form_restore_data.js"></script>