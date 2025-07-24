$(document).ready(function() {
	$('#btn_npwpd').click(function() {
		showDialog("wajib_pajak/get_wp_sptpd/" + $("input[name=kodus_id]").val(), 'Nomor Pokok Wajib Pajak/Retribusi', 1000, 500);
	});
	
	$("#btn_cetak").click(function(){
		if($("#wp_wr_id").val() == "") {
			showWarning('Silahkan masukkan NPWPD');
		} else if($("#spt_periode").val() == "") {
			showWarning('Silahkan masukkan periode SPT');
		} else {
			url = GLOBAL_KARTU_DATA_RESTORAN_VARS["cetak"] +
					"?spt_periode=" + $('#spt_periode').val() +
					"&wp_id=" + $('#wp_wr_id').val() +
					"&mengetahui=" + $('#ddl_mengetahui').val() +
					"&dibuat=" + $('#ddl_dibuat').val();
			
			var html = '<iframe id="pdf" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			
			$("input[name=cetak]").val("1");
			return false;
		}
	});
});