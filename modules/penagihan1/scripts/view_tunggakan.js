/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#tunggakan_table").flexigrid({
		url: GLOBAL_VIEW_TUNGGAKAN_VARS["get_list"] + "?periode=" + $("#periode").val() + "&jenis_pajak=" + $("select[name=jenis_pajak]").val(),
		dataType: 'json',
		colModel : [
		    {display: 'SPT ID', name : 'spt_pen_id', width : 120, sortable : true, align: 'center', hide:true},
			{display: 'No.', name : '', width : 25, align: 'left'},
			{display: 'Nama WP', name : 'wp_wr_nama', width : 240, sortable : true, align: 'left'},
			{display: 'NPWPD', name : 'npwprd', width : 110, sortable : true, align: 'left'},			
			{display: 'Jenis Pajak', name : 'ref_jenparet_ket', width : 120, sortable : true, align: 'left'},
			{display: 'Periode', name : 'spt_periode', width : 40, sortable : true, align: 'center'},
			{display: 'No. KOHIR/SPT', name : 'spt_nomor', width : 80, sortable : true, align: 'center'},
			{display: 'Masa Pajak', name : 'tgl_jatuh_tempo', width : 100, sortable : true, align: 'left'},
			{display: 'Jatuh Tempo', name : 'tgl_jatuh_tempo', width : 80, sortable : true, align: 'center'},
			{display: 'Kode Rekening', name : 'koderek', width : 80, sortable : true, align: 'center'},			
			{display: 'Ket. SPT ID', name : 'ketspt_id', width : 80, sortable : true, align: 'left', hide: 'true'},
			{display: 'Ket. SPT', name : 'ketspt_singkat', width : 80, sortable : true, align: 'center'},
			{display: 'Jumlah Pajak (Rp)', name : 'spt_pajak', width: 110, align: 'right'}
			],
		searchitems : [
			{display: 'No. SPT', name : 'spt_nomor', isdefault: true},
			{display: 'Periode SPT', name : 'spt_periode'},
			{display: 'Kode Rekening', name : 'koderek'},
			{display: 'NPWPD', name : 'npwprd'},
			{display: 'Nama WP', name : 'wp_wr_nama'}
			],
		sortname: "tgl_jatuh_tempo",
		sortorder: "ASC",
		usepager: true,
		title: 'Daftar Tunggakan',
		useRp: true,
		rp: 10,
		showTableToggleBtn: true,
		height: 'auto',
		width: 'auto'
	});
};

/**
 * cellClick Event from grid
 * @param celDiv
 * @param id
 * @returns
 */
var cellClick = function(celDiv,id) {
    $(celDiv).click(function (){
    	var $row = $(celDiv).parent().parent();
		var cells = $("div", $row);
		
		if ($('#cb'+id+':checked').val() == null) {
			$('#cb'+id).attr("checked",true);
			$("input[name=id]").val($(cells[0]).text());
		}
		else {
			$('#cb'+id).attr("checked",false);
			$("input[name=id]").val('');
		}	
    });
 };
 
 /**
  * isChecked sptpd
  * @param id
  * @returns
  */
 var isChecked = function(id, sptId) {
	 if ($('#cb'+id+':checked').val() == null) {
		$('#cb'+id).attr("checked",true);
		$("input[name=id]").val(sptId);
	 }
	 else {
		$('#cb'+id).attr("checked",false);
		$("input[name=id]").val('');
	 }
 };
 
 /**
  * selectRows function
  * @returns
  */
 var selectRows = function() {
	var rows = $("table#wp_pribadi_table").find("tr").get();
	if(rows.length > 0) {
		$.each(rows,function(i,n) {
			$(n).toggleClass("trSelected");
		});
	};
	
	$(".toggle").each( function () {
		if ($(this).is(':checked')) {
			$(this).removeAttr('checked');
		} else {
			$(this).attr('checked', 'true');
			$("input[name=id]").val($(this).val());
		}		
	});
};

/**
 * select row index
 * @param index
 * @returns
 */
var selectRow = function(index, id) {
	if ($("#cb"+index).is(':checked')) {
		$("input[name=id]").val(id);
	} else {
		$("input[name=id]").val('');
	}
};

/**
 * validate form page
 * @returns
 */
var validateForm = function() {
	($("#fDate").val() == "") ? $("#fDate").addClass("mandatory_invalid") : $("#fDate").removeClass("mandatory_invalid");			
	($("#tDate").val() == "") ? $("#tDate").addClass("mandatory_invalid") : $("#tDate").removeClass("mandatory_invalid");

	if ($("#fDate").val() == "" || $("#tDate").val() == "")
		return false;
	else
		return true;
};

/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {	
	/**
	 * button cari click
	 **/
	$("#btn_cari").click(function() {
		ext_url = GLOBAL_VIEW_TUNGGAKAN_VARS["get_list"] + 
				"?periode=" + $("#periode").val() +
				"&jenis_pajak=" + $("select[name=jenis_pajak]").val() + 
				"&camat_id=" + $("select[name=camat_id]").val() + 
				"&fDate=" + $("input[name=fDate]").val() + 
				"&tDate=" + $("input[name=tDate]").val();
		
		$("#tunggakan_table").flexOptions({url: ext_url}); 	
		$("#tunggakan_table").flexReload();
		
		return false;
	});
	
	/**
	 * cetak to excel
	 */
	$("#btn_cetak").click(function() {
		url = GLOBAL_VIEW_TUNGGAKAN_VARS["cetak"] +
					"?periode=" + $("#periode").val() +
					"&jenis_pajak=" + $("select[name=jenis_pajak]").val() + 
					"&camat_id=" + $("select[name=camat_id]").val() + 
					"&fDate=" + $("input[name=fDate]").val() + 
					"&tDate=" + $("input[name=tDate]").val();
		
		var html = '<iframe id="index" class="index" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
		
		var w = window.open(url);
		w.document.writeln(html);
		w.document.close();
		return false;
	});
	
	/**
	 * reset click
	 */
	$("#btn_reset").click(function() {
		$("select[name=jenis_pajak]").val("0");
		$("select[name=camat_id]").val("0");
		$("input[name=fDate], input[name=tDate]").val("");
		
		ext_url = GLOBAL_VIEW_TUNGGAKAN_VARS["get_list"] + 
									"?periode=" + $("#periode").val();

		$("#tunggakan_table").flexOptions({url: ext_url}); 	
		$("#tunggakan_table").flexReload();
		return false;
	});
};

/**
 * complete page
 * @returns
 */
var completePage = function() {	
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
};

$(document).ready(function(){
	createDataGrid();
	completePage();
	createEventToolbar();
});