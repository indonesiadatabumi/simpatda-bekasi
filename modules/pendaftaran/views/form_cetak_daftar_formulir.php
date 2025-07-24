<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>
	<div class="m">
		<div class="header icon-48-print">
			Cetak Daftar Formulir Pendaftaran 
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
		<form method="post" name="frm_cetak_formulir" id="frm_cetak_formulir">
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td align="right" colspan="2">
						<fieldset class="detailForm">
							<legend>Form Cetak Daftar Formulir</legend>
							<table class="admintable" border=0 cellspacing="1" width="100%">
								<tr>
									<td class="key">Nomor Formulir</td>
									<td>
										<input type="text" name="from_formulir" id="from_formulir" size="11" value="" maxlength="8" tabindex="1"/>
										s/d <input type="text" name="to_formulir" id="to_formulir" size="11" value="" maxlength="8" tabindex="2"/>
									</td>
								</tr>
								<tr>
									<td class="key">Tanggal Kirim</td>
									<td>
										<input type="text" name="fDate" id="fDate" size="11" value="" maxlength="10" tabindex="1"/>
										s/d <input type="text" name="tDate" id="tDate" size="11" value="" maxlength="10" tabindex="2"/>
									</td>
								</tr>
								<tr>
									<td class="key">Status</td>
									<td>
										<select name="status" id="status">
											<option value="">--</option>
											<option value="1">Dikirim</option>
											<option value="2">Kembali</option>
											<option value="0">Belum Kembali</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="key">Tanggal Cetak</td>
									<td>
										<input type="text" name="tgl_cetak" id="tgl_cetak" size="11" value="" maxlength="10" />
									</td>
								</tr>
       							<tr>
                                    <td class="key">Mengetahui</td>
                                    <td>
                                        <?php
											$attributes = 'id="ddl_mengetahui" class="inputbox"';
											echo form_dropdown('ddl_mengetahui', $pejabat_daerah, '', $attributes);
										?>
                                    </td>
                                </tr>
                                <tr>
                                	<td class="key">Diperiksa Oleh</td>
                                   	<td>
                                    	<?php
											$attributes = 'id="ddl_pemeriksa" class="inputbox"';
											echo form_dropdown('ddl_pemeriksa', $pejabat_daerah, '', $attributes);
										?>
                                        <input type="button" name="btn_cetak" id="btn_cetak" value="Cetak" class="button" />
                                  	</td>
                                </tr>
							</table>
						</fieldset>
					</td>
				</tr>
			</table>
		</div>
		<div class="clr"></div>
 		<input type="hidden" name="task" value="" />
		</form>
		<br />
		
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="modules/pendaftaran/scripts/form_cetak_daftar_formulir.js"></script>