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
		url = GLOBAL_MAIN_VARS["BASE_URL"] + "pembukuan/pendapatan_daerah/save_excel" +
				"?tgl_proses=" + $("#tgl_proses").val() +
				"&tgl_cetak=" + $("#tgl_cetak").val() + 
				"&mengetahui=" + $("#mengetahui").val();
		
		$.download(url, 'filename=realisasi&format=xls');
		return false;
	});
});