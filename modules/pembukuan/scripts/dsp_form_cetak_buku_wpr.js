
var validateForm = function() {
	var result = false;
	if ($("#jepem").val() == "") {
		showWarning("Silahkan pilih jenis pemungutan");
	} else if ($("#wp_wr_id").val() == "") {
		showWarning("Silahkan pilih Nomor WP");
	} else {
		result = true;
	}
	
	return result;
}; 

var completePage = function() {
	$('#btn_npwpd').click(function() {
		showDialog("wajib_pajak/popup_npwpd?status=true", 'Nomor Pokok Wajib Pajak/Retribusi', 1000, 500);
	});
	$("#f_date_c").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	$('#f_date_c').datepicker('setDate', 'c');

	$('#wp_wr_gol').autotab({ target: 'wp_wr_no_urut', format: 'numeric' });
	$('#wp_wr_no_urut').autotab({ target: 'wp_wr_kd_camat', format: 'numeric', previous: 'wp_wr_gol' });
	$('#wp_wr_kd_camat').autotab({ target: 'wp_wr_kd_lurah', format: 'numeric', previous: 'wp_wr_no_urut' });
	$('#wp_wr_kd_lurah').autotab({ format: 'numeric', previous: 'wp_wr_kd_camat' });	
};

$(document).ready(function(){
	completePage();
	
	$("#btn_cetak").click(function() {
		if (validateForm()) {
			url = GLOBAL_CETAK_BUKU_VARS["cetak"] +
					"?tahun=" + $('#thn_pajak').val() +
					"&jenis_pemungutan=" + $('#jepem').val() +
					"&wp_id=" + $("#wp_wr_id").val() +
					"&tgl_cetak=" + $('#tgl_cetak').val();
	
			var html = '<iframe id="pdf" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
});