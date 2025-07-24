/**
 * onComplete Page
 * @returns
 */
var completePage = function() {
	var dates = $("#fDate, #tDate").datepicker({
   	   	dateFormat: "dd-mm-yy",
   	 	showOn: "both",
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		maxDate: '0',
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
		},
		onSelect: function( selectedDate ) {
			var option = this.id == "fDate" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
   	});
	
	$("#tgl_cetak").datepicker({
		dateFormat: "dd-mm-yy",
   	 	showOn: "both",
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		maxDate: '0',
		constrainInput: true,
		duration: "fast"
	});
	
	$('#tgl_cetak').datepicker('setDate', 'c');
	
	$("input[name=btn_cetak]").click(function() {
		url = GLOBAL_WP_TUTUP_VARS["cetak"] +
				"?fDate=" + $('#fDate').val() + 
				"&tDate=" + $('#tDate').val() +
				"&bidus=" + $('#bidus').val() +
				"&camat=" + $('#wp_wr_kd_camat').val() +
				"&mengetahui=" + $('#ddl_mengetahui').val() +
				"&pemeriksa=" + $('#ddl_pemeriksa').val() +
				"&tgl_cetak=" + $('#tgl_cetak').val();
		
		var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
		
		var w = window.open(url);
		w.document.writeln(html);
		w.document.close();
		return false;
	});
};

$(document).ready(function() {
	completePage();
});