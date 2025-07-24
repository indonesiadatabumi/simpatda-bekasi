<table class="admintable" border=0 cellspacing="1" width="100%">
	<tr>
		<td style="width: 70px; font-weight: bold; color: #274F0A;background-color: #FAFFF4;">
			NPWPD
		</td>
		<td align="left">
			<input type="hidden" name="wp_id" value="<?= $row['wp_wr_id']; ?>">
			<input type="text" name="npwprd" id="npwprd" class="inputbox" size="30" maxlength="20" readonly="true" value="<?= $row['npwprd']; ?>"/>
		</td>
	</tr>
	
	<tr>
		<td style="width: 70px; font-weight: bold; color: #274F0A;background-color: #FAFFF4;">
			Nama
		</td>
		<td align="left">
			<input type="text" name="wp_wr_nama" id="wp_wr_nama" class="inputbox" size="80" readonly="true" value="<?= $row['wp_wr_nama']; ?>"/>
	</tr>
	<tr>
		<td style="width: 70px; font-weight: bold; color: #274F0A; background-color: #FAFFF4;">
			Alamat
		</td>
		<td align="left">
			<input type="text" name="wp_wr_almt" id="wp_wr_almt" value="<?= $row['wp_wr_almt']." KEL. ".$row['wp_wr_lurah']." KEC. ".$row['wp_wr_camat']; ?>" class="inputbox" size="130" maxlength="50" readonly="true" />
	</tr>
	<tr>
		<td style="width: 70px; font-weight: bold; color: #274F0A; background-color: #FAFFF4;">Periode SPT</td>
		<td align="left">
			<form id="frm_data_spt" action="#">
			<input type="text" name="spt_periode" id="spt_periode" class="inputbox" size="4" maxlength="4" value="<?= date('Y'); ?>"/> &nbsp;
			<input type="button" name="btn_cari" id="btn_cari" class="button" value="Cari"> &nbsp;
			<!-- <input type="button" name="btn_cetak" id="btn_cetak" class="button" value="Cetak"> -->
			</form>
		</td>
	</tr>
</table>

<br/><br/>

<img id="grafik" />

<script type="text/javascript" src="<?=base_url();?>modules/penagihan/scripts/kartu_data_detail.js"></script>