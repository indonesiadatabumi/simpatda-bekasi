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
	
	$("#trigger_rek").click(function() {
		showDialog("rekening/popup_rekening5digit?koderek=" + $("#korek").val(), 'Kode Rekening', 800, 500);
	});
};

$(document).ready(function() {
	completePage();
	
	
	$("#btn_bpps").click(function(){
		url = GLOBAL_BPPS_VARS["cetak_bpps"] +
				"?fDate=" + $('#fDate').val() +
				"&tDate=" + $('#tDate').val() +
				"&koderek=" + $('#korek').val() +
				"&via_bayar=" + $('#via').val();
		
		var html = '<iframe id="sspd" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
		var w = window.open(url);
		w.document.writeln(html);
		w.document.close();
		return false;
	});
	
	
	$("#btn_reset").click(function() {
		$("#spt_kode_rek").val("");
		$("#korek").val("");
		$("#korek_nama").val("");
		$("#via").val("");
	});
});