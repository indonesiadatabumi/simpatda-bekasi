/**
 * Form button
 */
var createEventToolbar = function (){
	$("#btn_view").click(function (){
		// load content
		load_content(GLOBAL_WP_PRIBADI_VARS["view_wp_pribadi"]);
	});
	
	var submitForm = function() {
		//Save di trigger oleh tombol Save, Reply dan Create Ticket
		var showInsertResponse = function (responseText, statusText) {
			data = $.parseJSON(responseText);
            if(data.status == true) {
               $("#txt_npwpd").val(data.npwpd).slideDown("slow");;
               $("#frm_add_wp_pribadi")[0].reset();
            } else {
            	showWarning(data.msg);
            }
            $('#btn_saved').one("click", submitForm);
		};
		
		var save_options = { 
			url : GLOBAL_WP_PRIBADI_VARS["save_wp_pribadi"],
			beforeSubmit: function(arr, $form, options) { 
				validate = jqform_validate(arr, $form, options);
				
				if (validate && validateForm()) {
					return true;
				} else {
					$('#btn_saved').one("click", submitForm);
					return false;
				}
			},	// pre-submit callback
			success: showInsertResponse,
			error: function(){
                alert("Terjadi kesalahan pada aplikasi. Silahkan menghubungi administrator");
            } 
		};
		
		$("#frm_add_wp_pribadi").ajaxSubmit(save_options);
	};
	
	$("#btn_saved").one("click", function() {
		submitForm();
	});
};

var validateForm = function() {
	var result = true;
	
	if($('#wp_wr_no_urut').val().length < 7) {
		result = false;
		showWarning('Anda harus mengisi Nomor Registrasi 7 digit !');
	} else if ($("input[name=bidus]").is(':checked') == false) {
		result = false;
		showWarning("Silahkan pilih bidang usaha");
	}
	
	return result;
};

var completePage = function() {
	$('select#wp_wr_jenis').focus();
	
	$("#f_date_kk, #f_date_ktp").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast", 
		changeMonth: true,
		changeYear: true,
		maxDate: "D",
		yearRange: '-90'
	});
	
	$("#f_date_a, #f_date_b, #f_date_c").datepicker({
   	   	dateFormat: "dd-mm-yy",
   	 	showOn: "both",
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		constrainInput: true,
		duration: "fast",
		beforeShow: function() {
			$('#f_date_b, #f_date_c').datepicker("option", 'minDate', $('#f_date_a').val());
		},
		onSelect: function( selectedDate ) {
			if (this.id == "f_date_a") {
				var date_b = $(this).datepicker('getDate');
				date_b.setDate(date_b.getDate()+7);
				$('#f_date_b').datepicker('setDate', date_b);
				$('#f_date_b, #f_date_c').datepicker("option", 'minDate', selectedDate);
			}
		}
   	});
	
 	$('#f_date_a').datepicker('setDate', 'c');
	$('#f_date_b').datepicker('setDate', 'c+7d');
	$('#f_date_c').datepicker('setDate', 'c');
	
	$("#wp_wr_no_urut").mask("9999999");
	$("#wp_wr_telp").numeric("-");
   	$("#wp_wr_kodepos").mask("99999");
   	$("#wp_wr_telp_milik").numeric("-");
   	$("#wp_wr_kodepos_milik").mask("99999");
   
   	//Data Type Combo (Category - Sub Category - Sub Sub Category)
	$('#wp_wr_kd_camat').chainSelect('#wp_wr_kd_lurah', GLOBAL_MAIN_VARS["LIST_KELURAHAN"]);
	
	$('#txt_next_nomor').click(function(){ getNextNomor(); });
	
	$('#ddl_wp_wr_pekerjaan').change(function(){
		if($(this).val() == '-') {
			$('#wp_wr_pekerjaan').val('');
		} else {
			$('#wp_wr_pekerjaan').val($('#ddl_wp_wr_pekerjaan').val());
		}		
	});
};

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

var getNextNomor = function() {
	$.ajax({
		type : "GET",
		url : GLOBAL_WP_PRIBADI_VARS["get_next_number_wp"],
		success: function(data){
			if (data.length > 0) {
				$('#wp_wr_no_urut').val(data);
			}
		}
	});
};

$(document).ready(function(){
	tabContent();
	completePage();
	//get next number
	getNextNomor();
	createEventToolbar();
});