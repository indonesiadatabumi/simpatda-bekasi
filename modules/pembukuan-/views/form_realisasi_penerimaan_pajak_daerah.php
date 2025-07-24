
<div id="toolbar-box">
	<div class="t">
		<div class="t"> <div class="t"> </div></div>
	</div>
    <div class="m">
        <div class="header icon-48-user"> Cetak Laporan Realisasi Penerimaan Pajak Daerah </div>
      	<div class="clr"></div>
  	</div>
	<div class="b">
		<div class="b"> <div class="b"></div></div>
	</div>
</div>
            
<div class="clr"></div>

<div id="element-box">
	<div class="t"> <div class="t"> <div class="t"> </div> </div> </div>
    <div class="m"  >
		<form method="post" name="adminForm" >                 
        	<table class="admintable" border=0 cellspacing="3">
        		<tr>
               		<td class="key" width="150">Tanggal Proses</td>
                    <td>
                    	<input type="tgl_proses" name="tahun" id="tgl_proses" size="11" />
                  	</td>
              	</tr>
            	<tr>
               		<td class="key" width="150">Tanggal Cetak</td>
                    <td>
                    	<input type="text" name="tgl_cetak" id="tgl_cetak" size="11" tabindex="1"/>
                  	</td>
              	</tr>                  
	            <tr>
	             	<td class="key">   Mengetahui    </td>
	                <td>
						<?php
							$attributes = 'id="mengetahui" name="mengetahui"';
							echo form_dropdown('mengetahui', $pejabat_daerah, '', $attributes);
						?>								
                  	</td>
	         	</tr>
	            <tr>
	            	<td class="key">   Bendahara    </td>
	                <td>
						<?php
							$attributes = 'id="bendahara" name="bendahara"';
							echo form_dropdown('bendahara', $pejabat_daerah, '', $attributes);
						?>								
	          			<input type="button" name="btn_cetak" id="btn_cetak" value="Cetak" class="button"/>
	          		</td>
	       		</tr>
			</table>
		</form>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b"><div class="b"></div></div>
	</div>
</div>

<script type="text/javascript">
	var GLOBAL_REALISASI_PAJAK_VARS = new Array ();
	GLOBAL_REALISASI_PAJAK_VARS["cetak"] = "<?=base_url();?>pembukuan/realisasi_penerimaan_pajak_daerah/save_excel";
</script>
<script type="text/javascript" src="<?= base_url(); ?>modules/pembukuan/scripts/form_realisasi_penerimaan_pajak_daerah.js"></script>
	