/**
 * completePage
 * @returns
 */
var completePage = function () {
	$("#tgl_pendataan_awal, #tgl_pendataan_akhir, #tgl_cetak").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: GLOBAL_MAIN_VARS["BASE_URL"] + "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	// $('#tgl_pendataan, #tgl_cetak').datepicker('setDate', 'c');
	$('#tgl_pendataan_awal, #tgl_pendataan_akhir, #tgl_cetak').datepicker('setDate', 'c');

	$("#trigger_rek").click(function () {
		showDialog("rekening/popup_rekening5digit?koderek=" + $("#korek").val(), 'Kode Rekening', 800, 500);
	});
};

$(document).ready(function () {
	completePage();

	$("#btn_cetak").click(function () {
		if ($("#spt_periode").val() == "") {
			showWarning('Silahkan masukkan periode SPT');
		} else {
			daftar = $("input[name=daftar]:checked").val() == '1' ? '1' : '0';
			tandatangan = $("input[name=tandatangan]:checked").val() == '1' ? '1' : '0';

			url = GLOBAL_KARTU_DATA_VARS["cetak_daftar"] +
				"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
				"&spt_periode=" + $("#spt_periode").val() +
				"&tgl_pendataan_awal=" + $("#tgl_pendataan_awal").val() +
				"&tgl_pendataan_akhir=" + $("#tgl_pendataan_akhir").val() +
				"&daftar=" + $("#daftar").val() +
				"&tgl_cetak=" + $('#tgl_cetak').val() +
				"&tandatangan=" + tandatangan +
				"&mengetahui=" + $("#ddl_mengetahui").val() +
				"&diperiksa=" + $("#ddl_pemeriksa").val();

			var html = '<iframe id="pdf" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
});