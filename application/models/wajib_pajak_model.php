<?php 
/**
 * class Wajib_pajak_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Wajib_pajak_model extends CI_model {
	/**
	 * get list data from db
	 */

	function get_kecamatan($kd_kecamatan)
	{
		$query = $this->db->get_where('kecamatan', array('camat_id' => $kd_kecamatan));

		return $query->row();
	}

	function get_list_wp($status = "true", $ref_kodus_id = NULL, $jenis_pungutan = NULL) {
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' a.no_reg ';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";
		
		$query = $_POST['query'];
		$qtype = $_POST['qtype'];
	
		($status=="false") ? $status_aktif = "false":$status_aktif="true";
		$where = "WHERE a.wp_wr_status_aktif='".$status_aktif."'";
		
		if ($query) $where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
		$where .= (!empty($ref_kodus_id) && $ref_kodus_id != null) ? " AND a.wp_wr_bidang_usaha='" . $ref_kodus_id."'":"";
		
		if (!empty($jenis_pungutan) && $jenis_pungutan != null)
			$where .= " AND a.wp_wr_gol='".$_GET['spt_jenis_pemunggutan']."'";
		
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$where .= " AND camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}
		
		$total = $this->adodb->GetOne("SELECT count('wp_wr_id') FROM v_wp_wr a $where");
		$sql = "SELECT a.wp_wr_id,a.wp_wr_no_form,a.no_reg,a.npwprd,a.wp_wr_no_kartu,a.wp_wr_nama,a.wp_wr_almt,a.wp_wr_lurah,
						a.wp_wr_camat,a.wp_wr_kabupaten FROM v_wp_wr a 
						$where $sort $limit";
		$result = $this->adodb->Execute($sql);
		// var_dump($sql);die;
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				// var_dump($row);die;
				$wp_wr_almt = addslashes(preg_replace("/[\r|\n]/","",$row->wp_wr_almt));
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$counter,
									$row->no_reg,					
									"<a href=\"#\" onclick=\"isChosen('$row->wp_wr_id','$row->npwprd', 
															'".str_replace(array("\r\n","\n\r","\r", "\n", "\"", "'", '\\', '"'), '', stripslashes($row->wp_wr_nama))."',
															'$wp_wr_almt','$row->wp_wr_lurah','$row->wp_wr_camat',
															'$row->wp_wr_kabupaten');\">".$row->npwprd."</a>",
									$row->wp_wr_no_kartu,
									$row->wp_wr_nama,
									$wp_wr_almt,
									$row->wp_wr_lurah,
									$row->wp_wr_camat,
									$row->wp_wr_kabupaten
								)
							);
				$counter++;
			}	
		}
		
		$result = array (
						"page"	=> $page,
						"total"	=> $total,
						"rows"	=> $list
					);
			
		echo json_encode($result);
	}

	function get_list_wp_nonaktif($status = "true", $ref_kodus_id = NULL, $jenis_pungutan = NULL) {
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' a.no_reg ';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";
		
		$query = $_POST['query'];
		$qtype = $_POST['qtype'];
	
		($status=="false") ? $status_aktif = "false":$status_aktif="true";
		$where = "WHERE a.wp_wr_status_aktif='".$status_aktif."'";
		
		if ($query) $where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
		$where .= (!empty($ref_kodus_id) && $ref_kodus_id != null) ? " AND a.wp_wr_bidang_usaha='" . $ref_kodus_id."'":"";
		
		if (!empty($jenis_pungutan) && $jenis_pungutan != null)
			$where .= " AND a.wp_wr_gol='".$_GET['spt_jenis_pemunggutan']."'";
		
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$where .= " AND camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}
		
		$total = $this->adodb->GetOne("SELECT count('wp_wr_id') FROM penonaktifan_wpwr");
		$sql = "SELECT a.wp_wr_id, a.tgl_nonaktif, a.no_berita_acara, a.isi_berita_acara, b.*
				FROM penonaktifan_wpwr a
				LEFT JOIN v_wp_wr b ON a.wp_wr_id = b.wp_wr_id
				$sort $limit";
		$result = $this->adodb->Execute($sql);
		// var_dump($sql);die;
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			$index = 0;
			while ($row = $result->FetchNextObject(false)) {
				// var_dump($row);die;
				$wp_wr_almt = addslashes(preg_replace("/[\r|\n]/","",$row->wp_wr_almt));
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->wp_wr_id,
									$counter,
									'<input type="checkbox" id="cb'.$counter.'" class="toggle" name="wp_wr_id[]" value="'.$row->wp_wr_id.'" 
											onclick="selectRow('.$index.');isChecked(this.checked,'.$row->wp_wr_nama.');" />',
									$row->tgl_nonaktif,					
									// "<a href=\"#\" onclick=\"isChosen('$row->wp_wr_id','$row->npwprd', 
									// 						'".str_replace(array("\r\n","\n\r","\r", "\n", "\"", "'", '\\', '"'), '', stripslashes($row->wp_wr_nama))."',
									// 						'$wp_wr_almt','$row->wp_wr_lurah','$row->wp_wr_camat',
									// 						'$row->wp_wr_kabupaten', '$row->no_berita_acara', '$row->isi_berita_acara');\">".$row->npwprd."</a>",
									$row->npwprd,
									$row->wp_wr_nama,
									$wp_wr_almt,
									$row->wp_wr_lurah,
									$row->wp_wr_camat,
									$row->wp_wr_kabupaten
								)
							);
				$counter++;
			}	
		}
		
		$result = array (
						"page"	=> $page,
						"total"	=> $total,
						"rows"	=> $list
					);
			
		echo json_encode($result);
	}

	function get_list_popup_wp_nonaktif($status = "true", $ref_kodus_id = NULL, $jenis_pungutan = NULL) {
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' a.no_reg ';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";
		
		$query = $_POST['query'];
		$qtype = $_POST['qtype'];
	
		($status=="false") ? $status_aktif = "false":$status_aktif="true";
		$where = "WHERE a.wp_wr_status_aktif='".$status_aktif."'";
		
		if ($query) $where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
		$where .= (!empty($ref_kodus_id) && $ref_kodus_id != null) ? " AND a.wp_wr_bidang_usaha='" . $ref_kodus_id."'":"";
		
		if (!empty($jenis_pungutan) && $jenis_pungutan != null)
			$where .= " AND a.wp_wr_gol='".$_GET['spt_jenis_pemunggutan']."'";
		
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$where .= " AND camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}
		
		$total = $this->adodb->GetOne("SELECT count('wp_wr_id') FROM penonaktifan_wpwr");
		$sql = "SELECT a.wp_wr_id, a.tgl_nonaktif, a.no_berita_acara, a.isi_berita_acara, b.*
				FROM penonaktifan_wpwr a
				LEFT JOIN v_wp_wr b ON a.wp_wr_id = b.wp_wr_id
				$sort $limit";
		$result = $this->adodb->Execute($sql);
		// var_dump($sql);die;
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			$index = 0;
			while ($row = $result->FetchNextObject(false)) {
				// var_dump($row);die;
				$wp_wr_almt = addslashes(preg_replace("/[\r|\n]/","",$row->wp_wr_almt));
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$counter,
									$row->tgl_nonaktif,					
									"<a href=\"#\" onclick=\"isChosen('$row->wp_wr_id','$row->npwprd', 
															'".str_replace(array("\r\n","\n\r","\r", "\n", "\"", "'", '\\', '"'), '', stripslashes($row->wp_wr_nama))."',
															'$wp_wr_almt','$row->wp_wr_lurah','$row->wp_wr_camat',
															'$row->wp_wr_kabupaten');\">".$row->npwprd."</a>",
									$row->wp_wr_nama,
									$wp_wr_almt,
									$row->wp_wr_lurah,
									$row->wp_wr_camat,
									$row->wp_wr_kabupaten
								)
							);
				$counter++;
			}	
		}
		
		$result = array (
						"page"	=> $page,
						"total"	=> $total,
						"rows"	=> $list
					);
			
		echo json_encode($result);
	}

	function get_list_wp_teguran($status = "true", $ref_kodus_id = NULL, $jenis_pungutan = NULL) {
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' a.no_reg ';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		$jenis_pajak = $_GET['jenispajak'];
		// $nm_kecamatan = $_GET['nm_kecamatan'];
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$order = "ORDER BY spt_id DESC";
		$limit = " LIMIT $rp OFFSET $start ";
		
		$query = $_POST['query'];
		$qtype = $_POST['qtype'];
	
		($status=="false") ? $status_aktif = "false":$status_aktif="true";
		// $where = "WHERE a.wp_wr_status_aktif='".$status_aktif."'";
		$where = " WHERE spt_jenis_pajakretribusi='".$jenis_pajak."'";
		$where .= "AND status_bayar='0'";
		
		if ($query) $where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
		$where .= (!empty($ref_kodus_id) && $ref_kodus_id != null) ? " AND a.wp_wr_bidang_usaha='" . $ref_kodus_id."'":"";
		
		if (!empty($jenis_pungutan) && $jenis_pungutan != null)
			$where .= " AND a.wp_wr_gol='".$_GET['spt_jenis_pemunggutan']."'";
		
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$where .= " AND camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}
		
		// $total = $this->adodb->GetOne("SELECT count('wp_wr_id') FROM v_wp_wr a $where");
		$total = $this->adodb->GetOne("SELECT count('spt_id') FROM v_spt a $where");
		// $sql = "SELECT a.wp_wr_id,a.wp_wr_no_form,a.no_reg,a.npwprd,a.wp_wr_no_kartu,a.wp_wr_nama,a.wp_wr_almt,a.wp_wr_lurah,
		// 				a.wp_wr_camat,a.wp_wr_kabupaten FROM v_wp_wr a 
		// 				$where $sort $limit";
		$sql = "SELECT * FROM v_spt
						$where $order $limit";
		$result = $this->adodb->Execute($sql);
		// var_dump($sql);die;
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				// var_dump($row);die;
				$wp_wr_almt = addslashes(preg_replace("/[\r|\n]/","",$row->wp_wr_almt));
				$list[] = array (
								"id"	=> $counter,
								// "cell"	=> array (
								// 	$counter,
								// 	$row->no_reg,					
								// 	"<a href=\"#\" onclick=\"isChosen('$row->wp_wr_id','$row->npwprd', 
								// 							'".str_replace(array("\r\n","\n\r","\r", "\n", "\"", "'", '\\', '"'), '', stripslashes($row->wp_wr_nama))."',
								// 							'$wp_wr_almt','$row->wp_wr_lurah','$row->wp_wr_camat',
								// 							'$row->wp_wr_kabupaten');\">".$row->npwprd."</a>",
								// 	$row->wp_wr_no_kartu,
								// 	$row->wp_wr_nama,
								// 	$wp_wr_almt,
								// 	$row->wp_wr_lurah,
								// 	$row->wp_wr_camat,
								// 	$row->wp_wr_kabupaten
								// )
								"cell"	=> array (
									$counter,
									$row->spt_id,					
									"<a href=\"#\" onclick=\"isChosen('$row->spt_idwpwr','$row->npwprd', 
															'".str_replace(array("\r\n","\n\r","\r", "\n", "\"", "'", '\\', '"'), '', stripslashes($row->wp_wr_nama))."',
															'$wp_wr_almt','$row->wp_wr_lurah','$row->wp_wr_camat',
															'$row->wp_wr_kabupaten');\">".$row->npwprd."</a>",
									$row->spt_nomor,
									$row->wp_wr_nama,
									$wp_wr_almt,
									$row->wp_wr_lurah,
									$row->wp_wr_camat,
									$row->wp_wr_kabupaten
								)
							);
				$counter++;
			}	
		}
		
		$result = array (
						"page"	=> $page,
						"total"	=> $total,
						"rows"	=> $list
					);
			
		echo json_encode($result);
	}

	function get_list_wp_teguran_laporan() {
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' a.no_reg ';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		$jenis_pajak = $_GET['jenispajak'];
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
		// $nm_kecamatan = $_GET['nm_kecamatan'];
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$order = "ORDER BY a.spt_id DESC";
		$limit = " LIMIT $rp OFFSET $start ";
		
		$query = $_POST['query'];
		$qtype = $_POST['qtype'];
	
		// $where = "WHERE a.wp_wr_status_aktif='".$status_aktif."'";
		$where = " WHERE a.spt_jenis_pajakretribusi='".$jenis_pajak."'
					AND TO_CHAR(a.spt_periode_jual1, 'MM') = '0$bulan' AND TO_CHAR(a.spt_periode_jual1, 'YYYY') = '$tahun'
					AND a.status_bayar='1'
					AND b.tgl_lapor IS NULL";
		if ($query != null) {
			$where .= " AND a.$qtype='$query'";
		}

		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$where .= " AND a.camat_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}
		
		// $total = $this->adodb->GetOne("SELECT count('wp_wr_id') FROM v_wp_wr a $where");
		$total = $this->adodb->GetOne("SELECT count('a.spt_id') FROM v_spt a LEFT JOIN spt b on a.spt_kode_billing=b.spt_kode_billing $where");
		// $sql = "SELECT a.wp_wr_id,a.wp_wr_no_form,a.no_reg,a.npwprd,a.wp_wr_no_kartu,a.wp_wr_nama,a.wp_wr_almt,a.wp_wr_lurah,
		// 				a.wp_wr_camat,a.wp_wr_kabupaten FROM v_wp_wr a 
		// 				$where $sort $limit";
		$sql = "SELECT a.*, b.tgl_lapor 
				FROM v_spt a
				LEFT JOIN spt b on a.spt_kode_billing=b.spt_kode_billing
				$where $order $limit";
		$result = $this->adodb->Execute($sql);
		// var_dump($sql);die;
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				// var_dump($row);die;
				$wp_wr_almt = addslashes(preg_replace("/[\r|\n]/","",$row->wp_wr_almt));
				$list[] = array (
								"id"	=> $counter,
								// "cell"	=> array (
								// 	$counter,
								// 	$row->no_reg,					
								// 	"<a href=\"#\" onclick=\"isChosen('$row->wp_wr_id','$row->npwprd', 
								// 							'".str_replace(array("\r\n","\n\r","\r", "\n", "\"", "'", '\\', '"'), '', stripslashes($row->wp_wr_nama))."',
								// 							'$wp_wr_almt','$row->wp_wr_lurah','$row->wp_wr_camat',
								// 							'$row->wp_wr_kabupaten');\">".$row->npwprd."</a>",
								// 	$row->wp_wr_no_kartu,
								// 	$row->wp_wr_nama,
								// 	$wp_wr_almt,
								// 	$row->wp_wr_lurah,
								// 	$row->wp_wr_camat,
								// 	$row->wp_wr_kabupaten
								// )
								"cell"	=> array (
									$counter,
									$row->spt_id,					
									"<a href=\"#\" onclick=\"isChosen('$row->spt_idwpwr','$row->npwprd', 
															'".str_replace(array("\r\n","\n\r","\r", "\n", "\"", "'", '\\', '"'), '', stripslashes($row->wp_wr_nama))."',
															'$wp_wr_almt','$row->wp_wr_lurah','$row->wp_wr_camat',
															'$row->wp_wr_kabupaten');\">".$row->npwprd."</a>",
									$row->spt_nomor,
									$row->wp_wr_nama,
									$wp_wr_almt,
									$row->wp_wr_lurah,
									$row->wp_wr_camat,
									$row->wp_wr_kabupaten
								)
							);
				$counter++;
			}	
		}
		
		$result = array (
						"page"	=> $page,
						"total"	=> $total,
						"rows"	=> $list
					);
			
		echo json_encode($result);
	}
	
	/**
	 * get_wp_by_npwpd
	 * @param unknown_type $kode_pajak
	 * @param unknown_type $golongan
	 * @param unknown_type $jenis_pajak
	 * @param unknown_type $no_registrasi
	 * @param unknown_type $kode_camat
	 * @param unknown_type $kode_lurah
	 * @param unknown_type $kodus
	 */
	function get_wp_by_npwpd($kode_pajak, $golongan, $jenis_pajak, $no_registrasi, $kode_camat, $kode_lurah, $kodus = "") {
		$result = array();
		
		$where = array('wp_wr_jenis' => strtolower ($kode_pajak),
						'wp_wr_gol' => $golongan,
						'ref_kodus_kode' => $jenis_pajak,
						'wp_wr_no_urut' => $no_registrasi,
						'camat_kode' => $kode_camat,
						'lurah_kode' => $kode_lurah,
						'wp_wr_status_aktif' => 'TRUE'
				);
		$this->db->select("wp_wr_id,npwprd,wp_wr_nama,wp_wr_almt,wp_wr_lurah,wp_wr_camat,wp_wr_kabupaten");
		$this->db->from('v_wp_wr');
		$this->db->where($where);
		if (!empty($kodus)) {
			$this->db->where('wp_wr_bidang_usaha', $kodus);
		}
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$row = $query->row_array(); 
				$result = $row;
			}			
		}
		
		return $result;
	}
	
	/**
	 * get wp by kodus kode
	 * @param unknown_type $kodus_kode
	 */
	function get_wp_by_jenis_pajak($kodus_kode) {
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' a.no_reg ';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";
		
		$query = $_POST['query'];
		$qtype = $_POST['qtype'];
		$where = "WHERE a.wp_wr_status_aktif='TRUE' AND ref_kodus_kode =  '$kodus_kode'";
		
		if ($query) $where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";
		$where .= (!empty($ref_kodus_id) && $ref_kodus_id != null) ? " AND a.wp_wr_bidang_usaha='" . $ref_kodus_id."'":"";
		
		if (!empty($jenis_pungutan) && $jenis_pungutan != null)
			$where .= " AND a.wp_wr_gol='".$_GET['spt_jenis_pemunggutan']."'";
		
		$total = $this->adodb->GetOne("SELECT count('wp_wr_id') FROM v_wp_wr a $where");
		$sql = "SELECT a.wp_wr_id,a.wp_wr_no_form,a.no_reg,a.npwprd,a.wp_wr_no_kartu,a.wp_wr_nama,a.wp_wr_almt,a.wp_wr_lurah,
						a.wp_wr_camat,a.wp_wr_kabupaten FROM v_wp_wr a 
						$where $sort $limit";
		$result = $this->adodb->Execute($sql);
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$wp_wr_almt = addslashes(preg_replace("/[\r|\n]/","",$row->wp_wr_almt));
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$counter,
									$row->no_reg,					
									"<a href=\"#\" onclick=\"isChosen('$row->wp_wr_id','$row->npwprd', 
															'".str_replace(array("\r\n","\n\r","\r", "\n", "\"", "'", '\\', '"'), '', stripslashes($row->wp_wr_nama))."',
															'$wp_wr_almt','$row->wp_wr_lurah','$row->wp_wr_camat',
															'$row->wp_wr_kabupaten');\">".$row->npwprd."</a>",
									$row->wp_wr_no_kartu,
									$row->wp_wr_nama,
									$wp_wr_almt,
									$row->wp_wr_lurah,
									$row->wp_wr_camat,
									$row->wp_wr_kabupaten
								)
							);
				$counter++;
			}	
		}
		
		$result = array (
						"page"	=> $page,
						"total"	=> $total,
						"rows"	=> $list
					);
			
		echo json_encode($result);
	}

	function get_list_reklame() {
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' a.no_reg ';
		if (!$sortorder) $sortorder = 'desc';
		$sort = "ORDER BY $sortname $sortorder";
		
		$page = $_POST['page'];
		$rp = $_POST['rp'];
		if (!$page) $page = 1;
		if (!$rp) $rp = 10;
		$start = (($page-1) * $rp);
		$limit = " LIMIT $rp OFFSET $start ";

		$total = $this->adodb->GetOne("SELECT count('no_pelayanan') FROM tbl_integrasi_reklame a $where");
		$sql = "SELECT a.* FROM tbl_integrasi_reklame a WHERE no_skp IS NULL AND kd_billing IS NULL $sort $limit";

		$result = $this->adodb->Execute($sql);

		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				// var_dump($row);die;
				$wp_wr_almt = addslashes(preg_replace("/[\r|\n]/","",$row->alamat_wp));
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$counter,
									"<a href=\"#\" onclick=\"isChosen('$row->no_pelayanan', '$row->periode_spt', '$row->nama_wp', '$wp_wr_almt', '$row->jenis_reklame', '$row->naskah_reklame', '$row->lokasi', '$row->area',
												'$row->kelurahan', '$row->kecamatan', '$row->kelas_jalan', '$row->luas', '$row->jumlah', '$row->jangka_waktu');\">".$row->no_pelayanan."</a>",
									$row->periode_spt,
									$row->nama_wp,
									$wp_wr_almt,
									$row->kelurahan,
									$row->kecamatan,
									$row->kota
								)
							);
				$counter++;
			}	
		}
		
		$result = array (
						"page"	=> $page,
						"total"	=> $total,
						"rows"	=> $list
					);
			
		echo json_encode($result);
	}
}

?>