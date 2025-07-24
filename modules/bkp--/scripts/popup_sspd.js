/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#popup_sspd_table").flexigrid({
		url: GLOBAL_POPUP_SPT_VARS["get_list_data"],
		dataType: 'json',
		colModel : [
		    {display: 'SPT ID', name : 'spt_pen_id', width : 120, sortable : true, align: 'center', hide:true},
			{display: 'No.', name : '', width : 15, align: 'center'},
			{display: 'No. KOHIR/SPT', name : 'spt_nomor', width : 80, sortable : true, align: 'center'},
			{display: 'Periode', name : 'spt_periode', width : 40, sortable : true, align: 'center'},
			{display: 'Jatuh Tempo', name : 'tgl_jatuh_tempo', width : 80, sortable : true, align: 'center'},
			{display: 'Kode Rekening', name : 'koderek', width : 80, sortable : true, align: 'center'},
			{display: 'NPWPD', name : 'npwprd', width : 110, sortable : true, align: 'center'},
			{display: 'Nama WP', name : 'wp_wr_nama', width : 180, sortable : true, align: 'left'},
			{display: 'Ket. SPT ID', name : 'ketspt_id', width : 80, sortable : true, align: 'left', hide: 'true'},
			{display: 'Ket. SPT', name : 'ketspt_singkat', width : 80, sortable : true, align: 'center'},
			{display: 'Pajak (Rp)', name : 'spt_pajak', width: 110, align: 'right'}
			],
		searchitems : [
			{display: 'No. SPT', name : 'spt_nomor', isdefault: true},
			{display: 'Periode SPT', name : 'spt_periode'},
			{display: 'Kode Rekening', name : 'koderek'},
			{display: 'NPWPD/NPWRD', name : 'npwprd'},
			{display: 'Nama WP', name : 'wp_wr_nama'}
			],
		sortname: "spt_pen_id",
		sortorder: "DESC",
		usepager: true,
		title: 'DAFTAR KOHIR/SPT',
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
var isChosenSPT = function(spt_nomor, ket_spt, form_id) {
	$('#' + form_id).val(spt_nomor);
	$('#setorpajret_jenis_ketetapan').val(ket_spt);
	
	$("#div_dialog_box").dialog('close');
};

$(document).ready(function(){
	createDataGrid();
	
	$('#toolbar-popup-cancel').click(function() {
		$("#div_dialog_box").dialog('close');
	});
});