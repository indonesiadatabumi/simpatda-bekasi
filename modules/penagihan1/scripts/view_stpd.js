/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#stpd_table").flexigrid({
		url: GLOBAL_STPD_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'netapajrek_id', width : 200, sortable : true, align: 'left', hide:true},
			{display: 'No.', name : '', width : 10, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'Nomor', name : 'stpd_nomor', width : 40, sortable : true, align: 'left', process: cellClick},
			{display: 'Periode', name : 'stpd_periode', width : 50, sortable : true, align: 'center', process: cellClick},
			{display: 'Nama Pajak', name : 'ref_jenparet_ket', width : 120, sortable : true, align: 'left', process: cellClick},
			{display: 'Kode Rekening', name : 'koderek', width : 80, sortable : true, align: 'center',process: cellClick},
			{display: 'Nama Rekening', name : 'korek_nama', width : 160, sortable : true, align: 'left', process: cellClick},
			{display: 'Tanggal Proses', name : 'stpd_tgl_proses', width : 80, sortable : true, align: 'center', process: cellClick},
			{display: 'Jatuh Tempo', name : 'stpd_jatuh_tempo', width : 75, sortable : true, align: 'center', process: cellClick},			
			{display: 'NPWPD', name : 'npwprd', width : 120, sortable : true, align: 'center', process: cellClick},
			{display: 'Nama WP', name : 'wp_wr_nama', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Jumlah Tagihan', name : 'stpd_pajak', width : 120, sortable : true, align: 'right', process: cellClick}
			],
		searchitems : [
		    {display: 'Nomor STPD', name : 'stpd_nomor', isdefault: true},
			{display: 'Periode STPD', name : 'stpd_periode'},			
			{display: 'Nama WP', name : 'wp_wr_nama'},
			{display: 'NPWPD', name : 'npwprd'},
			{display: 'Nama Pajak', name : 'ref_jenparet_ket'},
			],
		sortname: "stpd_nomor",
		sortorder: "DESC",
		usepager: true,
		title: 'DAFTAR STPD',
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
 * edit data
 * @param spt_id
 * @param spt_jenis_pajak
 * @returns
 */
var editData = function(stpd_id) {
	showDialogPost(GLOBAL_STPD_VARS["edit_stpd"], "STPD", {
				'stpd_id' : stpd_id
			}, 900, 500);
};




 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		load_content(GLOBAL_MAIN_VARS["BASE_URL"] + "penagihan/stpd/add");
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
		     url: GLOBAL_STPD_VARS["delete_stpd"],
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#stpd_table").flexReload();
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