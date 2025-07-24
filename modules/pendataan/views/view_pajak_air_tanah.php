<div id="toolbar-box">
	<div class="t">
		<div class="t"><div class="t"></div></div>
	</div>

	<div class="m">
		<div class="toolbar" id="toolbar">
			<table class="toolbar">
				<tr>
					<td class="button" id="toolbar-new">
						<a href="#" class="toolbar" id="btn_add">
							<span class="icon-32-new" title="Baru"></span>Baru
						</a>
					</td>
					
					<td class="button" id="toolbar-edit">
						<a href="#" class="toolbar" id="btn_edit">
							<span class="icon-32-edit" title="Edit"></span>Edit
						</a>
					</td>
					<?php 
						if(($this->session->userdata('USER_SPT_CODE') == "10")) {
					?>
					<td class="button" id="toolbar-delete">
						<a href="#" class="toolbar" id="btn_delete">
							<span class="icon-32-delete" title="Hapus"></span>
							Hapus
						</a>
					</td>
					<?php 
						}
					?>
				</tr>
			</table>
		</div>
		<div class="header icon-48-user">
			Tabel Isian SKPD Pajak Air Tanah
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
		<table id="pajak_air_table" style="display:none"></table>
		<input type="hidden" name="id" value="" />
		<input type="hidden" name="spt_jenis_pajakretribusi" value="<?= $this->config->item('jenis_pajak_air_bawah_tanah'); ?>" />
		<div class="clr"></div>
	</div>
	
	<div class="b">
		<div class="b">
			<div class="b"></div>
		</div>
	</div>
</div>

<div id="confirmation_delete" title="Konfirmasi" style="display: none;">
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
		Apakah anda yakin untuk menghapus ?
	</p>
</div>

<script type="text/javascript">
	var GLOBAL_PAJAK_AIR_VARS = new Array ();
	GLOBAL_PAJAK_AIR_VARS["get_list"] = "<?=base_url();?>pendataan/pajak_air_bawah_tanah/get_list";
	GLOBAL_PAJAK_AIR_VARS["add_sptpd"] = "<?=base_url();?>pendataan/pajak_air_bawah_tanah/add";
	GLOBAL_PAJAK_AIR_VARS["edit_sptpd"] = "pendataan/pajak_air_bawah_tanah/edit";
</script>
<script type="text/javascript" src="modules/pendataan/scripts/view_pajak_air_bawah_tanah.js"></script>