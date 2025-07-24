 /**
  * create event toolbar
  */
 var createEventToolbar = function (){	 	
 	$("#btn_add").click(function (){
 		// load content
 		load_content(GLOBAL_WP_BU_VARS["add_wp_bu"]);
 	});
 	
 	$("#btn_update").click(function (){
 		showAuthentication();
 	});
 	
 	$("#btn_view").click(function (){
 		load_content(GLOBAL_WP_BU_VARS["view_wp_bu"]);
 	});
};

/**
 * submit form
 * @returns
 */
var updateData = function() {
	var showUpdateResponse = function (data) {
        if(data.status == true) {
           showNotification(data.msg);
        } else {
        	showWarning(data.msg);
        }
	};
	
	var save_options = { 
		url : GLOBAL_WP_BU_VARS["update_wp_bu"],
		dataType : "json",
		beforeSubmit: jqform_validate,	// pre-submit callback 
		success: showUpdateResponse	// post-submit callback 
	};
	
	$("#frm_edit_wp_bu").ajaxSubmit(save_options);
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
};

var selectBidangUsaha = function() {
	var createForm = function() {
		bidus = $("input[name=bidus]:checked").val();
		if (bidus == "1" || bidus == "16") {
			$("#detail_usaha").slideUp("fast").slideDown("slow");
			$("#detail_usaha").html($("#bidus_" + bidus).html());		
		} else {
			$("#detail_usaha").fadeOut("slow");
		}
	};
	
	$("input[name=bidus]").on("click", function() {
		createForm();	
	});
	
	createForm();
	$.post(GLOBAL_WP_BU_VARS["get_wp_detail"], { "wp_id": $("input[name=wp_wr_id]").val() },
			 function(data){
				bidus = $("input[name=bidus]:checked").val();
			 	if (data.status == true) {
			 		row = data.row;
					if (bidus == "1") {
						$("select[name=gol_hotel]").val(row.wp_gol_hotel);
						$("input[name=txt_jumlah_kamar]").val(row.wp_jlh_kamar);
					} else if (bidus == "16") {
						$("select[name=ddl_jenis_restoran]").val(row.wp_jenis_restoran);
						$("input[name=txt_jumlah_meja]").val(row.wp_jlh_meja);
						$("input[name=txt_jumlah_kursi]").val(row.wp_jlh_kursi);
					}
				}
			 }, "json");
};

$(document).ready(function(){
	tabContent();
	createEventToolbar();
	completePage();
	selectBidangUsaha();
});