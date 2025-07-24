<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-print">
			CETAK MEDIA PENETAPAN
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
		<form method="post" name="frm_surat_ketetapan">
			<table class="adminlist">
				<thead>
					<tr>
						<th width="20">#</th>		
						<th class="title">Pilihan</th>
					</tr>
				</thead>
				
				<tbody id="tbl_menu">
				<?php
				$menus = array(
						'penetapan/surat_ketetapan/form_ketetapan_skpd' => "Cetak Media Ketetapan SKPD",
						'penetapan/surat_ketetapan/form_ketetapan_skpdkb' => "Cetak Media Ketetapan SKPD Kurang Bayar (SKPDKB)",
						'penetapan/surat_ketetapan/form_ketetapan_skpdt' => "Cetak Media Ketetapan SKPD Tambahan/SKPD Jabatan",
						'penetapan/surat_ketetapan/form_ketetapan_skpdn' => "Cetak Media Ketetapan SKPD Nihil",
						'penetapan/surat_ketetapan/form_ketetapan_skpdlb' => "Cetak Media Ketetapan SKPD Lebih Bayar",
						'penetapan/surat_ketetapan/form_ketetapan_skpkbt' => "Cetak Media Ketetapan SKPD Kurang Bayar Tambahan"				
					);
						
				$counter = 1;
				foreach ($menus as $key => $value) {
				?>				
					<tr class="row0">
						<td width="30">
							<?= $counter; ?>
						</td>
						<td>
							<a id="<?= $key; ?>" href="#"><?= $value; ?></a>
						</td>
					</tr>
				<?php
				$counter++;
				}
				?>
				</tbody>

				<tfoot>
					<tr>
						<td colspan="8">
							<del class="container"><div class="pagination">
							<div class="limit"></div>
								<input type="hidden" name="limitstart" value="0" />
							</div>
							</del>				
						</td>
					</tr>
				</tfoot>
			</table>
		</form>
	</div>
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<script type="text/javascript" src="modules/penetapan/scripts/view_surat_ketetapan.js"></script>