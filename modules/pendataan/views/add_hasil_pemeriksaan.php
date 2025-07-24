<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" id="btn_save" class="toolbar">
						<span class="icon-32-save" title="Save">
						</span>
						Simpan
						</a>
					</td>
					<td class="button" id="toolbar-ref">
						<a href="#" id="btn_view" class="toolbar">
							<span class="icon-32-ref" title="Lihat Data"></span>Lihat Data
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-lhp">
			Isian Laporan Hasil Pemeriksaan (LHP): <small><small id='title_head'>[ Baru ]</small></small>
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
		<?php
		$js = 'onKeypress = "return numbersonly(this, event)"';
		
		$attributes = array('id' => 'frm_add_lhp');
		echo form_open('frm_add_lhp', $attributes);
		?>
		<div class="col width-100">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td valign="top" width="35%" class="outsets">
						<table class="admintable" border=0 cellspacing="1">
							<tr>
								<td width="150" class="key">
									<label for="name">Jenis Pajak</label>
								</td>
								<td>
									<?php
										$attributes = 'id="lhp_jenis_pajakretribusi" class="inputbox mandatory"';
										echo form_dropdown('lhp_jenis_pajakretribusi', $jenis_pajak, '', $attributes);
									?>
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">NPWPD / NPWRD</label>
								</td>
								<td>
									<input type="hidden" name="wp_wr_id" id="wp_wr_id">
									<input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="inputbox mandatory" size="1" maxlength="1" value="P" readonly="true"/>
									<input type="text" name="wp_wr_golongan" id="wp_wr_golongan" class="inputbox npwpd mandatory" size="1" maxlength="1" autocomplete="off" />
									<input type="text" name="wp_wr_jenis_pajak" id="wp_wr_jenis_pajak" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
									<input type="text" name="wp_wr_no_registrasi" id="wp_wr_no_registrasi" class="inputbox npwpd mandatory" size="7" maxlength="7" autocomplete="off" />
									<input type="text" name="wp_wr_kode_camat" id="wp_wr_kode_camat" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
									<input type="text" name="wp_wr_kode_lurah" id="wp_wr_kode_lurah" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
									<input type="button" id="btn_npwpd" size="2" value="..." class="button" >
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">Nama WP/WR</label>
								</td>
								<td>
									<input type="text" name="wp_wr_nama" id="wp_wr_nama" class="inputbox" size="50" readonly="true" />
								</td>
							</tr>
							<tr>
								<td class="key" valign="top">
									<label for="username">Alamat</label>
								</td>
								<td>		
									<textarea cols="34" rows="3" name="wp_wr_almt" id="wp_wr_almt" class="inputbox" readonly="true" style="text-transform: uppercase;"></textarea>
								</td>
							</tr>
							<tr>
								<td class="key" valign="top">
									<label for="password">Kelurahan</label>
						
								</td>
								<td>
									<input type="text" name="wp_wr_lurah" id="wp_wr_lurah" class="inputbox" size="40" readonly="true" />
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="password2">Kecamatan</label>
						
								</td>
								<td>
									<input type="text" name="wp_wr_camat" id="wp_wr_camat" class="inputbox" size="40" readonly="true" />
								</td>
							</tr>
						</table>
					</td>
					<td valign="top" width="35%" class="outsets">
						<table class="admintable" border=0 cellspacing="1">
							<tr>
								<td class="key">Nomor Ketetapan</td>
								<td>
									<input type="text" name="lhp_no_periksa" id="lhp_no_periksa" onblur="checkNoPeriksa();" class="inputbox mandatory" />
									<span id="callNomor"></span>
								</td>								
							</tr>
							<tr>
								<td class="key">Tanggal Entry</td>
								<td>
									<input type="text" name="lhp_tgl" id="lhp_tgl" size="11" class="inputbox mandatory" />
								</td>
							</tr>
							<tr>
								<td class="key">Tanggal Pemeriksaan</td>
								<td>
									<input type="text" name="lhp_tgl_periksa" id="lhp_tgl_periksa" size="11" class="inputbox mandatory" />
								</td>
							</tr>
							<tr>
								<td class="key">Tahun</td>
								<td>
									<input type="text" name="lhp_periode" id="lhp_periode" class="inputbox mandatory" size="4" maxlength="4" value="<?= date('Y'); ?>" <?= $js; ?> />
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">Kode  Rekening</label>
								</td>
								<td>
									<input type="hidden" name="lhp_kode_rek" id="lhp_kode_rek">
									<input type="text" name="korek" id="korek" class="inputbox rekening" value="" size="10" readonly="true" />
									Jenis
									<input type="text" name="korek_rincian" id="korek_rincian" class="inputbox rekening" size="2" maxlength="2" />
									Klas
									<input type="text" name="korek_sub1" id="korek_sub1" class="inputbox rekening" size="2" maxlength="2" />
									<input type="button" id="trigger_rek" size="2" value="..." >
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">Nama  Rekening</label>
								</td>
								<td>
									<input type="text" name="korek_nama" id="korek_nama" class="mandatory" size="40" readonly="true" >
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">Persen Tarif</label>
								</td>
								<td>
									<input type="text" name="korek_persen_tarif" id="korek_persen_tarif" class="inputbox" size="5" readonly="true"/> %
								</td>
							</tr>
						</table>
					</td>
					
					<td valign="top" >
						<table class="admintable" border=0 cellspacing="1">
							<tr>
								<td class="key">Jenis Ketetapan</td>
								<td>
									<?php
										$attributes = 'id="lhp_jenis_ketetapan" class="inputbox mandatory"';
										echo form_dropdown('lhp_jenis_ketetapan', $ketetapan, '', $attributes);
									?>
								</td>							
							</tr>
							<tr>
								<td class="key">Catatan</td>
								<td>
									<textarea cols="34" rows="3" name="lhp_catatan" id="lhp_catatan" class="inputbox"></textarea>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
			<table class="admintable" border=0 cellspacing="1" width=100%>
				<tr>
					<td valign="top">
						<table class="adminlist" cellspacing="1" id="detailTable" border="0">
							<thead>
								<tr>
									<th class="title" rowspan="2">Ref. Self</th>
									<th class="title" rowspan="2">Periode</th>
									<th class="title" rowspan="2">S/D Periode</th>
									<th class="title">Dasar Pengenaan</th>
									<th class="title">Pajak Terhutang</th>
									<th class="title" width="270">Kredit Pajak</th>
									<th class="title">Pokok Pajak</th>
									<th class="title" width="250">Sanksi</th>
									<th class="title">Jumlah Pajak</th>

									<th class="title" rowspan="2"><span id="callSelf"></span></th>
								</tr>
								<tr>
									<th class="title">(a)</th>
									<th class="title">(b)</th>
									<th class="title">(c)</th>
									<th class="title">(d)=(b-c)</th>
									<th class="title">(e)=(d) x 1.8 % x jml. bulan</th>
									<th class="title">(f)=(d+e)</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<td colspan="12">
									</td>
								</tr>
							</tfoot>
							
							<tbody>
								
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center">
						<input type="BUTTON" value="TAMBAH DETAIL" name="btn_add_detail" class="refSelf">
						&nbsp;&nbsp;&nbsp; TOTAL &nbsp;&nbsp;&nbsp; 
						<input type="text" name="total_pajak" id="total_pajak" class="inputbox" size="20" readonly="true"  
							style="font-weight:bold;font-size:25px;color:#18F518;background-color:black;text-align:right;"/>
					</td>
				</tr>				
			</table>
		</div>
		<?=	form_close(); ?>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_LHP_VARS = new Array ();
	GLOBAL_LHP_VARS["get_rekening"] = "rekening/popup_rekening";
	GLOBAL_LHP_VARS["insert"] = "<?=base_url();?>pendataan/hasil_pemeriksaan/save";
	GLOBAL_LHP_VARS["view"] = "<?=base_url();?>pendataan/hasil_pemeriksaan/view";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/add_hasil_pemeriksaan.js"></script>