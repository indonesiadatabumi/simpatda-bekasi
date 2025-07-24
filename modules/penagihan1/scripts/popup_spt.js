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
			{display: 'Masa Pajak', name : 'spt_periode_jual1', width : 160, sortable : true, align: 'center'},
			{display: 'Tgl. Bayar', name : 'setorpajret_tgl_bayar', width : 60, sortable : true, align: 'left'},
			{display: 'Bulan Pengenaan', name : '', width : 90, sortable : true, align: 'center'},
			{display: 'Jumlah Setoran', name : 'setorpajret_jlh_bayar', width : 120, sortable : true, align: 'right'},
			{display: 'NPWPD/NPWRD', name : 'npwprd', width : 110, sortable : true, align: 'center'},
			{display: 'Nama WP', name : 'wp_wr_nama', width : 250, sortable : true, align: 'left'}
			],
		searchitems : [
			{display: 'No. SPT', name : 'spt_nomor', isdefault: true},
			{display: 'Periode SPT', name : 'spt_periode'},
			{display: 'Kode Rekening', name : 'koderek'},
			{display: 'NPWPD/NPWRD', name : 'npwprd'},
			{display: 'Nama WP', name : 'wp_wr_nama'}
			],
		sortname: "setorpajret_id",
		sortorder: "DESC",
		usepager: true,
		title: 'DAFTAR SETORAN',
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
var chosenSPT = function(spt_nomor, setorpajret_id) {
	$('#spt_nomor').val(spt_nomor);
	$("#div_dialog_stpd").dialog('close');
	
	$.post(GLOBAL_MAIN_VARS['BASE_URL'] + "penagihan/stpd/get_detail_setoran", {setorpajret_id : setorpajret_id},
		function(data) {
		  $("input[name=setorpajret_id]").val(data.setorpajret_id);
		  $("#wp_wr_id").val(data.setorpajret_id_wp);
		  $("#wp_wr_kode_pajak").val(data.wp_wr_jenis);
		  $("#wp_wr_golongan").val(data.wp_wr_gol);
		  $("#wp_wr_jenis_pajak").val(data.ref_kodus_kode);
		  $("#wp_wr_no_registrasi").val(data.wp_wr_no_urut);
		  $("#wp_wr_kode_camat").val(data.camat_kode);
		  $("#wp_wr_kode_lurah").val(data.lurah_kode);
		  $("#wp_wr_nama").val(data.wp_wr_nama);
		  $("#wp_wr_almt").val(data.wp_wr_almt);
		  $("#setorpajret_periode_jual1").val(data.setorpajret_periode_jual1);
		  $("#setorpajret_periode_jual2").val(data.setorpajret_periode_jual2);
		  $("#setorpajret_jatuh_tempo").val(data.setorpajret_jatuh_tempo);
		  $("#setorpajret_tgl_bayar").val(data.setorpajret_tgl_bayar);
		  $("#setorpajret_jlh_bayar").val(data.setorpajret_jlh_bayar);
		  $("#bulan_pengenaan").val(data.bulan_pengenaan);
		  $("#spt_pajak").val(data.pajak);
	}, "json");
};

$(document).ready(function(){
	createDataGrid();
	
	$('#btn_popup_close_stpd').click(function() {
		$("#div_dialog_stpd").dialog('close');
	});
});