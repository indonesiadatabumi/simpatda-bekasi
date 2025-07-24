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
        <a href="#" onclick="javascript: submitbutton('save')" class="toolbar">
	<span class="icon-32-save" title="SAVE">
	</span>
	Save
	</a>
</td>


<!--<td class="button" id="toolbar-help">
<a href="#" onclick="popupWindow('http://help.joomla.org/index2.php?option=com_content&amp;task=findkey&amp;tmpl=component;1&amp;keyref=screen.users.edit.15', 'Help', 640, 480, 1)" class="toolbar">
<span class="icon-32-help" title="Help">
</span>
Help

</a>
</td>-->

</tr></table>
</div>
				<div class="header icon-48-key">
PASSWORD: 
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

<?php
	/*$db->debug=0;
	$qr_pass = &$db->GetRow("SELECT * from operator WHERE opr_id='$staff_id'");*/
#echo $qr_pass[opr_passwd];
?>

<script language="javascript" type="text/javascript">

$(document).ready(function() {
	
	$("input[type=text],input[type=radio],input[type=password],select").enter2tab();
	$('input[type!=hidden]:first').focus();

	$("button,input,select,textarea").focus(function() {
	$(this).select();
	})

});

	function submitbutton(pressbutton) {
		// do field validation
		if ($("#last_pass").val() == "") {
			alert( "Password lama Kosong" );  
			$("#last_pass").focus();
		} else if ($("#new_pass1").val() == "") {
			alert( "Password Baru harus diisi" );  
			$("#new_pass1").focus();
		} else if ($("#new_pass2").val() == "") {
			alert( "Retype password Kosong" );  
			$("#new_pass2").focus();
		}else if ($("#new_pass1").val() != $("#new_pass2").val()) {
			alert( "Isian password baru harus sama" );  
			$("#new_pass1").focus();
		}else { 
			//Save di trigger oleh tombol Save, Reply dan Create Ticket
			var showInsertResponse = function (response, statusText) {
	            if(response.status == true) {
	               $("#frm_change_password").resetForm();
	               showNotification(response.msg);
	            } else {
	            	showWarning(response.msg);
	            }
			};
			
			var save_options = {
				url : GLOBAL_MAIN_VARS['BASE_URL'] + "main/save_password",
				type : "POST",
				dataType: 'json',
				beforeSubmit: jqform_validate,	// pre-submit callback 
				success: showInsertResponse	// post-submit callback 
			};
			
			$("#frm_change_password").ajaxSubmit(save_options);
		}
	}
</script>


<? $defaultFill = '<font size="3" color="red">*</font>'; ?>

<form name="frm_change_password" id="frm_change_password" >
	<div class="col width-50">
		<fieldset class="adminForm">

                        <table class="admintable" cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                    <td  class="key"><label> Password Lama </label> <?=$defaultFill?> </td>
                                    <td> <input type="password" name="last_pass" id="last_pass" class="inputbox" size="50" maxlength=100 tabindex="1" /> </td>
                                </tr>
                                <tr>
                                    <td  class="key"><label> Password Baru </label> <?=$defaultFill?> </td>
                                    <td> <input type="password" name="new_pass1" id="new_pass1" class="inputbox" size="50" maxlength=100 tabindex="2" /> </td>
                                </tr>
                                <tr>
                                    <td  class="key"><label> Ulangi Password Baru </label> <?=$defaultFill?> </td>
                                    <td> <input type="password" name="new_pass2" id="new_pass2" class="inputbox" size="50" maxlength=100 tabindex="3" /> </td>
                                </tr>
                        </table><?=$defaultFill?> Wajib diisi
		</fieldset>
	</div>
	<div class="clr"></div>

	<input type="hidden" name="staff_id" value="<?= $this->session->userdata("USER_ID");?>" />
	<input type="hidden" name="task" value="" />
                </form>

                        <div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>

				</div>
			</div>
   		</div>
</div>