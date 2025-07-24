/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#popup_rek_table").flexigrid({
		url: GLOBAL_POPUP_REK_VARS["get_list_data"],
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 30, align: 'center'},
			{display: 'Kode Rekening', name : 'koderek', width : 110, sortable : true, align: 'center'},
			{display: 'Nama Rekening', name : 'korek_nama', width : 350, sortable : true, align: 'left'},
			{display: 'Tarif Dasar', name : 'korek_tarif_dsr', width : 100, sortable : true, align: 'right'},
			{display: 'Persen Tarif', name : 'korek_persen_tarif', width : 100, sortable : true, align: 'right'}
		],
		searchitems : [
			{display: 'Kode Rekening', name : 'koderek', isdefault: true},
			{display: 'Nama Rekening', name : 'korek_nama'},
			{display: 'Tarif Dasar', name : 'korek_tarif_dsr'},
			{display: 'Persen Tarif', name : 'korek_persen_tarif'}
		],
		sortname: "koderek,jenis,klas",
		sortorder: "ASC",
		usepager: true,
		title: 'DAFTAR KODE REKENING',
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
var isChosen = function(id, kode_rek, rek_nama, tarif_dasar, persen_tarif) {
	showRekening(id, kode_rek, rek_nama, tarif_dasar, persen_tarif);
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
var showRekening = function(id, kode_rek, rek_nama, tarif_dasar, persen_tarif) {
	try {
		var arr_rekening = kode_rek.split(".");
		$('#spt_kode_rek').val(id);
		
		if ($("#lhp_kode_rek").length != 0) {
			$('#lhp_kode_rek').val(id);
		}	
		
		//rekening kode
		$('#korek').val(arr_rekening[0]);
		$('#korek_rincian').val(arr_rekening[1]);
		$('#korek_sub1').val(arr_rekening[2]);
		
		$('#korek_nama').val(rek_nama);
		$('#korek_persen_tarif').val(persen_tarif);
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