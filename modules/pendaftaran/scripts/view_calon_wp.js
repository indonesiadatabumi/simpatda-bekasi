/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#calon_wp_table").flexigrid({
		url: GLOBAL_CALON_WP_VARS["get_list_data"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'wp_wr_id', width : 200, sortable : true, align: 'left', hide:true},
			{display: 'No.', name : '', width : 40, align: 'center', process: cellClick},
			{display: '<input type="checkbox" name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center'},
			{display: 'No. Pendaftaran', name : 'wp_wr_no_form', width : 100, sortable : true, align: 'left', process: cellClick},
			{display: 'No. Kartu WP', name : 'wp_wr_no_kartu', width : 120, sortable : true, align: 'left', process: cellClick},
			{display: 'Nama WP', name : 'wp_wr_nama', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Alamat', name : 'wp_wr_almt', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Kelurahan', name : 'wp_wr_lurah', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Kecamatan', name : 'wp_wr_camat', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Omset', name : 'omset', width : 110, sortable : true, align: 'right', process: cellClick}
			],
		searchitems : [
			{display: 'No. Pendaftaran', name : 'wp_wr_no_form', isdefault: true},
			{display: 'Nama WP/WR', name : 'wp_wr_nama'},
			{display: 'Alamat', name : 'wp_wr_almt'},
			{display: 'Kelurahan', name : 'wp_wr_lurah'},
			{display: 'Kecamatan', name : 'wp_wr_camat'},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten'}
			],
		sortname: "wp_wr_id",
		sortorder: "desc",
		usepager: true,
		title: 'DAFTAR CALON WAJIB PAJAK',
		useRp: true,
		rp: 15,
		showTableToggleBtn: true,
		height: 260
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
	var rows = $("table#calon_wp_table").find("tr").get();
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
var editData = function(wp_id) {
	load_content(GLOBAL_CALON_WP_VARS["edit_calon_wp"], {'wp_wr_id' : wp_id});
};

 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		// load content
 		load_content(GLOBAL_CALON_WP_VARS["add_calon_wp"]);
 	});
 	
 	$("#btn_edit").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			load_content(GLOBAL_CALON_WP_VARS["edit_calon_wp"], {'wp_wr_id' : $("input[name=id]").val()});
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
		     url: GLOBAL_MAIN_VARS["BASE_URL"] + "pendaftaran/calon_wp/delete",
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#calon_wp_table").flexReload();
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