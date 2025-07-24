<?php
require_once "header.php";
require_once "koneksi.php";
require_once "input.php";
require_once "fungsi.php";

$qris_id = $data ['qris_id'];
$_id_user = $data ['_id_user'];

$dataMsisdn = getPhoneNo($_id_user);
$chekcStatusQris = checkBayar($qris_id, $dataMsisdn['msisdn']);

// $jsonCheckStatus = json_decode($chekcStatusQris);

$arrResponse = array();
$arrResponse['status'] = $chekcStatusQris->STATUS;
$arrResponse['message'] = $chekcStatusQris->CODE;
$arrResponse['data'] = $chekcStatusQris->MSG;

echo json_encode($arrResponse, JSON_UNESCAPED_SLASHES);