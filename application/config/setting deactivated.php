<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * import data upload file
 * @var unknown_type
 */
$config['import_files'] = '/var/www/html/simpatda_bekasi/files/import_data/';

/*
 * pendataan status configuration 
 */
$config['status_spt_self'] = '8';
$config['status_spt_official'] = '1';
$config['status_spt_retribusi'] = '9';
$config['status_skrd'] = '9';
$config['status_stpd'] = '3';
$config['status_strd'] = '4';
$config['status_skpd'] = '1';
$config['status_skpdt'] = '2';
$config['status_skpdkb'] = '11';
$config['status_skpdkbt'] = '15';
$config['status_skpdlb'] = '12';
$config['status_skpdn'] = '14';

/*
 * kodus configuration
 */
$config['kodus_hotel'] = '1';
$config['kodus_restoran'] = '16';
$config['kodus_hiburan'] = '11';
$config['kodus_reklame'] = '5';
$config['kodus_genset'] = '12';
$config['kodus_parkir'] = '14';
$config['kodus_air_bawah_tanah'] = '18';


/*
 * korek configuration
 */
$config['korek_hotel'] = '41101';
$config['korek_restoran'] = '41102';
$config['korek_hiburan'] = '41103';
$config['korek_reklame'] = '41104';
$config['korek_genset'] = '41105';
$config['korek_parkir'] = '41107';
$config['korek_air_bawah_tanah'] = '41108';

/*
 * spt_jenis_pajak
 */
$config['jenis_pajak_hotel'] = '1';
$config['jenis_pajak_restoran'] = '2';
$config['jenis_pajak_hiburan'] = '3';
$config['jenis_pajak_reklame'] = '4';
$config['jenis_pajak_genset'] = '5';
$config['jenis_pajak_parkir'] = '7';
$config['jenis_pajak_air_bawah_tanah'] = '8';


/**
 * length kohir spt
 * @var unknown_type
 */
$config['length_kohir_spt'] = '4';
$config['length_no_spt'] = '4';

$config['nama_jabatan_kepala_dinas'] = "Kepala Badan Pendapatan Daerah";

/**
 * persentase denda
 * @var unknown_type
 */
$config['bunga'] = 2;

/**
 * message for saved data to database
 * @var unknown_type
 */
$config['msg_success'] = "Data berhasil disimpan";
$config['msg_fail'] = "Data gagal disimpan";

$config['default_mengetahui'] = "1";
$config['default_diperiksa'] = "82";