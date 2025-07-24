
var validateForm = function() {
	var result = false;
	if ($("#thn_pajak").val() == "") {
		showWarning("Silahkan masukkan tahun pajak.");
	}
	else if ($("#jepem").val() == "") {
		showWarning("Silahkan pilih jenis pemungutan.");
	} else if ($("#wp_wr_id").val() == "") {
		showWarning("Silahkan pilih Nomor WP.");
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
	var dates = $("#fDate, #tDate").datepicker({
   	   	dateFormat: "dd-mm-yy",
   	 	showOn: "both",
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		constrainInput: true,
		duration: "fast",
		beforeShow: function(){
			$("#ui-datepicker-div").css("zIndex", 99999);
			
			if ( $.browser.msie && $.browser.version == "6.0") {
				setTimeout(function() {
					$('#ui-datepicker-div').css('position', "absolute");
					$('#ui-datepicker-div').bgiframe();
				}, 10);
			}
		}
   	});
	
	$('#fDate, #tDate').datepicker('setDate', 'c');
	
	$("#fDate, #tDate").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
};

$(document).ready(function(){
	$("#accordion").accordion();
	
	completePage();
	
	$("#btn_setoran_cetak").click(function() {
		url = GLOBAL_MAIN_VARS["BASE_URL"] + "pembukuan/daftar_setoran/cetak?fDate=" + $('#fDate').val() +
				"&tDate=" + $('#tDate').val() +
				"&jenis_pajak=" + $("#jenis_pajak").val() +
				"&type=1";

		var html = '<iframe id="pdf" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
		var w = window.open(url);
		w.document.writeln(html);
		w.document.close();
		return false;
	});
	
	
	$("#btn_ketetapan_cetak").click(function() {
		url = GLOBAL_MAIN_VARS["BASE_URL"] + "pembukuan/daftar_setoran/cetak?bulan_ketetapan=" + $('#bulan_ketetapan').val() +
				"&tahun_ketetapan=" + $('#tahun_ketetapan').val() +
				"&jenis_pajak=" + $("#jenis_pajak").val() +
				"&jenis_daftar=" + $("#jenis_daftar").val() +
				"&type=2";
		
		var html = '<iframe id="pdf" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
		var w = window.open(url);
		w.document.writeln(html);
		w.document.close();
		return false;
	});
});