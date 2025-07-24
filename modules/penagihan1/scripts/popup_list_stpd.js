/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#popup_stpd_table").flexigrid({
		url: GLOBAL_MAIN_VARS["BASE_URL"] + "penagihan/stpd/get_list_data_stpd?periode="+$("#periode").val()+ 
				"&jenis_pajak=" + $("#jenis_pajak").val() + "&mode=" + $("#mode").val(),
		dataType: 'json',
		colModel : [
		    {display: 'SPT ID', name : 'spt_id', width : 120, sortable : true, align: 'center', hide:true},
			{display: 'No.', name : '', width : 15, align: 'center'},
			{display: 'No. SPT', name : 'stpd_nomor', width : 50, sortable : true, align: 'left'},
			{display: 'Periode', name : 'stpd_periode', width : 50, sortable : true, align: 'center'},
			{display: 'Nama Pajak', name : 'ref_jenparet_ket', width : 60, sortable : true, align: 'left'},
			{display: 'Kode Rekening', name : 'koderek', width : 90, sortable : true, align: 'center'},
			{display: 'NPWPD/NPWRD', name : 'npwprd', width : 110, sortable : true, align: 'center'},
			{display: 'Nama WP', name : 'wp_wr_nama', width : 250, sortable : true, align: 'left'},
			{display: 'Jumlah Setoran', name : 'stpd_pajak', width : 120, sortable : true, align: 'right'},
			],
		searchitems : [
			{display: 'No. STPD', name : 'spt_nomor', isdefault: true},
			{display: 'Nama WP', name : 'wp_wr_nama'}
			],
		sortname: "stpd_id",
		sortorder: "DESC",
		usepager: true,
		title: 'DAFTAR STPD',
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
var chosenData = function(stpd_nomor) {
	if ($("#mode").val() == "from") {
		$("#stpd_nomor1").val(stpd_nomor);
	} else {
		$("#stpd_nomor2").val(stpd_nomor);
	}
	
	$("#div_dialog_get").dialog('close');
};

$(document).ready(function(){
	createDataGrid();
	
	$('#toolbar-popup-cancel').click(function() {
		$("#div_dialog_get").dialog('close');
	});
});