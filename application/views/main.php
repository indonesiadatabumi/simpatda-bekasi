<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>SIMPATDA - KOTA BEKASI</title>
  	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url();?>favicon.ico">
  	<link rel="stylesheet" media="all" type="text/css" href="assets/styles/jquery/jquery-ui.css" />
  	<link rel="stylesheet" media="all" type="text/css" href="assets/styles/jquery/jquery.cssmenu.css" />
	<link rel="stylesheet" href="assets/styles/jquery/jquery.autocomplete.css" type="text/css" />
	<link rel="stylesheet" href="assets/styles/templates/system/css/system.css" type="text/css" />
	<link rel="stylesheet" href="assets/styles/templates/khepri/css/template.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="assets/styles/templates/khepri/css/rounded.css" />
	<link rel="stylesheet" type="text/css" href="assets/styles/jquery/flexigrid.css">
	<link rel="stylesheet" href="assets/styles/greybox.css" type="text/css" />
	<!--[if IE 7]>
	<link href="assets/styles/templates/khepri/css/ie7.css" rel="stylesheet" type="text/css" />
	
	<style type="text/css">
		.jquerycssmenu{height: 1%;} /*Holly Hack for IE7 and below*/
	</style>
	<![endif]-->
	
	<!--[if lte IE 6]>
	<link href="assets/styles/templates/khepri/css/ie6.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	
	<script type="text/javascript" src="assets/scripts/jquery/jquery-1.8.2.js"></script>
  	<script type="text/javascript" src="assets/scripts/jquery/jquery-ui-1.9.0.custom.min.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/supersubs.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery.autotab.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery.hotkeys.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery-enter2tab.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery.maskedinput-1.2.2.min.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery.dateentry.min.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery.download.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery.numeric.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery.form.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery.autocomplete.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery.chainedSelects.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/flexigrid.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/ajaxfileupload.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/greybox/greybox.js"></script>
	<script type="text/javascript">
		var GLOBAL_SESSION_VARS = new Array ();
		GLOBAL_SESSION_VARS["USER_ID"] = "<?=$this->session->userdata('USER_ID');?>";
		GLOBAL_SESSION_VARS["USER_JABATAN"] = "<?=$this->session->userdata('USER_JABATAN');?>";
		GLOBAL_SESSION_VARS["USER_SPT_CODE"] = "<?=$this->session->userdata('USER_SPT_CODE');?>";
		
		GLOBAL_MAIN_VARS = new Array ();
		GLOBAL_MAIN_VARS["BASE_URL"] = "<?= base_url();?>";
		GLOBAL_MAIN_VARS["LIST_KECAMATAN"] = "<?= base_url();?>common/get_kecamatan";
		GLOBAL_MAIN_VARS["LIST_KELURAHAN"] = "<?= base_url();?>common/get_kelurahan";
		GLOBAL_MAIN_VARS["NEXT_NO_SPTPD"] = "<?= base_url();?>common/get_next_nomor_sptpd";
	</script>
	<script type="text/javascript" src="assets/scripts/private/main.js"></script>
	<script type="text/javascript" src="assets/scripts/jquery/jquery.cssmenu.js"></script>
</head>
<body id="minwidth">
	
	<?php $this->load->view("header"); ?>
	
	<div id="warning"></div>
	<div id="notification"></div>
	
	<!-- main-body -->
	<div id="content-box">
		<div class="border">
			<div class="padding">
				<div class="clr"></div>
				<div id="element-box">
					<div id="content_panel">
					<?php $this->load->view("home");?>
					</div>
				</div>
			<div class="clr"></div>
		</div>
	</div>

	<div id="border-bottom">
		<div>
			<div></div>
		</div>
	</div>
	<div id="footer">
		<!-- <p class="copyright">&copy;&nbsp;Copyright <a href="http://teknosoftmedia.com" target="_blank">PT. Mitra Prima Utama</a> <?php echo date("Y"); ?></p>  -->
	</div>
	<noscript>
		Warning! JavaScript must be enabled for proper operation of the Administrator Back-end 
	</noscript>
</body>
</html>