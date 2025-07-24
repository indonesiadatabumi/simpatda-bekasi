<?php
// $time_start = microtime(true);
require_once "header.php";
require_once "koneksi.php";
require_once "input.php";

//mengubah standar encoding
// $content    = file_get_contents("php://input");
// $content    = utf8_encode($content);
// $data       = json_decode($content,TRUE);

$username = $data ['username'];
$password = $data ['password'];

// cek user
$query_cek_user = "SELECT users.id_user, users.username, users.fullname, users.email, users.created_at, users.password FROM user_pasar as users WHERE users.username= '$username'";
$result_cek_user = pg_query($connect, $query_cek_user);
$row_cek_user = pg_fetch_object($result_cek_user);
pg_free_result($result_cek_user);
if ($row_cek_user == null){ //apabila belum pernah daftar
    $response = [
        'status' => 'gagal',
        'message' => 'Username belum terdaftar'
    ];
}else {
    if (password_verify($password, $row_cek_user->password)){
        $response = [
            'status' => 'sukses',
            'id_user' => $row_cek_user->id_user,
            'username' => $row_cek_user->username,
            'fullname' => $row_cek_user->fullname,
            'email' => $row_cek_user->email,
            'created_at' => $row_cek_user->created_at,
        ];
    }else{
        $response = [
            'status' => 'gagal',
            'message' => 'Password salah'
        ];
    }
}
echo json_encode($response);
// $time_end = microtime(true);
// $time = $time_end - $time_start;
// echo "Login success in $time seconds\n";