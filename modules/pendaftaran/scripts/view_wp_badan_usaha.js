/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#wp_bu_table").flexigrid({
		url: GLOBAL_WP_BU_VARS["get_list_data"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'wp_wr_id', width : 200, sortable : true, align: 'left', hide:true},
			{display: 'No.', name : '', width : 30, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 20, align: 'center', process: cellClick},
			{display: 'No. Pendaft.', name : 'no_reg', width : 60, sortable : true, align: 'left', process: cellClick},
			{display: 'NPWPD', name : 'npwprd', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'No. Kartu WP', name : 'wp_wr_no_kartu', width : 100, sortable : true, align: 'left', process: cellClick},
			{display: 'Nama WP', name : 'wp_wr_nama', width : 150, sortable : true, align: 'left', process: cellClick},
			{display: 'Alamat', name : 'wp_wr_almt', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Kelurahan', name : 'wp_wr_lurah', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Kecamatan', name : 'wp_wr_camat', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Nama Pemilik', name : 'wp_wr_nama_milik', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Alamat Pemilik', name : 'wp_wr_almt_milik', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Kelurahan Pemilik', name : 'wp_wr_lurah_milik', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Kecamatan Pemilik', name : 'wp_wr_camat_milik', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Kabupaten Pemilik', name : 'wp_wr_kabupaten_milik', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Tgl Form Diterima', name : 'wp_wr_tgl_terima_form', width : 100, sortable : true, align: 'center', process: cellClick},
			{display: 'Tgl Batas Kirim', name : 'wp_wr_tgl_bts_kirim', width : 100, sortable : true, align: 'center', process: cellClick},
			{display: 'Tgl Form Kembali', name : 'wp_wr_tgl_form_kembali', width : 100, sortable : true, align: 'center', hide: true, process: cellClick}
			],
		searchitems : [
			{display: 'No. Pendaftaran', name : 'wp_wr_no_form', isdefault: true},
			{display: 'NPWP', name : 'npwprd'},
			{display: 'Nama WP', name : 'wp_wr_nama'},
			{display: 'Alamat', name : 'wp_wr_almt'},
			{display: 'Kelurahan', name : 'wp_wr_lurah'},
			{display: 'Kecamatan', name : 'wp_wr_camat'},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten'},
			{display: 'Tgl Form Diterima', name : 'npwprd'},
			{display: 'Tgl Batas Kirim', name : 'wp_wr_nama'},
			{display: 'Tgl Form Kembali', name : 'wp_wr_almt'}
			],
		sortname: "wp_wr_id",
		sortorder: "desc",
		usepager: true,
		title: 'DAFTAR WAJIB PAJAK',
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
	var rows = $("table#wp_bu_table").find("tr").get();
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
	load_content(GLOBAL_WP_BU_VARS["edit_wp_bu"], {'wp_wr_id' : wp_id});
};

 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		// load content
 		load_content(GLOBAL_WP_BU_VARS["add_wp_bu"]);
 	});
 	
 	$("#btn_edit").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			load_content(GLOBAL_WP_BU_VARS["edit_wp_bu"], {'wp_wr_id' : $("input[name=id]").val()});
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
		     url: GLOBAL_MAIN_VARS["BASE_URL"] + "pendaftaran/wp_badan_usaha/delete",
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#wp_bu_table").flexReload();
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