<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			CETAK MEDIA PENYETORAN SSPD
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
		
		$attributes = array('id' => 'frm_rekap_setoran');
		echo form_open('frm_rekap_setoran', $attributes);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td class="key">
						Periode SPT
					</td>
					<td>
						<input type="text" name="spt_periode" id="spt_periode" size="4" maxlength="4" class="mandatory" value="<?= date('Y');?>" <?= $js; ?> >
					</td>
              	</tr>
               	<tr>
					<td class="key">Jenis Pajak</td>
					<td>
						<?php
							$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory"';
							echo form_dropdown('spt_jenis_pajakretribusi', $objek_pajak, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Nomor Kohir / SPT</label>
					</td>
					<td>
						<table>
							<tr>
								<td>
									<input type="text" name="spt_nomor1" id="spt_nomor1" class="inputbox" size="8" /> 
									<input type="button" id="trigger_spt1" size="2" value="..." class="button"> S/D
								</td> 
								<td>
									<input type="text" name="spt_nomor2" id="spt_nomor2" class="inputbox" size="8" /> 
									<input type="button" id="trigger_spt2" size="2" value="..." class="button" />
									* untuk mencetak satu SSPD, kolom Nomor SPT kedua silahkan dikosongkan
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Kode Ketetapan</label>
					</td>
					<td>
						<?php
							$attributes = 'id="setorpajret_jenis_ketetapan" class="inputbox mandatory"';
							echo form_dropdown('setorpajret_jenis_ketetapan', $keterangan_spt, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
             		<td class="key" width="150">Tanggal Penyetoran</td>
                    <td>
                   		<input type="text" name="tanggal_setor" id="tanggal_setor" size="11" /> * kosongkan jika tidak diikutkan dalam cetakan
               		</td>
              	</tr>
				<tr>
					<td class="key">Penyetor</td>
					<td>
						<input type="text" name="penyetor" id="penyetor" class="inputbox" size="40" value="" tabindex="6"/>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" name="btn_cetak_sspd" id="btn_cetak_sspd" value=" Cetak " class="button" />
						<input type="submit" name="btn_billing" id="btn_billing" value=" Billing " class="button" />
					</td>
				</tr>
			</table>
		</div>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var GLOBAL_SETOR_PAJAK_VARS = new Array ();
	GLOBAL_SETOR_PAJAK_VARS["get_spt"] = "bkp/rekam_pajak/get_sspd";
	GLOBAL_SETOR_PAJAK_VARS["sspd"] = "<?=base_url();?>bkp/rekam_pajak/cetak_multi_sspd";
	GLOBAL_SETOR_PAJAK_VARS["bill"] = "<?=base_url();?>bkp/rekam_pajak/cetak_multi_billing";
</script>
<script type="text/javascript" src="modules/bkp/scripts/form_cetak_sspd.js"></script>