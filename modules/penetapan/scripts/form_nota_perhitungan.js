
/**
 * validateForm
 * @returns
 */
var validateForm = function() {
	var result = false;
	if ($.trim($("#spt_periode").val()) == "") {
		showWarning( "Anda harus mengisi kolom Tahun Pajak" );
	} else if ($("#spt_jenis_pajakretribusi").val() == "") {
		showWarning( "Silahkan pilih objek pajak" );
	} else if ($("#spt_nomor1").val() == "" || $("#spt_nomor2").val() == "") {
		showWarning( "Anda harus mengisi Nomor SPT" );
	} else {
		result = true;
	}
	
	return result;
};

/**
 * showDialog form
 * @param url
 * @param width
 * @param height
 * @returns
 */
var showDialogNota = function(url, title, data, width, height) {
	$("body").append("<div id='div_dialog_box'></div>");
	$("#div_dialog_box").html(GLOBAL_MAIN_VARS["progress_indicator"]);
	$("#div_dialog_box").dialog({
		bgiframe: true,
		autoOpen: true,
		resizable: false,
		width: width,
		height: height,
		modal: true,
		position: 'center',
		open : function() {
            $('#div_dialog_box').dialog( "option" , "title" , title);
		}
	});
	
	if (url != '') {
		$.get(GLOBAL_MAIN_VARS["BASE_URL"] + url, data, 
			function(htm){
				$("#div_dialog_box").html(htm);
		},"html");
	}
};

/**
 * onCompletePage
 * @returns
 */
var completePage = function() {
	$("#trigger_spt1").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialogNota(GLOBAL_NOTA_VARS["get_spt"], 'List SPTPD', {'spt_periode' : $("#spt_periode").val(), 
																				'spt_jenis_pajakretribusi' : $("#spt_jenis_pajakretribusi").val(),
																				'spt_jenis_ketetapan' : $("#spt_jenis_ketetapan").val(),
																				'mode' : 'from'}, 800, 500);
		}
	});
	
	$("#trigger_spt2").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialogNota(GLOBAL_NOTA_VARS["get_spt"], 'List SPTPD', {'spt_periode' : $("#spt_periode").val(), 
																				'spt_jenis_pajakretribusi' : $("#spt_jenis_pajakretribusi").val(),
																				'spt_jenis_ketetapan' : $("#spt_jenis_ketetapan").val(),
																				'mode' : 'to'}, 800, 500);
		}
	});
};

/**
 * ready function
 */
$(document).ready(function() {
	completePage();
	
	$("#btn_cetak").click(function() {
		if (validateForm()) {
			url = GLOBAL_NOTA_VARS["cetak"] +
					"?spt_periode=" + $('#spt_periode').val() + 
					'&spt_jenis_ketetapan=' + $("#spt_jenis_ketetapan").val() +
					"&spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
					"&spt_nomor1=" + $('#spt_nomor1').val() +
					"&spt_nomor2=" + $('#spt_nomor2').val() +
					"&mengetahui=" + $('#ddl_mengetahui').val() +
					"&pemeriksa=" + $('#ddl_pemeriksa').val();
			
			var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
});