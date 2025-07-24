
/**
 * document ready
 */
$(document).ready(function() {
	
	$('#frm_upload_air_tanah').submit(function(e) {
		  e.preventDefault();
		  $.ajaxFileUpload({
		     url         	: GLOBAL_MAIN_VARS["BASE_URL"] + "pendataan/pajak_air_bawah_tanah/prepare_upload/?xid=0&_=0", 
			 fileElementId  : 'userfile',
			 dataType    	: 'json',
			 data			: {
				 'spt_jenis_pajakretribusi' : $("input[name=spt_jenis_pajakretribusi]").val(), 
				 'kodus_id' : $("input[name=kodus_id]").val(), 
				 'korek' : $("input[name=korek]").val()
			 },
			 success  		: function (data, status)
			 {
				 if (data.status == true) {
						$("#file_path").val(data.file_path);
						$("#total").text(data.total);
						$("#confirmation").slideDown("slow");
						if (data.total > 0) {
							$("#btn_approve").show();
						} else {
							$("#btn_approve").hide();
						}
				}
				else {
					showWarning(data.msg, 4000);
				}
		     },
			error: function() {
				alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
			}
		  });
		  return false;
	});
	
	$("#btn_approve").click(function(){
		$.ajax({
            type:"POST",
            url: GLOBAL_MAIN_VARS["BASE_URL"]+"pendataan/pajak_air_bawah_tanah/insert_upload/",
            async:false,
            dataType: "json",
            data: {
            	file_path : $("#file_path").val(),
            	spt_jenis_pajakretribusi : $("input[name=spt_jenis_pajakretribusi]").val(),
            	kodus_id : $("input[name=kodus_id]").val(),
            	korek : $("input[name=korek]").val()
            },
            success:function(response){
                if(response.status == true){
                	showNotification(response.msg, 3000);
                }else {
                	showWarning(response.msg, 3000); 
                }
                
                $("#file_path").val("");
				$("#total").text("");
				$("#confirmation").slideUp("slow");
            },
            error:function(){
            	alert("Upload fail connection: please contact your administrator");
            }  
		}); 
	});
	
	$("#btn_cancel").click(function(){
		$("#file_path").val("");
		$("#total").text("");
		$("#confirmation").slideUp("fast");
	});
});