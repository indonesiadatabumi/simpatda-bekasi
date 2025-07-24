var tabContent = function() {
	//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
	
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTabjQ = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTabjQ).fadeIn(); //Fade in the active content
		return false;
	});
};

var onLoad = function() {
	var dates = $("#fDate, #tDate").datepicker({
   	   	dateFormat: "dd-mm-yy",
   	 	showOn: "both",
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		constrainInput: true,
		duration: "fast",
		maxDate: "D",
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
	
	$('#fDate, #tDate').datepicker('setDate', 'c');
	
	// tab3
	
		var dates = $("#awDate, #akDate").datepicker({
   	   	dateFormat: "dd-mm-yy",
   	 	showOn: "both",
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		constrainInput: true,
		duration: "fast",
		maxDate: "D",
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
			var option = this.id == "awDate" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" );
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
   	});
	
	$('#awDate, #akDate').datepicker('setDate', 'c');
	
	
	
	if ($("#jenis_pajak").val() == "4" || $("#jenis_pajak").val() == "8") {
		$("#status_spt").val("1");
		$("#jenis_restoran").hide();
		$("#daftar_cetak").hide();
	} else {
		if ($("#jenis_pajak").val() == "2") {
			$("#jenis_restoran").show();
		} else {
			$("#jenis_restoran").hide();
		}
		$("#daftar_cetak").show();
		$("#status_spt").val("8");
	}
};

var createEventToolbar = function() {
	$("input[name=cetak]").click(function() {
		if ($("select[name=jenis_restoran]").length > 0) {
			jenis_restoran = $("select[name=jenis_restoran]").val();
		} else {
			jenis_restoran = 0;
		}
		
		$.download(GLOBAL_MAIN_VARS["BASE_URL"] + "pembukuan/daftar_rekapitulasi/cetak" + 
				"?lap=masa_pajak" +
				"&jenis_pajak=" + $("select[name=jenis_pajak]").val() +
				"&jenis_restoran=" + jenis_restoran +
		//		"&jenis_restoran=" + $("select[name=jenis_restoran]").val() +
				"&bulan_masa_pajak=" + $("#bulan_masa_pajak").val() + 
				"&tahun_masa_pajak=" + $("#tahun_masa_pajak").val() +
				"&status_spt=" + $("#status_spt").val() +
				"&camat_id=" + $("#camat_id").val(),
			'filename=daftar_rekapitulasi&format=xls');
		return false;
	});	
	
	$("input[name=cetak_realisasi]").click(function() {
		if ($("select[name=jenis_restoran_realisasi]").length > 0) {
			jenis_restoran2 = $("select[name=jenis_restoran_realisasi]").val();
		} else {
			jenis_restoran2 = 0;
		}
		
		$.download(GLOBAL_MAIN_VARS["BASE_URL"] + "pembukuan/daftar_rekapitulasi/cetak" + 
				"?lap=realisasi" +
				"&jenis_pajak=" + $("select[name=jenis_pajak_realisasi]").val() +
				"&jenis_restoran=" + jenis_restoran2 +	
			//"&jenis_restoran=" + $("select[name=jenis_restoran_realisasi]").val() +
				"&fDate=" + $("#fDate").val() + 
				"&tDate=" + $("#tDate").val() +
				"&status_spt=" + $("#status_spt_realisasi").val() +
				"&camat_id=" + $("#camat_id_realisasi").val(),
			'filename=daftar_rekapitulasi_realisasi&format=xls');
		return false;
	});
	
	
	$("input[name=cetak_pendataan]").click(function() {
		if ($("select[name=jenis_restoran]").length > 0) {
			jenis_restoran3 = $("select[name=jenis_restoran]").val();
		} else {
			jenis_restoran3 = 0;
		}
		
		$.download(GLOBAL_MAIN_VARS["BASE_URL"] + "pembukuan/daftar_rekapitulasi/cetak_tgl_pendataan" + 
				"?lap=pendataan" +
				"&jenis_pajak=" + $("select[name=jenis_pajak_pendataan]").val() +
				"&jenis_restoran=" + jenis_restoran3 +	

				"&awDate=" + $("#awDate").val() + 
				"&akDate=" + $("#akDate").val() +
				"&status_spt=" + $("#status_spt").val() +
				"&camat_id=" + $("#camat_id").val(),
			'filename=daftar_rekapitulasi_pendataan&format=xls');
		return false;
	});
};

$(document).ready(function() {
	tabContent();
	onLoad();
	$("#jenis_pajak").change(function() {
		selectedStatus();
	});
	
	$("#jenis_pajak_realisasi").change(function() {
		selectedStatus2();
	});
	
		$("#jenis_pajak_pendataan").change(function() {
		selectedStatus3();
	});
	
	createEventToolbar();
});

var selectedStatus = function() {
	if ($("#jenis_pajak").val() == "2") {
		$("#jenis_restoran").show();
	} else {
		$("#jenis_restoran").hide();
	}
};


var selectedStatus2 = function() {
	if ($("#jenis_pajak_realisasi").val() == "2") {
		$("#jenis_restoran2").show();
	} else {
		$("#jenis_restoran2").hide();
	}
};

var selectedStatus3 = function() {
	if ($("#jenis_pajak_pendataan").val() == "2") {
		$("#jenis_restoran3").show();
	} else {
		$("#jenis_restoran3").hide();
	}
};



$(document).ready(function() {
	$("#accordion").accordion();
	//$("#accordion2").accordion2();
	//$("#accordion3").accordion3();
	
	tabContent();
	createEventToolbar();
	
	selectedStatus();
	selectedStatus2();
	selectedStatus3();

	
	$("#jenis_pajak").change(function() {
		selectedStatus();
	});
	
	
	$("#jenis_pajak_realisasi").change(function() {
		selectedStatus2();
	});
	
		$("#jenis_pajak_pendataan").change(function() {
		selectedStatus3();
	});
	
		
	
	
});