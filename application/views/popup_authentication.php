<form action="#" method="post" name="frm_confirm_password" >
	<table class="admintable" border=0 cellspacing="3">
		<tr>
        	<td class=admintable style="font-size: 12px">Nama User</td>
            <td class=admintable> : </td>
            <td class=admintable>
            	<input type="text" name="username" id="username" value="" style="font-size: 12px" />
				<span class="paslock">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
			</td>
		</tr>
		<tr>
            <td class=admintable style="font-size: 12px">Password</td>
          	<td class=admintable> : </td>
            <td>
            	<input type="password" name="password" id="password" value="" style="font-size: 12px" />
           	</td>
      	</tr>
      	<tr>
      		<td colspan="3" align="right">
      			<input type="button" name="otorisasi" id="btn_submit" value="Autentikasi" class="button" style="font-size: 12px"/>
      			<input type="button" name="otorisasi" id="tutup" value="Batal" class="button" style="font-size: 12px"/>
      		</td>
      	</tr>
  	</table>
</form>

<script type="text/javascript">
GLOBAL_MAIN_VARS["authentication"] = "<?= base_url();?>login/check_authentication";
GLOBAL_MAIN_VARS["action_authenticate"] = "<?= $action;?>";
</script>
<script type="text/javascript" src="<?= base_url();?>assets/scripts/private/popup_authentication.js"></script>