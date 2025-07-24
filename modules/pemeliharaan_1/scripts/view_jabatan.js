/**
 * Create main data grid
 */
var createDataGridJabatan = function (){
	$("#jabatan_table").flexigrid({
		url: GLOBAL_JABATAN_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'ref_japeda_id', width : 200, sortable : true, align: 'left', hide:true, process: cellClick},
			{display: 'No.', name : '', width : 80, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 100, align: 'center', process: cellClick},
			{display: 'Nama Jabatan', name : 'ref_japeda_nama', width : 400, sortable : true, align: 'left'}
			],
		searchitems : [
			{display: 'Nama Jabatan', name : 'pejda_nama'}
		],
		sortname: "ref_japeda_id",
		sortorder: "asc",
		usepager: true,
		title: 'DAFTAR JABATAN',
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
		
		if ($('#cbj'+id+':checked').val() == null) {
			$('#cbj'+id).attr("checked",true);
			$("input[name=id_jabatan]").val($(cells[0]).text());
		}
		else {
			$('#cbj'+id).attr("checked",false);
			$("input[name=id_jabatan]").val('');
		}	
    });
 };
 
 /**
  * isChecked sptpd
  * @param id
  * @returns
  */
 var isChecked = function(id, sptId) {
	 if ($('#cbj'+id+':checked').val() == null) {
		$('#cbj'+id).attr("checked",true);
		$("input[name=id_jabatan]").val(sptId);
	 }
	 else {
		$('#cbj'+id).attr("checked",false);
		$("input[name=id_jabatan]").val('');
	 }
 };
 
 /**
  * selectRows function
  * @returns
  */
 var selectRows = function() {
	var rows = $("#jabatan_table").find("tr").get();
	if(rows.length > 0) {
		$.each(rows,function(i,n) {
			$(n).toggleClass("trSelected");
		});
	};
	
	$(".toggle_jabatan").each( function () {
		if ($(this).is(':checked')) {
			$(this).removeAttr('checked');
		} else {
			$(this).attr('checked', 'true');
			$("input[name=id_jabatan]").val($(this).val());
		}		
	});
};

/**
 * select row index
 * @param index
 * @returns
 */
var selectRow = function(index, id) {
	if ($("#cbj"+index).is(':checked')) {
		$("input[name=id_jabatan]").val(id);
	} else {
		$("input[name=id_jabatan]").val('');
	}
};

var editJabatan = function(id, nama) {
	$("input[name=mode]").val("edit");
	$("#ref_japeda_nama").val(nama);
	$("input[name=ref_japeda_id]").val(id);
	$('#div_dialog_box').animate({
        scrollTop: $("#editor").offset().top},
        'slow');
};

var resetState = function() {
	$("input[name=mode]").val("add");
	$("#ref_japeda_nama").val("");
	$("input[name=ref_japeda_id]").val("");
	$('#div_dialog_box').animate({
        scrollTop: $("#top").offset().top},
        'slow');
	$("input[name=id_jabatan]").val('');
};

 /**
  * Form button
  */
 var createEventToolbarJabatan = function (){ 	
 	$("#btn_jab_save").click(function (){ 		
 		if($("input[name=mode]").val()=='add') {
 			vURL = GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/jabatan/insert";
 		} else {
 			vURL = GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/jabatan/update";
 		}
 		
 		var options = { 
    		url : vURL,
    		type : "POST",
    		dataType: 'json',
    		beforeSubmit: jqform_validate,	// pre-submit callback 
			success: function(response) {
				$("#jabatan_table").flexReload();
				resetState();
				
				if (response.status == true)
					showNotification(response.msg);
				else
					showWarning(response.msg);
			}
		}; 
		
		$("#frm_jabatan").ajaxSubmit(options);
 	});
 	
 	$("#btn_delete_jabatan").click(function (){ 		
 		if ($("input[name=id_jabatan]").val().length > 0) {
 			showAuthentication('delete');
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk dihapus");
		}
 	});
 	
 	$("#btn_jab_reset, #btn_jab_batal").click(function() {
 		resetState();
 	});
 	
 	$("#btn_add_jabatan").click(function(){
 		$("input[name=mode]").val("add");
 		$("#ref_japeda_nama").val("");
 		$("input[name=ref_japeda_id]").val("");
 		$('#div_dialog_box').animate({
 	        scrollTop: $("#editor").offset().top},
 	        'slow');
 	});
 	
 	$("#btn_close_jabatan").click(function() {
 		$("#div_dialog_box").dialog('close');
 	});
 };
 
 var deleteData = function() {
	 var remove = function (){
		 var selectedItems = "";
		 
		 $(".toggle_jabatan").each( function () {
			if ($(this).is(':checked')) {
				selectedItems += $(this).val() + "|";
			}		
		});
		 
		 $.ajax({
		     type: "POST",
		     url: GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/jabatan/delete",
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#jabatan_table").flexReload();
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
	createDataGridJabatan();
	createEventToolbarJabatan();
});