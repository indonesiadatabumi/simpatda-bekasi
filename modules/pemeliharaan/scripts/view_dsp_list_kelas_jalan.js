/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#kelas_jalan_table").flexigrid({
		url: GLOBAL_KELAS_JALAN_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'ref_kelas_jalan_id', width : 200, sortable : true, align: 'left', hide:true, process: cellClick},
			{display: 'No.', name : '', width : 10, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'Kelas Jalan', name : 'ref_kelas_jalan_id', width : 250, sortable : true, align: 'left', process: cellClick}
			],
		searchitems : [
			{display: 'Kelas Jalan', name : 'ref_kelas_jalan_nama', isdefault: true}
			],
		sortname: "ref_kelas_jalan_nama",
		sortorder: "asc",
		usepager: true,
		title: 'Tabel Kelas Jalan',
		usepager: true,
		title: 'DAFTAR SETORAN',
		useRp: true,
		rp: 10,
		showTableToggleBtn: true,
		height: 'auto'
	});
};

/**
 * cellClick Event from grid
 * @param celDiv
 * @param id
 * @returns
 */
var cellClick = function(celDiv,id) {
    $(celDiv).click(function (){
    	var $row = $(celDiv).parent().parent();
		var cells = $("div", $row);
		
		if ($('#cb'+id+':checked').val() == null) {
			$('#cb'+id).attr("checked",true);
			$("input[name=id]").val($(cells[0]).text());
		}
		else {
			$('#cb'+id).attr("checked",false);
			$("input[name=id]").val('');
		}	
    });
 };
 
 /**
  * isChecked sptpd
  * @param id
  * @returns
  */
 var isChecked = function(id, sptId) {
	 if ($('#cb'+id+':checked').val() == null) {
		$('#cb'+id).attr("checked",true);
		$("input[name=id]").val(sptId);
	 }
	 else {
		$('#cb'+id).attr("checked",false);
		$("input[name=id]").val('');
	 }
 };
 
 /**
  * selectRows function
  * @returns
  */
 var selectRows = function() {
	var rows = $("table#wp_pribadi_table").find("tr").get();
	if(rows.length > 0) {
		$.each(rows,function(i,n) {
			$(n).toggleClass("trSelected");
		});
	};
	
	$(".toggle").each( function () {
		if ($(this).is(':checked')) {
			$(this).removeAttr('checked');
		} else {
			$(this).attr('checked', 'true');
			$("input[name=id]").val($(this).val());
		}		
	});
};

/**
 * select row index
 * @param index
 * @returns
 */
var selectRow = function(index, id) {
	if ($("#cb"+index).is(':checked')) {
		$("input[name=id]").val(id);
	} else {
		$("input[name=id]").val('');
	}
};

 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		// load content
 		load_content(GLOBAL_PAJAK_HOTEL_VARS["add_sptpd_hotel"]);
 	});
 	
 	$("#btn_edit").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			load_content(GLOBAL_PAJAK_HOTEL_VARS["edit_sptpd_hotel"], {
 																	'spt_id' : $("input[name=id]").val(),
 																	'spt_jenis_pajakretribusi' : $("input[name=spt_jenis_pajakretribusi]").val()
 																}
 						);
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk diedit");
		}
 	});
 	
 	$("#btn_delete").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			showAuthentication('delete');
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk dihapus");
		}
 	});
 };
 
 var deleteData = function() {
	 var remove = function (){
		 var selectedItems = "";
		 
		 $(".toggle").each( function () {
			if ($(this).is(':checked')) {
				selectedItems += $(this).val() + "|";
			}		
		});
		 
		 $.ajax({
		     type: "POST",
		     url: GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_hotel/delete",
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#pajak_hotel_table").flexReload();
	 			showNotification(msg);
		     }
		 });
	 };
		 
	 $("#confirmation_delete").dialog({
		bgiframe: true,
		resizable: false,
		height: 350,
		height: 140,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.2
		},
		buttons: {
			'Ya': function() {
				$(this).dialog('close');
				remove();
			},
			'Tidak': function() {
				$(this).dialog('close');
			}
		}
	});
 };
 
$(document).ready(function(){
	//flexigrid table
	createDataGrid();
	createEventToolbar();
});