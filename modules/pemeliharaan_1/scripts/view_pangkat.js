/**
 * Create main data grid
 */
var createDataGridPangkat = function (){
	$("#pangkat_table").flexigrid({
		url: GLOBAL_PANGKAT_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'ref_pangpej_id', width : 200, sortable : true, align: 'left', hide:true, process: cellClick},
			{display: 'No.', name : '', width : 80, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 100, align: 'center', process: cellClick},
			{display: 'Nama Pangkat', name : 'ref_pangpej_ket', width : 400, sortable : true, align: 'left'}
			],
		searchitems : [
			{display: 'Nama Pangkat', name : 'pejda_nama'}
		],
		sortname: "ref_pangpej_id",
		sortorder: "asc",
		usepager: true,
		title: 'DAFTAR PANGKAT',
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
		
		if ($('#cbp'+id+':checked').val() == null) {
			$('#cbp'+id).attr("checked",true);
			$("input[name=id_pangkat]").val($(cells[0]).text());
		}
		else {
			$('#cbp'+id).attr("checked",false);
			$("input[name=id_pangkat]").val('');
		}	
    });
 };
 
 /**
  * isChecked sptpd
  * @param id
  * @returns
  */
 var isChecked = function(id, sptId) {
	 if ($('#cbp'+id+':checked').val() == null) {
		$('#cbp'+id).attr("checked",true);
		$("input[name=id_pangkat]").val(sptId);
	 }
	 else {
		$('#cbp'+id).attr("checked",false);
		$("input[name=id_pangkat]").val('');
	 }
 };
 
 /**
  * selectRows function
  * @returns
  */
 var selectRows = function() {
	var rows = $("#pangkat_table").find("tr").get();
	if(rows.length > 0) {
		$.each(rows,function(i,n) {
			$(n).toggleClass("trSelected");
		});
	};
	
	$(".toggle_pangkat").each( function () {
		if ($(this).is(':checked')) {
			$(this).removeAttr('checked');
		} else {
			$(this).attr('checked', 'true');
			$("input[name=id_pangkat]").val($(this).val());
		}		
	});
};

/**
 * select row index
 * @param index
 * @returns
 */
var selectRow = function(index, id) {
	if ($("#cbp"+index).is(':checked')) {
		$("input[name=id_pangkat]").val(id);
	} else {
		$("input[name=id_pangkat]").val('');
	}
};

var editPangkat = function(id, nama) {
	$("input[name=mode]").val("edit");
	$("#ref_pangpej_ket").val(nama);
	$("input[name=ref_pangpej_id]").val(id);
	$('#div_dialog_box').animate({
        scrollTop: $("#editor").offset().top},
        'slow');
};

var resetState = function() {
	$("input[name=mode]").val("add");
	$("#ref_pangpej_ket").val("");
	$("input[name=ref_pangpej_id]").val("");
	$('#div_dialog_box').animate({
        scrollTop: $("#top").offset().top},
        'slow');
	$("input[name=id_pangkat]").val('');
};

 /**
  * Form button
  */
 var createEventToolbarPangkat = function (){ 	
 	$("#btn_pangkat_save").click(function (){ 		
 		if($("input[name=mode]").val()=='add') {
 			vURL = GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/pangkat/insert";
 		} else {
 			vURL = GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/pangkat/update";
 		}
 		
 		var options = { 
    		url : vURL,
    		type : "POST",
    		dataType: 'json',
    		beforeSubmit: jqform_validate,	// pre-submit callback 
			success: function(response) {
				$("#pangkat_table").flexReload();
				resetState();
				
				if (response.status == true)
					showNotification(response.msg);
				else
					showWarning(response.msg);
			}
		}; 
		
		$("#frm_pangkat").ajaxSubmit(options);
 	});
 	
 	$("#btn_delete_pangkat").click(function (){ 		
 		if ($("input[name=id_pangkat]").val().length > 0) {
 			showAuthentication('delete');
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk dihapus");
		}
 	});
 	
 	$("#btn_pangkat_reset, #btn_pangkat_batal").click(function() {
 		resetState();
 	});
 	
 	$("#btn_add_pangkat").click(function(){
 		$("input[name=mode]").val("add");
 		$("#ref_pangpej_ket").val("");
 		$("input[name=ref_pangpej_id]").val("");
 		$('#div_dialog_box').animate({
 	        scrollTop: $("#editor").offset().top},
 	        'slow');
 	});
 	
 	$("#btn_close_pangkat").click(function() {
 		$("#div_dialog_box").dialog('close');
 	});
 };
 
 var deleteData = function() {
	 var remove = function (){
		 var selectedItems = "";
		 
		 $(".toggle_pangkat").each( function () {
			if ($(this).is(':checked')) {
				selectedItems += $(this).val() + "|";
			}		
		});
		 
		 $.ajax({
		     type: "POST",
		     url: GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/pangkat/delete",
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#pangkat_table").flexReload();
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
	createDataGridPangkat();
	createEventToolbarPangkat();
});