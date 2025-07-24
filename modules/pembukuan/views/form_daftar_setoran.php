
<div id="toolbar-box">
   			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>

			<div class="m">
			<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr></tr>
			</table>
			</div>
			<div class="header icon-48-print">
				Cetak Daftar Setoran
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
 		<div class="t">

			<div class="t"></div>
 		</div>
	</div>
	<div class="m">
		<form name="adminForm" id="adminForm">
			<div id="accordion">
				<h3>Berdasarkan Tanggal Setoran</h3>
			  	<div>
					<table class="admintable" border=0 cellspacing="1">
						<tr>
							<td class="key">
								<label for="password">Jenis Pajak</label>
							</td>
							<td>									
								<?php
									$attributes = 'id="jenis_pajak" class="inputbox mandatory"';
									echo form_dropdown('jenis_pajak', $jenis_pajak, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								Tanggal Setoran
							</td>
							<td>
								<input type="text" name="fDate" id="fDate" size="11" tabindex="1"/> 										
								S/D <input type="text" name="tDate" id="tDate" size="11" tabindex="2"/>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="button" name="btn_setoran_cetak" id="btn_setoran_cetak" value=" Cetak " class="button" />
							</td>
						</tr>
					</table>
			 	</div>
			  	<h3>Berdasarkan Bulan Ketetapan</h3>
			  	<div>
				    <table class="admintable" border=0 cellspacing="1">
						<tr>
							<td class="key">
								<label for="password">Jenis Pajak</label>
							</td>
							<td>									
								<?php
									$attributes = 'id="jenis_pajak" class="inputbox mandatory"';
									echo form_dropdown('jenis_pajak', $jenis_pajak, '', $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								Bulan Ketetapan
							</td>
							<td>
								<?php
									$attributes = 'id="bulan_ketetapan" class="inputbox"';
									echo form_dropdown('bulan_ketetapan', get_month(), date("n") - 1, $attributes);
								?>
								<?php
									$attributes = 'id="tahun_ketetapan" class="inputbox"';
									echo form_dropdown('tahun_ketetapan', $tahun_ketetapan, date("Y"), $attributes);
								?>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label>Lihat Daftar</label>
							</td>
							<td>									
								<select name="jenis_daftar" id="jenis_daftar">
									<option value="1">Sudah Setoran</option>
									<option value="2">Belum Setoran</option>
									<option value="0">Semua Ketetapan</option>
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="button" name="btn_ketetapan_cetak" id="btn_ketetapan_cetak" value=" Cetak " class="button" />
							</td>
						</tr>
					</table>
			  	</div>
			</div>
		</form>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="modules/pembukuan/scripts/form_daftar_setoran.js"></script>