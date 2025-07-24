<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" id="btn_print" style="display: none;">
							<span class="icon-32-print" title="Cetak STS"> </span> Cetak STS
						</a>
					</td>
					<td class="button" id="toolbar-ref">
						<a href="#" id="btn_save">
							<span class="icon-32-save" title="Simpan"> </span> Simpan 
						</a>
					</td>
					<td class="button" id="toolbar-ref">
						<a href="#" id="btn_back">
							<span class="icon-32-back" title="Kembali"> </span> Kembali 
						</a>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="header icon-48-setoran_bank">
			CETAK SURAT TANDA SETORAN KE BANK - <small><small id='title_head'>[ Baru ]</small></small>
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
		<?php
		$js = 'onKeypress = "return numbersonly(this, event)"';
		
		$attributes = array('id' => 'frm_add_setor_bank');
		$hidden = array(
						'mode' => 'cart', 
						'setoran_id' => $setoran_id,
						'is_cart' => $this->input->post('cart'),
						'setor_bank_id' => ''
					);
		echo form_open('frm_add_setor_bank', $attributes, $hidden);
		?>
			<table class="admintable" cellspacing="3" style="font-size: 12px;">
           		<tr>
                  	<td class="key" width="10%">Tanggal Penyetoran</td>
           			<td width="200px">
           			<?php 
           				$tgl_penyetoran = "";
           				if ($arr_data->num_rows() > 0) {
           					$row = $arr_data->row();
           					$tgl_penyetoran = format_tgl($row->setorpajret_tgl_bayar);
           				}
           			?>
           				<input type="text" name="tgl_penyetoran" id="tgl_penyetoran"  size="10" value="<?= $tgl_penyetoran; ?>" maxlength="10" class="inputbox mandatory" />
           			</td>
           		</tr>
           		<tr>
                  	<td width="10%" class="key">Dari</td>
           			<td>
           				<?php
							$attributes = 'id="ddl_dari" class="inputbox"';
							echo form_dropdown('ddl_dari', $uptd, "", $attributes);
						?>
           				<input type="text" name="txt_dari" id="txt_dari" size="50" readonly="readonly" class="inputbox mandatory" /> *	
           			</td>
           		</tr>
           		<tr>
                  	<td width="10%" class="key">Alamat</td>
           			<td>
           				<input type="text" name="txt_alamat" id="txt_alamat" readonly="readonly" class="inputbox mandatory" size="80"/> *			
           			</td>
           		</tr>
           		<tr>
                  	<td width="10%" class="key">Keterangan / Uraian</td>
           			<td>
           				<input type="text" name="txt_keterangan" id="txt_keterangan" class="inputbox" size="100"/>			
           			</td>
           		</tr>
           		<tr>
                  	<td width="10%" class="key">Bukti Setoran</td>
           			<td>
           				<?php
							$attributes = 'id="ddl_bukti_setoran" class="inputbox"';
							echo form_dropdown('ddl_bukti_setoran', $bukti_setoran, "", $attributes);
						?>			
           			</td>
           		</tr>
			</table>
			
			<table border="0" width="60%">
				<tr>
					<td valign="top">
						<table class="adminlist" style="font-size: 12px;" id="detailTable">
                       		<thead>
                            	<tr>
                                	<th width="3%" class="title"></th>
                                   	<th width="10%" class="title">Kode Rekening</th>
                                   	<th width="20%" class="title">Uraian</th>
                                  	<th width="10%" class="title">Jumlah (Rp.)</th>
                               	</tr>
                           	</thead>
                            <tbody>
                            <?php 
                            $counter = 1;
                            $total = 0;
                            
                            if ($arr_data->num_rows() > 0) {
	                            foreach ($arr_data->result() as $row) {
	                            	$total += $row->setorpajret_dt_jumlah;
	                            	$masa_pajak = $row->setorpajret_periode_jual1;
									$arr_masa_pajak = explode("-", $masa_pajak);
	                    	
	                        ?>
	                        	<tr>
	                        		<td align="center"><?= $counter; ?></td>
	                        		<td align="center"><?= $row->koderek; ?></td>	                        
	                        
	                        		<?php 
	                        		if ($row->korek_jenis == "1") {                       		
	                        		?>	                        		
	                        		<td><?= $row->korek_nama." - ".getNamaBulan($arr_masa_pajak[1])." ".$arr_masa_pajak[0]; ?></td>
	                        		<?php 
	                        		} else {                		
	                        		?>
	                        		<td><?= $row->korek_nama; ?></td>
	                        		<?php } ?>
	                        		
	                        		<td align="right"><?= format_currency($row->setorpajret_dt_jumlah); ?></td>
	                        	</tr>	                        
	                        <?php 
	                        	$counter++;
	                            }
                            }                            
                            ?>
                            	<tr>
                            		<td align="center" colspan="3" style="font-weight: bold">T O T A L</td>
                            		<td align="right">
                            			<input type="text" name="txt_total_setor" id="txt_total_setor" value="<?= format_currency($total); ?>" class="inputbox" 
                            				readonly="true" style="font-weight: bold; font-size: 14px; color: #18F518; background-color: black; text-align: right;" /> 
                            		</td>
                            	</tr>
                            </tbody>                      
                    	</table>
					</td>
				</tr>
			</table>
		<?php 
		echo form_close();
		?>
	<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_FORM_CETAK_STS_VARS = new Array ();
	GLOBAL_FORM_CETAK_STS_VARS["get_penyetoran"] = "<?=base_url();?>bkp/setor_bank/get_nomor_bukti";
	GLOBAL_FORM_CETAK_STS_VARS["insert"] = "<?=base_url();?>bkp/setor_bank/insert";
	GLOBAL_FORM_CETAK_STS_VARS["print"] = "<?=base_url();?>bkp/sts/cetak_sts";
	GLOBAL_FORM_CETAK_STS_VARS["empty_cart"] = "<?=base_url();?>bkp/cart/empty_cart";
	GLOBAL_FORM_CETAK_STS_VARS["back"] = "<?=base_url();?>bkp/rekam_pajak/setor_pajak";
</script>
<script type="text/javascript" src="modules/bkp/scripts/form_cetak_sts.js"></script>
