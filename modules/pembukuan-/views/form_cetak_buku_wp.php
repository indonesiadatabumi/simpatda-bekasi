
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
				Cetak Buku WAJIB PAJAK / RETRIBUSI
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
	<div class="col width-51">
			<table class="admintable" border=0 cellspacing="1">
			<tr><TD valign="top">
			<table class="admintable" border=0 cellspacing="1">
                                <tr>
                                      <td width="150" class="key"> Tahun Pajak </td>
                                      <td> 
                                          <input type="text" name="thn_pajak" id="thn_pajak" class="inputbox" size="5" maxlength="4" value="<?=date('Y');?>" autocomplete="off" />
                                      </td>
                                </tr>
                       
                                <tr>
                                      <td width="150" class="key"> Jenis Pemungutan </td>
                                      <td> 
                                          <select name="jepem" id="jepem">  <option value=""> </option>
                                                <option value="1"> Self Assesment </option>
                                                <option value="2"> Official Assesment </option>
                                          </select>
                                      </td>
                                </tr>
                              
				<tr>
					<td width="150" class="key">
						<label for="name"> Nomor Wajib Pajak/Restribusi </label>
					</td>      
					<td>    
						<input type="hidden" name="wp_wr_id" id="wp_wr_id">
						<input type="text" name="wp_wr_kode_pajak" id="wp_wr_kode_pajak" class="inputbox mandatory" size="1" maxlength="1" value="P" readonly="true"/>
						<input type="text" name="wp_wr_golongan" id="wp_wr_golongan" class="inputbox npwpd mandatory" size="1" maxlength="1" readonly="true" />
						<input type="text" name="wp_wr_jenis_pajak" id="wp_wr_jenis_pajak" class="inputbox npwpd mandatory" size="2" maxlength="2" readonly="true" />
						<input type="text" name="wp_wr_no_registrasi" id="wp_wr_no_registrasi" class="inputbox npwpd mandatory" size="7" maxlength="7" readonly="true" />
						<input type="text" name="wp_wr_kode_camat" id="wp_wr_kode_camat" class="inputbox npwpd mandatory" size="2" maxlength="2" readonly="true" />
						<input type="text" name="wp_wr_kode_lurah" id="wp_wr_kode_lurah" class="inputbox npwpd mandatory" size="2" maxlength="2" readonly="true" />
						<input type="button" id="btn_npwpd" size="2" value="...">
					</td>
				</tr>
				<tr>
					<td class="key" width="100">
						<label for="password"> Tanggal Cetak </label>
					</td>
					<td>
						<input type="text" name="tgl_cetak" id="tgl_cetak" size="10" value="<?= date('d-m-Y'); ?>" maxlength="10" onchange="dateFormat(this);"/>
					</td>
				</tr>
				<tr>
					<td class="key"> </td>
					<td>
						<input type="button" name="btn_cetak" id="btn_cetak" value="Cetak">
					</td>
				</tr>
			</table>
			</td>
			</tr>
		</table>
		<!--</fieldset>-->
	</div>
	<div class="clr"></div>
	
<script type="text/javascript">
	var GLOBAL_CETAK_BUKU_VARS = new Array ();
	GLOBAL_CETAK_BUKU_VARS["cetak"] = "<?=base_url();?>pembukuan/dsp_form_cetak_buku_wpr/cetak";
</script>
<script type="text/javascript" src="modules/pembukuan/scripts/dsp_form_cetak_buku_wpr.js"></script>