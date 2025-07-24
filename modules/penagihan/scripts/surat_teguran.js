
/**
 * validateForm
 * @returns
 */
var validateForm = function() {
	var result = false;
	if ($.trim($("#tgl_awal").val()) == "") {
		showWarning( "Anda harus mengisi tanggal awal" );
	} else if ($.trim($("#tgl_akhir").val()) == "") {
		showWarning( "Anda harus mengisi tanggal akhir" );
	}
	else if ($("#spt_jenis_pajakretribusi").val() == "") {
		showWarning( "Anda harus mengisi kolom Jenis Obyek Pajak" );
	//} else if ($("#tgl_cetak").val() == "") {
	//	showWarning( "Anda harus mengisi Tgl Cetak" );
	} else {
		result = true;
	}
	
	return result;
};

/**
 * completePage
 * @returns
 */
var completePage = function() {
	$('#btn_npwpd_teguran').click(function() {
		showDialog("wajib_pajak/popup_npwpd_teguran?status=true&jenispajak=" + $("#spt_jenis_pajakretribusi").val(), 'Nomor Pokok Wajib Pajak/Retribusi', 1000, 500,);
	});
	
	$("#tgl_cetak").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	$('#tgl_awal').datepicker('setDate', 'c');

		$("#tgl_awal").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
		$('#tgl_awal').datepicker('setDate', 'c');
		
	$('#tgl_akhir').datepicker('setDate', 'c');

		$("#tgl_akhir").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	$('#tgl_akhir').datepicker('setDate', 'c');

	
	$("#trigger_rek").click(function() {
		showDialog("rekening/popup_rekening5digit?koderek=" + $("#korek").val(), 'Kode Rekening', 800, 500);
	});
};

$(document).ready(function() {
	completePage();
	/*
	$("#btn_cetak1").click(function() {
		if (validateForm()) {
			url = GLOBAL_SURAT_TEGURAN_VARS["cetak"] +
					"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
				//	"&bulan=" + $('#masa_pajak').val() +
				//	"&tahun=" + $('#tahun').val() +
				"&tgl_awal=" + $('#tgl_awal').val() +
					"&tgl_akhir=" + $('#tgl_akhir').val() +
					'&wp_wr_kd_camat=' + $("#wp_wr_kd_camat").val() +
					'&wp_wr_id=' + $("input[name=wp_wr_id]").val() +
					"&tgl_cetak=" + $("input[name=tgl_cetak]").val() +
					"&pejabat=" + $('#ddl_mengetahui').val();

			
			var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
	
	$("#btn_cetak").click(function() {
		if (validateForm()) {
			url = GLOBAL_SURAT_TEGURAN_VARS["cetak"] +
					"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
					"&tgl_awal=" + $('#tgl_awal').val() +
					"&tgl_akhir=" + $('#tgl_akhir').val() +
					'&wp_wr_kd_camat=' + $("#wp_wr_kd_camat").val() +
					'&wp_wr_id=' + $("input[name=wp_wr_id]").val() +
					"&tgl_cetak=" + $("input[name=tgl_cetak]").val() +
					"&pejabat=" + $('#ddl_mengetahui').val();

			
			var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
	*/
	$("#btn_cetak").click(function() {		

		if (validateForm()) {
			var jenis_pajak = $('#spt_jenis_pajakretribusi').val();
			
			if(jenis_pajak==4){
				url = GLOBAL_SURAT_TEGURAN_VARS["cetak_teguran_reklame"] +
					"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
					"&tgl_awal=" + $('#tgl_awal').val() +
					"&tgl_akhir=" + $('#tgl_akhir').val() +
					"&tgl_cetak=" + $("input[name=tgl_cetak]").val() +
					// '&wp_wr_id=' + $("input[name=wp_wr_id]").val() +
					'&npwrd=' + $("input[name=npwrd]").val() +
					"&pejabat=" + $('#ddl_mengetahui').val();
			}else {
				url = GLOBAL_SURAT_TEGURAN_VARS["cetak"] +
						"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
						"&tgl_awal=" + $('#tgl_awal').val() +
						"&tgl_akhir=" + $('#tgl_akhir').val() +
						'&wp_wr_camat=' + $("#wp_wr_camat").val() +
						// '&wp_wr_id=' + $("input[name=wp_wr_id]").val() +
						'&npwrd=' + $("input[name=npwrd]").val() +
						"&tgl_cetak=" + $("input[name=tgl_cetak]").val() +
						"&pejabat=" + $('#ddl_mengetahui').val();
			}
			var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';

			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});

	$("#btn_daftar").click(function() {
		if (validateForm()) {
			url = GLOBAL_SURAT_TEGURAN_VARS["daftar"] +
					"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
				//	"&bulan=" + $('#masa_pajak').val() +
				//	"&tahun=" + $('#tahun').val() +
				"&tgl_awal=" + $('#tgl_awal').val() +
					"&tgl_akhir=" + $('#tgl_akhir').val() +
					'&wp_wr_kd_camat=' + $("#wp_wr_kd_camat").val() +
					'&wp_wr_id=' + $("input[name=wp_wr_id]").val() +
					"&tgl_cetak=" + $("input[name=tgl_cetak]").val() +
					"&mengetahui=" + $("#ddl_mengetahui").val() +
					"&diperiksa=" + $('#ddl_diperiksa').val();
			
			var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
});