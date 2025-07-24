/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#hasil_pemeriksaan_table").flexigrid({
		url: GLOBAL_LHP_VARS["get_list"],
		dataType: 'json',
		colModel : [
		    {display: 'Id', name : 'lhp_id', width : 20, align: 'center', process: cellClick, hide: true},
			{display: 'No.', name : '', width : 20, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'Nomor Periksa', name : 'lhp_no_periksa', width : 100, sortable : true, align: 'left', process: cellClick},
			{display: 'Tgl. Entry', name : 'lhp_tgl', width : 100, sortable : true, align: 'center', process: cellClick},
			{display: 'Tgl. Pemeriksaan', name : 'lhp_tgl_periksa', width : 100, sortable : true, align: 'center',process: cellClick},
			{display: 'Ketetapan', name : 'ketspt_singkat', width : 90, sortable : true, align: 'center',process: cellClick},
			{display: 'NPWPD / NPWRD', name : 'npwprd', width : 110, sortable : true, align: 'center', process: cellClick},
			{display: 'Nama WP/WR', name : 'wp_wr_nama', width : 250, sortable : true, align: 'left', process: cellClick},
			{display: 'Kode Rekening', name : 'koderek', width : 100, sortable : true, align: 'center', process: cellClick},
			{display: 'Nama Rekening', name : 'korek_nama', width : 250, sortable : true, align: 'left', process: cellClick}
			],
		searchitems : [
			{display: 'Nomor Periksa', name : 'lhp_no_periksa', isdefault: true},
			{display: 'NPWPD / NPWRD', name : 'npwprd'},
			{display: 'Nama WP/WR', name : 'wp_wr_nama'},
			{display: 'Kode Rekening', name : 'koderek'},
			{display: 'Nama Rekening', name : 'korek_nama'}
			],
		sortname: "lhp_id",
		sortorder: "desc",
		usepager: true,
		title: 'DAFTAR HASIL PEMERIKSAAN',
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
var editData = function(lhp_id) {
	load_content(GLOBAL_LHP_VARS["edit"], {'lhp_id' : lhp_id });
};

 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		// load content
 		load_content(GLOBAL_LHP_VARS["add"]);
 	});
 	
 	$("#btn_edit").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			load_content(GLOBAL_LHP_VARS["edit"], {
													'lhp_id' : $("input[name=id]").val()
												}
 						);
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
		     url: GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/hasil_pemeriksaan/delete",
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#hasil_pemeriksaan_table").flexReload();
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