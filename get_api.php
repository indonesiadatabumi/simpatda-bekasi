<html>
    <body>
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    Friend ID
                </td>
                <td>
                    First Name
                </td>
                <td>
                    Surname
                </td>
                <td>
                    Email Address
                </td>
            </tr>
        <?php
	$sql = "SELECT SUM(a.setorpajret_dt_jumlah) AS TOTAL, 
						b.ref_jenparet_id AS JENIS_PAJAK_ID, 
						b.ref_jenparet_ket AS JENIS_PAJAK_NAME, 
						to_char(a.setorpajret_tgl_bayar, 'YYYY') AS TAHUN, 
						to_char(a.setorpajret_tgl_bayar, 'MM') AS BULAN
						FROM v_rekapitulasi_penerimaan_detail a
						JOIN ref_jenis_pajak_retribusi b ON b.ref_jenparet_id = a.setorpajret_jenis_pajakretribusi 
						GROUP BY b.ref_jenparet_id, to_char(a.setorpajret_tgl_bayar, 'YYYY'), to_char(a.setorpajret_tgl_bayar, 'MM') ORDER BY TAHUN, BULAN, JENIS_PAJAK_ID";
$pdo = new PDO('pgsql:dbname=DBSIMPATDA;host=localhost;user=postgres;password=admin');
if ($con = $pdo->prepare($sql)) {
    $con->execute([
        ':name'=>'Pasta'
    ]);
    $r = $con->fetch(PDO::FETCH_ASSOC);
    if(!empty($r)){
        echo $r['TOTAL'];
        echo $r['BULAN'];
    }
}

        ?>
        </table>
    </body>
</html> 