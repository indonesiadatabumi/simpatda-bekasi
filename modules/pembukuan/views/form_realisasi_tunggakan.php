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
				<form name="adminForm" id="adminForm">
					<div class="col width-51">
						<fieldset class="adminform">
						<legend>FORM DAFTAR REKAPITULASI</legend>
	
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
							<td class="key">Jenis Daftar</td>
							<td>
								<?php
									$attributes = 'id="jenis_daftar" name="jenis_daftar"';
									echo form_dropdown('jenis_daftar', $jenis_daftar, '', $attributes);
								?>
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
				</table>
			</fieldset>
			</div>
		</form>
		<div class="clr"></div>
		</div>
	</div>
	<div class="b">
			<div class="b">
				<div class="b"></div>
			</div>
	</div>

<script type="text/javascript" src="../../assets/scripts/jquery/jquery-1.8.2.js"></script>
<script type="text/javascript" src="../../assets/scripts/jquery/jquery.download.js"></script>
<script type="text/javascript" src="../../modules/pembukuan/scripts/form_realisasi_tunggakan.js"></script>