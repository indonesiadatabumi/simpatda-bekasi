/**
 * completePage
 * @returns
 */
var completePage = function() {
	$("#tgl_entry").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	$('#tgl_entry').datepicker('setDate', 'c');
};

$(document).ready(function() {
	completePage();
	
	$("#btn_cetak").click(function(){
		if($("#wp_wr_id").val() == "") {
			showWarning('Silahkan masukkan NPWPD');
		} else if($("#spt_periode").val() == "") {
			showWarning('Silahkan masukkan periode SPT');
		} else {
			url = GLOBAL_SPTPD_VARS["cetak"] +
					"?spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
					"&sistem_pemunggutan=" + $('#sistem_pemunggutan').val() +
					"&tgl_entry=" + $('#tgl_entry').val() +
					"&kecamatan=" + $('#kecamatan').val(); + 
					"&masa_pajak=" + $("#masa_pajak").val() +
					"&spt_periode=" + $("#spt_periode").val();
			
			var html = '<iframe id="pdf" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
});