

var insertOptionRekening = function(idSelect) {
	$.get(GLOBAL_SETORAN_DINAS_VARS["get_rekening"], { }, function(data){
		var option = "";
		option += "<option value=''>--</option>";
		if (data.total!=undefined && data.total>0){
			$.each(data.list, function(id, obj){
				option += "<option value='"+ obj.key +"'>"+ obj.value +"</option>";
			});
		}
		$("#" + idSelect).append(option);
	}, "json");
};

/**
 * check kode rekening is exist
 * @param n
 * @returns
 */
var checkKorek = function(id) {
	var i = $('#detailTable tr').length - 3;
	for (k=1;k<=i;k++) {
		try {
			if (document.getElementById('spt_dt_korek'+k).value == document.getElementById('spt_dt_korek'+id).value && k!=id) {
				showWarning('Kode Rekening yang sama sudah terpilih. Mohon pilih kode rekening lainnya!');
				$('#spt_dt_korek'+id).val('');
				$('#spt_dt_korek'+id).focus();
				return false;
			}
		} catch (ex) {
		}
	}
};

/**
 * parsing string by comma
 * @param arr
 * @returns
 */
var parseComma = function(arr) {
	if (arr == "") arr = ',';
	var myString = new String(arr);
	var myStringList = myString.split(','); // split on commas
	return myStringList;
};


/**
 * to calculate
 * @returns
 */
var hitungSetoran = function() {
	var i=0;
	var pajak = 0;
	
	$('#txt_setoran').val("");
	var rowCount = $('#detailTable tr').length;
	while (i <= rowCount) {
		try {
			pajak += (unformatCurrency($("#txt_dt_setoran"+i+"").val()) * 1);
		} catch (ex) { }
		i++;
	}
	
	$('#txt_setoran').val(formatCurrency(pajak));
};

/**
 * addForm field
 * @returns
 */
var addFormField = function() {
	var rowCount = $('#detailTable tr').length;
	var id = rowCount - 2;
	counter = 0;
	while (counter < 40) {
		if ($('#row_detail' + id).length == 0) {
			break;
		} else {
			id++;
		}
		counter++;
	}
	rowField = appendRowField(id);	
	
	insertOptionRekening('ddl_korek'+id);
	$("#detailTable").append(rowField);
};

var appendRowField = function(id) {
	var rowField = 
		'<tr class="row" id="row_detail'+ id +'" >'+
			'<td>'+
				'<select name="ddl_korek[]" id="ddl_korek'+ id +'" class="inputbox mandatory" onchange="hitungSetoran();">' +
				'</select>'+
			'</td>'+
			'<td>'+
				'<input type="text" name="txt_dt_setoran[]" id="txt_dt_setoran'+ id +'" class="inputbox mandatory" size="16" style="font-weight: bold; font-size: 10px; text-align:right;" onKeypress = "return numbersonly(this, event)" ' +
				'onchange="hitungSetoran();" onblur="this.value=formatCurrency(this.value);" onfocus="this.value=unformatCurrency(this.value);" />'+
			'</td>'+
			'<td><a href="#" onClick="removeFormField(\'#row_detail' + id + '\');hitungSetoran();return false;">Hapus</a></td>'+
		'</tr>';
	
	return rowField;
};

/**
 * removeFormField tr
 * @returns
 */
var removeFormField = function(id) {
	var x=window.confirm('Anda yakin akan menghapus detail tersebut?');
	if (x)
		return $(id).remove();
	else
	return;
};

/**
 * onCompletePage
 * @returns
 */
var completePage = function() {
	addFormField();
	
	$('#btn_add_detail').click(function() {
		addFormField();
	});
	
	$('#btn_npwpd').click(function() {
		showDialog("wajib_pajak/get_wp_sptpd/" + $("input[name=kodus_id]").val(), 'Nomor Pokok Wajib Pajak/Retribusi', 1000, 500);
	});
	
	$("#tanggal_setor").datepicker({
		dateFormat: "dd-mm-yy",
		showOn: "both",
		constrainInput: true,
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		duration: "fast",
		maxDate: "D"
	});
	$('#tanggal_setor').datepicker('setDate', 'c');
	
	$("#tanggal_setor").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
};


/**
 * function to focus the input
 * @returns
 */
var focusInput = function() {
	$("#spt_periode").focus();
	
	var isShift = false;
	$(document).change(function(e){ if(e.which == 16) isShift=false; });
	
	$("input[type=text],input[type=radio],input[type=checkbox],select").keypress(function(e) {
		if(e.which == 16) isShift=true;
		if ((e.which==13 || e.which==9) && isShift == false) {
			if (this.name == "skpd_kode" ) { $('input[name=tanggal_setor]').focus(); return false;}
			else if (this.name == "tanggal_setor" ) $('input[name=txt_dari]').focus();
			else if (this.name == "txt_dari" ) $('input[name=txt_keterangan]').focus();
			
			else if (e.which==9) return true;
			return false;
		}
	});

	$("button,input,select,textarea").focus(function() {
		$(this).select();
	});
};

/**
 * createEventToolbar
 * @returns
 */
var createEventToolbar = function() {
	$('#btn_save').click(function() {
		var showInsertResponse = function (response, status) {
            if(response.status == true) {
            	showNotification(response.msg);
            	$("#frm_setoran_dinas").resetForm();
            } else {
            	showWarning(response.msg);
            }
		};
		
		var save_options = { 
			url : GLOBAL_SETORAN_DINAS_VARS["save"],
			type : "POST",
			dataType: 'json',
			beforeSubmit: jqform_validate,
			success: showInsertResponse
		};
		
		$("#frm_setoran_dinas").ajaxSubmit(save_options);
	});
	
	//button view list
	$("#btn_view").click(function() {
		//load content panel
		load_content(GLOBAL_SETORAN_DINAS_VARS["view"]);
	});
};

$(document).ready(function() {
	completePage();
	createEventToolbar();
	focusInput();
});