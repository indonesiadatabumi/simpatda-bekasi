<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			CETAK DAFTAR SURAT KETETAPAN
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
		<form name="frm_daftar_surat_teguran" id="frm_daftar_surat_teguran">
			<div id="accordion">
				<h4>Berdasarkan Bulan Penetapan</h4>
				<div>
					<table class="admintable">
						<tr>
							<td class="key">
								<label for="password">Jenis Pajak</label>
							</td>
							<td>									
								<?php
									$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory"';
									echo form_dropdown('spt_jenis_pajakretribusi', $jenis_pajak, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td width="150" class="key">Ketetapan</td>
							<td>
								<b>Tahun</b>
								<input type="text" name="tahun" id="tahun" class="inputbox" size="4" maxlength="4" value="<?= date('Y') ?>" tabindex="3" />
								&nbsp;&nbsp;&nbsp;
								<b>Bulan</b>
								<?php
									$attributes = 'id="bulan" class="inputbox"';
									echo form_dropdown('bulan', get_month(), date('n'), $attributes);
								?>
								&nbsp;&nbsp;&nbsp;
								<b>Tanggal</b>
								<?php
									$arr_tanggal = array();
									$arr_tanggal[''] = "";
									for ($i=1; $i <= 31; $i++)
										$arr_tanggal[$i] = $i;
										
									$attributes = 'id="tanggal" class="inputbox"';
									echo form_dropdown('tanggal', $arr_tanggal, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label>Pilihan Ketetapan</label>
							</td>
							<td>									
								<?php
									$attributes = 'id="keterangan_spt" class="inputbox mandatory"';
									echo form_dropdown('keterangan_spt', $keterangan_spt, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td class="key">Kecamatan</td>
							<td>
								<?php
									$attributes = 'id="wp_wr_kd_camat" class="inputbox mandatory"';
									echo form_dropdown('wp_wr_kd_camat', $kecamatan, '', $attributes);
								?> 
								<span id="ket_reklame" style="display: none;">
									* Silahkan pilih untuk memilih reklame kecamatan. Kosongkan jika memilih reklame dinas.
								</span>
							</td>
						</tr>
						<tr>
							<td class="key">Cetak Penandatangan</td>
							<td>
								<input type="checkbox" name="tandatangan" id="tandatangan" value="1" checked> Pilih jika diikutsertakan dalam cetakan.
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
							<td class="key">Diperiksa oleh</td>
							<td>
								<?php
									$attributes = 'id="ddl_pemeriksa" class="inputbox"';
									echo form_dropdown('ddl_pemeriksa', $pejabat_daerah, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td width="150" class="key">
								<label for="name">Tanggal Cetak</label>
							</td>
							<td>
								<input type="text" name="tgl_cetak" id="tgl_cetak" size="11" />
							</td>
						</tr>
						<tr>
							<td class="key">Font Size</td>
							<td>
								<select name="fontsize" id="fontsize">
									<option value="3.5">3.5</option>
		                            <option value="4">4.0</option>
		                            <option value="4.5">4.5</option>
		                            <option value="5">5.0</option>
		                            <option value="5.5">5.5</option>
		                            <option value="6">6.0</option>
		                            <option value="6.5">6.5</option>
		                            <option value="7">7.0</option>
		                            <option value="7.5">7.5</option>
		                            <option value="8" selected>8.0</option>
		                            <option value="8.5">8.5</option>
								</select>	
							</td>
						</tr>
						<tr>
							<td class="key">Baris Spasi</td>
							<td>
								<select name="linespace" id="linespace">
		                            <option value="4.5">4.5</option>
		                            <option value="5">5.0</option>
		                            <option value="5.5">5.5</option>
		                            <option value="6">6.0</option>
		                            <option value="6.5">6.5</option>
								</select>	
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak PDF " class="button" /> &nbsp;&nbsp;
								
								<input type="button" name="btn_cetak" id="btn_cetak_excel" value=" Cetak Excel " class="button" />
								
							</td>
						</tr>
					<!--	<tr>
							<td></td>
							<td>
								<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak PDF " class="button" /> &nbsp;&nbsp;
								<?php 
							    if ($this->session->userdata('USER_SPT_CODE') == "10") {
								?>
								<input type="button" name="btn_cetak" id="btn_cetak_excel" value=" Cetak Excel " class="button" />
								<?php 
								}
								?> 
							</td>
						</tr>-->
						
					</table>
				</div>
				<h4>Berdasarkan Tanggal Penetapan</h4>
			  	<div>
			  		<table class="admintable">
						<tr>
							<td class="key">
								<label for="password">Jenis Pajak</label>
							</td>
							<td>									
								<?php
									$attributes = 'id="ddl_jenis_pajak" class="inputbox mandatory"';
									echo form_dropdown('ddl_jenis_pajak', $jenis_pajak, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td width="150" class="key">Tanggal Penetapan</td>
							<td>
								<input type="text" name="tgl_penetapan1" id="tgl_penetapan1" size="11" />
								&nbsp;S/D&nbsp;
								<input type="text" name="tgl_penetapan2" id="tgl_penetapan2" size="11" />
							</td>
						</tr>
						<tr>
							<td class="key">
								<label>Pilihan Ketetapan</label>
							</td>
							<td>									
								<?php
									$attributes = 'id="ddl_keterangan_spt" class="inputbox mandatory"';
									echo form_dropdown('ddl_keterangan_spt', $keterangan_spt, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td class="key">Kecamatan</td>
							<td>
								<?php
									$attributes = 'id="ddl_camat" class="inputbox mandatory"';
									echo form_dropdown('ddl_camat', $kecamatan, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td class="key">Cetak Penandatangan</td>
							<td>
								<input type="checkbox" name="tandatangan2" id="tandatangan2" value="1" checked> Pilih jika diikutsertakan dalam cetakan.
							</td>
						</tr>
						<tr>
							<td class="key">Mengetahui</td>
							<td>
								<?php
									$attributes = 'id="ddl_mengetahui2" class="inputbox"';
									echo form_dropdown('ddl_mengetahui2', $pejabat_daerah, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td class="key">Diperiksa oleh</td>
							<td>
								<?php
									$attributes = 'id="ddl_pemeriksa2" class="inputbox"';
									echo form_dropdown('ddl_pemeriksa2', $pejabat_daerah, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td width="150" class="key">
								<label for="name">Tanggal Cetak</label>
							</td>
							<td>
								<input type="text" name="txt_tgl_cetak" id="txt_tgl_cetak" size="11" />
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="button" name="btn_cetak2" id="btn_cetak2" value=" Cetak PDF " class="button" />

								<input type="button" name="btn_cetak2" id="btn_cetak_excel2" value=" Cetak Excel " class="button" />
							</td>
						</tr>
					</table>
			  	</div>
			  </div>
		</form>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_DAFTAR_SURAT_KETETAPAN_VARS = new Array ();
	GLOBAL_DAFTAR_SURAT_KETETAPAN_VARS["cetak"] = "<?=base_url();?>penetapan/daftar_surat_ketetapan/pdf_daftar_surat_ketetapan";
	GLOBAL_DAFTAR_SURAT_KETETAPAN_VARS["cetak_excel"] = "<?=base_url();?>penetapan/daftar_surat_ketetapan/xls_daftar_surat_ketetapan";
	GLOBAL_DAFTAR_SURAT_KETETAPAN_VARS["cetak_via_tanggal"] = "<?=base_url();?>penetapan/daftar_surat_ketetapan/pdf_cetak_daftar_via_tanggal_ketetapan";
	GLOBAL_DAFTAR_SURAT_KETETAPAN_VARS["cetak_excel_via_tanggal"] = "<?=base_url();?>penetapan/daftar_surat_ketetapan/xls_daftar_surat_ketetapan_via_tanggal";
</script>
<script type="text/javascript" src="modules/penetapan/scripts/form_daftar_surat_ketetapan.js"></script>