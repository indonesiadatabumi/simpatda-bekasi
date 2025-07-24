<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar" id="top">
				<tr>					
					<td class="button" id="toolbar-add">
						<a href="#" class="toolbar" id="btn_update">
							<span class="icon-32-save" title="Update"></span>
							Simpan
						</a>
					</td>
					
					<td class="button" id="toolbar-cancel">
						<a href="#" class="toolbar" id="btn_close_edit">
							<span class="icon-32-close" title="Tutup"></span>Tutup
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="header icon-48-master">
			Kode Rekening : <small><small id='title_head'>[ Edit ]</small></small>
		</div>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<div class="clr"></div>
				
<div id="element-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>
	
	<div class="m">
		<div class="col">
			<form id="frm_edit_kode_rekening" name="frm_edit_kode_rekening">
				<input type="hidden" name="korek_id" value="<?= $row->korek_id; ?>">
				<table class="admintable">
					<tr>
						<td class="key">Kode Rekening</td>
						<td>
							Tipe: <input type="text" name="korek_tipe" id="korek_tipe" value="<?= $row->korek_tipe; ?>" class="inputbox" size="1" maxlength="1"/> &nbsp;
							Kelompok: <input type="text" name="korek_kelompok" id="korek_kelompok" value="<?= $row->korek_kelompok; ?>" class="inputbox" size="1" maxlength="1"/> &nbsp;
							Jenis: <input type="text" name="korek_jenis" id="korek_jenis" value="<?= $row->korek_jenis; ?>" class="inputbox" size="1" maxlength="1" /> &nbsp;
							Objek: <input type="text" name="korek_objek" id="korek_objek" value="<?= $row->korek_objek; ?>" class="inputbox" size="2" maxlength="2" /> &nbsp;
							Rincian: <input type="text" name="korek_rincian" id="korek_rincian" value="<?= $row->korek_rincian; ?>" class="inputbox" size="2" maxlength="2" /> &nbsp;							
						</td>
					</tr>
					<tr>
						<td class="key">Sub</td>
						<td>
							1: <input type="text" name="korek_sub1" id="korek_sub1" value="<?= $row->korek_sub1; ?>" class="inputbox" size="2" maxlength="2" /> &nbsp;
							2: <input type="text" name="korek_sub2" id="korek_sub2" value="<?= $row->korek_sub2; ?>" class="inputbox" size="2" maxlength="2" /> &nbsp;
							3: <input type="text" name="korek_sub3" id="korek_sub3" value="<?= $row->korek_sub3; ?>" class="inputbox" size="2" maxlength="2" /> &nbsp;
						</td>
					</tr>
					<tr>
						<td class="key">Nama Rekening</td>
						<td>
							<input type="text" name="korek_nama" id="korek_nama" value="<?= $row->korek_nama; ?>" class="inputbox mandatory" maxlength="200" size="50" />
						</td>
					</tr>
					<tr>
						<td class="key">Kategori Rekening</td>
						<td>
							<?php 
								$attributes = 'id="korek_kategori" class="inputbox"';
								echo form_dropdown('korek_kategori', $kategori, $row->korek_kategori, $attributes);
							?>
						</td>
					</tr>
					<tr>
						<td class="key">% Tarif</td>
						<td>
							<input type="text" name="korek_persen_tarif" id="korek_persen_tarif" value="<?= $row->korek_persen_tarif; ?>" class="inputbox mandatory" size="10" maxlength="200" />
						</td>
					</tr>
					<tr>
						<td class="key">Tarif dasar</td>
						<td>
							<input type="text" name="korek_tarif_dsr" id="korek_tarif_dsr" value="<?= (real) $row->korek_tarif_dsr; ?>" class="inputbox" size="10" maxlength="200" />
						</td>
					</tr>
					<tr>
						<td class="key">Volume dasar</td>
						<td>
							<input type="text" name="korek_vol_dsr" id="korek_vol_dsr" value="<?= $row->korek_vol_dsr; ?>" class="inputbox" size="10" maxlength="200" />
						</td>
					</tr>
					<tr>
						<td class="key">Tarif Tambahan</td>
						<td>
							<input type="text" name="korek_tarif_tambah" id="korek_tarif_tambah" value="<?= $row->korek_tarif_tambah; ?>" class="inputbox" size="10" maxlength="200" />
						</td>
					</tr>
					<tr>
						<td class="key">Nomor Perda</td>
						<td>
							<?php 
								$attributes = 'id="korek_id_hukum" class="inputbox"';
								echo form_dropdown('korek_id_hukum', $perda, $row->korek_id_hukum, $attributes);
							?>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div class="clr"></div>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>

		</div>
	</div>
</div>
<script type="text/javascript" src="modules/pemeliharaan/scripts/edit_kode_rekening.js"></script>
	