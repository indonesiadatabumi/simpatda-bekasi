/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#tbl_kode_rekening").flexigrid({
		url: GLOBAL_KODE_REKENING_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'lurah_id', width : 200, sortable : true, align: 'left', hide:true, process: cellClick},
			{display: 'No.', name : '', width : 10, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'Status Aktif', name : 'korek_status_aktif', width : 60, sortable : true, align: 'center'},
			{display: 'Tipe', name : 'korek_tipe', width : 50, sortable : true, align: 'center', process: cellClick},
			{display: 'Kelompok', name : 'korek_kelompok', width : 50, sortable : true, align: 'center', process: cellClick},
			{display: 'Jenis', name : 'korek_jenis', width : 50, sortable : true, align: 'center', process: cellClick},
			{display: 'Objek', name : 'korek_objek', width : 50, sortable : true, align: 'center', process: cellClick},
			{display: 'Rincian', name : 'jenis', width : 50, sortable : true, align: 'center', process: cellClick},
			{display: 'Sub1', name : 'klas', width : 50, sortable : true, align: 'center', process: cellClick},
			{display: 'Sub2', name : 'korek_sub2', width : 50, sortable : true, align: 'center', process: cellClick},
			{display: 'Sub3', name : 'korek_sub3', width : 50, sortable : true, align: 'center', process: cellClick},
			{display: 'Nama Rekening', name : 'korek_nama', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Kategori Rekening', name : 'ref_kakorek_ket', width : 150, sortable : true, align: 'left', process: cellClick},
			{display: '% Tarif', name : 'korek_persen_tarif', width : 50, sortable : true, align: 'right', process: cellClick},
			{display: 'Tarif Dasar', name : 'korek_tarif_dsr', width : 100, sortable : true, align: 'right', process: cellClick},
			{display: 'Volume Dasar', name : 'korek_vol_dsr', width : 100, sortable : true, align: 'right', process: cellClick},
			{display: 'Tarif Tambahan', name : 'korek_tarif_tambah', width : 100, sortable : true, align: 'left', process: cellClick},
			{display: 'Nomor Perda', name : 'dahukorek_no_perda', width : 150, sortable : true, align: 'center', process: cellClick},
			{display: 'Tanggal Perda', name : 'dahukorek_tgl_perda', width : 90, sortable : true, align: 'center', process: cellClick}
		],
		searchitems : [
			{display: 'Nama Rekening', name : 'korek_nama', isdefault: true},
			{display: 'Kode Rekening 5 digit', name : 'korek_tipe||korek_kelompok||korek_jenis||korek_objek'},
			{display: 'Kategori Rekening', name : 'ref_kakorek_ket'},
			{display: 'Nomor Perda', name : 'dahukorek_no_perda'}
		],
		sortname: "koderek,jenis,klas,korek_sub2,korek_sub3",
		sortorder: "asc",
		usepager: true,
		title: 'DAFTAR KODE REKENING',
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
 * disable status aktif
 * @param korek_id
 * @returns
 */
var disableKorek = function(korek_id) {
	$.post(GLOBAL_KODE_REKENING_VARS["status_aktif"], {
		status : 'false',
		korek_id : korek_id
	}, function(data) {
		$("#tbl_kode_rekening").flexReload();
	});
};

/**
 * enable status aktif
 * @param korek_id
 * @returns
 */
var enableKorek = function(korek_id) {
	$.post(GLOBAL_KODE_REKENING_VARS["status_aktif"], {
		status : 'true',
		korek_id : korek_id
	}, function(data) {
		$("#tbl_kode_rekening").flexReload();
	});
};

/**
 * editData
 * @param title
 * @param id
 * @returns
 */
var editData = function(id) {
	showDialogPost(GLOBAL_KODE_REKENING_VARS["edit"], "Kode Rekening", {korek_id : id}, 700, 450);
};

 /**
  * Form button
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		showDialog(GLOBAL_KODE_REKENING_VARS["add"], "Kode Rekening", 700, 450);
 	});
 	
 	$("#btn_edit").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			editData($("input[name=id]").val());
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
 	
 	$("#btn_status_anggaran").click(function() {
 		showDialog(GLOBAL_KODE_REKENING_VARS["form_status_anggaran"], 'Status Anggaran', 950, 550);
 	});
 	
 	$("#btn_cetak").click(function() {
 		url = GLOBAL_KODE_REKENING_VARS['cetak'];		
		var html = '<iframe id="pdf" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
		var w = window.open(url);
		w.document.writeln(html);
		w.document.close();
		return false;
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
		     url: GLOBAL_KODE_REKENING_VARS["delete"],
		     data: "mode=delete&id="+selectedItems,
		     success: function(msg){
	 			$("#tbl_kode_rekening").flexReload();
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