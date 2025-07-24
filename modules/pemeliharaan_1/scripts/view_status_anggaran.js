/**
 * Create main data grid
 */
var createDataGridStatus = function (){
	$("#status_anggaran_table").flexigrid({
		url: GLOBAL_STATUS_ANGGARAN_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 80, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 100, align: 'center', process: cellClick},
			{display: 'Status Anggaran', name : 'ref_statang_ket', width : 400, sortable : true, align: 'left'}
			],
		searchitems : [
			{display: 'Status Anggaran', name : 'ref_statang_ket'}
		],
		sortname: "ref_statang_id",
		sortorder: "asc",
		usepager: true,
		title: 'DAFTAR STATUS ANGGARAN',
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
		
		if ($('#cbsa'+id+':checked').val() == null) {
			$('#cbsa'+id).attr("checked",true);
			$("input[name=ref_statang_id]").val($(cells[0]).text());
		}
		else {
			$('#cbsa'+id).attr("checked",false);
			$("input[name=ref_statang_id]").val('');
		}	
    });
 };
 
 /**
  * isChecked sptpd
  * @param id
  * @returns
  */
 var isChecked = function(id, sptId) {
	 if ($('#cbsa'+id+':checked').val() == null) {
		$('#cbsa'+id).attr("checked",true);
		$("input[name=ref_statang_id]").val(sptId);
	 }
	 else {
		$('#cbsa'+id).attr("checked",false);
		$("input[name=ref_statang_id]").val('');
	 }
 };
 
 /**
  * selectRows function
  * @returns
  */
 var selectRows = function() {
	var rows = $("#status_anggaran_table").find("tr").get();
	if(rows.length > 0) {
		$.each(rows,function(i,n) {
			$(n).toggleClass("trSelected");
		});
	};
	
	$(".toggle_status_anggaran").each( function () {
		if ($(this).is(':checked')) {
			$(this).removeAttr('checked');
		} else {
			$(this).attr('checked', 'true');
			$("input[name=ref_statang_id]").val($(this).val());
		}		
	});
};

/**
 * select row index
 * @param index
 * @returns
 */
var selectRow = function(index, id) {
	if ($("#cbsa"+index).is(':checked')) {
		$("input[name=ref_statang_id]").val(id);
	} else {
		$("input[name=ref_statang_id]").val('');
	}
};

var editStatusAnggaran = function(id, nama) {
	$("input[name=mode]").val("edit");
	$("#ref_statang_ket").val(nama);
	$("input[name=ref_statang_id]").val(id);
	$('#div_dialog_box').animate({
        scrollTop: $("#editor").offset().top},
        'slow');
};

var resetState = function() {
	$("input[name=mode]").val("add");
	$("#ref_statang_ket").val("");
	$("input[name=ref_statang_id]").val("");
	$('#div_dialog_box').animate({
        scrollTop: $("#top").offset().top},
        'slow');
	$("input[name=ref_statang_id]").val('');
};

 /**
  * Form button
  */
 var createEventToolbarJabatan = function (){ 	
 	$("#btn_status_save").click(function (){ 		
 		if($("input[name=mode]").val()=='add') {
 			vURL = GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/status_anggaran/insert";
 		} else {
 			vURL = GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/status_anggaran/update";
 		}
 		
 		var options = { 
    		url : vURL,
    		type : "POST",
    		dataType: 'json',
    		beforeSubmit: jqform_validate,	// pre-submit callback 
			success: function(response) {
				$("#status_anggaran_table").flexReload();
				resetState();
				
				if (response.status == true)
					showNotification(response.msg);
				else
					showWarning(response.msg);
			}
		}; 
		
		$("#frm_status_anggaran").ajaxSubmit(options);
 	});
 	
 	$("#btn_delete_status_anggaran").click(function (){ 		
 		if ($("input[name=ref_statang_id]").val().length > 0) {
 			showAuthentication('delete');
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk dihapus");
		}
 	});
 	
 	$("#btn_status_reset").click(function() {
 		resetState();
 	});
 	
 	$("#btn_add_status_anggaran").click(function(){
 		$("input[name=mode]").val("add");
 		$("#ref_statang_ket").val("");
 		$("input[name=ref_statang_id]").val("");
 		$('#div_dialog_box').animate({
 	        scrollTop: $("#editor").offset().top},
 	        'slow');
 	});
 	
 	$("#btn_close_status_anggaran").click(function() {
 		$("#div_dialog_box").dialog('close');
 	});
 };
 
 var deleteData = function() {
	 var remove = function (){
		 var selectedItems = "";
		 
		 $(".toggle_status_anggaran").each( function () {
			if ($(this).is(':checked')) {
				selectedItems += $(this).val() + "|";
			}		
		});
		 
		 $.ajax({
		     type: "POST",
		     url: GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/status_anggaran/delete",
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#status_anggaran_table").flexReload();
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
	createDataGridStatus();
	createEventToolbarJabatan();
});