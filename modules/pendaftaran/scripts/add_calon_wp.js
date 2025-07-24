/**
 * Form button
 */
var createEventToolbar = function (){
	$("#btn_view").click(function (){
		// load content
		load_content(GLOBAL_CALON_WP_VARS["view_calon_wp"]);
	});
	
	var submitForm = function() {
		//Save di trigger oleh tombol Save, Reply dan Create Ticket
		var showInsertResponse = function (responseText, statusText) {
			data = $.parseJSON(responseText);
            if(data.status == true) {
               $("#frm_add_calon_wp")[0].reset();
			   alert(data.msg)
            } else {
            	showWarning(data.msg);
            }
            $('#btn_saved').one("click", submitForm);
		};
		
		var save_options = { 
			url : GLOBAL_CALON_WP_VARS["save_calon_wp"],
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
		
		$("#frm_add_calon_wp").ajaxSubmit(save_options);
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

var completePage = function(){
	var isShift = false;
	$(document).keyup(function(e){ if(e.which == 16) isShift=false; });
	
	$("input[type=text],input[type=radio],input[type=checkbox],select").keypress(function(e) {
		if(e.which == 16) isShift=true;
		if ((e.which==13 || e.which==9) && isShift == false) {
			if (this.name =="wp_wr_no_urut" ) $('input[name=wp_wr_nama]').focus();
			else if (this.name == "wp_wr_nama" ) $('textarea[name=wp_wr_almt]').focus();
			else if (this.name == "wp_wr_kd_camat" ) $('select#wp_wr_kd_lurah').focus();
			else if (this.name == "wp_wr_kd_lurah" ) $('input[name=wp_wr_kabupaten]').focus();
			else if (this.name == "wp_wr_kabupaten" ) $('input[name=wp_wr_telp]').focus();
			else if (this.name == "wp_wr_telp" ) $('input[name=wp_wr_kodepos]').focus();
			else if (this.name == "wp_wr_kodepos" ) $('input[name=wp_wr_nama_milik]').focus();
			else if (this.name == "wp_wr_nama_milik" ) $('textarea[name=wp_wr_almt_milik]').focus();
			else if (this.name == "wp_wr_lurah_milik" ) $('input[name=wp_wr_camat_milik]').focus();
			else if (this.name == "wp_wr_camat_milik") $('input[name=wp_wr_kabupaten_milik]').focus();
			else if (this.name == "wp_wr_kabupaten_milik") $('input[name=wp_wr_telp_milik]').focus();
				else if (this.name == "wp_wr_telp_milik") $('input[name=wp_wr_kodepos_milik]').focus();
			else if (this.name == "wp_wr_kodepos_milik") $('input[name=wp_wr_tgl_terima_form]').focus();
			else if (this.name == "wp_wr_tgl_terima_form") $('input[name=wp_wr_tgl_bts_kirim]').focus();
			else if (this.name == "wp_wr_tgl_bts_kirim") $('input[name=wp_wr_tgl_form_kembali]').focus();
			else if (this.name == "spt_periode_jual2" && e.which==9) return true;
			else if (e.which==9) return true;
			return false;
		}
	});

	$("button,input,select,textarea").focus(function() {
		$(this).select();
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
	$('#wp_wr_kd_camat').chainSelect('#wp_wr_kd_lurah', GLOBAL_MAIN_VARS["LIST_KELURAHAN"],
	{
		before: function(target) {
		},
		after: function(target) {
			var kecamatan = $('#wp_wr_kd_camat').val().split("|");
			$('#wp_wr_camat_milik').val(kecamatan[1]);
			$('#wp_wr_lurah_milik').val('');
		}
	});
	
	$('#wp_wr_kd_lurah').change(function() {		
		var kelurahan = $('#wp_wr_kd_lurah').val().split("|");
		$('#wp_wr_lurah_milik').val(kelurahan[1]);
	});
	
	$('#txt_next_nomor').click(function(){ getNextNomor(); });	
	
	//textbox input
	$('#wp_wr_nama').change(function() {
		$('#wp_wr_nama_milik').val($('#wp_wr_nama').val());
	});
	
	$('#wp_wr_almt').change(function() {
		$('#wp_wr_almt_milik').val($('#wp_wr_almt').val());
	});
	
	$('#wp_wr_telp').change(function() {
		$('#wp_wr_telp_milik').val($('#wp_wr_telp').val());
	});
	
	$('#wp_wr_kodepos').change(function() {
		$('#wp_wr_kodepos_milik').val($('#wp_wr_kodepos').val());
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
		url : GLOBAL_CALON_WP_VARS["get_next_number_calon_wp"],
		success: function(data){
			if (data.length > 0) {
				$('#wp_wr_no_urut').val(data);
			}
		}
	});
};

var selectBidangUsaha = function() {
	$("input[name=bidus]").on("click", function() {
		bidus = $("input[name=bidus]:checked").val();
		if (bidus == "1" || bidus == "16") {
			$("#detail_usaha").slideUp("fast").slideDown("slow");
			$("#detail_usaha").html($("#bidus_" + bidus).html());		
		} else {
			$("#detail_usaha").fadeOut("slow");
		}		
	});
};

$(document).ready(function(){
	tabContent();
	completePage();
	//get next number
	getNextNomor();
	createEventToolbar();
	selectBidangUsaha();
});