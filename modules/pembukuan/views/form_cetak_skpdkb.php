<?php
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=skpdkb_masapajak.xls");
header("Expires:0");
header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
header("Pragma: public");

//$host ="10.200.31.254";
$host = "localhost";
$user = "postgres";
$password = "admin";
$port ="5432";
$dbname = "DBSIMPATDA";
$link= pg_connect("host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$password) or die("Koneksi gagal");
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"> 
<head>
<title>SKPDKB</title>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252"> 
<meta name=ProgId content=Excel.Sheet> 
<meta name=Generator content="Microsoft Excel 10"> 
<style type="text/css">
body {font-family:Trebuchet MS; }
</style>
</head>

<body>
<div style="font-size:12px; text-align:center; font-weight:bold; width:1242px; ">DAFTAR REKAPITULASI SKPDKB DAN REALISASI  <?= $jenis_pajak;?> </div>
<div style="font-size:12px; text-align:center; font-weight:bold; width:1242px; ">MASA PAJAK <?php echo strtoupper(getNamaBulan($first_param))." ".$second_param;?></div>
<div style="height:10px; ">&nbsp;</div>
<table border="1">
<tbody>
	<tr style="font-size:12px; text-align:center; font-weight:bold; ">
		<td rowspan="2" style="width:40px; ">NO</td>
		<td colspan="3">WAJIB PAJAK</td>
		<td colspan="3">SKPDKB</td>
		<td colspan="3">STS</td>
		<td rowspan="2">TUNGGAKAN (Rp)</td>
	</tr>
	<tr style="font-size:12px; text-align:center; font-weight:bold; ">
		<td style="width:180px; ">NAMA WP</td>
		<td style="width:124px; ">NPWPD</td>
		<td style="width:250px; ">ALAMAT</td>
		<td style="width:75px; ">TANGGAL</td>
		<td style="width:60px; ">NOMOR</td>
		<td style="width:105px; ">KETETAPAN (Rp)</td>
		<td style="width:110px; ">NOMOR</td>
		<td style="width:80px; ">TANGGAL</td>
		<td style="width:110px; ">SETORAN (Rp)</td>
	</tr>
	<tr style="text-align:center; font-size:9px; font-weight:bold; ">
		<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td>
	</tr>
	<?php
	$no=1; $baris=7; $pajak=0; $setoran=0;
	if($camat_id==""){
		$qcamat="SELECT distinct wp_wr_kd_camat as camat_kode, wp_wr_camat as camat_nama FROM v_daftar_ketetapan_list 
				WHERE netapajrek_id_spt IS NOT NULL AND netapajrek_jenis_ketetapan='11' AND spt_jenis_pajakretribusi='".$jpajak."' 
				AND date_part('month',netapajrek_tgl)='$first_param' AND date_part('year',netapajrek_tgl)='$second_param'  
				";
	}else {
		$qcamat="SELECT distinct wp_wr_kd_camat as camat_kode, wp_wr_camat as camat_nama FROM v_daftar_ketetapan_list 
				WHERE netapajrek_id_spt IS NOT NULL AND netapajrek_jenis_ketetapan='11' AND spt_jenis_pajakretribusi='".$jpajak."' AND wp_wr_kd_camat='$camat_id' 
				AND date_part('month',netapajrek_tgl)='$first_param' AND date_part('year',netapajrek_tgl)='$second_param'  
				";
	}
	//echo $qcamat;
	//exit();
	$rcamat = pg_query($link, $qcamat);
	while($dtcamat = pg_fetch_assoc($rcamat)){
	$baris = $baris+1;
	?>
	<tr style="font-size:10px; font-weight:bold; ">
		<td></td>
		<td><?= $dtcamat['camat_nama'];?></td>
		<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
	</tr>
	
	<?php
		$where = "WHERE netapajrek_id_spt IS NOT NULL ";
		if ($jenis_pajak != null) 
			$where .= " AND spt_jenis_pajakretribusi='$jpajak'";
		
		if ($dtcamat['camat_kode'] != null)
			$where .= " AND wp_wr_kd_camat='".$dtcamat['camat_kode']."'";
			
		if ($first_param != null && $second_param != null)
			$where .= " AND EXTRACT(MONTH FROM netapajrek_tgl) = $first_param
					AND EXTRACT(YEAR FROM netapajrek_tgl) = $second_param";	
			
		if ($status_spt != null)
			$where .= " AND netapajrek_jenis_ketetapan='$status_spt'";
		
		$sql = "select * 
				from v_daftar_ketetapan_list 
				$where 
				order by netapajrek_kohir ASC";
		//echo "xxx".$sql;
		//exit();
		$result = pg_query($link, $sql);
		while($row=pg_fetch_assoc($result)){
	?>
	<tr style="font-size:10px; ">
		<td style="text-align:center; "><?= $no?></td>
		<td><?= $row['wp_wr_nama'];?></td>
		<td><?= $row['npwprd'];?></td>
		<td><?= $row['wp_wr_almt'];?></td>
		<td style="text-align:center; "><?= $row['netapajrek_tgl'];?></td>
		<td style="text-align:center; "><?php echo "'$row[spt_nomor]";?></td>
		<td style="text-align:right; "><?= number_format($row['spt_pajak'], 0, ",",".");?></td>
		<?php
		$q = "select setorpajret_no_bukti, setorpajret_tgl_bayar from v_setoran_pajak_retribusi 
				where ketspt_singkat='SKPDKB' and setorpajret_jenis_pajakretribusi='".$row['spt_jenis_pajakretribusi']."' and setorpajret_jenis_ketetapan=11 and setorpajret_id_wp='".$row['spt_idwpwr']."'
				and setorpajret_no_spt='".$row['spt_nomor']."' and setorpajret_spt_periode='".$row['spt_periode']."' order by setorpajret_id ";
		$r = pg_query($link, $q);
		$j = pg_num_rows($r);
		$rq=pg_fetch_assoc($r);
		if($j > 0){
			$qj = "select sum(setorpajret_dt_jumlah) as jml_bayar from v_setoran_pajak_retribusi 
				where ketspt_singkat='SKPDKB' and setorpajret_jenis_pajakretribusi='".$row['spt_jenis_pajakretribusi']."' and setorpajret_jenis_ketetapan=11 and setorpajret_id_wp='".$row['spt_idwpwr']."'
				and setorpajret_no_spt='".$row['spt_nomor']."' and setorpajret_spt_periode='".$row['spt_periode']."' ";
			$rj = pg_query($link, $qj);
			$jlh_bayar = pg_fetch_assoc($rj);
		}
			
		?>
		<td style="text-align:center; "><?= $rq['setorpajret_no_bukti']?></td>
		<td style="text-align:center; "><?= $rq['setorpajret_tgl_bayar']?></td>
		<td style="text-align:right; "><?= number_format($jlh_bayar['jml_bayar'], 0, ",",".");?></td>
		<?php //}?>
		<td><?php echo "=J$baris-G$baris";?></td>
	</tr>

	<?php
		$pajak = $pajak + $row['spt_pajak'];
		$setoran = $setoran + $jlh_bayar['jml_bayar'];
		$no++; $baris++;
		}
	}
	pg_free_result($result);
	 pg_close($link);
	$nobar = $baris - 1;
	?>
	<tr style="font-size:12px; text-align:center; font-weight:bold; ">
		<td></td>
		<td colspan="3" style="text-align:center; ">TOTAL</td>
		<td></td>
		<td></td>
		<td style="text-align:right; "><?= number_format($pajak, 0, ",", ".");?></td>
		<td></td>
		<td></td>
		<td style="text-align:right; "><?= number_format($setoran, 0, ",", ".");?></td>
		<td style="text-align:right; "><?php echo "=sum(K7:K$nobar)";?></td>
	</tr>
</tbody>
</table>
</body>
</html>