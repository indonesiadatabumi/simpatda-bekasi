<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			Cetak Daftar SPTPD Self Assesment
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
		<form name="frm_daftar_sptpd" id="frm_daftar_sptpd">
			<div id="accordion">
				<h4>Berdasarkan Masa Pajak SPTPD</h4>
				<div>
					<table class="admintable">
						<tr>
							<td width="150" class="key">
								<label for="name">Jenis Pajak</label>
							</td>
							<td>
								<?php
									$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory"';
									echo form_dropdown('spt_jenis_pajakretribusi', $objek_pajak, '', $attributes);
								?>
							</td>
						</tr>
						<tr id="jenis_restoran" style="display: none;">
							<td class="key">Jenis Restoran</td>
							<td>
								<?php
									$attributes = 'id="jenis_pajak_restoran" class="inputbox"';
									echo form_dropdown('jenis_pajak_restoran', $jenis_pajak_restoran, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td class="key" width="150">Sistem Pemunggutan</td>
							<td>
		                    	<select name="sistem_pemungutan" id="sistem_pemungutan">
		                        	<option value="1">Self Assesment</option>                               
		                      	</select>
		                  	</td>
						</tr>
						<tr>
							<td class="key" width="150">Kecamatan</td>
							<td>
								<?php
									$attributes = 'id="kecamatan" class="inputbox"';
									echo form_dropdown('kecamatan', $kecamatan, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td width="150" class="key">Masa Pajak</td>
							<td>
								<?php
									$attributes = 'id="masa_pajak" class="inputbox"';
									echo form_dropdown('masa_pajak', get_month(), date('n')-1, $attributes);
								?>
								Tahun 
								<input type="text" name="spt_periode" id="spt_periode" class="inputbox" size="4" maxlength="4" value="<?= date('Y') ?>" tabindex="3" />
							</td>
						</tr>
						<!-- 
						<tr>
							<td class="key">Cetak Semua WP</td>
							<td>
								<input type="checkbox" name="cetak_wp" id="cetak_wp" value="1"> Pilih jika diikutsertakan semua daftar WP dari jenis pajak.
							</td>
						</tr>
						 -->
						 <tr>
							<td class="key">Lihat Daftar SPTPD</td>
							<td>
								<select name="ddl_daftar" id="ddl_daftar">
									<option value="1">SPT yang sudah dilaporkan</option>
									<option value="2">SPT yang belum dilaporkan</option>
									<option value="0">SPT yang sudah dan belum dilaporkan</option>
								</select>
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
							<td></td>
							<td>
								<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak PDF " class="button" />
								&nbsp;&nbsp;&nbsp;
								<?php 
								if ($this->session->userdata('USER_SPT_CODE') == "10") {
								?>
								<input type="button" name="btn_cetak_xls" id="btn_cetak_xls" value=" Cetak Excel " class="button" />
								<?php 
								}
								?>
							</td>
						</tr>
					</table>
					<br/><br/><br/>
				</div>
				<h4>Berdasarkan Tanggal Pendataan SPTPD</h4>
			  	<div>
			  		<table class="admintable">
						<tr>
							<td width="150" class="key">
								<label for="name">Jenis Pajak</label>
							</td>
							<td>
								<?php
									$attributes = 'id="spt_jenis_pajak_entry" class="inputbox mandatory"';
									echo form_dropdown('spt_jenis_pajak_entry', $objek_pajak, '', $attributes);
								?>
							</td>
						</tr>
						<tr id="jenis_restoranmp" style="display: none;">
							<td class="key">Jenis Restoran</td>
							<td>
								<?php
									$attributes = 'id="jenis_pajak_restorantgl" class="inputbox"';
									echo form_dropdown('jenis_pajak_restoran', $jenis_pajak_restoran, '', $attributes);
								?>
							</td>
						</tr>

						<tr>
							<td class="key" width="150">Kecamatan</td>
							<td>
								<?php
									$attributes = 'id="kecamatan_entry" class="inputbox"';
									echo form_dropdown('kecamatan_entry', $kecamatan, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td width="150" class="key">Tanggal Entry Pendataan</td>
							<td>
								<input type="text" name="tgl_entry1" id="tgl_entry1" size="11" />
								&nbsp;S/D&nbsp;
								<input type="text" name="tgl_entry2" id="tgl_entry2" size="11" />
							</td>
						</tr>						
						<tr>
							<td class="key">Mengetahui</td>
							<td>
								<?php
									$attributes = 'id="ddl_mengetahui_entry" class="inputbox"';
									echo form_dropdown('ddl_mengetahui_entry', $pejabat_daerah, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td class="key">Diperiksa oleh</td>
							<td>
								<?php
									$attributes = 'id="ddl_pemeriksa_entry" class="inputbox"';
									echo form_dropdown('ddl_pemeriksa_entry', $pejabat_daerah, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td width="150" class="key">
								<label for="name">Tanggal Cetak</label>
							</td>
							<td>
								<input type="text" name="tgl_cetak_spt" id="tgl_cetak_spt" size="11" />
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="button" name="btn_cetak_entry" id="btn_cetak_entry" value=" Cetak " class="button" />
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
	var GLOBAL_SPTPD_VARS = new Array ();
	GLOBAL_SPTPD_VARS["cetak"] = "<?=base_url();?>pendataan/sptpd/cetak_daftar_sptpd";
	GLOBAL_SPTPD_VARS["cetak_xls"] = "<?=base_url();?>pendataan/sptpd/cetak_xls_daftar_sptpd";
	GLOBAL_SPTPD_VARS["cetak_via_tgl_entry"] = "<?=base_url();?>pendataan/sptpd/cetak_daftar_tanggal_sptpd";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/form_daftar_sptpd.js"></script>