
/**
 * onCompletePage
 * @returns
 */
var completePage = function() {
	$("input[name=tanggal_setor]").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	
	$('input[name=tanggal_setor]').datepicker('setDate', 'c');
	
	$("input[name=tanggal_setor]").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
	
	$("#trigger_spt").click(function() {
		if($("#spt_jenis_pajakretribusi").val() == "") {
			showWarning("Pilih objek pajak terlebih dahulu");
		} else {
			showDialog(GLOBAL_SETOR_PAJAK_VARS["get_spt"] + "?spt_periode=" + $("#spt_periode").val() 
														+ "&spt_jenis_pajakretribusi=" + $("#spt_jenis_pajakretribusi").val()
														+ "&ketspt_id=" + $("#setorpajret_jenis_ketetapan").val(),
						'List SPT/KOHIR', 950, 500);
		}
	});
	
	$("#btn_cancel").click(function() {
		load_content(GLOBAL_MAIN_VARS['BASE_URL'] + "bkp/rekam_pajak");
	});
};

/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$('#btn_proses').click(function() {
		var showProcessResponse = function (response, status) {
			if ($("#div_setoran").is(':visible')) 
				$("#div_setoran").slideUp('fast').slideDown('slow').html(response);
			else
				$("#div_setoran").slideDown('slow').html(response);
		};
		
		var save_options = { 
			url : GLOBAL_SETOR_PAJAK_VARS["proses_setoran"],
			type : "POST",
			beforeSubmit: jqform_validate,
			success: showProcessResponse
		};
		
		$("#frm_setoran_pajak").ajaxSubmit(save_options);
	});
	
	$("#btn_reset").click(function(){
		$("#spt_nomor").val("");
		$("#div_setoran").hide('slow');
		$("#spt_nomor").focus();
	});
	
	//button view list
	$("#btn_view").click(function() {
		//load content panel
		load_content(GLOBAL_SETOR_PAJAK_VARS["view_setoran"]);
	});
	
	/**
	 * pembatalan setoran
	 */
	$("#btn_batal").click(function() {
		//load content panel
		load_content(GLOBAL_SETOR_PAJAK_VARS["batal_setoran"]);
	});
};

/**
 * focus input function
 * @returns
 */
var focusInput = function() {	
	$("#spt_jenis_pajakretribusi").focus();
	
	var isShift = false;
	$(document).change(function(e){ if(e.which == 16) isShift=false; });
	
	$("input[type=text],input[type=radio],input[type=checkbox],input[type=button],select").keypress(function(e) {
		if(e.which == 16) isShift=true;
		if ((e.which==13 || e.which==9) && isShift == false) {
			if (this.name == "spt_jenis_pajakretribusi" ) { $('input[name=spt_periode]').focus(); return false;}
			else if (this.name == "spt_periode" ) $('input[name=spt_nomor]').focus();
			else if (this.name == "spt_nomor" ) $('select[name=setorpajret_jenis_ketetapan]').focus();
			else if (this.name == "setorpajret_jenis_ketetapan" ) $('input[name=btn_proses]').focus().click();
			
			else if (e.which==9) return true;
			
			if (this.name == "btn_reset") {
				$('input[name=btn_reset]').click();
			}
			
			return false;
		}
	});

	$("#setorpajret_jenis_ketetapan").keypress(function(e){
	    //console.log(String.fromCharCode(e));
	});
	
	$("#spt_jenis_pajakretribusi").change(function() {
		if ($("#spt_jenis_pajakretribusi").val() == "4" || $("#spt_jenis_pajakretribusi").val() == "8") {
			$("#setorpajret_jenis_ketetapan").val("1");
		} else {
			$("#setorpajret_jenis_ketetapan").val("8");
		}
	});
};

$(document).ready(function() {
	completePage();
	createEventToolbar();
	focusInput();
});