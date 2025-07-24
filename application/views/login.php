<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/loose.dtd" >
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>SIMPATDA - KOTA BEKASI</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
  	<link rel="stylesheet" media="all" type="text/css" href="assets/styles/jquery/jquery-ui.css" />
	<link rel="stylesheet" href="assets/styles/templates/system/css/system.css" type="text/css" />
	<link rel="stylesheet" href="assets/styles/templates/khepri/css/template.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="assets/styles/templates/khepri/css/rounded.css" />
	<!--[if IE 7]>
	<link href="assets/styles/templates/khepri/css/ie7.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	
	<!--[if lte IE 6]>
	<link href="assets/styles/templates/khepri/css/ie6.css" rel="stylesheet" type="text/css" />
	<![endif]-->

  	<script type="text/javascript" src="assets/scripts/jquery/jquery-1.8.2.js"></script>
  	<script type="text/javascript" src="assets/scripts/jquery/cmxforms.js"></script>
  	<script type="text/javascript" src="assets/scripts/jquery/jquery.metadata.js"></script>
</head>
<body>

<style>
#judul {
	font-family:"Algerian";
	font-weight:bold;
	font-size:300%;
	color:#00000;
}
#loginform {
	background:url(assets/images/login/form_login_04.jpg) no-repeat;
	padding:3px 0px;
	color:#fff;
	text-align:left;
}
#loginform table {
	margin: 5px;
}
input.butlogin {
	background:url(assets/images/login/form_login_06.gif) no-repeat;
	width:96px;
	height:27px;
	border:none;
}
input.butlogin:hover {
	background:url(assets/images/login/form_login_06-over.gif) no-repeat;
}
input#username,input#password {
	font-size:11px;
	margin:2px 0px 3px 0px;
	border:1px inset #C7AC6F;
	width:150px;
}
input#username:focus,input#password:focus {
	/*background-color:#ECE1B1;*/
	background-color:#E0EAEF;
}
#footer {
	font-family:"Algerian";
	font-weight:bold;
	font-size:500%;
	color:#00000;
}

img {margin:0; padding:0;}

</style>
<div id="warning" class="ui-corner-all" style="width: 255px;">
	<span class="text"></span>
</div>
				
<p>&nbsp;</p><p>&nbsp;</p>
<form name="form_login" id="form_login" method="post" onsubmit="return false;">
<div id="formlogin" width="500" align="center">
<div id="judul">SIMPATDA</div>
<p>
<table id="Table_01" width="482" border="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse: collapse;">
	<tr>
		<td style="background-image: url(assets/images/login/form_login_01.jpg); width: 247px; height: 148px;"></td>
		<td style="background-image: url(assets/images/login/form_login_02.jpg); width: 235px; height: 148px"></td>
	</tr>
	<tr>
		<td style="background-image: url(assets/images/login/form_login_03.jpg); width: 247px; height: 133px;"></td>
		<td style="width: 235px; background:url(assets/images/login/form_login_04.jpg) no-repeat; padding:3px 10px;">
			<table style="height: 100%;">
				<tr>
					<td>
						<font color="#00587F" size="2" face="Tahoma, Arial, Helvetica, sans-serif"><strong>Username</strong></font><br />
						<input name="user_name" id="username" type="text" class="form" size="15" autocomplete="off" />
					</td>
				</tr>
				<tr>
					<td>
						<font color="#00587F" size="2" face="Tahoma, Arial, Helvetica, sans-serif"><strong>Password</strong></font><br />
						<input name="pswd" id="password" type="password" class="form" size="15" />
					</td>
				</tr>
				<tr>
					<td><input type="submit" class="butlogin" name="login" id="login" value="" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img id="form_login_05" src="assets/images/login/form_login_05.jpg" width="247" height="125" alt="" /></td>
		<td><img id="form_login_06" src="assets/images/login/form_login_06.jpg" width="235" height="125" alt="" /></td>
	</tr>
</table>
</div>
<div id="footer">
		<p class="copyright">
		<p align="center">

			BADAN PENDAPATAN DAERAH KOTA BEKASI
		</p>
		<div style="display:none">

        <a href="https://pinarakpedia.my.id/"></a>
        <a href="https://gudanginformatika.com/"></a>

</div>
		
	</div>
<div style="margin-left:200px; margin-right:10px; "><marquee behavior="slide" width="90%" scrolldelay="100" style="color:#00ff00; font-weight:bold; font-size:22px;" onmouseover="this.stop();" onmouseout="this.start();"> 
>> PENYALAHGUNAAN USER MENJADI TANGGUNGJAWAB PEMILIK USER, UNTUK KEAMANAN GANTI PASSWORD SECARA BERKALA. << </marquee></div>	

	
</form>
<script type="text/javascript">
	var GLOBAL_MAIN_VARS = new Array ();
	GLOBAL_MAIN_VARS["BASE_URL"] = "<?=base_url();?>";
</script>
<script type="text/javascript" src="<?=base_url();?>assets/scripts/private/login.js"></script>	
<body bgcolor="#3399CC">
</body>
</html>