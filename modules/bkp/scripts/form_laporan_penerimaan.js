
/**
 * validateForm
 * @returns
 */
var validateForm = function() {
	var result = false;
	if ($.trim($("#fDate").val()) == "" && $.trim($("#tDate").val()) == "") {
		showWarning( "Anda harus mengisi tanggal penerimaan" );
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
	
	$("#tgl_cetak").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	
	$('#fDate, #tDate, #tgl_cetak').datepicker('setDate', 'c');
	
	$("#fDate, #tDate").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
};

/**
 * ready function
 */
$(document).ready(function(){
	completePage();
	
	$("#btn_cetak").click(function() {
		if (validateForm()) {
			tandatangan = $("input[name=tandatangan]:checked").val() == '1' ? '1' : '0';
			
			url = GLOBAL_MAIN_VARS["BASE_URL"] + "bkp/laporan_penerimaan/cetak_laporan" +
					"?fDate=" + $('#fDate').val() + 
					"&tDate=" + $("#tDate").val() +
					"&jenis_pajak=" + $('#jenis_pajak').val() +
					"&camat_id=" + $('#camat_id').val() +
					"&tgl_cetak=" + $("#tgl_cetak").val() +
					"&tandatangan=" + tandatangan +
					"&mengetahui=" + $("#ddl_mengetahui").val() +
					"&bendahara=" + $("#ddl_bendahara").val();
			
			var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
			
			var w = window.open(url);
			w.document.writeln(html);
			w.document.close();
			return false;
		}
	});
	
	
	$("#btn_reset").click(function() {
		$("#camat_id").val('');
		$("#jenis_pajak").val('');
		$("#ddl_mengetahui").val('');
		$("#ddl_mengetahui").val('0');
		$("#ddl_bendahara").val('0');
	});
});