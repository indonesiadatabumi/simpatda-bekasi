/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#wp_nonaktif_table").flexigrid({
		url: GLOBAL_WP_NONAKTIF_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'wp_wr_id', width : 200, sortable : true, align: 'left', hide:true},
			{display: 'No.', name : '', width : 30, align: 'center', process: cellClick},
			{display: '<input type=checkbox name="toggle" value="" onclick="selectRows();" />', name : '', width : 20, align: 'center', process: cellClick},
			{display: 'Tgl. Nonaktif', name : 'tgl_nonaktif', width : 70, sortable : true, align: 'center'},
			{display: 'NPWP', name : 'npwprd', width : 110, sortable : true, align: 'center'},
			{display: 'Nama WP/WR', name : 'wp_wr_nama', width : 300, sortable : true, align: 'left'},
			{display: 'Alamat', name : 'wp_wr_almt', width : 300, sortable : true, align: 'left'},
			{display: 'Pemilik/Penanggung Jawab', name : 'wp_wr_nama_milik', width : 300, sortable : true, align: 'left'},
			{display: 'Kelurahan', name : 'wp_wr_lurah', width : 300, sortable : true, align: 'left'},
			{display: 'Kecamatan', name : 'wp_wr_camat', width : 100, sortable : true, align: 'left'},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten', width : 100, sortable : true, align: 'left'}
			],
		searchitems : [
		    {display: 'Nama WP/WR', name : 'a.wp_wr_nama', isdefault: true},
		    {display: 'NPWP', name : 'a.npwprd'},		
			{display: 'Alamat', name : 'a.wp_wr_almt'},
			{display: 'Kelurahan', name : 'a.wp_wr_lurah'},
			{display: 'Kecamatan', name : 'a.wp_wr_camat'}
			],
		sortname: "tgl_nonaktif",
		sortorder: "desc",
		usepager: true,
		title: 'DAFTAR WAJIB PAJAK NON AKTIF',
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
	var rows = $("table#wp_nonaktif_table").find("tr").get();
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

var createEventToolbar = function (){	 
	$("#btn_change").click(function (){ 		
		if ($("input[name=id]").val().length > 0) {
			showAuthentication('delete');
	   } else {
		   showWarning("Silahkan pilih data terlebih dahulu untuk dihapus");
	   }
	});
};

// ubah aktif wp

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
			url: GLOBAL_MAIN_VARS["BASE_URL"] + "pendaftaran/penonaktifan_wpwr/change_status",
			data: "mode=delete&id="+selectedItems,
			success: function(msg){
				$("#wp_nonaktif_table").flexReload();
				showNotification(msg);
			}
		});
	};
		
	$("#confirmation_status").dialog({
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