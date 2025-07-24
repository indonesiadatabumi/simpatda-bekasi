/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#setoran_table").flexigrid({
		url: GLOBAL_VIEW_SETORAN_DINAS_VARS["get_list"],
		dataType: 'json',
		colModel : [
		    {display: 'SLH ID', name : 'slh_id', width : 120, sortable : true, align: 'center', hide:true},
		    {display: '', name : '', width : 20, sortable : true, align: 'center', process: cellClick},
		    {display: 'No.', name : '', width : 40, align: 'left', process: cellClick},
			{display: 'Periode', name : 'slh_tahun', width : 50, sortable : true, align: 'center', process: cellClick},
			{display: 'Tgl. STS', name : 'slh_tgl', width : 80, sortable : true, align: 'center', process: cellClick},
			{display: 'Dinas', name : 'skpd_nama', width : 210, sortable : true, align: 'Left', process: cellClick},
			{display: 'Dari', name : 'slh_dari', width : 220, sortable : true, align: 'Left', process: cellClick},
			{display: 'Keterangan', name : 'slh_keterangan', width : 250, sortable : true, align: 'left', process: cellClick},
			{display: 'Jumlah', name : 'slh_jumlah', width : 120, sortable : true, align: 'right', process: cellClick}
			],
		searchitems : [
			{display: 'No. Bukti', name : 'setorpajret_no_bukti', isdefault: true},
			{display: 'Periode SPT', name : 'spt_periode'},
			{display: 'NPWPD/NPWRD', name : 'npwprd'},
			{display: 'Nama WP', name : 'wp_wr_nama'}
			],
		sortname: "slh_id",
		sortorder: "DESC",
		usepager: true,
		title: 'DAFTAR SETORAN DINAS LAIN',
		useRp: true,
		rp: 15,
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
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {	
	//button view list
	$("#btn_add").click(function() {
		//load content panel
		load_content(GLOBAL_VIEW_SETORAN_DINAS_VARS["add"]);
	});
	
	$("#btn_delete").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			showAuthentication('delete');
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk dihapus");
		}
 	});
	
	$("#btn_edit").click(function() {
		if ($("input[name=id]").val().length > 0) {
			load_content(GLOBAL_VIEW_SETORAN_DINAS_VARS["edit"], {
								'id' : $("input[name=id]").val()
							}
			);
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk diedit");
		}
	});
};


/**
 * deleteData
 * @returns
 */
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
		     dataType: "json",
		     url: GLOBAL_VIEW_SETORAN_DINAS_VARS["delete"],
		     data: "mode=delete&id="+selectedItems,
		     success: function(data){
	 			if (data.status == true) {
	 				$("#setoran_table").flexReload();
		 			showNotification(data.msg);
				} else {
					showWarning(data.msg);
				}
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
	createDataGrid();
	createEventToolbar();
});