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
<span class="icon-32-save" title="Simpan">
</span>
SIMPAN
</a>
</td>

</tr></table>
</div>

<div class="header icon-48-sand_watch"> Konfigurasi Jatuh Tempo </div>
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


<!-- _______(Start)_________The Form___________ -->

<? //$defaultFill = '<font size="3" color="red">*</font>'; ?>

<form action="<?//= $myself.$XFA['act_mstr_jatuh_tempo']; ?>" method="post" name="adminForm" >
                  
                    <table class="admintable" border=0 cellspacing="3" width="100%">
                        <tr>
                            <td class="key" width="50%"> <label> Jumlah HARI Jatuh Tempo </label><?//=$defaultFill?> </td>
                            <td>
                                <input type="text" name="ref_jatem" value="<?//= $ar_dat[ref_jatem]?>" size="2" maxlength="2" autocomplete="off" tabindex="1"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" width="50%"> <label> TANGGAL Jatuh Tempo BAYAR Self Assesment </label> </td>
                            <td>
                                <input type="text" name="ref_jatem_batas_bayar_self" value="<?//= $ar_dat[ref_jatem_batas_bayar_self]?>" size="2" maxlength="2" autocomplete="off" tabindex="2"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" width="50%"> <label> TANGGAL Jatuh Tempo LAPOR Self Assesment</label> </td>
                            <td>
                                <input type="text" name="ref_jatem_batas_lapor_self" value="<?//= $ar_dat[ref_jatem_batas_lapor_self]?>" size="2" maxlength="2" autocomplete="off" tabindex="3"/>
                            </td>
                        </tr>
                    </table> <?//=$defaultFill?> Wajib diisi
                                <input type="hidden" name="task" value=""/>
                                <input type="hidden" name="old_val" value="<?//= $ar_dat?>"/>
                  
</form>


<!-- _______(Start)_________The Form___________ -->


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