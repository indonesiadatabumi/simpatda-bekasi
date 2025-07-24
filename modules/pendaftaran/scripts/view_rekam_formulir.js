/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#formulir_table").flexigrid({
		url: GLOBAL_FORMULIR_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'wp_wr_id', width : 200, sortable : true, align: 'left', hide:true},
			{display: 'No.', name : '', width : 30, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 20, align: 'center', process: cellClick},
			{display: 'No. Formulir', name : 'form_nomor', width : 70, sortable : true, align: 'left', process: cellClick},
			{display: 'Nama', name : 'form_nama', width : 150, sortable : true, align: 'left', process: cellClick},
			{display: 'Alamat', name : 'form_alamat', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Kecamatan', name : 'camat_nama', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Kelurahan', name : 'lurah_nama', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Status', name : 'status', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Tgl. Kirim', name : 'form_tgl_kirim', width : 80, sortable : true, align: 'left', process: cellClick},
			{display: 'Tgl. kembali', name : 'form_tgl_kembali', width : 80, sortable : true, align: 'left', process: cellClick}
			],
		searchitems : [
			{display: 'No. Formulir', name : 'form_nomor', isdefault: true},
			{display: 'Nama', name : 'form_nama'},
			{display: 'Alamat', name : 'form_alamat'},
			{display: 'Kelurahan', name : 'lurah_nama'},
			{display: 'Kecamatan', name : 'camat_nama'},
			],
		sortname: "form_id",
		sortorder: "desc",
		usepager: true,
		title: 'DAFTAR FORMULIR PENDAFTARAN',
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
  * selectRows function
  * @returns
  */
 var selectRows = function() {
	var rows = $("table#formulir_table").find("tr").get();
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
 * @param id
 * @returns
 */
var editData = function(id) {
	load_content(GLOBAL_FORMULIR_VARS["edit"], {'id' : id});
};

 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		// load content
 		load_content(GLOBAL_FORMULIR_VARS["add"]);
 	});
 	
 	$("#btn_edit").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			load_content(GLOBAL_FORMULIR_VARS["edit"], {'id' : $("input[name=id]").val()});
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
		     url: GLOBAL_MAIN_VARS["BASE_URL"] + "pendaftaran/rekam_formulir/delete",
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#formulir_table").flexReload();
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