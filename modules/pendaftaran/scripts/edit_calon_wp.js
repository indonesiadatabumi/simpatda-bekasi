 /**
  * create event toolbar
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		// load content
 		load_content(GLOBAL_CALON_WP_VARS["add_calon_wp"]);
 	});
 	
 	$("#btn_update").click(function (){
 		showAuthentication();
 	});
 	
 	$("#btn_view").click(function (){
 		load_content(GLOBAL_CALON_WP_VARS["view_calon_wp"]);
 	});
};

/**
 * submit form
 * @returns
 */
var updateData = function() {
	//Save di trigger oleh tombol Save, Reply dan Create Ticket
	var showUpdateResponse = function (responseText, statusText) {
		data = $.parseJSON(responseText);
        if(data.status == true) {
           showNotification(data.msg);
        } else {
        	showWarning(data.msg);
        }
	};
	
	var save_options = { 
		url : GLOBAL_CALON_WP_VARS["update_calon_wp"],
		beforeSubmit: jqform_validate,	// pre-submit callback 
		success: showUpdateResponse	// post-submit callback 
	};
	
	$("#frm_edit_calon_wp").ajaxSubmit(save_options);
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
	
	$("#wp_wr_no_urut").mask("9999999");
	$("#wp_wr_telp").numeric("-");
   	$("#wp_wr_kodepos").mask("99999");
   	$("#wp_wr_telp_milik").numeric("-");
   	$("#wp_wr_kodepos_milik").mask("99999");
   	
   	$('#ddl_wp_wr_pekerjaan').change(function(){
		if($(this).val() == '-') {
			$('#wp_wr_pekerjaan').val('');
		} else {
			$('#wp_wr_pekerjaan').val($('#ddl_wp_wr_pekerjaan').val());
		}		
	});
};

$(document).ready(function(){
	tabContent();
	createEventToolbar();
	completePage();
});