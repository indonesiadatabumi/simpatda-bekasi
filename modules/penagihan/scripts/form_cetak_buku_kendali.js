$("#trigger_rek").click(function(){
	showDialog("penagihan/dsp_ref_korek_GB", 'Daftar Kode Rekening', 1000, 500);
});
$("#f_date_c, #f_date_b, #f_date_a").datepicker({
	dateFormat: "dd-mm-yy",
	showOn: "both",
	constrainInput: true,
	buttonImage: "assets/images/calendar.gif",
	buttonImageOnly: true,
	duration: "fast",
	maxDate: "D"
});
$('#f_date_c, #f_date_b, #f_date_a').datepicker('setDate', 'c');

function submitbutton(pressbutton) {
	var form = document.adminForm;
	if (pressbutton == 'cancel') {
		submitform( pressbutton );
		return;
	}
	var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

	// do field validation
	if (form.spt_idwpwr.value == "") {
		alert( "Anda harus mengisi kolom NPWPD / NPWRD" );
	} else if (trim(form.spt_periode.value) == "") {
		alert( "Anda harus mengisi kolom Periode SPT" );
	} else if (form.spt_nomor.value == "") {
		alert( "Anda harus mengisi kolom Nomor SPT" );
	} else if (form.spt_kode_rek.value == "") {
		alert( "Anda harus mengisi kolom Kode Rekening" );
	} else if (form.spt_tgl_terima.value == "") {
		alert( "Anda harus mengisi kolom Tgl Diterima WP/WR" );
	} else if (form.spt_tgl_bts_kembali.value == "") {
		alert( "Anda harus mengisi kolom Tgl Batas Kembali" );
	} else {
		submitform( pressbutton );
	}
}

function gotocontact( id ) {
	var form = document.adminForm;
	form.contact_id.value = id;
	submitform( 'contact' );
}

function openChild(file,window) {
childWindow=open(file,window,'resizable=no,width=1000,height=700');
if (childWindow.opener == null) childWindow.opener = self;
}


function dateFormat(obj) {
	if (obj.value !="") {
	date = obj.value.replace(/\$|\-20/g,'').replace(/\$|\-/g,'');
	formated = date[0]+date[1]+'-'+date[2]+date[3]+'-20'+date[4]+date[5];

		$.ajax({
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
						if (obj.name == "masa1" || obj.name == "masa2") {
						ldmonth(obj);
						}
				}
			}
			});
	}
	else { formated=""; }
return;
}

function values (field) {
	var form = document.adminForm;
	if (field == "wp_wr_jenis2")
	form.wp_wr_jenis2.value = form.wp_wr_jenis.value;
	else if (field == "wp_wr_gol2")
	form.wp_wr_gol2.value = form.wp_wr_gol.value;
	else if (field == "wp_wr_no_urut2")
	form.wp_wr_no_urut2.value = form.wp_wr_no_urut.value;
	else if (field == "wp_wr_kd_camat2")
	form.wp_wr_kd_camat2.value = form.wp_wr_kd_camat.value;
	else if (field == "wp_wr_kd_lurah2")
	form.wp_wr_kd_lurah2.value = form.wp_wr_kd_lurah.value;

}

$(document).ready(function() {
$("input[type=text],input[type=radio],input[type=checkbox],select").enter2tab();
$('input[type!=hidden]:first').focus();
$("button,input,select,textarea").focus(function(){$(this).select();})
$('#korek').autotab({ target: 'korek_rincian', format: 'numeric' });
$('#korek_rincian').autotab({ target: 'korek_sub1', format: 'numeric', previous: 'korek' });
$('#korek_sub1').autotab({ format: 'numeric', previous: 'korek_rincian' });
});