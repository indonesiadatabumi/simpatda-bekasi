/**
 * createDataGrid
 * @returns
 */
var createDataGrid = function() {
	$("#sts_table").flexigrid({
		url: GLOBAL_VIEW_STS_VARS["get_list"],
		dataType: 'json',
		colModel : [
		    {display: 'SKBH ID', name : 'skbh_id', width : 120, sortable : true, align: 'center', hide:true},
		    {display: 'No.', name : '', width : 40, align: 'left', process: cellClick},
		    {display: '', name : '', width : 20, sortable : true, align: 'center', process: cellClick},
			{display: 'No. Bukti', name : 'skbh_no', width : 100, align: 'left', process: cellClick},
			{display: 'Tanggal', name : 'skbh_tgl', width : 80, sortable : true, align: 'center', process: cellClick},
			{display: 'Nama', name : 'skbh_nama', width : 180, sortable : true, align: 'left', process: cellClick},
			{display: 'Alamat', name : 'skbh_alamat', width : 250, sortable : true, align: 'left', process: cellClick},
			{display: 'Jumlah', name : 'skbh_jumlah', width : 100, align: 'right', process: cellClick},
			{display: 'Validasi', name : '', width : 60, sortable : true, align: 'center'},
			{display: 'Cetak', name : '', width : 50, sortable : true, align: 'center'}
			],
		searchitems : [
			{display: 'Nomor STS', name : 'skbh_no', isdefault: true},
            {display: 'Tanggal', name : 'skbh_tgl'}
			],
		sortname: "skbh_id",
		sortorder: "DESC",
		usepager: true,
		title: 'Daftar Surat Tanda Setoran ke Bank',
		useRp: true,
		rp: 10,
		showTableToggleBtn: false,
		height: 'auto'
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
 * validasi STS
 * @returns
 */
var validasiSTS = function(id) {
	var showValidasiResponse = function(response) {
		if (response.status == true) {
			$("#btn_validasi" + id).hide();
		} else {
			showWarning(response.msg);
		}
	};
	
	$.ajax({
	  type: 'POST',
	  url: GLOBAL_VIEW_STS_VARS["validasi"],
	  data: {
		  skbh_id : id
	  },
	  success: showValidasiResponse,
	  dataType: 'json'
	});
};

/**
 * cetak STS
 * @returns
 */
var cetakSTS = function(id) {
	url = GLOBAL_VIEW_STS_VARS["cetak"] + "?skbh_id=" + id;
	var html = '<iframe id="sspd" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
	var w = window.open(url);
	w.document.writeln(html);
	w.document.close();
	
	return false;
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
	//button view list
	$("#btn_add").click(function() {
		//load content panel
		load_content(GLOBAL_VIEW_STS_VARS["add"]);
	});
	
	$("#btn_delete").click(function (){ 		
 		if ($("input[name=id]").val().length > 0) {
 			showAuthentication('delete');
		} else {
			showWarning("Silahkan pilih data terlebih dahulu untuk dihapus");
		}
 	});
	
	/**
	 * button cari click
	 **/
	$("#btn_cari").click(function() {
		ext_url = GLOBAL_VIEW_STS_VARS["search"] + 
				"?fDate=" + $("input[name=fDate]").val() + 
				"&tDate=" + $("input[name=tDate]").val();
		
		$("#sts_table").flexOptions({url: ext_url}); 	
		$("#sts_table").flexReload();
		
		return false;
	});
	
	/**
	 * cetak to excel
	 */
	$("#btn_cetak").click(function() {
		ext_url = GLOBAL_VIEW_STS_VARS["cetak_daftar"] + 
				"?fDate=" + $("input[name=fDate]").val() + 
				"&tDate=" + $("input[name=tDate]").val();
		
		$.download(ext_url, 'filename=daftar_sts&format=xls');
		
		return false;
	});
	
	/**
	 * reset click
	 */
	$("#btn_reset").click(function() {
		
		ext_url = GLOBAL_VIEW_STS_VARS["search"] + "?fDate=&tDate=";

		$("#sts_table").flexOptions({url: ext_url}); 	
		$("#sts_table").flexReload();
		return false;
	});
};


/**
 * deleteData
 * @returns
 */
var deleteData = function() {
	 var remove = function (){
		 var selectedItems = "";
		 
		 $(".toggle").each( function () {
			if ($(this).is(':checked')) {
				selectedItems += $(this).val() + "|";
			}		
		});
		 
		 $.ajax({
		     type: "POST",
		     url: GLOBAL_VIEW_STS_VARS["delete"],
		     data: "mode=delete&id="+selectedItems,
		     dataType: "json",
		     success: function(response){
		    	 if (response.status == true) {
		    		 $("#sts_table").flexReload();
		    		 showNotification(response.msg);
				} else {
					showWarning(response.msg);
				}	 			
		     }
		 });
	 };
		 
	 $("#confirmation_delete").dialog({
		bgiframe: true,
		resizable: false,
		height: 350,
		height: 140,
		modal: true,
		overlay: {
			backgroundColor: '#000',
			opacity: 0.2
		},
		buttons: {
			'Ya': function() {
				$(this).dialog('close');
				remove();
			},
			'Tidak': function() {
				$(this).dialog('close');
			}
		}
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
	
	$('#fDate, #tDate').datepicker('setDate', 'c');
};

$(document).ready(function(){
	createDataGrid();
	completePage();
	createEventToolbar();
});