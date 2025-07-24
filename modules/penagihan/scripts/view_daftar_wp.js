/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#wp_bu_table").flexigrid({
		url: GLOBAL_VIEW_DAFTAR_WP_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'wp_wr_id', width : 200, sortable : true, align: 'left', hide:true},
			{display: 'No.', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'No. Pendaft.', name : 'no_reg', width : 60, sortable : true, align: 'left', process: cellClick},
			{display: 'NPWPD', name : 'npwprd', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Nama WP', name : 'wp_wr_nama', width : 150, sortable : true, align: 'left', process: cellClick},
			{display: 'Alamat', name : 'wp_wr_almt', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Kelurahan', name : 'wp_wr_lurah', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Kecamatan', name : 'wp_wr_camat', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Nama Pemilik', name : 'wp_wr_nama_milik', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Alamat Pemilik', name : 'wp_wr_almt_milik', width : 200, sortable : true, align: 'left', process: cellClick},
			{display: 'Kelurahan Pemilik', name : 'wp_wr_lurah_milik', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Kecamatan Pemilik', name : 'wp_wr_camat_milik', width : 110, sortable : true, align: 'left', process: cellClick},
			{display: 'Kabupaten Pemilik', name : 'wp_wr_kabupaten_milik', width : 110, sortable : true, align: 'left', process: cellClick}
			],
		searchitems : [
		    {display: 'Nama WP', name : 'wp_wr_nama'},
			{display: 'NPWP', name : 'npwprd'},			
			{display: 'Alamat', name : 'wp_wr_almt'},
			{display: 'Kelurahan', name : 'wp_wr_lurah'},
			{display: 'Kecamatan', name : 'wp_wr_camat'},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten'}
			],
		sortname: "wp_wr_id",
		sortorder: "asc",
		usepager: true,
		title: 'DAFTAR WAJIB PAJAK',
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
	// double click
	$(celDiv).dblclick(function (){
		var $row = $(celDiv).parent().parent();
		var cells = $("div", $row);
		//alert($(cells[0]).text());
		//open detail kartu data
		showDialogGet("penagihan/kartu_data_wp/get_detail", "Data Wajib Pajak", {
			wp_id : $(cells[0]).text(),
			periode : $("#spt_periode").val()
		}, 1200, 800);
	});
 };
 
$(document).ready(function(){
	//flexigrid table
	createDataGrid();
});