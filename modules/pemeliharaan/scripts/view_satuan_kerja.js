/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#tbl_satuan_kerja").flexigrid({
		url: GLOBAL_SATUAN_KERJA_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'skpd_id', width : 200, sortable : true, align: 'left', hide:true, process: cellClick},
			{display: 'No.', name : '', width : 10, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'Instansi', name : 'instansi', width : 50, align: 'center', process: cellClick},
			{display: 'Urusan', name : 'ref_urus_nama', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Bidang', name : 'bdg_nama', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Kode', name : 'skpd_kode', width : 100, sortable : true, align: 'center', process: cellClick},
			{display: 'Nama', name : 'skpd_nama', width : 400, sortable : true, align: 'left', process: cellClick},
			{display: 'NPWP', name : 'bdg_nama', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Bidang Tambahan', name : 'skpd_bidang_tambahan', width : 300, sortable : true, align: 'left', process: cellClick}
		],
		searchitems : [
			{display: 'Kode', name : 'skpd_kode', isdefault: true},
			{display: 'Nama', name : 'skpd_nama'},
			{display: 'Urusan', name : 'ref_urus_nama'},
			{display: 'Bidang', name : 'bdg_nama'}
		],
		sortname: "bdg_urusan,bdg_kode,skpd_kode",
		sortorder: "asc",
		usepager: true,
		title: 'DAFTAR SATUAN KERJA',
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


var disableInstansi = function(id) {
	$.post(GLOBAL_SATUAN_KERJA_VARS["instansi"], {
		status : 'false',
		skpd_id : id
	}, function(data) {
		$("#tbl_satuan_kerja").flexReload();
	});
};

var enableInstansi = function(id) {
	$.post(GLOBAL_SATUAN_KERJA_VARS["instansi"], {
		status : 'true',
		skpd_id : id
	}, function(data) {
		$("#tbl_satuan_kerja").flexReload();
	});
};

/**
 * open target anggaran
 * @param title
 * @param id
 * @returns
 */
var editSatuanKerja = function(id) {
	showDialogPost(GLOBAL_SATUAN_KERJA_VARS["edit"], "Satuan Kerja", {skpd_id : id}, 700, 400);
};

 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		showDialog(GLOBAL_SATUAN_KERJA_VARS["add"], "Satuan Kerja", 700, 400);
 	});
 	
 	$("#btn_edit").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			editKecamatan($("input[name=id]").val());
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
 		showDialog(GLOBAL_SATUAN_KERJA_VARS["form_status_anggaran"], 'Status Anggaran', 950, 550);
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
		     url: GLOBAL_SATUAN_KERJA_VARS["delete"],
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#tbl_satuan_kerja").flexReload();
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