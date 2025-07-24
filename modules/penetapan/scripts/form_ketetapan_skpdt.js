
/**
 * validateForm
 * @returns
 */
var validateForm = function() {
	var result = false;
	if ($.trim($("#tahun").val()) == "") {
		showWarning( "Anda harus mengisi kolom Tahun Pajak" );
	} else if ($("#spt_jenis_pajakretribusi").val() == "") {
		showWarning( "Anda harus mengisi kolom Jenis Obyek Pajak" );
	} else if ($("#no_kohir1").val() == "" || $("#no_kohir2").val() == "") {
		showWarning( "Anda harus mengisi Nomor Kohir" );
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
var showDialogMediaKetetapan = function(url, title, data, width, height) {
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
	$("input[name=netapajrek_tgl]").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	
	//$('input[name=netapajrek_tgl]').datepicker('setDate', 'c');
	
	$("input[name=netapajrek_tgl]").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
	
	$("#trigger_spt1").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialogMediaKetetapan(GLOBAL_KET_SKPDT_VARS["get_spt"], 'List Kohir', {'tahun' : $("#tahun").val(), 
																					'spt_jenis_pajakretribusi' : $("#spt_jenis_pajakretribusi").val(),
																					'netapajrek_tgl' : $("#netapajrek_tgl").val(),
																					'jenis_ketetapan' : $("input[name=jenis_ketetapan]").val(),
																					'mode' : 'from'}, 800, 500);
		}
	});
	
	$("#trigger_spt2").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialogMediaKetetapan(GLOBAL_KET_SKPDT_VARS["get_spt"], 'List Kohir', {'tahun' : $("#tahun").val(), 
																					'spt_jenis_pajakretribusi' : $("#spt_jenis_pajakretribusi").val(),
																					'netapajrek_tgl' : $("#netapajrek_tgl").val(),
																					'jenis_ketetapan' : $("input[name=jenis_ketetapan]").val(),
																					'mode' : 'to'}, 800, 500);
		}
	});
	
	$("#btn_cancel").click(function() {
		load_content(GLOBAL_MAIN_VARS['BASE_URL'] + "penetapan/surat_ketetapan");
	});
};

/**
 * ready function
 */
$(document).ready(function(){
	completePage();
	
	$("#btn_cetak").click(function() {
		if (validateForm()) {
			url = GLOBAL_KET_SKPDT_VARS["cetak"] +
					"?spt_periode=" + $('#tahun').val() + 
					"&spt_jenis_pajakretribusi=" + $('#spt_jenis_pajakretribusi').val() +
					"&spt_nomor1=" + $('#no_kohir1').val() +
					"&spt_nomor2=" + $('#no_kohir2').val() +
					'&netapajrek_tgl=' + $("#netapajrek_tgl").val() +
					'&spt_jenis_ketetapan=' + $("input[name=jenis_ketetapan]").val() +
					"&mengetahui=" + $('#ddl_mengetahui').val();
			
			var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
});