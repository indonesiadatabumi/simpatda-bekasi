GLOBAL_MAIN_VARS["progress_indicator"] = "<img src='" + GLOBAL_MAIN_VARS["BASE_URL"] + "assets/images/progress.gif'/>";

/**
 * Show warning
 */
var showWarning = function (message, period){
	if ($("#warning").is(":visible")){
		$("#warning").prepend(message + "<br/>");
	}
	else{
		$("#warning").text(message)
			.slideDown("slow")
			.animate({opacity: 1.0}, (period!==undefined?period:3000))
			.slideUp("slow");
	}
};

/**
 * Show notification
 */
var showNotification = function (message, period){
	if ($("#notification").is(":visible")){
		$("#notification").prepend(message + "<br/>");
	}
	else{
		$("#notification").text(message)
			.slideDown("slow")
			.animate({opacity: 1.0}, (period!==undefined?period:1000))
			.slideUp("slow");
	}
};

/**
 * check if is valid Date
 * @param controlName
 * @param format
 * @returns
 */
var isValidDate = function(controlName, format) {
	var isValid = true;
	
	try {
		$.datepicker.parseDate(format, $('#' + controlName).val(), null);
	} catch (e) {
		isValid = false;
	}
	
	if (isValid != true) {
		showWarning('Tanggal salah');
		$('#' + controlName).val('');
	}
	
	return isValid;
};

/**
 * jQuery Form Validation
 */
var jqform_validate = function (formData, jqForm, options) {
	var pass = true;
	
	$('.mandatory', $(jqForm)).each(function() {
		if (!$(this).val()) {
			$(this).addClass("mandatory_invalid");
			pass = false;
		} else {
			$(this).removeClass("mandatory_invalid");
		}
	});

	if(!pass) {
		alert('Silahkan masukkan nilai untuk field mandatory');
	}
	return pass;
};

/**
 * unformatedCurrency
 * @param num
 * @returns
 */
var unformatCurrency = function (num) {
	if (num != "" || num != "undefined") {
		num = num.toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'');
	}
	return num;
};

/**
 * formatCurrency
 * @returns
 */
var formatCurrency = function(num, id) {
	if (num != "" || num != "undefined") {
		num = num.toString().replace(/\$|\,00/g,'').replace(/\$|\./g,'');
		if(isNaN(num)) {
			showWarning('Mohon Isi Dengan Angka');
			$('#' + id).focus();
			return(num);
		} else {
			sign = (num == (num = Math.abs(num)));
			num = Math.floor(num*100+0.50000000001);
			cents = num%100;
			num = Math.floor(num/100).toString();
			if(cents<10)
				cents = "0" + cents;
			for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
				num = num.substring(0,num.length-(4*i+3))+'.'+
			num.substring(num.length-(4*i+3));
			
			return (((sign)?'':'-') + num + ',' + cents);
		}
	}
};

/**
 * Numbers Only
 */
var numbersonly = function (myfield, e, dec) {
	var key;
	var keychar;

	if (window.event) {
		 key = window.event.keyCode;
	} else if (e) {
		 key = e.which;
	} else {
		 return true;
	}

	keychar = String.fromCharCode(key);

	// control keys
	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27) ) {
		return true;
	} else if ((("0123456789").indexOf(keychar) > -1)) { // numbers
		return true;
	} else if (dec && (keychar == ".")) { // decimal point jump
		myfield.form.elements[dec].focus();
		return false;
	} else {
		return false;
	}
};

var load_content = function(url, data) {
	
	// show progress indicator
	$("#content_panel").html(GLOBAL_MAIN_VARS["progress_indicator"]);

	// load content
	if (data == null) {
		$("#content_panel").load(url);
	} else {
		$("#content_panel").load(url, data);
	}
};

/**
 * showAuthentication Form Dialog
 */
var showAuthentication = function (action){
	$("body").append("<div id='div_authentication' title='Autentikasi'></div>");
	$("#div_authentication").html(GLOBAL_MAIN_VARS["progress_indicator"]);
	$("#div_authentication").dialog({
		bgiframe: true,
		autoOpen: true,
		resizable: false,
		width: 300,
		height: 150,
		modal: true,
		position: 'center'
	});
	$.get(GLOBAL_MAIN_VARS["BASE_URL"] + "login/popup_authentication", "action=" + (action!==undefined?action : "update"), 
		function(htm){
			$("#div_authentication").html(htm);
	},"html");
};

/**
 * showDialog form
 * @param url
 * @param width
 * @param height
 * @returns
 */
var showDialog = function(url, title, width, height) {
	$("body").append("<div id='div_dialog_box'></div>");
	$("#div_dialog_box").html(GLOBAL_MAIN_VARS["progress_indicator"]);
	$("#div_dialog_box").dialog({
		bgiframe: true,
		autoOpen: true,
		resizable: false,
		width: width,
		height: height,
		modal: true,
		position: 'center',
		open : function() {
            $('#div_dialog_box').dialog( "option" , "title" , title);
		}
	});
	
	if (url != '') {
		$.get(GLOBAL_MAIN_VARS["BASE_URL"] + url, {}, 
			function(htm){
				$("#div_dialog_box").html(htm);
		},"html");
	}
};

/**
 * showDialog post data
 * @param url
 * @param width
 * @param height
 * @returns
 */
var showDialogPost = function(url, title, data, width, height) {
	$("body").append("<div id='div_dialog_post'></div>");
	$("#div_dialog_post").html(GLOBAL_MAIN_VARS["progress_indicator"]);
	$("#div_dialog_post").dialog({
		bgiframe: true,
		autoOpen: true,
		resizable: false,
		width: width,
		height: height,
		modal: true,
		position: 'center',
		open : function() {
            $('#div_dialog_post').dialog( "option" , "title" , title);
		}
	});
	
	if (url != '') {
		$.post(GLOBAL_MAIN_VARS["BASE_URL"] + url, data, 
			function(htm){
				$("#div_dialog_post").html(htm);
		},"html");
	}
};


/**
 * showDialog get data
 * @param url
 * @param width
 * @param height
 * @returns
 */
var showDialogGet = function(url, title, data, width, height) {
	$("body").append("<div id='div_dialog_get'></div>");
	$("#div_dialog_get").html(GLOBAL_MAIN_VARS["progress_indicator"]);
	$("#div_dialog_get").dialog({
		bgiframe: true,
		autoOpen: true,
		resizable: false,
		width: width,
		height: height,
		modal: true,
		position: 'center',
		open : function() {
            $('#div_dialog_get').dialog( "option" , "title" , title);
		}
	});
	
	if (url != '') {
		$.get(GLOBAL_MAIN_VARS["BASE_URL"] + url, data, 
			function(htm){
				$("#div_dialog_get").html(htm);
		},"html");
	}
};

$(document).ready(function(){
	var zIndexNumber = 1000;
    $('ul#main_menu li').each(function() {
    	$(this).css('zIndex', zIndexNumber);
    	$(this).bgiframe();
    	zIndexNumber -= 10;
    });
    
	$("#main_menu").supersubs({
		minWidth: 12,
		maxWidth: 27,
		extraWidth: 1
	});
	
	// ajax setup
	$.ajaxSetup({cache: false});
	
	// top menu event handler
	$("ul#main_menu a").click(function (){
		$("ul#main_menu a.selected").removeClass("selected");
		$(this).addClass("selected");
		
		// get page id
		var menu_id = $(this).attr("id");
		
		if (menu_id != "#") {
			if (menu_id.substr(0, 5) == "popup") {
				if (menu_id == "popup_pendataan/objek_pajak/popup_jenis_pajak") {
					showDialog(menu_id.substr(6), 'Jenis Pajak', 800, 500);
				} else if (menu_id == "popup_pendataan/kartu_data/jenis_pajak") {
					showDialog(menu_id.substr(6), 'Kartu Data', 800, 500);
				}
			} else
				load_content(menu_id);
		}
	});
});