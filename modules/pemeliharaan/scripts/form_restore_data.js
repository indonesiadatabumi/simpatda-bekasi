/**
 * document ready
 */
$(function() {
	$('#frm_restore_data').submit(function(e) {
		  e.preventDefault();
		  $.ajaxFileUpload({
		     url         	: GLOBAL_MAIN_VARS["BASE_URL"] + "pemeliharaan/restore_data/upload", 
			 fileElementId  : 'userfile',
			 dataType    	: 'json',
			 success  		: function (data, status)
			 {
				if (data.status == true) {
				$("#file_path").val(data.file_path);
				$("#total_spt").text(data.total_spt);
				$("#confirmation").slideDown("slow");
				if (data.total_spt > 0) {
					$("#btn_restore").show();
				} else {
					$("#btn_restore").hide();
					}
				}
				else {
					showWarning(data.msg);
				}
		     },
			error: function() {
				alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
			}
		  });
		  return false;
   });
	
	$("#btn_restore").click(function(){
		$.ajax({
            type:"POST",
            url: GLOBAL_MAIN_VARS["BASE_URL"]+"pemeliharaan/restore_data/restore/",
            async:false,
            dataType: "json",
            data: {
            	'file_path' : $("#file_path").val()
            },
            success:function(response){
                if(response.status == true){
                	showNotification(response.msg, 2000);
                }else {
                	showWarning(response.msg); 
                }
                 
                $("#file_path").val("");
				$("#total_spt").text("");
				$("#confirmation").slideUp("slow");
            },
			error: function() {
				alert("Terjadi error pada aplikasi. Silahkan menghubungi administrator");
			} 
		}); 
	});
	
	$("#btn_cancel").click(function(){
		$("#file_path").val("");
		$("#total_spt").text("");
		$("#confirmation").slideUp("fast");
	});
});