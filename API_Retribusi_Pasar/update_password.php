<?php
require_once "header.php";
require_once "koneksi.php";
require_once "input.php";

$id_user = $data ['_id_user'];
$password_lama = $data ['password_lama'];
$password_baru = $data ['password_baru'];

// cek user
$query_cek_user = "SELECT users.password FROM user_pasar as users WHERE users.id_user= '$id_user'";
$result_cek_user = pg_query($connect, $query_cek_user);
$row_cek_user = pg_fetch_object($result_cek_user);
pg_free_result($result_cek_user);
if ($row_cek_user == null){
    $response = [
        'status' => 'gagal',
        'message' => 'Username belum terdaftar'
    ];
}else {
    if (password_verify($password_lama, $row_cek_user->password)){
        $password = password_hash($password_baru, PASSWORD_DEFAULT);
        $query_update_password = "UPDATE user_pasar as users SET users.password = '$password' WHERE users.id_user= '$id_user'";
        $result_update_password = pg_query($connect, $query_upadate_status_skrd);
        pg_free_result($result_update_password);
        $response = [
            'status' => 'sukses',
            'message' => 'Update Password Berhasil'
        ];
    }else{
        $response = [
            'status' => 'Gagal',
            'message' => 'Password tidak sesuai'
        ];
    }
}
echo json_encode($response);
// $time_end = microtime(true);
// $time = $time_end - $time_start;
// echo "Login success in $time seconds\n";