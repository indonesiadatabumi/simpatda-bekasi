<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
		</div>
		<div class="header icon-48-master">
			Restore Data Wajib Pajak (WP)
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
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
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
							<b>Jumlah data WP akan di-restore : <span id="total_wp"></span></b>.<br/> Apakah anda yakin untuk re-store data?
						</p>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="button" name="btn_restore" id="btn_restore" value="Ya" class="button"/>&nbsp;&nbsp;&nbsp;
						<input type="button" name="btn_cancel" id="btn_cancel" value="Tidak" class="button"/>
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
	
<script type="text/javascript" src="modules/pemeliharaan/scripts/form_restore_data_wp.js"></script>