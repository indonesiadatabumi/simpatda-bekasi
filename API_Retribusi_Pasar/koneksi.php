<?php
function printResponseTime() {
	$t1=$_SERVER['REQUEST_TIME'];
	$t2=time();
	$t3=abs($t2 - $t1);
	$t4=round($t3 / 60,2);
	echo "\nResponse In $t3 secs OR $t4 minute";
}
// register_shutdown_function("printResponseTime");
// Set the timezone to "Asia/Tokyo"
date_default_timezone_set('Asia/Jakarta');

// function exception_error_handler($errno, $errstr, $errfile, $errline ) {
//     throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
// }
// set_error_handler("exception_error_handler");
// $time_start = microtime(true);

$hostname = "192.168.1.6";
$database = "DBSIMPATDA";
$username = "postgres";
$password = "Bapenda2021";
$port     =  "5432";
$sConnect = "host=$hostname port=$port dbname=$database user='$username' password='$password'";
// echo $sConnect;
$connect = @pg_pconnect($sConnect);
// script cek koneksi   
if (!$connect) {
    die("Koneksi Tidak Berhasil");
}
// $time_end = microtime(true);
// $time = $time_end - $time_start;
// echo "Connection success in $time seconds\n";


// while(pg_connection_busy($connect)) {
//     pg_consume_input($connect);
//     usleep(10000);
// }
// try {
//     $conn=@pg_connect($sConnect);
//     if (!$connect) {
//         die("Koneksi Tidak Berhasil");
//     }
    
// } Catch (Exception $e) {
//     Echo $e->getMessage();
// }


