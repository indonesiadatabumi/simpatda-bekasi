	<div id="toolbar-box">
   			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
				<div class="toolbar" id="toolbar">
				<table class="toolbar"><tr></tr></table>
				</div>
				<div class="header icon-48-print">Cetak Realisasi & Buku Kendali:</div>
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
		 		<div class="t">
					<div class="t"></div>
		 		</div>
			</div>
			<div class="m">
				<div class="col" style="width: 100%">
				<ul class="tabs">
				    <li><a href="#tab1">Cetak Realisasi</a></li>
				    <li><a href="#tab2">Cetak Buku Kendali</a></li>
				</ul>
				
				<div class="tab_container">
	   				<div id="tab1" class="tab_content">
	   					<form name="adminForm" id="adminForm">
							<div class="col width-51">
								<fieldset class="adminform">
								<legend>Form Cetak Realisasi</legend>
			
								<table class="admintable" border=0 cellspacing="1">
								<tr><TD valign="top">
								<table class="admintable" border=0 cellspacing="1">
									<tr>
										<td width="150" class="key">
											<label for="name">Jenis Pajak</label>
										</td>
										<td>
											<?php
												$attributes = 'id="jenis_pajak_realisasi"';
												echo form_dropdown('jenis_pajak_realisasi', $jenis_pajak, '', $attributes);
											?>
										</td>
									</tr>
									<tr>
										<td class="key" width="100">
											<label for="password">Realisasi / Bulan</label>
										</td>
										<td>
											<?php
												$attributes = 'id="f_bulan_realisasi" class="inputbox"';
												echo form_dropdown('f_bulan_realisasi', get_month(), 1, $attributes);
											?>
											<?php
												$attributes = 'id="f_tahun_realisasi" class="inputbox"';
												echo form_dropdown('f_tahun_realisasi', $tahun_pajak, date("Y"), $attributes);
											?>
										&nbsp; S / D &nbsp;
											<?php
												$attributes = 'id="t_bulan_realisasi" class="inputbox"';
												echo form_dropdown('t_bulan_realisasi', get_month(), date('n'), $attributes);
											?>
											<?php
												$attributes = 'id="t_tahun_realisasi" class="inputbox"';
												echo form_dropdown('t_tahun_realisasi', $tahun_pajak, date("Y"), $attributes);
											?>
										</td>
									</tr>
									<tr>
										<td class="key">
											Status SPT
										</td>
										<td>
											<?php
												$attributes = 'id="status_spt_realisasi" name="status_spt"';
												echo form_dropdown('status_spt_realisasi', $keterangan_spt, '', $attributes);
											?>
											</select> &nbsp;
					
										</td>
									</tr>
									<tr>
										<td class="key">Kode Kecamatan</td>
										<td>
											<?php
												$attributes = 'id="camat_id_realisasi" name="camat_id_realisasi"';
												echo form_dropdown('camat_id_realisasi', $kecamatan, '', $attributes);
											?>
											&nbsp;
										</td>
									</tr>
									<tr>
										<td class="key">Pilihan Denda</td>
										<td>
											<?php
												$attributes = array(
														    'name'        => 'denda_realisasi',
														    'id'          => 'denda_realisasi',
														    'value'       => '1',
														    'checked'     => TRUE
														);
												echo form_checkbox($attributes);
											?>
											<b>Silahkan cek/pilih jika denda diikutsertakan </b>
										</td>
									</tr>
									<tr>
										<td colspan="2" align="center">						
											<input type="button" name="btn_realisasi" value="Cetak Excel" class="button">																		
										</td>
									</tr>
								</table>
								</TD>
								</tr>
							</table>
						</fieldset>
					</div>
					</form>
	   				</div>
	   				<div id="tab2" class="tab_content">
	   					<form name="adminForm" id="adminForm">
							<div class="col width-51">
								<fieldset class="adminform">
								<legend>Form Cetak Buku Kendali</legend>
			
								<table class="admintable" border=0 cellspacing="1">
								<tr><TD valign="top">
								<table class="admintable" border=0 cellspacing="1">
									<tr>
										<td width="150" class="key">
											<label for="name">Jenis Pajak</label>
										</td>
										<td>
											<?php
												$attributes = 'id="jenis_pajak_kendali"';
												echo form_dropdown('jenis_pajak_kendali', $jenis_pajak, '', $attributes);
											?>
										</td>
									</tr>
									<tr>
										<td class="key" width="100">
											<label for="password">Buku Kendali / Bulan</label>
										</td>
										<td>
											<?php
												$attributes = 'id="f_bulan_kendali" class="inputbox"';
												echo form_dropdown('f_bulan_kendali', get_month(), 12, $attributes);
											?>
											<?php
												$attributes = 'id="f_tahun_kendali" class="inputbox"';
												echo form_dropdown('f_tahun_kendali', $tahun_pajak, date("Y") - 1, $attributes);
											?>
										&nbsp; S / D &nbsp;
											<?php
												$attributes = 'id="t_bulan_kendali" class="inputbox"';
												echo form_dropdown('t_bulan_kendali', get_month(), date('n')-1, $attributes);
											?>
											<?php
												$attributes = 'id="t_tahun_kendali" class="inputbox"';
												echo form_dropdown('t_tahun_kendali', $tahun_pajak, date("Y"), $attributes);
											?>
										</td>
									</tr>
									<tr>
										<td class="key">
											Status SPT
										</td>
										<td>
											<?php
												$attributes = 'id="status_spt_kendali" name="status_spt_kendali"';
												echo form_dropdown('status_spt_kendali', $keterangan_spt, '', $attributes);
											?>
											</select> &nbsp;
					
										</td>
									</tr>
									<tr>
										<td class="key">Kode Kecamatan</td>
										<td>
											<?php
												$attributes = 'id="camat_id_kendali" name="camat_id_kendali"';
												echo form_dropdown('camat_id_kendali', $kecamatan, '', $attributes);
											?>
											&nbsp;
										</td>
									</tr>
									<tr>
										<td class="key">Pilihan Denda</td>
										<td>
											<?php
												$attributes = array(
														    'name'        => 'denda_kendali',
														    'id'          => 'denda_kendali',
														    'value'       => '1',
														    'checked'     => TRUE
														);
												echo form_checkbox($attributes);
											?>
											<b>Silahkan cek/pilih apakah denda diikutsertakan </b>
										</td>
									</tr>
									<tr>
										<td colspan="2" align="center">						
											<input type="button" name="btn_kendali" value="Cetak Excel" class="button">																		
										</td>
									</tr>
								</table>
								</TD>
								</tr>
							</table>
						</fieldset>
						</div>
						</form>
	   				</div>
	   			</div>
			</div>
		<div class="clr"></div>
		<div class="clr"></div>
		</div>
	</div>
	<div class="b">
			<div class="b">
				<div class="b"></div>
			</div>
	</div>

<script type="text/javascript" src="modules/pembukuan/scripts/form_buku_kendali.js"></script>