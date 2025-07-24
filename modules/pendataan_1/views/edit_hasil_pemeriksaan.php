<?php 
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" id="btn_update" class="toolbar">
						<span class="icon-32-save" title="Save"></span>Update
						</a>
					</td>
					<td class="button" id="toolbar-new">
						<a href="#" id="btn_add" class="toolbar">
						<span class="icon-32-new" title="Baru"></span>Baru
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
			Isian Laporan Hasil Pemeriksaan (LHP): <small><small id='title_head'>[ Edit ]</small></small>
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
		
		$attributes = array('id' => 'frm_edit_lhp');
		$hidden = array('lhp_id' => $row->lhp_id);
		echo form_open('frm_edit_lhp', $attributes, $hidden);
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
										echo form_dropdown('lhp_jenis_pajakretribusi', $jenis_pajak, $row->lhp_jenis_pajakretribusi, $attributes);
									?>
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">NPWPD / NPWRD</label>
								</td>
								<td>
									<input type="hidden" name="wp_wr_id" id="wp_wr_id" value="<?= $row->lhp_idwpwr;?>">
									<input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="inputbox mandatory" size="1" maxlength="1" value="P" readonly="true"/>
									<input type="text" name="wp_wr_golongan" id="wp_wr_golongan" value="<?= $row->wp_wr_gol;?>" class="inputbox npwpd mandatory" size="1" maxlength="1" autocomplete="off" />
									<input type="text" name="wp_wr_jenis_pajak" id="wp_wr_jenis_pajak" value="<?= $row->ref_kodus_kode;?>" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
									<input type="text" name="wp_wr_no_registrasi" id="wp_wr_no_registrasi" value="<?= $row->wp_wr_no_urut;?>" class="inputbox npwpd mandatory" size="7" maxlength="7" autocomplete="off" />
									<input type="text" name="wp_wr_kode_camat" id="wp_wr_kode_camat" value="<?= $row->camat_kode;?>" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
									<input type="text" name="wp_wr_kode_lurah" id="wp_wr_kode_lurah" value="<?= $row->lurah_kode;?>" class="inputbox npwpd mandatory" size="2" maxlength="2" autocomplete="off" />
									<input type="button" id="btn_npwpd" size="2" value="...">
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">Nama WP/WR</label>
								</td>
								<td>
									<input type="text" name="wp_wr_nama" id="wp_wr_nama" value="<?= $row->wp_wr_nama;?>" class="inputbox" size="50" readonly="true" />
								</td>
							</tr>
							<tr>
								<td class="key" valign="top">
									<label for="username">Alamat</label>
								</td>
								<td>		
									<textarea cols="34" rows="3" name="wp_wr_almt" id="wp_wr_almt" class="inputbox" readonly="true" style="text-transform: uppercase;"><?= $row->wp_wr_almt; ?></textarea>
								</td>
							</tr>
							<tr>
								<td class="key" valign="top">
									<label for="password">Kelurahan</label>
						
								</td>
								<td>
									<input type="text" name="wp_wr_lurah" id="wp_wr_lurah" value="<?= $row->wp_wr_lurah;?>" class="inputbox" size="40" readonly="true" />
								</td>
							</tr>
							<tr>
								<td class="key">
									<label for="password2">Kecamatan</label>
						
								</td>
								<td>
									<input type="text" name="wp_wr_camat" id="wp_wr_camat" value="<?= $row->wp_wr_camat;?>" class="inputbox" size="40" readonly="true" />
								</td>
							</tr>
						</table>
					</td>
					<td valign="top" width="35%" class="outsets">
						<table class="admintable" border=0 cellspacing="1">
							<tr>
								<td class="key">Nomor Periksa</td>
								<td>
									<input type="text" name="lhp_no_periksa" id="lhp_no_periksa" onblur="checkNoPeriksa();" value="<?= $row->lhp_no_periksa;?>" class="inputbox mandatory" />
									<span id="callNomor"></span>
								</td>								
							</tr>
							<tr>
								<td class="key">Tanggal Entry</td>
								<td>
									<input type="text" name="lhp_tgl" id="lhp_tgl" size="11" class="inputbox mandatory" value="<?= $row->lhp_tgl;?>" />
								</td>
							</tr>
							<tr>
								<td class="key">Tanggal Pemeriksaan</td>
								<td>
									<input type="text" name="lhp_tgl_periksa" id="lhp_tgl_periksa" size="11" class="inputbox mandatory" value="<?= $row->lhp_tgl_periksa;?>" />
								</td>
							</tr>
							<tr>
								<td class="key">Tahun</td>
								<td>
									<input type="text" name="lhp_periode" id="lhp_periode" class="inputbox mandatory" size="4" maxlength="4" value="<?= $row->lhp_periode; ?>" <?= $js; ?> />
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">Kode  Rekening</label>
								</td>
								<td>
									<input type="hidden" name="lhp_kode_rek" id="lhp_kode_rek" value="<?= $row->lhp_kode_rek;?>">
									<input type="text" name="korek" id="korek" class="inputbox rekening" value="<?= $row->koderek;?>" size="10" readonly="true" />
									Jenis
									<input type="text" name="korek_rincian" id="korek_rincian" class="inputbox rekening" value="<?= $row->jenis;?>" size="2" maxlength="2" />
									Klas
									<input type="text" name="korek_sub1" id="korek_sub1" value="<?= $row->klas;?>" class="inputbox rekening" size="2" maxlength="2" />
									<input type="button" id="trigger_rek" size="2" value="..." >
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">Nama  Rekening</label>
								</td>
								<td>
									<input type="text" name="korek_nama" id="korek_nama" value="<?= $row->korek_nama;?>" class="mandatory" size="40" readonly="true" >
								</td>
							</tr>
							<tr>
								<td width="150" class="key">
									<label for="name">Persen Tarif</label>
								</td>
								<td>
									<input type="text" name="korek_persen_tarif" id="korek_persen_tarif" value="<?= $row->lhp_dt_tarif_persen;?>" class="inputbox" size="5" readonly="true"/> %
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
										echo form_dropdown('lhp_jenis_ketetapan', $ketetapan, $row->lhp_jenis_ketetapan, $attributes);
									?>
								</td>							
							</tr>
							<tr>
								<td class="key">Catatan</td>
								<td>
									<textarea cols="34" rows="3" name="lhp_catatan" id="lhp_catatan" class="inputbox"><?= $row->lhp_catatan; ?></textarea>
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
									<th class="title">(e)=(d) x 2% x jml. bulan</th>
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
								<?php
								$counter = 0;
								if ($row_detail->num_rows() > 0) {

									foreach ($row_detail->result() as $detail) {
								?>			
								<tr class="row0" id="row_detail<?=$counter?>">
									<td valign="top">
									<input type="button" class="refSelf" size="2" value="..." onclick="popupRefSelf (<?=$counter?>)">
									</td>
									<td valign="top">
									<input type="hidden" name="lhp_dt_tarif_persen[]" id="lhp_dt_tarif_persen<?=$counter?>" value="<?=$detail->lhp_dt_tarif_persen?>">
									<input type="hidden" name="lhp_dt_id[]" id="lhp_dt_id<?=$counter?>" value="<?=$detail->lhp_dt_id ?>">

									<input type="text" name="lhp_dt_periode1[]" id="lhp_dt_periode1<?=$counter?>" size="10"  onblur="dateFormat(this,'<?=$counter?>','lhp_dt_periode2<?=$counter?>');callSetorSelf(this.value,document.getElementById('lhp_dt_periode2<?=$counter?>').value,<?=$counter?>);" value="<?=format_tgl($detail->lhp_dt_periode1)?>" />
									</td>
									<td valign="top">	
									<input type="text" name="lhp_dt_periode2[]" id="lhp_dt_periode2<?=$counter?>" size="10" onblur="dateFormat(this,'<?=$counter?>');callSetorSelf(document.getElementById('lhp_dt_periode1<?=$counter?>').value,this.value,<?=$counter?>);" value="<?=format_tgl($detail->lhp_dt_periode2) ?>" />
									</td>
									<td align="right" valign="top">
									<input type="text" name="lhp_dt_dsr_pengenaan[]" id="lhp_dt_dsr_pengenaan<?=$counter?>" onblur="calcTerhutang(<?=$counter?>);this.value=formatCurrency(this.value);" class="numerics" size="17" value="<?=number_format ($detail->lhp_dt_dsr_pengenaan, 2,',','.')?>" onfocus="this.value=unformatCurrency(this.value);" style="text-align:right;"/>
									</td>
									<td align="right" valign="top">
									<input type="text" name="pajak_terhutang[]" id="pajak_terhutang<?=$counter?>" class="inputbox" size="17" value="<?=format_currency($detail->lhp_dt_pajak); ?>"  style="text-align:right;" onblur="calcPengenaan(<?= $counter; ?>);this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);"/>
									</td>
									<td align="right" valign="top">
									Setoran : 
									<input type="text" name="lhp_dt_setoran[]" id="lhp_dt_setoran<?=$counter?>" class="inputbox" size="17" value="<?=number_format ($detail->lhp_dt_setoran, 2,',','.')?>"  style="text-align:right;" onkeyout="calcKreditPajak(<?= $counter; ?>);" onchange="calcKreditPajak(<?= $counter; ?>);" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);"/><br>
									Kompensasi : 
									<input type="text" name="lhp_dt_kompensasi[]" id="lhp_dt_kompensasi<?=$counter?>" class="numerics" size="17" onkeyout="calcKreditPajak(<?=$counter?>);" onchange="calcKreditPajak(<?=$counter?>);" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" style="text-align:right;" value="<?=number_format ($detail->lhp_dt_kompensasi, 2,',','.')?>"/><br>
									Lain-lain : 
									<input type="text" name="lhp_dt_kredit_pjk_lain[]" id="lhp_dt_kredit_pjk_lain<?=$counter?>" class="numerics" size="17" onkeyout="calcKreditPajak(<?=$counter?>);" onchange="calcKreditPajak(<?=$counter?>);" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" style="text-align:right;" value="<?=number_format ($detail->lhp_dt_kredit_pjk_lain, 2,',','.')?>"/><br><hr>
									Total : 
									<?php 
										$total_kredit = $detail->lhp_dt_setoran + $detail->lhp_dt_kompensasi + $detail->lhp_dt_kredit_pjk_lain;
									?>
									<input type="text" name="kredit_pajak[]" id="kredit_pajak<?=$counter?>" class="inputbox" size="17" value="<?=number_format ($total_kredit, 2,',','.')?>" readonly="true" style="text-align:right;"/>

									<td align="right" valign="top">
									<?php 
										$pokok_pajak = $detail->lhp_dt_pajak - $total_kredit;
									?>
									<input type="text" name="pokok_pajak[]" id="pokok_pajak<?=$counter?>" class="inputbox" size="17" value="<?= format_currency($pokok_pajak)?>" readonly="true" style="text-align:right;"/>
									</td>

									<td align="right" valign="top">
									Bunga : 
									<input type="text" name="lhp_dt_bunga[]" id="lhp_dt_bunga<?=$counter?>" class="inputbox" size="17" value="<?=number_format ($detail->lhp_dt_bunga, 2,',','.')?>" onkeyout="calcSanksi(<?= $counter; ?>);" onchange="calcSanksi(<?= $counter; ?>);" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" style="text-align:right;"/><br>
									Kenaikan : 
									<input type="text" name="lhp_dt_kenaikan[]" id="lhp_dt_kenaikan<?=$counter?>" class="numerics" size="17" value="<?=number_format ($detail->lhp_dt_kenaikan, 2,',','.')?>" style="text-align:right;" onkeyout="calcSanksi(<?= $counter; ?>);" onchange="calcSanksi(<?= $counter; ?>);" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" /><br><hr>
									Total : 
									<?php 
										$sanksi = $detail->lhp_dt_bunga + $detail->lhp_dt_kenaikan;
									?>
									<input type="text" name="sanksi[]" id="sanksi<?=$counter?>" class="inputbox" size="17" value="<?=format_currency($sanksi)?>" readonly="true" style="text-align:right;"/>
									</td>

									<td align="right" valign="top">
									<?php 
										$jumlah_pajak = $pokok_pajak + $sanksi;
									?>
									<input type="text" name="jumlah_pajak[]" id="jumlah_pajak<?=$counter?>" class="inputbox" size="17" value="<?=format_currency($jumlah_pajak) ?>" readonly="true" style="text-align:right;"/>
									</td>
									<td><a href="#" onClick="removeFormField('#row_detail<?=$counter?>');calcTotal();return false;">Hapus</a></td>
								</tr>
								<?php 
									}
								}
								?>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td align="center">
						<input type="BUTTON" value="TAMBAH DETAIL" name="btn_add_detail" class="refSelf">
						&nbsp;&nbsp;&nbsp; TOTAL &nbsp;&nbsp;&nbsp; 
						<input type="text" name="total_pajak" id="total_pajak" value="<?= format_currency($row->lhp_pajak); ?>" class="inputbox" size="20" readonly="true"  
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
	GLOBAL_LHP_VARS["update"] = "<?=base_url();?>pendataan/hasil_pemeriksaan/update";
	GLOBAL_LHP_VARS["view"] = "<?=base_url();?>pendataan/hasil_pemeriksaan/view";
	GLOBAL_LHP_VARS["insert"] = "<?=base_url();?>pendataan/hasil_pemeriksaan";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/edit_hasil_pemeriksaan.js"></script>