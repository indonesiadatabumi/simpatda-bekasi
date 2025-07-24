/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#wp_tutup_table").flexigrid({
		url: GLOBAL_WP_TUTUP_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 10, align: 'center'},
			{display: 'No. Pendaftaran', name : 'no_reg', width : 110, sortable : true, align: 'center'},
			{display: 'NPWP', name : 'npwprd', width : 110, sortable : true, align: 'center'},
			{display: 'No. Kartu WP/WR', name : 'wp_wr_no_kartu', width : 150, sortable : true, align: 'left'},
			{display: 'Nama WP/WR', name : 'wp_wr_nama', width : 300, sortable : true, align: 'left'},
			{display: 'Alamat', name : 'wp_wr_almt', width : 300, sortable : true, align: 'left'},
			{display: 'Kelurahan', name : 'wp_wr_lurah', width : 300, sortable : true, align: 'left'},
			{display: 'Kecamatan', name : 'wp_wr_camat', width : 100, sortable : true, align: 'left'},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten', width : 100, sortable : true, align: 'left'}
			],
		searchitems : [
			{display: 'Nama WP/WR', name : 'a.wp_wr_nama', isdefault: true},
			{display: 'NPWP', name : 'a.npwprd'},
			{display: 'No. Pendaftaran', name : 'a.no_reg'},
			{display: 'No. Kartu WP/WR', name : 'a.wp_wr_no_kartu'},			
			{display: 'Alamat', name : 'a.wp_wr_almt'},
			{display: 'Kelurahan', name : 'a.wp_wr_lurah'},
			{display: 'Kecamatan', name : 'a.wp_wr_camat'},
			{display: 'Kabupaten', name : 'a.wp_wr_kabupaten'}
			],
		sortname: "a.no_reg",
		sortorder: "desc",
		usepager: true,
		title: 'DAFTAR WAJIB PAJAK TUTUP',
		useRp: true,
		rp: 10,
		showTableToggleBtn: true,
		height: 'auto'
	});
};

$(document).ready(function(){
	createDataGrid();
});