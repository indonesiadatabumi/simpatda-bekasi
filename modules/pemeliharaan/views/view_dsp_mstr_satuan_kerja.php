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
<a href="#" onclick="openChildGB('Cetak Daftar Satuan Kerja','<?//= $myself.$XFA['dsp_cetak_mstr_satuan_kerja'];?>','win2')" style="cursor:pointer" >
<span class="icon-32-print" title="Cetak Daftar">
</span>
Cetak Daftar
</a>
</td>

<td class="button" id="toolbar-new">
<a href="#" onclick="javascript:hideMainMenu(); submitbutton('add')" class="toolbar">
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
<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Silahkan tentukan pilihan dari daftar untuk melakukan HAPUS');}else{  konfirm('remove')}" class="toolbar">
<span class="icon-32-delete" title="Delete">

</span>
Hapus
</a>
</td>

</tr></table>
</div>
<div class="header icon-48-master"> UNIT KERJA </div>
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

<form name="adminForm" action="<?//= $myself.$XFA['act_mstr_satuan_kerja']; ?>" method="post">

<table id="flex1" style="display:none"></table>

<span id="saveBar"></span>


<!--			<table class="adminlist">
			<thead>
			<tr>
				<th width="20"> # </th>
				<th width="30"><input type="checkbox" name="toggle" value="" onclick="checkAll(20);" /></th>
				<th width="5%" class="title"> Kode Unit Kerja </th>
				<th width="25%"> Nama Unit Kerja </th>
				<th width="25%"> Nama Unit Kerja 2</th>
			</tr>
			</thead>

			<tfoot>
			<tr>
				<td colspan="8">
					<del class="container"><div class="pagination">

<div class="limit">Display #<select name="limit" id="limit" class="inputbox" size="1" onchange="submitform();"><option value="5" >5</option><option value="10" >10</option><option value="15" >15</option><option value="20"  selected="selected">20</option><option value="25" >25</option><option value="30" >30</option><option value="50" >50</option><option value="100" >100</option><option value="0" >all</option></select></div>

<div class="limit"></div>
<input type="hidden" name="limitstart" value="0" />
</div></del>				</td>
			</tr>
			</tfoot>-->
<?php
// $counter = 1;
// if (!empty($qr_data)) {
// 	foreach ($qr_data as $k => $v) {
	?>
<!--            <tbody>
                <tr class="row0">
                    <td width="1%"> <?= $counter ?> </td>
                    <td width="1%">
		    <input type="checkbox" id="cb<?=$k?>" name="skpd_id[]" value="<?= $v[skpd_id]; ?>" onclick="isChecked(this.checked,'<?= $v[skpd_nama]; ?>');" />					</td>
                    <td width="5%"> <?= $v[skpd_kode]; ?> </td>
                    <td width="25%">
                        <a href="<?php echo $myself.$XFA['act_mstr_satuan_kerja']."&master=satker&task=edit&skpd_id[]=".$v[skpd_id]; ?>">
                        <?= $v[skpd_nama]; ?> </a>
                    </td>
                    <td width="25%">
                        <?= $v[skpd_nama2]; ?>
                    </td>
                </tr>
            </tbody>-->
<?php
// 	$counter++;
// 	}
// }
?>
			<!--</table>-->

		<input type="hidden" name="nd" value="0" />
		<input type="hidden" name="option" value="com_languages" />
		<input type="hidden" name="client" value="0" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="master" value="satker" />
		<input type="hidden" name="boxchecked" value="0" />

<!--FLEXIGRID-->
		<input type="hidden" name="sqtype" value="<?//=$attributes[sqtype]?>" />
		<input type="hidden" name="squery" value="<?//=$attributes[squery]?>" />
		<input type="hidden" name="snewp" value="<?//=$attributes[snewp]?>" />
		<input type="hidden" name="srp" value="<?//=$attributes[srp]?>" />
		<input type="hidden" name="tarik" value="" />


		<input type="hidden" name="bca500dec7e618674e233206add340e6" value="1" />
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