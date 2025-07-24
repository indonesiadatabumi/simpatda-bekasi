/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#kartu_npwpd_table").flexigrid({
		url: GLOBAL_CETAK_KARTU_VARS["get_list_data"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'wp_wr_id', width : 200, sortable : true, align: 'left', hide:true, process: cellClick},
			{display: 'No.', name : '', width : 40, align: 'center', process: cellClick},
			{display: '', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'No. Pendaftaran', name : 'wp_wr_no_form', width : 95, sortable : true, align: 'center', process: cellClick},
			{display: 'NPWP', name : 'npwprd', width : 100, sortable : true, align: 'center', process: cellClick},
			{display: 'No. Kartu WP/WR', name : 'wp_wr_no_kartu', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Nama WP/WR', name : 'wp_wr_nama', width : 150, sortable : true, align: 'left', process: cellClick},

			{display: 'Alamat', name : 'wp_wr_almt', width : 150, sortable : true, align: 'left', process: cellClick},
			{display: 'Kelurahan', name : 'wp_wr_lurah', width : 85, sortable : true, align: 'left', process: cellClick},
			{display: 'Kecamatan', name : 'wp_wr_camat', width : 85, sortable : true, align: 'left', process: cellClick},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten', width : 85, sortable : true, align: 'left', process: cellClick},

			{display: 'Nama Pemilik', name : 'wp_wr_nama_milik', width : 150, sortable : true, align: 'left', process: cellClick},
			{display: 'Alamat Pemilik', name : 'wp_wr_almt_milik', width : 150, sortable : true, align: 'left', process: cellClick},
			{display: 'Kelurahan Pemilik', name : 'wp_wr_lurah_milik', width : 85, sortable : true, align: 'left', process: cellClick},
			{display: 'Kecamatan Pemilik', name : 'wp_wr_camat_milik', width : 85, sortable : true, align: 'left', process: cellClick},

			{display: 'Kabupaten Pemilik', name : 'wp_wr_kabupaten_milik', width : 85, sortable : true, align: 'center', process: cellClick},
			{display: 'Tgl Form Diterima', name : 'wp_wr_tgl_terima_form', width : 90, sortable : true, align: 'center', process: cellClick},
			{display: 'Tgl Batas Kirim', name : 'wp_wr_tgl_bts_kirim', width : 90, sortable : true, align: 'center', process: cellClick},
			{display: 'Tgl Form Kembali', name : 'wp_wr_tgl_form_kembali', width : 90, sortable : true, align: 'center', process: cellClick}
			],
		searchitems : [
			{display: 'No. Pendaftaran', name : 'wp_wr_no_form', isdefault: true},
			{display: 'NPWP', name : 'npwprd'},
			{display: 'No. Kartu WP/WR', name : 'wp_wr_no_kartu'},
			{display: 'Nama WP/WR', name : 'wp_wr_nama'},
			{display: 'Alamat', name : 'wp_wr_almt'},
			{display: 'Kelurahan', name : 'wp_wr_lurah'},
			{display: 'Kecamatan', name : 'wp_wr_camat'},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten'},
			{display: 'Nama Pemilik', name : 'wp_wr_nama_milik'},
			{display: 'Alamat Pemilik', name : 'wp_wr_almt_milik'},
			{display: 'Kelurahan Pemilik', name : 'wp_wr_lurah_milik'},
			{display: 'Kecamatan Pemilik', name : 'wp_wr_camat_milik'},
			{display: 'Kabupaten Pemilik', name : 'wp_wr_kabupaten_milik'}
			],
		sortname: "wp_wr_id",
		sortorder: "desc",
		usepager: true,
		title: 'Daftar Cetak NPWPD',
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
	$("#btn_print").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			//alert($("input[name=id]").val());
 			url = GLOBAL_CETAK_KARTU_VARS["cetak"] +
						"?wp_id=" + $("input[name=id]").val();

			var html = '<iframe id="pdf" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk dicetak");
		}
 	});
};

$(document).ready(function(){
	//flexigrid table
	createDataGrid();
	createEventToolbar();
});