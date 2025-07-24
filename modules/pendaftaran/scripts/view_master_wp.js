/**
 * Create main data grid
 */
var createDataGrid = function (){
	$("#master_wp_table").flexigrid({
		url: GLOBAL_MAIN_VARS["BASE_URL"] + "pendaftaran/master_wp/get_list/?kodus_id=" + $("input[name=kodus_id]").val(),
		dataType: 'json',
		colModel : [
			{display: 'ID', name : 'wp_wr_id', width : 200, sortable : true, align: 'left', hide:true},
			{display: 'No.', name : '', width : 30, align: 'center', process: cellClick},
			{display: 'No. Pendaft.', name : 'no_reg', width : 60, sortable : true, align: 'left', process: cellClick},
			{display: 'NPWPD', name : 'npwprd', width : 110, sortable : true, align: 'left', process: cellClick},
			//{display: 'No. Kartu WP', name : 'wp_wr_no_kartu', width : 100, sortable : true, align: 'left', process: cellClick},
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
		    {display: 'Nama WP', name : 'wp_wr_nama', isdefault: true},			
			{display: 'NPWP', name : 'npwprd'},	
			{display: 'No. Pendaftaran', name : 'wp_wr_no_form'},
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
		rp: 15,
		showTableToggleBtn: true,
		height: 'auto'
	});
};


var cellClick = function() {
};
 
$(document).ready(function(){
	//flexigrid table
	createDataGrid();
});