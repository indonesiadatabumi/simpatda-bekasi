/**
 * onCompletePage
 * @returns
 */
var completePage = function() {	
	var dates = $("#fDate").datepicker({
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
	
	$('#fDate').datepicker('setDate', 'c');
	
	$("#fDate").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
};

//save to excel
var saveExcel = function (){	
	$.download(GLOBAL_REKAPITULASI_VARS["cetak"] + 
						"?tgl_penerimaan=" + $("input[name=fDate]").val(),
					'filename=rekapitulasi_harian&format=xls');
};

$(document).ready(function() {
	completePage();
	
	$("#btn_cetak").click(function(){
		saveExcel();
		return false;
	});
});