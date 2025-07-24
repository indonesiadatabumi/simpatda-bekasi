
				<div id="toolbar-box">
   			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>
			</div>
			<div class="m">
				<div class="toolbar" id="toolbar">

<table class="toolbar"><tr>
<td class="button" id="toolbar-delete">
<a onclick="openChildGB('Cetak Daftar Printer','<?//= $myself.$XFA['dsp_cetak_mstr_printer'];?>','win2')" style="cursor:pointer" >
<span class="icon-32-print" title="Cetak Daftar">
</span>
Cetak Daftar
</a>
</td>

<td class="button" id="toolbar-new">
<a href="#" onclick="javascript:hideMainMenu(); submitbutton('new')" class="toolbar">
<span class="icon-32-new" title="New">
</span>
Baru
</a>
</td>

<td class="button" id="toolbar-edit">
<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Tentukan Pilihan Anda terlebih dahulu');}else{  submitbutton('edit')}" class="toolbar">
<span class="icon-32-edit" title="Edit">
</span>
Edit
</a>
</td>

<td class="button" id="toolbar-delete">
<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Tentukan Pilihan Anda Terlebih Dahulu');}else{  konfirm('remove')}" class="toolbar">
<span class="icon-32-delete" title="Hapus">
</span>
Hapus
</a>
</td>

</tr></table>
</div>
<div class="header icon-48-master"> PRINTER </div>
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
<form name="adminForm" action="<?php //echo $myself.$XFA['act_mstr_printer']; ?>" method="post">
<table id="flex1" style="display:none"></table>
<span id="saveBar"></span>

		<input type="hidden" name="nd" value="0" />
		<input type="hidden" name="client" value="0" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="master" value="mstr_printer" />
		<input type="hidden" name="boxchecked" value="0" />

<!--FLEXIGRID-->
		<input type="hidden" name="sqtype" value="<?//=$attributes[sqtype]?>" />
		<input type="hidden" name="squery" value="<?//=$attributes[squery]?>" />
		<input type="hidden" name="snewp" value="<?//=$attributes[snewp]?>" />
		<input type="hidden" name="srp" value="<?//=$attributes[srp]?>" />
		<input type="hidden" name="tarik" value="" />

<!--END OF FLEXIGRID-->


        </form>

				<div class="clr"></div>
			</div>
			<div class="b"> <div class="b"><div class="b"></div></div></div>

   		</div>
		<noscript>
			Warning! JavaScript must be enabled for proper operation of the Administrator Back-end		</noscript>
		<div class="clr"></div>
	</div>
