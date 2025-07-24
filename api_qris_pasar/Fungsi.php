<?php

class Fungsi
{
	function tanggal_lap($tanggal)
	{
		$bulan = array(
			1 => 'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$p = explode('/', $tanggal);
		return $p[2] . ' ' . $bulan[(int)$p[1]] . ' ' . $p[0];
	}

	function tanggalindo($tanggal)
	{
		$bulan = array(
			1 => 'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$p = explode('-', $tanggal);
		return $p[2] . ' ' . $bulan[(int)$p[1]] . ' ' . $p[0];
	}

	function tambah_nol($angka, $jumlah)
	{
		$jumlah_nol = strlen($angka);
		$angka_nol = $jumlah - $jumlah_nol;
		$nol = "";
		for ($i = 1; $i <= $angka_nol; $i++) {
			$nol .= '0';
		}
		return $nol . $angka;
	}

	function bulan($bulan)
	{
		switch ($bulan) {
			case 1:
				$bulan = "Januari";
				break;
			case 2:
				$bulan = "Februari";
				break;
			case 3:
				$bulan = "Maret";
				break;
			case 4:
				$bulan = "April";
				break;
			case 5:
				$bulan = "Mei";
				break;
			case 6:
				$bulan = "Juni";
				break;
			case 7:
				$bulan = "Juli";
				break;
			case 8:
				$bulan = "Agustus";
				break;
			case 9:
				$bulan = "September";
				break;
			case 10:
				$bulan = "Oktober";
				break;
			case 11:
				$bulan = "November";
				break;
			case 12:
				$bulan = "Desember";
				break;
		}
		return $bulan;
	}

	function get_headers_from_curl_response($headerContent)
	{

		$headers = array();

		// Split the string on every "double" new line.
		$arrRequests = explode("\r\n\r\n", $headerContent);

		// Loop of response headers. The "count() -1" is to 
		//avoid an empty row for the extra line break before the body of the response.
		for ($index = 0; $index < count($arrRequests) -1; $index++) {

			foreach (explode("\r\n", $arrRequests[$index]) as $i => $line)
			{
				if ($i === 0)
					$headers[$index]['http_code'] = $line;
				else
				{
					list ($key, $value) = explode(': ', $line);
					$headers[$index][$key] = $value;
				}
			}
		}

		return $headers;
	}

	function token_fintech($data_token){
		$url = 'http://10.31.224.39:8080/mobile-webconsole/apps/pocket/requestTokenFintech/';
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, 1);
	
		$headers = array(
		"Accept: application/json", 
		"Content-Type: application/json",
		"Access-Control-Allow-Methods: POST",
		);
	
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_token);
	
		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
		$resp = curl_exec($curl);
		// Retudn headers seperatly from the Response Body
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$header = substr($resp, 0, $header_size);
		$body = substr($resp, $header_size);

		curl_close($curl);
		// var_dump($resp);
		return $header;
	}

	function getQris($token_fintech, $data_qris){
		$url = 'http://10.31.224.39:8080/mobile-webconsole/apps/4/pbTransactionAdapter/createInvoiceQRISDinamisExt';
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
		$headers = array(
		"Accept: application/json", 
		"Content-Type: application/json",
		"X-AUTH-TOKEN: $token_fintech",
		"Access-Control-Allow-Methods: POST",
		);
	
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_qris);
	
		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
		$resp = curl_exec($curl);
		curl_close($curl);
		// var_dump($resp);
		return json_decode($resp);
	}
}