
/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#setoran_batal_table").flexigrid({
		url: GLOBAL_BATAL_SETORAN_VARS["get_list"],
		dataType: 'json',
		colModel : [
		    {display: 'No.', name : '', width : 30, align: 'left'},
		    {display: 'Tgl. Batal', name : 'setorpajret_deleted_time', width : 100, sortable : true, align: 'left'},
		    {display: 'Petugas', name : 'setorpajret_deleted_by', width : 120, sortable : true, align: 'left'},
		    {display: 'Jenis Pajak', name : 'ref_jenparet_ket', width : 110, sortable : true, align: 'left'},
			{display: 'Periode', name : 'setorpajret_spt_periode', width : 50, sortable : true, align: 'center'},			
			{display: 'No. KOHIR/SPT', name : 'setorpajret_no_spt', width : 80, sortable : true, align: 'left'},
			{display: 'Ket. SPT', name : 'ketspt_singkat', width : 80, sortable : true, align: 'center'},
			{display: 'Tgl Setor', name : 'setorpajret_tgl_bayar', width : 90, sortable : true, align: 'center'},			
			{display: 'Jumlah', name : 'setorpajret_jlh_bayar', width : 100, sortable : true, align: 'right'},
			{display: 'NPWPD', name : 'npwprd', width : 110, sortable : true, align: 'center'},
			{display: 'Nama WP', name : 'wp_wr_nama', width : 250, sortable : true, align: 'left'}
			],
		searchitems : [
			{display: 'Periode SPT', name : 'spt_periode'},
			{display: 'NPWPD', name : 'npwprd'},
			{display: 'Nama WP', name : 'wp_wr_nama'}
			],
		sortname: "setorpajret_deleted_time",
		sortorder: "DESC",
		usepager: true,
		title: 'DAFTAR PEMBATALAN SETORAN',
		useRp: true,
		rp: 15,
		showTableToggleBtn: false,
		height: 'auto',
		width: 'auto'
	});
};

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
			showDialog(GLOBAL_BATAL_SETORAN_VARS["get_spt"] + "?spt_periode=" + $("#spt_periode").val() + "&spt_jenis_pajakretribusi=" + $("#spt_jenis_pajakretribusi").val(), 
							'List SPT/KOHIR', 950, 500);
		}
	});
	
	$("#btn_cancel").click(function() {
		load_content(GLOBAL_MAIN_VARS['BASE_URL'] + "bkp/rekam_pajak");
	});
};

//validate before submit 
var validateForm = function() {
	($("#spt_jenis_pajakretribusi").val() == "0") ? $("#spt_jenis_pajakretribusi").addClass("mandatory_invalid") : $("#spt_jenis_pajakretribusi").removeClass("mandatory_invalid");
	($("#spt_periode").val() == "") ? $("#spt_periode").addClass("mandatory_invalid") : $("#spt_periode").removeClass("mandatory_invalid");
	($("#spt_nomor").val() == "") ? $("#spt_nomor").addClass("mandatory_invalid") : $("#spt_nomor").removeClass("mandatory_invalid");			
	($("#setorpajret_jenis_ketetapan").val() == "") ? $("#setorpajret_jenis_ketetapan").addClass("mandatory_invalid") : $("#setorpajret_jenis_ketetapan").removeClass("mandatory_invalid");

	if ($("#spt_jenis_pajakretribusi").val() == "0" || $("#spt_periode").val() == "" || $("#spt_nomor").val() == "" || $("#setorpajret_jenis_ketetapan").val() == "")
		return false;
	else
		return true;
};

/**
 * delete data
 * @returns
 */
var deleteData = function() {
	var showProcessResponse = function (response) {
		if (response.status == true) {
			showNotification(response.msg, 5000);
			$("#setoran_batal_table").flexReload();
		} else {
			showWarning(response.msg, 5000);
		}
	};
	
	$.ajax({
	  type: 'POST',
	  url: GLOBAL_BATAL_SETORAN_VARS["insert"],
	  data: {
		  spt_jenis_pajakretribusi : $("#spt_jenis_pajakretribusi").val(),
		  spt_periode : $("#spt_periode").val(),
		  spt_nomor : $("#spt_nomor").val(),
		  setorpajret_jenis_ketetapan : $("#setorpajret_jenis_ketetapan").val()
	  },
	  success: showProcessResponse,
	  dataType: 'json'
	});
};

/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$('#btn_batal').click(function() {
		if (validateForm()) {
			showAuthentication('delete');
		}
	});
	
	$("#btn_reset").click(function(){
		$("#spt_nomor").val("");
		$("#div_setoran").hide('slow');
		$('#setorpajret_jenis_ketetapan').val("");
		$("#spt_nomor").focus();
	});
	
	//button back function
	$('#btn_back').click(function() {
		load_content(GLOBAL_BATAL_SETORAN_VARS["back"]);
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
};

$(document).ready(function() {
	createDataGrid();
	completePage();
	createEventToolbar();
	focusInput();
});