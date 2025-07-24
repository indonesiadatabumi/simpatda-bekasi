/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#popup_lhp_table").flexigrid({
		url: GLOBAL_POPUP_LHP_VARS["get_list_data"] + "?tahun=" + $("#tahun").val(),
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 10, align: 'center'},
			{display: 'NPWP', name : 'npwprd', width : 110, sortable : true, align: 'center'},
			{display: 'Nama WP/WR', name : 'wp_wr_nama', width : 300, sortable : true, align: 'left'},
			{display: 'Periode', name : 'lhp_periode', width : 80, sortable : true, align: 'left'},
			{display: 'Ket. ID', name : 'ketspt_id', width : 60, sortable : true, align: 'left', hide: true},
			{display: 'Ketetapan', name : 'ketspt_singkat', width : 100, sortable : true, align: 'left'}
			],
		searchitems : [
			{display: 'NPWP', name : 'npwprd'},
			{display: 'Nama WP', name : 'wp_wr_nama'},
			{display: 'Periode', name : 'lhp_periode'},
			],
		sortname: "wp_wr_nama",
		sortorder: "desc",
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
var isChosen = function(id, npwpd) {
	showNpwpd(id, npwpd);
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
var showNpwpd = function(id, npwpd) {
	try {
		var arr_npwpd = npwpd.split(".");
		$('#wp_wr_id').val(id);
		
		//npwpwd
		$('#wp_wr_golongan').val(arr_npwpd[1]);
		$('#wp_wr_jenis_pajak').val(arr_npwpd[2]);
		$('#wp_wr_no_registrasi').val(arr_npwpd[3]);
		$('#wp_wr_kode_camat').val(arr_npwpd[4]);
		$('#wp_wr_kode_lurah').val(arr_npwpd[5]);
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