/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#popup_ketetapan_table").flexigrid({
		url: GLOBAL_POPUP_KETETAPAN_VARS["get_list_data"],
		dataType: 'json',
		colModel : [
		    {display: 'ID Penetapan', name : 'netapajrek_id', width : 120, sortable : true, align: 'center', hide:true},
			{display: 'No.', name : '', width : 15, align: 'center'},
			{display: 'No. KOHIR', name : 'netapajrek_kohir', width : 50, sortable : true, align: 'left'},
			{display: 'NPWP', name : 'npwprd', width : 120, sortable : true, align: 'left'},
			{display: 'Periode', name : 'spt_periode', width : 50, sortable : true, align: 'center'},
			{display: 'Tanggal Penetapan', name : 'netapajrek_tgl', width : 100, sortable : true, align: 'center'},
			{display: 'Jatuh Tempo', name : 'netapajrek_tgl_jatuh_tempo', width : 100, sortable : true, align: 'center'},
			{display: 'Kode Rekening', name : 'koderek', width : 100, sortable : true, align: 'center'}
			],
		searchitems : [
			{display: 'No. Kohir', name : 'netapajrek_kohir', isdefault: true},
			{display: 'Periode', name : 'spt_periode'},
			{display: 'Kode Rekening', name : 'koderek'},
			{display: 'NPWPD/NPWRD', name : 'npwprd'},
			{display: 'Nama WP', name : 'wp_wr_nama'}
			],
		sortname: "netapajrek_kohir",
		sortorder: "DESC",
		usepager: true,
		title: 'DAFTAR KOHIR',
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
var isChosenSPT = function(spt_nomor) {
	if (GLOBAL_POPUP_KETETAPAN_VARS["mode"] == "from") {
		$('#no_kohir1').val(spt_nomor);
	} else {
		$('#no_kohir2').val(spt_nomor);
	}
	
	$("#div_dialog_box").dialog('close');
};

$(document).ready(function(){
	createDataGrid();
	
	$('#toolbar-popup-cancel').click(function() {
		$("#div_dialog_box").dialog('close');
	});
});