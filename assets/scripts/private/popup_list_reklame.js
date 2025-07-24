/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#popup_list_reklame_table").flexigrid({
		url: GLOBAL_POPUP_NPWPD_VARS["get_list_data"],
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 10, align: 'center'},
			{display: 'No. Pelayanan', name : 'no_pelayanan', width : 30, sortable : true, align: 'center'},
			{display: 'Periode', name : 'periode_spt', width : 50, sortable : true, align: 'left'},
			{display: 'Nama WP/WR', name : 'nama_wp', width : 200, sortable : true, align: 'left'},
			{display: 'Alamat', name : 'wp_wr_almt', width : 300, sortable : true, align: 'left'},
			{display: 'Kelurahan', name : 'kelurahan', width : 200, sortable : true, align: 'left'},
			{display: 'Kecamatan', name : 'kecamatan', width : 200, sortable : true, align: 'left'},
			{display: 'Kabupaten', name : 'kabupaten', width : 200, sortable : true, align: 'left'}
			],
		searchitems : [
		    {display: 'Nama WP/WR', name : 'a.nama_wp', isdefault: true},
			{display: 'No. Pelayanan', name : 'a.no_pelayanan'},			
			{display: 'Alamat', name : 'a.wp_wr_almt'},
			{display: 'Kelurahan', name : 'a.kelurahan'},
			{display: 'Kecamatan', name : 'a.kecamatan'},
			{display: 'Kabupaten', name : 'a.kabupaten'}
			],
		sortname: "a.no_pelayanan",
		sortorder: "desc",
		usepager: true,
		title: 'DAFTAR DATA REKLAME',
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
var isChosen = function(no_pelayanan, periode_spt, nama_wp, alamat_wp, jenis_reklame, naskah_reklame, lokasi_pasang, area, kelurahan, kecamatan, kelas_jalan, luas, jumlah, jangka_waktu) {
	showNpwpd(no_pelayanan, periode_spt, nama_wp, alamat_wp, jenis_reklame, naskah_reklame, lokasi_pasang, area, kelurahan, kecamatan, kelas_jalan, luas, jumlah, jangka_waktu);
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
 * @param no_pelayanan
 * @returns
 */
var showNpwpd = function(no_pelayanan, periode_spt, nama_wp, alamat_wp, jenis_reklame, naskah_reklame, lokasi_pasang, area, kelurahan, kecamatan, kelas_jalan, luas, jumlah, jangka_waktu) {
	try {
		
		$('#no_pelayanan').val(no_pelayanan);
		$('#spt_periode').val(periode_spt);
		$('#wp_wr_nama').val(nama_wp);
		$('#wp_wr_almt').val(alamat_wp);
		switch (jenis_reklame) {
			case 'bilboard':
				$('#spt_dt_korek1 option[value="26,25,0"]').prop('selected', true);
				$('#spt_dt_korek1').change(load_ads_assess_panel(1));
				break;
		
			default:
				alert('jenis reklame tidak ditemukan')
				break;
		}
		$('#txt_judul1').val(naskah_reklame);
		$('#txt_lokasi_pasang1').val(lokasi_pasang);
		if (area == 'outdor') {
			$('#area1_1').prop('checked', true);
			$('#area1_1').change(execute_area_function('1'));
		}else{
			$('#area1_2').prop('checked', true);
			$('#area1_2').change(execute_area_function('1'));
		}

		switch (kecamatan) {
			case 'bekasi timur':
				$('#txt_kode_camat option[value="39"]').prop('selected', true);
				break;

			case 'bekasi selatan':
					$('#txt_kode_camat option[value="36"]').prop('selected', true);
					break;
		
			default:
				alert('kecamatan tidak ditemukan')
				break;
		}
		
		switch (kelurahan) {
			case 'kayu ringin':
				$('#txt_kode_lurah').prepend('<option value="68">KAYURINGIN JAYA</option>');
				$('#txt_kode_lurah option[value="68"]').prop('selected', true);
				break;

			case 'margarahayu':
				$('#txt_kode_lurah').prepend('<option value="86">MARGAHAYU</option>');
				$('#txt_kode_lurah option[value="86"]').prop('selected', true);
				break;
		
			default:
				alert('kelurahan tidak ditemukan')
				break;
		}

		switch (kelas_jalan) {
			case '1':
				$('#kelas_jalan1').prepend('<option value="04">Kelas Jalan I</option>');
				$('#kelas_jalan1').change(getNilaiKelasJalan('1'));
				break;
		
			default:
				break;
		}
		$('#txt_luas1').val(luas);
		$('#txt_luas1').change(calcNSR('1'));
		$('#txt_jumlah1').val(jumlah);
		$('#txt_jumlah1').change(calcNSR('1'));
		$('#txt_jangka_waktu1').val(jangka_waktu);
		$('#txt_jangka_waktu1').change(calcNSR('1'));
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