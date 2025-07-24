<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" id="btn_print">
							<span class="icon-32-print" title="Cetak STS"> </span> Cetak STS
						</a>
					</td>
					<td class="button" id="toolbar-ref">
						<a href="#" id="btn_save">
							<span class="icon-32-save" title="Simpan"> </span> Simpan 
						</a>
					</td>
					<td class="button" id="toolbar-ref">
						<a href="#" id="btn_reset">
							<span class="icon-32-reload" title="Reset"> </span> Reset 
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
						'mode' => 'add',
						'setor_bank_id' => ''
					);
		echo form_open('frm_add_setor_bank', $attributes, $hidden);
		?>
			<table class="admintable" cellspacing="3" style="font-size: 12px;">
           		<tr>
                  	<td class="key" width="10%">Tanggal Penyetoran</td>
           			<td width="200px">
           				<input type="text" name="tgl_penyetoran" id="tgl_penyetoran" size="10" maxlength="10" class="inputbox mandatory" />
           			</td>
           		</tr>
           		<tr>
                  	<td width="10%" class="key">Jenis Pajak</td>
           			<td>
           				<?php
							$attributes = 'id="spt_jenis_pajakretribusi" class="inputbox mandatory"';
							echo form_dropdown('spt_jenis_pajakretribusi', $objek_pajak, '', $attributes);
						?>    				
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
                                	<th width="5%" class="title"></th>
                                   	<th width="10%" class="title">No. SSPD</th>
                                  	<th width="15%" class="title">JUMLAH (Rp.)</th>
                               	</tr>
                           	</thead>
                            <tbody>
                            
                            </tbody>
                    	</table>
					</td>
				</tr>
			</table>
			
			<table width="60%" border="0">
           		<tr>
                	<td align="RIGHT">
                    	<input type="BUTTON" value="TAMBAH DETAIL" id="btn_add_detail"> &nbsp;&nbsp;&nbsp; T O T A L
                        	&nbsp;&nbsp;&nbsp; 
                            <input type="text" name="txt_total_setor" id="txt_total_setor" class="inputbox" size="20" value="" readonly="true" 
                            	style="font-weight: bold; font-size: 15px; color: #18F518; background-color: black; text-align: right;" />
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
	var GLOBAL_SETOR_BANK_VARS = new Array ();
	GLOBAL_SETOR_BANK_VARS["get_penyetoran"] = "<?=base_url();?>bkp/setor_bank/get_nomor_bukti";
	GLOBAL_SETOR_BANK_VARS["insert"] = "<?=base_url();?>bkp/setor_bank/insert";
	GLOBAL_SETOR_BANK_VARS["print"] = "<?=base_url();?>bkp/sts/cetak_sts";
</script>
<script type="text/javascript" src="modules/bkp/scripts/form_setor_bank.js"></script>
