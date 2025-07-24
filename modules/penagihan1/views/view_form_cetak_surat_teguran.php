		<?php
		/*
		$xajax->printJavascript('scripts/'); 
		if (!empty($attributes[idedit])) {
		$now_date = "";
		$nextweek = "";
		}
		*/
		?>
  <style type="text/css">
#fields {
display: none;
}
</style>

				<div id="toolbar-box">
   			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>

			<div class="m">
				<div class="toolbar" id="toolbar">
				<table class="toolbar"><tr></tr></table>
</div>
				<div class="header icon-48-print">
Form Cetak Surat Teguran:  <small><small>[ <?php //if(!empty($idedit)) echo "Edit"; else echo "New"; ?> ]</small></small>
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
				


<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

		// do field validation
		if (form.spt_idwpwr.value == "") {
			alert( "Anda harus mengisi kolom NPWPD / NPWRD" );
		} else if (trim(form.spt_periode.value) == "") {
			alert( "Anda harus mengisi kolom Periode SPT" );
		} else if (form.spt_nomor.value == "") {
			alert( "Anda harus mengisi kolom Nomor SPT" );
		} else if (form.spt_kode_rek.value == "") {
			alert( "Anda harus mengisi kolom Kode Rekening" );
		} else if (form.spt_tgl_terima.value == "") {
			alert( "Anda harus mengisi kolom Tgl Diterima WP/WR" );
		} else if (form.spt_tgl_bts_kembali.value == "") {
			alert( "Anda harus mengisi kolom Tgl Batas Kembali" );
		} else {
			submitform( pressbutton );
		}

	}

	function gotocontact( id ) {
		var form = document.adminForm;
		form.contact_id.value = id;
		submitform( 'contact' );
	}
	function openChild(file,window) {
	childWindow=open(file,window,'resizable=no,width=1000,height=700');
	if (childWindow.opener == null) childWindow.opener = self;
	}

</script>

<form action="<?//php echo $myself.$XFA['dsp_cetak_surat_teguran']; ?>" method="post" name="adminForm" id="adminForm">
	<div class="col width-51">
		<fieldset class="adminform">
		<legend>FORM SURAT TEGURAN</legend>

			<table class="admintable" border=0 cellspacing="1">
			<tr><TD valign="top">
			<table class="admintable" border=0 cellspacing="1">
				<tr>
					<td width="150" class="key">
						<label for="name">
							NPWPD / NPWRD</label>
					</td>
					<td>
						<input type="hidden" name="spt_idwpwr" id="spt_idwpwr" value="<?//= $ar_edit_data[spt_idwpwr]; ?>">
						<select name="wp_wr_jenis" id="wp_wr_jenis" onchange="submitSignup('chosen_npw');" tabindex="1">
						<option value="P">P</option>
						<option value="R">R</option>
						</select>

						<input type="text" name="wp_wr_gol" id="wp_wr_gol" class="inputbox" size="1" maxlength="1" value="<?//= $ar_edit_data[wp_wr_gol]; ?>"  onkeypress="submitSignup('chosen_npw');" onchange="submitSignup('chosen_npw');" autocomplete="off" tabindex="2"/>

						<input type="text" name="wp_wr_no_urut" id="wp_wr_no_urut" class="inputbox" size="7" maxlength="7" value="<?//= $ar_edit_data[wp_wr_no_urut]; ?>"  onkeypress="submitSignup('chosen_npw');" onchange="submitSignup('chosen_npw');" autocomplete="off" tabindex="3"/>

						<input type="text" name="wp_wr_kd_camat" id="wp_wr_kd_camat" class="inputbox" size="2" maxlength="2" value="<?//= $ar_edit_data[wp_wr_kd_camat]; ?>"  onkeypress="submitSignup('chosen_npw');" onchange="submitSignup('chosen_npw');" autocomplete="off" tabindex="4"/>

						<input type="text" name="wp_wr_kd_lurah" id="wp_wr_kd_lurah" class="inputbox" size="3" maxlength="3" value="<?//= $ar_edit_data[wp_wr_kd_lurah]; ?>"  onkeypress="submitSignup('chosen_npw');" onchange="submitSignup('chosen_npw');" autocomplete="off" tabindex="5"/>

						<input type="button" id="trigger_npw" size="2" value="..." onclick="openChildGB('Daftar Wajib Pajak/Retribusi','<?//= $myself.$XFA['dsp_ref_npw_GB'];?>','win2')" >

					</td>
				</tr>
						<script type="text/javascript">

jQuery(document).ready(function() {
jQuery("input[type=text],input[type=radio],input[type=checkbox],select").enter2tab();
jQuery('input[type!=hidden]:first').focus();
jQuery("button,input,select,textarea").focus(function(){jQuery(this).select();})

jQuery('#wp_wr_gol').autotab({ target: 'wp_wr_no_urut', format: 'numeric' });
jQuery('#wp_wr_no_urut').autotab({ target: 'wp_wr_kd_camat', format: 'numeric', previous: 'wp_wr_gol' });
jQuery('#wp_wr_kd_camat').autotab({ target: 'wp_wr_kd_lurah', format: 'numeric', previous: 'wp_wr_no_urut' });
jQuery('#wp_wr_kd_lurah').autotab({ format: 'numeric', previous: 'wp_wr_kd_camat' });

jQuery('#korek').autotab({ target: 'korek_rincian', format: 'numeric' });
jQuery('#korek_rincian').autotab({ target: 'korek_sub1', format: 'numeric', previous: 'korek' });
jQuery('#korek_sub1').autotab({ format: 'numeric', previous: 'korek_rincian' });
});

function dateFormat(obj) {
	if (obj.value !="") {
	date = obj.value.replace(/\$|\-20/g,'').replace(/\$|\-/g,'');
	formated = date[0]+date[1]+'-'+date[2]+date[3]+'-20'+date[4]+date[5];

		jQuery.ajax({
			type : "POST",
				url : "index.php?action=m.qry_get_reklame_values_ajax_jq",
			data : "string="+ formated,
			beforeSend: function(){
				//jQuery('#date_string').html('<div align="center"><img src="images/loading.gif"  border="0"/></div>');
			},
			success: function(msg){
				if (msg.length > 0) {
					if (msg == 0) {
					alert ("Tanggal Salah");
					jQuery('#'+obj.id).attr('value','');
					jQuery('#'+obj.id).attr('value','');
					jQuery('#'+obj.id).focus();
					} else {
					jQuery('#'+obj.id).attr('value',formated);
					}
						if (obj.name == "masa1" || obj.name == "masa2") {
						ldmonth(obj);
						}
				}
			}
			});
	}
	else { formated=""; }
return;
}

						function submitSignup(master)
						{
							if (master == 'call_npw')
							xajax_processForm_npw_call(xajax.getFormValues("adminForm"));
							else if (master == 'chosen_npw')
							xajax_processForm_npw_chosen(xajax.getFormValues("adminForm"));
							else if (master == 'chosen_korek')
							xajax_processForm_korek_chosen(xajax.getFormValues("adminForm"));
							else if (master == 'spt_prd_no')
							xajax_processForm_spt_prd_no(xajax.getFormValues("adminForm"));
							else if (master == 'tgl_form_kemb')
							xajax_processForm_tgl_form_kemb(xajax.getFormValues("adminForm"));

							return false;
						}
						</script>
				<tr>
					<td class="key" width="100">
						<label for="password">
							Masa Pajak						</label>

					</td>
					<td>
						<input type="text" name="masa1" id="f_date_a" size="11" value="<?//= format_tgl($ar_edit_data[spt_tgl_proses]) . $now_date; ?>" <?//php echo $dis; ?> onblur="dateFormat(this);" tabindex="6"/> <input type="reset" id="trigger_a" size="2" value="...">
					&nbsp; S/D &nbsp;
						<input type="text" name="masa2" id="f_date_b" size="11" value="<?//= format_tgl($ar_edit_data[spt_tgl_entry]) . $now_date; ?>" <?//php echo $dis; ?> onblur="dateFormat(this);" tabindex="7"/> <input type="reset" id="trigger_b" size="2" value="...">
		
					<script type="text/javascript">
					Calendar.setup({
						inputField     :    "f_date_b",      // id of the input field
						ifFormat       :    "%d-%m-%Y",       // format of the input field %m/%d/%Y %I:%M %p
						showsTime      :    false,            // will display a time selector
						button         :    "trigger_b",   // trigger for the calendar (button ID)
						singleClick    :    false,           // double-click mode
						step           :    1                // show all years in drop-down boxes (instead of every other year as default)
					});
					</script>
					</td>

				</tr>
								<tr>
					<td class="key">
						Tahun				</td>
					<td>
						
						<input type="text" name="spt_periode" id="spt_periode" class="inputbox" size="4" tabindex="8"/></td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">
							Nomor  Rekening						</label>
					</td>
					<td>
						<input type="hidden" name="spt_kode_rek" id="spt_kode_rek" value="<?//=$ar_edit_data[spt_kode_rek];?>">
						<input type="text" name="korek" id="korek" class="inputbox" size="5" maxlength="5" value="<?//= $ar_edit_data[koderek]; ?>" onchange="submitSignup('chosen_korek');" onkeypress="submitSignup('chosen_korek');" tabindex="9"/>
						Jenis
						<input type="text" name="korek_rincian" id="korek_rincian" class="inputbox" size="2" maxlength="2" value="<?//= $ar_edit_data[korek_rincian]; ?>" onchange="submitSignup('chosen_korek');" onkeypress="submitSignup('chosen_korek');" tabindex="10"/>
						Klas
						<input type="text" name="korek_sub1" id="korek_sub1" class="inputbox" size="2" maxlength="2" value="<?//= $ar_edit_data[korek_sub1]; ?>" onchange="submitSignup('chosen_korek');" onkeypress="submitSignup('chosen_korek');" tabindex="11"/>
						<input type="button" id="trigger_rek" size="2" value="..." onclick="openChildGB('Daftar Kode Rekening','<?//= $myself.$XFA['dsp_ref_korek_GB'];?>','win2')">
					</td>
				</tr>
				<tr>
					<td class="key" valign="top">
						<label for="username">
							Nama  Rekening						</label>
					</td>
					<td>
						<input type="text" name="korek_nama" id="korek_nama" class="inputbox" size="40" value="<?//= $ar_edit_data[korek_nama]; ?>" readonly="true"/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password">
							Tanggal Proses						</label>

					</td>
					<td>
						<input type="text" name="tgl_proses" id="f_date_c" size="16" onblur="dateFormat(this);" value="<?=date('d-m-Y')?>" tabindex="12"/> <input type="reset" id="trigger_c" size="2" value="...">
		
					<script type="text/javascript">
					Calendar.setup({
						inputField     :    "f_date_c",      // id of the input field
						ifFormat       :    "%d-%m-%Y",       // format of the input field %m/%d/%Y %I:%M %p
						showsTime      :    false,            // will display a time selector
						button         :    "trigger_c",   // trigger for the calendar (button ID)
						singleClick    :    false,           // double-click mode
						step           :    1                // show all years in drop-down boxes (instead of every other year as default)
					});
					</script>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<label for="gid">
							Tanggal Cetak						</label>

					</td>
					<td>
						<input type="text" name="tgl_cetak" id="f_date_d" size="16" onblur="dateFormat(this);" value="<?=date('d-m-Y')?>" tabindex="13"/> <input type="reset" id="trigger_d" size="2" value="...">
		
					<script type="text/javascript">
					Calendar.setup({
						inputField     :    "f_date_d",      // id of the input field
						ifFormat       :    "%d-%m-%Y",       // format of the input field %m/%d/%Y %I:%M %p
						showsTime      :    false,            // will display a time selector
						button         :    "trigger_d",   // trigger for the calendar (button ID)
						singleClick    :    false,           // double-click mode
						step           :    1                // show all years in drop-down boxes (instead of every other year as default)
					});
					</script>
					</td>

				</tr>

				<tr>
					<td class="key">
						Kode Pejabat</td>
					<td>
						<select name="pejabat" id="pejabat"  class="inputbox" tabindex="14"> <option value="">--</option>
						<?php
							//foreach ($ar_pejabat as $kc => $vc) {
						?>
							<option value="<?//= $vc[pejda_id]; ?>" ><?//= "[".$vc[pejda_kode]."] ".$vc[pejda_nama]." / ".$vc[ref_japeda_nama]; ?></option>
						<?php
							//}
						?>

						</select> &nbsp;
						<input type="submit" name="cetak" value="Cetak" tabindex="15">
					</td>
				</tr>

			</table>
			</TD>


</tr>
							</table>
		</fieldset>
	</div>
	<div class="clr"></div>

	<input type="hidden" name="cid[]" value="" />
	<input type="hidden" name="spt_jenis_pemungutan" value="" />
	<input type="hidden" name="wp_wr_nama" value="" />
	<input type="hidden" name="wp_wr_almt" value="" />
	<input type="hidden" name="wp_wr_lurah" value="" />
	<input type="hidden" name="wp_wr_camat" value="" />
	<input type="hidden" name="wp_wr_kabupaten" value="" />

	<input type="hidden" name="form" value="sptprd" />
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="spt_id" id="spt_id" value="<?//= $ar_edit_data[spt_id]; ?>" />
	<input type="hidden" name="operator" value="<?//= $staff_id; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="contact_id" value="" />
		<input type="hidden" name="4e5df0df35b0914f3fbb6b63af22c21d" value="1" /></form>
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>

				</div>
			</div>
   		</div>
		<noscript>
			Warning! JavaScript must be enabled for proper operation of the Administrator Back-end </noscript>
		<div class="clr"></div>
	</div>


