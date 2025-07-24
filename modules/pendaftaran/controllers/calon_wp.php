<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pribadi class controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Calon_wp extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('calon_wp_model');
		$this->load->model('common_model');
	}
	
	/**
	 * index page controller
	 */
	function index() {
		$this->add();
	}
	
	/**
	 * view list wajib pajak pribadi
	 */
	function view() {
		$this->load->view('view_calon_wp');
	}
	
	/**
	 * get list data wp pribadi
	 */
	function get_list() {
		$this->calon_wp_model->get_list();
	}
	
	/**
	 * add page contoller
	 */
	function add() {		
		$kecamatan = $this->common_model->get_kecamatan();
		//get kecamatan
		$arr_kecamatan = array();
		$arr_kecamatan[''] = "--";
		foreach ($kecamatan as $row) {
			$arr_kecamatan[$row->camat_id.'|'.$row->camat_nama] = $row->camat_kode.' | '.$row->camat_nama;
		}
		$data['kecamatan'] = $arr_kecamatan;
		$data['kelurahan'] = array('' => '--');
		$data['kabupaten'] = $this->common_model->get_record_value('dapemda_nm_dati2', 'data_pemerintah_daerah', 'dapemda_id=1');
		
		$bidang_usaha = array();
		$arr_bidang_usaha = $this->common_model->get_bidang_usaha();
		if (count($arr_bidang_usaha))
		{
			foreach ($arr_bidang_usaha as $row)
			{
				$bidang_usaha[$row->ref_kodus_id] = $row->ref_kodus_kode.'.'.$row->ref_kodus_nama;
			}
		}		
		$data['bidang_usaha'] = $bidang_usaha;
		
		$arr_gol_hotel = array();
		$golongan_hotel = $this->common_model->get_query("*", "ref_gol_hotel", NULL, "ref_kode ASC");
		if (count($golongan_hotel) > 0)
		{
			$arr_gol_hotel[''] = "-- Silahkan Pilih --";
			foreach ($golongan_hotel->result() as $row)
			{
				$arr_gol_hotel[$row->ref_kode] = $row->ref_kode.' | '.$row->ref_nama;
			}
		}
		$data['golongan_hotel'] = $arr_gol_hotel;
		
		$arr_jenis_restoran = array("0" => "Rumah Makan & Catering", "1" => "Rumah Makan", "2" => "Catering");
		$data['jenis_restoran'] = $arr_jenis_restoran;
		
		$this->load->view('add_calon_wp', $data);
	}
	
	/**
	 * edit wp pribadi controller
	 */
	function edit() {
		$wp_wr_id = $this->input->post('wp_wr_id');
		if (!empty($wp_wr_id)) {
			$query = $this->calon_wp_model->get_calon_wp_wr($wp_wr_id);
			
			if ($query->num_rows() > 0) {
				$wp_data = $query->row();
				$data['row'] = $wp_data;
				
				$kecamatan = $this->common_model->get_kecamatan();
				$arr_kecamatan = array();
				$arr_kecamatan[''] = "--";
				foreach ($kecamatan as $row) {
					$arr_kecamatan[$row->camat_id.'|'.$row->camat_nama] = $row->camat_kode.' | '.$row->camat_nama;
				}
				$data['kecamatan'] = $arr_kecamatan;
				
				$kelurahan = $this->common_model->get_kelurahan($wp_data->wp_wr_kd_camat);
				$arr_kelurahan = array();
				$arr_kelurahan[''] = "--";
				foreach ($kelurahan as $row) {
					$arr_kelurahan[$row->lurah_id.'|'.$row->lurah_nama] = $row->lurah_kode.' | '.$row->lurah_nama;
				}
				$data['kelurahan'] = $arr_kelurahan;
				
				$data['kabupaten'] = $this->common_model->get_record_value('dapemda_nm_dati2', 'data_pemerintah_daerah', 'dapemda_id=1');
				
				$bidang_usaha = array();
				$arr_bidang_usaha = $this->common_model->get_bidang_usaha();			
				if (count($arr_bidang_usaha))
				{
					foreach ($arr_bidang_usaha as $row)
					{
						$bidang_usaha[$row->ref_kodus_id] = $row->ref_kodus_kode.'.'.$row->ref_kodus_nama;
					}
				}
				$data['bidang_usaha'] = $bidang_usaha;
				$data['kewarganegaran'] = array('WNI' => 'WNI', 'WNA' => 'WNA');
				$data['tanda_bukti'] = array('KTP' => 'KTP', 'SIM' => 'SIM', 'PASPOR' => 'PASPOR');
				$data['pekerjaan'] = array('' => '-', 'PEGAWAI NEGERI' => 'PEGAWAI NEGERI', 'PEGAWAI SWASTA' => 'PEGAWAI SWASTA', 
											'ABRI' => 'ABRI', 'PEMILIK USAHA' => 'PEMILIK USAHA', '-' => 'LAINNYA');
				
				$this->load->view('edit_calon_wp', $data);
			} else {
				echo 'ID Wajib Pajak tidak ditemukan.';
			}
		} else {
			echo 'ID Wajib Pajak tidak ada. Silahkan masukkan terlebih dahulu';	
		}
	}
	
	/**
	 * saved data inserted
	 */
	function save() {
		echo json_encode($this->calon_wp_model->insert_data());
	}
	
	/**
	 * update data
	 */
	function update() {
		echo json_encode($this->calon_wp_model->update_data());
	}
	
/**
	 * delete page controller
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->calon_wp_model->delete_data($arr_id[$i]) == true)
				$counter++;
		}
		
		if ($counter != 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data berhasil yang dihapus";
		}
	}
}