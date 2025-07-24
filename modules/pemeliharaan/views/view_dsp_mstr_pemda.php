
		<div id="toolbar-box">
			<div class="t">
			<div class="t">
			<div class="t"></div>
			</div>
			</div>
			<div class="m">
			<div class="toolbar" id="toolbar">
			<table class="toolbar"><tr>
			<td class="button" id="toolbar-save">
			<a href="#" id="konfirm" class="toolbar">
			<span class="icon-32-save" title="Save">
			</span>
			Update
			</a>
			</td>
			</tr></table>
			</div>
			<div class="header icon-48-pemda">
			DATA PEMERINTAH DAERAH: <small><small>[ Edit ]</small></small>
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

               // alert( pressbutton );
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

		// do field validation

		if (trim(form.dapemda_nm_dati2.value) == "") {
			alert( "Kabupaten  Kosong" );
		} else if (form.dapemda_ibu_kota.value == "") {
			alert( "Ibukota Kosong" );
		} else {
			submitform( pressbutton );
		}


	}

	function gotocontact( id ) {
		var form = document.adminForm;
		form.contact_id.value = id;
		submitform( 'contact' );
	}

	function check_pswd(msg) {
		if (msg==1) {
		submitbutton('update');
		}
		else {
		alert("Maaf Nama User atau Password Salah atau Nama User Bukanlah Administrator!!");
		document.adminForm.reset();
		return false;
		}
	}

</script>

</script>
<?php
$d = $data_master->row();
?>
<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<input type="hidden" name="pswd" value="<?//=$staff_pswd?>">
	<div class="col width-100">
		<!--<fieldset class="adminForm">
		<legend>Data Pemda</legend>-->

                        <table class="admintable" cellspacing="3" cellpadding="3" border="0" >
                                <tr>
                                        <td  class="key">
                                                <label for="pmd_kdlokasi"> Kode Lokasi </label><font color="red" size="3">*</font>
                                        </td>
                                        <td><input type="text" name="dapemda_kode" id="dapemda_kode" class="inputbox" size="2" value="<?=$d->dapemda_kode?>" maxlength=2 tabindex="1" />
                                        </td>
<!--                                         <td rowspan="7" bgcolor="navy" value="logone" width="50"> </td> -->
                                    <td class="key"> Nama Bank </td>
                                    <td>
                                        <input type="text" name="dapemda_bank_nama" id="dapemda_bank_nama" class="inputbox" size="40" value="<?=$d->dapemda_bank_nama?>" autocomplete="off" tabindex="7" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="dapemda_nama"> Kabupaten/Kota </label><font color="red" size="3">*</font>
                                    </td> 
                                    <td>
										<?php
											$attributes = 'id="dapemda_nama" name="dapemda_nama" class="inputbox" tabindex="2"';
											echo form_dropdown('dapemda_nama', array(''=>'---','kabupaten'=>'Kabupaten','kota'=>'Kota'), $d->dapemda_nama, $attributes);
										?>
                                    </td>
                                    <td class="key" width="30"> Nomor Rekening Bank </td>
                                    <td>
                                        <input type="text" name="dapemda_bank_norek" id="dapemda_bank_norek" class="inputbox" size="40" value="<?=$d->dapemda_bank_norek?>" autocomplete="off" tabindex="8" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key">
                                        <label for="pmd_pejabat"> Pejabat Kab/Kota </label><font color="red" size="3">*</font>
                                    </td>
                                    <td>
                                        <select name="dapemda_pejabat" class="inputbox" id="dapemda_pejabat" tabindex="3">
                                            <?php
												if (strtoupper($d->dapemda_pejabat)=="BUPATI"){
													$s1="selected"; $s2=""; $s0="";
												}
												else if (strtoupper($d->dapemda_pejabat)=="WALIKOTA"){
													$s1=""; $s2="selected";   $s0="";
												}
												else { 
													$s1=""; $s2=""; $s0="selected"; 
												}
                                            ?>
                                            <option value="" <?= $s0 ?> >---	</option>
                                            <option value="Bupati" <?= $s1 ?> >Bupati</option>
                                            <option value="Walikota" <?= $s2 ?> >Walikota</option>
                                        </select>
                                    </td>
                                    <td class="key" valign="top">
                                        Logo Pemerintah Daerah
                                    </td>
                                    <td>   <!--< ?=$d['dapemda_logo_path']?><br>-->
                                        <input class="button" id="logo" name="logo" type="file" size="30" value="<?=$d->dapemda_logo_path;?>" tabindex="9" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key" valign="top">
                                        <label for="nama_dinas"> Nama Instansi </label><font color="red" size="3">*</font>
                                    </td>
                                    <td>
                                       <input type="text" name="nama_dinas" id="nama_dinas" class="inputbox" size="40" value="<?=$d->nama_dinas?>" autocomplete="off" tabindex="4" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key" valign="top">
                                        <label for="nama_dinas"> Nama Singkatan Instansi </label><font color="red" size="3">*</font>
                                    </td>
                                    <td>
                                       <input type="text" name="nama_singkatan" id="nama_singkatan" class="inputbox" size="40" value="<?=$d->nama_singkatan?>" autocomplete="off" tabindex="4" />
                                    </td>
                                </tr>  
                                <tr>
                                    <td class="key" valign="top">
                                        <label for="dapemda_lokasi"> Alamat Kantor </label><font color="red" size="3">*</font>
                                    </td>
                                    <td>
                                        <textarea name="dapemda_lokasi" cols="34" rows="5" id="dapemda_lokasi" ><?=$d->dapemda_lokasi?></textarea>
                                    </td>
                                    <td rowspan="7" colspan="2" align="center" >
                                        <img src="<?=$d->dapemda_logo_path?>" name="imagelib" />
                                    </td>
                                </tr>   
                                <tr>
                                    <td class="key">
                                        Nama Kabupaten/Kota
                                    </td>
                                    <td>
                                        <input type="text" name="dapemda_nm_dati2" id="dapemda_nm_dati2" class="inputbox" size="40" value="<?=$d->dapemda_nm_dati2?>" autocomplete="off" tabindex="4" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="key"> Ibukota Kab/Kota    </td>
                                    <td>
                                        <input type="text" name="dapemda_ibu_kota" id="dapemda_ibu_kota" class="inputbox" size="40" value="<?=$d->dapemda_ibu_kota?>" autocomplete="off" tabindex="5" />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top" class="key"> Nomor Telp. Kantor  </td>
                                    <td>
                                        <input type="text" name="dapemda_no_telp" id="dapemda_no_telp" class="inputbox" size="20" value="<?=$d->dapemda_no_telp?>" autocomplete="off" tabindex="6" />
                                    </td>
                                </tr>
<tr height=50><td></td></tr>
                        </table><font size="3" color="red">*</font> Wajib diisi
		<!--</fieldset>-->
	</div>
	<div class="clr"></div>

<!--         <input type="hidden" name="MAX_FILE_SIZE" value="80000" /> -->
        <input type="hidden" name="id" value="62" />
	<input type="hidden" name="cid[]" value="62" />
	<input type="hidden" name="master" value="pemda" />

	<input type="hidden" name="dapemda_id" value="<?= $d->dapemda_id;?>" />
	<input type="hidden" name="option" value="com_users" />
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
			Warning! JavaScript must be enabled for proper operation of the Administrator Back-end		</noscript>
		<div class="clr"></div>
	</div>


	<div id="border-bottom"><div><div></div></div></div>
