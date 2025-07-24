<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Common Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Martz
 */

// ------------------------------------------------------------------------
if ( ! function_exists('format_tgl'))
{	
	function format_tgl ($tgl, $with_time=false, $char_bulan=false, $period=false) {
		$arr_bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$arr_bulan_num = array("01","02","03","04","05","06","07","08","09","10","11","12");
	
		if ($with_time) {
			list($tgl,$time) = explode(" ",$tgl);
		}
	
		if (!empty($tgl) && $tgl != null) {
			$arr_tgl = explode("-",$tgl);
			if (!$char_bulan)
				$tgl = $arr_tgl[2]."-".$arr_tgl[1]."-".$arr_tgl[0];
			else {
				foreach ($arr_bulan as $k => $v) {
					if ($arr_bulan_num[$k] == $arr_tgl[1])
					$arr_tgl[1] = $v;
				}
				if(!$period)
					$tgl = $arr_tgl[0]." ".$arr_tgl[1]." ".$arr_tgl[2];
				else
					$tgl = $arr_tgl[1]." ".$arr_tgl[2];
			}
		}
	
		if ($with_time) {
			$tgl = $tgl." ".$time;
		}
	
		return $tgl;
	}
}

/**
 * Format Currency function
 */
if (! function_exists('format_currency')) {
	function format_currency($value) {
		if (!empty($value))
			return number_format($value, 2, ',', '.');
		else 
			return "0,00";
	}
}

/**
 * Format Currency function
 */
if (! function_exists('format_currency_no_comma')) {
	function format_currency_no_comma($value) {
		if (!empty($value))
			return number_format($value, 0, ',', '.');
		else 
			return "0";
	}
}

/**
 * Unformat Currency function
 */
if (! function_exists('unformat_currency')) {
	function unformat_currency($value) {
		if (empty($value))
			return 0;
			
		$arr_val = explode(',', $value);
		return str_replace('.', '', $arr_val[0]);
	}
}

/**
 * get month
 */
if (!function_exists('get_month')) {
	function get_month() {
		$arr_month = array(
						'1' => 'Januari',
						'2' => 'Februari',
						'3' => 'Maret',
						'4' => 'April',
						'5' => 'Mei',
						'6' => 'Juni',
						'7' => 'Juli',
						'8' => 'Agustus',
						'9' => 'September',
						'10' => 'Oktober',
						'11' => 'November',
						'12' => 'Desember'
					);
					
		return $arr_month;
	}
}

/**
 * format_angka
 */	
if ( ! function_exists('format_angka'))
{
	function format_angka($len,$nomor) {
		if (!empty($nomor) && $nomor < 99999 ) {
			if (strlen($nomor) < $len)  {
				$selisih = $len - strlen($nomor);

				for ($i=1;$i<=$selisih;$i++) {
					$nomor = "0".$nomor;
				}
			}
		}
		
		return $nomor;
	}
}

if (!function_exists('format_romawi')) 
{
	function format_romawi($n) {
		$hasil = '';
		$iromawi = array(0 => '', 1 => 'I', 2 =>'II', 3 => 'III', 4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9 => 'IX', 10 =>'X',
						20=>'XX',30=>'XXX',40=>'XL',50=>'L',60=>'LX',70=>'LXX',80=>'LXXX',
						90=>'XC',100=>'C',200=>'CC',300=>'CCC',400=>'CD',500=>'D',
						600=>'DC',700=>'DCC',800=>'DCCC',900=>'CM',1000=>'M',
						2000=>'MM',3000=>'MMM');
			
		if(array_key_exists($n,$iromawi)){
			$hasil = $iromawi[$n];
		}elseif($n >= 11 && $n <= 99){
			$i = $n % 10;
			$hasil = $iromawi[$n-$i] . format_romawi($n % 10);
		}elseif($n >= 101 && $n <= 999){
			$i = $n % 100;
			$hasil = $iromawi[$n-$i] . format_romawi($n % 100);
		}else{
			$i = $n % 1000;
			$hasil = $iromawi[$n-$i] . format_romawi($n % 1000);
		}
		
		return $hasil;
	}
}

function kekata($x) {
    $x = abs($x);
    $angka = array("", "SATU", "DUA", "TIGA", "EMPAT", "LIMA",
    "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = kekata($x - 10). " BELAS";
    } else if ($x <100) {
        $temp = kekata($x/10)." PULUH". kekata($x % 10);
    } else if ($x <200) {
        $temp = " SERATUS" . kekata($x - 100);
    } else if ($x <1000) {
        $temp = kekata($x/100) . " RATUS" . kekata($x % 100);
    } else if ($x <2000) {
        $temp = " SERIBU" . kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = kekata($x/1000) . " RIBU" . kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " JUTA" . kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " MILYAR" . kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " TRILYUN" . kekata(fmod($x,1000000000000));
    }      
        return $temp;
}

function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "MINUS ". trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }      
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }      
    return $hasil;
}

function tanggal_lengkap($tgl) {
	$nmbln = array(
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember'
	);
	
	$dtg = explode("-",$tgl);
	$blnx = $dtg[1];
	$tglx = $dtg[0]. ' ' . $nmbln[$blnx] . ' ' . $dtg[2];
	
	return $tglx;
}

function getNamaBulan($idbln) {
	$idbln = (strlen($idbln) == 1) ? "0".$idbln : $idbln;
	$nmbln = array(
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember'
	);
	// $nmbln = array(
	// 	'01' => 'Jan',
	// 	'02' => 'Feb',
	// 	'03' => 'Mar',
	// 	'04' => 'Apr',
	// 	'05' => 'Mei',
	// 	'06' => 'Jun',
	// 	'07' => 'Jul',
	// 	'08' => 'Agus',
	// 	'09' => 'Sept',
	// 	'10' => 'Okt',
	// 	'11' => 'Nov',
	// 	'12' => 'Des'
	// );
	return $nmbln[$idbln];
} 

function getMonthYear($year, $month) {
    // Daftar nama bulan dalam bahasa Indonesia
    $bulan = [
        1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    
    // Pastikan nilai bulan valid
    if ($month < 1 || $month > 12) {
        return "Bulan tidak valid";
    }
    
    return $bulan[$month] . " " . $year;
}



function get_diff_months($startDate, $endDate, $ketetapan = 8) {
	$start_timestamp = strtotime($startDate);
	$end_timestamp = strtotime($endDate);
	if ($end_timestamp > $start_timestamp) {
		//jika SPTPD maka perhitungannya per bulan
		if ($ketetapan == 8) {
			// Assume YYYY-mm-dd - as is common MYSQL format
		    $splitStart = explode('-', $startDate);
		    $splitEnd = explode('-', $endDate);
		
		    if (is_array($splitStart) && is_array($splitEnd)) {
		        $startYear = $splitStart[0];
		        $startMonth = $splitStart[1];
		        $endYear = $splitEnd[0];
		        if( $splitEnd[2] == "31"){
					$endMonth = date("Y-m-d", strtotime('+1 days', strtotime($endDate)));
					$endMonth = explode('-', $endMonth);
					$endMonth = $endMonth[1];
				}else {
					$endMonth = $splitEnd[1];
				}
				
		        $difYears = $endYear - $startYear;
				$difMonth = $endMonth - $startMonth;
				
		      	if (0 == $difYears && $difMonth > 0) { // same year, dif months
		            return $difMonth;
		        }
		        else if (1 == $difYears) {
		            $startToEnd = 12 - $startMonth; // months remaining in start year(13 to include final month
		            return ($startToEnd + $endMonth); // above + end month date
		        }
		        else if ($difYears > 1) {
		            $startToEnd = 12 - $startMonth; // months remaining in start year 
		            $yearsRemaing = $difYears - 1;  // minus the years of the start and the end year
		            $remainingMonths = 12 * $yearsRemaing; // tally up remaining months
		            $totalMonths = $startToEnd + $remainingMonths + $endMonth; // Monthsleft + full years in between + months of last year
		            return $totalMonths;
		        } else {
		        	return 0;
		        }
		    } else {
		    	return 0;
		    }
		} else {
			$difference = $end_timestamp - $start_timestamp;
			$months = ceil($difference / 86400 / 30 );
			return $months;
		}
	} else {
		return 0;
	}
}

function bulan_pengenaan($startDate, $endDate, $ketetapan = 8) {
	$start_timestamp = strtotime($startDate);
	$end_timestamp = strtotime($endDate);
	
	if ($end_timestamp > $start_timestamp) {
		//jika SPTPD maka perhitungannya per bulan
		if ($ketetapan == 8) {
			// Assume YYYY-mm-dd - as is common MYSQL format
		    $splitStart = explode('-', $startDate);
		    $splitEnd = explode('-', $endDate);
		
		    if (is_array($splitStart) && is_array($splitEnd)) {
		        $startYear = $splitStart[0];
		        $startMonth = $splitStart[1];
		        $endYear = $splitEnd[0];
		        // if( $splitEnd[2] == "31"){
				// 	$endMonth = date("Y-m-d", strtotime('+1 days', strtotime($endDate)));
				// 	$endMonth = explode('-', $endMonth);
				// 	$endMonth = $endMonth[1];
				// }else {
				// 	$endMonth = $splitEnd[1];
				// }
				$endMonth = $splitEnd[1];
		        $difYears = $endYear - $startYear;
				$difMonth = $endMonth - $startMonth;
				
		      	if (0 == $difYears && $difMonth > 0) { // same year, dif months
					if ($splitEnd[2] > 10){
						return $difMonth + 1;
					}else {
						return $difMonth;
					}
		        }
		        else if (1 == $difYears) {
		            $startToEnd = 12 - $startMonth; // months remaining in start year(13 to include final month
					if ($splitEnd[2] > 10){
						return ($startToEnd + $endMonth + 1);
					}else {
						return ($startToEnd + $endMonth); // above + end month date
					}
		        }
		        else if ($difYears > 1) {
		            $startToEnd = 12 - $startMonth; // months remaining in start year 
		            $yearsRemaing = $difYears - 1;  // minus the years of the start and the end year
		            $remainingMonths = 12 * $yearsRemaing; // tally up remaining months
		            $totalMonths = $startToEnd + $remainingMonths + $endMonth; // Monthsleft + full years in between + months of last year
					if ($splitEnd[2] > 10){
						return $totalMonths + 1;
					}else {
						return $totalMonths;
					}
		        }elseif ($difMonth == 0) {
					if ($splitEnd[2] > 10) {
						return 1;
					}else {
						return 0;
					}
				}
				else {
		        	return 0;
		        }
		    } else {
		    	return 0;
		    }
		} else {
			$difference = $end_timestamp - $start_timestamp;
			$months = ceil($difference / 86400 / 30 );
			return $months;
		}
	} else {
		return 0;
	}
}


/**
 * UUID Generator
 *
 *
 * @access	public
 * @param	
 * @return	string
 */	
if ( ! function_exists('uuid'))
{
	function uuid()
	{
		$result = "";
		$result = sprintf( '%04x%04x%04x%04x%04x%04x%04x%04x',
							mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
							mt_rand( 0, 0x0fff ) | 0x4000,
							mt_rand( 0, 0x3fff ) | 0x8000,
							mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ));
		
		return $result;
	} 
}


/**
 * Url Variable Parser
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if ( ! function_exists('get_url_var'))
{
	function get_url_var($var_name)
	{
		$var_value = '';
		// <a title="CODEIGNITER" href="http://www.andreabaccega.com/blog/tag/codeigniter/">CODEIGNITER</a> HACK
		$tmp = explode('?',$_SERVER['REQUEST_URI']);
		
		$tmp = explode('&', $tmp[1]);
		//print_r($tmp);
		
		foreach($tmp as $keyval) {
			$tmpAppoggio = explode('=', $keyval);
			$_GET[urldecode($tmpAppoggio[0])]=urldecode($tmpAppoggio[1]);
			//echo $tmpAppoggio[0];
			if($tmpAppoggio[0]==$var_name)
			{
				$var_value = $tmpAppoggio[1];
				break;
			}
		}
		
		// end of codeigniter hack
		return $var_value;
	}

	function dateDiff($interval, $dateTimeBegin, $dateTimeEnd)
	{
		//Parse about any English textual datetime
		//$dateTimeBegin, $dateTimeEnd

		$dateTimeBegin = strtotime($dateTimeBegin);
		if ($dateTimeBegin === -1) {
			return ("..begin date Invalid");
		}

		$dateTimeEnd = strtotime($dateTimeEnd);
		if ($dateTimeEnd === -1) {
			return ("..end date Invalid");
		}

		$dif = $dateTimeEnd - $dateTimeBegin;

		switch ($interval) {
			case "s": //seconds
				return ($dif);

			case "n": //minutes
				return (floor($dif / 60)); //60s=1m

			case "h": //hours
				return (floor($dif / 3600)); //3600s=1h

			case "d": //days
				return (floor($dif / 86400)); //86400s=1d

			case "ww": //Week
				return (floor($dif / 604800)); //604800s=1week=1semana

			case "m": //similar result "m" dateDiff Microsoft
				$monthBegin = (date("Y", $dateTimeBegin) * 12) +
					date("n", $dateTimeBegin);
				$monthEnd = (date("Y", $dateTimeEnd) * 12) +
					date("n", $dateTimeEnd);
				$monthDiff = $monthEnd - $monthBegin;
				return ($monthDiff);

			case "yyyy": //similar result "yyyy" dateDiff Microsoft
				return (date("Y", $dateTimeEnd) - date("Y", $dateTimeBegin));

			default:
				return (floor($dif / 86400)); //86400s=1d
		}
	}

	function datediff1($tgl1, $tgl2)
	{
		$tgl1 = strtotime($tgl1);
		$tgl2 = strtotime($tgl2);
		$diff_secs = abs($tgl1 - $tgl2);
		$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
		$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);

		return array("years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff));
	}

	//tanggal jatuh tempo = tgl satu bulan berikutnya
	//misal kalo masa pajak 01/09/2016 ketika dibayar tgl 1/10/2016 dah kena pajak 2 %

	function denda($tgl_jatuh_tempo_sppt, $tgl_bayar, $spt_pajak)
	{
		if (empty($tgl_bayar)) $tgl_bayar = date('Y/m/d');

		$hari = intval(dateDiff("d", $tgl_jatuh_tempo_sppt, $tgl_bayar));

		$a =  datediff1($tgl_jatuh_tempo_sppt, $tgl_bayar);

		$v_jml_tahun = $a['years'];
		$v_jml_bulan = $a['months'];
		$v_jml_hari = $a['days'];

		$explode_jatuh_tempo = explode('-', $tgl_jatuh_tempo_sppt);
		$tahun_jatuh_tempo = $explode_jatuh_tempo[0];
		$bulan_jatuh_tempo = $explode_jatuh_tempo[1];

		if ($hari <= 0) {
			$v_denda = "0";
		} else {
			if ($tahun_jatuh_tempo >= '2024' && $bulan_jatuh_tempo >= '02') {
				if ($v_jml_tahun >= 2) {
					$v_denda = 24 * 1 / 100 * $spt_pajak;
				} else if ($v_jml_tahun < 2) {
					//if($v_jml_tahun == 1 && $v_jml_bulan==0 && $v_jml_hari==0){
					if ($v_jml_tahun == 1) {
						$v_jml_bulan = $v_jml_bulan + 12;
	
						if ($v_jml_hari > 0) {
							$v_jml_bulan = $v_jml_bulan + 1;
	
							$v_denda = $v_jml_bulan * 1 / 100 * $spt_pajak;
						} else {
	
							$v_denda = $v_jml_bulan * 1 / 100 * $spt_pajak;
						}
					} else {
						if ($v_jml_hari >= 1) {
							$v_jml_bulan = $v_jml_bulan + 1;
	
							$v_denda = $v_jml_bulan * 1 / 100 * $spt_pajak;
						} else {
	
							$v_denda = $v_jml_bulan * 1 / 100 * $spt_pajak;
						}
					}
				}
			}else{
				if ($v_jml_tahun >= 2) {
					$v_denda = 24 * 2 / 100 * $spt_pajak;
				} else if ($v_jml_tahun < 2) {
					//if($v_jml_tahun == 1 && $v_jml_bulan==0 && $v_jml_hari==0){
					if ($v_jml_tahun == 1) {
						$v_jml_bulan = $v_jml_bulan + 12;
	
						if ($v_jml_hari > 0) {
							$v_jml_bulan = $v_jml_bulan + 1;
	
							$v_denda = $v_jml_bulan * 2 / 100 * $spt_pajak;
						} else {
	
							$v_denda = $v_jml_bulan * 2 / 100 * $spt_pajak;
						}
					} else {
						if ($v_jml_hari >= 1) {
							$v_jml_bulan = $v_jml_bulan + 1;
	
							$v_denda = $v_jml_bulan * 2 / 100 * $spt_pajak;
						} else {
	
							$v_denda = $v_jml_bulan * 2 / 100 * $spt_pajak;
						}
					}
				}
			}
		}

		$v_denda = round($v_denda);

		return ($v_denda);
	}
}
