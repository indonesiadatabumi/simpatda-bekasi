<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_cancel">
						<span class="icon-32-cancel" title="Kembali">
						</span>
						Kembali
						</a>
					</td>			
				</tr>
			</table>
		</div>
		<div class="header icon-48-print">
			CETAK MEDIA PENETAPAN SKPDKB
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
		
		$attributes = array('id' => 'frm_penetapan_skpd');
		$hidden = array('mode' => 'add', 'jenis_ketetapan' => $this->config->item('status_skpdkb'));
		echo form_open('frm_penetapan_skpd', $attributes, $hidden);
		?>
		<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td class="key">Tahun</td>
					<td>
						<input type="text" name="tahun" id="tahun" class="inputbox mandatory" size="4" maxlength="4" value="<?=date('Y');?>" <?= $js; ?> />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">Jenis Obyek Pajak</label>
					</td>
					<td>									
						<?php
							$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory"';
							echo form_dropdown('spt_jenis_pajakretribusi', $objek_pajak, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">Tanggal Penetapan</label>
					</td>
					<td>
						<input type="text" name="netapajrek_tgl" id="netapajrek_tgl" class="mandatory" size="11" />
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">Nomor Kohir</label>
					</td>
					<td>
						<input type="text" name="no_kohir1" id="no_kohir1" class="inputbox mandatory" size="5"/> 
						<input type="button" id="trigger_spt1" size="2" value="..." class="button" />
						s/d
						<input type="text" name="no_kohir2" id="no_kohir2" class="inputbox mandatory" size="5"/> 
						<input type="button" id="trigger_spt2" size="2" value="..." class="button" />
					</td>
				</tr>
				<tr>
					<td class="key">Pejabat</td>
					<td>
						<?php
							$attributes = 'id="ddl_mengetahui" class="inputbox"';
							echo form_dropdown('ddl_mengetahui', $pejabat_daerah, '', $attributes);
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="button" name="btn_cetak" id="btn_cetak" value=" Cetak " class="button"/>
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
	GLOBAL_KET_SKPDKB_VARS = new Array();
	GLOBAL_KET_SKPDKB_VARS["get_spt"] = "penetapan/surat_ketetapan/get_penetapan";
	GLOBAL_KET_SKPDKB_VARS["cetak"] = "<?=base_url();?>penetapan/surat_ketetapan/pdf_skpdkb";
</script>
<script type="text/javascript" src="modules/penetapan/scripts/form_ketetapan_skpdkb.js"></script>