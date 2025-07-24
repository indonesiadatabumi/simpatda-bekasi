<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Kartu_data Controller
 * @package Simpatda
 * @author Daniel Hutauruk
 */
class Sts extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('sts_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$this->load->view('view_sts');
	}
	
	/**
	 * get list
	 */
	function get_list() {
		$this->sts_model->get_list();
	}
	
	/**
	 * validasi
	 */
	function validasi() {
		$result = array();
		
		$return = $this->sts_model->validasi($this->input->post('skbh_id'));		
		if ($return) {
			//insert history log
			$skbh_no = $this->adodb->GetOne("SELECT skbh_no FROM setoran_ke_bank_header WHERE skbh_id=".$_POST['skbh_id']);
			$this->common_model->history_log("bkp", "U", "Validasi data STS : ".$_POST['skbh_id']." | ".$skbh_no);	
			
			$spt_id = $this->adodb->GetOne("select s.spt_id from spt s, v_sts vs 
											where s.spt_id=vs.setorpajret_id_spt and s.spt_idwpwr=vs.setorpajret_id_wp and s.spt_nomor=vs.setorpajret_no_spt 
											and vs.skbh_no='$skbh_no' ");
			$this->db->where('spt_id', $spt_id);
			$this->db->update('spt', array('status_bayar' => 1));
			
			$pmbayaran = $this->db->query("select b.skbh_no, b.setorpajret_dt_jumlah, b.setorpajret_jlh_bayar, b.npwprd, b.wp_wr_nama, 
				b.ref_jenparet_ket, b.setorpajret_spt_periode, 
				b.setorpajret_periode_jual1, b.setorpajret_periode_jual2, b.setorpajret_tgl_bayar, b.setorpajret_id_spt, b.skbh_tgl, c.spt_kode_billing, c.koderek 
				from v_sts b, v_spt c
				where b.skbh_no='$skbh_no' and b.setorpajret_id_spt=c.spt_id")->result();
			foreach ($pmbayaran as $p){
				$npwprd = $p->npwprd;
				$kode_billing = $p->spt_kode_billing;
				$tahun_pajak = $p->setorpajret_spt_periode;
				$kd_rekening = $p->koderek;
				$nm_rekening = $p->ref_jenparet_ket;
				$masa_awal = $p->setorpajret_periode_jual1;
				$masa_akhir = $p->setorpajret_periode_jual2;
				$tagihan = $p->setorpajret_dt_jumlah;
				$jlh_bayar = $p->setorpajret_jlh_bayar;
				$tgl_bayar = $p->setorpajret_tgl_bayar;
				$tgl_rekam = $p->skbh_tgl;
			}

			$data_pembayaran_sptpd = $this->sts_model->get_data_pembayaran_sptpd($npwprd, $kode_billing);
			if($data_pembayaran_sptpd == 0){
				$data_byr = array(
					'npwprd' => $npwprd,
					'kode_billing' => $kode_billing,
					'tahun_pajak' => $tahun_pajak,
					'pembayaran_ke' => '1',
					'kd_rekening' => $kd_rekening,
					'nm_rekening' => $nm_rekening,
					'masa_awal' => $masa_awal,
					'masa_akhir' => $masa_akhir,
					'tagihan' => $tagihan,
					'sptpd_yg_dibayar' => $jlh_bayar,
					'tgl_pembayaran' => $tgl_bayar,
					'tgl_rekam_byr' => $tgl_rekam,
					'nip_rekam_byr' => $this->session->userdata('USER_ID'),
					'ntp' => $this->session->userdata('USER_NAME')
				);
				$this->db->insert('payment.pembayaran_sptpd', $data_byr); 
			}
			$result = array('status' => TRUE);	
		} else {
			$result = array('status' => FALSE, 'msg' => 'Data gagal divalidasi');
		}
		
		echo json_encode($result);
	}
	
	/**
	 * search data sts
	 */
	function search() {
		$this->sts_model->get_list($this->input->get('fDate'), $this->input->get('tDate'));
	}
	
	/**
	 * cetak sts
	 */
	function cetak_sts() {
		$id = $this->input->get('skbh_id');
		$query = $this->common_model->get_query('*', 'data_pemerintah_daerah');	
		$data['pemda'] = $query->row();
		$data['arr_data'] = $this->sts_model->get_setoran_ke_bank($id);
		
		//insert history log
		$skbh_no = $this->adodb->GetOne("SELECT skbh_no FROM setoran_ke_bank_header WHERE skbh_id=".$id);
		$this->common_model->history_log("bkp", "P", "Print STS : ".$id." | ".$skbh_no);
		
		$this->load->view('pdf_cetak_sts', $data);
	}
	
	/**
	 * cetak daftar
	 */
	function cetak_daftar() {
		$data['query'] = $this->sts_model->list_daftar_sts($this->input->get('fDate'),
																$this->input->get('tDate')); 
		//insert history log
		$this->common_model->history_log("bkp", "P", "Cetak daftar STS");
		
		$this->load->view('xls_daftar_sts', $data);
	}
	
	/**
	 * delete anggaran
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->sts_model->delete($arr_id[$i]) == true) {
				$counter++;
				
				//insert history log
				$this->common_model->history_log("bkp", "D", "Delete data STS : ".$arr_id[$i]);
			}
		}
		
		if ($counter > 0) {
			echo json_encode(array('status' => true, 'msg' => "$counter data berhasil dihapus"));
		} else {
			echo json_encode(array('status' => false, 'msg' => "Tidak ada data yang berhasil dihapus. Silahkan cek apabila STS sudah divalidasi"));
		}
	}
}