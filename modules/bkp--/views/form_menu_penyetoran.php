<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="header icon-48-menulist">
			Menu Penyetoran
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
		<form method="post" name="frm_menu_penyetoran">
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
								'bkp/rekam_pajak/cetak_sspd' => "Cetak Surat Setoran Pajak Daerah (SSPD)",
								'bkp/rekam_pajak/setor_pajak' => "Rekam Penerimaan Pajak/Retribusi Daerah",
								'bkp/rekam_pajak/setor_dinas' => "Entry Setoran dari Dinas-Dinas/Lain-lain",
								'bkp/rekam_pajak/batal_setoran' => "Pembatalan Setoran"							
							);
					
					$counter = 1;
					foreach ($menus as $key => $value) {
				?>				
					<tr class="row0">
						<td width="30">
							<?= $counter; ?>
						</td>
						<td>
							<a id="<?= $key;?>" href="#"><?= $value; ?></a>
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

<script type="text/javascript" src="modules/bkp/scripts/form_menu_penyetoran.js"></script>