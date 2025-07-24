
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
								<td class="button" id="toolbar-new">
									<a href="#" onclick="javascript:hideMainMenu(); submitbutton('add')" class="toolbar"> 
										<span class="icon-32-new" title="New"></span> 
										Baru
									</a>
								</td>
								<td class="button" id="toolbar-edit">
									<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Silahkan tentukan pilihan dari daftar untuk melakukan EDIT');}else{ hideMainMenu(); submitbutton('edit')}" class="toolbar"> 
										<span class="icon-32-edit" title="Edit"> </span>
										Edit 
									</a>
								</td>
								<td class="button" id="toolbar-delete">
									<a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Silahkan tentukan pilihan dari daftar untuk melakukan HAPUS');}else{  submitbutton('remove')}" class="toolbar"> 
										<span class="icon-32-delete" title="Delete"> </span>
										Hapus 
									</a>
								</td>
							</tr>
						</table>
					</div>
					<div class="header icon-48-master">Tabel Bank</div>
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

<form action="<?//= $myself.$XFA['act_mstr_bank']; ?>" method="post" name="adminForm">
<table id="flex1" style="display: none"></table>
	<span id="saveBar"></span>  
	<input type="hidden" name="nd" value="0" /> 
	<input type="hidden" name="option" value="com_modules" /> 
	<input type="hidden" name="client" value="0" /> 
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" /> 
	<input type="hidden" name="filter_order" value="m.position" /> 
	<input type="hidden" name="filter_order_Dir" value="" /> <!--FLEXIGRID--> 
	<input type="hidden" name="sqtype" value="<?//=$attributes[sqtype]?>" /> 
	<input type="hidden" name="squery" value="<?//=$attributes[squery]?>" /> 
	<input type="hidden" name="snewp" value="<?//=$attributes[snewp]?>" /> 
	<input type="hidden" name="srp" value="<?//=$attributes[srp]?>" /> 
	<input type="hidden" name="tarik" value="" /> 

<input type="hidden" name="84f4092560a267906dbac5e2e8f652cb" value="1" />
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
			Warning! JavaScript must be enabled for proper operation of the Administrator Back-end
			</noscript>

			<div class="clr"></div>
		</div>
