
var insertNomorBukti = function(idSelect) {
	$.get(GLOBAL_SETOR_BANK_VARS["get_penyetoran"], { tgl_penyetoran : $("#tgl_penyetoran").val(), spt_jenis_pajakretribusi : $("#spt_jenis_pajakretribusi").val() }, 
			function(data){
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
 * addForm field
 * @returns
 */
var addFormField = function() {
	var rowCount = $('#detailTable tr').length;
	var id = rowCount - 1;
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
	
	insertNomorBukti('setorpajret_id'+id);
	$("#detailTable").append(rowField);
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
 * check nomor bukti is exist
 * @param n
 * @returns
 */
var checkNomorBukti = function(id) {
	var i = $('#detailTable tr').length - 2;
	for (k=0; k<=i; k++) {
		try {
			if ($('#setorpajret_id'+k).val() == $('#setorpajret_id'+id).val() && k != id) {
				showWarning('Nomor bukti sama sudah terpilih. Mohon pilih nomor bukti lainnya!');
				$('#setorpajret_id'+id).val('');
				$('#setorpajret_id'+id).focus();
			}
		} catch (ex) {
		}
	}
};

var getPenyetoran = function(id, value) {
	try {
		var arr_value = value.split("|");
		$("#skbd_jumlah"+id).val(formatCurrency(arr_value[2]));
	} catch (err) {
		$("#skbd_jumlah"+id).val(formatCurrency(0));
	}
	
	calcTotal();
};

var appendRowField = function(id) {
	var rowField = 
		'<tr class="row0" id="row_detail'+ id +'" >'+
        '<td align="center"><a href="#" onClick="removeFormField(\'#row_detail' + id + '\');calcTotal();return false;">Hapus</a></td>'+
        '<td>'+
			'<select name="setorpajret_id[]" id="setorpajret_id'+ id +'" class="inputbox mandatory" style="width: 100px" ' +
				'onchange=" checkNomorBukti('+ id +'); getPenyetoran('+ id +',this.value);calcTotal();" onblur="calcTotal();">' +
			'</select>'+
		'</td>'+
        '<td align="right">'+
        '<input type="text" name="skbd_jumlah[]" id="skbd_jumlah'+ id +'" class="inputbox mandatory" size="20" value="" readonly="readonly" style="text-align:right;font-size:12px;" onblur="calcTotal();this.value=formatCurrency(this.value,this.id);" onfocus="this.value=unformatCurrency(this.value);"/>'+
        '</td>'+
        '</tr>';
	
	return rowField;
};

/**
 * to calculate
 * @returns
 */
var calcTotal = function() {
	var totalPajak=0;
	var i=0;
	$('#totalSetorBank').val("");
	var rowCount = $('#detailTable tr').length;
	while ( i <= rowCount) {
		try {
			totalPajak += unformatCurrency($("#skbd_jumlah"+i).val()) * 1;
		} catch (ex) { }
		i++;
	}
	
	$('#totalSetorBank').val(formatCurrency(totalPajak));
};

var completePage = function() {	
	$('#btn_add_detail').click(function() {
		addFormField();
	});
	
	$("#btn_print").hide();
	
	var dates = $("#tgl_penyetoran").datepicker({
   	   	dateFormat: "dd-mm-yy",
   	 	showOn: "both",
		buttonImage: "assets/images/calendar.gif",
		buttonImageOnly: true,
		constrainInput: true,
		duration: "fast",
		beforeShow: function(){
			$("#ui-datepicker-div").css("zIndex", 99999);
			
			if ( $.browser.msie && $.browser.version == "6.0") {
				setTimeout(function() {
					$('#ui-datepicker-div').css('position', "absolute");
					$('#ui-datepicker-div').bgiframe();
				}, 10);
			}
		}
   	});
	
	$('#tgl_penyetoran').datepicker('setDate', 'c');
	
	$("#tgl_penyetoran").change(function() {
		isValidDate(this.id, "dd-mm-yy");
	});
	
	$("#spt_jenis_pajakretribusi").change(function() {
		var i = $('#detailTable tr').length;
		for (k=0; k <= i; k++) {
			try {
				$('#row_detail'+k).remove();
			} catch (ex) {
			}
		}
		calcTotal();
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
            	$("#btn_print").show();
            	$("#frm_add_setor_bank").resetForm();
            	$("input[name=id]").val(response.id);
            	shownotification("Data berhasil disimpan.");
            } else {
            	showWarning(response.msg);
            }
		};
		
		var save_options = { 
			url : GLOBAL_SETOR_BANK_VARS["insert"],
			type : "POST",
			dataType: 'json',
			beforeSubmit: jqform_validate,
			success: showInsertResponse
		};
		
		$("#frm_add_setor_bank").ajaxSubmit(save_options);
	});
	
	//button print click
	$("#btn_print").click(function() {
		url = GLOBAL_SETOR_BANK_VARS["print"] + "?skbh_id=" + $("input[name=id]").val();
		var html = '<iframe id="sspd" class="pdf" src="' + url + '" width="100%" height="100%" scrollbar="yes" marginwidth="0" marginheight="0" hspace="0" align="middle" frameborder="0" scrolling="yes" style="width:100%; border:0;  height:100%; overflow:auto;"></iframe>';
		var w = window.open(url);
		w.document.writeln(html);
		w.document.close();
		
		return false;
	});
	
	//button view list
	$("#btn_view").click(function() {
		//load content panel
		load_content(GLOBAL_PAJAK_PARKIR_VARS["view_sptpd"]);
	});
};

$(document).ready(function() {
	completePage();
	createEventToolbar();
});