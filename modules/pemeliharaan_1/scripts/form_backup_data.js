/**
 * validateForm
 * @returns
 */
var validateForm = function() {
	var result = false;
	
	var vals = [];
	$('input[name="kecamatan[]"]:checked').each(function() {
	    vals.push(this.value);
	});
	
	var pajaks = [];
	$('input[name="jenis_pajak[]"]:checked').each(function() {
		pajaks.push(this.value);
	});
	
	if($("#fDate").val() == "" || $("#tDate").val() == "") {
		showWarning("Masukkan tanggal pendataan");
	} else if(pajaks == "") {
		showWarning("Silahkan pilih jenis pajak");
	} else if (vals == "") {
		showWarning("Silahkan pilih kecamatan");
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
		
		var pajaks = [];
		$('input[name="jenis_pajak[]"]:checked').each(function() {
			pajaks.push(this.value);
		});

		$.download(GLOBAL_BACKUP_DATA_VARS["export"] + 
				"?fDate=" + $("#fDate").val() + 
				"&tDate=" + $("#tDate").val() +
				"&kecamatan=" + vals +
				"&jenis_pajak=" + pajaks,
			'filename=backup&format=json');
	}
};


/**
 * create flexigrid
 * @returns
 */
var createDataGrid = function() {
	var vals = [];
	$('input[name="kecamatan[]"]:checked').each(function() {
	    vals.push(this.value);
	});
	
	var pajaks = [];
	$('input[name="jenis_pajak[]"]:checked').each(function() {
		pajaks.push(this.value);
	});
	
	$("#backup_table").flexigrid({
		url: GLOBAL_BACKUP_DATA_VARS["view"]  + 
				"?fDate=" + $("#fDate").val() + 
				"&tDate=" + $("#tDate").val() +
				"&kecamatan=" + vals +
				"&jenis_pajak=" + pajaks,
		dataType: 'json',
		colModel : [
			{display: 'No.', name : '', width : 40, align: 'center', sortable : true, align: 'left'},
			{display: 'Nomor SPT', name : 'spt_nomor', width : 100, sortable : true, align: 'left'},
			{display: 'Jenis Pajak', name : 'spt_jenis_pajak', width : 180, sortable : true, align: 'left'},
			{display: 'Jumlah Pajak', name : 'spt_jenis_pajak', width : 170, sortable : true, align: 'left'},
			],
		sortname: "spt_nomor",
		sortorder: "asc",
		usepager: true,
		title: 'DAFTAR BACKUP DATA',
		useRp: true,
		rp: 10,
		showTableToggleBtn: false,
		height: 'auto',
		width: '490'
	});
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
	
	$("#btn_view").click(function(){
		if(!validateForm())
			return false;
		
		if ($(".flexigrid").is(':visible') == false) {
			createDataGrid();
		} else {
			var vals = [];
			$('input[name="kecamatan[]"]:checked').each(function() {
			    vals.push(this.value);
			});
			
			var pajaks = [];
			$('input[name="jenis_pajak[]"]:checked').each(function() {
				pajaks.push(this.value);
			});
			
			urlAction = GLOBAL_BACKUP_DATA_VARS["view"]  + 
						"?fDate=" + $("#fDate").val() + 
						"&tDate=" + $("#tDate").val() +
						"&kecamatan=" + vals +
						"&jenis_pajak=" + pajaks;
			
			$("#backup_table").flexOptions({
	            url: urlAction,
	            newp: 1
	        }).flexReload();
		}
		
	});
});