<?php
// $time_start = microtime(true);
require_once "header.php";
require_once "koneksi.php";
require_once "input.php";
require_once "fungsi.php";

//mengubah standar encoding
// $content    = file_get_contents("php://input");
// $content    = utf8_encode($content);
// $data       = json_decode($content,TRUE);
if (!$data) {
    log_error("Invalid JSON Body", 'ERROR');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON body'
    ]);
    exit;
}

$required_fields = ['username', 'password'];

foreach ($required_fields as $field) {
    if (empty($data[$field])) {
        log_error("Missing field: $field. Request: " . json_encode($data), 'ERROR');
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => "Field '$field' wajib diisi"
        ]);
        exit;
    }
}

$username = $data['username'];
$password = $data['password'];

// cek user
$query_cek_user = "SELECT users.id_user, users.username, users.fullname, users.email, users.created_at, users.password FROM user_pasar as users WHERE users.username= '$username'";
$result_cek_user = pg_query($connect, $query_cek_user);

if (!$result_cek_user) {
    log_error("Sql cek data user error: " . pg_last_error($connect), 'ERROR');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Sql cek data user error'
    ]);
    exit;
}

$row_cek_user = pg_fetch_object($result_cek_user);
pg_free_result($result_cek_user);

if ($row_cek_user == null) { //apabila belum pernah daftar
    $response = [
        'status' => 'gagal',
        'message' => 'Username belum terdaftar'
    ];
} else {
    if (password_verify($password, $row_cek_user->password)) {
        $response = [
            'status' => 'sukses',
            'id_user' => $row_cek_user->id_user,
            'username' => $row_cek_user->username,
            'fullname' => $row_cek_user->fullname,
            'email' => $row_cek_user->email,
            'created_at' => $row_cek_user->created_at,
        ];
    } else {
        $response = [
            'status' => 'gagal',
            'message' => 'Password salah'
        ];
    }
}

pasar_log('LOGIN USER', $_SERVER['REQUEST_METHOD'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], json_encode($data), json_encode($response), http_response_code(), date('Y-m-d H:i:s'));
echo json_encode($response);
// $time_end = microtime(true);
// $time = $time_end - $time_start;
// echo "Login success in $time seconds\n";