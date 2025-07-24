/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#popup_wp_table").flexigrid({
		url: GLOBAL_POPUP_NPWPD_VARS["get_list_data"],
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
		title: 'DAFTAR WAJIB PAJAK',
		useRp: true,
		rp: 10,
		showTableToggleBtn: true,
		height: 265
	});

	$("#popup_wp_table_teguran").flexigrid({
		url: GLOBAL_POPUP_NPWPD_VARS["get_list_data"],
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 10, align: 'center'},
			// {display: 'No. Pendaftaran', name : 'no_reg', width : 110, sortable : true, align: 'center'},
			{display: 'SPT ID', name : 'spt_id', width : 110, sortable : true, align: 'center'},
			{display: 'NPWP', name : 'npwprd', width : 110, sortable : true, align: 'center'},
			// {display: 'No. Kartu WP/WR', name : 'wp_wr_no_kartu', width : 150, sortable : true, align: 'left'},
			{display: 'Nomor SPT', name : 'spt_nomor', width : 150, sortable : true, align: 'left'},
			{display: 'Nama WP/WR', name : 'wp_wr_nama', width : 300, sortable : true, align: 'left'},
			{display: 'Alamat', name : 'wp_wr_almt', width : 300, sortable : true, align: 'left'},
			{display: 'Kelurahan', name : 'wp_wr_lurah', width : 300, sortable : true, align: 'left'},
			{display: 'Kecamatan', name : 'wp_wr_camat', width : 100, sortable : true, align: 'left'},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten', width : 100, sortable : true, align: 'left'}
			],
		searchitems : [
		    // {display: 'Nama WP/WR', name : 'a.wp_wr_nama', isdefault: true},
		    // {display: 'NPWP', name : 'a.npwprd'},
			// {display: 'No. Pendaftaran', name : 'a.no_reg'},
			// {display: 'No. Kartu WP/WR', name : 'a.wp_wr_no_kartu'},			
			// {display: 'Alamat', name : 'a.wp_wr_almt'},
			// {display: 'Kelurahan', name : 'a.wp_wr_lurah'},
			// {display: 'Kecamatan', name : 'a.wp_wr_camat'},
			// {display: 'Kabupaten', name : 'a.wp_wr_kabupaten'}
			{display: 'Nama WP/WR', name : 'wp_wr_nama', isdefault: true},
		    {display: 'NPWP', name : 'npwprd'},
			{display: 'No. SPT', name : 'spt_nomor'},			
			{display: 'Alamat', name : 'wp_wr_almt'},
			{display: 'Kelurahan', name : 'wp_wr_lurah'}
			],
		// sortname: "a.no_reg",
		// sortorder: "desc",
		usepager: true,
		title: 'DAFTAR WAJIB PAJAK',
		useRp: true,
		rp: 10,
		showTableToggleBtn: true,
		height: 265
	});

	$("#popup_wp_table_teguran_laporan").flexigrid({
		url: GLOBAL_POPUP_NPWPD_VARS["get_list_data"],
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 10, align: 'center'},
			// {display: 'No. Pendaftaran', name : 'no_reg', width : 110, sortable : true, align: 'center'},
			{display: 'SPT ID', name : 'spt_id', width : 110, sortable : true, align: 'center'},
			{display: 'NPWP', name : 'npwprd', width : 110, sortable : true, align: 'center'},
			// {display: 'No. Kartu WP/WR', name : 'wp_wr_no_kartu', width : 150, sortable : true, align: 'left'},
			{display: 'Nomor SPT', name : 'spt_nomor', width : 150, sortable : true, align: 'left'},
			{display: 'Nama WP/WR', name : 'wp_wr_nama', width : 300, sortable : true, align: 'left'},
			{display: 'Alamat', name : 'wp_wr_almt', width : 300, sortable : true, align: 'left'},
			{display: 'Kelurahan', name : 'wp_wr_lurah', width : 300, sortable : true, align: 'left'},
			{display: 'Kecamatan', name : 'wp_wr_camat', width : 100, sortable : true, align: 'left'},
			{display: 'Kabupaten', name : 'wp_wr_kabupaten', width : 100, sortable : true, align: 'left'}
			],
		searchitems : [
		    // {display: 'Nama WP/WR', name : 'a.wp_wr_nama', isdefault: true},
		    // {display: 'NPWP', name : 'a.npwprd'},
			// {display: 'No. Pendaftaran', name : 'a.no_reg'},
			// {display: 'No. Kartu WP/WR', name : 'a.wp_wr_no_kartu'},			
			// {display: 'Alamat', name : 'a.wp_wr_almt'},
			// {display: 'Kelurahan', name : 'a.wp_wr_lurah'},
			// {display: 'Kecamatan', name : 'a.wp_wr_camat'},
			// {display: 'Kabupaten', name : 'a.wp_wr_kabupaten'}
			{display: 'Nama WP/WR', name : 'wp_wr_nama', isdefault: true},
		    {display: 'NPWP', name : 'npwprd'},
			{display: 'No. SPT', name : 'spt_nomor'},			
			{display: 'Alamat', name : 'wp_wr_almt'},
			{display: 'Kelurahan', name : 'wp_wr_lurah'}
			],
		// sortname: "a.no_reg",
		// sortorder: "desc",
		usepager: true,
		title: 'DAFTAR WAJIB PAJAK',
		useRp: true,
		rp: 10,
		showTableToggleBtn: true,
		height: 265
	});
};

/**
 * is choosen datagrid
 * @returns
 */
var isChosen = function(id, npwpd, nama, alamat, kelurahan, kecamatan, kabupaten) {
	showNpwpd(id, npwpd, nama, alamat, kelurahan, kecamatan, kabupaten);
	$("#div_dialog_box").dialog('close');
};

/**
 * showNpwpd from Pop-Up menu
 * @param id
 * @param npwpd
 * @param nama
 * @param alamat
 * @param kelurahan
 * @param kecamatan
 * @param kabupaten
 * @returns
 */
var showNpwpd = function(id, npwpd, nama, alamat, kelurahan, kecamatan, kabupaten) {
	try {
		var arr_npwpd = npwpd.split(".");
		$('#wp_wr_id').val(id);
		// $('#wp_wr_id').val(npwpd);
		
		//npwpwd
		$('#wp_wr_golongan').val(arr_npwpd[1]);
		$('#wp_wr_jenis_pajak').val(arr_npwpd[2]);
		$('#wp_wr_no_registrasi').val(arr_npwpd[3]);
		$('#wp_wr_kode_camat').val(arr_npwpd[4]);
		$('#wp_wr_kode_lurah').val(arr_npwpd[5]);
		
		$('#wp_wr_nama').val(nama);
		$('#npwrd').val(npwpd);
		$('#wp_wr_almt').val(alamat);
		$('#wp_wr_lurah').val(kelurahan);
		$('#wp_wr_camat').val(kecamatan);
		$('#wp_wr_kabupaten').val(kabupaten);
	} catch (err) {
		showWarning('There was an error in this page.\n Error description : ' + err.message);
	}
};

$(document).ready(function(){
	createDataGrid();
	
	$('#btn_popup_cancel').click(function() {
		$("#div_dialog_box").dialog('close');
	});
});