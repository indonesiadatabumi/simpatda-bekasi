<?php 
	$menus = array();
	$sub_menus = array();
	$sub_sub_menus = array();
	
	if (($this->session->userdata('USER_JABATAN') == '200')) {
		$menus = array('pendaftaran' => 'Pendaftaran', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'bkp' => 'BKP', 'pelaporan' => 'Pembukuan', 'penagihan' => 'Penagihan',
						'pemeliharaan' => 'Pemeliharaan');
		
		$sub_menus = array('pendaftaran' => array(
								'pendaftaran/wp_pribadi' => 'Rekam Master WP Pribadi', 
								'pendaftaran/wp_badan_usaha' => 'Rekam Master WP Badan Usaha',
								'pendaftaran/calon_wp' => 'Rekam Calon WP',
								//'pendaftaran/rekam_formulir' => 'Rekam Formulir Pendaftaran',
								//'pendaftaran/cetak_daftar_formulir' => 'Cetak Daftar Formulir Pendaftaran',
								'pendaftaran/cetak_kartu_npwpd' => 'Cetak Kartu NPWPD',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data',
								'pendaftaran/penonaktifan_wpwr' => 'Penonaktifan WP/WR',
								'pendaftaran/penutupan_wpwr' => 'Penutupan WP/WR',
								'pendaftaran/pembukaan_kembali_wpwr' => 'Pembukuan Kembali WP/WR'
							),
							'pendataan' => array(
								'popup_pendataan/objek_pajak/popup_jenis_pajak' => 'Rekam Data Objek Pajak',
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'' => '',
								//'pendataan/sptpd' => 'Cetak SPTPD',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data',
								'pendataan/kartu_data/daftar' => 'Cetak Daftar Kartu Data',
								'pendataan/wp_belum_lapor/daftar' => 'Rekap Wp Belum Lapor'
								//'pendataan/surat_teguran/daftar' => 'Daftar Surat Teguran'
							),
							'penetapan' => array(
								'penetapan/skpd' => 'Proses Penetapan Pajak',
								'penetapan/lhp' => 'Proses Penetapan LHP',
								'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
								'penetapan/daftar_jam_tayang' => 'Cetak Daftar Habis Jam Tayang'
							),
							'bkp' => array(
								'bkp/rekam_pajak/setor_pajak' => 'Rekam Setoran Pajak',
								'bkp/setoran_dinas' => 'Rekam Setoran Retribusi',
								//'bkp/rekam_pajak/proses_setoran' => 'Rekam Penerimaan Pajak',
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak Surat Setoran Pajak Daerah (SSPD)',
								'bkp/setor_bank' => 'Cetak Surat Tanda Setoran(STS)',
								'bkp/sts' => 'Daftar Surat Tanda Setoran',						
								'' => '',
								'bkp/rekapitulasi' => 'Cetak Rekapitulasi Penerimaan Harian',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',								
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'
								//'bkp/laporan_penerimaan' => 'Cetak Laporan Pertanggungjawaban Penerimaan',
								//'sub_menu_kasir' => 'Petugas Loker/Kasir Penerima',
								//'sub_menu_bendahara' => 'Bendahara Penerima'
							),
							'pemeliharaan' => array(
								'sub_menu_menu_master' => 'Menu Master', 
								'sub_menu_menu_reklame' => 'Menu Reklame',
								//'pemeliharaan/backup_data' => 'Backup Data SPT',								
								//'pemeliharaan/restore_data' => 'Restore Data SPT',
								//'pemeliharaan/backup_data_wp' => 'Backup Wajib Pajak (WP)'
								//'dsp_form_op_multi' => 'Rekam Object Pajak Multi',
								//'pemeliharaan/dsp_form_import_wpwr_data' => 'Import WP/WR Data',
								//'pemeliharaan/dsp_form_import_kec_kel_data' => 'Import Kecamatan & Kelurahan Data'
							),							
							'pelaporan' => array(
								'sub_menu_menu_penerimaan' => 'Pembukuan Penerimaan',
								'sub_menu_menu_pelaporan' => 'Pembukuan Pelaporan'
							),			
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran Pembayaran',
								//'penagihan/surat_tegurann' => 'Cetak Surat Teguran Pembayaran di bawah satu juta',
								'penagihan/surat_teguran_laporan' => 'Cetak Surat Teguran Laporan',
								'penagihan/stpd/add' => 'Rekam STPD Pembayaran',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD Pembayaran',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan',
								'penagihan/kartu_data_wp' => 'Grafik Kartu Data WP',
								'penagihan/tunggakan' => 'Daftar Tunggakan WP'
								//'sub_menu_menu_penagihan' => 'Penagihan'
							),							
					);
					
		$sub_sub_menus = array(
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr_baru' => 'Cetak Daftar Induk WP Baru',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_nonaktif' => 'Cetak Daftar WP Non Aktif',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup',
								'pendaftaran/dokumentasi_pengolahan/daftar_perkembangan_wpwr' => 'Cetak Daftar Perkembangan WP'
							),
							'kasir' => array(
								'bkp/rekam_pajak' => 'Rekam Penerimaan Pajak',
								'' => '',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',
								'bkp/rekap_setoran' => 'Cetak Rekapitulasi Daftar Ketetapan dan Setoran'
							),
							'bendahara' => array(
								'bkp/setor_bank' => 'Rekam Penyetoran ke Bank',
								'bkp/sts' => 'Cetak STS (Surat Setoran ke Bank)',
								'bkp/laporan_penerimaan' => 'Cetak Laporan Pertanggungjawaban Penerimaan & Penyetoran Uang',
								'bkp/kas_umum' => 'Cetak Buku Kas Umum',
								'bkp/jurnal_keluar_kas' => 'Cetak Buku Jurnal Keluar Kas',
								'bkp/realisasi_penerimaan' => 'Cetak Laporan Realisasi Penerimaan Pajak Daerah',
								'bkp/realisasi_setoran' => '++ Realisasi Penerimaan Setoran Harian Pajak Daerah'
							),
							'menu_master' => array(
								'pemeliharaan/pemda' => 'Tabel Pemda',								
								'pemeliharaan/satuan_kerja' => 'Tabel Satuan Kerja Kab/Kota',
								'pemeliharaan/uptd' => 'Tabel UPTD',
								'pemeliharaan/kecamatan' => 'Tabel Kecamatan',
								'pemeliharaan/kelurahan' => 'Tabel Kelurahan',
								'pemeliharaan/anggaran' => 'Tabel Anggaran',
								'pemeliharaan/kode_rekening' => 'Tabel Kode Rekening',
								'pemeliharaan/pos_anggaran' => 'Tabel Pos Anggaran',
								'pemeliharaan/pejabat' => 'Tabel Pejabat',
								'pemeliharaan/operator' => 'Tabel Operator',
								'pemeliharaan/keterangan_spt' => 'Tabel Keterangan SPT',
								//'pemeliharaan/dsp_mstr_printer' => 'Tabel Printer',
								'pemeliharaan/kode_usaha' => 'Tabel Kode Usaha',
								'pemeliharaan/jatuh_tempo' => 'Jatuh Tempo',
								//'pemeliharaan/dsp_mstr_password' => 'Tabel Password',
								'pemeliharaan/history_log' => 'History Log'
							),							
							'menu_reklame' => array(
								//'pemeliharaan/dsp_list_njopr' => 'Tabel NJOP Reklame',
								//'pemeliharaan/dsp_ref_ayat_reklame_jenis_njopr' => 'Tabel Ayat Jenis NJOPR',
								//'pemeliharaan/dsp_list_sudut_pandang' => 'Sudut Pandang',
								'pemeliharaan/kelas_jalan' => 'Kelas Jalan',
								//'pemeliharaan/dsp_mstr_reklame_nilai_strategis' => 'Reklame - Nilai Strategis',
								//'pemeliharaan/dsp_mstr_rek_sudutpandang' => 'Sudut Pandang dan<br />Kelas Jalan',
								//'pemeliharaan/dsp_ref_jenisreklame' => 'Reklame - Jenis Reklame',
								'pemeliharaan/nilai_kelas_jalan' => 'Nilai Kelas Jalan'
							),
							'menu_penerimaan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak',
								'pembukuan/daftar_setoran' => 'Cetak Daftar Setoran'							
							),							
							'menu_pelaporan' => array(
							//	'pembukuan/pendapatan_pajak_daerah' => 'Cetak Laporan Pajak Daerah',
								//'pembukuan/pendapatan_daerah' => '* Cetak Laporan Pendapatan Daerah',
								//'pembukuan/rekap_pendapatan_daerah' => '** Cetak Rekap Pendapatan Daerah'								
							),
							'menu_penagihan' => array(
								'penagihan/dsp_form_cetak_buku_kendali' => 'Cetak Buku Kendali (Official Assesment)',
								'penagihan/dsp_form_cetak_buku_kendali&jepem=1' => 'Cetak Buku Kendali (Self Assesment)',
								'penagihan/dsp_form_cetak_surat_teguran' => 'Cetak Surat Teguran per NPWPD',
								//'penagihan/dsp_form_cetak_surat_tegurann' => 'Cetak Surat Teguran per NPWPD'
							),							
					);
		
	}
	else if (($this->session->userdata('USER_JABATAN') == '99') || ($this->session->userdata('USER_JABATAN') == '98')) {
		$menus = array('pendaftaran' => 'Pendaftaran', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'bkp' => 'BKP', 'pelaporan' => 'Pembukuan', 'penagihan' => 'Penagihan',
						'pemeliharaan' => 'Pemeliharaan');
		
		$sub_menus = array('pendaftaran' => array(
								'pendaftaran/wp_pribadi' => 'Rekam Master WP Pribadi', 
								'pendaftaran/wp_badan_usaha' => 'Rekam Master WP Badan Usaha',
								'pendaftaran/calon_wp' => 'Rekam Calon WP',
								//'pendaftaran/rekam_formulir' => 'Rekam Formulir Pendaftaran',
								//'pendaftaran/cetak_daftar_formulir' => 'Cetak Daftar Formulir Pendaftaran',
								'pendaftaran/cetak_kartu_npwpd' => 'Cetak Kartu NPWPD',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data',
								'pendaftaran/penonaktifan_wpwr' => 'Penonaktifan WP/WR',
								'pendaftaran/penutupan_wpwr' => 'Penutupan WP/WR',
								'pendaftaran/pembukaan_kembali_wpwr' => 'Pembukuan Kembali WP/WR'
							),
							'pendataan' => array(
								'popup_pendataan/objek_pajak/popup_jenis_pajak' => 'Rekam Data Objek Pajak',
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'' => '',
								//'pendataan/sptpd' => 'Cetak SPTPD',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data',
								'pendataan/kartu_data/daftar' => 'Cetak Daftar Kartu Data',
								'pendataan/wp_belum_lapor/daftar' => 'Rekap Wp Belum Lapor'
								//'pendataan/surat_teguran/daftar' => 'Daftar Surat Teguran'
							),
							'penetapan' => array(
								'penetapan/skpd' => 'Proses Penetapan Pajak',
								'penetapan/lhp' => 'Proses Penetapan LHP',
								'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
								'penetapan/daftar_jam_tayang' => 'Cetak Daftar Habis Jam Tayang'
							),
							'bkp' => array(
								'bkp/rekam_pajak/setor_pajak' => 'Rekam Setoran Pajak',
								'bkp/setoran_dinas' => 'Rekam Setoran Retribusi',
								//'bkp/rekam_pajak/proses_setoran' => 'Rekam Penerimaan Pajak',
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak Surat Setoran Pajak Daerah (SSPD)',
								'bkp/setor_bank' => 'Cetak Surat Tanda Setoran(STS)',
								'bkp/sts' => 'Daftar Surat Tanda Setoran',						
								'' => '',
								'bkp/rekapitulasi' => 'Cetak Rekapitulasi Penerimaan Harian',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',								
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'
								//'bkp/laporan_penerimaan' => 'Cetak Laporan Pertanggungjawaban Penerimaan',
								//'sub_menu_kasir' => 'Petugas Loker/Kasir Penerima',
								//'sub_menu_bendahara' => 'Bendahara Penerima'
							),
							'pemeliharaan' => array(
								'sub_menu_menu_master' => 'Menu Master', 
								'sub_menu_menu_reklame' => 'Menu Reklame',
								//'pemeliharaan/backup_data' => 'Backup Data SPT',								
								//'pemeliharaan/restore_data' => 'Restore Data SPT',
								//'pemeliharaan/backup_data_wp' => 'Backup Wajib Pajak (WP)'
								//'dsp_form_op_multi' => 'Rekam Object Pajak Multi',
								//'pemeliharaan/dsp_form_import_wpwr_data' => 'Import WP/WR Data',
								//'pemeliharaan/dsp_form_import_kec_kel_data' => 'Import Kecamatan & Kelurahan Data'
							),							
							'pelaporan' => array(
								'sub_menu_menu_penerimaan' => 'Pembukuan Penerimaan',
								//'sub_menu_menu_pelaporan' => 'Pembukuan Pelaporan'
							),			
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran Pembayaran',
								//'penagihan/surat_tegurann' => 'Cetak Surat Teguran Pembayaran di bawah satu juta',
								'penagihan/surat_teguran_laporan' => 'Cetak Surat Teguran Laporan',
								'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan',
								'penagihan/kartu_data_wp' => 'Grafik Kartu Data WP',
								'penagihan/tunggakan' => 'Daftar Tunggakan WP'
								//'sub_menu_menu_penagihan' => 'Penagihan'
							),							
					);
					
		$sub_sub_menus = array(
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr_baru' => 'Cetak Daftar Induk WP Baru',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_nonaktif' => 'Cetak Daftar WP Non Aktif',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup',
								'pendaftaran/dokumentasi_pengolahan/daftar_perkembangan_wpwr' => 'Cetak Daftar Perkembangan WP'
							),
							'kasir' => array(
								'bkp/rekam_pajak' => 'Rekam Penerimaan Pajak',
								'' => '',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',
								'bkp/rekap_setoran' => 'Cetak Rekapitulasi Daftar Ketetapan dan Setoran'
							),
							'bendahara' => array(
								'bkp/setor_bank' => 'Rekam Penyetoran ke Bank',
								'bkp/sts' => 'Cetak STS (Surat Setoran ke Bank)',
								'bkp/laporan_penerimaan' => 'Cetak Laporan Pertanggungjawaban Penerimaan & Penyetoran Uang',
								'bkp/kas_umum' => 'Cetak Buku Kas Umum',
								'bkp/jurnal_keluar_kas' => 'Cetak Buku Jurnal Keluar Kas',
								'bkp/realisasi_penerimaan' => 'Cetak Laporan Realisasi Penerimaan Pajak Daerah',
								'bkp/realisasi_setoran' => '++ Realisasi Penerimaan Setoran Harian Pajak Daerah'
							),
							'menu_master' => array(
								'pemeliharaan/pemda' => 'Tabel Pemda',								
								'pemeliharaan/satuan_kerja' => 'Tabel Satuan Kerja Kab/Kota',
								'pemeliharaan/uptd' => 'Tabel UPTD',
								'pemeliharaan/kecamatan' => 'Tabel Kecamatan',
								'pemeliharaan/kelurahan' => 'Tabel Kelurahan',
								'pemeliharaan/anggaran' => 'Tabel Anggaran',
								'pemeliharaan/kode_rekening' => 'Tabel Kode Rekening',
								'pemeliharaan/pos_anggaran' => 'Tabel Pos Anggaran',
								'pemeliharaan/pejabat' => 'Tabel Pejabat',
								'pemeliharaan/operator' => 'Tabel Operator',
								'pemeliharaan/keterangan_spt' => 'Tabel Keterangan SPT',
								//'pemeliharaan/dsp_mstr_printer' => 'Tabel Printer',
								'pemeliharaan/kode_usaha' => 'Tabel Kode Usaha',
								'pemeliharaan/jatuh_tempo' => 'Jatuh Tempo',
								//'pemeliharaan/dsp_mstr_password' => 'Tabel Password',
								'pemeliharaan/history_log' => 'History Log'
							),							
							'menu_reklame' => array(
								//'pemeliharaan/dsp_list_njopr' => 'Tabel NJOP Reklame',
								//'pemeliharaan/dsp_ref_ayat_reklame_jenis_njopr' => 'Tabel Ayat Jenis NJOPR',
								//'pemeliharaan/dsp_list_sudut_pandang' => 'Sudut Pandang',
								'pemeliharaan/kelas_jalan' => 'Kelas Jalan',
								//'pemeliharaan/dsp_mstr_reklame_nilai_strategis' => 'Reklame - Nilai Strategis',
								//'pemeliharaan/dsp_mstr_rek_sudutpandang' => 'Sudut Pandang dan<br />Kelas Jalan',
								//'pemeliharaan/dsp_ref_jenisreklame' => 'Reklame - Jenis Reklame',
								'pemeliharaan/nilai_kelas_jalan' => 'Nilai Kelas Jalan'
							),
							'menu_penerimaan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/daftar_setoran' => 'Cetak Daftar Setoran',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'								
							),							
							'menu_pelaporan' => array(
								//'pembukuan/pendapatan_pajak_daerah' => 'Cetak Laporan Pajak Daerah',
								//'pembukuan/pendapatan_daerah' => '* Cetak Laporan Pendapatan Daerah',
							//	'pembukuan/rekap_pendapatan_daerah' => '** Cetak Rekap Pendapatan Daerah'								
							),
							'menu_penagihan' => array(
								'penagihan/dsp_form_cetak_buku_kendali' => 'Cetak Buku Kendali (Official Assesment)',
								'penagihan/dsp_form_cetak_buku_kendali&jepem=1' => 'Cetak Buku Kendali (Self Assesment)',
								'penagihan/dsp_form_cetak_surat_teguran' => 'Cetak Surat Teguran per NPWPD',
								//'penagihan/dsp_form_cetak_surat_tegurann' => 'Cetak Surat Teguran per NPWPD'
							),							
					);
		
	} 
	//Operator Hotel
	else if ($this->session->userdata('USER_JABATAN') == '1') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'penagihan' => 'Penagihan',  'bkp' => 'BKP', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								//'pendaftaran/wp_badan_usaha' => 'Rekam Master WP Badan Usaha',
								'pendaftaran/cetak_kartu_npwpd' => 'Cetak Kartu NPWPD',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP'
							),
							'pendataan' => array(
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'pendataan/pajak_hotel/add' => 'Rekam Data Objek Pajak Hotel',
								'pendataan/pajak_hotel/view' => 'Lihat Daftar SPT Hotel',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'pendataan/kartu_data/pajak_hotel' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								'penetapan/lhp' => 'Proses Penetapan LHP',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
								'penetapan/daftar_jam_tayang' => 'Cetak Daftar Habis Jam Tayang'
							),
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
							'bkp' => array(
								//'sub_menu_kasir' => 'Petugas Loker/Kasir Penerima'
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak SSPD'
							),
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'								
							)				
					);
					
		$sub_sub_menus = array(
							'kasir' => array(
								'bkp/rekam_pajak' => 'Rekam Penerimaan Pajak'
							)						
					);
	}
	//Operator Restoran
	else if ($this->session->userdata("USER_JABATAN") == '2') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'penagihan' => 'Penagihan', 'bkp' => 'BKP', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								//'pendaftaran/wp_badan_usaha' => 'Rekam Master WP Badan Usaha',
								'pendaftaran/cetak_kartu_npwpd' => 'Cetak Kartu NPWPD',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP'
							),
							'pendataan' => array(
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'pendataan/pajak_restoran/add' => 'Rekam Data Objek Pajak Restoran',
								'pendataan/pajak_restoran/view' => 'Lihat Daftar SPT Restoran',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'pendataan/kartu_data/pajak_restoran' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								'penetapan/lhp' => 'Proses Penetapan LHP',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
								'penetapan/daftar_jam_tayang' => 'Cetak Daftar Habis Jam Tayang'
							),
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
							'bkp' => array(
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak SSPD'
							),
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							)					
					);
					
		$sub_sub_menus = array(
							'kasir' => array(
								'bkp/rekam_pajak' => 'Rekam Penerimaan Pajak'
							)						
					);
	}
	//Operator Hiburan
	else if ($this->session->userdata("USER_JABATAN") == '3') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'penagihan' => 'Penagihan', 'bkp' => 'BKP', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								//'pendaftaran/wp_badan_usaha' => 'Rekam Master WP Badan Usaha',
								'pendaftaran/cetak_kartu_npwpd' => 'Cetak Kartu NPWPD',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP'
							),
							'pendataan' => array(
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'pendataan/pajak_hiburan/add' => 'Rekam Data Objek Pajak Hiburan',
								'pendataan/pajak_hiburan/view' => 'Lihat Daftar SPT Hiburan',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'pendataan/kartu_data/pajak_hiburan' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								'penetapan/lhp' => 'Proses Penetapan LHP',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
								'penetapan/daftar_jam_tayang' => 'Cetak Daftar Habis Jam Tayang'
							),
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
							'bkp' => array(
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak SSPD'
							),
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							)					
					);
					
		$sub_sub_menus = array(
							'kasir' => array(
								'bkp/rekam_pajak' => 'Rekam Penerimaan Pajak'
							)						
					);
	}
	//Operator Reklame
	else if ($this->session->userdata("USER_JABATAN") == '4') {
		$menus = array('pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'penagihan' => 'Penagihan', 'bkp' => 'BKP', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendataan' => array(
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'pendataan/pajak_reklame/add' => 'Rekam Data Objek Pajak Reklame',
								'pendataan/pajak_reklame/view' => 'Lihat Daftar SPT Pajak Reklame',
								//'pendataan/kartu_data/pajak_reklame' => 'Cetak Kartu Data',
								//'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD'
							),
							'penetapan' => array(
								'penetapan/skpd' => 'Proses Penetapan Pajak',
								'penetapan/lhp' => 'Proses Penetapan LHP',
								'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
								'penetapan/daftar_jam_tayang' => 'Cetak Daftar Habis Jam Tayang'
							),
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
							'bkp' => array(
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak SSPD'
							),
							'pembukuan' => array(
								'pembukuan/daftar_setoran' => 'Cetak Daftar Setoran',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi'													
							)
					);
					
		$sub_sub_menus = array(
							'kasir' => array(
								'bkp/rekam_pajak' => 'Rekam Penerimaan Pajak'
							)						
					);
	}
	//Operator Pajak Penerangan Jalan / Genset
	else if ($this->session->userdata("USER_JABATAN") == '5') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'penagihan' => 'Penagihan', 'bkp' => 'BKP', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP'
							),
							'pendataan' => array(
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'pendataan/pajak_genset/add' => 'Rekam Data Objek Pajak Penerangan / Genset',
								'pendataan/pajak_pln/add' => 'Rekam Data Objek Pajak Penerangan PLN',
								'pendataan/pajak_genset/view' => 'Lihat Daftar SPT Pajak Penerangan / Genset',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'pendataan/kartu_data/pajak_genset' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								'penetapan/lhp' => 'Proses Penetapan LHP',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
								'penetapan/daftar_jam_tayang' => 'Cetak Daftar Habis Jam Tayang'
							),
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
							'bkp' => array(
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak SSPD'
							),
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							)
					);
					
		$sub_sub_menus = array(
							'kasir' => array(
								'bkp/rekam_pajak' => 'Rekam Penerimaan Pajak'
							)						
					);
	}
	//Operator Pajak Penerangan Jalan / Genset
	else if ($this->session->userdata("USER_JABATAN") == '47') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'penagihan' => 'Penagihan', 'bkp' => 'BKP', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP'
							),
							'pendataan' => array(
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								//'pendataan/pajak_genset/add' => 'Rekam Data Objek Pajak Penerangan / Genset',
								'pendataan/pajak_pln/add' => 'Rekam Data Objek Pajak Penerangan PLN',
								'pendataan/pajak_genset/view' => 'Lihat Daftar SPT Pajak Penerangan',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'pendataan/kartu_data/pajak_genset' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								'penetapan/lhp' => 'Proses Penetapan LHP',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
								'penetapan/daftar_jam_tayang' => 'Cetak Daftar Habis Jam Tayang'
							),
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
							'bkp' => array(
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak SSPD'
							),
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							)
					);
					
		$sub_sub_menus = array(
							'kasir' => array(
								'bkp/rekam_pajak' => 'Rekam Penerimaan Pajak'
							)						
					);
	}
	//Operator Parkir
	else if ($this->session->userdata("USER_JABATAN") == '7') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'penagihan' => 'Penagihan',  'bkp' => 'BKP', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								//'pendaftaran/wp_badan_usaha' => 'Rekam Master WP Badan Usaha',
								'pendaftaran/cetak_kartu_npwpd' => 'Cetak Kartu NPWPD',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP'
							),
							'pendataan' => array(
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'pendataan/pajak_parkir/add' => 'Rekam Data Objek Pajak Parkir',
								'pendataan/pajak_parkir/view' => 'Lihat Daftar SPT Pajak Parkir',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'pendataan/kartu_data/pajak_parkir' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								'penetapan/lhp' => 'Proses Penetapan LHP',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan'
							),
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
							'bkp' => array(
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak SSPD'
							),
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							)
					);
					
		$sub_sub_menus = array(
							'kasir' => array(
								'bkp/rekam_pajak' => 'Rekam Penerimaan Pajak'
							)						
					);
	}	
	//Operator Air Bawah Tanah
	else if ($this->session->userdata("USER_JABATAN") == '8') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'penagihan' => 'Penagihan', 'bkp' => 'BKP', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								//'pendaftaran/wp_badan_usaha' => 'Rekam Master WP Badan Usaha',
								'pendaftaran/cetak_kartu_npwpd' => 'Cetak Kartu NPWPD',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP'
							),
							'pendataan' => array(
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'pendataan/pajak_air_bawah_tanah/add' => 'Rekam Data Objek Pajak Air Tanah',
								'pendataan/pajak_air_bawah_tanah/view' => 'Lihat Daftar SPT Pajak Air Tanah',
								'pendataan/pajak_air_bawah_tanah/view_upload' => 'Upload Data Pajak Air Tanah',
								'pendataan/kartu_data/pajak_air_bawah_tanah' => 'Cetak Kartu Data'								
							),
							'penetapan' => array(
								'penetapan/skpd' => 'Proses Penetapan Pajak',
								'penetapan/lhp' => 'Proses Penetapan LHP',
								'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan'
							),
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
							'bkp' => array(
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak SSPD'
							),
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi'						
							)
					);
					
		$sub_sub_menus = array(
							'kasir' => array(
								'bkp/rekam_pajak' => 'Rekam Penerimaan Pajak'
							)						
					);
	} 
	
	//pendaftaran
	else if ($this->session->userdata("USER_JABATAN") == '9') {
		$menus = array('pendaftaran' => 'Master WP', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/wp_pribadi' => 'Rekam Master WP Pribadi', 
								'pendaftaran/wp_badan_usaha' => 'Rekam Master WP Badan Usaha',
								'pendaftaran/calon_wp' => 'Rekam Calon WP',
								'pendaftaran/rekam_formulir' => 'Rekam Formulir Pendaftaran',
								'pendaftaran/cetak_daftar_formulir' => 'Cetak Daftar Formulir Pendaftaran',
								'pendaftaran/cetak_kartu_npwpd' => 'Cetak Kartu NPWPD',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data',
								'pendaftaran/penonaktifan_wpwr' => 'Penonaktifan WP/WR',
								'pendaftaran/penutupan_wpwr' => 'Penutupan WP/WR',
								'pendaftaran/pembukaan_kembali_wpwr' => 'Pembukuan Kembali WP/WR'
							),
							'pembukuan' => array(
								//'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								//'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							)
							
							
					);	

		$sub_sub_menus = array(
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr_baru' => 'Cetak Daftar Induk WP Baru',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_nonaktif' => 'Cetak Daftar WP Non Aktif',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup',
								'pendaftaran/dokumentasi_pengolahan/daftar_perkembangan_wpwr' => 'Cetak Daftar Perkembangan WP'
							)
														
					);
					
	}
	
	
	//master operator
	else if ($this->session->userdata("USER_JABATAN") == '10') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 'bkp' => 'BKP', 'pemeliharaan' => 'Pemeliharaan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP'
							),
							'pendataan' => array(
								'popup_pendataan/objek_pajak/popup_jenis_pajak' => 'Rekam Data Objek Pajak',
								//'pendataan/sptpd' => 'Cetak SPTPD',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data',
								'pendataan/kartu_data/daftar' => 'Cetak Daftar Kartu Data'
							),
							'bkp' => array(
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak SSPD'
							),
							'pemeliharaan' => array(
								//'pemeliharaan/backup_data' => 'Backup Data SPT',								
								//'pemeliharaan/restore_data' => 'Restore Data SPT',
								//'pemeliharaan/backup_data_wp' => 'Backup Wajib Pajak (WP)'
							)				
					);		
	}

	//operator data entry
	else if ($this->session->userdata("USER_JABATAN") == '11') {
		$menus = array('pendaftaran' => 'Master WP','pendataan' => 'Pendataan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak'
							),
							'pendataan' => array(
								'popup_pendataan/objek_pajak/popup_jenis_pajak' => 'Rekam Data Objek Pajak',
								//'pendataan/sptpd' => 'Cetak SPTPD',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								//'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data',
								//'pendataan/kartu_data/daftar' => 'Cetak Daftar Kartu Data'
							),
										
					);		
	}

	//BKP
	else if ($this->session->userdata("USER_JABATAN") == '21') {
		$menus = array('pendaftaran' => 'Master WP','bkp' => 'BKP');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak'
							),
							
							'bkp' => array(
								'bkp/rekam_pajak/setor_pajak' => 'Rekam Penerimaan Pajak',
								//'bkp/rekam_pajak/proses_setoran' => 'Rekam Penerimaan Pajak',
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak Surat Setoran Pajak Daerah (SSPD)',
								'bkp/setor_bank' => 'Cetak Surat Tanda Setoran(STS)',
								'bkp/sts' => 'Daftar Surat Tanda Setoran',						
								'' => '',
								'bkp/rekapitulasi' => 'Cetak Rekapitulasi Harian Bendahara Penerimaan',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'							
							)						
					);
	}
	
	//validasi
	else if ($this->session->userdata("USER_JABATAN") == '46') {
		$menus = array('pendaftaran' => 'Master WP','bkp' => 'BKP','penagihan' => 'Penagihan','pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak'
							),
							'penagihan' => array(
								//'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								//'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								//'penagihan/kartu_data_wp' => 'Grafik Kartu Data WP',
								//'penagihan/tunggakan' => 'Daftar Tunggakan WP',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
							
							'bkp' => array(
								'bkp/rekam_pajak/setor_pajak' => 'Rekam Penerimaan Pajak',
								//'bkp/rekam_pajak/proses_setoran' => 'Rekam Penerimaan Pajak',
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak Surat Setoran Pajak Daerah (SSPD)',
								'bkp/setor_bank' => 'Cetak Surat Tanda Setoran(STS)',
								'bkp/sts' => 'Daftar Surat Tanda Setoran',						
								'' => '',
								'bkp/rekapitulasi' => 'Cetak Rekapitulasi Harian Bendahara Penerimaan',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'							
							),	
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/daftar_setoran' => 'Cetak Daftar Setoran',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							)
					);
	}
	
	//Pembukuan&Pelaporan
	else if ($this->session->userdata("USER_JABATAN") == '22') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'penagihan' => 'Penagihan',  'bkp' => 'BKP', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data'
								//'pendaftaran/penutupan_wpwr' => 'Penutupan WP/WR',
							),
							'pendataan' => array(
								//'pendataan/pajak_parkir/add' => 'Rekam Data Objek Pajak Parkir',
								//'pendataan/pajak_parkir/view' => 'Lihat Daftar SPT Pajak Parkir',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD'
								//'pendataan/kartu_data/pajak_parkir' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								//'penetapan/skpd/view' => 'Lihat SPT yang sudah ditetapkan',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								//'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan'
							),
							'penagihan' => array(
								//'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								//'penagihan/stpd/add' => 'Rekam STPD',
								//'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								'penagihan/kartu_data_wp' => 'Grafik Kartu Data WP',
								'penagihan/tunggakan' => 'Daftar Tunggakan WP',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
							'bkp' => array(
								'bkp/rekapitulasi' => 'Cetak Rekapitulasi Penerimaan Harian',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',								
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'
							),
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'					
							)
					);
					
		$sub_sub_menus = array(							
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup'
							),
							'menu_penerimaan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							),							
							'menu_pelaporan' => array(
								'pembukuan/pendapatan_pajak_daerah' => 'Cetak Laporan Pajak Daerah',
								'pembukuan/pendapatan_daerah' => '* Cetak Laporan Pendapatan Daerah',
								'pembukuan/rekap_pendapatan_daerah' => '** Cetak Rekap Pendapatan Daerah'		
							)						
					);
	}
	
	//Pembukuan&Pelaporan adkoni
	else if ($this->session->userdata("USER_JABATAN") == '43') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'penagihan' => 'Penagihan',  'bkp' => 'BKP', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data'
								//'pendaftaran/penutupan_wpwr' => 'Penutupan WP/WR',
							),
							'pendataan' => array(
								//'pendataan/pajak_parkir/add' => 'Rekam Data Objek Pajak Parkir',
								//'pendataan/pajak_parkir/view' => 'Lihat Daftar SPT Pajak Parkir',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD'
								//'pendataan/kartu_data/pajak_parkir' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								//'penetapan/skpd/view' => 'Lihat SPT yang sudah ditetapkan',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								//'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan'
							),
							'penagihan' => array(
								//'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								//'penagihan/stpd/add' => 'Rekam STPD',
								//'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								'penagihan/kartu_data_wp' => 'Grafik Kartu Data WP',
								'penagihan/tunggakan' => 'Daftar Tunggakan WP',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
							'bkp' => array(
								'bkp/rekapitulasi' => 'Cetak Rekapitulasi Penerimaan Harian',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',								
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'
							),
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi'						
							)
					);
					
		$sub_sub_menus = array(							
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup'
							),
							'menu_penerimaan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							),							
							'menu_pelaporan' => array(
								'pembukuan/pendapatan_pajak_daerah' => 'Cetak Laporan Pajak Daerah',
								'pembukuan/pendapatan_daerah' => '* Cetak Laporan Pendapatan Daerah',
								'pembukuan/rekap_pendapatan_daerah' => '** Cetak Rekap Pendapatan Daerah'		
							)						
					);
	}
	
	//Evaluasi
	elseif ($this->session->userdata('USER_JABATAN') == "23") {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan','penetapan' => 'Penetapan', 'penagihan' => 'Penagihan', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								//'pendaftaran/wp_badan_usaha' => 'Rekam Master WP Badan Usaha',
								//'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data',
								'pendaftaran/cetak_kartu_npwpd' => 'Cetak Kartu NPWPD'
								//'pendaftaran/penutupan_wpwr' => 'Penutupan WP/WR',
							),
							'pendataan' => array(
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								//'penetapan/skpd/view' => 'Lihat SPT yang sudah ditetapkan',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								//'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan'
							),
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran Pembayaran',
								//'penagihan/surat_tegurann' => 'Cetak Surat Teguran Pembayaran di bawah satu juta',
								'penagihan/surat_teguran_laporan' => 'Cetak Surat Teguran Laporan',
								//'penagihan/stpd/add' => 'Rekam STPD Pembayaran',
								//'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD Pembayaran',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan',
								//'penagihan/kartu_data_wp' => 'Grafik Kartu Data WP',
								'penagihan/tunggakan' => 'Daftar Tunggakan WP'
								//'sub_menu_menu_penagihan' => 'Penagihan'
							),
							
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'						
							)				
					);
					
		$sub_sub_menus = array(
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_nonaktif' => 'Cetak Daftar WP Non Aktif',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup'
							),
							'menu_penerimaan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							),							
					);
	}
	//Perencanaan
	else if ($this->session->userdata("USER_JABATAN") == '24') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan','penetapan' => 'Penetapan', 'bkp' => 'Penerimaan', 'pelaporan' => 'Pembukuan', 'penagihan' => 'Penagihan',);
		
		$sub_menus = array(
							'pendaftaran' => array(
								
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data'
								
							),
							'pendataan' => array(
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								//'penetapan/skpd/view' => 'Lihat SPT yang sudah ditetapkan',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								//'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan'
							),
							'bkp' => array(
								'bkp/rekapitulasi' => 'Cetak Rekapitulasi Penerimaan Harian',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',								
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'
							),
							'penagihan' => array(
								'penagihan/kartu_data_wp' => 'Kartu Data WP',
								'penagihan/tunggakan' => 'Daftar Tunggakan WP',
								//'penagihan/kartu_data_wp' => 'Grafik Kartu Data WP'
								//'sub_menu_menu_penagihan' => 'Penagihan'
							),
							'pelaporan' => array(
								'sub_menu_menu_penerimaan' => 'Pembukuan Penerimaan',
								'sub_menu_menu_pelaporan' => 'Pembukuan Pelaporan'
							)						
					);
					
		$sub_sub_menus = array(							
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr_baru' => 'Cetak Daftar Induk WP Baru',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup',
								'pendaftaran/dokumentasi_pengolahan/daftar_perkembangan_wpwr' => 'Cetak Daftar Perkembangan WP'
							),
							'menu_penerimaan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							),							
							'menu_pelaporan' => array(
								'pembukuan/pendapatan_pajak_daerah' => 'Cetak Laporan Pajak Daerah',
								'pembukuan/pendapatan_daerah' => '* Cetak Laporan Pendapatan Daerah',
								'pembukuan/rekap_pendapatan_daerah' => '** Cetak Rekap Pendapatan Daerah'		
							)					
					);
	}

   //Pemeriksaan
	else if ($this->session->userdata("USER_JABATAN") == '26') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 'penetapan' => 'Penetapan', 'bkp' => 'Penerimaan', 'pelaporan' => 'Pembukuan', 'penagihan' => 'Penagihan',);
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data',

							),
							'pendataan' => array(
							     'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								//'penetapan/skpd/view' => 'Lihat SPT yang sudah ditetapkan',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								//'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
							),
							'bkp' => array(
								'bkp/rekapitulasi' => 'Cetak Rekapitulasi Penerimaan Harian',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',								
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'
							),
							'penagihan' => array(
								//'penagihan/kartu_data_wp' => 'Kartu Data WP',
								'penagihan/tunggakan' => 'Daftar Tunggakan WP',
								'penagihan/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
								//'sub_menu_menu_penagihan' => 'Penagihan'
							),
							
							'pelaporan' => array(
								'sub_menu_menu_penerimaan' => 'Pembukuan Penerimaan',
								'sub_menu_menu_pelaporan' => 'Pembukuan Pelaporan'
							)						
					);
					
		$sub_sub_menus = array(							
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_nonaktif' => 'Cetak Daftar WP Non Aktif',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup'
							),
							'menu_penerimaan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							),							
							'menu_pelaporan' => array(
								'pembukuan/pendapatan_pajak_daerah' => 'Cetak Laporan Pajak Daerah',
								'pembukuan/pendapatan_daerah' => '* Cetak Laporan Pendapatan Daerah',
								'pembukuan/rekap_pendapatan_daerah' => '** Cetak Rekap Pendapatan Daerah'		
							)						
					);
	}

	//Pengembangan
	else if ($this->session->userdata("USER_JABATAN") == '27') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 'bkp' => 'Penerimaan', 'pelaporan' => 'Pembukuan', 'penagihan' => 'Penagihan',);
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data',

							),
							'pendataan' => array(
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data',
							),
							'bkp' => array(
								'bkp/rekapitulasi' => 'Cetak Rekapitulasi Penerimaan Harian',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',								
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'
							),
							'penagihan' => array(
								//'penagihan/kartu_data_wp' => 'Kartu Data WP',
								//'penagihan/tunggakan' => 'Daftar Tunggakan WP',
								'penagihan/kartu_data_wp' => 'Grafik Kartu Data WP'
								//'sub_menu_menu_penagihan' => 'Penagihan'
							),
							
							'pelaporan' => array(
								'sub_menu_menu_penerimaan' => 'Pembukuan Penerimaan'
								//'sub_menu_menu_pelaporan' => 'Pembukuan Pelaporan'
							)				
					);
					
		$sub_sub_menus = array(							
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup'
							),
							'menu_penerimaan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							)							
							/**'menu_pelaporan' => array(
								'pembukuan/pendapatan_pajak_daerah' => 'Cetak Laporan Pajak Daerah',
								'pembukuan/pendapatan_daerah' => '* Cetak Laporan Pendapatan Daerah',
								'pembukuan/rekap_pendapatan_daerah' => '** Cetak Rekap Pendapatan Daerah'		
							)		**/				
					);
	}
	
	//penagihan
	elseif ($this->session->userdata('USER_JABATAN') == "28") {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan','penetapan' => 'Penetapan', 'penagihan' => 'Penagihan', 'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								//'pendaftaran/wp_badan_usaha' => 'Rekam Master WP Badan Usaha',
								//'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data',
								//'pendaftaran/penutupan_wpwr' => 'Penutupan WP/WR',
							),
							'pendataan' => array(
								//'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								//'penetapan/skpd/view' => 'Lihat SPT yang sudah ditetapkan',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								//'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan'
							),
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran Pembayaran',
								//'penagihan/surat_tegurann' => 'Cetak Surat Teguran Pembayaran di bawah satu juta',
								'penagihan/kartu_data_wp' => 'Kartu Data WP',
								'penagihan/tunggakan' => 'Daftar Tunggakan WP',
								'penagihan/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
								//'sub_menu_menu_penagihan' => 'Penagihan'
							),
							
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'						
							)				
					);
					
		$sub_sub_menus = array(
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_nonaktif' => 'Cetak Daftar WP Non Aktif',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup'
							),
							'menu_penerimaan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							),							
					);
	}
	
	//Operator Air Bawah Tanah pedanil
	else if ($this->session->userdata("USER_JABATAN") == '29') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 'penetapan' => 'Penetapan',
						'pembukuan' => 'Pembukuan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								//'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								//'penetapan/skpd/view' => 'Lihat SPT yang sudah ditetapkan',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								//'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan'
							),
							'pendataan' => array(
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data',
							),
							'pembukuan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi'						
							)
					);
					
	} 
	//Pembukuan
	else if ($this->session->userdata("USER_JABATAN") == '30') {
		$menus = array('pendaftaran' => 'Master WP','bkp' => 'Penerimaan', 'pelaporan' => 'Pembukuan', 'penagihan' => 'Penagihan',);
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data',
							),
							'bkp' => array(
								'bkp/rekapitulasi' => 'Cetak Rekapitulasi Penerimaan Harian',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',								
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'
							),
							'penagihan' => array(
								'penagihan/kartu_data_wp' => 'Kartu Data WP',
								'penagihan/tunggakan' => 'Daftar Tunggakan WP',
								//'penagihan/cetak_daftar_stpd' => 'Cetak Daftar STPD'
								//'sub_menu_menu_penagihan' => 'Penagihan'
							),
							
							'pelaporan' => array(
								'sub_menu_menu_penerimaan' => 'Pembukuan Penerimaan',
								'sub_menu_menu_pelaporan' => 'Pembukuan Pelaporan'
							)						
					);
					
		$sub_sub_menus = array(							
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup'
							),
							'menu_penerimaan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							),							
							'menu_pelaporan' => array(
								'pembukuan/pendapatan_pajak_daerah' => 'Cetak Laporan Pajak Daerah',
								'pembukuan/pendapatan_daerah' => '* Cetak Laporan Pendapatan Daerah',
								'pembukuan/rekap_pendapatan_daerah' => '** Cetak Rekap Pendapatan Daerah'		
							)						
					);
	}
	//Operator Data Entry Mamin
	else if ($this->session->userdata("USER_JABATAN") == '44') {
		$menus = array('pendataan' => 'Pendataan', 'bkp' => 'BKP');
		
		$sub_menus = array(
							
							'pendataan' => array(
								//'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'pendataan/pajak_restoran/add_katering' => 'Rekam Data Objek Pajak Restoran'
								//'pendataan/pajak_restoran/view' => 'Lihat Daftar SPT Restoran',
								//'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								//'pendataan/kartu_data/pajak_restoran' => 'Cetak Kartu Data'
							),
							
							'bkp' => array(
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak SSPD'
							),
											
					);
	}


 //Pemeriksaan KPK/BPK
	else if ($this->session->userdata("USER_JABATAN") == '45') {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 'penetapan' => 'Penetapan','bkp' => 'BKP', 'pelaporan' => 'Pembukuan', 'penagihan' => 'Penagihan', );
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data',

							),
							'pendataan' => array(
							     'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								//'penetapan/skpd/view' => 'Lihat SPT yang sudah ditetapkan',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								//'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
							),
							'bkp' => array(
								'bkp/rekam_pajak/setor_pajak' => 'Rekam Setoran Pajak',
								//'bkp/setoran_dinas' => 'Rekam Setoran Retribusi',
								//'bkp/rekam_pajak/proses_setoran' => 'Rekam Penerimaan Pajak',
								//'bkp/rekam_pajak/cetak_sspd' => 'Cetak Surat Setoran Pajak Daerah (SSPD)',
								//'bkp/setor_bank' => 'Cetak Surat Tanda Setoran(STS)',
								'bkp/sts' => 'Daftar Surat Tanda Setoran',						
								'' => '',
								//'bkp/rekapitulasi' => 'Cetak Rekapitulasi Penerimaan Harian',
								//'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',								
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'
								//'bkp/laporan_penerimaan' => 'Cetak Laporan Pertanggungjawaban Penerimaan',
								//'sub_menu_kasir' => 'Petugas Loker/Kasir Penerima',
								//'sub_menu_bendahara' => 'Bendahara Penerima'
							),
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran',
								//'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
							),
								
							'pelaporan' => array(
								'sub_menu_menu_penerimaan' => 'Pembukuan Penerimaan',
								//'sub_menu_menu_pelaporan' => 'Pembukuan Pelaporan'
							)		
							
					);
					
		$sub_sub_menus = array(							
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr_baru' => 'Cetak Daftar Induk WP Baru',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_nonaktif' => 'Cetak Daftar WP Non Aktif',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_nonaktif' => 'Cetak Daftar WP Non Aktif',
								'pendaftaran/dokumentasi_pengolahan/daftar_perkembangan_wpwr' => 'Cetak Daftar Perkembangan WP'
							),
							'menu_penerimaan' => array(
								//'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'
							)		
					);
	}
	
	//Pejabat
	else if ($this->session->userdata('USER_JABATAN') == '100') {
		$menus = array('pendaftaran' => 'Pendaftaran', 'pendataan' => 'Pendataan', 
						'penetapan' => 'Penetapan', 'bkp' => 'BKP', 'pelaporan' => 'Pembukuan', 'penagihan' => 'Penagihan');
		
		$sub_menus = array('pendaftaran' => array(
								'pendaftaran/wp_pribadi' => 'Rekam Master WP Pribadi', 
								'pendaftaran/wp_badan_usaha' => 'Rekam Master WP Badan Usaha',
								'pendaftaran/calon_wp' => 'Rekam Calon WP',
								'pendaftaran/rekam_formulir' => 'Rekam Formulir Pendaftaran',
								'pendaftaran/cetak_daftar_formulir' => 'Cetak Daftar Formulir Pendaftaran',
								'pendaftaran/cetak_kartu_npwpd' => 'Cetak Kartu NPWPD',
								'sub_menu_dokumentasi' => 'Dokumentasi dan Pengolahan Data',
								'pendaftaran/penonaktifan_wpwr' => 'Penonaktifan WP/WR',
								'pendaftaran/penutupan_wpwr' => 'Penutupan WP/WR',
								'pendaftaran/pembukaan_kembali_wpwr' => 'Pembukuan Kembali WP/WR'
							),
							'pendataan' => array(
								'popup_pendataan/objek_pajak/popup_jenis_pajak' => 'Rekam Data Objek Pajak',
								'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								'' => '',
								//'pendataan/sptpd' => 'Cetak SPTPD',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data',
								'pendataan/kartu_data/daftar' => 'Cetak Daftar Kartu Data'
								//'pendataan/surat_teguran/daftar' => 'Daftar Surat Teguran'
							),
							'penetapan' => array(
								'penetapan/skpd' => 'Proses Penetapan Pajak',
								'penetapan/lhp' => 'Proses Penetapan LHP',
								'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan'
							),
							'bkp' => array(
								'bkp/rekam_pajak/setor_pajak' => 'Rekam Setoran Pajak',
								'bkp/setoran_dinas' => 'Rekam Setoran Retribusi',
								//'bkp/rekam_pajak/proses_setoran' => 'Rekam Penerimaan Pajak',
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak Surat Setoran Pajak Daerah (SSPD)',
								'bkp/setor_bank' => 'Cetak Surat Tanda Setoran(STS)',
								'bkp/sts' => 'Daftar Surat Tanda Setoran',						
								'' => '',
								'bkp/rekapitulasi' => 'Cetak Rekapitulasi Penerimaan Harian',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',								
								'bkp/laporan_penerimaan' => 'Cetak Laporan Penerimaan'
								//'bkp/laporan_penerimaan' => 'Cetak Laporan Pertanggungjawaban Penerimaan',
								//'sub_menu_kasir' => 'Petugas Loker/Kasir Penerima',
								//'sub_menu_bendahara' => 'Bendahara Penerima'
							),
							'pemeliharaan' => array(
								'sub_menu_menu_master' => 'Menu Master', 
								'sub_menu_menu_reklame' => 'Menu Reklame',
								//'pemeliharaan/backup_data' => 'Backup Data SPT',								
								//'pemeliharaan/restore_data' => 'Restore Data SPT',
								//'pemeliharaan/backup_data_wp' => 'Backup Wajib Pajak (WP)'
								//'dsp_form_op_multi' => 'Rekam Object Pajak Multi',
								//'pemeliharaan/dsp_form_import_wpwr_data' => 'Import WP/WR Data',
								//'pemeliharaan/dsp_form_import_kec_kel_data' => 'Import Kecamatan & Kelurahan Data'
							),							
							'pelaporan' => array(
								'sub_menu_menu_penerimaan' => 'Pembukuan Penerimaan',
								'sub_menu_menu_pelaporan' => 'Pembukuan Pelaporan'
							),			
							'penagihan' => array(
								'penagihan/surat_teguran' => 'Cetak Surat Teguran Pembayaran',
								'penagihan/surat_teguran_laporan' => 'Cetak Surat Teguran Laporan',
								'penagihan/stpd/add' => 'Rekam STPD',
								'penagihan/stpd_pelaporan/add' => 'Rekam STPD Pelaporan',
								'penagihan/stpd/cetak_stpd' => 'Cetak STPD',
								// 'penagihan/stpd/cetak_stpd_pelaporan' => 'Cetak STPD Pelaporan',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan',
								'penagihan/kartu_data_wp' => 'Grafik Kartu Data WP',
								'penagihan/tunggakan' => 'Daftar Tunggakan WP'
								//'sub_menu_menu_penagihan' => 'Penagihan'
							),							
					);
					
		$sub_sub_menus = array(
							'dokumentasi' => array(
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr_baru' => 'Cetak Daftar Induk WP Baru',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_tutup' => 'Cetak Daftar WP Tutup',
								'pendaftaran/dokumentasi_pengolahan/daftar_wpwr_nonaktif' => 'Cetak Daftar WP Non Aktif',
								'pendaftaran/dokumentasi_pengolahan/daftar_perkembangan_wpwr' => 'Cetak Daftar Perkembangan WP'
							),
							'kasir' => array(
								'bkp/rekam_pajak' => 'Rekam Penerimaan Pajak',
								'' => '',
								'bkp/bpps' => 'Cetak Buku Pembantu Penerimaan Sejenis (BPPS)',
								'bkp/rekap_setoran' => 'Cetak Rekapitulasi Daftar Ketetapan dan Setoran'
							),
							'bendahara' => array(
								'bkp/setor_bank' => 'Rekam Penyetoran ke Bank',
								'bkp/sts' => 'Cetak STS (Surat Setoran ke Bank)',
								'bkp/laporan_penerimaan' => 'Cetak Laporan Pertanggungjawaban Penerimaan & Penyetoran Uang',
								'bkp/kas_umum' => 'Cetak Buku Kas Umum',
								'bkp/jurnal_keluar_kas' => 'Cetak Buku Jurnal Keluar Kas',
								'bkp/realisasi_penerimaan' => 'Cetak Laporan Realisasi Penerimaan Pajak Daerah',
								'bkp/realisasi_setoran' => '++ Realisasi Penerimaan Setoran Harian Pajak Daerah'
							),
							'menu_penerimaan' => array(
								'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'								
							),							
							'menu_pelaporan' => array(
								'pembukuan/pendapatan_pajak_daerah' => 'Cetak Laporan Pajak Daerah',
								'pembukuan/pendapatan_daerah' => '* Cetak Laporan Pendapatan Daerah',
								'pembukuan/rekap_pendapatan_daerah' => '** Cetak Rekap Pendapatan Daerah'								
							),
							'menu_penagihan' => array(
								'penagihan/dsp_form_cetak_buku_kendali' => 'Cetak Buku Kendali (Official Assesment)',
								'penagihan/dsp_form_cetak_buku_kendali&jepem=1' => 'Cetak Buku Kendali (Self Assesment)',
								'penagihan/dsp_form_cetak_surat_teguran' => 'Cetak Surat Teguran per NPWPD'
							),							
					);
		
	}

	//operator pemberi ketetapan reklame
	else if ($this->session->userdata("USER_JABATAN") == '48') {
		$menus = array('penetapan' => 'Penetapan', 'pendataan' => 'Pendataan',);
		
		$sub_menus = array(
							'pendataan' => array(
								//'pendataan/hasil_pemeriksaan' => 'Rekam Laporan Hasil Pemeriksaan (LHP)',
								//'pendataan/pajak_reklame/add' => 'Rekam Data Objek Pajak Reklame',
								'pendataan/pajak_reklame/view' => 'Lihat Daftar SPT Pajak Reklame',
								//'pendataan/kartu_data/pajak_reklame' => 'Cetak Kartu Data',
								//'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD'
							),
							'penetapan' => array(
								//'penetapan/skpd' => 'Proses Penetapan Pajak',
								//'penetapan/skpd/view' => 'Lihat SPT yang sudah ditetapkan',
								'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								'penetapan/surat_ketetapan' => 'Cetak Surat Ketetapan',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
							)
								
							
					);
					
		
	}

	//Operator UPTD
	else if (
		($this->session->userdata('USER_JABATAN') == '31') || ($this->session->userdata('USER_JABATAN') == '32') || ($this->session->userdata('USER_JABATAN') == '33') ||
		($this->session->userdata('USER_JABATAN') == '34') || ($this->session->userdata('USER_JABATAN') == '35') || ($this->session->userdata('USER_JABATAN') == '36') ||
		($this->session->userdata('USER_JABATAN') == '37') || ($this->session->userdata('USER_JABATAN') == '38') || ($this->session->userdata('USER_JABATAN') == '39') ||
		($this->session->userdata('USER_JABATAN') == '40') || ($this->session->userdata('USER_JABATAN') == '41') || ($this->session->userdata('USER_JABATAN') == '42')
	) {
		$menus = array('pendaftaran' => 'Master WP', 'pendataan' => 'Pendataan', 'penetapan' => 'Penetapan',
						'bkp' => 'BKP', 'pembukuan' => 'Pembukuan','penagihan' => 'Penagihan', 'pemeliharaan' => 'Pemeliharaan');
		
		$sub_menus = array(
							'pendaftaran' => array(
								'pendaftaran/master_wp' => 'Data Wajib Pajak',
								'pendaftaran/calon_wp' => 'Rekam Calon WP',
								'pendaftaran/dokumentasi_pengolahan/daftar_induk_wpwr' => 'Cetak Daftar Induk WP'
							),
							'pendataan' => array(
								'popup_pendataan/objek_pajak/popup_jenis_pajak' => 'Rekam Data Objek Pajak',
								//'pendataan/sptpd' => 'Cetak SPTPD',
								'pendataan/wp_belum_lapor/daftar' => 'Rekap Wp Belum Lapor',
								'pendataan/sptpd/daftar' => 'Cetak Daftar SPTPD',
								'popup_pendataan/kartu_data/jenis_pajak' => 'Cetak Kartu Data',
								//'pendataan/kartu_data/daftar' => 'Cetak Daftar Kartu Data'
							),
							'penetapan' => array(
								//'penetapan/skpd_reklame' => 'Proses Penerapan Pajak Reklame',
								//'penetapan/nota_perhitungan' => 'Cetak Nota Perhitungan',
								//'penetapan/surat_ketetapan/form_ketetapan_skpd' => 'Cetak SKPD',
								'penetapan/daftar_surat_ketetapan' => 'Cetak Daftar Surat Ketetapan',
								'penetapan/daftar_jam_tayang' => 'Cetak Daftar Habis Jam Tayang'
							),
							'bkp' => array(
								'bkp/rekam_pajak/cetak_sspd' => 'Cetak SSPD'
							),
							'pembukuan' => array(
								//'pembukuan/buku_kendali' => 'Cetak Realisasi & Buku Kendali',
								'pembukuan/daftar_rekapitulasi' => 'Cetak Daftar Rekapitulasi',
								'pembukuan/buku_wp' => 'Cetak Buku Wajib Pajak'						
							),
							'penagihan' => array(
								//'penagihan/kartu_data_wp' => 'Kartu Data WP',
								'penagihan/tunggakan' => 'Daftar Tunggakan WP',
								'penagihan/stpd/cetak_daftar_stpd' => 'Cetak Daftar STPD',
								'penagihan/stpd_pelaporan/cetak_daftar_stpd_pelaporan' => 'Cetak Daftar STPD Pelaporan'
								//'sub_menu_menu_penagihan' => 'Penagihan'
							),
							'pemeliharaan' => array(
								//'pemeliharaan/restore_data_uptd' => 'Restore Data SPT',
								//'pemeliharaan/backup_data_uptd' => 'Backup Data SPT',								
								//'pemeliharaan/restore_data_wp' => 'Restore Wajib Pajak (WP)',
								'pemeliharaan/pejabat' => 'Tabel Pejabat'
							)				
					);		
	}
?>


	<div id="border-top" class="h_green">
		<div>
			<div>
<?php
	$d = date('d');
	$m = date('m');
	$y = date('Y');
	
	$bulan = array(
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
		'11' => 'Nopember',
		'12' => 'Desember'
	);
?>
				<span class="version">Tanggal : <?php echo $d . ' ' . $bulan[$m] . ' ' . $y . '  '; ?></span>
				<span class="title">SIMPATDA - KOTA BEKASI</span>
			</div>
		</div>
	</div>
	<div id="header-box">
		<div id="module-status">
			<span class="loggedin-users"><?= $this->session->userdata('USER_FULL_NAME'); ?> | <?= $this->session->userdata('USER_JABATAN_NAME'); ?></span>
		</div>
		<div id="jmenu" class="jquerycssmenu">
			<ul id="main_menu">
				<li>
					<a id="main/home" href="#" class="node"><img src="assets/images/khepri/menu/icon-16-frontpage.png" alt="Home" title="Home"/></a>
				</li>
				<?php 
				foreach($menus as $key => $menu) {
					echo "<li><a class='node' id='#'>$menu</a>";
						if (count(@$sub_menus[$key]) > 0) {
							echo "<ul>";
							foreach ($sub_menus[$key] as $key_sub => $sub_menu) {
								if (!empty($sub_menu)) {
									if (substr($key_sub, 0, 8) == 'sub_menu') {
										echo '<li><a id="#">'.$sub_menu.'</a>';
										
										if (count(@$sub_sub_menus[substr($key_sub, 9)]) > 0) {
											echo "<ul>";
											
											foreach ($sub_sub_menus[substr($key_sub, 9)] as $key_sub_sub => $sub_sub_menu) {
												if (!empty($sub_sub_menu)) {
													echo "<li><a id='$key_sub_sub' href='#'>$sub_sub_menu</a></li>";
												} else {
													echo '<li class="separator"><span></span></li>';
												}
											}
										
											echo "</ul>";	
										}
									
										echo '</li>';
									} else {
										echo "<li><a id='$key_sub' href='#'>$sub_menu</a></li>";
									}
								} else 
									echo '<li class="separator"><span></span></li>';
							}
							echo "</ul>";
						}
					echo '</li>';
				}
				?>
				<li><a class="node" id="main/change_password" href="#">Ganti Password</a></li>
				<li><a class="node" id="#" href="logout" >Logout</a></li>
			</ul>
		</div>
		<div class="clr"></div>
	</div>