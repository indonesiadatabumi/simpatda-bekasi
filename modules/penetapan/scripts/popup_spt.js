/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#popup_spt_table").flexigrid({
		url: GLOBAL_POPUP_SPT_VARS["get_list_data"],
		dataType: 'json',
		colModel : [
		    {display: 'SPT ID', name : 'spt_id', width : 120, sortable : true, align: 'center', hide:true},
			{display: 'No.', name : '', width : 15, align: 'center'},
			{display: 'No. SPT', name : 'spt_nomor', width : 50, sortable : true, align: 'left'},
			{display: 'Periode', name : 'spt_periode', width : 50, sortable : true, align: 'center'},
			{display: 'Periode Jual', name : 'spt_periode_jual1', width : 200, sortable : true, align: 'center'},
			{display: 'Kode Rekening', name : 'koderek', width : 100, sortable : true, align: 'center'},
			{display: 'NPWPD/NPWRD', name : 'npwprd', width : 100, sortable : true, align: 'center'},
			{display: 'Nama WP', name : 'wp_wr_nama', width : 250, sortable : true, align: 'left'}
			],
		searchitems : [
			{display: 'No. SPT', name : 'spt_nomor', isdefault: true},
			{display: 'Periode SPT', name : 'spt_periode'},
			{display: 'Kode Rekening', name : 'koderek'},
			{display: 'NPWPD/NPWRD', name : 'npwprd'},
			{display: 'Nama WP', name : 'wp_wr_nama'}
			],
		sortname: "spt_id",
		sortorder: "DESC",
		usepager: true,
		title: 'DAFTAR SPT',
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
	if (GLOBAL_POPUP_SPT_VARS["mode"] == "from") {
		$('#spt_nomor1').val(spt_nomor);
	} else {
		$('#spt_nomor2').val(spt_nomor);
	}
	
	$("#div_dialog_get").dialog('close');
};

$(document).ready(function(){
	createDataGrid();
	
	$('#btn_popup_skpd_close').click(function() {
		$("#div_dialog_get").dialog('close');
	});
});