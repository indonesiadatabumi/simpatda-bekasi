<!-- Semua Script Javascript yang dipakai diletakkan di bagian ini -->
<?php
	//$xajax->printJavascript('scripts/');
	//$sukses = $attributes['sukses'];
?>
<!-- main-body -->
	<div class="border">
		<div class="padding">
			<div id="toolbar-box">
				<div class="t">
					<div class="t"><div class="t"></div></div>
				</div>
				<div class="m">
					<div id="toolbar" class="toolbar">
						<table class="toolbar">
							<tr>
								<td class="button" id="toolbar-close">
									<a href="#" onclick="javascript:parent.GB_hide()" class="toolbar">
										<span class="icon-32-close" title="Tutup"></span>Tutup
									</a>
								</td>
							</tr>
						</table>
					</div>
					<div class="header icon-48-menulist">
						Form Import Data Kecamatan Dan Kelurahan
					</div>
					<div class="clr"></div>
				</div>
				<div class="b">
					<div class="b"><div class="b"></div></div>
				</div>
			</div>
			<div class="clr"></div>
			<div id="element-box">
				<div class="t"><div class="t"><div class="t"></div></div></div>
				<div class="m">
					<!-- content body -->
					<fieldset>
						<legend>Import Data Kecamatan Dan Kelurahan</legend>
					<form action="<?php //echo $myself.$XFA['act_form_import_kec_kel_data']; ?>" method="post" enctype="multipart/form-data" name="adminForm" id="adminForm">
					<?php
						//if($sukses == '1') echo '<p style="text-decoration:blink;background-color:#E3EFD1"><strong>Import Data berhasil!!</strong></p>';
						//elseif($sukses == '0') echo '<p style="text-decoration:blink;background-color:#EFDCD1;color:#ff0000;"><strong>Ada error!! mohon periksa kembali data di file excel yang Anda upload.</strong></p>';
					?>
					<p><strong>Download Template Excel</strong> : <a href="su/readexcel/templatedatakecamatan.xls">templatedatakecamatan.xls</a></p>
						<table class="admintable">
							<tr>
								<td class="key">Upload file</td>
								<td>
									<input type="file" class="inputbox" name="filenya" id="filenya" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="wp_wr_pejabat" value="<?//= $staff_id ?>" />
						<p><input type="button" name="import" id="btnimport" value=" Import " /></p>
					</form>
					</fieldset>
					<div class="clr"></div>
				</div>
				<div class="b">
					<div class="b">
						<div class="b"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
<div class="clr"></div>