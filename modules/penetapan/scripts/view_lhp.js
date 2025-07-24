/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#lhp_table").flexigrid({
		url: GLOBAL_PENETAPAN_LHP_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 10, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'Kohir', name : 'netapajrek_kohir', width : 30, sortable : true, align: 'left', process: cellClick},
			{display: 'Periode', name : 'spt_periode', width : 50, sortable : true, align: 'center', process: cellClick},
			{display: 'Tgl. Penetapan', name : 'netapajrek_tgl', width : 80, sortable : true, align: 'center', process: cellClick},
			{display: 'Jatuh Tempo', name : 'netapajrek_tgl_jatuh_tempo', width : 75, sortable : true, align: 'center', process: cellClick},
			{display: 'NPWPD / NPWRD', name : 'npwprd', width : 120, sortable : true, align: 'center', process: cellClick},
			{display: 'Nama', name : 'wp_wr_nama', width : 220, sortable : true, align: 'left', process: cellClick},
			{display: 'Jenis Penetapan', name : 'ketspt_singkat', width : 120, sortable : true, align: 'left', process: cellClick},
			],
		searchitems : [
			{display: 'Periode SPT', name : 'lhp_periode', isdefault: true},
			{display: 'Nomor Kohir', name : 'netapajrek_kohir'},
			{display: 'Jenis Penetapan', name : 'ketspt_singkat'},
			{display: 'NPWPD / NPWRD', name : 'npwprd'},
			{display: 'Nama', name : 'wp_wr_nama'}
			],
		sortname: "netapajrek_tgl",
		sortorder: "DESC",
		usepager: true,
		title: 'DAFTAR PENETAPAN LHP',
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
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		// load content
 		load_content(GLOBAL_PENETAPAN_LHP_VARS["add"]);
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
		     url: GLOBAL_PENETAPAN_LHP_VARS["delete"],
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#lhp_table").flexReload();
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