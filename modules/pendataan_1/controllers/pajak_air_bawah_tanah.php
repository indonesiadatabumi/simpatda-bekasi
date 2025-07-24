<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pajak_air_bawah_tanah controller
 * @package Simpatda
 * @author Daniel Hutauruk
 * @version 20121016
 */
class Pajak_air_bawah_tanah extends Master_Controller {
	/**
	 * constructor
	 */
	function __construct() {
		parent::__construct();
		$this->load->model('common_model');
		$this->load->model('rekening_model');
		$this->load->model('spt_model');
		$this->load->model('pajak_air_bawah_tanah_model');
	}
	
	/**
	 * get rekening air tanah
	 */
	function get_rekening() {
		$result = array();
		$rekening = $this->rekening_model->find_rekening();
	
		if ($rekening != false) {			
			$result = array('status' => true, 'korek_id' => $rekening['korek_id'], 'korek' => "(".$rekening['koderek_titik'].") ".$rekening['korek_nama'], 'persen_tarif' => $rekening['korek_persen_tarif']);
		}
		else
			$result = array('status' => false, 'msg' => 'Rekening tidak ditemukan');
	
		echo json_encode($result);
	}
	
	/**
	 * add page controller
	 */
	function add() {
		$data['sistem_pemungutan'] = array('2' => 'Official Assesment');
		$this->load->view('add_pajak_air_bawah_tanah', $data);
	}
	
	/**
	 * insert data sptpd
	 */
	function save() {
		$result = array();
		$wp_id = $this->input->post('wp_wr_id');
		
		if (!empty($wp_id)) {
			$check_masa_pajak = $this->spt_model->check_masa_pajak(
															$wp_id, 
															$this->input->post('spt_periode_jual1'),
															$this->input->post('spt_periode_jual2'),
															$this->input->post('korek'),
															$this->input->post('spt_jenis_pemungutan')
															);
			if (!$check_masa_pajak) {
				//save spt and spt_detail
				$spt_id = $this->spt_model->insert_spt();
				
				if ($spt_id != 0) {
					//insert into spt_detail
					$this->pajak_air_bawah_tanah_model->insert_spt_detail($spt_id);
					$result = array('status' => true, 'msg' => 'Data berhasil disimpan');
					
					//insert history log
					$this->common_model->history_log("pendataan", "i", "Insert Data Pajak Air Tanah : ".
							$spt_id." | ".$_POST['spt_periode']." | ".$_POST['spt_kode'].$_POST['spt_no_register']." | ".strtoupper($_POST['wp_wr_nama'])." | ".$_POST['spt_pajak']);
				} else {
					$result = array('status' => false, 'msg' => 'Data tidak berhasil disimpan');
				}
			} else {
				$result = array('status' => false, 'msg' => 'WPWR untuk periode penjualan yang sama sudah pernah diinput');
			}
		} else {
			$result = array('status' => false, 'msg' => 'Silahkan masukkan data WP terlebih dahulu');
		}
		
		echo json_encode($result);
	}
	
	/**
	 * view data
	 */
	function view() {
		$this->load->view('view_pajak_air_bawah_tanah');	
	}
	
	/**
	 * get list sptpd
	 */
	function get_list() {
		$this->pajak_air_bawah_tanah_model->get_list();
	}
	
	/**
	 * edit pajak controller
	 */
	function edit() {
		$sptpd = $this->spt_model->get_sptpd();
		$data['sistem_pemungutan'] = array('2' => 'Official Assesment');
		//load rekening
		$this->load->model('rekening_model');
		$data['rekening'] = $this->rekening_model->get_arr_list('41108', true);
	
		if ($sptpd != false) {
			//get spt_detail
			$spt_detail = $this->pajak_air_bawah_tanah_model->get_spt_detail();
			$data['row'] = $sptpd;
			$data['row_detail'] = $spt_detail;
			$this->load->view('edit_pajak_air_bawah_tanah', $data);	
		}
	}
	
	/**
	 * update data sptpd
	 */
	function update() {
		$result = array();
		$wp_id = $this->input->post('wp_wr_id');
		$spt_id = $this->input->post('spt_id');
		
		if (!empty($wp_id) && !empty($spt_id)) {
			//update spt and spt_detail
			$check_masa_pajak = $this->spt_model->check_masa_pajak(
															$wp_id, 
															$this->input->post('spt_periode_jual1'),
															$this->input->post('spt_periode_jual2'),
															$this->input->post('korek'),
															$this->input->post('spt_jenis_pemungutan'),
															$this->input->post('spt_id')
															);
			if (!$check_masa_pajak) {
				$return = $this->spt_model->update_spt();
				if ($return) {
					$this->pajak_air_bawah_tanah_model->update_spt_detail($spt_id);
					$result = array('status' => true, 'msg' => 'Data berhasil disimpan');
					//insert history log
					$this->common_model->history_log("pendataan", "U", "Update Data Pajak Air Tanah : ".
						$_POST['spt_id']." | ".$_POST['spt_periode']." | ".$_POST['spt_no_register']." | ".strtoupper($_POST['wp_wr_nama'])." | ".$_POST['spt_pajak']);
				}
				else 
					$result = array('status' => false, 'msg' => 'Data tidak berhasil disimpan');
			} else {
				$result = array('status' => false, 'msg' => 'WPWR untuk periode penjualan yang sama sudah pernah diinput');
			}				
		} else {
			$result = array('status' => false, 'msg' => 'Silahkan masukkan data WP terlebih dahulu');
		}
		
		echo json_encode($result);
	}
	
	/**
	 * deleta data pajak
	 */
	function delete() {
		$result = "";
		$counter = 0;
		
		$arr_id = explode("|", $this->input->post('id'));
		for ($i = 0; $i < count($arr_id) - 1; $i++) {
			if($this->spt_model->delete_spt_all($arr_id[$i]) == true) {
				$counter++;
				//insert history log
				$this->common_model->history_log("pendataan", "D", "Delete Data Pajak Air Tanah : ".$arr_id[$i]);
			}
		}
		
		if ($counter != 0) {
			echo $counter." data berhasil dihapus";
		} else {
			echo "Tidak ada data yang berhasil dihapus";
		}
	}
	
	/**
	 * load view form upload
	 */
	function view_upload() {
		$this->load->view('upload_pajak_air_tanah');
	}
	
	/**
	 * prepare upload
	 */
	function prepare_upload() {
		//load library excel reader
		$this->load->library('excel_reader');
				
		$path = ""; 
		$status = false;
		$file_element_name = 'userfile';
		
		$config['file_name'] = date("YmdHis");
		$config['upload_path'] = "files/upload_air_tanah/";
		$config['allowed_types'] = "csv";
		$config['max_size'] = '1024';
		
		//load library upload
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload($file_element_name)) {
			$status = false;
			$msg = $this->upload->display_errors('', '');
		} else {
			$upload = $this->upload->data();
			$path = $upload['full_path'];
			$counter = 0;
			
			if ($upload['file_ext'] == ".csv") {
				try {
					//open the csv file
					$file = fopen($path, "rb");
					
					while (($data = fgetcsv($file, 8000, ",")) !== false) {
						if (!empty($data[2]) && !empty($data[4]) && !empty($data[5]) && !empty($data[6]) && !empty($data[7]) && !empty($data[8])) {
							$counter++;
						}
					}
					//dikurang 1 untuk baris pertama
					if ($counter > 0) $counter -= 1;
					
					$status = true;
					fclose($file);
				} catch (Exception $e) {
					$status = "error";
					$msg = "Error $e";
				}
			} elseif ($upload['file_ext'] == ".xls") {
				try {
					$this->excel_reader->read($path);
					// Read the first workbook in the file
					$worksheetrows = $this->excel_reader->worksheets[0];
					//Set number of columns in your Excel file
					$worksheetcolumns = 9;
					
					$data = array();
					
					foreach($worksheetrows as $worksheetrow)
					{
						if ($counter == 0) {
							continue;
						}
					   	
					   	$counter++;
					}
					
					$status = true;
				} catch (Exception $e) {
					$status = false;
					$msg = "Error $e";
				}	
			}
		}
		
		@unlink($_FILES["txt_attachment"]);
		
		if ($status == true) {
			echo json_encode(array('status' => $status, 'file_path' => $path, 'total' => $counter));
		} else {
			echo json_encode(array('status' => $status, 'msg' => $msg));	
		}		
	}
	
	/**
	 * insert data upload air tanah
	 */
	function insert_upload() {
		$total_success = 0;
		$total_failed = 0;
		
		$file_path = $this->input->post('file_path');
		$spt_kode_rek = $this->common_model->get_record_value('korek_id', 'v_kode_rekening_pajak5digit', "koderek='".$this->input->post('korek')."'");
		$rekening = $this->rekening_model->find_rekening();
		$korek_id = $rekening['korek_id'];
		$korek_persen_tarif = $rekening['korek_persen_tarif'];		
		
		if (!empty($file_path)) {
			$file_ext = substr($file_path, -3);
			$counter = 0;
			
			if ($file_ext == "csv") {
				try {
					//open the csv file
					$file = fopen($file_path, "rb");
					
					while (($data = fgetcsv($file, 8000, ",")) !== false) {
						if ($counter == 0) {
							$counter++;
							continue;
						}
												
						if (!empty($data[2]) && !empty($data[4]) && !empty($data[5]) && !empty($data[6]) && !empty($data[7]) && !empty($data[8])) {
							$arr_val = explode('.', $data[7]);
							$volume = str_replace(',', '', $arr_val[0]);
							
							$arr_val = explode('.', $data[8]);
							$npa = str_replace(',', '', $arr_val[0]);
						
							$wp_id = $this->pajak_air_bawah_tanah_model->get_wp_id(trim($data[2]), $this->input->post('kodus_id'));
							$arr_masa_pajak = explode('-', $data[6]);
				   		 	$periode_jual1 = date("Y-m-d", mktime(0,0,0,$arr_masa_pajak[0], 1, $arr_masa_pajak[1]));						   					   	
						   	$periode_jual2 = date("Y-m-d", mktime(0,0,0,$arr_masa_pajak[0] + 1, 0, $arr_masa_pajak[1]));
							
					   		 if ($wp_id != null && $wp_id != false) {
					   		 	$pajak = ceil(round($npa * $korek_persen_tarif / 100) / 100) * 100;
					   		 	
					   		 	$check_masa_pajak = $this->spt_model->check_masa_pajak(
																$wp_id, 
																format_tgl($periode_jual1),
						   		 								format_tgl($periode_jual2),
																$this->input->post('korek'),
																2
																);
																					
								if (!$check_masa_pajak) {
									$spt_id = $this->pajak_air_bawah_tanah_model->insert_spt_air_tanah(
						   		 											$data[5],
						   		 											$spt_kode_rek,
						   		 											$periode_jual1,
						   		 											$periode_jual2,
						   		 											$this->config->item('status_skpd'),
						   		 											$pajak,
						   		 											$this->input->post('spt_jenis_pajakretribusi'),
						   		 											$wp_id,
						   		 											format_tgl($data[4]),
						   		 											date("Y-m-d")
						   		 										);
						   		 	
						   		 	if ($spt_id != 0) {
						   		 		$total_success ++;
						   		 		//insert spt detail
						   		 		$this->pajak_air_bawah_tanah_model->insert_spt_detail_air_tanah(
						   		 											$spt_id,
						   		 											$korek_id,
						   		 											$volume,
						   		 											$npa,
						   		 											$korek_persen_tarif,
						   		 											$pajak
						   		 										);
						   		 	
						   		 	} else {
						   		 		$total_failed ++;
						   		 	}		   		 	
								} else {
									$total_failed ++;
								}
							} else {
								$total_failed++;
							}
						}		
					}
					$status = true;
					fclose($file);						
				} catch (Exception $e) {
					$status = false;
					$msg = "Error $e";
				}
			} elseif ($file_ext == "xls") {
				//load library excel reader
				$this->load->library('excel_reader');
			
				try {
					$this->excel_reader->read($file_path);
					// Read the first workbook in the file
					$worksheetrows = $this->excel_reader->worksheets[0];
					//Set number of columns in your Excel file
					$worksheetcolumns = 9;
					
					$data = array();
					$total_rows = 0;
					foreach($worksheetrows as $worksheetrow)
					{
						if ($counter == 0) {
							$counter++;
							continue;
						}
						
						for($i=0; $i<$worksheetcolumns; $i++)
					    {
				           // if the field is not blank -- otherwise CI will throw warnings
				           if (isset($worksheetrow[$i])) {
				           		if ($i == 1) $data['npwpd'] = $worksheetrow[$i];
				           		elseif ($i == 4) $data['tgl_proses'] = $worksheetrow[$i];
				           		elseif ($i == 5) $data['periode'] = $worksheetrow[$i];
				           		elseif ($i == 6) $data['masa_pajak'] = $worksheetrow[$i];
				           		elseif ($i == 7) $data['volume'] = $worksheetrow[$i];
				           		else  $data['npa'] = $worksheetrow[$i];
				           }
				           // empty field
				           else {
				           		if ($i == 1) $data['npwpd'] = "";
				           		elseif ($i == 4) $data['tgl_proses'] = "";
				           		elseif ($i == 5) $data['periode'] = "";
				           		elseif ($i == 6) $data['masa_pajak'] = "";
				           		elseif ($i == 7) $data['volume'] = "";
				           		else  $data['npa'] = "";
				           }
					   	}
					   	
					   	if (!empty($data['npwpd']) && !empty($data['tgl_proses']) && !empty($data['periode']) && !empty($data['masa_pajak']) && !empty($data['volume']) && !empty($data['npa'])) {
					   		 $wp_id = $this->pajak_air_bawah_tanah_model->get_wp_id(trim($data['npwpd']), $this->input->post('kodus_id'));
					   		 $periode_jual1 = date("Y-m-d", ($data['masa_pajak']-25569) * 86400);
						   	 $arr_masa_pajak = explode('-', $periode_jual1);				   	
						   	 $periode_jual2 = date("Y-m-d", mktime(0,0,0,$arr_masa_pajak[1] + 1, 0, $arr_masa_pajak[0]));
	
					   		 if ($wp_id != null && $wp_id != false) {
					   		 	$pajak = (round((($data['npa'] * $korek_persen_tarif) / 100)) / 100) * 100;
					   		 	
					   		 	$check_masa_pajak = $this->spt_model->check_masa_pajak(
																$wp_id, 
																format_tgl($periode_jual1),
						   		 								format_tgl($periode_jual2),
																$this->input->post('korek'),
																2
																);
																					
								if (!$check_masa_pajak) {
									$spt_id = $this->pajak_air_bawah_tanah_model->insert_spt_air_tanah(
						   		 											$data['periode'],
						   		 											$spt_kode_rek,
						   		 											$periode_jual1,
						   		 											$periode_jual2,
						   		 											$this->config->item('status_skpd'),
						   		 											$pajak,
						   		 											$this->input->post('spt_jenis_pajakretribusi'),
						   		 											$wp_id,
						   		 											format_tgl($data['tgl_proses']),
						   		 											date("Y-m-d")
						   		 										);
						   		 	
						   		 	if ($spt_id != 0) {
						   		 		$total_success ++;
						   		 		//insert spt detail
						   		 		$this->pajak_air_bawah_tanah_model->insert_spt_detail_air_tanah(
						   		 											$spt_id,
						   		 											$korek_id,
						   		 											unformat_currency($data['volume']),
						   		 											unformat_currency($data['npa']),
						   		 											$korek_persen_tarif,
						   		 											$pajak
						   		 										);
						   		 	
						   		 	} else {
						   		 		$total_failed ++;
						   		 	}		   		 	
								} else {
									$total_failed ++;
								}							
					   		 }
					   	}
	
					   	
					   	$counter++;
					}
					
					$status = true;
				} catch (Exception $e) {
					$status = false;
					$msg = "Error $e";
				}	
			}
		} else {
			$status = false;
			$msg = "Error file not found.";
		}
		
		if ($status == true) {
			echo json_encode(array('status' => $status, 'msg' => $total_success." berhasil disimpan. $total_failed gagal disimpan."));
			$this->common_model->history_log("PENDATAAN", "I", "Insert data upload air tanah. $total_success sukses, $total_failed gagal");
		} else {
			echo json_encode(array('status' => $status, 'msg' => $msg));	
		}
	}
}