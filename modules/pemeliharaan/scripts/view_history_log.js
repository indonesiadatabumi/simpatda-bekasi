/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#tbl_history_log").flexigrid({
		url: GLOBAL_HISTORY_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'camat_id', width : 200, sortable : true, align: 'left', hide:true, process: cellClick},
			{display: 'No.', name : '', width : 20, align: 'left', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'Waktu', name : 'hislog_time', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Nama User', name : 'hislog_opr_user', width : 100, sortable : true, align: 'left', process: cellClick},
			{display: 'Nama Lengkap', name : 'opr_nama', width : 150, sortable : true, align: 'left', process: cellClick},
			{display: 'IP Address', name : 'hislog_ip_address', width : 80, sortable : true, align: 'left', process: cellClick},
			{display: 'Modul', name : 'hislog_module', width : 100, sortable : true, align: 'left', process: cellClick},
			{display: 'Aksi', name : 'hislog_action', width : 80, sortable : true, align: 'left', process: cellClick},
			{display: 'Deskripsi', name : 'hislog_description', width : 400, sortable : true, align: 'left', process: cellClick}
		],
		searchitems : [
			{display: 'Nama User', name : 'hislog_opr_user', isdefault: true},
			{display: 'Nama Lengkap', name : 'opr_nama'},
			{display: 'IP Address', name : 'hislog_ip_address'},
			{display: 'Modul', name : 'hislog_module'},
			{display: 'Aksi', name : 'hislog_action'},
			{display: 'Deskripsi', name : 'hislog_description'}
		],
		sortname: "hislog_time",
		sortorder: "desc",
		usepager: true,
		title: 'Daftar History Log',
		useRp: true,
		rp: 15,
		showTableToggleBtn: false,
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
 	$("#btn_delete").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			showAuthentication('delete');
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk dihapus");
		}
 	});
 	
 	$("#btn_status_anggaran").click(function() {
 		showDialog(GLOBAL_HISTORY_VARS["form_status_anggaran"], 'Status Anggaran', 950, 550);
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
		     url: GLOBAL_HISTORY_VARS["delete"],
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#tbl_history_log").flexReload();
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