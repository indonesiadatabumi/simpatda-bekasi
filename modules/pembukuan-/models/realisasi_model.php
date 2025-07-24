<?php 
/**
 * class Realisasi_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Realisasi_model extends CI_Model {
	/**
	 * get rekening 
	 */
	function get_rekening($korek_kelompok = NULL, $korek_jenis = NULL, $korek_objek = NULL, $korek_sub1 = FALSE) {
		$where = "korek_status_aktif='TRUE'";
		if (!is_null($korek_kelompok)) $where .= " AND korek_kelompok='$korek_kelompok'";
		if (!is_null($korek_jenis)) $where .= " AND korek_jenis='$korek_jenis'";
		if ($korek_objek != null && $korek_objek != "")
			$where .= " AND korek_objek IS NOT NULL AND korek_objek = '$korek_objek'";
		else if (empty($korek_objek) && !is_null($korek_objek))
			$where .= " AND korek_objek IS NOT NULL";
		if (!$korek_sub1) $where .= " AND (korek_sub1 = '00' OR korek_sub1 ISNULL)";
		
		$sql = "SELECT korek_id, 
					korek_nama,
					case when korek_jenis IS NOT NULL THEN
						case when korek_objek IS NOT NULL THEN
								case when korek_rincian != '00' THEN
											case when korek_sub1 != '00' THEN
												case when korek_sub2 != '00' THEN
												korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text || '.'::text || 
												korek_rincian::text || '.'::text || korek_sub1::text || '.' || korek_sub2::text
												ELSE
												korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text || '.'::text || 
												korek_rincian::text || '.'::text || korek_sub1::text
												END
											ELSE
												korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text || '.'::text || 
												korek_rincian::text
											END
								ELSE
										korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text
								END
						ELSE
							korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text
						END
					ELSE
					korek_tipe::text || '.'::text || korek_kelompok::text
					END AS rekening, 
					korek_tipe, korek_kelompok, korek_jenis, korek_objek, korek_rincian, korek_sub1, korek_sub2, korek_sub3
				FROM kode_rekening
				WHERE $where
				ORDER BY rekening";

		$query = $this->adodb->GetAll($sql);
		return $query;
	}
	
	/**
	 * get rekening rekapitulasi
	 */
	function get_rekening_rekap() {
		$sql = "SELECT korek_id,  
						case when korek_jenis IS NOT NULL THEN
							case when korek_objek IS NOT NULL THEN
									case when korek_rincian != '00' THEN
												case when korek_sub1 != '00' THEN
													case when korek_sub2 != '00' THEN
													korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text || '.'::text || 
													korek_rincian::text || '.'::text || korek_sub1::text || '.' || korek_sub2::text
													ELSE
													korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text || '.'::text || 
													korek_rincian::text || '.'::text || korek_sub1::text
													END
												ELSE
													korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text || '.'::text || 
													korek_rincian::text
												END
									ELSE
											korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text || '.'::text || korek_objek::text
									END
							ELSE
								korek_tipe::text || '.'::text || korek_kelompok::text || '.'::text || korek_jenis::text
							END
						ELSE
						korek_tipe::text || '.'::text || korek_kelompok::text
						END AS rekening,korek_nama, korek_tipe, korek_kelompok, korek_jenis, korek_objek, korek_rincian, korek_sub1, korek_sub2, korek_sub3
				FROM kode_rekening 
				WHERE (korek_kelompok='1' AND korek_objek IS NULL) 
						OR (korek_kelompok='2' AND (korek_objek IS NULL OR (korek_jenis='1' AND korek_objek IN ('01','02') AND korek_rincian='00')))
						OR (korek_kelompok='3' AND (korek_objek IS NULL OR (korek_objek IN ('01','02') AND korek_rincian='00')))
				ORDER BY rekening";
		
		$query = $this->adodb->GetAll($sql);
		return $query;
	}
	
	/**
	 * get target anggaran
	 */
	function get_target_anggaran($tahun_anggaran) {
		$result = array();
		$sql = "SELECT * FROM v_tahun_anggaran where tahang_thn1='$tahun_anggaran'";
		$query = $this->adodb->GetAll($sql);
		
		if (count($query) > 0) {
			foreach ($query as $row) {
				$result[$tahun_anggaran][$row['tahangdet_id_rek']] = $row['tahangdet_jumlah'];
			}
		}
		
		return $result;
	}
	
	/**
	 * get realisasi pajak
	 */
	function realisasi_pajak($tanggal_proses, $year, $param, $korek_kelompok = NULL, $korek_jenis = NULL, $korek_objek = NULL, $korek_sub1 = FALSE, $is_rekap = FALSE) {
		if ($tanggal_proses == "")
			return ;
		
		$start_week_date = $this->pembukuan_model->start_week_date($tanggal_proses);
		if ($param == 1)
			$sub_where = "skbh_tgl < '$start_week_date' AND date_part('year', skbh_tgl) = '$year'";
		else {			
			$sub_where = "skbh_tgl BETWEEN '$start_week_date' AND '$tanggal_proses' AND date_part('year', skbh_tgl) = '$year'";
		}
			
		if (!$is_rekap) {
			$where = "korek_status_aktif='TRUE'";
					if (!is_null($korek_kelompok)) $where .= " AND korek_kelompok='$korek_kelompok'";
					if (!is_null($korek_jenis)) $where .= " AND korek_jenis='$korek_jenis'";
					if ($korek_objek != null && $korek_objek != "")
						$where .= " AND korek_objek IS NOT NULL AND korek_objek = '$korek_objek'";
					else if (empty($korek_objek) && !is_null($korek_objek))
						$where .= " AND korek_objek IS NOT NULL";
					if (!$korek_sub1) $where .= " AND (korek_sub1 = '00' OR korek_sub1 ISNULL)";
		} else {
			$where = "korek_status_aktif='TRUE' AND ((korek_kelompok='1' AND korek_objek IS NULL) 
						OR (korek_kelompok='2' AND (korek_objek IS NULL OR (korek_jenis='1' AND korek_objek IN ('01','02') AND korek_rincian='00')))
						OR (korek_kelompok='3' AND (korek_objek IS NULL OR (korek_objek IN ('01','02') AND korek_rincian='00'))))";
		}
		
			
		$sql = "SELECT korek_id, 
					korek_nama,
					case when korek_jenis IS NOT NULL THEN
						case when korek_objek IS NOT NULL THEN
								case when korek_rincian != '00' THEN
											case when korek_sub1 != '00' THEN
												case when korek_sub2 != '00' THEN
													(SELECT COALESCE(SUM(a.setorpajret_dt_jumlah),0) AS pen 
															FROM v_rekapitulasi_penerimaan_detail a 
															LEFT JOIN kode_rekening b ON a.setorpajret_dt_rekening=b.korek_id
															WHERE $sub_where
															AND kode_rekening.korek_tipe=b.korek_tipe
															AND kode_rekening.korek_kelompok=b.korek_kelompok
															AND kode_rekening.korek_jenis=b.korek_jenis
															AND kode_rekening.korek_objek=b.korek_objek
															AND kode_rekening.korek_rincian=b.korek_rincian
															AND kode_rekening.korek_sub1=b.korek_sub1
															AND kode_rekening.korek_sub1=b.korek_sub2)
												ELSE
												(SELECT COALESCE(SUM(a.setorpajret_dt_jumlah),0) AS pen 
															FROM v_rekapitulasi_penerimaan_detail a 
															LEFT JOIN kode_rekening b ON a.setorpajret_dt_rekening=b.korek_id
															WHERE $sub_where
															AND kode_rekening.korek_tipe=b.korek_tipe
															AND kode_rekening.korek_kelompok=b.korek_kelompok
															AND kode_rekening.korek_jenis=b.korek_jenis
															AND kode_rekening.korek_objek=b.korek_objek
															AND kode_rekening.korek_rincian=b.korek_rincian
															AND kode_rekening.korek_sub1=b.korek_sub1
													)
												END
											ELSE
											(SELECT COALESCE(SUM(a.setorpajret_dt_jumlah),0) AS pen 
															FROM v_rekapitulasi_penerimaan_detail a 
															LEFT JOIN kode_rekening b ON a.setorpajret_dt_rekening=b.korek_id
															WHERE $sub_where
															AND kode_rekening.korek_tipe=b.korek_tipe
															AND kode_rekening.korek_kelompok=b.korek_kelompok
															AND kode_rekening.korek_jenis=b.korek_jenis
															AND kode_rekening.korek_objek=b.korek_objek
															AND kode_rekening.korek_rincian=b.korek_rincian
												)
											END
								ELSE
										(SELECT COALESCE(SUM(a.setorpajret_dt_jumlah),0) AS pen 
															FROM v_rekapitulasi_penerimaan_detail a 
															LEFT JOIN kode_rekening b ON a.setorpajret_dt_rekening=b.korek_id
															WHERE $sub_where
															AND kode_rekening.korek_tipe=b.korek_tipe
															AND kode_rekening.korek_kelompok=b.korek_kelompok
															AND kode_rekening.korek_jenis=b.korek_jenis
															AND kode_rekening.korek_objek=b.korek_objek)
								END
						ELSE
							(SELECT COALESCE(SUM(a.setorpajret_dt_jumlah),0) AS pen 
															FROM v_rekapitulasi_penerimaan_detail a 
															LEFT JOIN kode_rekening b ON a.setorpajret_dt_rekening=b.korek_id
															WHERE $sub_where
															AND kode_rekening.korek_tipe=b.korek_tipe
															AND kode_rekening.korek_kelompok=b.korek_kelompok
															AND kode_rekening.korek_jenis=b.korek_jenis)
						END
					ELSE
						(SELECT COALESCE(SUM(a.setorpajret_dt_jumlah),0) AS pen 
															FROM v_rekapitulasi_penerimaan_detail a 
															LEFT JOIN kode_rekening b ON a.setorpajret_dt_rekening=b.korek_id
															WHERE $sub_where
															AND kode_rekening.korek_tipe=b.korek_tipe
															AND kode_rekening.korek_kelompok=b.korek_kelompok)
					END AS penerimaan
				FROM kode_rekening
				WHERE $where
				ORDER BY korek_tipe, korek_kelompok, korek_jenis, korek_objek, korek_rincian, korek_sub1, korek_sub2, korek_sub3";
		$query = $this->adodb->GetAll($sql);
		
		if (count($query) > 0) {
			foreach ($query as $row) {
				$result[$year][$row['korek_id']] = $row['penerimaan'];
			}
		}
		
		return $result;
	}
}