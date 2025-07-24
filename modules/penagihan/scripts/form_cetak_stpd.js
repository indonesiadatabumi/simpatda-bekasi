
/**
 * validateForm
 * @returns
 */
var validateForm = function() {
	var result = false;
	if ($.trim($("#periode").val()) == "") {
		showWarning( "Anda harus mengisi periode STPD" );
	} else if ($("#jenis_pajak").val() == "") {
		showWarning( "Anda harus mengisi kolom Jenis Pajak" );
	} else if ($("#stpd_nomor1").val() == "" || $("#stpd_nomor2").val() == "") {
		showWarning( "Anda harus mengisi nomor STPD" );
	} else {
		result = true;
	}
	
	return result;
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
			showDialogGet(GLOBAL_KET_STPD_VARS["get_spt"], 'List STPD', {'periode' : $("#periode").val(), 
																					'jenis_pajak' : $("#jenis_pajak").val(),
																					'mode' : 'from'}, 800, 500);
		}
	});
	
	$("#trigger_spt2").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialogGet(GLOBAL_KET_STPD_VARS["get_spt"], 'List STPD', {'periode' : $("#periode").val(), 
																					'jenis_pajak' : $("#jenis_pajak").val(),
																					'mode' : 'to'}, 800, 500);
		}
	});
};

/**
 * ready function
 */
$(document).ready(function(){
	completePage();
	
	$("#btn_cetak").click(function() {
		if (validateForm()) {
			url = GLOBAL_KET_STPD_VARS["cetak"] +
					"?periode=" + $('#periode').val() + 
					"&jenis_pajak=" + $('#jenis_pajak').val() +
					"&stpd_nomor1=" + $('#stpd_nomor1').val() +
					"&stpd_nomor2=" + $('#stpd_nomor2').val() +
					"&mengetahui=" + $('#ddl_mengetahui').val();
			
			var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
});