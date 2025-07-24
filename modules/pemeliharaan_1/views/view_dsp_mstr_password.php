	<div id="content-box">
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
<table class="toolbar"><tr>
<td class="button" id="toolbar-save">
        <a href="#" onclick="javascript: submitbutton('save')" class="toolbar">
	<span class="icon-32-save" title="SAVE">
	</span>
	Save
	</a>
</td>
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
<!--
 uker_id        | integer                | not null default nextval('unit_kerja_uker_id_seq'::regclass)
 uker_kode      | character varying(2)   | not null
 uker_nama1     | character varying(100) | not null
 uker_nama2     | character varying(100) |
 uker_singkatan | character varying(50)  |
 uker_simpatda  | boolean                | not null default false


     |  Kode Unit Kerja  :  [  ]                                        |
     |  Nama Unit Kerja1 :  [                                        ]  |
     |  Nama Unit Kerja2 :  [                                        ]  |
     |  Singkatan        :  [                    ]                      |


-->

<?// $defaultFill = '<font size="3" color="red">*</font>'; ?>

<form action="<?php //echo $myself.$XFA['act_mstr_password']; ?>" method="post" name="adminForm" >
	<div class="col width-50">
		<fieldset class="adminForm">

                        <table class="admintable" cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                    <td  class="key"><label> Password Lama </label> <?//=$defaultFill?> </td>
                                    <td> <input type="password" name="last_pass" id="last_pass" class="inputbox" size="50" maxlength=100 tabindex="1" /> </td>
                                </tr>
                                <tr>
                                    <td  class="key"><label> Password Baru </label> <?//=$defaultFill?> </td>
                                    <td> <input type="password" name="new_pass1" id="new_pass1" class="inputbox" size="50" maxlength=100 tabindex="2" /> </td>
                                </tr>
                                <tr>
                                    <td  class="key"><label> Ulangi Password Baru </label> <?//=$defaultFill?> </td>
                                    <td> <input type="password" name="new_pass2" id="new_pass2" class="inputbox" size="50" maxlength=100 tabindex="3" /> </td>
                                </tr>
                        </table><?//=$defaultFill?> Wajib diisi
		</fieldset>
	</div>
	<div class="clr"></div>

	<input type="hidden" name="staff_id" value="<?//= $staff_id;?>" />
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
		<noscript>
			Warning! JavaScript must be enabled for proper operation of the Administrator Back-end		</noscript>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
</div>
</div>
	<div id="border-bottom"><div><div></div></div></div>