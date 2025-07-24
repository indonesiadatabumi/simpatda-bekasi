<?php
require "header.php";
require_once "koneksi.php";
require_once "input.php";

//mengubah standar encoding
// $content    = file_get_contents("php://input");
// $content    = utf8_encode($content);
// $data       = json_decode($content,TRUE);

$username = $data ['username'];
$fullname = $data ['fullname'];
$email = $data ['email'];
$get_password = $data ['password'];
$password = password_hash($get_password, PASSWORD_DEFAULT);
$created_at = date('Y-m-d');

// cek user
$query_cek_user = "SELECT user.id_user, user.username, user.fullname, user.email, user.created_at, user.password FROM user_pasar as user WHERE username= '$username' AND email = '$email'";
$result_cek_user = pg_query($connect, $query_cek_user);
$row_cek_user = pg_fetch_object($result_cek_user);
pg_free_result($result_cek_user);
if ($row_cek_user == null){ //apabila belum pernah daftar
    // get id_user
    $query_id_user = "SELECT MAX(id_user)+1 AS id_user FROM user_pasar";
    $result_id_user = pg_query($connect, $query_id_user);
    $row_id_user = pg_fetch_object($result_id_user);
    pg_free_result($result_id_user);
    if ($row_id_user->id_user == null) {
        $id_user = 1;
    }else{
        $id_user = intval($row_id_user->id_user);
    }
    // insert user
    $query_insert_user = "INSERT INTO user_pasar (id_user, username, fullname, email, password, created_at) VALUES($id_user, '$username', '$fullname', '$email', '$password', '$created_at')";
    $result_insert_user = pg_query($connect, $query_insert_user);
    pg_free_result($result_insert_user);

    $response = [
        'status' => 'sukses',
        'message' => 'Pendaftaran Berhasil'
    ];
}else {
    $response = [
        'status' => 'Gagal',
        'message' => 'Username / email sudah terdaftar'
    ];
}

echo json_encode($response);