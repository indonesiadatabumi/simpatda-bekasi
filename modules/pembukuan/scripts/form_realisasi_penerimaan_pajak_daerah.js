
$(document).ready(function(){
	$("input[name=tgl_cetak], #tgl_proses").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	
	$('input[name=tgl_cetak], #tgl_proses').datepicker('setDate', 'c');
	
	$("input[name=tgl_cetak], #tgl_proses").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
	
	//cetak click
	$("#btn_cetak").click(function(){		
		url = GLOBAL_REALISASI_PAJAK_VARS["cetak"] +
				"?tgl_proses=" + $("#tgl_proses").val() +
				"&tgl_cetak=" + $("#tgl_cetak").val() + 
				"&mengetahui=" + $("#mengetahui").val() +
				"&bendahara=" + $("#bendahara").val();
		
		$.download(url, 'filename=realisasi_pajak&format=xls');
		return false;
		/*
		var html = '<iframe id="pdf" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
		var w = window.open(url);
		w.document.writeln(html);
		w.document.close();
		
		return false;
		*/
	});
});