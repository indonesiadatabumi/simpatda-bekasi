/**
 * Create main data grid
 */
var createDataGridTarget = function (){
	$("#target_anggaran_table").flexigrid({
		url: GLOBAL_TARGET_ANGGARAN_VARS["get_list"] + "?tahang_id="+ $("input[name=tahangdet_id_header]").val(),
		dataType: 'json',
		colModel : [
		    {display: 'ID', name : 'tahangdet_id', width : 10, align: 'center', hide: true},
			{display: 'No.', name : '', width : 10, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'Kode Rekening', name : 'korek_group', width : 100, sortable : false, align: 'left', process: cellClick},
			{display: 'Nama Rekening', name : 'korek_nama', width : 400, sortable : false, align: 'left', process: cellClick},
			{display: 'Jumlah', name : 'tahangdet_jumlah', width : 200, sortable : false, align: 'right', process: cellClick}
		],
		searchitems : [
			{display: 'Kode Rekening', name : 'kode_rek_raw', isdefault: true},
			{display: 'Nama Rekening', name : 'korek_nama', isdefault: true}
		],
		usepager: true,
		title: 'DAFTAR TARGET ANGGARAN',
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
		
		if ($('#cbta'+id+':checked').val() == null) {
			$('#cbta'+id).attr("checked",true);
			$("input[name=tahangdet_id]").val($(cells[0]).text());
		}
		else {
			$('#cbta'+id).attr("checked",false);
			$("input[name=tahangdet_id]").val('');
		}	
    });
 };
 
 /**
  * isChecked sptpd
  * @param id
  * @returns
  */
 var isChecked = function(id, sptId) {
	 if ($('#cbta'+id+':checked').val() == null) {
		$('#cbta'+id).attr("checked",true);
		$("input[name=tahangdet_id]").val(sptId);
	 }
	 else {
		$('#cbta'+id).attr("checked",false);
		$("input[name=tahangdet_id]").val('');
	 }
 };
 
 /**
  * selectRows function
  * @returns
  */
 var selectRows = function() {
	var rows = $("#target_anggaran_table").find("tr").get();
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
			$("input[name=tahangdet_id]").val($(this).val());
		}		
	});
};

/**
 * select row index
 * @param index
 * @returns
 */
var selectRow = function(index, id) {
	if ($("#cbta"+index).is(':checked')) {
		$("input[name=tahangdet_id]").val(id);
	} else {
		$("input[name=tahangdet_id]").val('');
	}
};

var resetState = function() {
	$("input[name=mode]").val("add");
	$("input[name=tahangdet_id]").val("");
	$("input[name=tahangdet_jumlah]").val('');
};

 /**
  * Form button
  */
 var createEventToolbarJabatan = function (){ 	
 	$("#btn_target_save").click(function (){ 		
 		if($("input[name=mode]").val()=='add') {
 			vURL = GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/target_anggaran/insert";
 		} else {
 			vURL = GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/target_anggaran/update";
 		}
 		
 		var options = { 
    		url : vURL,
    		type : "POST",
    		dataType: 'json',
    		beforeSubmit: jqform_validate,	// pre-submit callback 
			success: function(response) {
				$("#target_anggaran_table").flexReload();
				resetState();
				
				if (response.status == true)
					showNotification(response.msg);
				else
					showWarning(response.msg);
			},
			error: function() {
				alert("Terjadi error. Silahkan menghubungi administrator");
			}
		}; 
		
		$("#frm_target_anggaran").ajaxSubmit(options);
 	});
 	
 	$("#btn_edit_target").click(function (){ 		
 		if ($("input[name=tahangdet_id]").val().length > 0) {
 			$.ajax({
 				type: "POST",
 				url: GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/target_anggaran/get_detail",
 				data: { tahangdet_id: $("input[name=tahangdet_id]").val() },
 				success: function(response) {
 					if (response.status == true) {
 						$("input[name=mode]").val("edit");
 						$("#tahangdet_id_rek option[value='"+response.data.tahangdet_id_rek+"']").attr("selected", "selected");
 						$("input[name=tahangdet_jumlah]").val(formatCurrency(response.data.tahangdet_jumlah));
 					}						
					else
						showWarning(response.msg);
				},
 				dataType: "json",
				error: function() {
					alert("Terjadi error. Silahkan menghubungi administrator");
				}
			});
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk diubah");
		}
 	});
 	
 	$("#btn_delete_target").click(function (){ 		
 		if ($("input[name=tahangdet_id]").val().length > 0) {
 			showAuthentication('delete');
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk dihapus");
		}
 	});
 	
 	$("#btn_target_reset").click(function() {
 		resetState();
 	});
 	
 	$("#btn_add_target").click(function(){
 		$("input[name=mode]").val("add");
 		$("#ref_statang_ket").val("");
 		$("input[name=tahangdet_id]").val("");
 		$('#div_dialog_box').animate({
 	        scrollTop: $("#editor").offset().top},
 	        'slow');
 	});
 	
 	$("#btn_close_target").click(function() {
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
		     url: GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/target_anggaran/delete",
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#target_anggaran_table").flexReload();
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
	createDataGridTarget();
	createEventToolbarJabatan();
});