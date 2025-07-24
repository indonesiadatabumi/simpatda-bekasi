
				<div id="toolbar-box">
   			<div class="t">
				<div class="t">
					<div class="t"></div>
				</div>

			</div>
			<div class="m">
				<div class="toolbar" id="toolbar">
<table class="toolbar"><tr>

<td class="button" id="toolbar-new">
<a href="#" onclick="javascript:hideMainMenu(); submitbutton('add')" class="toolbar">
<span class="icon-32-new" title="New">
</span>

Baru
</a>
</td>

<td class="button" id="toolbar-edit">
<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Silahkan tentukan pilihan dari daftar untuk melakukan EDIT');}else{ hideMainMenu(); submitbutton('edit')}" class="toolbar">
<span class="icon-32-edit" title="Edit">
</span>
Edit
</a>
</td>

<td class="button" id="toolbar-delete">
<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Silahkan tentukan pilihan dari daftar untuk melakukan HAPUS');}else{  submitbutton('remove')}" class="toolbar">
<span class="icon-32-delete" title="Delete">

</span>
Hapus
</a>
</td>

</tr></table>
</div>
				<div class="header icon-48-master">
Tabel Kecamatan

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

<!--						<form action="<?php echo $myself.$XFA['dsp_mstr_kecamatan']; ?>" method="post" name="filterForm">

			<table>
			<tr>
				<td align="left" width="100%">
					Filter:
					<select name="filter_assigned1" id="filter_assigned" class="inputbox" size="1">
	

					<option value="0"  selected="selected">- Semua Kolom -</option><option value="Kode Kecamatan" >Kode Kecamatan</option><option value="Nama Kecamatan" >Nama Kecamatan</option></select>

					<select name="filter_assigned2" id="filter_assigned" class="inputbox" size="1">
					<option value="0"  selected="selected">Diawali</option><option value="Memuat" >Memuat</option></select>
	
					<input type="text" name="search" id="search" value="" class="text_area" />
					<button onclick="this.form.submit();">Go</button>

					<button onclick="document.getElementById('search').value='';this.form.submit();">Reset</button>
					<input type="hidden" name="cari" value="kecamatan" />


				</td>
				<td nowrap="nowrap">
					</td>

			</tr>
			</table>
			</form>-->
<form action="<?//= $myself.$XFA['act_mstr_kecamatan']; ?>" method="post" name="adminForm">
<table id="flex1" style="display:none"></table>


<span id="saveBar"></span>

<!--			<table class="adminlist" cellspacing="1">
			<thead>
			<tr>
				<th width="20">
					#				</th>
				<th width="20">

					<input type="checkbox" name="toggle" value="" onclick="checkAll(20);" />
				</th>
				<th class="title" width="7%">
					<a href="javascript:tableOrdering('m.published','desc','');" title="Klik untuk sort berdasarkan kolom ini">Kode Kecamatan</a>				</th>
				<th class="title">

					<a href="javascript:tableOrdering('m.position','desc','');" title="Klik untuk sort berdasarkan kolom ini">Nama Kecamatan<img src="administrator/images/sort_asc.png" alt=""  /></a>				</th>
				
			</tr>
			</thead>
			<tfoot>
			<tr>
				<td colspan="12">
					<del class="container"><div class="pagination">

<div class="limit">Display #<select name="limit" id="limit" class="inputbox" size="1" onchange="submitform();"><option value="5" >5</option><option value="10" >10</option><option value="15" >15</option><option value="20"  selected="selected">20</option><option value="25" >25</option><option value="30" >30</option><option value="50" >50</option><option value="100" >100</option><option value="0" >All</option></select></div><div class="button2-right off"><div class="start"><span>Start</span></div></div><div class="button2-right off"><div class="prev"><span>Prev</span></div></div>
<div class="button2-left"><div class="page"><span>1</span><a title="2" onclick="javascript: document.adminForm.limitstart.value=20; submitform();return false;">2</a>
</div></div><div class="button2-left"><div class="next"><a title="Next" onclick="javascript: document.adminForm.limitstart.value=20; submitform();return false;">Next</a></div></div><div class="button2-left"><div class="end"><a title="End" onclick="javascript: document.adminForm.limitstart.value=20; submitform();return false;">End</a></div></div>

<div class="limit">Page 1 of 2</div>
<input type="hidden" name="limitstart" value="0" />
</div></del>				</td>
			</tr>
			</tfoot>
			<tbody>-->

<?php
// $counter = 1;
// if (!empty($qr_data)) {
// 	foreach ($qr_data as $k => $v) {
?>
<!--							<tr class="row0">
					<td align="right">
						<?= $counter; ?>					</td>

					<td width="20"><input type="checkbox" id="cb<?=$k?>" name="camat_id[]" value="<?= $v[camat_id]; ?>" onclick="isChecked(this.checked,'<?= $v[camat_nama]; ?>');" /></td>
					
					<td align="center">
						<?= $v[camat_kode]; ?>					</td>
					<td>
						<span class="editlinktip hasTip" title="Klik untuk Edit Kecamatan ini::SIMPATDA">
					<a href="<?php echo $myself.$XFA['act_mstr_kecamatan']."&task=edit&camat_id[]=".$v[camat_id]; ?>">
					<?= $v[camat_nama]; ?></a></span>				</td>
											
				</tr>-->
<?php
// 	$counter++;
// 	}
// }
?>
<!--							</tbody>
			</table>-->
		<input type="hidden" name="nd" value="0" />
		<input type="hidden" name="option" value="com_modules" />
		<input type="hidden" name="client" value="0" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="m.position" />
		<input type="hidden" name="filter_order_Dir" value="" />


		<input type="hidden" name="84f4092560a267906dbac5e2e8f652cb" value="1" />		</form>
		
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

