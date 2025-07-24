/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#flex1").flexigrid({
		url: GLOBAL_REF_KOREK_VARS["get_list"],
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 10, align: 'center'},
			{display: 'Kode Rekening', name : 'koderek', width : 110, sortable : true, align: 'center'},
			{display: 'Nama Rekening', name : 'korek_nama', width : 500, sortable : true, align: 'left'},
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
		sortorder: "asc",
		usepager: true,
		title: 'DAFTAR KODE REKENING',
		useRp: true,
		rp: 7,
		showTableToggleBtn: true,
		width: 945,
		height: 190
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

var showNpwpd = function(id, npwpd, nama, alamat, kelurahan, kecamatan, kabupaten) {
	try {
		var arr_npwpd = npwpd.split(".");
		$('#wp_wr_id').val(id);
		
		//npwpwd
		$('#wp_wr_golongan').val(arr_npwpd[1]);
		$('#wp_wr_jenis_pajak').val(arr_npwpd[2]);
		$('#wp_wr_no_registrasi').val(arr_npwpd[3]);
		$('#wp_wr_kode_camat').val(arr_npwpd[4]);
		$('#wp_wr_kode_lurah').val(arr_npwpd[5]);
		
		$('#wp_wr_nama').val(nama);
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