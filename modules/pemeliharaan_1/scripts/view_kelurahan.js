/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#tbl_kelurahan").flexigrid({
		url: GLOBAL_KELURAHAN_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'lurah_id', width : 200, sortable : true, align: 'left', hide:true, process: cellClick},
			{display: 'No.', name : '', width : 10, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'Kode Kecamatan', name : 'camat_kode', width : 100, sortable : true, align: 'center', process: cellClick},
			{display: 'Kode Kelurahan', name : 'lurah_kode', width : 100, sortable : true, align: 'center', process: cellClick},
			{display: 'Nama Kelurahan', name : 'lurah_nama', width : 300, sortable : true, align: 'left'},
			{display: 'Nama Kecamatan', name : 'camat_nama', width : 300, sortable : true, align: 'left', process: cellClick}
		],
		searchitems : [
			{display: 'Kode Kelurahan', name : 'lurah_kode', isdefault: true},
			{display: 'Nama Kelurahan', name : 'lurah_nama'},
			{display: 'Kode Kecamatan', name : 'camat_kode'},
			{display: 'Nama Kecamatan', name : 'camat_nama'}
		],
		sortname: "camat_kode,lurah_kode",
		sortorder: "asc",
		usepager: true,
		title: 'DAFTAR KELURAHAN',
		useRp: true,
		rp: 10,
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
 * open target anggaran
 * @param title
 * @param id
 * @returns
 */
var editKelurahan = function(id) {
	showDialogPost(GLOBAL_KELURAHAN_VARS["edit"], "Kelurahan", {lurah_id : id}, 700, 300);
};

 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		showDialog(GLOBAL_KELURAHAN_VARS["add"], "Kelurahan", 700, 300);
 	});
 	
 	$("#btn_edit").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			editKelurahan($("input[name=id]").val());
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
 	
 	$("#btn_status_anggaran").click(function() {
 		showDialog(GLOBAL_KELURAHAN_VARS["form_status_anggaran"], 'Status Anggaran', 950, 550);
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
		     url: GLOBAL_KELURAHAN_VARS["delete"],
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#tbl_kelurahan").flexReload();
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