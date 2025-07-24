/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#pajak_hotel_table").flexigrid({
		url: GLOBAL_PAJAK_HOTEL_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'spt_id', width : 200, sortable : true, align: 'left', hide:true, process: cellClick},
			{display: 'No.', name : '', width : 30, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'Pemungutan', name : 'ref_jenput_ket', width : 100, sortable : true, align: 'center', process: cellClick},
			{display: 'Nomor', name : 'spt_nomor', width : 60, sortable : true, align: 'left'},
			{display: 'Periode', name : 'spt_periode', width : 60, sortable : true, align: 'center', process: cellClick},
			{display: 'NPWPD / NPWRD', name : 'npwprd', width : 120, sortable : true, align: 'center',process: cellClick},
			{display: 'Nama WP/WR', name : 'wp_wr_nama', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Jumlah Pajak', name : 'spt_pajak', width : 90, sortable : true, align: 'right', process: cellClick},
			{display: 'Ketetapan', name : 'ketspt_singkat', width : 60, sortable : true, align: 'left', process: cellClick},
			{display: 'Tgl Penetapan', name : 'netapajrek_tgl', width : 80, sortable : true, align: 'center', process: cellClick},
			{display: 'No. Kohir', name : 'netapajrek_kohir', width : 60, sortable : true, align: 'left', process: cellClick},
			{display: 'Jatuh Tempo', name : 'netapajrek_tgl_jatuh_tempo', width : 80, sortable : true, hide:true, align: 'center', process: cellClick},
			{display: 'Tgl. Setoran', name : 'setorpajret_tgl_bayar', width : 80, align: 'center', process: cellClick},
			{display: 'Jumlah Setoran', name : 'setorpajret_tgl_bayar', width : 90, align: 'right', process: cellClick},
			//{display: 'Tgl Diterima WP/WR', name : 'spt_tgl_terima', width : 100, sortable : true, align: 'center', process: cellClick, hide: true},
			//{display: 'Tgl Batas Kembali', name : 'spt_tgl_bts_kembali', width : 100, sortable : true, align: 'center', process: cellClick, hide: true}
			],
		searchitems : [
		    {display: 'Nomor SPT', name : 'spt_nomor', isdefault: true},
		    {display: 'Periode SPT', name : 'spt_periode'},
			{display: 'NPWPD / NPWRD', name : 'npwprd'},
			{display: 'Nama WP/WR', name : 'wp_wr_nama'},
			{display: 'Pemungutan', name : 'ref_jenput_ket'}			
			],
		sortname: "spt_id",
		sortorder: "desc",
		usepager: true,
		title: 'DAFTAR SPT HOTEL',
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
var editData = function(spt_id, spt_jenis_pajakretribusi) {
	showDialogPost(GLOBAL_PAJAK_HOTEL_VARS["edit_sptpd_hotel"], "Pajak Hotel", {
				'spt_id' : spt_id,
				'spt_jenis_pajakretribusi' : spt_jenis_pajakretribusi
			}, 1000, 480);
};

 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		// load content
 		load_content(GLOBAL_PAJAK_HOTEL_VARS["add_sptpd_hotel"]);
 	});
 	
 	$("#btn_edit").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			editData($("input[name=id]").val(), $("input[name=spt_jenis_pajakretribusi]").val());
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
		     url: GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_hotel/delete",
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#pajak_hotel_table").flexReload();
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