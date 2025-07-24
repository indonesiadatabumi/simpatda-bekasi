/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#tbl_pejabat").flexigrid({
		url: GLOBAL_MASTER_PEJABAT_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 10, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'ID', name : 'pejda_id', width : 30, sortable : true, align: 'left', process: cellClick},
			{display: 'Kode', name : 'pejda_kode', width : 100, sortable : true, align: 'center', process: cellClick},
			{display: 'Nama', name : 'pejda_nama', width : 250, sortable : true, align: 'left'},
			{display: 'Jabatan', name : 'ref_japeda_nama', width : 300, sortable : true, align: 'left', process: cellClick},
			{display: 'Golongan', name : 'ref_goru_ket', width : 100, sortable : true, align: 'center', process: cellClick},
			{display: 'NIP', name : 'pejda_nip', width : 140, sortable : true, align: 'center', process: cellClick},
			{display: 'Status', name : 'ref_stajab_ket', width : 100, sortable : true, align: 'center', process: cellClick}
			],
			//buttons : [
			//	{name: 'Add', bclass: 'add', onpress : test},
			//	{name: 'Delete', bclass: 'delete', onpress : test},
			//	{separator: true}
			//	],
		searchitems : [
			{display: 'Kode', name : 'pejda_kode', isdefault: true},
			{display: 'Nama', name : 'pejda_nama'},
			{display: 'Jabatan', name : 'ref_japeda_nama'},
			{display: 'Golongan', name : 'ref_goru_ket'},
			{display: 'NIP', name : 'pejda_nip'},
			{display: 'Status', name : 'ref_stajab_ket'}
		],
		sortname: "pejda_kode",
		sortorder: "asc",
		usepager: true,
		title: 'DAFTAR PEJABAT',
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
 * editData
 * @param title
 * @param id
 * @returns
 */
var editData = function(id) {
	showDialogPost(GLOBAL_MASTER_PEJABAT_VARS["edit"], "Pejabat", {'pejda_id' : id}, 850, 450);
};

 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		showDialog(GLOBAL_MASTER_PEJABAT_VARS["add"], "Pejabat", 850, 450);
 	});
 	
 	$("#btn_edit").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			editData($("input[name=id]").val());
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
 	
 	$("#btn_jabatan").click(function() {
 		showDialog(GLOBAL_MASTER_PEJABAT_VARS["form_jabatan"], 'Daftar Jabatan', 950, 550);
 	});
 	
 	$("#btn_golongan").click(function() {
 		showDialog(GLOBAL_MASTER_PEJABAT_VARS["form_golongan"], 'Daftar Golongan', 950, 550);
 	});
 	
 	$("#btn_pangkat").click(function() {
 		showDialog(GLOBAL_MASTER_PEJABAT_VARS["form_pangkat"], 'Daftar Pangkat', 950, 550);
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
		     url: GLOBAL_MASTER_PEJABAT_VARS["delete"],
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#tbl_pejabat").flexReload();
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