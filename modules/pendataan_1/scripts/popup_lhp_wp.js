/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#popup_lhp_wp_table").flexigrid({
		url: GLOBAL_POPUP_LHP_VARS["get_list_data"],
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 10, align: 'center'},
			{display: 'No. Bukti', name : 'setorpajret_no_bukti', width : 100, sortable : true, align: 'left'},
			{display: 'Tahun', name : 'sprsd_thn', width : 100, sortable : true, align: 'center'},
			{display: 'Tanggal Setor', name : 'setorpajret_tgl_bayar', width : 100, sortable : true, align: 'center'},
			{display: 'Periode Jual', name : 'sprsd_periode_jual1', width : 200, sortable : true, align: 'center'},
			{display: 'Nilai Setor(Rp.)', name : 'setorpajret_jlh_bayar', width : 250, sortable : true, align: 'right'},
			{display: 'Via', name : 'ref_viabaypajret_ket', width : 250, sortable : true, align: 'left'},
			],
		searchitems : [
			{display: 'No. Bukti', name : 'setorpajret_no_bukti', isdefault: true},
				{display: 'Tahun', name : 'sprsd_thn'},
				{display: 'Via', name : 'ref_viabaypajret_ket'}
			],
		sortname: "sprsd_id",
		sortorder: "asc",
		usepager: true,
		title: 'DAFTAR SETORAN',
		useRp: true,
		rp: 7,
		showTableToggleBtn: true,
		height: 190
	});
};

/**
 * is choosen datagrid
 * @returns
 */
var isChosen = function(row_id, setorpajret_id, sprsd_thn, ref_viabaypajret_ket, sprsd_periode_jual1, sprsd_periode_jual2, setorpajret_jlh_bayar) {
	showSetoran(row_id, setorpajret_id, sprsd_thn, ref_viabaypajret_ket, sprsd_periode_jual1, sprsd_periode_jual2, setorpajret_jlh_bayar);
	$("#div_dialog_box").dialog('close');
};

/**
 * showSetoran
 * @param row_id
 * @param setorpajret_id
 * @param sprsd_thn
 * @param ref_viabaypajret_ket
 * @param sprsd_periode_jual1
 * @param sprsd_periode_jual2
 * @param setorpajret_jlh_bayar
 * @returns
 */
var showSetoran = function(row_id, setorpajret_id, sprsd_thn, ref_viabaypajret_ket, sprsd_periode_jual1, sprsd_periode_jual2, setorpajret_jlh_bayar) {
	try {
		$('#lhp_dt_periode1' + row_id).val(sprsd_periode_jual1);
		$('#lhp_dt_periode2' + row_id).val(sprsd_periode_jual2);
		$('#lhp_dt_setoran' + row_id).val(setorpajret_jlh_bayar);
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