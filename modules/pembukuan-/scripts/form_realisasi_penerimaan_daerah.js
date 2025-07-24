$("#f_date_c, #f_date_a").datepicker({
	dateFormat: "dd-mm-yy",
	showOn: "both",
	constrainInput: true,
	buttonImage: "assets/images/calendar.gif",
	buttonImageOnly: true,
	duration: "fast",
	maxDate: "D"
});
$('#f_date_c, #f_date_a').datepicker('setDate', 'c');

function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");
	// do field validation
	if (trim(form.spt_periode.value) == "") {
		alert( "Anda harus mengisi kolom Periode SPT" );
	} else if (form.spt_nomor1.value == "" || form.spt_nomor2.value == "") {
		alert( "Anda harus mengisi kolom Nomor SPT" );
	} else if (form.netapajrek_tgl.value == "") {
		alert( "Anda harus mengisi Tanggal Penetapan" );
	} else {
		submitform( pressbutton );
	}
}

function openChild(file,window) {
	childWindow=open(file,window,'resizable=no,width=1000,height=700');
	if (childWindow.opener == null) childWindow.opener = self;
}

function klik () {
	var form = document.adminForm;
	form.submit();
}

function dateFormat(obj) {
	if (obj.value !="") {
	date = obj.value.replace(/\$|\-20/g,'').replace(/\$|\-/g,'');
	formated = date[0]+date[1]+'-'+date[2]+date[3]+'-20'+date[4]+date[5];
	$ajax({
		type : "POST",
		url : "index.php?action=m.qry_get_reklame_values_ajax_jq",
		data : "string="+ formated,
		beforeSend: function(){
		//jQuery('#date_string').html('<div align="center"><img src="images/loading.gif"  border="0"/></div>');
		},
		success: function(msg){
			if (msg.length > 0) {
				if (msg == 0) {
					alert ("Tanggal Salah");
					$('#'+obj.id).attr('value','');
					$('#'+obj.id).attr('value','');
					$('#'+obj.id).focus();
				} else {
					$('#'+obj.id).attr('value',formated);
				}
			}
		}
	});
	}
	else { 
		formated=""; 
	}
return;
}