<?php 
	error_reporting(E_ERROR | E_WARNING);
	
	if (count($ar_rekam_setor) > 0) {
?>

	<form name="frm_list_setoran_pajak" id="frm_list_setoran_pajak">
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1" width="100%">
				<tr>
					<td align="center" colspan="3">
						<span style="font-size: 12px; font-weight: bold; letter-spacing:3px">DETAIL SETORAN PAJAK</span> <br/>
					</td>
				</tr>
				<tr>
					<td align="right" class="outsets">
						<table class="admintable" border=0 cellspacing="1" width="100%">
							<tr>
								<td class="key">
									NPWPD
								</td>
								<td align="left">
									<input type="text" name="npwprd" id="npwprd" class="inputbox" size="30" maxlength="20" readonly="true" value="<?= $ar_rekam_setor[0]['npwprd']; ?>"/>
								</td>
							</tr>
							
							<tr>
								<td class="key" width="500">
									Nama
								</td>
								<td align="left">
									<input type="text" name="wp_wr_nama" id="wp_wr_nama" class="inputbox" size="40" maxlength="50" readonly="true" value="<?= $ar_rekam_setor[0]['wp_wr_nama']; ?>"/>
							</tr>
							<tr>
								<td class="key">
									Alamat
								</td>
								<td align="left">
									<input type="text" name="wp_wr_almt" id="wp_wr_almt" class="inputbox" size="80" maxlength="50" readonly="true" value="<?= $ar_rekam_setor[0]['wp_wr_almt']; ?>"/>
							</tr>
							<?php if ($ar_rekam_setor[0]['spt_jenis_pajakretribusi'] != "4") { ?>
							<tr>
								<td>
								</td>
								<td align="left">								
									<input type="text" name="wp_wr_lurah" id="wp_wr_lurah" class="inputbox" size="30" maxlength="30" readonly="true" value="<?= $ar_rekam_setor[0]['wp_wr_lurah']; ?>"/>
									<input type="text" name="wp_wr_camat" id="wp_wr_camat" class="inputbox" size="30" maxlength="30" readonly="true" value="<?= $ar_rekam_setor[0]['wp_wr_camat']; ?>"/>								
								</td>
							</tr>
							<?php } ?>
						</table>
					</td>
					<td valign="top" class="outsets">
						<table>
							<tr>
								<td class="key">
									Tahun
								</td>
								<td align="left">
									<input type="text" name="periode_spt" id="periode_spt" class="inputbox" size="4" maxlength="4" readonly="true" value="<?= $ar_rekam_setor[0]['spt_periode']; ?>"/>
								</td>
							</tr>

							<tr>
								<td class="key">
									Nomor Kohir/SPT
								</td>
								<td align="left">
									<input type="text" name="nomor_spt" id="nomor_spt" class="inputbox" size="10" maxlength="10" readonly="true" value="<?= $ar_rekam_setor[0]['spt_nomor']; ?>"/>
								</td>
							</tr>
							
							<tr>
								<td class="key">
									Masa Pajak
								</td>
								<td align="left">
									<input type="text" name="spt_periode_jual1" id="fDate" readonly="true" value="<?= format_tgl($ar_rekam_setor[0]['spt_periode_jual1']);?>" size="11" />
									S / D
									<input type="text" name="spt_periode_jual2" id="tDate" readonly="true" value="<?= format_tgl($ar_rekam_setor[0]['spt_periode_jual2']);?>" size="11" />
								</td>
							</tr>

							<tr>
								<td class="key">
									Jatuh Tempo</td>
								<td align="left">
									<input type="text" name="txt_jatuh_tempo" id="txt_jatuh_tempo" class="inputbox" size="10" maxlength="10" readonly="true" value="<?= format_tgl($ar_rekam_setor[0]['tgl_jatuh_tempo']); ?>"/>
								</td>
							</tr>							
						</table>
					</td>
					<td valign="top">
						<table class="toolbar">
							<tr>
								<td class="button" >
									<a href="#" id="btn_cetak_sspd" class="toolbar">
									<span class="icon-32-print" title="Cetak SSPD"></span>
									Cetak SSPD
									</a>
								</td>
								<td class="button">
									<a href="#" id="btn_cetak_sts" class="toolbar" style="display: none;">
									<span class="icon-32-print" title="Cetak STS"></span>
									Cetak STS
									</a>
								</td>							
							</tr>
							<tr>
								<td class="button">
									<a href="#" id="btn_cetak_sts_tampung" class="toolbar" style="display: none;">
									<span class="icon-32-print" title="Cetak STS"></span>
									Cetak STS Tampung 
									</a>
								</td>
								<td class="button">
									<a href="#" id="btn_tampung" class="toolbar" style="display: none;">
									<span class="icon-32-new1" title="Tampung"></span>
									Tampung
									</a>
								</td>
								<td class="button" >
									<a href="#" id="btn_empty" class="toolbar" style="display: none;">
									<span class="icon-32-delete1" title="Kosongkan Penampungan"></span>
									Kosongkan
									</a>
								</td>
							</tr>
						</table>
					</td>						
				</tr>
				<tr>
					<td colspan="2" class="outsets" valign="top">
						<table class="adminlist" style="width: 100%" colspan="2">
							<thead>
								<tr>
									<th class="title" width="5%">No</th>
									<th class="title" width="15%">Kode Rekening</th>
									<th class="title" width="60%">Nama Rekening</th>
									<th class="title" width="15%">Jumlah</th>
								</tr>
							</thead>
							
							<tbody id="tbl_menu">
							<?php
							$counter = 1;
							$total=0;
	
							foreach ($ar_rekam_setor as $k => $v) {
								$total += $v['spt_dt_pajak'];
							?>
								<tr class="row0">
									<td width="30">
										<?= $counter; ?>
									</td>
									<td>
										<input type="hidden" name="spt_dt_korek[]" value="<?= $v['spt_dt_korek']; ?>">
										
										<?= $v['koderek_detail']; ?>
									</td>
									<td><?= $v['korek_nama_detail']; ?></td>
									<td align="right">
										<input type="hidden" name="spt_dt_pajak[]" value="<?= $v['spt_dt_pajak']; ?>"> 
										<?= format_currency($v['spt_dt_pajak']); ?>
									</td>
								</tr>
							<?php 
								$counter++;
							}	
							?>
							
							</tbody>
						</table>
					</td>
					<td rowspan="2" valign="top">
						<table class="admintable" align="right">
							<tr>
								<td>
									<table border=0 cellspacing="1" width="100%">
									<?php 
									if ( $v['koderek_detail'] =='4.1.1.08.01' || $v['koderek_detail'] =='4.1.1.04.01' || $v['koderek_detail'] =='4.1.1.04.02' || $v['koderek_detail'] =='4.1.1.04.03' || $v['koderek_detail'] =='4.1.1.04.04' || $v['koderek_detail'] =='4.1.1.04.05' || $v['koderek_detail'] =='4.1.1.04.06' 
					|| $v['koderek_detail'] =='4.1.1.04.07' || $v['koderek_detail'] =='4.1.1.04.08' || $v['koderek_detail'] =='4.1.1.04.09' || $v['koderek_detail'] =='4.1.1.04.10' || $v['koderek_detail'] =='4.1.1.04.12'){
									
									?>
										<tr>
											<td class="key">Jenis Setoran</td>
											<td>
												<select name="jenis_setoran"><option value="2">Pokok Pajak </option>
												<select>
											</td>
										</tr>
									<?php }	else { ?>

										<tr>
											<td class="key">Jenis Setoran</td>
											<td>
												<?php 
													$attributes = 'id="jenis_setoran" class="inputbox mandatory"';
													echo form_dropdown('jenis_setoran', $jenis_setoran, '', $attributes);
												?>
											</td>
										</tr>

									
									<?php
								}  
									$tgl_setoran1= $this->input->post('tanggal_setor');
									$tgl_setoran=substr($tgl_setoran1,3,2);
								
									if ($tgl_setoran==11){
									$diskon= $total * 0.15;
			
									}else if ($tgl_setoran==12){
									$diskon= $total* 0.10;
			
									}


									if ( $v['koderek_detail'] =='4.1.1.08.01' || $v['koderek_detail'] =='4.1.1.04.01' || $v['koderek_detail'] =='4.1.1.04.02' || $v['koderek_detail'] =='4.1.1.04.03' || $v['koderek_detail'] =='4.1.1.04.04' || $v['koderek_detail'] =='4.1.1.04.05' || $v['koderek_detail'] =='4.1.1.04.06' 
					|| $v['koderek_detail'] =='4.1.1.04.07' || $v['koderek_detail'] =='4.1.1.04.08' || $v['koderek_detail'] =='4.1.1.04.09' || $v['koderek_detail'] =='4.1.1.04.10' || $v['koderek_detail'] =='4.1.1.04.12'){

										$total_setoran=$total-$diskon;

									}else {$total_setoran=$total+$denda;}
								//	 format_currency($total+$denda); 
									?>
											<tr>
											<td class="key">Jumlah Setoran</td>
											<td>
											<input type="hidden" name="korek_reklame_air" value="<?= $v['koderek_detail']; ?>">
												<input type="text" name="txt_setoran" id="txt_setoran" value="<?= format_currency($total_setoran); ?>" class="inputbox" 
													style="font-weight: bold; text-align: right;" size="17" maxlength="40" readonly="true"  />
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center">
												<input type="button" id="btn_setor" title="Lakukan Penyetoran" value="Simpan Setoran" class="button" 
													style="padding: 5px 3px 5px 3px;letter-spacing: 1px;">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					
					</td>
				</tr>
				<tr>
					<td align="right" colspan="2">
						<table class="admintable" align="right">
						<?php  
				//		if (($v['koderek_detail'] =='4.1.1.08.01' || $v['koderek_detail'] =='4.1.1.04.01' ) and empty($denda)){
					if ( $v['koderek_detail'] =='4.1.1.08.01' || $v['koderek_detail'] =='4.1.1.04.01' || $v['koderek_detail'] =='4.1.1.04.02' || $v['koderek_detail'] =='4.1.1.04.03' || $v['koderek_detail'] =='4.1.1.04.04' || $v['koderek_detail'] =='4.1.1.04.05' || $v['koderek_detail'] =='4.1.1.04.06' 
					|| $v['koderek_detail'] =='4.1.1.04.07' || $v['koderek_detail'] =='4.1.1.04.08' || $v['koderek_detail'] =='4.1.1.04.09' || $v['koderek_detail'] =='4.1.1.04.10' || $v['koderek_detail'] =='4.1.1.04.12'){
						?>
							<tr>
								<td class="key">Pokok Pajak (Rp.)</td>
								<td align="right">
									<input type="text" name="txt_pokok_pajak" id="txt_pokok_pajak" class="inputbox" size="20" maxlength="50" readonly="true" style="text-align: right;" value="<?= format_currency($total); ?>"/>
								</td>						
							</tr>
							<tr>
								<td class="key">Diskon %</td>
								<td align="right">
									<input type="text" name="txt_diskon" id="txt_diskon" class="inputbox" size="20" maxlength="50" readonly="true" style="text-align: right;" value="<?= format_currency($diskon); ?>"/>
								</td>						
							</tr>
							
						<?php

						}else {
							?>

							<tr>
							<td class="key">Pokok Pajak (Rp.)</td>
							<td align="right">
								<input type="text" name="txt_pokok_pajak" id="txt_pokok_pajak" class="inputbox" size="20" maxlength="50" readonly="true" style="text-align: right;" value="<?= format_currency($total); ?>"/>
							</td>						
						</tr>
					<?php
						}
							if (  $denda > 0) {
							?>
							<tr>
								<td class="key">Sanksi / Denda (Rp.)</td>
								<td align="right">
									<input type="text" name="txt_denda" id="txt_denda" class="inputbox" size="20" maxlength="40" readonly="true" style="text-align: right;" value="<?= format_currency($denda); ?>"/>
								</td>
							</tr>
							<?php 
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</TD>
	</tr>
	</table>
	</div>

	<div class="clr"></div>
	<input type="hidden" name="cetak" value="0">
	<input type="hidden" name="setor_id" value="">
	<input type="hidden" name="penyetor" id="penyetor" value="">
	<input type="hidden" name="wp_id" value="<?= $ar_rekam_setor[0]['spt_idwpwr'];?>">
	<input type="hidden" name="spt_pen_id" value="<?= $ar_rekam_setor[0]['spt_pen_id'];?>">
	<input type="hidden" name="via_bayar" id="via_bayar" value="<?= $this->input->post('via_bayar'); ?>">
	<input type="hidden" name=setorpajret_jenis_ketetapan id="setorpajret_jenis_ketetapan" value="<?= $ar_rekam_setor[0]['ketspt_id']; ?>"/>
	<input type="hidden" name="tanggal_setor" id="tanggal_setor" value="<?= $this->input->post('tanggal_setor'); ?>">
	<input type="hidden" name="spt_jenis_pajakretribusi" id="spt_jenis_pajakretribusi" value="<?= $ar_rekam_setor[0]['spt_jenis_pajakretribusi']; ?>">

	</form>
		
<script type="text/javascript">
	var GLOBAL_LIST_SETOR_PAJAK_VARS = new Array ();
	GLOBAL_LIST_SETOR_PAJAK_VARS["cetak_sts"] = "<?=base_url();?>bkp/setor_bank/form_cetak_sts";
	GLOBAL_LIST_SETOR_PAJAK_VARS["cetak_sts_cart"] = "<?=base_url();?>bkp/cart/check_cart";
	GLOBAL_LIST_SETOR_PAJAK_VARS["add_cart"] = "<?=base_url();?>bkp/cart/add_cart";
	GLOBAL_LIST_SETOR_PAJAK_VARS["empty_cart"] = "<?=base_url();?>bkp/cart/empty_cart";
	GLOBAL_LIST_SETOR_PAJAK_VARS["sspd"] = "<?=base_url();?>bkp/rekam_pajak/cetak_sspd_pdf";
	GLOBAL_LIST_SETOR_PAJAK_VARS["setor_pajak"] = "<?=base_url();?>bkp/rekam_pajak/insert_setor_pajak";
	GLOBAL_LIST_SETOR_PAJAK_VARS["cancel"] = "<?=base_url();?>bkp/rekam_pajak/setor_pajak";
</script>
<script type="text/javascript" src="modules/bkp/scripts/form_list_setoran_pajak.js"></script>

<?php 
	} else {
		echo "<span style='font-weight: bold;font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: #fff;background: red;'>
			Data tidak ditemukan. Periksa terlebih dahulu data yang akan disetorkan.</span>";
	}
?>