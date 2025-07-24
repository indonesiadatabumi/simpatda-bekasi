/**
 * validateForm
 * @returns
 */
var validateForm = function() {
	var result = false;
	
	if($("#fDate").val() == "" || $("#tDate").val() == "") {
		showWarning("Masukkan tanggal pendataan");
	} else if ($("#kecamatan").val() == "") {
		showWarning("Silahkan pilih kecamatan");
	//} else if($("#from_penyetoran").val() == "" || $("#to_penyetoran").val() == "") {
	//	showWarning("Masukkan tanggal penyetoran");
	} else {
		result = true;
	}
	
	return result;
};

//backup data
var backupData = function (){
	if (validateForm()) {
		var vals = [];
		$('input[name="kecamatan[]"]:checked').each(function() {
		    vals.push(this.value);
		});
		
		/*
		$.download(GLOBAL_BACKUP_DATA_WP_VARS["export"] + 
				"?fDate=" + $("#fDate").val() + 
				"&tDate=" + $("#tDate").val() +
				"&kecamatan=" + vals +
				"&from_penyetoran=" + $('#from_penyetoran').val() +
				"&to_penyetoran=" + $('#to_penyetoran').val(),
			'filename=backup&format=json');
		*/
		$.download(GLOBAL_BACKUP_DATA_WP_VARS["export"] + 
				"?fDate=" + $("#fDate").val() + 
				"&tDate=" + $("#tDate").val() +
				"&kecamatan=" + vals,
			'filename=backup&format=json');
	}
};

/**
 * document ready
 */
$(document).ready(function() {
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
	
	var dates_setoran = $("#from_penyetoran, #to_penyetoran").datepicker({
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
			var option = this.id == "from_penyetoran" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
				dates_setoran.not( this ).datepicker( "option", option, date );
		}
   	});
	
	$("#btn_backup").click(function(){
		backupData();
		return false;
	});
});