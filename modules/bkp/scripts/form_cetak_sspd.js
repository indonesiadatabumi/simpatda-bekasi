
/**
 * onCompletePage
 * @returns
 */
var completePage = function() {
	$("input[name=tanggal_setor]").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	
	$("input[name=tanggal_setor]").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
	
	$("#trigger_spt1, #trigger_spt2").click(function() {
		form_id = "spt_nomor1";
		if ($(this).attr('id') == "trigger_spt2")
			form_id = "spt_nomor2";
	
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialog(GLOBAL_SETOR_PAJAK_VARS["get_spt"] + "?spt_periode=" + $("#spt_periode").val() 
					+ "&spt_jenis_pajakretribusi=" + $("#spt_jenis_pajakretribusi").val()
					+ "&form_id=" + form_id, 
							'List SPT/KOHIR', 950, 500);
		}
	});
	
	$("#btn_cancel").click(function() {
		load_content(GLOBAL_MAIN_VARS['BASE_URL'] + "bkp/rekam_pajak");
	});
};

/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$("#btn_cetak_sspd").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "0") {
			showWarning('Silahkan memilih jenis pajak');
		} else if($("#spt_nomor1").val() == "") {
			showWarning('Silahkan masukkan nomor SPT/KOHIR');
		} else {
			url = GLOBAL_SETOR_PAJAK_VARS["sspd"] +
					"?spt_periode=" + $('#spt_periode').val() +
					"&spt_nomor1=" + $('#spt_nomor1').val() +
					"&spt_nomor2=" + $('#spt_nomor2').val() +
					"&spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
					"&setorpajret_jenis_ketetapan=" + $('#setorpajret_jenis_ketetapan').val() +
					"&tanggal_setor=" + $('#tanggal_setor').val() +
					"&penyetor=" + $('#penyetor').val();
			
			var html = '<iframe id="sspd" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			
			$("input[name=cetak]").val("1");
		}
		
		return false;
	});
	
			$("#btn_billing").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "0") {
			showWarning('Silahkan memilih jenis pajak');
		} else if($("#spt_nomor1").val() == "") {
			showWarning('Silahkan masukkan nomor SPT/KOHIR');
		} else {
			url = GLOBAL_SETOR_PAJAK_VARS["bill"] +
					"?spt_periode=" + $('#spt_periode').val() +
					"&spt_nomor1=" + $('#spt_nomor1').val() +
					"&spt_nomor2=" + $('#spt_nomor2').val() +
					"&spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
					"&setorpajret_jenis_ketetapan=" + $('#setorpajret_jenis_ketetapan').val() +
					"&tanggal_setor=" + $('#tanggal_setor').val() +
					"&penyetor=" + $('#penyetor').val();
			
			var html = '<iframe id="sspd" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			
			$("input[name=cetak]").val("1");
		}
		
		return false;
	});
};

$(document).ready(function() {
	createEventToolbar();
	completePage();
});