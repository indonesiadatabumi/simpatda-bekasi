<?php
require_once "header.php";
require_once "koneksi.php";
require_once "input.php";
require_once "fungsi.php";

//mengubah standar encoding
// $content    = file_get_contents("php://input");
// $content    = utf8_encode($content);
// $data       = json_decode($content,TRUE);
if (!$data) {
    inquiry_wp_log("Invalid JSON Body", 'ERROR');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON body'
    ]);
    exit;
}

if (empty($data['npwrd'])) {
    inquiry_wp_log("Missing field: npwrd. Request: " . json_encode($data), 'ERROR');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => "Field 'npwrd' wajib diisi"
    ]);
    exit;
}

$npwrd = $data['npwrd'];
$now = date('Y-m-d H:i:s');

$query = "SELECT reg.npwrd, reg.nm_wp_wr, reg.alamat_wp_wr, reg.kelurahan, reg.kecamatan, reg.kota FROM app_reg_wr as reg WHERE npwrd= '$npwrd'";
$result = pg_query($connect, $query);

if (!$result) {
    inquiry_wp_log("Sql cek data wp error: " . pg_last_error($connect), 'ERROR');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Sql cek data wp error'
    ]);
    exit;
}

$row = pg_fetch_object($result);
pg_free_result($result);
if ($row == null) {
    inquiry_wp_log("Wp Tidak Ditemukan. Received: " . json_encode($data), 'ERROR');
    $response = [
        'status' => 'Gagal',
        'data' => 'Wp Tidak Ditemukan'
    ];
} else {
    $query2 = "SELECT total_retribusi FROM app_nota_perhitungan_pasar WHERE npwrd= '$npwrd' ORDER BY fk_skrd DESC";
    $result2 = pg_query($connect, $query2);

    if (!$result2) {
        inquiry_wp_log("Sql cek data total retribusi error: " . pg_last_error($connect), 'ERROR');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Sql cek data total retribusi error'
        ]);
        exit;
    }

    $row2 = pg_fetch_object($result2);
    pg_free_result($result2);

    //insert table app_log_retribusi_pasar
    $query_log = "INSERT INTO app_log_retribusi_pasar (npwrd, nama_wp, alamat_wp, amount, created_time) VALUES ('$npwrd', '$row->nm_wp_wr', '$row->alamat_wp_wr', $row2->total_retribusi, '$now')";
    $result_log = pg_query($connect, $query_log);

    if (!$result_log) {
        inquiry_wp_log("Sql insert app log retribusi pasar error: " . pg_last_error($connect), 'ERROR');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Sql insert app log retribusi pasar error'
        ]);
        exit;
    }

    pg_free_result($result_log);

    $data = [
        'npwrd' => $row->npwrd,
        'nm_wp_wr' => $row->nm_wp_wr,
        'alamat_wp_wr' => $row->alamat_wp_wr,
        'kelurahan' => $row->kelurahan,
        'kecamatan' => $row->kecamatan,
        'kota' => $row->kota,
        'nominal_pengenaan' => $row2->total_retribusi
    ];
    inquiry_wp_log("Response: Sukses. Received: " . json_encode($data), 'INFO');
    $response = [
        'status' => 'Sukses',
        'data_wp' => $data,
    ];
}

pasar_log('REQUEST WP', $_SERVER['REQUEST_METHOD'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], json_encode($data), json_encode($response), http_response_code(), date('Y-m-d H:i:s'));
echo json_encode($response);
