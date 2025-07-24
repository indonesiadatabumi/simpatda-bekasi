<?php 
/**
 * class Surat_ketetapan_model
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Surat_ketetapan_model extends CI_Model {
	/**
	 * get spt nota
	 */
	function get_kohir() {
		$tables = " v_nota_perhitungan_list ";
	
		$sortname = $_POST['sortname'];
		$sortorder = $_POST['sortorder'];
		if (!$sortname) $sortname = ' wp_wr_id ';
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
		
		$where = " WHERE netapajrek_id IS NOT NULL ";		
		
		$jenis_ketetapan = $this->input->get('jenis_ketetapan');
		$spt_periode = $this->input->get('spt_periode');
		$tahun = $this->input->get('tahun');
		$spt_jenis_pajak = $this->input->get('spt_jenis_pajakretribusi');
		$netapajrek_tgl = $this->input->get('netapajrek_tgl');
		
		$where .= " AND netapajrek_jenis_ketetapan='$jenis_ketetapan' AND spt_jenis_pajakretribusi='".$this->input->get('spt_jenis_pajakretribusi')."'";
			
		if ($spt_periode != "") {
			$where .= " AND spt_periode='$spt_periode' ";
		}
		
		if ($tahun != "") {
			$where .= " AND spt_periode='$tahun' ";
		}
		
		if (!empty($netapajrek_tgl)) {
			$where .= " AND netapajrek_tgl='".format_tgl($netapajrek_tgl)."' ";
		}
		
		if ($this->session->userdata('USER_SPT_CODE') != "10") {
			$where .= " AND spt_kode = '".$this->session->userdata('USER_SPT_CODE')."'";
		}
		
		if ($query) 
			$where .= " AND CAST($qtype AS TEXT) ~~* '%$query%' ";	
	
		$sql = "SELECT DISTINCT netapajrek_id, spt_id,netapajrek_tgl, netapajrek_kohir, npwprd,spt_periode, netapajrek_tgl_jatuh_tempo, korek
				FROM $tables $where $sort $limit";
		//echo $sql;
		$result = $this->adodb->Execute($sql);
		$total = $this->adodb->GetOne("SELECT count('netapajrek_id') FROM $tables $where");
		
		$list = array();
		$counter = 1 + $rp * ($page - 1);
		
		if ($result) {
			while ($row = $result->FetchNextObject(false)) {
				$list[] = array (
								"id"	=> $counter,
								"cell"	=> array (
									$row->netapajrek_id,
									$counter,
									"<a href=\"#\" onclick=\"isChosenSPT('$row->netapajrek_kohir');\">".$row->netapajrek_kohir."</a>",
									$row->npwprd,
									$row->spt_periode,
									format_tgl($row->netapajrek_tgl),
									format_tgl($row->netapajrek_tgl_jatuh_tempo),
									$row->korek
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
	 * call data setor
	 * @param unknown_type $view
	 */
	function call_data_setor($view) {
		$kohir1 = $this->input->get('no_kohir1');
		$kohir2 = $this->input->get('no_kohir2');
		$periode = $this->input->get('tahun');
		$spt_jenis_pajakretribusi = $this->input->get('spt_jenis_pajakretribusi');
		$jenis_ketetapan = $this->input->get('jenis_ketetapan');

		$tanggal_proses = format_tgl($this->input->get('netapajrek_tgl'));

		$sql_cari = "SELECT DISTINCT netapajrek_id_spt,wp_wr_nama,wp_wr_nama_milik,wp_wr_almt,wp_wr_lurah,wp_wr_camat,
						npwprd1,npwprd2,ketspt_ket,ketspt_singkat,spt_periode_jual1,spt_periode_jual2,spt_periode,netapajrek_kohir,netapajrek_id,nama_rek_header,
						netapajrek_tgl,netapajrek_tgl_jatuh_tempo,koderek 
					FROM $view 
					WHERE netapajrek_id_spt IS NOT NULL";
		
		if (!empty($spt_jenis_pajakretribusi))
			$sql_cari .= " AND spt_jenis_pajakretribusi='".$spt_jenis_pajakretribusi."'";
		
		if (!empty($jenis_ketetapan)) 
			$sql_cari .= " AND netapajrek_jenis_ketetapan=".$jenis_ketetapan;
			
		if (!empty($kohir1))
			$sql_cari .= " AND netapajrek_kohir BETWEEN '".$kohir1."' AND '".$kohir2."'";
			
		if (!empty($periode))
			$sql_cari .= " AND spt_periode='".$periode."'";
			
		if (!empty($tanggal_proses))
			$sql_cari .= " AND netapajrek_tgl='".$tanggal_proses."'";
			
		$sql_cari .= " ORDER BY netapajrek_kohir ASC";
		
		//echo $sql_cari;
		$ar_cari = $this->adodb->GetAll($sql_cari);
		return $ar_cari;
	}	
	
	function daftar_surat_ketetapan() {
		$where = "WHERE netapajrek_id_spt IS NOT NULL";
		
		if (!empty($_GET['keterangan_spt']))
			$where .= " AND netapajrek_jenis_ketetapan=".$_GET['keterangan_spt'];
			
		if (!empty($_GET['spt_jenis_pajakretribusi']))
			$where .= " AND spt_jenis_pajakretribusi=".$_GET['spt_jenis_pajakretribusi'];
			
		if (!empty($_GET['tanggal']))
			$where .= " AND date_part('day',netapajrek_tgl)='".$_GET['tanggal']."'";
			
		if (!empty($_GET['bulan']))
			$where .= " AND date_part('month',netapajrek_tgl)='".$_GET['bulan']."'";
		
		if (!empty($_GET['tahun']))
			$where .= " AND date_part('year',netapajrek_tgl)='".$_GET['tahun']."'";
			
		if (!empty($_GET['wp_wr_kd_camat']))
			$where .= " AND wp_wr_kd_camat='".$_GET['wp_wr_kd_camat']."'";
		
		$order_by = "ORDER BY netapajrek_kohir ASC";
		
		$sql = "SELECT * FROM v_daftar_ketetapan_list $where $order_by";
		// echo $sql;die;
		$result = $this->adodb->GetAll($sql);
		return $result;
	}
	
	/**
	 * daftar_surat_ketetapan_reklame
	 */
	function daftar_surat_ketetapan_reklame() {
		$where = "WHERE netapajrek_id_spt IS NOT NULL";
		
		if (!empty($_GET['keterangan_spt']))
			$where .= " AND netapajrek_jenis_ketetapan=".$_GET['keterangan_spt'];
			
		if (!empty($_GET['spt_jenis_pajakretribusi']))
			$where .= " AND spt_jenis_pajakretribusi=".$_GET['spt_jenis_pajakretribusi'];
			
		if (!empty($_GET['tanggal']))
			$where .= " AND date_part('day',netapajrek_tgl)='".$_GET['tanggal']."'";
			
		if (!empty($_GET['bulan']))
			$where .= " AND date_part('month',netapajrek_tgl)='".$_GET['bulan']."'";
		
		if (!empty($_GET['tahun']))
			$where .= " AND date_part('year',netapajrek_tgl)='".$_GET['tahun']."'";
			
		// if ($this->session->userdata('USER_SPT_CODE') == "10") {
		// 	if ($_GET['wp_wr_kd_camat'] != "0") {
		// 		$camat_kode = $this->common_model->get_record_value('camat_kode', 'kecamatan', "camat_id=".$_GET['wp_wr_kd_camat']);
		// 		$where .= " AND spt_kode='$camat_kode'";
		// 	} else {
		// 		$where .= " AND spt_kode='".$this->session->userdata('USER_SPT_CODE')."'";
		// 	}			
		// } else {
		// 	$where .= " AND spt_kode='".$this->session->userdata('USER_SPT_CODE')."'";
		// }

		if (!empty($_GET['wp_wr_kd_camat'])){
			$kd_camat = $_GET['wp_wr_kd_camat'];
			$get_camat = $this->surat_ketetapan_model->getCamat($kd_camat);
			$camat = $get_camat->camat_nama;
			$where .= " AND wp_wr_camat='".$camat."'";
		}
		
		$order_by = " ORDER BY netapajrek_kohir ASC";
		
		$sql = "SELECT a.*, b.korek_nama as korek_nama_detail,b.spt_dt_pajak, c.sptrek_judul, c.sptrek_lokasi, c.sptrek_luas, c.sptrek_lama_pasang
					FROM v_daftar_ketetapan_list a 
					INNER JOIN v_spt_detail b ON a.netapajrek_id_spt=b.spt_dt_id_spt
					LEFT JOIN spt_reklame c ON b.spt_dt_id=c.sptrek_id_spt_dt  $where $order_by";
		// echo $sql;die;
		$result = $this->adodb->GetAll($sql);
		return $result;
	}
	
	/**
	 * daftar_tanggal_surat_ketetapan
	 */
	function daftar_tanggal_surat_ketetapan() {
		$where = "WHERE netapajrek_id_spt IS NOT NULL";
		
		$where .= " AND spt_jenis_pajakretribusi=".$_GET['spt_jenis_pajakretribusi'];
		$where .= " AND netapajrek_tgl BETWEEN '".format_tgl($_GET['tgl_penetapan1'])."' AND '".format_tgl($_GET['tgl_penetapan2'])."'";
		
		if (!empty($_GET['keterangan_spt']))
			$where .= " AND netapajrek_jenis_ketetapan=".$_GET['keterangan_spt'];
			
		if (!empty($_GET['wp_wr_kd_camat']))
			$where .= " AND wp_wr_kd_camat='".$_GET['wp_wr_kd_camat']."'";
		
		$order_by = "ORDER BY netapajrek_kohir ASC";
		
		$sql = "SELECT * FROM v_daftar_ketetapan_list $where $order_by";
		//echo $sql;
		$result = $this->adodb->GetAll($sql);
		return $result;
	}
	
	/**
	 * daftar_tanggal_surat_ketetapan_reklame
	 */
	function daftar_tanggal_surat_ketetapan_reklame() {
		$where = "WHERE netapajrek_id_spt IS NOT NULL";
		
		$where .= " AND spt_jenis_pajakretribusi=".$_GET['spt_jenis_pajakretribusi'];
		$where .= " AND netapajrek_tgl BETWEEN '".format_tgl($_GET['tgl_penetapan1'])."' AND '".format_tgl($_GET['tgl_penetapan2'])."'";
		
		if (!empty($_GET['keterangan_spt']))
			$where .= " AND netapajrek_jenis_ketetapan=".$_GET['keterangan_spt'];
			
		if ($this->session->userdata('USER_SPT_CODE') != "")
			$where .= " AND spt_kode='".$this->session->userdata('USER_SPT_CODE')."'";
		
		$order_by = " ORDER BY netapajrek_kohir ASC";
		
		$sql = "SELECT a.*, b.korek_nama as korek_nama_detail, b.spt_dt_pajak, c.sptrek_judul, c.sptrek_lokasi, c.sptrek_luas, c.sptrek_lama_pasang
					FROM v_daftar_ketetapan_list a 
					INNER JOIN v_spt_detail b ON a.netapajrek_id_spt=b.spt_dt_id_spt
					LEFT JOIN spt_reklame c ON b.spt_dt_id=c.sptrek_id_spt_dt $where $order_by";
		//echo $sql;
		$result = $this->adodb->GetAll($sql);
		return $result;
	}

	function getCamat($kd_camat){
		$sql_camat = "SELECT camat_nama FROM kecamatan WHERE camat_id = '$kd_camat'";
		$query = $this->db->query($sql_camat);
		return $query->row();
	}
}