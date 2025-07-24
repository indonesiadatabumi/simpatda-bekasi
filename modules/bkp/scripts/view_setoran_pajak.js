/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#setoran_table").flexigrid({
		url: GLOBAL_VIEW_SETORAN_VARS["get_list"],
		dataType: 'json',
		colModel : [
		    {display: 'SPT ID', name : 'setorpajret_id', width : 120, sortable : true, align: 'center', hide:true},
		    {display: 'No.', name : '', width : 40, align: 'left'},
			{display: 'Periode', name : 'setorpajret_spt_periode', width : 50, sortable : true, align: 'center'},
			{display: 'No. KOHIR/SPT', name : 'setorpajret_spt_periode', width : 80, sortable : true, align: 'left'},
			{display: 'Ket. SPT', name : 'ketspt_singkat', width : 80, sortable : true, align: 'center'},
			{display: 'Tgl Setoran', name : 'setorpajret_tgl_bayar', width : 90, sortable : true, align: 'center'},
			{display: 'Nama Pajak', name : 'korek_nama', width : 110, sortable : true, align: 'left'},
			{display: 'Jumlah (Rp)', name : 'setorpajret_jlh_bayar', width : 90, sortable : true, align: 'right'},
			{display: 'NPWPD/NPWRD', name : 'npwprd', width : 110, sortable : true, align: 'left'},
			{display: 'Nama WP', name : 'wp_wr_nama', width : 250, sortable : true, align: 'left'},
			{display: 'Bayar Via', name : 'ref_viabaypajret_ket', width : 150, sortable : true, align: 'left'}
			],
		searchitems : [
			{display: 'No. KOHIR/SPT', name : 'setorpajret_no_spt', isdefault: true},
			{display: 'Periode SPT', name : 'setorpajret_spt_periode'},
			{display: 'NPWPD/NPWRD', name : 'npwprd'},
			{display: 'Nama WP', name : 'wp_wr_nama'}
			],
		sortname: "setorpajret_dibuat_tanggal",
		sortorder: "DESC",
		usepager: true,
		title: 'DAFTAR SETORAN',
		useRp: true,
		rp: 15,
		showTableToggleBtn: true,
		height: 'auto'
	});
};

$(document).ready(function(){
	createDataGrid();
	
	$('#btn_back').click(function() {
		load_content(GLOBAL_VIEW_SETORAN_VARS["back"]);
	});
});