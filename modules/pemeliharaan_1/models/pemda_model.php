<?php 
/**
 * Pemda model class
 * @author Daniel
 */
class Pemda_model extends CI_Model 
{
	/**
	 * get content
	 */
	function get_content()
	{
		$this->db->select('*');
		$query = $this->db->get('data_pemerintah_daerah');
		return $query;
	}
	
	/**
	 * update data_pemerintah_daerah 
	 */
	function update() {
		// check uploaded file size
        $file_sze = $_FILES['logo']['size'] ;
        $file_tmp = $_FILES['logo'][tmp_name];
        $file_type = $_FILES['logo'][type];
        $file_name = $_FILES['logo'][name];
        $allowedFileTypes = array("image/gif", "image/jpeg", "image/jpg","image/pjpeg");
        $uploadDir = "assets/images/";   // set the name of the target directory

        $record = array();
        $record['dapemda_kode'] = $this->input->post('dapemda_kode');
        $record['dapemda_nama'] = $this->input->post('dapemda_nama');
        $record['dapemda_lokasi'] = $this->input->post('dapemda_lokasi');
        $record['dapemda_pejabat'] = $this->input->post('dapemda_pejabat');
        $record['nama_dinas'] = stripslashes($this->input->post('nama_dinas'));
        $record['nama_singkatan'] = stripslashes($this->input->post('nama_singkatan'));
        $record['dapemda_no_telp'] = $this->input->post('dapemda_no_telp');
        $record['dapemda_ibu_kota'] = $this->input->post('dapemda_ibu_kota');
        $record['dapemda_nm_dati2'] = $this->input->post('dapemda_nm_dati2');
        $record['dapemda_bank_nama'] = $this->input->post('dapemda_bank_nama');
        $record['dapemda_bank_norek'] = $this->input->post('dapemda_bank_norek');
        
		if (!empty($file_name)) {
            // copy the uploaded file to the directory
            if (move_uploaded_file($file_tmp, $uploadDir.$file_name)) {
               // display success message
               // echo ("File successfully uploaded to ".$uploadDir.$file_name);
               $record['dapemda_logo_path'] = "images/".$file_name;
            }
            else {
                die("Cannot copy uploaded file");
            }
        }
        
        $this->db->where('dapemda_id', $this->input->post('dapemda_id'));
        $this->db->update('data_pemerintah_daerah', $record);
        
        if ($this->db->affected_rows() > 0)
        	return true;
        else 
        	return false;
	}	
}