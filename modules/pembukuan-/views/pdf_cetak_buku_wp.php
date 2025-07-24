<?php 

error_reporting(E_ERROR);

// Load library FPDF
define('FPDF_FONTPATH',$this->config->item('fonts_path'));

require_once APPPATH.'libraries/fpdf/table/class.fpdf_table.php';
require_once APPPATH.'libraries/fpdf/table/table_def.inc';
require_once APPPATH.'libraries/fpdf/table/header_footer.inc';

$pdf = new FPDF_TABLE('L','mm','A4'); // Portrait dengan ukuran kertas A4
$pdf->Open();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetLeftMargin(4);

$pdf->SetStyle("sb","arial","B",7,"0,0,0");
$pdf->SetStyle("b","arial","B",8,"0,0,0");
$pdf->SetStyle("h1","arial","B",8,"0,0,0");
$pdf->SetStyle("nu","arial","U",8,"0,0,0");
$pdf->SetStyle("th1","arial","B",10,"0,0,0");

if($this->input->get('jenis_pemungutan') == 2) {    //  OFFICIAL ASSESMENT
     $npwprd = $attributes['wp_wr_jenis'].".".$attributes['wp_wr_gol'].".".$attributes['wp_wr_no_urut'].".".$attributes['wp_wr_kd_camat'].".".$attributes['wp_wr_kd_lurah'];
     $wpwr = call_data_wpwr ($npwprd); // $attributes[masa1],$attributes[masa2],$attributes[spt_kode_rek],$attributes[camat_id],$attributes['status_spt']);
     $title_column = "P E N E T A P A N";
     $column_tgl = "TANGGAL";
     $column_kohir = "NO. KOHIR";
     $column_jumlah = "JUMLAH KETETAPAN";
     $column_ketetapan = "KETETAPAN";
}
elseif($this->input->get('jenis_pemungutan') == 1) {   //  SELF ASSESMENT
      $npwprd = $attributes['wp_wr_jenis'].$attributes['wp_wr_gol'].$attributes['wp_wr_no_urut'].$attributes['wp_wr_kd_camat'].$attributes['wp_wr_kd_lurah'];
      $wpwr = call_data_wpwr_self ($npwprd); // $attributes[masa1],$attributes[masa2],$attributes[spt_kode_rek]);
      $title_column = "D A T A   S P T P D ";
      $column_tgl = "TANGGAL";
     $column_kohir = "NO. SPT";
     $column_jumlah = "DASAR OMSET";
     $column_ketetapan = "PAJAK";
}


if (!empty($wpwr)) {
	
}


?>