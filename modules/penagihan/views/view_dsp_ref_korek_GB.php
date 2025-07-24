<body id="minwidth">

		<?php
		 //$xajax->printJavascript('scripts/');
		?>
		<div class="border">
			<div class="padding">
				<div id="toolbar-box">
   			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>

			</div>
			<div class="m">
				<div class="toolbar" id="toolbar">
<table class="toolbar">
<tr>
	<td class="button" id="toolbar-cancel">
	<a href="#" id="btn_popup_cancel" class="toolbar">
	<span class="icon-32-cancel" title="Close">
	</span>
	Batal
	</a>
	</td>
</tr>
</table>
</div>
	<div class="header icon-48-module">Tabel Referensi Kode Rekening</div>
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
		<form action="#" onsubmit="submitSignup('save_ref2c');" method="post" name="adminForm" id="adminForm">

			<table>
			<tr>
				<td align="left" width="100%">
					<input type="hidden" name="master" value="kelurahan" />
					<input type="hidden" name="cari" value="kelurahan" />


				</td>
				<td nowrap="nowrap">
					</td>

			</tr>
			</table>
<table id="flex1" style="display:none"></table>
		<input type="hidden" name="nd" value="0" />
		<input type="hidden" name="wp_wr_jenis" value="<?//=$attributes['wp_wr_jenis']?>" />
		<input type="hidden" name="modul" value="<?//=$attributes['modul']?>" />
		<input type="hidden" name="exception" value="<?//=$attributes['exception']?>" />
		<input type="hidden" name="id" value="0" />
		<input type="hidden" name="edit" value="0" />
		<input type="hidden" name="option" value="com_modules" />
		<input type="hidden" name="client" value="0" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="master" value="kelurahan" />
		<input type="hidden" name="filter_order" value="m.position" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="84f4092560a267906dbac5e2e8f652cb" value="1" />

				<div class="clr"></div>

			</div>

   		</div>
		<noscript>
			Warning! JavaScript must be enabled for proper operation of the Administrator Back-end		</noscript>

		<div class="clr"></div>
	</div>
	<div class="clr"></div>
</div>
</div>
</div> <!--bates div scroll-->
	<div id="border-bottom"><div><div></div></div></div>

<div id="korek_id" style="display:none;">
 </div>
<div id="korek" style="display:none;">
 </div>
<div id="korek_nama" style="display:none;">
 </div>
<div id="korek_rincian" style="display:none;">
 </div>
<div id="korek_sub1" style="display:none;">
 </div>
<div id="korek_persen_tarif" style="display:none;">
 </div>
<div id="korek_tarif_dsr" style="display:none;">
 </div>

</body>
<script type="text/javascript">
	var GLOBAL_REF_KOREK_VARS = new Array ();
	GLOBAL_REF_KOREK_VARS["get_list"] = "<?=base_url();?>penagihan/dsp_ref_korek_GB/get_list";
	//&task=call_korek&wp_wr_jenis=$attributes[wp_wr_jenis]&modul=$attributes[modul]&korek=$attributes[korek]&exception=$attributes[exception]&spt_idwpwr=$attributes[spt_idwpwr]"?>'
</script>
<script type="text/javascript" src="modules/penagihan/scripts/dsp_ref_korek_gb.js"></script>