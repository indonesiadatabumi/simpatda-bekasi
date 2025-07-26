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
    log_error("Invalid JSON Body", 'ERROR');
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON body'
    ]);
    exit;
}

$required_fields = ['npwrd', 'amount', '_id_user'];

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

$npwrd = $data['npwrd'];
$amount = $data['amount'];
$id_user = $data['_id_user'];
$date = date('Y-m-d');
$timestamp = date('Y-m-d H:i:s');
$bln_retribusi = intval(date('m'));
$thn_retribusi = date('Y');

$query = "SELECT a.nm_wp_wr, a.alamat_wp_wr, a.kelurahan, a.kecamatan, a.kota, a.kd_rekening, b.jenis_retribusi, b.dasar_hukum_pengenaan FROM app_reg_wr AS a 
        LEFT JOIN app_ref_jenis_retribusi AS b ON a.kd_rekening=b.kd_rekening 
        WHERE a.npwrd= '$npwrd'";
$result = pg_query($connect, $query);

if (!$result) {
    log_error("Sql cek data wp error: " . pg_last_error($connect), 'ERROR');
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
    $response = [
        'status' => 'Gagal',
        'data' => 'Wp Tidak Ditemukan'
    ];
} else {
    // cek generate qris
    $query_cek_qris = "SELECT * FROM app_qris_retribusi
            WHERE npwrd= '$npwrd' AND create_date = '$date'";
    $result_cek_qris = pg_query($connect, $query_cek_qris);
    $row_cek_qris = pg_fetch_object($result_cek_qris);
    pg_free_result($result_cek_qris);

    if ($row_cek_qris == null) { //apabila belum pernah generate qris

        // cek user
        $query_cek_user = "SELECT id_user FROM app_qris_retribusi
                            WHERE npwrd= '$npwrd' ";
        $result_cek_user = pg_query($connect, $query_cek_user);
        $row_cek_user = pg_fetch_object($result_cek_user);
        pg_free_result($result_cek_user);

        if (!empty($row_cek_user->$id_user) && $id_user != $row_cek_user->id_user) { //jika login user tidak sesuai
            $response = [
                'status' => 'Gagal',
                'data' => 'id user tidak sesuai',
            ];
        } else {
            $data_request = [
                'amount' => $amount,
                'id_user' => $id_user
            ];
            $data_request = json_encode($data_request);
            $qris = getQris($data_request);

            if ($qris->qris == null) {
                $response = [
                    'status' => 'Gagal',
                    'message' => 'Create QRIS Gagal',
                ];
            } else {
                switch ($id_user) {
                    case '1':
                        $kd_pasar = '101';
                        break;

                    case '2':
                        $kd_pasar = '102';
                        break;
                    case '3':
                        $kd_pasar = '103';
                        break;
                    case '4':
                        $kd_pasar = '104';
                        break;
                    case '5':
                        $kd_pasar = '105';
                        break;
                }
                $kd_billing = $kd_pasar . date('YmdHis') . rand(0, 999);
                $wp_wr_nama = $row->nm_wp_wr;
                $wp_wr_alamat = $row->alamat_wp_wr;
                $wp_wr_lurah = $row->kelurahan;
                $wp_wr_camat = $row->kecamatan;
                $wp_wr_kabupaten = $row->kota;
                $kd_rekening = $row->kd_rekening;
                $nm_rekening = $row->jenis_retribusi;
                $dasar_pengenaan = $row->dasar_hukum_pengenaan;
                $total_retribusi = intval($amount);
                $expired_date = date('Y-m-d', strtotime('+1 days', strtotime($date)));

                // get nomor skrd & nota perhitungan
                $query_no_skrd = "SELECT MAX(no_skrd)+1 AS no_skrd FROM app_skrd_pasar WHERE thn_retribusi = '$thn_retribusi'";
                $result_no_skrd = pg_query($connect, $query_no_skrd);
                $row_no_skrd = pg_fetch_object($result_no_skrd);
                pg_free_result($result_no_skrd);
                if ($row_no_skrd->no_skrd == null) {
                    $no_skrd = 1;
                } else {
                    $no_skrd = intval($row_no_skrd->no_skrd);
                }

                // insert table app_skrd_pasar
                $query_app_skrd_pasar = "INSERT INTO app_skrd_pasar (no_skrd, bln_retribusi, thn_retribusi, tipe_retribusi, kd_billing, npwrd, wp_wr_nama, wp_wr_alamat, wp_wr_lurah, wp_wr_camat, wp_wr_kabupaten, kd_rekening, nm_rekening, user_input, tgl_input, tgl_skrd, tgl_penetapan, status_ketetapan, status_bayar, status_lunas) VALUES ($no_skrd, $bln_retribusi, '$thn_retribusi', '1', '$kd_billing', '$npwrd', '$wp_wr_nama', '$wp_wr_alamat', '$wp_wr_lurah', '$wp_wr_camat', '$wp_wr_kabupaten', '$kd_rekening', '$nm_rekening', 'admin', '$timestamp', '$date', '$date', '1', '0', '0')";
                $result_app_skrd_pasar = pg_query($connect, $query_app_skrd_pasar);
                pg_free_result($result_app_skrd_pasar);

                // get id skrd
                $query_id_skrd = "SELECT MAX(id_skrd) AS id_skrd FROM app_skrd_pasar";
                $result_id_skrd = pg_query($connect, $query_id_skrd);
                $row_id_skrd = pg_fetch_object($result_id_skrd);
                $id_skrd = intval($row_id_skrd->id_skrd);
                pg_free_result($result_id_skrd);

                // insert table nota_perhitungan_pasar
                $query_app_nota_perhitungan_pasar = "INSERT INTO app_nota_perhitungan_pasar (npwrd, no_nota_perhitungan, bln_retribusi, thn_retribusi, kd_rekening, nm_rekening, dasar_pengenaan, jenis_ketetapan, keterangan, jenis_bangunan, tipe_bangunan, total_retribusi, imb, fk_skrd) VALUES ('$npwrd', $no_skrd, $bln_retribusi, '$thn_retribusi', '$kd_rekening', '$nm_rekening', '$dasar_pengenaan', 'SKRD', '', '', '', $total_retribusi, '', $id_skrd)";
                $result_app_nota_perhitungan_pasar = pg_query($connect, $query_app_nota_perhitungan_pasar);
                pg_free_result($result_app_nota_perhitungan_pasar);

                if (!$result_app_skrd_pasar && !$result_app_nota_perhitungan_pasar) {
                    $response = [
                        'status' => 'Gagal',
                        'data' => 'Insert tabel app skrd pasar dan nota perhitungan pasar gagal'
                    ];
                } else {
                    // insert table app_qris_retribusi
                    $query_app_qris_retribusi = "INSERT INTO app_qris_retribusi (kode_billing, amount, status_bayar, create_date, barcode, invoice_id, npwrd, transaction_date, id_user, expired_date) VALUES ('$kd_billing', $total_retribusi, '0', '$date', '$qris->qris', '$qris->invoice_id', '$npwrd', null, '$id_user', '$expired_date')";
                    $result_app_qris_retribusi = pg_query($connect, $query_app_qris_retribusi);
                    pg_free_result($result_app_qris_retribusi);

                    //insert table qris_va_spt
                    $query_qris_va_spt = "INSERT INTO qris_va_spt (va_number, kode_billing, tahun, jns_pajak, jns_billing, amount, create_date, client_refnum, transaction_date, status, barcode, expired_date, invoice_id)
                    VALUES (null, '$kd_billing', '$thn_retribusi', 'Retribusi Pasar', 'QRIS', '$total_retribusi', '$date', null, null, '0', '$qris->qris', '$expired_date', '$qris->invoice_id')";
                    $result_qris_va_spt = pg_query($connect, $query_qris_va_spt);
                    pg_free_result($result_qris_va_spt);

                    $response = [
                        'status' => 'Sukses',
                        'qris' => $qris->qris,
                    ];
                }
            }
        }
    } else {
        $response = [
            'status' => 'Sukses',
            'qris' => $row_cek_qris->barcode,
        ];
    }
}

pasar_log('REQUEST QRIS', $_SERVER['REQUEST_METHOD'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], json_encode($data), json_encode($response), http_response_code(), date('Y-m-d H:i:s'));
echo json_encode($response);
