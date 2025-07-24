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
	
	$("input[name=format_cetak]").click(function() {
		url = GLOBAL_MAIN_VARS["BASE_URL"] + "pendaftaran/dokumentasi_pengolahan/export_daftar_induk_baru/" +
				"?wp_wr_jenis=" + $('#wp_wr_jenis').val() +
				"&wp_wr_golongan=" + $('#wp_wr_golongan').val() +
				"&bidus=" + $('#bidus').val() +
				"&camat=" + $('#wp_wr_kd_camat').val() +
				"&lurah=" + $('#wp_wr_kd_lurah').val() +
				"&fDate=" + $('#fDate').val() + 
				"&tDate=" + $('#tDate').val() +
				"&wp_wr_status_aktif=" + $("#wp_wr_status_aktif").val() +
				"&mengetahui=" + $('#ddl_mengetahui').val() +
				"&pemeriksa=" + $('#ddl_pemeriksa').val() +
				"&linespace=" + $('#linespace').val() +
				"&tgl_cetak=" + $('#tgl_cetak').val();
		
		var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
		
		var w = window.open(url);
		w.document.writeln(html);
		w.document.close();
		return false;
	});
	
	
	$("input[name=format_cetak_xls]").click(function() {
		url = GLOBAL_MAIN_VARS["BASE_URL"] + "pendaftaran/dokumentasi_pengolahan/export_daftar_induk_xls/" +
				"?wp_wr_jenis=" + $('#wp_wr_jenis').val() +
				"&wp_wr_golongan=" + $('#wp_wr_golongan').val() +
				"&bidus=" + $('#bidus').val() +
				"&camat=" + $('#wp_wr_kd_camat').val() +
				"&lurah=" + $('#wp_wr_kd_lurah').val() +
				"&fDate=" + $('#fDate').val() + 
				"&tDate=" + $('#tDate').val() +
				"&wp_wr_status_aktif=" + $("#wp_wr_status_aktif").val() +
				"&mengetahui=" + $('#ddl_mengetahui').val() +
				"&pemeriksa=" + $('#ddl_pemeriksa').val() +
				"&linespace=" + $('#linespace').val() +
				"&tgl_cetak=" + $('#tgl_cetak').val();
		
		$.download(url, 'filename=daftar_wp&format=xls');
	});
};

$(document).ready(function() {
	completePage();
	
	//Data Type Combo (Category - Sub Category - Sub Sub Category)
	$('#wp_wr_kd_camat').chainSelect('#wp_wr_kd_lurah', GLOBAL_MAIN_VARS["LIST_KELURAHAN"]);
});