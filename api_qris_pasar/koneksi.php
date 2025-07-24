<?php
$hostname = "192.168.1.6";
$database = "DBSIMPATDA";
$username = "postgres";
$password = "Bapenda2021";
$port     =  "5432";
$connect = pg_connect("host=$hostname port=$port dbname=$database user='$username'
password='$password'");
// script cek koneksi   
if (!$connect) {
    die("Koneksi Tidak Berhasil");
}