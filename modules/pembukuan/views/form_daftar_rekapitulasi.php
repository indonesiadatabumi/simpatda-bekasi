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
				<div class="header icon-48-print">Cetak Daftar Rekapitulasi</div>
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
				    <li><a href="#tab1">Masa Pajak</a></li>
				    <li><a href="#tab2">Realisasi</a></li>
					<li><a href="#tab3">Pendataan</a></li>
				</ul>
				
				<div class="tab_container">
	   				<div id="tab1" class="tab_content">
	   					<form name="adminForm" id="adminForm">
							<div class="col width-51">
			<!--		<div id="accordion">-->
					<fieldset class="adminform">
							<table class="admintable" border=0 cellspacing="1">
							<tr><TD valign="top">
							<table class="admintable" border=0 cellspacing="1">
								<!-- 
								<tr>
									<td class="key" width="100">
										<label for="password">Tanggal Cetak</label>
									</td>
									<td>
										<input type="text" name="tanggal" id="f_date_c" size="10" value="<?= date('d-m-Y'); ?>" maxlength="10" />
									</td>
								</tr>
								 -->
								<tr>
									<td width="150" class="key">
										<label for="name">Jenis Pajak</label>
									</td>
									<td>
										<?php
											$attributes = 'id="jenis_pajak"';
											echo form_dropdown('jenis_pajak', $jenis_pajak, '', $attributes);
										?>
									</td>
								</tr>						
								<tr id="jenis_restoran" style="display: none;">
									<td class="key">Jenis Restoran</td>
									<td>
										<?php
											$attributes = 'id="jenis_restoran" class="inputbox"';
											echo form_dropdown('jenis_restoran', $jenis_pajak_restoran, '', $attributes);
										?>
									</td>
								</tr>
								<tr>
									<td class="key" width="100">
										<label for="password">Masa Pajak</label>
									</td>
									<td>
										<?php
											$attributes = 'id="bulan_masa_pajak" class="inputbox"';
											echo form_dropdown('bulan_masa_pajak', get_month(), date("n") - 1, $attributes);
										?>
										<?php
											$attributes = 'id="tahun_masa_pajak" class="inputbox"';
											echo form_dropdown('tahun_masa_pajak', $tahun_pajak, date("Y"), $attributes);
										?>
									</td>
								</tr>
								<tr>
									<td class="key">
										Status SPT
									</td>
									<td>
										<?php
											$attributes = 'id="status_spt" name="status_spt"';
											echo form_dropdown('status_spt', $keterangan_spt, '', $attributes);
										?>
										</select> &nbsp;
				
									</td>
								</tr>
								<tr>
									<td class="key">Kode Kecamatan</td>
									<td>
										<?php
											$attributes = 'id="camat_id" name="camat_id"';
											echo form_dropdown('camat_id', $kecamatan, '', $attributes);
										?>
										&nbsp;
									</td>
								</tr>
								<tr>
									<td class="key">Kode Kelurahan</td>
									<td>
										<?php
											$attributes = 'id="lurah_id" name="lurah_id"';
											echo form_dropdown('lurah_id', $kelurahan, '', $attributes);
										?>
										&nbsp;
									</td>
								</tr>
								<tr>
									<td colspan="2" align="center">						
										<input type="button" name="cetak" value="Cetak Excel" class="button">																		
									</td>
								</tr>
							</table>
							</TD>
							</tr>
							</fieldset>
							
						</table>
				<!--	</div>-->
					</div>
					</form>
					</div>
	   			
				<div id="tab2" class="tab_content">
				<div class="col width-51">
				
				<div id="accordion2">
				
						<table class="admintable" border=0 cellspacing="1">
						<tr><TD valign="top">
						<table class="admintable" border=0 cellspacing="1">
							<!-- 
							<tr>
								<td class="key" width="100">
									<label for="password">Tanggal Cetak</label>
								</td>
								<td>
									<input type="text" name="tanggal" id="f_date_c" size="10" value="<?= date('d-m-Y'); ?>" maxlength="10" />
								</td>
							</tr>
							 -->
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
							<tr id="jenis_restoran2" style="display: none;">
								<td class="key">Jenis Restoran</td>
								<td>
									<?php
										$attributes = 'id="jenis_restoran_realisasi" class="inputbox"';
										echo form_dropdown('jenis_restoran_realisasi', $jenis_pajak_restoran, '', $attributes);
									?>
								</td>
							</tr>
							<tr>
								<td class="key" width="100">
									<label for="password">Tanggal Realisasi</label>
								</td>
								<td>
									<input type="text" name="fDate" id="fDate" size="11" />
									S / D
									<input type="text" name="tDate" id="tDate" size="11" />
								</td>
							</tr>
							<tr>
								<td class="key">
									Status SPT
								</td>
								<td>
									<?php
										$attributes = 'id="status_spt_realisasi" name="status_spt_realisasi"';
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
								<td class="key">Kode Kelurahan</td>
								<td>
									<?php
										$attributes = 'id="lurah_id_realisasi" name="lurah_id_realisasi"';
										echo form_dropdown('lurah_id_realisasi', $kelurahan, '', $attributes);
									?>
									&nbsp;
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">						
									<input type="button" name="cetak_realisasi" value="Cetak Excel" class="button">																		
								</td>
							</tr>
						</table>
						
							</TD>
						</tr>
					</table>
				</div>
				</div>
				</div>
				
			<div id="tab3" class="tab_content">
				<div class="col width-51">
				
			<!--	<div id="accordion3">-->
				
						<table class="admintable" border=0 cellspacing="1">
						<tr><TD valign="top">
						<table class="admintable" border=0 cellspacing="1">
							<!-- 
							<tr>
								<td class="key" width="100">
									<label for="password">Tanggal Cetak</label>
								</td>
								<td>
									<input type="text" name="tanggal" id="f_date_c" size="10" value="<?= date('d-m-Y'); ?>" maxlength="10" />
								</td>
							</tr>
							 -->
							<tr>

								<td width="150" class="key">
									<label for="name">Jenis Pajak</label>
								</td>
								<td>
									<?php
										$attributes = 'id="jenis_pajak_pendataan" ';
										echo form_dropdown('jenis_pajak_pendataan', $jenis_pajak, '', $attributes);
									?>
								</td>
							</tr>						
							<tr id="jenis_restoran3" style="display: none;">
								<td class="key">Jenis Restoran</td>
								<td>
									<?php
										$attributes = 'id="jenis_restoran_pendataan" name="jenis_restoran" class="inputbox"';
										echo form_dropdown('jenis_restoran', $jenis_pajak_restoran, '', $attributes);
									?>
								</td>
							</tr>
							<tr>
								<td class="key" width="100">
									<label for="password">Tanggal Entri</label>
								</td>
								<td>
									<input type="text" name="awDate" id="awDate" size="11" />
									S / D
									<input type="text" name="akDate" id="akDate" size="11" />
								</td>
							</tr>
							<tr>
								<td class="key">
									Status SPT
								</td>
								<td>
									<?php
										$attributes = 'id="status_spt_pendataan" name="status_spt_pendataan"';
										echo form_dropdown('status_spt', $keterangan_spt, '', $attributes);
									?>
									</select> &nbsp;
			
								</td>
							</tr>
							<tr>
								<td class="key">Kode Kecamatan</td>
								<td>
									<?php
										$attributes = 'id="camat_id_pendataan" name="camat_id_pendataan"';
										echo form_dropdown('camat_id', $kecamatan, '', $attributes);
									?>
									&nbsp;
								</td>
							</tr>
							<tr>
								<td class="key">Kode Kelurahan</td>
								<td>
									<?php
										$attributes = 'id="lurah_id_pendataan" name="lurah_id_pendataan"';
										echo form_dropdown('lurah_id', $kelurahan, '', $attributes);
									?>
									&nbsp;
								</td>
							</tr>
							<tr>
								<td colspan="2" align="center">						
									<input type="button" name="cetak_pendataan" value="Cetak Excel" class="button">																		
								</td>
							</tr>
						</table>
						
							</TD>
						</tr>
					</table>
				</div>
				<!--</div>-->
				
				</div>
				</div>
				</div>
				</div>
				<div class="clr"></div>
	
			<div class="clr"></div>
		
	<div class="b">
			<div class="b">
				<div class="b"></div>
			</div>
	</div>
	

<script type="text/javascript" src="modules/pembukuan/scripts/form_daftar_rekapitulasi.js"></script>